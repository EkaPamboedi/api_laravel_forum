<?php

namespace App\Models;
namespace App\Models\User;
namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
}

public function user(){
  return->$this->belongsTo(User::class);
}
public function forum(){
  return->$this->belongsTo(Forum::class);
}
