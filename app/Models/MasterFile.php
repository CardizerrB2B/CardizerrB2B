<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MasterFile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['item_code','description','retail_price','is_active','createdBy_id','lastEditBy_id','sub_category_id'];

    public function subCategory()
    {
        $this->hasOne(SubCategory::class,'id','sub_category_id');
    }

    public function image()
    {
        return $this->hasOne(Madia::class,'mediable_id','id');
    }


    
    protected $appends=['image_path'];

    public function getImagePathAttribute()
    {

        if($this->image)
        {
            return asset('uploads/masterFiles/'.$this->image->file);
        }
        
    }
}
