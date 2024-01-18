<?php

namespace App\Http\Controllers\API\Common\Wallet;

use App\Http\Controllers\ApiController;

use App\Models\PaymentAccount;
use App\Models\PaymentTransaction;


use App\Http\Requests\Common\Wallets\StoreNewPaymentAccountRequest;

use App\Http\Requests\Common\Wallets\RemovalPaymentAccountRequest;

use  App\Http\Resources\Common\Wallets\PaymentAccountResource;




class PaymentAccountController extends ApiController
{
    public function show()
    {
        $myPaymentAccount = PaymentAccount::where('user_id',auth()->user()->id)->first();

        return $this->respondWithItem(new PaymentAccountResource($myPaymentAccount) );

    }

    public function store(StoreNewPaymentAccountRequest $request)
    {
        PaymentAccount::create([
            'user_id'=>auth()->user()->id,
            'bank_name'=> $request->bank_name,
            'account_number'=> $request->account_number,
            'IBAN'=> $request->IBAN,
            'account_ownerName'=> $request->account_ownerName,
            
        ]);

        return $this->successStatus((__('msg.successStatus'))); 
    }

    public function removal()
    {
        $myPaymentAccount = PaymentAccount::where('user_id',auth()->user()->id)->first();

        $myPaymentAccount->update([
            'status' => 'removal',
            'isRemoval'=>1
        ]);

        return $this->respondWithMessage(__('msg.update'));
    }



    public function makePaymentTransaction($user_id ,$payment_account_id ,$payment_type, $amount , $payment_transfer )
    {
        ### payment transaction will be checked and approved by admin 
        // should be pyamnet attachment per every withdrow 

       $paymentTransaction= PaymentTransaction::create([
            'user_id'=>$user_id,
            'payment_account_id'=>$payment_account_id,
            'type'=>$payment_type,
            'amount'=>$amount,

        ]);

        if ($payment_transfer) {

            storeMedia($payment_transfer, 'paymentTransactions', $paymentTransaction->id, 'App\Models\PaymentTransaction');
            
        }

        return true ;

    }

}
