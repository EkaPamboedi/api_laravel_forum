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
      $validator = Validator::make($request->all(), $this->getValidationAttribute());

      if($validator->fails()) {
        return response()->json($validator->messages());
      }

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

     private function getValidationAttribute()
     {
       return [
          'title' => 'required|min:5',
          'body' => 'required|min:10',
          'category' => 'required',
       ];
     }

     private function getAuthUser()
     {
       try {
          return $user=  auth()->userorFail();
       } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {

         return response()->json(['message' => 'Not authenticated, you need to login first']);

       }
     }

    public function update(Request $request, $id)
    {
      //dibuat jadi satu fungsi biar gk ngulang2

      // check owp
      $validator = Validator::make($request->all(), $this->getValidationAttribute());

      if($validator->fails()) {
        return response()->json($validator->messages());
      }

      $user = $this->getAuthUser();

       Forum::find($id)
       ->update([
                  'title' => request('title'),
                  'body'  => request('body'),
                  'category'  => request('category')
        ]);
        return response()->json(['message' => 'Successfully updated ']);
     }

    public function destroy($id)
    {

    }
}
