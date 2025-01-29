<?php

// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('subscriber.categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $posts = $category->posts; // Récupère tous les articles associés à la catégorie
    
        return view('subscriber.categories.show', compact('category', 'posts'));
    }
   // Abonnement/Désabonnement à une catégorie
   public function toggleSubscription($id)
   {
       $category = Category::findOrFail($id);
       $user = Auth::user();

       // Vérifier si l'utilisateur est déjà abonné à cette catégorie
       if ($user->categories->contains($category->id)) {
           // Si l'utilisateur est abonné, on le désabonne
           $user->categories->detach($category->id);
       } else {
           // Si l'utilisateur n'est pas abonné, on l'abonne
           $user->categories->attach($category->id);
       }

       // Rediriger avec un message de succès
       return redirect()->back()->with('success', 'Votre abonnement a été mis à jour.');
   }

    public function subscribed()
    {
        $categories = Auth::user()->categories;

        return view('subscriber.categories.subscribed', compact('categories'));
    }



    public function showSubscribed()
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();

        // Assurez-vous que l'utilisateur est trouvé
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }

        $categories = $user->categories;

        return view('subscriber.categories.subscribed', compact('categories'));
    }


}
