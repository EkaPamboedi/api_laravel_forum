<?php

namespace App\Models;
use App\Models\ForumComment;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;
   public $table = "forum";
    protected $guarded = ['id'];


public function user()
{
  return$this->belongsTo(User::class);
}
public function comments()
{
  return$this->hasMany(ForumComment::class);
}
}
