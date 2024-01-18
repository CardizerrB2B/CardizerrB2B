<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','payment_account_id','wallet_detail_id','type','status','amount'];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
