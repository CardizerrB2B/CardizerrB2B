<?php

namespace App\Http\Requests\Common\Wallets;

use App\Http\Requests\APIRequest;


class RemovalPaymentAccountRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status'=>'required|string|in:removal'
        ];
    }
}
