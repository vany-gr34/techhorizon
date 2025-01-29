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
    return $this->belongsTo(User::class, 'user_id')->where('role', 'manager');
}

public function subscribers()
{
    return $this->belongsToMany(User::class, 'category_user');
}
protected $fillable = [
    'name',
    'user_id', // Si vous associez une catégorie à un utilisateur (manager)
];
protected $except = [
    'register/step2',
    'register/step1',
    'register/submit',
];

}
