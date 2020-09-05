<?php

namespace Api\Services;

use Api\Filters\ReservationCalendarFilter;
use Api\Repositories\Criterias\Core\HasCriteria;
use Api\Repositories\PropertyRepository;
use Api\Repositories\ReservationRepository;
use Api\Transformers\ReservationCalendar\DataTransformer;
use Illuminate\Support\Arr;

/**
 * Class ReservationCalendarService
 * @package Api\Services
 */
class ReservationCalendarService extends BaseApiService
{
    /**
     * ReservationCalendarService constructor.
     * @param ReservationCalendarFilter $filter
     * @param ReservationRepository $repository
     * @param DataTransformer $transformer
     */
    public function __construct(
        ReservationCalendarFilter $filter,
        ReservationRepository $repository,
        DataTransformer $transformer
    )
    {
        parent::__construct($filter, $repository, $transformer);
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function data($data = [])
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
                        'relation' => 'units',
                    ]
                ],
                'relations' => [
                    'units' => [
                        'order' => 'asc',
                        'sortBy' => 'name',
                        'selects' => [
                            'id',
                            'name',
                            'property_id',
                            'unit_category_id',
                        ],
                        'relations' => [
                            'reservations' => [
                                'selects' => [
                                    'id',
                                    'client_id',
                                    'property_id',
                                    'unit_id',
                                    'start_date',
                                    'end_date',
                                    'amount',
                                    'source',
                                ],
                                'relations' => [
                                    'client' => [
                                        'selects' => [
                                            'id',
                                            'name'
                                        ]
                                    ]
                                ],
                                'where' => !Arr::get($data, 'date') ? [] : [
                                    [
                                        'field' => 'start_date',
                                        'operation' => '<',
                                        'value' => carbon($data['date'])->addDays($data['days'])->toDateString(),
                                    ],
                                    [
                                        'field' => 'end_date',
                                        'operation' => '>',
                                        'value' => carbon($data['date'])->toDateString(),
                                    ],
                                    [
                                        'field' => 'status',
                                        'operation' => '<>',
                                        'value' => \ConstReservationStatuses::CANCELED,
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
}
