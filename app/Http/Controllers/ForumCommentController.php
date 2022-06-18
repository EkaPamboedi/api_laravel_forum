<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthUserTrait;
use Illuminate\Support\Facades\Validator;

class ForumCommentController extends Controller
{
  use AuthUserTrait;

  public function _construct()
  {
    return auth()->shouldUse('api');
  }


  public function store(Request $request, $id)
  {
    $this->validateRequest();
    $user = $this->getAuthUser();

    $user->forumComments()->create([
      'body'  => request('body'),
      'forum_id' => $id
    ]);
     return response()->json(['message' => 'Successfully comment posted']);
  }
  private function validateRequest()
  {
    // we only need to validate body here
    $validator = Validator::make(request()->all(),
      [
         'body' => 'required|min:10',
      ]);

      if ($validator->fails()) {

      response()->json($validator ->messages())->send();

      exit;
    }
  }
}
