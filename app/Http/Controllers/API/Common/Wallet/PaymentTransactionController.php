<?php

namespace App\Http\Controllers\API\Common\Wallet;

use App\Http\Controllers\ApiController;
use App\Models\PaymentTransaction;
use App\Http\Requests\Common\Wallets\SearchRequest;

use App\Http\Resources\Common\Wallets\PaymentTransactionResource;
use App\Http\Resources\Common\Wallets\PaymentTransactionsCollection;

class PaymentTransactionController extends ApiController
{
    public function getPaymentTransactions()
    {
        $paymentTransactions = PaymentTransaction::where('user_id',auth()->user()->id)->paginate(20);
        return new PaymentTransactionsCollection($paymentTransactions);

    }

    public function searchPaymentTransactions( SearchRequest $request)
    {
        $key = $request->key;
        $paymentTransactions = PaymentTransaction::where('user_id',auth()->user()->id)->when($key,function($q) use($key){
                                                        $q->where(function($q) use($key){
                                                                $q->Where('id','like','%'.$key.'%')
                                                                    ->orWhere('amount','like','%'.$key.'%');
                                                        });
                                                    })
                                                   ->paginate(20);  
        return new PaymentTransactionsCollection($paymentTransactions);

    }



    public function showPaymentTransaction($id)
    {
        $paymentTransaction = PaymentTransaction::whereId($id)->where('user_id',auth()->user()->id)->first();

        if (!$paymentTransaction) {
            return $this->errorNotFound();
         }

         return $this->respondWithItem(new PaymentTransactionResource($paymentTransaction) );


    }


}
