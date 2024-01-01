<?php

use Illuminate\Support\Facades\DB;

use App\Models\Store;


if (! function_exists('upload')) {
    function upload($file, $path)
    {
       $baseDir = 'uploads/' . $path;
      
       $name = sha1(time() . $file->getClientOriginalName());
       $extension = $file->getClientOriginalExtension();
       $fileName = "{$name}.{$extension}";

       $file->move(public_path() . '/' . $baseDir, $fileName);

       
       return $fileName;
    }
}


if (!function_exists('storeMedia')) {
    function storeMedia($path,$file, $id ,$model)
    {
        DB::table('madias')->insert(
            [
                'file' => upload($path, $file),
                'mediable_id' => $id,
                'mediable_type' => $model
            ]
        );
    }
}



if (!function_exists('updateMedia')) {
    function updateMedia($file,$path, $id )
    {
        DB::table('madias')->where('mediable_id', $id)->update(
            [
                'file' => upload($file, $path),

            ]
        );
    }
}


if(!function_exists('getStoreID')){

    function getStoreID ($owner_id)
    {
        return Store::where('owner_id',$owner_id)->first()->id;
    }
}