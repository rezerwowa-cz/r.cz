<?php

namespace App\Http\Requests;

use App\Rules\TimetableAvailable;
use Illuminate\Foundation\Http\FormRequest;

class OrderFormRequest extends FormRequest
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
     * @noinspection PhpParamsInspection
     */
    public function rules()
    {
        return [
            'date' => ['required', 'date_format:d-m-Y', new TimetableAvailable($this->route('service'), $this->input('time'))],
            'time' => ['required', 'date_format:H:i'],
        ];
    }
}
