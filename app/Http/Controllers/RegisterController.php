<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class RegisterController extends Controller
{
  public function register()
  {
    $this->validate(request(),[
       'email' => 'required|email|unique:users',
       'username' => 'required|unique:users',
       'password' => 'required',
    ]);

    $user = User::create([
        'email'     => request('email'),
        'username' => request('username'),
        'password'  => Hash::make(request('password'))
      ]);
     return response()->json(['message' => 'Successfully register']);
     // return response()->json(['message' => 'Successfully logged out']);
  }
}
