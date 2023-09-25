<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function getUsers()
    {
       return User::with('subscriptions')->get();

    }

    public function storeUser($data)
    {
        $user = User::create($data);
        $user->assignRole('User');
        return $user;
    }

    public function showUser($data,$id)
    {
        $user = User::with('subscriptions.item')->where('id',$id)->first();
        return $user;
    }



    public function destroy($data,$id)
    {
        $startTime = microtime(true);
        $user = User::where('id',$id)->first();

        if ($user->subscriptions()->count() > 0) {
            return response()->error(request(), null, 'The Subscription  User cannot be deleted .', 400, $startTime);
        }
        return $user->delete();
    }



    public function updateUser($data,$id)
    {
        $user = User::where('id',$id)->first();
        $user->update($data);
        return $user;
    }


    public function socialLogin($data)
    {

      $user= User::create($data);
      $user->assignRole('User');
      return $user;
    }


    public function userStatus($request,$id)
    {
        $user= User::where('id',$id)->first();


        $user->status = $user->status == 1 ? 0 : 1;
        $data = $user->save();
        return $data;
    }




}
