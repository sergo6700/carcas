<?php

namespace Api\Services;

use Api\Filters\RoomTypeFilter;
use Api\Jobs\Rates\SaveHistory;
use Api\Repositories\Criterias\Core\OrWhereInCriteria;
use Api\Repositories\Criterias\Core\RelationCriteria;
use Api\Repositories\Criterias\Core\SelectCriteria;
use Api\Repositories\Criterias\Core\WhereCriteria;
use Api\Repositories\Criterias\Core\WhereInCriteria;
use Api\Repositories\DerivationRuleRepository;
use Api\Repositories\RateRepository;
use Api\Repositories\ReservationRepository;
use Api\Repositories\RoomTypeRepository;
use Api\Transformers\RoomTypeTransformer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Class RoomTypesService
 * @package Api\Services
 */
class RoomTypesService extends BaseApiService
{
    /**
     * @var UnitsService
     */
    protected $unitService;

    /**
     * @var RateRepository
     */
    protected $rateRepository;

    /**
     * @var ReservationRepository
     */
    protected $reservationRepository;

    /**
     * @var DerivationRuleRepository
     */
    protected $derivationRuleRepository;

    /**
     * RoomTypesService constructor.
     * @param RoomTypeFilter $filter
     * @param RoomTypeRepository $repository
     * @param RoomTypeTransformer $transformer
     * @param RateRepository $rateRepository
     * @param ReservationRepository $reservationRepository
     * @param DerivationRuleRepository $derivationRuleRepository
     * @param UnitsService $unitService
     */
    public function __construct(
        RoomTypeFilter $filter,
        RoomTypeRepository $repository,
        RoomTypeTransformer $transformer,
        RateRepository $rateRepository,
        ReservationRepository $reservationRepository,
        DerivationRuleRepository $derivationRuleRepository,
        UnitsService $unitService
    )
    {
        parent::__construct($filter, $repository, $transformer);

        $this->unitService = $unitService;
        $this->rateRepository = $rateRepository;
        $this->reservationRepository = $reservationRepository;
        $this->derivationRuleRepository = $derivationRuleRepository;
    }

    /**
     * @param $id
     * @param $date
     * @return int
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getAvailability($id, $date)
    {
        $availability = 0;
        $date = carbon($date);

        $relations = [
            'unit_category' => [
                'selects' => [
                    'id'
                ],
                'has' => [
                    [
                        'relation' => 'units'
                    ]
                ],
                'relations' => [
                    'units' => [
                        'selects' => [
                            'id',
                            'unit_category_id',
                        ]
                    ]
                ]
            ]
        ];

        $roomType = $this->repository
            ->resetCriteria()
            ->pushCriteria(new SelectCriteria([
                'id',
                'unit_category_id',
            ]))
            ->pushCriteria(new RelationCriteria($relations))
            ->find($id);

        $roomType = $roomType->toArray();

        $reservationPendingCount = $this->reservationRepository
            ->resetCriteria()
            ->pushCriteria(new WhereCriteria('end_date', $date->toDateString(), '>'))
            ->pushCriteria(new WhereCriteria('start_date', $date->toDateString(), '<='))
            ->pushCriteria(new WhereCriteria('status', \ConstReservationStatuses::PENDING))
            ->pushCriteria(new WhereInCriteria('room_type_id', $this->getLinkedIds($roomType['id'])))
            ->count();

        foreach ($roomType['unit_category']['units'] as $unit) {
            $availability = $this->unitService->isAvailable(
                $unit['id'],
                $date->toDateString(),
                (clone $date)->addDay()->toDateString()
            );

            if ($availability) {
                $availability++;
            }
        }

        return max($availability - $reservationPendingCount, 0);
    }

    /**
     * @param $id
     * @param int $availability
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getLinkedIds($id, $availability = \ConstGeneralStatuses::NO)
    {
        $ids = array_merge(
            $this->getLinkedIdsTopDown($id, $availability),
            $this->getLinkedIdsBottomUp($id, $availability)
        );

        return array_unique($ids);
    }

    /**
     * @param $id
     * @param int $availability
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getLinkedIdsBottomUp($id, $availability = \ConstGeneralStatuses::NO)
    {
        $ids = [
            $id
        ];

        $this->derivationRuleRepository
            ->resetCriteria()
            ->pushCriteria(new SelectCriteria([
                'parent_id'
            ]))
            ->pushCriteria(new WhereCriteria('room_type_id', $id));

        if ($availability === \ConstGeneralStatuses::YES) {
            $this->derivationRuleRepository->pushCriteria(new WhereCriteria('availability', $availability));
        }

        $rules = $this->derivationRuleRepository->get()->toArray();

        if (!empty($rules)) {
            foreach ($rules as $rule) {
                if (in_array($rule['parent_id'], $ids)) {
                    continue;
                }

                $parentIds = $this->getLinkedIdsBottomUp($rule['parent_id'], $availability);
                $ids = array_merge($ids, $parentIds);
            }
        }

        return $ids;
    }

    /**
     * @param $id
     * @param int $availability
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getLinkedIdsTopDown($id, $availability = \ConstGeneralStatuses::NO)
    {
        $ids = [
            $id
        ];

        $this->derivationRuleRepository
            ->resetCriteria()
            ->pushCriteria(new SelectCriteria([
                'room_type_id'
            ]))
            ->pushCriteria(new WhereCriteria('parent_id', $id));

        if ($availability === \ConstGeneralStatuses::YES) {
            $this->derivationRuleRepository->pushCriteria(new WhereCriteria('availability', $availability));
        }

        $rules = $this->derivationRuleRepository->get()->toArray();

        if (!empty($rules)) {
            foreach ($rules as $rule) {
                if (in_array($rule['room_type_id'], $ids)) {
                    continue;
                }

                $childIds = $this->getLinkedIdsTopDown($rule['room_type_id'], $availability);
                $ids = array_merge($ids, $childIds);
            }
        }

        return $ids;
    }

    /**
     * @param $id
     * @param $startDate
     * @param $endDate
     * @param array $changes
     * @return array
     * @throws \Exception
     */
    public function processDerivations($id, $startDate, $endDate, $changes = [])
    {
        $result = [];

        $endDate = carbon($endDate);
        $startDate = carbon($startDate);

        DB::beginTransaction();

        try {
            $ids = $this->getLinkedIdsTopDown($id);

            $roomTypes = $this->repository
                ->resetCriteria()
                ->pushCriteria(new SelectCriteria([
                    'id',
                    'min_price',
                    'min_stay',
                    'max_stay',
                ]))
                ->pushCriteria(new WhereInCriteria('id', $ids))
                ->get();

            $rules = $this->derivationRuleRepository
                ->resetCriteria()
                ->pushCriteria(new SelectCriteria([
                    'id',
                    'room_type_id',
                    'parent_id',
                    'amount',
                    'amount_status',
                    'availability',
                    'restrictions',
                    'stop_sell',
                ]))
                ->pushCriteria(new WhereInCriteria('parent_id', $ids))
                ->pushCriteria(new OrWhereInCriteria('room_type_id', $ids))
                ->get();

            foreach ($ids as $id) {
                $rates = $this->rateRepository
                    ->resetCriteria()
                    ->pushCriteria(new SelectCriteria([
                        'id',
                        'room_type_id',
                        'date',
                        'amount',
                        'availability',
                        'min_stay',
                        'max_stay',
                        'cta',
                        'ctd',
                        'stop_sell',
                        'cut_off',
                    ]))
                    ->pushCriteria(new WhereInCriteria('room_type_id', $ids))
                    ->pushCriteria(new WhereCriteria('date', $endDate->toDateString(), '<='))
                    ->pushCriteria(new WhereCriteria('date', $startDate->toDateString(), '>='))
                    ->get();

                $date = clone $startDate;

                do {
                    $roomType = $roomTypes->firstWhere('id', $id);

                    $rule = $rules->filter(function ($rule) use ($id) {
                        return $rule->room_type_id === $id;
                    })->first();

                    if (empty($rule)) {
                        continue;
                    }

                    $rate = $rates->filter(function ($rate) use ($date, $id) {
                        return $rate->room_type_id === $id && $date->toDateString() === $rate->date;
                    })->first();

                    $parentRate = $rates->filter(function ($rate) use ($date, $rule) {
                        return $rate->room_type_id === $rule->parent_id && $date->toDateString() === $rate->date;
                    })->first();

                    if (empty($parentRate)) {
                        continue;
                    }

                    if (empty($rate)) {
                        $result[] = $this->processNotExistingRateDerivation($rule, $parentRate, $roomType);
                    } else {
                        $result[] = $this->processExistingRateDerivation($rate, $rule, $parentRate, $roomType, $changes);
                    }
                } while ($endDate->greaterThanOrEqualTo($date->addDay()));
            }

            DB::commit();

            return $result;

        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param $rate
     * @param $rule
     * @param $parentRate
     * @param $roomType
     * @param array $changes
     * @return mixed|null
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    protected function processExistingRateDerivation($rate, $rule, $parentRate, $roomType, $changes = [])
    {
        $data = [];

        if (Arr::get($changes, 'cut_off')) {
            $data['cut_off'] = $parentRate->cut_off;
        }
        if (Arr::get($changes, 'availability')) {
            $parentAvailability = $parentRate->availability;
            $data['availability'] = $rule->availability ? $parentAvailability : $rate->availability;
        }
        if (Arr::get($changes, 'stop_sell')) {
            $parentStopSell = $parentRate->stop_sell;
            $data['stop_sell'] = $rule->stop_sell ? $parentStopSell : $rate->stop_sell;
        }
        if (Arr::get($changes, 'cta')) {
            $parentCta = $parentRate->cta === \ConstGeneralStatuses::NO ? config('rate-calendar.defaults.cta') : $parentRate->cta;
            $data['cta'] = $rule->restrictions ? $parentCta : $rate->cta;
        }
        if (Arr::get($changes, 'ctd')) {
            $parentCtd = $parentRate->ctd === \ConstGeneralStatuses::NO ? config('rate-calendar.defaults.ctd') : $parentRate->ctd;
            $data['ctd'] = $rule->restrictions ? $parentCtd : $rate->ctd;
        }
        if (Arr::get($changes, 'max_stay')) {
            $parentMaxStay = $parentRate->max_stay === 0 ? $roomType->max_stay : $parentRate->max_stay;
            $data['max_stay'] = $rule->length_of_stay ? $parentMaxStay : $rate->max_stay;
        }
        if (Arr::get($changes, 'min_stay')) {
            $parentMinStay = $parentRate->min_stay === 0 ? $roomType->min_stay : $parentRate->min_stay;
            $data['min_stay'] = $rule->length_of_stay ? $parentMinStay : $rate->min_stay;
        }

        if (Arr::get($changes, 'stop_sell') === \ConstGeneralStatuses::YES) {
            $data['stop_sell'] = \ConstGeneralStatuses::YES;
            $data['amount'] = config('rate-calendar.defaults.max_price');
        } elseif (!$parentRate->stop_sell && !Arr::get($changes, 'stop_sell') && Arr::get($changes, 'amount')) {
            if (\ConstDerivationRules::UNLINKED === $rule->amount_status) {
                $data['amount'] = $rate->amount;
            }
            elseif (\ConstDerivationRules::PERCENTAGE === $rule->amount_status) {
                if ($rule->is_round === \ConstGeneralStatuses::YES) {
                    $data['amount'] = round($parentRate->amount + ($parentRate->amount * $rule->amount / 100), 0);
                } else {
                    $data['amount'] = $parentRate->amount + ($parentRate->amount * $rule->amount / 100);
                }
            }
            else {
                if ($rule->is_round === \ConstGeneralStatuses::YES) {
                    $data['amount'] = round($rule->amount + $parentRate->amount, 0);
                } else {
                    $data['amount'] = $rule->amount + $parentRate->amount;
                }
            }
        } else {
            return null;
        }

        if ($roomType->min_price > $data['amount'] && $rule->amount_status != \ConstDerivationRules::UNLINKED) {
            $data['amount'] = $roomType->min_price;
        }

        $result = $this->rateRepository
            ->resetCriteria()
            ->update($data, $rate->id);

        $history = array_merge((array) $rate->toArray(), [
            'modification' => \ConstRateModifications::DERIVATION
        ]);

        dispatch(new SaveHistory($history));

        return $result;
    }

    /**
     * @param $rule
     * @param $parentRate
     * @param $roomType
     * @return mixed|null
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    protected function processNotExistingRateDerivation($rule, $parentRate, $roomType)
    {
        $data = [];

        if ($parentRate->stop_sell) {
            $data['amount'] = config('rate-calendar.defaults.max_price');
        }
        elseif (\ConstDerivationRules::PERCENTAGE === $rule->amount_status) {
            if ($rule->is_round === \ConstGeneralStatuses::YES) {
                $data['amount'] = round($parentRate->amount + ($parentRate->amount * $rule->amount / 100), 0);
            } else {
                $data['amount'] = $parentRate->amount + ($parentRate->amount * $rule->amount / 100);
            }
        }
        elseif (\ConstDerivationRules::CURRENCY === $rule->amount_status) {
            if ($rule->is_round === \ConstGeneralStatuses::YES) {
                $data['amount'] = round($rule->amount + $parentRate->amount, 0);
            } else {
                $data['amount'] = $rule->amount + $parentRate->amount;
            }
        }
        else {
            return null;
        }

        if ($roomType->min_price > $data['amount']) {
            $data['amount'] = $roomType->min_price;
        }

        if ($rule->availability !== \ConstGeneralStatuses::YES) {
            $data['availability'] = $this->getAvailability($roomType->id, $parentRate->date);
        } else {
            $data['availability'] = $parentRate->availability;
        }

        $data['date'] = $parentRate->date;
        $data['cut_off'] = $parentRate->cut_off;
        $data['stop_sell'] = $parentRate->stop_sell;
        $data['room_type_id'] = $rule->room_type_id;
        $data['cta'] = $rule->restrictions ? $parentRate->cta : config('rate-calendar.defaults.cta');
        $data['ctd'] = $rule->restrictions ? $parentRate->ctd : config('rate-calendar.defaults.ctd');
        $data['max_stay'] = $rule->length_of_stay ? $parentRate->max_stay : $roomType->max_stay;
        $data['min_stay'] = $rule->length_of_stay ? $parentRate->min_stay : $roomType->min_stay;

        $result = $this->rateRepository
            ->resetCriteria()
            ->create($data);

        $history = array_merge((array) $data, [
            'modification' => \ConstRateModifications::DERIVATION
        ]);

        dispatch(new SaveHistory($history));

        return $result;
    }
}
