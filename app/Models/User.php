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
    
    
    public function managedCategories()
{
    return $this->hasMany(Category::class, 'manager_id');
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function interests()
{
    return $this->belongsToMany(Interest::class, 'user_interests');
}

}
