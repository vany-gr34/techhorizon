<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostUserHistory;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Charge ses abonnements aux catégories
        $categories = $user->categories;
        $count = $categories->count();
        $postsHistory = $user->postsHistory()->orderBy('viewed_at', 'desc')->get();
        // Retourne une vue avec les données utilisateur et catégories
        return view('subscriber.profile', [
            'user' => $user,
            'categories' => $categories,
            'count'=> $count,
            'postsHistory'=> $postsHistory,
        ]);
    }
    public function unsubscribe(Category $category)
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Supprime l'abonnement (relation dans la table pivot)
        $user->categories()->detach($category->id);
        
        // Redirige avec un message de succès
        return redirect()->route('user.space')->with('success', 'Abonnement retiré avec succès.');
    }
}