<?php

namespace Api\Http\Requests\ReservationCalendar;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReservationCalendarGetRequest
 * @package Api\Http\Requests\RateCalendar
 */
class ReservationCalendarGetRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'date_format:Y-m-d',
            'days' => 'required_with:date|integer'
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
