<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Users\RegisterUserRequest;
use App\Http\Requests\Users\LoginUserRequest;

use App\Http\Requests\Users\UpdateUserRequest;


use App\Http\Requests\Users\ChangePasswordRequest;

use App\Http\Resources\Members\UserMemberResource ;
use App\Http\Resources\Members\UserProfileResource ;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthUserController extends ApiController
{

    public function show($id)
    {
        $user = User::find($id);

        return $this->respondWithItem(new UserProfileResource($user) );
    }


    public function register(RegisterUserRequest $request)
    {
        User::create([
            "username" => $request->username,
            "password"=> $request->password,
            "mobile_number"=> $request->mobile_number,
            "email"=> $request->email,
            "fullname"=> $request->fullname,
        ]);

        return $this->successStatus((__('msg.successStatus')));
    }

    public function login(LoginUserRequest $request)
    {
        $user = User::where('mobile_number', $request->mobile_number)->first();
  

        if (empty($user)) {
            return $this->errorStatus(__('msg.wrongCreds'));
        }

        if ($user->enable === 0) {
            return $this->errorStatus(__('msg.disableUser'));
        }
 

        if (!auth()->guard('api')->setUser($user)) {
            return $this->errorStatus(__('msg.Unauthorized'));
        }
        $user = auth('api')->user();

        // if (!Auth::guard('web')->attempt($request->only('email', 'password'))) {
        //     return $this->errorStatus(__('msg.Unauthorized'));
        // }
      
        // $user = auth('web')->user();

        return $this->sendResponse(new UserMemberResource($user), __('msg.Login'));

    }




    public function update(UpdateUserRequest $request)
    {
       // dd(Auth::user());

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
        if (!auth('api')->check()) {
            return  $this->errorUnauthenticated();
        }

        auth('api')->user()->token()->revoke();

        return $this->respondWithMessage(__('msg.logout'));
    }


    
    public function chnagePassword(ChangePasswordRequest $request)
    {
       // dd(auth()->user()->password);
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
