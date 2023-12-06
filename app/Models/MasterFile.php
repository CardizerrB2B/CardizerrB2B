<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterFile extends Model
{
    use HasFactory;
    protected $dates = ['deleted_at'];

    protected $fillable = ['item_code','description','retail_price','is_active','createdBy_id','lastEditBy_id','sub_category_id'];
}
