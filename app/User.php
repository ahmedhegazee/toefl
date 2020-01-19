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

    public function getStudent()
    {
        return Student::where('uid',$this->id)->get()->first();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function isAdmin()
    {
        return $this->roles->contains(1) ;
    }
    public function isSuperAdmin()
    {
        return $this->roles->contains(11) ;
    }
    public function canEditMarks()
    {
        return $this->roles->contains(7) ;
    }
    public function canManageExamsPanel()
    {
        return $this->roles->contains(3) ;
    }
    public function canManageStudentsPanel()
    {
        return $this->roles->contains(9) ;
    }
    public function canManageReservationsPanel()
    {
        return $this->roles->contains(10) ;
    }
    public function canManageGrammarSection()
    {
        return $this->roles->contains(5) ;
    }
    public function canManageReadingSection()
    {
        return $this->roles->contains(4) ;
    }
    public function canManageListeningSection()
    {
        return $this->roles->contains(6) ;
    }
    public function canPrintCertificates()
    {
        return $this->roles->contains(8) ;
    }

}
