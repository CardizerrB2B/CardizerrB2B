<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name'];

    public function image()
    {
        return $this->hasOne(Madia::class,'mediable_id','id');
    }


    
    protected $appends=['image_path'];

    public function getImagePathAttribute()
    {

        if($this->image)
        {
            return asset('uploads/categories/'.$this->image->file);
        }
        
    }

}
