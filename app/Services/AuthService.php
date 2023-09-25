<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{


    public function register($validatedData)
    {

        $data = array_merge($validatedData, ['password' => Hash::make($validatedData['password'])]);
        $user =  User::create($validatedData);
        $user->assignRole($data['role']);
        return $user;
    }









}


