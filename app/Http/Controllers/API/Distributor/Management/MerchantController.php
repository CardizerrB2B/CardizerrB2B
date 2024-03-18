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

class MerchantController extends ApiController
{
    public function allMyMerchants()
    {
        //$merchants = User::withTrashed()->where('user_type','Merchant')// both deleted and not
        $merchants = User::where('user_type','Merchant')
                     ->where('distributor_id',auth()->user()->id)->get();
        return new UserProfilesCollection($merchants);
    }

    public function showAccount($id)
    {
        $merchant = User::whereId($id)->where('user_type','Merchant')
                     ->where('distributor_id',auth()->user()->id)->first();
        if (empty($merchant)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new UserProfileResource($merchant) );
    }


    public function search(SearchUserRequest $request)
    {
        $key = $request->key;
        $merchants = User::where('user_type','Merchant')
                          ->where('distributor_id',auth()->user()->id)
                          ->when($key,function($q) use($key){
                              $q->where(function($q) use($key){
                                    $q->where('id','like','%'.$key.'%')
                                        ->orWhere('mobile_number','like','%'.$key.'%')
                                        ->orWhere('username','like','%'.$key.'%') ;
                              });
                          })
                        ->paginate(20);     
        return new UserProfilesCollection($merchants);

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
                'user_type'=>'Merchant',
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
            $merchant = User::where('user_type','Merchant')
                            ->where('distributor_id',auth()->user()->id)->whereId($id)->first();

            if (empty($merchant)) {
                return $this->errorStatus(__('msg.errorNotFound'));
            }

            if($request->input('mobile_number'))
            {
                $merchant->update(['mobile_number'=>$request->mobile_number]);
            }

            if($request->input('email'))
            {
                $merchant->update(['email'=>$request->email]);
            }

            if($request->input('fullname'))
            {
                $merchant->update(['fullname'=>$request->fullname]);
            }

            
            return $this->respondWithMessage(__('msg.update'));
        }


    }

    public function destroy($id,DeleteUserRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $merchant = User::withTrashed()->whereId($id)->where('distributor_id',auth()->user()->id)->first();
                if ($merchant->trashed()) {
                    // The record is soft deleted
                    return $this->errorStatus(__('msg.theRecordAlreadyDeleted'));
                }
            $merchant->delete();
            return $this->respondWithMessage(__('msg.deleted'));

        }

    }

    public function GetSoftDeletedmerchants()
    {
        $softDeletedmerchants = User::onlyTrashed()->get();

    }

    public function restore($id)
    {
        $merchant = User::withTrashed()->find($id);
        $merchant->restore();

    }

}
