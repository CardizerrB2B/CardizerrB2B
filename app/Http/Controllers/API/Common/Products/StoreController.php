<?php

namespace App\Http\Controllers\API\Common\Products;

use App\Http\Controllers\ApiController;
use App\Models\Store;

use App\Http\Requests\Common\Products\SearchRequest;

use App\Http\Resources\Common\Products\StoreResource;
use App\Http\Resources\Common\Products\StoreCollection;


class StoreController extends ApiController
{
    public function index()
    {
        $stores = Store::paginate(20);

        return new StoreCollection($stores);

    }

    public function search(SearchRequest $request)
    {
        $key = $request->key;
        $stores = Store::when($key,function($q) use($key){
                              $q->where(function($q) use($key){
                                    $q->where('owner_id','like','%'.$key.'%')
                                        ->orWhere('name','like','%'.$key.'%')
                                        ->orWhere(function($q) use($key){
                                            $q->whereHas('distributor',function($q) use($key){
                                                $q->where('username','like','%'.$key.'%')
                                                  ->orWhere('fullname','like','%'.$key.'%');
                                            });
                                        }) ;
                              });
                          })
                        ->paginate(20);

                        
        return new StoreCollection($stores);

    }

    public function show($id)
    {
        $store = Store::find($id);
        if (empty($store)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new StoreResource($store) );

    }




}
