<?php

namespace App\Http\Controllers\API\Common\Wallet;

use App\Http\Controllers\ApiController;
use App\Models\WalletTransaction;

use App\Http\Requests\Common\Wallets\SearchRequest;

use App\Http\Resources\Common\Wallets\WalletTransactionResource;
use App\Http\Resources\Common\Wallets\WalletTransactionsCollection;

class WalletTransactionController extends ApiController
{
    public function getWalletTransactions()
    {
        $walletTransactions = WalletTransaction::where('user_id',auth()->user()->id)->paginate(20);
        return new WalletTransactionsCollection($walletTransactions);

    }

    public function searchWalletTransactions( SearchRequest $request)
    {
        $key = $request->key;
        $walletTransactions = WalletTransaction::where('user_id',auth()->user()->id)->when($key,function($q) use($key){
                                                        $q->where(function($q) use($key){
                                                                $q->Where('id','like','%'.$key.'%')
                                                                    ->orWhere('amount','like','%'.$key.'%');
                                                        });
                                                    })
                                                   ->paginate(20);  
        return new WalletTransactionsCollection($walletTransactions);

    }



    public function showWalletTransaction($id)
    {
        $walletTransaction = WalletTransaction::whereId($id)->where('user_id',auth()->user()->id)->first();

        if (!$walletTransaction) {
            return $this->errorNotFound();
         }

         return $this->respondWithItem(new WalletTransactionResource($walletTransaction) );


    }
}
