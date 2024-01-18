<?php

namespace App\Http\Controllers\API\Admin\Wallet;

use App\Http\Controllers\ApiController;

use App\Models\PaymentAccount;

use  App\Http\Resources\Common\Wallets\PaymentAccountResource;
use  App\Http\Resources\Common\Wallets\PaymentAccountsCollection;


class PaymentAccountController extends ApiController
{

    public function index()
    {
        $paymentAccounts = PaymentAccount::paginate(20);
        return new PaymentAccountsCollection($paymentAccounts);
    }
    public function show($id)
    {
        $paymentAccount = PaymentAccount::find($id);
        return $this->respondWithItem(new PaymentAccountResource($paymentAccount) );

    }





}
