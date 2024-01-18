<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;
    protected $fillable =['user_id','apporvedRejectedby_id','payment_account_id','type','status','rejected_note','amount'];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function paymentTransfer()
    {
        return $this->hasOne(Madia::class,'mediable_id','id');
    }

    protected $appends=['image_path'];

    public function getPaymentTransferPathAttribute()
    {
        if($this->paymentTransfer)
        {
            return asset('uploads/paymentTransactions/'.$this->paymentTransfer->file);
        }
        
    }

}
