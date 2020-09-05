<?php

namespace Api\Services;

use Api\Filters\RateCalendarFilter;
use Api\Jobs\Rates\SaveHistory;
use Api\Repositories\Criterias\Core\HasCriteria;
use Api\Repositories\Criterias\Core\SelectCriteria;
use Api\Repositories\Criterias\Core\WhereCriteria;
use Api\Repositories\Criterias\Core\WhereInCriteria;
use Api\Repositories\Criterias\RoomTypes\ParentCriteria;
use Api\Repositories\PropertyRepository;
use Api\Repositories\RateRepository;
use Api\Repositories\RoomTypeRepository;
use Api\Transformers\RateCalendar\ChildrenTransformer;
use Api\Transformers\RateCalendar\DetailedTransformer;
use Api\Transformers\RateCalendar\CompressedTransformer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Class RateCalendarService
 * @package Api\Services
 */
class RateCalendarService extends BaseApiService
{
    /**
     * @var RoomTypesService
     */
    protected $roomTypesService;

    /**
     * RateCalendarService constructor.
     * @param RateCalendarFilter $filter
     * @param RateRepository $repository
     * @param DetailedTransformer $transformer
     * @param RoomTypesService $roomTypesService
     */
    public function __construct(
        RateCalendarFilter $filter,
        RateRepository $repository,
        DetailedTransformer $transformer,
        RoomTypesService $roomTypesService
    )
    {
        parent::__construct($filter, $repository, $transformer);

        $this->roomTypesService = $roomTypesService;
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function detailed($data = [])
    {
        $this->setRepository(PropertyRepository::class);

        $data['_selects'] = [
            'id',
            'name',
        ];

        $data['_relations'] = [
            'unit_categories' => [
                'order' => 'asc',
                'sortBy' => 'name',
                'selects' => [
                    'id',
                    'property_id',
                    'name',
                    'color',
                ],
                'has' => [
                    [
                        'relation' => 'room_types',
                    ]
                ],
                'relations' => [
                    'room_types' => [
                        'order' => 'asc',
                        'sortBy' => 'name',
                        'selects' => [
                            'id',
                            'unit_category_id',
                            'name',
                            'adults',
                            'breakfast',
                            'refundable',
                        ],
                        'relations' => [
                            'rates' => [
                                'selects' => [
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
                                ],
                                'where' => !Arr::get($data, 'date') ? [] : [
                                    [
                                        'field' => 'date',
                                        'operation' => '>=',
                                        'value' => carbon($data['date'])->toDateString(),
                                    ],
                                    [
                                        'field' => 'date',
                                        'operation' => '<=',
                                        'value' => carbon($data['date'])->addDays($data['days'])->toDateString(),
                                    ],
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->repository->pushCriteria(new HasCriteria('unit_categories'));

        return $this->pagination($data);
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function compressed($data = [])
    {
        $this->setRepository(PropertyRepository::class);
        $this->setTransformer(CompressedTransformer::class);

        $data['_selects'] = [
            'id',
            'name',
        ];

        $data['_relations'] = [
            'unit_categories' => [
                'order' => 'asc',
                'sortBy' => 'name',
                'selects' => [
                    'id',
                    'property_id',
                    'name',
                    'color',
                ],
                'has' => [
                    [
                        'relation' => 'room_types',
                        'criterias' => [
                            new ParentCriteria()
                        ],
                    ]
                ],
                'relations' => [
                    'room_types' => [
                        'order' => 'asc',
                        'sortBy' => 'name',
                        'selects' => [
                            'id',
                            'unit_category_id',
                            'name',
                            'adults',
                            'breakfast',
                            'refundable',
                        ],
                        'relations' => [
                            'rates' => [
                                'selects' => [
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
                                ],
                                'where' => !Arr::get($data, 'date') ? [] : [
                                    [
                                        'field' => 'date',
                                        'operation' => '>=',
                                        'value' => carbon($data['date'])->toDateString(),
                                    ],
                                    [
                                        'field' => 'date',
                                        'operation' => '<=',
                                        'value' => carbon($data['date'])->addDays($data['days'])->toDateString(),
                                    ],
                                ],
                            ]
                        ],
                        'criterias' => [
                            new ParentCriteria()
                        ]
                    ]
                ]
            ]
        ];

        $this->repository->pushCriteria(new HasCriteria('unit_categories'));

        return $this->pagination($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return array
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function children($id, $data = [])
    {
        $this->setRepository(RoomTypeRepository::class);
        $this->setTransformer(ChildrenTransformer::class);

        $data['_selects'] = [
            'id',
            'unit_category_id',
            'name',
            'adults',
            'breakfast',
            'refundable',
        ];

        $data['_relations'] = [
            'rates' => [
                'selects' => [
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
                ],
                'where' => !Arr::get($data, 'date') ? [] : [
                    [
                        'field' => 'date',
                        'operation' => '>=',
                        'value' => carbon($data['date'])->toDateString(),
                    ],
                    [
                        'field' => 'date',
                        'operation' => '<=',
                        'value' => carbon($data['date'])->addDays($data['days'])->toDateString(),
                    ],
                ],
            ]
        ];

        $ids = $this->roomTypesService->getLinkedIdsTopDown($id);

        unset($ids[0]);

        $this->repository->pushCriteria(new WhereInCriteria('id', $ids));

        return $this->collection($data);
    }

    /**
     * @param array $data
     * @return array|mixed
     * @throws \Exception
     */
    public function create(array $data)
    {
        $result = [];

        $defaults = config('rate-calendar.defaults');

        $endDate = carbon($data['end_date']);
        $startDate = carbon($data['start_date']);

        $rateData = [
            'end_date' => $endDate->toDateString(),
            'start_date' => $startDate->toDateString(),
            'room_type_id' => $data['room_type_id'],
        ];

        if (Arr::get($data, 'stop_sell') === \ConstGeneralStatuses::YES) {
            $variation = \ConstPriceVariation::EXACT;
            $coefficient = config('rate-calendar.defaults.max_price');
        } else {
            $variation = Arr::get($data, 'price_variation');
            $coefficient = Arr::get($data, 'amount');
        }

        DB::beginTransaction();

        try {
            $rates = $this->repository
                ->resetCriteria()
                ->pushCriteria(new SelectCriteria([
                    'id',
                    'date',
                    'amount'
                ]))
                ->pushCriteria(new WhereCriteria('room_type_id', $data['room_type_id']))
                ->pushCriteria(new WhereCriteria('date', $endDate->toDateString(), '<='))
                ->pushCriteria(new WhereCriteria('date', $startDate->toDateString(), '>='))
                ->get();

            $date = clone $startDate;

            do {
                if (Arr::get($data, 'weekdays')) {
                    if (!in_array($date->dayOfWeek, $data['weekdays'])) {
                        continue;
                    }
                }

                $rate = $rates->firstWhere('date', $date->toDateString());
                $amount = $rate ? $rate->amount : null;

                if (empty($rate)) {
                    $rateData['cta'] = intval($data['cta'] ?? $defaults['cta']);
                    $rateData['ctd'] = intval($data['cta'] ?? $defaults['cta']);
                    $rateData['cut_off'] = intval($data['cut_off'] ?? $defaults['cut_off']);
                    $rateData['min_stay'] = intval($data['min_stay'] ?? $defaults['min_stay']);
                    $rateData['max_stay'] = intval($data['max_stay'] ?? $defaults['max_stay']);
                    $rateData['stop_sell'] = intval($data['stop_sell'] ?? $defaults['stop_sell']);
                    $rateData['availability'] = Arr::get($data, 'availability');
                } else {
                    if (isset($data['cta'])) {
                        $rateData['cta'] = intval($data['cta']);
                    }
                    if (isset($data['ctd'])) {
                        $rateData['ctd'] = intval($data['ctd']);
                    }
                    if (isset($data['cut_off'])) {
                        $rateData['cut_off'] = intval($data['cut_off']);
                    }
                    if (isset($data['min_stay'])) {
                        $rateData['min_stay'] = intval($data['min_stay']);
                    }
                    if (isset($data['max_stay'])) {
                        $rateData['max_stay'] = intval($data['max_stay']);
                    }
                    if (isset($data['stop_sell'])) {
                        $rateData['stop_sell'] = intval($data['stop_sell']);
                    }
                    if (isset($data['availability'])) {
                        $rateData['availability'] = intval($data['availability']);
                    }
                }

                if ($amount) {
                    switch ($variation) {
                        case \ConstPriceVariation::INCREMENT:
                            $amount += $coefficient;
                            break;
                        case \ConstPriceVariation::PERCENT:
                            $amount = $amount + ($amount * $coefficient / 100);
                            break;
                        default:
                            $amount = $coefficient ?? $amount;
                            break;
                    }
                } elseif (\ConstPriceVariation::EXACT !== $variation) {
                    $amount = null;
                } else {
                    $amount = $coefficient;
                }

                $rateData['amount'] = $amount;

                if (!isset($data['availability'])) {
                    $rateData['availability'] = $this->roomTypesService->getAvailability(
                        $data['room_type_id'],
                        $date->toDateString()
                    );
                }

                $rate = $this->repository
                    ->resetCriteria()
                    ->updateOrCreate([
                        'date' => $date->toDateString(),
                        'room_type_id' => $data['room_type_id']
                    ], $rateData);

                $result[] = $rate;

                $history = array_merge((array) $rate->toArray(), [
                    'modification' => \ConstRateModifications::RATE_CALENDAR
                ]);

                dispatch(new SaveHistory($history));

            } while ($endDate->greaterThanOrEqualTo($date->addDay()));

            if (Arr::get($data, 'skip_derived') !== \ConstGeneralStatuses::YES) {
                $derived = $this->roomTypesService->processDerivations(
                    $data['room_type_id'],
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                    $rateData
                );

                $result = array_merge($result, $derived);
            }

            DB::commit();

            return $result;

        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
