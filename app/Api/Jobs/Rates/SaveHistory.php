<?php

namespace Api\Jobs\Rates;

use Api\Jobs\BaseApiJob;
use Api\Repositories\RateHistoryRepository;

/**
 * Class SaveHistory
 * @package Api\Jobs\Rates
 */
class SaveHistory extends BaseApiJob
{
    /**
     * @var array
     */
    protected $data;

    /**
     * SaveHistory constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param RateHistoryRepository $rateHistoryRepository
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function handle(RateHistoryRepository $rateHistoryRepository)
    {
        $rateHistoryRepository
            ->resetCriteria()
            ->create($this->data);
    }
}
