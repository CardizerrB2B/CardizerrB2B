<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SubCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];


    protected $fillable = ['category_id','name'];

    // protected static function boot() {
    //     parent::boot();

    //     static::addGlobalScope('exclude_deleted', function (Builder $builder) {
    //         $builder->whereNull('deleted_at');
    //     });
    // }

    public function category()
    {
        return $this->hasOne(Category::class,'id','category_id');
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
            return asset('uploads/subCategories/'.$this->image->file);
        }
        
    }

}
