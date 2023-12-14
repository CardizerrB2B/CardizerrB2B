<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Store extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['name','owner_id','createdBy_id','lastEditBy_id'];


    public function distributor()
    {
        return $this->hasOne(User::class,'id','owner_id');
    }

}
