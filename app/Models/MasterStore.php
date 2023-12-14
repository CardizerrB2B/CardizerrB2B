<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MasterStore extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];


    protected $fillable = ['store_id','sub_category_id','product_secure_type_id','item_id','item_code','description','QTY','last_cost','AVG_cost','stock_cost','retail_price','createdBy_id','lastEditBy_id'];


}
