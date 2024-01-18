<?php

namespace App\Http\Requests\Common\Wallets;

use App\Http\Requests\APIRequest;

class MakeWalletTransactionRequest extends APIRequest
{
    
    public function rules(): array
    {
        return [
            'type'=>'required|string|in:deposit,withdraw,pay,transfer',
            'amount'=>'required|numeric|min:300|max:1000',// payment scope between 300 and 1000 
            'payment_transfer' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'

        ];
    }
}
