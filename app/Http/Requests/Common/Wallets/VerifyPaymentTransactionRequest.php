<?php

namespace App\Http\Requests\Common\Wallets;

use App\Http\Requests\APIRequest;

class VerifyPaymentTransactionRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            'status'=>'required|string|in:approved,rejected',
            'rejected_note'=>'nullable|string'
        ];
    }
}
