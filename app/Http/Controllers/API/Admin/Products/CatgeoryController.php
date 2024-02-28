<?php

namespace App\Http\Controllers\API\Admin\Products;

use App\Http\Controllers\ApiController;

use App\Models\Category;

use App\Http\Requests\Admins\Products\SearchRequest;
use App\Http\Requests\Admins\Products\StoreCategoryRequest;
use App\Http\Requests\Admins\Products\UpdateCategoryRequest;
use App\Http\Requests\Admins\Products\DeleteRequest;

use App\Http\Resources\Admins\Products\CategoryResource;
use App\Http\Resources\Admins\Products\CategoryCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CatgeoryController extends ApiController
{
    public function index()
    {
        $categories = Category::withTrashed()->get();

        return new CategoryCollection($categories);
    }

    public function search(SearchRequest $request)
    {
        $key = $request->key;

        $categories = Category::withTrashed()->when($key , function($q) use($key) {
                                    $q->where('name','like','%'.$key.'%');
                                  })->paginate(20);

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

    public function store(StoreCategoryRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $category=Category::create([
                'name'=>$request->name
            ]);

            if ($request->hasFile('image')) {
                storeMedia($request->image, 'categories', $category->id, 'App\Models\Category');
            }
    
            return $this->successStatus((__('msg.successStatus')));
        }


    }

    public function update($id,UpdateCategoryRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $category = Category::find($id);
            if (empty($category)) {
                        return $this->errorStatus(__('msg.errorNotFound'));
                    }
            $category->update([
                'name'=> $request->name
            ]);

            if ($request->hasFile('image')) {

                if($category->image)
                {
                    updateMedia($request->image, 'categories', $category->id);
                }else{
                    storeMedia($request->image, 'categories', $category->id, 'App\Models\Category');
                }
                
            }
            
            return $this->respondWithItem(new CategoryResource($category) );

        }

    }

    public function destroy($id, DeleteRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $category = Category::withTrashed()->whereId($id)->first();
                if ($category->trashed()) {
                    // The record is soft deleted
                    return $this->errorStatus(__('msg.theRecordAlreadyDeleted'));
                }
            $category->delete();
            return $this->respondWithMessage(__('msg.deleted'));

        }

    }
}
