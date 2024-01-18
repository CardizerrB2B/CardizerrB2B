<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletDetail extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','payment_account_id','balance','status'];
    
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class,'id','wallet_detail_id');
    }
}
