<?php

namespace App\Http\Controllers\API\Admin\Products;

use App\Http\Controllers\ApiController;
use App\Models\Store;

use App\Http\Requests\Admins\Products\SearchRequest;
use App\Http\Requests\Admins\Products\DeleteRequest;

use App\Http\Resources\Admins\Products\StoreResource;
use App\Http\Resources\Admins\Products\StoreCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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


    public function destroy($id, DeleteRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $store = Store::withTrashed()->whereId($id)->first();
                if ($store->trashed()) {
                    // The record is soft deleted
                    return $this->errorStatus(__('msg.theRecordAlreadyDeleted'));
                }
            $store->delete();
            return $this->respondWithMessage(__('msg.deleted'));

        }

    }


}
