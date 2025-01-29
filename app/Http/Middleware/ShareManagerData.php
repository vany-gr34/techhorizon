<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;

class ShareManagerData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Vérifie si l'utilisateur est authentifié
        if (auth()->check()) {
            $manager = auth()->user();
            view()->share('manager', $manager);
    
            // Récupère la première catégorie de l'utilisateur
            $category = Category::where('user_id', $manager->id)->first();
    
            // Partage la catégorie avec toutes les vues (ou null si elle n'existe pas)
            view()->share('category', $category);
        }
    
        // Continue la requête
        return $next($request);
    }
}