<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderDetail extends Model
{
    use HasFactory;
    protected $fillable = ['SO_id','store_item_id','master_store_id','item_code','product_secure_type_id','product_secure_type_value','item_price'];

}
