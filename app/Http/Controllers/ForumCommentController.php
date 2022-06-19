<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthUserTrait;
use Illuminate\Support\Facades\Validator;
use App\Models\ForumComment;
use App\Models\Forum;

class ForumCommentController extends Controller
{
  use AuthUserTrait;

  public function _construct()
  {
    return auth()->shouldUse('api');
  }

  private function validateRequest()
  {
    // we only need to validate body here
    $validator = Validator::make(request()->all(),
      [
         'body' => 'required|min:10',
      ]);

      if ($validator->fails()) {

      response()->json($validator ->messages(), 422)->send();

      exit;
    }
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


  public function update(Request $request, $forumid, $commentid)
  {
      $this->validateRequest();
      $forumComment = ForumComment::find($commentid);
      // dd($forumComment);
      // $forum = Forum::find($forumid);
      $this->checkOwnership($forumComment->user_id);

       $forumComment->update([
                  'body'  => request('body'),
        ]);
        return response()->json(['message' => 'Successfully Comment updated ']);
  }

  public function destroy(Request $request, $forumid, $commentid)
  {
      $forum = Forum::find($forumid);
      $forumComment = ForumComment::find($commentid);
      $this->checkOwnership($forum->user_id);
      $forumComment->delete();
      return response()->json(['message' => 'Comment Successfully Deleted ']);
  }
}
