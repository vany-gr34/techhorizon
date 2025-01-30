<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\post;
use Illuminate\Http\Request;
use App\Models\User;
class EditorController extends Controller
{
    
    
 
// 3lch knt zidt had fonctionalite hna is her what cuz the problem checkitt
public function dashboard()
{
    // Count users and articles
    $userCount = User::count();
    $articleCount = post::count();
    $catgoryCount = category::count();
    $managersCount = User::where('role', 'manager')->count();
    $subscribersCount = User::where('role', 'subscriber')->count();
    $publicCount = post::where('status', 'public')->count();
    $proposedCount = post::where('status', 'proposed')->count();
    $privateCount = post::where('status', 'private')->count();
    $collectionsCount = Collection::count(); 
    // Pass the counts to the view
    return view('editor.dashboard', compact('userCount', 'articleCount',  'catgoryCount' , 'managersCount','subscribersCount','publicCount','proposedCount', 'privateCount','collectionsCount'));
}

public function subscribers()
{
    // Fetch users with the 'subscriber' role
    $subscribers = User::where('role', 'subscriber')->get();

    // Pass the data to the view
    return view('editor.subscribers', compact('subscribers'));
}

public function managers()
{
    // Récupérer les utilisateurs ayant le rôle 'manager'
    $managers = User::where('role', 'manager')->get();
    $categories = Category::with('manager')->get(); 
    // Passer les données à la vue
    return view('editor.managers', compact('managers','categories'));
}

public function destroy($id)
{
    try {
        $subscriber = User::where('role', 'subscriber')->findOrFail($id);
        $subscriber->delete();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression : ' . $e->getMessage()], 500);
    }
}

public function block($id)
{
    // Trouver l'abonné ou renvoyer une erreur 404 si non trouvé
    $subscriber = User::findOrFail($id);

    // Bloquer l'abonné
    $subscriber->is_blocked = true;
    $subscriber->save();

    // Renvoyer une réponse JSON de succès
    return response()->json([
        'success' => true,
        'message' => 'Subscriber blocked successfully.'
    ], 200); // Code de statut 200 pour indiquer un succès
}

public function unblock($id)
{
    $subscriber = User::find($id);

    if (!$subscriber || $subscriber->role !== 'subscriber') {
        return response()->json(['success' => false, 'message' => 'Subscriber not found.'], 404);
    }

    $subscriber->is_blocked = false; // Update the status
    $subscriber->save();

    return response()->json(['success' => true]);
}

public function update(Request $request, $id)
{
    $subscriber = User::findOrFail($id);
    $subscriber->update([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Abonné mis à jour avec succès.',
    ]);
}


public function getAllArticles()
{
    $posts= post::all();
    return view('editor.articles', compact('posts')); 
}
public function activate($id)
{
    $article = post::findOrFail($id); 
    $article->status = 'public'; 
    $article->save(); 

    return redirect()->back()->with('success', 'L\'article a été rendu public avec succès.');
}

public function delete($id)
{
    try {
        // Récupérer la catégorie
        $category = Category::findOrFail($id);

        // Supprimer les posts associés à la catégorie
        $category->posts()->delete();

        // Supprimer le manager de la catégorie
        if ($category->manager) {
            $category->manager()->delete();
        }

        // Supprimer la catégorie elle-même
        $category->delete();

        return response()->json(['success' => true, 'message' => 'Catégorie et ses relations supprimées.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression.']);
    }
}
public function addManager(Request $request)
{
    try {
        // Log pour voir les données reçues
        \Log::info($request->all());

        // Vérifier si la catégorie est envoyée
        if (!$request->has('category')) {
            return response()->json(['success' => false, 'message' => 'Category is missing.'], 400);
        }

        // Créer le manager
        $manager = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Créer la catégorie et l'associer
        $category = Category::create([
            'name' => $request->category,
            'manager_id' => $manager->id,
        ]);

        return response()->json(['success' => true, 'manager' => $manager, 'category' => $category]);
    } catch (\Exception $e) {
        \Log::error($e);
        return response()->json(['success' => false, 'message' => 'Server error.'], 500);
    }
}


public function searchManager(Request $request)
{
    $query = $request->get('q');
    
    // Rechercher les catégories et leurs managers
    $categories = Category::with('manager')
        ->where('name', 'LIKE', "%{$query}%")
        ->orWhereHas('manager', function ($queryBuilder) use ($query) {
            $queryBuilder->where('name', 'LIKE', "%{$query}%")
                         ->orWhere('email', 'LIKE', "%{$query}%");
        })
        ->get();

    // Retourner une vue partielle avec les résultats
    return view('editor.partial2', compact('categories'))->render();
}


}