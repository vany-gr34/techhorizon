<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function manager()
{
    return $this->belongsto(User::class, 'User')->where('role', 'manager');
}

public function subscribers()
{
    return $this->belongsToMany(User::class, 'category_user')->where('role', 'subscriber');
}

}
