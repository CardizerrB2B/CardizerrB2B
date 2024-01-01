<?php

namespace App\Http\Controllers\API\Common\Products;
use App\Http\Controllers\ApiController;

use App\Models\ProductSecureType;

use App\Http\Requests\Common\Products\SearchRequest;


use App\Http\Resources\Common\Products\ProductSecureTypeResource;
use App\Http\Resources\Common\Products\ProductSecureTypeCollection;



class ProductSecureTypeController extends ApiController
{
    public function index()
    {
        $productSecureTypes = ProductSecureType::all();

        return new ProductSecureTypeCollection($productSecureTypes);
    }

    public function search(SearchRequest $request)
    {
        $key = $request->key;

        $productSecureTypes = ProductSecureType::when($key , function($q) use($key) {
                                    $q->where('name','like','%'.$key.'%');
                                  })->get();

        return new ProductSecureTypeCollection($productSecureTypes);

    }

    public function show($id)
    {
      $productSecureType = ProductSecureType::find($id);
        if (empty($category)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new ProductSecureTypeResource($productSecureType) );
    }


}
