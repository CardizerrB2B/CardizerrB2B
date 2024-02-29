<?php

namespace App\Http\Controllers\API\Common\Products;

use App\Http\Controllers\ApiController;

use App\Models\SubCategory;

use App\Http\Requests\Common\Products\SearchRequest;


use App\Http\Resources\Common\Products\SubCategoryResource;
use App\Http\Resources\Common\Products\SubCategoryCollection;


class SubCategoryController extends ApiController
{
    public function index()
    {
        $subCategories = SubCategory::all();

        return new SubCategoryCollection($subCategories);
    }
    public function getByCategoryID($category_id)
    {
        $subCategories = SubCategory::where('category_id',$category_id)->paginate(20);

        return new SubCategoryCollection($subCategories);
    }

    public function search(SearchRequest $request)
    {
        $key = $request->key;

        $subCategories = SubCategory::when($key , function($q) use($key) {
                                    $q->where('name','like','%'.$key.'%');
                                  })->get();

        return new SubCategoryCollection($subCategories);

    }

    public function show($id)
    {
      $subCategory = SubCategory::find($id);
        if (empty($subCategory)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new SubCategoryResource($subCategory) );
    }


}
