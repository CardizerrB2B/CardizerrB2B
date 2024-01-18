<?php

namespace App\Http\Requests\Common\Wallets;

use App\Http\Requests\APIRequest;

class VerifyPaymentAccountAndNewWalletRequest extends APIRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount'=>'required|numeric',
            'payment_transfer' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048'

        ];
    }
}
