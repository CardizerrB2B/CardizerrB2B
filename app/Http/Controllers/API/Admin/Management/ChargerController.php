<?php

namespace App\Http\Controllers\API\Admin\Management;

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

class ChargerController extends ApiController
{
    public function allMyChargers()
    {
        $chargers = User::where('user_type','Charger')
                             ->get();
        return new UserProfilesCollection($chargers);
    }

    public function showAccount($id)
    {
        $charger = User::whereId($id)->where('user_type','Charger')
                            ->first();
        if (empty($charger)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new UserProfileResource($charger) );
    }


    public function search(SearchUserRequest $request)
    {
        $key = $request->key;
        $chargers = User::where('user_type','Charger')
                          ->when($key,function($q) use($key){
                              $q->where(function($q) use($key){
                                    $q->where('id','like','%'.$key.'%')
                                        ->orWhere('mobile_number','like','%'.$key.'%')
                                        ->orWhere('username','like','%'.$key.'%') ;
                              });
                          })
                        ->paginate(20);
        return new UserProfilesCollection($chargers);

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
                'user_type'=>'Charger',
                'password'=>1234,//defualt password and it should be changed in the first login process 
                "createdBy_id"=> auth()->user()->id,

            ]);

        return $this->successStatus((__('msg.successStatus')));
      }

        
    }


    public function updateAccount($id,UpdateUserRequest $request)
    {

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $charger = User::where('user_type','Charger')->whereId($id)->first();

            if (empty($charger)) {
                return $this->errorStatus(__('msg.errorNotFound'));
            }

            if($request->input('mobile_number'))
            {
                $charger->update(['mobile_number'=>$request->mobile_number]);
            }

            if($request->input('email'))
            {
                $charger->update(['email'=>$request->email]);
            }

            if($request->input('fullname'))
            {
                $charger->update(['fullname'=>$request->fullname]);
            }

            
            return $this->respondWithMessage(__('msg.update'));
        }


    }

    public function destroy($id,DeleteUserRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $charger = User::withTrashed()->whereId($id)->first();
                if ($charger->trashed()) {
                    // The record is soft deleted
                    return $this->errorStatus(__('msg.theRecordAlreadyDeleted'));
                }
            $charger->delete();
            return $this->respondWithMessage(__('msg.deleted'));

        }

    }

    public function GetSoftDeletedChargers()
    {
        $softDeletedChargers = User::onlyTrashed()->get();

    }

    public function restore($id)
    {
        $charger = User::withTrashed()->find($id);
        $charger->restore();

    }

}
