<?php

namespace App\Http\Controllers\API\Common\Wallet;


use App\Http\Controllers\API\Common\Wallet\PaymentAccountController;

use App\Models\WalletDetail;
use App\Models\WalletTransaction;
use App\Models\PaymentAccount;


use  App\Http\Resources\Common\Wallets\WalletAccountResource;
use App\Http\Requests\Common\Wallets\VerifyPaymentAccountAndNewWalletRequest;
use App\Http\Requests\Common\Wallets\MakeWalletTransactionRequest;

use Illuminate\Support\Facades\DB;
use Exception;

use Carbon\Carbon;

class WalletAccountController extends PaymentAccountController
{
 
    public function show()
    {
        $myWalletDetail = WalletDetail::where('user_id',auth()->user()->id)->first();

        if (!$myWalletDetail) {
            return $this->errorNotFound();
         }

        return $this->respondWithItem(new WalletAccountResource($myWalletDetail) );

    }

    public function storeNewWalletAccount($user_id,$payment_account_id)
    {
        $checkWallet = WalletDetail::where('user_id',$user_id)->where('payment_account_id',$payment_account_id)->first();

        if ($checkWallet) {
           return -1 ;
        }

        $wallet_detail = WalletDetail::create([
            'user_id' =>$user_id,
            'payment_account_id' =>$payment_account_id, //linking the payment Account 
        ]);

      return $wallet_detail->id ;  
    }


    public function makeWalletTransactionGeneric($user_id ,$payment_account_id , $wallet_detail_id , $type ,$status, $amount , $attach  )
    {
        $payment_type = $type =='deposit' ? 'withdraw' : 'deposit' ;  // payment type instead of wallet type
        if($this->makePaymentTransaction($user_id ,$payment_account_id ,$payment_type, $amount , $attach ))//check if the payment is created successfully and waiting admin approval
        {
            WalletTransaction::create([//save the transaction on wallet 
                'user_id' =>$user_id,
                'payment_account_id' =>$payment_account_id, 
                'wallet_detail_id' =>$wallet_detail_id,
                'type' =>$type,
                'status'=>$status,
                'amount' =>$amount,
            ]);

            return 1;

        }else{
            return -1;
        }
    
    }

    public function verifyAccount(VerifyPaymentAccountAndNewWalletRequest $request)// as first time 
    {
        ### 
            ## create New Wallet Account and linking the payment Account 
            ## deposit 2$ to make verify process and ensure the payment account is correct , using payment trasnaction model and wallet trasnaction model
            ## if the response is ture , set true values at verify flag into payment account and increase balance into Wallet Account 
        ###

        try{

            DB::beginTransaction();
            // Fetch user-related information
            $user_id = auth()->user()->id;

            $payment_account_id = auth()->user()->paymentAccount->id;
        
            $wallet_detail_id = $this->storeNewWalletAccount($user_id,$payment_account_id);// store new wallet Account and get back the resposnse 

            if($wallet_detail_id == -1)
            {
              throw new Exception(__('msg.walletAlreadyFound'));

            }
            //dd($wallet_detail_id);

            $this->makeWalletTransactionGeneric($user_id ,$payment_account_id , $wallet_detail_id ,'deposit','pending', $request->amount,$request->payment_transfer);

            $paymentAccount = PaymentAccount::find($payment_account_id);
            $paymentAccount->update([
                //'status'=>'enabled', //should be approved as the first by  admin 
                'verified'=>1,
                'verified_date'=>Carbon::now()
            ]);

            // $walletDetail = WalletDetail::find($wallet_detail_id);
            // $walletDetail->update([
            //     'balance'=>$walletDetail->balance + $request->amount,
            //     'status'=>'enabled',
            // ]);

            DB::commit();

            return $this->successStatus((__('msg.successStatus'))); 

        }catch(\Exception $exception){

            DB::rollback();
	
			return $this->errorStatus(__($exception->getMessage()));

        }
    }

    public function checkEnableAccount($payment_status,$wallet_status)
    {
 
       // dd($payment_status == 'enabled' );
        if($payment_status <> 'enabled' || $wallet_status <>'enabled' )
        {
            throw new Exception(__('msg.PaymentOrWalletNotEnable'));

        }
    }
 
    public function makeWalletTransaction(MakeWalletTransactionRequest $request)
    {
        try{
            DB::beginTransaction();

            //check Payment & and wallet accounts status

            $this->checkEnableAccount(auth()->user()->paymentAccount->status ,auth()->user()->walletAccount->status );

            // Fetch user-related information
            $user_id = auth()->user()->id;
            $payment_account_id = auth()->user()->paymentAccount->id;
            $wallet_detail_id = auth()->user()->walletAccount->id;
            // Make wallet transaction
            $makeWalletTransactionGeneric=$this->makeWalletTransactionGeneric($user_id , $payment_account_id , $wallet_detail_id , $request->type , 'pending' , $request->amount,$request->payment_transfer);
            // Handle the result
            if($makeWalletTransactionGeneric == -1 )
            {
                throw new Exception(__('msg.transactionFailed'));

            }
            $walletDetail = WalletDetail::find($wallet_detail_id);
            // Update wallet details
            $walletDetail->update([
                'balance'=> $request->type =='deposit'? $walletDetail->balance + $request->amount : $walletDetail->balance - $request->amount  ,
            ]);
      
            if($walletDetail->balance < 0)
            {
                throw new Exception(__('msg.TheBalanceCannotBeNegative'));

            }

            DB::commit();
            return $this->successStatus((__('msg.successStatus'))); 


        }catch(\Exception $exception)
        {
            DB::rollback();
            return $this->errorStatus(__($exception->getMessage()));
        }
        


    }
    
}
