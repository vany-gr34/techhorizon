<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
    
    
  
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'); // Vérifie bien la clé étrangère
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function messages()
     {
         return $this->hasMany(Message::class)->where('approved',true);
 }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function interests()
{
    return $this->belongsToMany(Interest::class, 'user_interests');
}
public function categories()
{
    return $this->belongsToMany(Category::class, 'category_user');
}
public function postsHistory()
{
    return $this->hasMany(PostUserHistory::class);
}
public function isManager()
    {
        return $this->role === 'manager';
    }
}

