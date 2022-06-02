<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
     protected function redirectTo($request)
     {
         if (! $request->expectsJson()) {
             return route('login');
         }
     }
    // public function handle($request, Closure $next){
    //   if(!empty(trim($request->input('api_token'))))
    //   {
    //     $is_exists = User::where('id' , Auth::guard('api')->id())->exists();
    //     if($is_exists){
    //       return $next($request);
    //     }
    //   }
    //   return response()->json('Invalid Token', 401);
    // }
    // protected function authenticate($request, array $guards)
    // {
    //     if (empty($guards)) {
    //         $guards = [null];
    //     }
    //
    //     foreach ($guards as $guard) {
    //         if ($this->auth->guard($guard)->check()) {
    //             return $this->auth->shouldUse($guard);
    //         }
    //     }
    //
    //     throw new UnauthorizedHttpException('JWTAuth', 'Unauthenticated.');
    // }
}
