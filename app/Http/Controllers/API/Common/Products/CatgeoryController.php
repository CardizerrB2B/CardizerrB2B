<?php

namespace App\Http\Controllers\API\Common\Products;

use App\Http\Controllers\ApiController;

use App\Models\Category;

use App\Http\Requests\Common\Products\SearchRequest;

use App\Http\Resources\Common\Products\CategoryResource;
use App\Http\Resources\Common\Products\CategoryCollection;


class CatgeoryController extends ApiController
{
    public function index()
    {
        $categories = Category::all();

        return new CategoryCollection($categories);
    }

    public function search(SearchRequest $request)
    {
        $key = $request->key;

        $categories = Category::when($key , function($q) use($key) {
                                    $q->where('name','like','%'.$key.'%');
                                  })->get();

        return new CategoryCollection($categories);

    }

    public function show($id)
    {
      $category = Category::find($id);
        if (empty($category)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new CategoryResource($category) );
    }


}
