<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PayRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // general info
            'totalAmount'     => ['required', 'numeric'],
            'currency'        => ['required', 'string', 'max:3'],
            'emiOption'       => ['numeric', Rule::in([1, 0])],
            // customer info
            'cusName'         => ['required', 'string', 'max:50'],
            'cusEmail'        => ['required', 'string', 'max:50'],
            'cusAddress'      => ['required', 'string', 'max:50'],
            'cusCity'         => ['required', 'string', 'max:50'],
            'cusPostCode'     => ['required', 'string', 'max:30'],
            'cusCountry'      => ['required', 'string', 'max:50'],
            'cusPhone'        => ['required', 'string', 'max:20'],
            // shipping info
            'shippingMethod'  => ['required', 'string', 'max:50', Rule::in(['YES', 'NO', 'Courier'])],
            'numOfItems'      => ['required', 'integer'],
            // product info
            'productName'     => ['required', 'string', 'max:255'],
            'productCategory' => ['required', 'string', 'max:100'],
            'productProfile'  => ['required', 'string', 'max:100'],
        ];
    }
}
