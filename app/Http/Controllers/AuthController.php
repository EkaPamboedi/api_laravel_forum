<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
  /**
   * Create a new AuthController instance.
   *
   * @return void
   */
  public function __construct()
  {
      // $this->middleware('auth:api', ['except' => ['login']]);
      $this->middleware('auth:api', ['except' => ['login','register']]);
      // return auth()->shouldUse('api');
  }

  /**
   * Get a JWT via given credentials.
   *
   * @return \Illuminate\Http\JsonResponse
   */
   // Register function

   public function register()
   {
     // if (condition) {
     $validator = Validator::make(request()->all(), [
        'email' => 'required|email|unique:users',
        'username' => 'required|unique:users',
        'password' => 'required',
     ]);

     if ($validator->fails()) {
       return response()->json([$validator->messages()]);
     }

     $user = User::create([
         'email'     => request('email'),
         'username' => request('username'),
         'password'  => Hash ::make(request('password'))
       ]);
      return response()->json(['message' => 'Successfully register']);
   }

  public function login()
  {
      $credentials = request(['email', 'password']);

      if (! $token = auth()->attempt($credentials)) {
          return response()->json(['error' => 'Unauthorized'], 401);
      }

      return $this->respondWithToken($token);
  }

  /**
   * Get the authenticated User.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function me()
  {
      return response()->json(auth()->user());
  }

  /**
   * Log the user out (Invalidate the token).
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
      auth()->logout();

      return response()->json(['message' => 'Successfully logged out']);
  }

  /**
   * Refresh a token.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function refresh()
  {     
    //  refresh(true ,true); true yang pertaman untuk membuat kadaluarsa token yang lama,
    //  true ke 2 untuk membuat token baru
      return $this->respondWithToken(auth()->refresh(true, true));
  }

  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function respondWithToken($token)
  {
      return response()->json([
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth()->factory()->getTTL() * 60
      ]);
  }
}
