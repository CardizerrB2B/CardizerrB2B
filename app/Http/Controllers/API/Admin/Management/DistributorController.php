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
use App\Models\Store;
use Exception;
use Illuminate\Support\Facades\DB;

class DistributorController extends ApiController
{
    public function allMyDistributors()
    {
        //$distributors = User::withTrashed()->where('user_type','Distributor')// both deleted and not
        $distributors = User::where('user_type','Distributor')
                             ->get();
        return new UserProfilesCollection($distributors);
    }

    public function showAccount($id)
    {
        $distributor = User::whereId($id)->where('user_type','Distributor')
                            ->first();
        if (empty($distributor)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new UserProfileResource($distributor) );
    }


    public function search(SearchUserRequest $request)
    {
        $key = $request->key;
        $distributors = User::where('user_type','Distributor')
                          ->when($key,function($q) use($key){
                              $q->where(function($q) use($key){
                                    $q->where('id','like','%'.$key.'%')
                                        ->orWhere('mobile_number','like','%'.$key.'%')
                                        ->orWhere('username','like','%'.$key.'%') ;
                              });
                          })
                        ->paginate(20);

                        
        return new UserProfilesCollection($distributors);

    }

    


    public function createNewAccount(CreateNewUserRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{

            try {

                DB::beginTransaction();

                    $distributor= User::create([
                        "username" => $request->username,
                        "mobile_number"=> $request->mobile_number,
                        "email"=> $request->email,
                        "fullname"=> $request->fullname,
                        'user_type'=>'Distributor',
                        'password'=>1234,//defualt password and it should be changed in the first login process 
                        "createdBy_id"=> auth()->user()->id,
        
                    ]);
        
                    Store::create([
                        'name'=>$distributor->fullname,
                        'owner_id'=>$distributor->id,
                        "createdBy_id"=> auth()->user()->id,
        
                    ]);
                
                DB::commit();
                return $this->successStatus((__('msg.successStatus')));

            } catch (\Exception $exception) {
                DB::rollBack();
                return $this->errorStatus(__($exception->getMessage()));
            }




      }

        
    }


    public function updateAccount($id,UpdateUserRequest $request)
    {

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $distributor = User::where('user_type','Distributor')->whereId($id)->first();

            if (empty($distributor)) {
                return $this->errorStatus(__('msg.errorNotFound'));
            }

            if($request->input('mobile_number'))
            {
                $distributor->update(['mobile_number'=>$request->mobile_number]);
            }

            if($request->input('email'))
            {
                $distributor->update(['email'=>$request->email]);
            }

            if($request->input('fullname'))
            {
                $distributor->update(['fullname'=>$request->fullname]);
            }

            
            return $this->respondWithMessage(__('msg.update'));
        }


    }

    public function destroy($id,DeleteUserRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $distributor = User::withTrashed()->whereId($id)->first();
                if ($distributor->trashed()) {
                    // The record is soft deleted
                    return $this->errorStatus(__('msg.theRecordAlreadyDeleted'));
                }
            $distributor->delete();
            return $this->respondWithMessage(__('msg.deleted'));

        }

    }

    public function GetSoftDeletedDistributors()
    {
        $softDeletedDistributors = User::onlyTrashed()->get();

    }

    public function restore($id)
    {
        $distributor = User::withTrashed()->find($id);
        $distributor->restore();

    }

}
