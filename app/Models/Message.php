<?php
// app/Models/Message.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id', 'content','approved'];

    // Relation avec les posts
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id');
    }

    // Relation avec les utilisateurs
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
