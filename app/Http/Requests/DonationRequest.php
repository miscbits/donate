<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonationRequest extends FormRequest
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
         'first_name' => 'required|string',
          'last_name' => 'required|string',
              'email' => 'required|email',
              'phone' => 'required|digits:10|min:0',
           'address1' => 'required|string',
           'address2' => 'string|nullable',
               'city' => 'required|string',
                'zip' => 'required|digits:5|min:0',
             'amount' => 'required|integer|min:0',
              'terms' => 'required|accepted',
            'twitter' => 'string|nullable',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required',
            'email.*' => 'A valid email is required',
            'phone.*' => 'A valid phone number is required',
            'address1.required' => 'A valid Address is required',
            'city.required' => 'A valid city is required',
            'zip.*' => 'A valid zip code is required',
            'amount.integer' => 'The Donation Amount should not contain any special characters. ($/-+=)',
            'terms.required' => 'Please confirm you are an American citizen over the age of 18 by checking the box. This is required by U.S. law',
        ];
    }

}
