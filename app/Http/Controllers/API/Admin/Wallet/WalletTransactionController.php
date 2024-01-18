<?php

namespace App\Http\Controllers\API\Admin\Wallet;

use App\Http\Controllers\ApiController;
use App\Models\WalletTransaction;

use App\Http\Requests\Common\Wallets\SearchRequest;

use App\Http\Resources\Common\Wallets\WalletTransactionResource;
use App\Http\Resources\Common\Wallets\WalletTransactionsCollection;

class WalletTransactionController extends ApiController
{
    public function allWalletsTransactions()
    {
        $walletsTransactions = WalletTransaction::paginate(20);
        return new WalletTransactionsCollection($walletsTransactions);

    }

    public function searchWalletTransactions( SearchRequest $request)
    {
        $key = $request->key;
        $walletsTransactions = WalletTransaction::when($key,function($q) use($key){
                                                        $q->where(function($q) use($key){
                                                                $q->Where('id','like','%'.$key.'%')
                                                                    ->orWhere('amount','like','%'.$key.'%');
                                                        });
                                                    })
                                                   ->paginate(20);  
        return new WalletTransactionsCollection($walletsTransactions);

    }



    public function showWalletTransaction($id)
    {
        $walletTransaction = WalletTransaction::find($id);

        if (!$walletTransaction) {
            return $this->errorNotFound();
         }

         return $this->respondWithItem(new WalletTransactionResource($walletTransaction) );


    }
}
