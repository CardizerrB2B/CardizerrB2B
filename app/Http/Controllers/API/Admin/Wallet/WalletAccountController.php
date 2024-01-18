<?php

namespace App\Http\Controllers\API\Admin\Wallet;

use App\Http\Controllers\ApiController;


use App\Models\WalletDetail;
use App\Models\WalletTransaction;
use App\Models\PaymentAccount;


use  App\Http\Resources\Common\Wallets\WalletAccountResource;

use  App\Http\Resources\Common\Wallets\WalletAccountsCollection;


class WalletAccountController extends ApiController
{
    public function index ()
    {
        $walletDetails = WalletDetail::paginate(20);
        return new WalletAccountsCollection($walletDetails);
    }

    public function show($id)
    {
        $walletDetail = WalletDetail::find($id);

        if (!$walletDetail) {
            return $this->errorNotFound();
         }

        return $this->respondWithItem(new WalletAccountResource($walletDetail) );

    }


 

    
}
