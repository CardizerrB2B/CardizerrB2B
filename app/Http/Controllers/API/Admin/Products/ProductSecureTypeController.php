<?php

namespace App\Http\Controllers\API\Admin\Products;
use App\Http\Controllers\ApiController;

use App\Models\ProductSecureType;

use App\Http\Requests\Admins\Products\SearchRequest;
use App\Http\Requests\Admins\Products\StoreProductSecureTypeRequest;
use App\Http\Requests\Admins\Products\UpdateProductSecureTypeRequest;
use App\Http\Requests\Admins\Products\DeleteRequest;

use App\Http\Resources\Admins\Products\ProductSecureTypeResource;
use App\Http\Resources\Admins\Products\ProductSecureTypeCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function store(StoreProductSecureTypeRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            ProductSecureType::create([
                'name'=>$request->name
            ]);
    
            return $this->successStatus((__('msg.successStatus')));
        }


    }

    public function update($id,UpdateProductSecureTypeRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $productSecureType = ProductSecureType::find($id);
            if (empty($productSecureType)) {
                        return $this->errorStatus(__('msg.errorNotFound'));
                    }
            $productSecureType->update([
                'name'=> $request->name
            ]);
            
            return $this->respondWithItem(new ProductSecureTypeResource($productSecureType) );

        }

    }

    public function destroy($id, DeleteRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $productSecureType = ProductSecureType::withTrashed()->whereId($id)->first();
                if ($productSecureType->trashed()) {
                    // The record is soft deleted
                    return $this->errorStatus(__('msg.theRecordAlreadyDeleted'));
                }
            $productSecureType->delete();
            return $this->respondWithMessage(__('msg.deleted'));

        }

    }
}
