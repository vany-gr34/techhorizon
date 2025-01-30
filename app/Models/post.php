<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'content', 'category_id', 'user_id', 'stat', 'image'
    ];
  public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Define the relationship: a Post belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    } 

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
     // Relation avec les messages
     public function messages()
     {
         return $this->hasMany(Message::class,'post_id');
     }
     public function userRating()
{
    return $this->hasOne(Rating::class)->where('user_id', auth()->id());
}
public function approvedMessages()
{
    return $this->hasMany(Message::class)->where('approved', true);
}
}  

