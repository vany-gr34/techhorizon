<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;
  public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Define the relationship: a Post belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }   
}
