<?php

namespace App\Http\Requests\Common\Wallets;

use App\Http\Requests\APIRequest;

class StoreNewPaymentAccountRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            'bank_name'=>'required|string',
            'account_number'=>'required|string|min:14|max:14|unique:payment_accounts,account_number',
            'IBAN'=>'nullable|string|min:14|max:14|unique:payment_accounts,IBAN',
            'account_ownerName'=>'required|string',
        ];
    }
}
