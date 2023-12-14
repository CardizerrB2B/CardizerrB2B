<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id','distributor_id','VAT','total','status','is_invoiced','is_credit','finished'];

    public function orderItems()
    {
        return $this->hasMany(PurchaseOrderDetail::class,'PO_id','id');
    }
}
