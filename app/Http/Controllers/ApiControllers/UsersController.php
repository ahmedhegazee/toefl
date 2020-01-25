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
            if ($role->id == 1 || $role->id == 2)
                return [
                    'value' => $role->id,
                    'text' => $role->title,
                    'disabled' => true,
                ];
            else
                return [
                    'value' => $role->id,
                    'text' => $role->title
                ];
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
        $checkEmail = true;
        $checkName = true;
        $checkPassword = true;
        if (strlen($request->name) > 0){
            $message = " update user account with id is " . $user->id." and old name is".$user->name ." new name is ".$request->name;
            Logging::logAdmin(auth()->user(), $message);
            $checkName = $user->update([
                'name' => $request->name,
            ]);
        }

        if (strlen($request->email) > 0){
            $message = " update user account with id is " . $user->id." and old email is".$user->email ." new email is ".$request->email;
            Logging::logAdmin(auth()->user(), $message);
            $checkEmail = $user->update([
                'email' => $request->email,
            ]);
        }

        if (strlen($request->password) > 0){
            $message = " update user account password with id is " . $user->id;
            Logging::logAdmin(auth()->user(), $message);
            $checkPassword = $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $check = $checkEmail && $checkName && $checkPassword;
        return response()->json(['success' => $check]);
    }
    public function destroy(User $user)
    {
        $message = " delete user account  with id is " . $user->id;
        Logging::logAdmin(auth()->user(), $message);

        $user->roles()->sync([]);
        $user->delete();
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
