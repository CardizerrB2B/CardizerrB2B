<?php

namespace App\Http\Controllers\API\Admin\Products;

use App\Http\Controllers\ApiController;

use App\Models\SubCategory;

use App\Http\Requests\Admins\Products\SearchRequest;
use App\Http\Requests\Admins\Products\StoreSubCategoryRequest;
use App\Http\Requests\Admins\Products\UpdateSubCategoryRequest;
use App\Http\Requests\Admins\Products\DeleteRequest;

use App\Http\Resources\Admins\Products\SubCategoryResource;
use App\Http\Resources\Admins\Products\SubCategoryCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SubCategoryController extends ApiController
{
    public function index()
    {
        $subCategories = SubCategory::withTrashed()->get();

        return new SubCategoryCollection($subCategories);
    }

    public function getByCategoryID($category_id)
    {
        $subCategories = SubCategory::withTrashed()->where('category_id',$category_id)->paginate(20);

        return new SubCategoryCollection($subCategories);
    }

    public function search(SearchRequest $request)
    {
        $key = $request->key;

        $subCategories = SubCategory::withTrashed()->when($key , function($q) use($key) {
                                    $q->where('name','like','%'.$key.'%');
                                  })->paginate(20);


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

    public function store(StoreSubCategoryRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
           $subCategory= SubCategory::create([
                'category_id'=>$request->category_id,
                'name'=>$request->name
            ]);

            if ($request->hasFile('image')) {
                storeMedia($request->image, 'subCategories', $subCategory->id, 'App\Models\SubCategory');
            }
    
    
            return $this->successStatus((__('msg.successStatus')));
        }


    }

    public function update($id,UpdateSubCategoryRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $subCategory = SubCategory::find($id);
            if (empty($subCategory)) {
                        return $this->errorStatus(__('msg.errorNotFound'));
                    }
            $subCategory->update([
                'name'=> $request->name
            ]);

            
            if ($request->hasFile('image')) {

                if($subCategory->image)
                {
                    updateMedia($request->image, 'subCategories', $subCategory->id);
                }else{
                    storeMedia($request->image, 'subCategories', $subCategory->id, 'App\Models\SubCategory');
                }
                
            }
            
            return $this->respondWithItem(new SubCategoryResource($subCategory) );

        }

    }

    public function destroy($id, DeleteRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $subCategory = SubCategory::withTrashed()->whereId($id)->first();
                if ($subCategory->trashed()) {
                    // The record is soft deleted
                    return $this->errorStatus(__('msg.theRecordAlreadyDeleted'));
                }
            $subCategory->delete();
            return $this->respondWithMessage(__('msg.deleted'));

        }

    }
}
