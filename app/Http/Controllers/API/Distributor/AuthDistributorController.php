<?php

namespace App\Http\Controllers\API\Distributor;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Users\LoginUserRequest;

use App\Http\Requests\Users\UpdateUserRequest;


use App\Http\Requests\Users\ChangePasswordRequest;

use App\Http\Resources\Members\UserMemberResource ;
use App\Http\Resources\Members\UserProfileResource ;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthDistributorController extends ApiController
{
    public function showMyProfile()
    {
        $user = User::find(auth()->user()->id);

        return $this->respondWithItem(new UserProfileResource($user) );
    }

    public function login(LoginUserRequest $request)
    {
        $user = User::where('user_type','Distributor')
                    ->where('username', $request->username)->first();
  
        if (empty($user)) {
            return $this->errorStatus(__('msg.wrongCreds'));
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->errorStatus(__('msg.wrongCreds'));

        }
   

        if (!auth()->guard('distributor')->setUser($user)) {
            return $this->errorStatus(__('msg.Unauthorized'));
        }
        $user = auth('distributor')->user();

        return $this->sendResponse(new UserMemberResource($user), __('msg.Login'));

    }




    public function update(UpdateUserRequest $request)
    {

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $user = User::whereId(Auth::id())->first();
            //################### 
            // codes

            if($request->input('mobile_number'))
            {
                $user->update(['mobile_number'=>$request->mobile_number]);
            }

            if($request->input('email'))
            {
                $user->update(['email'=>$request->email]);
            }

            if($request->input('fullname'))
            {
                $user->update(['fullname'=>$request->fullname]);
            }

            //###################

            
            return $this->respondWithMessage(__('msg.update'));
        }


    }

    public function logout()
    {
        if (!auth('distributor')->check()) {
            return  $this->errorUnauthenticated();
        }

        auth('distributor')->user()->token()->revoke();

        return $this->respondWithMessage(__('msg.logout'));
    }


    
    public function chnagePassword(ChangePasswordRequest $request)
    {
        if (!Hash::check($request->current_password,auth()->user()->password))
        {
            return $this->errorStatus(__('msg.checkPassword'));
        }else{
            if($request->input('new_password'))
            {
                $user = User::find(auth()->user()->id);

                $user->update([
                    'password'=> $request->new_password
                ]);

                return $this->respondWithMessage(__('msg.changePassword'));

            }
        }
      
    }



}
