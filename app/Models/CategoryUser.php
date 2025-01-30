<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryUser extends Model
{
    use HasFactory;

    protected $table = 'category_user';

    protected $fillable = ['user_id', 'category_id'];

    public function index()
{
    // Récupérer tous les abonnés de la catégorie du manager connecté
    $subscribers = CategoryUser::with('user', 'category')->get();

    return view('manager.subscribers', compact('subscribers'));
}

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec la catégorie
    public function category()
    {
            return $this->belongsTo(Category::class);
}
public function users()
{
    return $this->belongsToMany(User::class, 'category_user', 'category_id', 'user_id');
}



    





   
}
