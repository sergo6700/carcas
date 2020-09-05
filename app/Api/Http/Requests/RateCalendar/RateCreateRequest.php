<?php

namespace Api\Http\Requests\RateCalendar;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RateCreateRequest
 * @package Api\Http\Requests\RateCalendar
 */
class RateCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function rules()
    {
        $priceVariations = get_class_constants_string(\ConstPriceVariation::class);
        $generalStatuses = get_class_constants_string(\ConstGeneralStatuses::class);

        return [
            'weekdays' => 'array',
            'end_date' => 'required|date_format:Y-m-d',
            'start_date' => 'required|date_format:Y-m-d',
            'room_type_id' => 'required|exists:room_types,id',
            'price_variation' => 'in:' . $priceVariations,
            'amount' => 'required_without_all:availability,min_stay,max_stay,cta,ctd,cut_off,skip_derived,stop_sell|numeric',
            'availability' => 'required_without_all:amount,min_stay,max_stay,cta,ctd,cut_off,skip_derived,stop_sell|integer',
            'min_stay' => 'required_without_all:availability,amount,max_stay,cta,ctd,cut_off,skip_derived,stop_sell|integer',
            'max_stay' => 'required_without_all:availability,min_stay,amount,cta,ctd,cut_off,skip_derived,stop_sell|integer',
            'cta' => 'required_without_all:availability,min_stay,max_stay,amount,ctd,cut_off,skip_derived,stop_sell|in:' . $generalStatuses,
            'ctd' => 'required_without_all:availability,min_stay,max_stay,cta,amount,cut_off,skip_derived,stop_sell|in:' . $generalStatuses,
            'cut_off' => 'required_without_all:availability,min_stay,max_stay,cta,ctd,amount,skip_derived,stop_sell|in:' . $generalStatuses,
            'skip_derived' => 'required_without_all:availability,min_stay,max_stay,cta,ctd,cut_off,amount,stop_sell|in:' . $generalStatuses,
            'stop_sell' => 'required_without_all:availability,min_stay,max_stay,cta,ctd,cut_off,skip_derived,amount|in:' . $generalStatuses,
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }
}
