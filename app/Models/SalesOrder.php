<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = ['distributor_id','marchent_id','store_id','VAT','total','status','is_invoiced','is_credit','finished'];

}
