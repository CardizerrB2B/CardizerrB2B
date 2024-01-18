<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAccount extends Model
{
    use HasFactory;
    
    protected $fillable =['user_id','bank_name','account_number','IBAN','account_ownerName','status','verified','verified_date'];

    
    public function users()
    {
        return $this->hasMany(User::class,'id','user_id');
    }

}
