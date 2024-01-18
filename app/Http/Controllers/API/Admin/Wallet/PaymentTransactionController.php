<?php

namespace App\Http\Controllers\API\Admin\Wallet;

use App\Http\Controllers\ApiController;
use App\Models\PaymentTransaction;
use App\Models\WalletTransaction;
use App\Models\WalletDetail;

use App\Http\Requests\Common\Wallets\SearchRequest;
use App\Http\Requests\Common\Wallets\VerifyPaymentTransactionRequest;

use App\Http\Resources\Common\Wallets\PaymentTransactionResource;
use App\Http\Resources\Common\Wallets\PaymentTransactionsCollection;
use Illuminate\Support\Facades\DB;

class PaymentTransactionController extends ApiController
{
    public function allPaymentsTransactions()
    {
        $paymentTransactions = PaymentTransaction::paginate(20);
        return new PaymentTransactionsCollection($paymentTransactions);

    }

    public function searchPaymentTransactions( SearchRequest $request)
    {
        $key = $request->key;
        $paymentTransactions = PaymentTransaction::when($key,function($q) use($key){
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
        $paymentTransaction = PaymentTransaction::whereId($id)->first();

        if (!$paymentTransaction) {
            return $this->errorNotFound();
         }

         return $this->respondWithItem(new PaymentTransactionResource($paymentTransaction) );


    }

    public function verifyPaymentTransaction($id,VerifyPaymentTransactionRequest $request)
    {
        try {
            DB::beginTransaction();

            $paymentTransaction = PaymentTransaction::whereId($id)->first();

            $paymentTransaction->update([
                'apporvedRejectedby_id' => 1,
                'status'=>$request->status
            ]);
    
            if($paymentTransaction->status == 'approved')
            {
    
                $walletTransaction = WalletTransaction::where('payment_account_id',$paymentTransaction->payment_account_id)->first();
                $walletTransaction->update([
                    'status'=>'done',
                ]);
                $walletDetail = WalletDetail::where('payment_account_id',$paymentTransaction->payment_account_id)->first();
                $walletDetail->update([
                    'balance'=>$walletDetail->balance + $walletTransaction->amount,
                    'status'=>'enabled',
                ]);
    
            }

            DB::commit();

            return $this->successStatus((__('msg.successStatus'))); 
 
    
        } catch (\Exception $exception) {
            DB::rollback();
	
			return $this->errorStatus(__($exception->getMessage()));
        }
      
    }


}
