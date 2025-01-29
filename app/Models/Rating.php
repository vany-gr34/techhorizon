<?php

// app/Models/Rating.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id', 'rating'];

    // Relation avec les posts
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relation avec les utilisateurs
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
