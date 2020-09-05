<?php

namespace Api\Transformers;

use Api\Models\Reservation;

/**
 * Class ReservationTransformer
 * @package Api\Transformers
 */
class ReservationTransformer extends BaseApiTransformer
{
    /**
     * @param Reservation $item
     * @return array|mixed
     */
    public function transform($item)
    {
        $result = parent::transform($item);

        if ($item->start_date && $item->end_date) {
            $result['nights'] = $this->getNights($item);
        }

        if ($item->source) {
            $result['source'] = $this->getSource($item);
        }

        if ($item->status) {
            $result['status_name'] = $this->getStatusName($item);
        }

        if ($item->amount) {
            $result['amount_formatted'] = $this->getAmountFormatted($item);
        }

        return $result;
    }

    /**
     * @param $item
     * @return string
     */
    public function getSource($item)
    {
        $default = 'images/ota/CiaoBooking.png';
        $dynamic = 'images/ota/'.preg_replace('/\s+/', '', $item->source).'.png';

        return $item->source ? asset($dynamic) : asset($default);
    }

    /**
     * @param $item
     * @return int
     */
    public function getNights($item)
    {
        $endDate = carbon($item->end_date);
        $startDate = carbon($item->start_date);

        return $startDate->diffInDays($endDate);
    }

    /**
     * @param $item
     * @return string
     */
    public function getAmountFormatted($item)
    {
        $currency = $item->currency ? $item->currency : \ConstCurrencies::EUR;

        return strval(money($item->amount*100, ($currency)));
    }

    /**
     * @param $item
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function getStatusName($item)
    {
        return trans('reservation.statuses.' . $item->status);
    }
}
