<?php

namespace App\Http\Controllers\API\Distributor\Management;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Users\CreateNewUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Requests\Users\DeleteUserRequest;
use App\Http\Requests\Users\SearchUserRequest;


use App\Http\Resources\Members\UserProfileResource ;
use App\Http\Resources\Members\UserProfilesCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class MarchentController extends ApiController
{
    public function allMyMarchents()
    {
        //$marchents = User::withTrashed()->where('user_type','Marchent')// both deleted and not
        $marchents = User::where('user_type','Marchent')
                     ->where('distributor_id',auth()->user()->id)->get();
        return new UserProfilesCollection($marchents);
    }

    public function showAccount($id)
    {
        $marchent = User::whereId($id)->where('user_type','Marchent')
                     ->where('distributor_id',auth()->user()->id)->first();
        if (empty($marchent)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new UserProfileResource($marchent) );
    }


    public function search(SearchUserRequest $request)
    {
        $key = $request->key;
        $marchents = User::where('user_type','Marchent')
                          ->where('distributor_id',auth()->user()->id)
                          ->when($key,function($q) use($key){
                              $q->where(function($q) use($key){
                                    $q->where('id','like','%'.$key.'%')
                                        ->orWhere('mobile_number','like','%'.$key.'%')
                                        ->orWhere('username','like','%'.$key.'%') ;
                              });
                          })
                        ->paginate(20);     
        return new UserProfilesCollection($marchents);

    }

    


    public function createNewAccount(CreateNewUserRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            User::create([
                "username" => $request->username,
                "mobile_number"=> $request->mobile_number,
                "email"=> $request->email,
                "fullname"=> $request->fullname,
                'user_type'=>'Marchent',
                'password'=>1234,//defualt password and it should be changed in the first login process 
                "createdBy_id"=> auth()->user()->id,
                "distributor_id"=> auth()->user()->id,

            ]);

        return $this->successStatus((__('msg.successStatus')));
      }

        
    }


    public function updateAccount($id,UpdateUserRequest $request)
    {

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $marchent = User::where('user_type','Marchent')
                            ->where('distributor_id',auth()->user()->id)->whereId($id)->first();

            if (empty($marchent)) {
                return $this->errorStatus(__('msg.errorNotFound'));
            }

            if($request->input('mobile_number'))
            {
                $marchent->update(['mobile_number'=>$request->mobile_number]);
            }

            if($request->input('email'))
            {
                $marchent->update(['email'=>$request->email]);
            }

            if($request->input('fullname'))
            {
                $marchent->update(['fullname'=>$request->fullname]);
            }

            
            return $this->respondWithMessage(__('msg.update'));
        }


    }

    public function destroy($id,DeleteUserRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $marchent = User::withTrashed()->whereId($id)->where('distributor_id',auth()->user()->id)->first();
                if ($marchent->trashed()) {
                    // The record is soft deleted
                    return $this->errorStatus(__('msg.theRecordAlreadyDeleted'));
                }
            $marchent->delete();
            return $this->respondWithMessage(__('msg.deleted'));

        }

    }

    public function GetSoftDeletedMarchents()
    {
        $softDeletedMarchents = User::onlyTrashed()->get();

    }

    public function restore($id)
    {
        $marchent = User::withTrashed()->find($id);
        $marchent->restore();

    }

}
