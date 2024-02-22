<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'mobile_number',
        'email',
        'fullname',
        'user_type',
        'createdBy_id',
        'distributor_id',
        'google2fa_secret',
        'google2fa_enabled',
    ];


    // protected function google2faSecret(): Attribute
    // {
       
    //     return new Attribute(
    //         get: fn ($value) =>  decrypt($value),
    //         set: fn ($value) =>  encrypt($value),
    //     );
    // }

    ##### distributor section ###################

    public function myStore()
    {
        return $this->hasOne(Store::class,'owner_id','id');
    }
    #############################################


    public function paymentAccount()
    {
        return $this->hasOne(PaymentAccount::class,'user_id','id');
    }

    public function walletAccount()
    {
        return $this->hasOne(WalletDetail::class,'user_id','id');
    }

    #########################################
    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    

}
