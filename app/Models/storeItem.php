<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class StoreItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['master_store_id','PO_id','product_secure_type_value','charger_id','isCharger','charger_date','sales_order_id','marchent_id','isSold','sold_date'];

}
