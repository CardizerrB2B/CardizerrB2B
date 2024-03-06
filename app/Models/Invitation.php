<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    public $fillable = ['distributor_id', 'is_used','is_expired', 'used_by_id', 'invitation_token', 'used_at'];

    public function generateInvitationToken() 
    {
        $this->invitation_token = substr(md5(rand(0, 9) . $this->distributor_id . time()), 0, 32);
    }

    public function isTokenExpired()
     {

        if ($this->is_used) {// if the invitation is already used, it is expired
            return true;
        }
        if ($this->is_expired) {// if the invitation is already expired, it is expired
            return true;
        }
        $current_time = time();
        $time_difference = $current_time - $this->created_at->timestamp;
    
        // Convert the time difference from seconds to minutes
        $time_difference_in_minutes = $time_difference / 60;
        // If the time difference is greater than 15 minutes, the token is expired
        return $time_difference_in_minutes > 15 ? true : false;
    }

    public function distributor()
    {
        return $this->belongsTo(User::class, 'distributor_id');
    }

    public function usedBy()
    {
        return $this->belongsTo(User::class, 'used_by_id');
    }
}
