<?php

namespace App\Http\Controllers\API\Admin\Products;

use App\Http\Controllers\ApiController;

use App\Models\MasterFile;

use App\Http\Requests\Admins\Products\SearchRequest;
use App\Http\Requests\Admins\Products\StoreMasterFileRequest;
use App\Http\Requests\Admins\Products\UpdateMasterFileRequest;
use App\Http\Requests\Admins\Products\DeleteRequest;

use App\Http\Resources\Admins\Products\MasterFileResource;
use App\Http\Resources\Admins\Products\MasterFileCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class MasterFileController extends ApiController
{
    public function index()
    {
        $products = MasterFile::paginate(20);

        return new MasterFileCollection($products);

    }

    public function search(SearchRequest $request)
    {
        $key = $request->key;
    //     $product = MasterFile::find(1) ;
    //    // dd($product);
    //     $product->subCategory;
    //     dd($product->subCategory);

        $products = MasterFile::when($key,function($q) use($key){
                              $q->where(function($q) use($key){
                                    $q->where('id','like','%'.$key.'%')
                                        ->orWhere('item_code','like','%'.$key.'%')
                                        ->orWhere('description','like','%'.$key.'%')
                                        ->orWhere('retail_price','like','%'.$key.'%')
                                        ->orWhere(function($q) use($key){
                                            $q->whereHas('subCategory',function($q) use($key){
                                                $q->where('name','like','%'.$key.'%');
                                            });
                                        }) ;
                              });
                          })
                        ->paginate(20);

                        
        return new MasterFileCollection($products);

    }

    public function show($id)
    {
        $product = MasterFile::find($id);
        if (empty($product)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new MasterFileResource($product) );

    }

    public function store(StoreMasterFileRequest $request)
    {
           $product= MasterFile::create([
                'sub_category_id'=>$request->sub_category_id,
                'item_code'=>$request->item_code,
                'description'=>$request->description,
                'retail_price'=>$request->retail_price,
                'createdBy_id'=>Auth::user()->id

            ]);

            if ($request->hasFile('image')) {
                storeMedia($request->image, 'masterFiles', $product->id, 'App\Models\MasterFile');
            }

    
            return $this->successStatus((__('msg.successStatus')));
        

    }

    public function update($id,UpdateMasterFileRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $product = MasterFile::find($id);
            if (empty($product)) {
                        return $this->errorStatus(__('msg.errorNotFound'));
                    }
            $product->update([
                'description'=>$request->description,
                'retail_price'=>$request->retail_price,
                'lastEditBy_id'=>Auth::user()->id
            ]);

            
            if ($request->hasFile('image')) {

                if($product->image)
                {
                    updateMedia($request->image, 'masterFiles', $product->id);
                }else{
                    storeMedia($request->image, 'masterFiles', $product->id, 'App\Models\MasterFile');
                }
                
            }
            
            return $this->respondWithItem(new MasterFileResource($product) );

        }


    }

    public function destroy($id, DeleteRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $product = MasterFile::withTrashed()->whereId($id)->first();
                if ($product->trashed()) {
                    // The record is soft deleted
                    return $this->errorStatus(__('msg.theRecordAlreadyDeleted'));
                }
            $product->delete();
            return $this->respondWithMessage(__('msg.deleted'));

        }

    }
}
