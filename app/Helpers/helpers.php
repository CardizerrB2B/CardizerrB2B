<?php

use Illuminate\Support\Facades\DB;


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