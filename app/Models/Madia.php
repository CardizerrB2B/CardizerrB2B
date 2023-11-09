<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Madia extends Model
{
    use HasFactory;

    protected $fillable =['file','mediable_id','mediable_type'];
}
