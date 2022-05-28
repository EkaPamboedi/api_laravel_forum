<?php

namespace App\Models;

namespace App\Models\Forum;
namespace App\Models\ForumsComment;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'email',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function forums()
    {
      return->$this->hasMany(Forum::class)
    }

    public function forumsComment()
    {
      return->$this->hasMany(ForumsComment::class)
    }

    public function getJWTIdentifier()
      {
          return $this->getKey();
      }

    public function getJWTCustomClaims()
    {
        return [];
    }

}

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
