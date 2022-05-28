<?php

namespace App\Models;
namespace App\Models\User;
namespace App\Models\ForumComment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

}

public function user()
{
  return->$this->belongsTo(User::class);
}
public function comments()
{
  return->$this->hasMany(ForumsComment::class)
}
