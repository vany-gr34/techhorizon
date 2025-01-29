<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostUserHistory extends Model
{
    protected $table = 'post_user_history';  // Nom de la table
    public $timestamps = false;

    protected $fillable = ['user_id', 'post_id', 'viewed_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
