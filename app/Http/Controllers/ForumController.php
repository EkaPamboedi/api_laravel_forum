<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AuthUserTrait;
use Illuminate\Support\Str;
use App\Models\Forum;
use App\Models\ForumComments;


class ForumController extends Controller
{
  use AuthUserTrait;
  public function _construct()
  {
    return auth()->shouldUse('api');
  }

    public function index()
    {
      return Forum::with('user:id,username', 'comments:user_id,body')->get();
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
      return Forum::with('user:id,username', 'comments.user:id,username')->find($id);
    }


    public function update(Request $request, $id)
    {

      // check owp
      // #Validator1st
      // $validator = Validator::make($request->all(), $this->getValidationAttribute());
      $this->validateRequest();
      // $user = $this->getAuthUser(); getAuthUser nya dilakukan di AuthUserTrait
      $forum = Forum::find($id);

      $this->checkOwnership($forum->user_id);

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
      $this->checkOwnership($forum->user_id);
      $forum->delete();
      return response()->json(['message' => 'Successfully Deleted ']);
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

}