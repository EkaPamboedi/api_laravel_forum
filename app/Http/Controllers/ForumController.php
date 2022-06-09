<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Forum;


class ForumController extends Controller
{
    public function index()
    {
      return Forum::with('user:id,username')->get();
    }

    public function store(Request $request)
    {
      //#Validator1st
      // $validator = Validator::make($request->all(), $this->getValidationAttribute());
      $this->validateRequest();
      $user = $this->getAuthUser();

      $user->forums()->create([
        'title' => request('title'),
        'body'  => request('body'),
        'slug'  => str::slug(request('title'), '-').'-'.time(),
        'category'  => request('category'),
      ]);
       return response()->json(['message' => 'Successfully posted']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }


    public function update(Request $request, $id)
    {

      // check owp
      // #Validator1st
      // $validator = Validator::make($request->all(), $this->getValidationAttribute());
      $this->validateRequest();
      $user = $this->getAuthUser();
      $forum = Forum::find($id);
      $this->checkOwnership($user->id, $forum->user_id);
       $forum->update([
                  'title' => request('title'),
                  'body'  => request('body'),
                  'category'  => request('category')
        ]);
        return response()->json(['message' => 'Successfully updated ']);
     }

    public function destroy($id)
    {
      $forum = Forum::find($id);
      $user = $this->getAuthUser();

      $this->checkOwnership($user->id, $forum->user_id);
      $forum->delete();
      return response()->json(['message' => 'Successfully Deleted ']);
    }

    //dibuat jadi satu fungsi biar gk ngulang2
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

    // #Validator1st cara pertama
    private function getValidationAttribute()
    {
      return [
         'title' => 'required|min:5',
         'body' => 'required|min:10',
         'category' => 'required',
      ];
    }
    private function validateRequest()
    {
      $validator = Validator::make(request()->all(),
        [
           'title' => 'required|min:5',
           'body' => 'required|min:10',
           'category' => 'required',
        ]);

        if ($validator->fails()) {

        response()->json($validator ->messages())->send();
        exit;
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
