<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{    protected $fillable = ['collection'];
    use HasFactory;
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
