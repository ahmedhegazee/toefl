<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password',
//    ];
protected $guarded=[];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getRoleID()
    {
        return $this->role->id;
}
    public function isAdmin()
    {
        //dd($this->role()->get());
        foreach ($this->role()->get() as $role) {
            if ($role->id == 1) {
                return true;
            }
        }

        return false;
       //return $this->role();
    }

    public function getStudent()
    {
        return Student::where('uid',$this->id)->get()->first();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}
