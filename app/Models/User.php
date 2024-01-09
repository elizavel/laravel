<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'password_renew_date',
        'pin'
    ];
 
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token',
        'pin'
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

    public function existingUserEmailToken($id,$email,$token){
        $result = $this->where('id',$id)->where('email',$email)->where('token',$token)->get();
        if(count($result)){  
            return true;
        }
        return false;
    }

    public function validateEmail($email){
        $result = $this->where('email',$email)->get();
        if(count($result)){  
            return true;
        }
        return false;
    }

    public function updateViaEmail($email,$data){
        $this::where('email',$email)->update($data);
    }
}
