<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResources;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($username)
    {
        return new UserResources(User::where('username', $username)->first());
    }   

    public function getActivity($username)
    {
        return new UserResources (User::where('username', $username)
                    ->with('forums','forumComments')->first()
                );
    }
}
