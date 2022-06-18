<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
  trait AuthUserTrait
  {

    //dibuat jadi satu fungsi biar gk ngulang2
    // tadi nya ada di ForumController, tpi sekarang dibuat trait karna dipake berkali2 di satu instance
    private function getAuthUser()
    {
      try {
          return  $user=  auth()->userOrFail();
      } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {

        response()->json(['message' => 'Not authenticated, you need to login first'])->send();
        // send disini untuk mengirim metode keluar program
        exit;
        // karna pada laravel send tidak dapat keluar dari sistem begitu saja, maklanya menggunakan metode "exit" setelah "send" agar dapat keluar sistem.
      }
    }

    private function checkOwnership($authUser, $owner)
    {
      if ($authUser != $owner) {

        response()->json(['message' => 'Not Authorized '], 403)->send();
        exit;
      }
    }


  }

 ?>
