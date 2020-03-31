<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Logging;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $users = $this->getUsers(User::all()) ;

//        dd(Role::all());
        $roles = $this->getRoles(Role::all());

        $data = [
            'users' => $users,
            'roles' => $roles
        ];
        return response()->json($data);

    }

    public function getUsers($users)
    {
        return $users->filter(function ($user) {
            if (!$user->roles->contains(2))
                return $user;
        })->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $this->rolesToString($user->roles->toArray()),
                'selectedRoles' => $user->roles->pluck('id')->toArray(),
                'Actions' => '',
            ];
        })->values();
    }
    public function rolesToString($roles)
    {
        $data = '';
        foreach ($roles as $role)
            $data .= $role['title'] . " , ";
        return $data;
    }

    public function getRoles($roles)
    {
        return $roles->map(function ($role) {
            $data=[];
            if ($role->id == 1 || $role->id == 2)
                $data=[
                    'value' => $role->id,
                    'text' => $role->title,
                    'disabled' => true,
                ];

            else
                $data=[
                    'value' => $role->id,
                    'text' => $role->title
                ];
                return $data;
        })->values();
    }
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
        ]);
        $user->roles()->attach(1);
        $data = [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $this->rolesToString($user->roles->toArray()),
                'selectedRoles' => $user->roles->pluck('id')->toArray(),
                'Actions' => '',
            ],
            'success' => true
        ];
        $message = " create new user account with id is " . $user->id." and name is ".$user->name ;
        Logging::logAdmin(auth()->user(), $message);
        return response()->json($data);
    }
    public function update(Request $request,User $user)
    {
        if($user->id!=1){
       $check=false;
        $data=[];
        if (strlen($request->name) > 0){
            $message = " update user account with id is " . $user->id." and old name is".$user->name ." new name is ".$request->name;
            Logging::logAdmin(auth()->user(), $message);
            $data['name']=$request->name;
//            $checkName = $user->update([
//                'name' => $request->name,
//            ]);
        }

        if (strlen($request->email) > 0){
            $message = " update user account with id is " . $user->id." and old email is".$user->email ." new email is ".$request->email;
            Logging::logAdmin(auth()->user(), $message);
            $data['email']=$request->email;
//            $checkEmail = $user->update([
//                'email' => $request->email,
//            ]);
        }

        if (strlen($request->password) > 0){
            $message = " update user account password with id is " . $user->id;
            Logging::logAdmin(auth()->user(), $message);
            $data['password']=Hash::make($request->password);
//            $checkPassword = $user->update([
//                'password' => Hash::make($request->password),
//            ]);
        }
        if(!empty($data)){
            $check =   $user->update($data);
        }


        return response()->json(['success' => $check]);
        } return response()->json(['success'=>false,'message'=>'you can\'t update this user sorry.' ]);
    }
    public function destroy(User $user)
    {
        if($user->id!=1){
            if($user->id != auth()->user()->id){
                $message = " delete user account  with id is " . $user->id;
                Logging::logAdmin(auth()->user(), $message);

                $user->roles()->sync([]);
                $user->delete();
                return response()->json(['success'=>true ]);
            }else
                return response()->json(['success'=>false,'message'=>'you can\'t delete yourself.' ]);
        } return response()->json(['success'=>false,'message'=>'you can\'t delete this user sorry.' ]);


    }
    public function updateRoles(Request $request, User $user)
    {
        $roles=Role::whereIn('id',$request->roles)->get();
        $message = " update user account roles with id is " . $user->id." ,old roles are { ".$this->rolesToString($user->roles->toArray())
        ." } new roles are {".$this->rolesToString($roles->toArray())." }";

        $user->roles()->sync($request->roles);
        Logging::logAdmin(auth()->user(), $message);
        return response()->json(['success' => true]);
    }
}
