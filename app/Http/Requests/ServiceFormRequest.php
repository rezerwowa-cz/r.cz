<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceFormRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'max:256'],
            'description' => ['required', 'min:3', 'max:1024'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', Rule::in(['PLN', 'EUR'])],
            'photos' => ['array', 'image'],
            'address.country' => ['required'],
            'address.zip_code' => ['required'],
            'address.city' => ['required'],
            'address.street' => ['required'],
            'address.house' => ['required'],
            'address.apartment' => ['nullable'],
            'address.telephone' => ['required'],
            'categories' => ['array', 'numeric', 'exists:categories,id'],
            'timetables' => ['array', 'min:1'],
            'timetables.*.day' => ['required', Rule::in(['monday', 'tuesday', 'wednesday', 'thursday', 'friday',])],
            'timetables.*.step' => ['required', 'numeric', 'min:1', 'max:60'],
            'timetables.*.from' => ['required', 'date_format:H:i'],
            'timetables.*.to' => ['required', 'date_format:H:i', 'after:timetables.*.from'],
            'timetables.*.limit' => ['required', 'integer', 'min:1'],
        ];
    }
}
