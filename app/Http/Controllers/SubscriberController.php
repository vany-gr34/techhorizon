<?php

namespace App\Http\Controllers;
use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;
 use App\Models\category;
use Illuminate\Support\Facades\Auth;
use App\Models\Collection;
use App\Models\PostUserHistory;
use App\Models\CategoryUser;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class SubscriberController extends Controller

{
    public function search(Request $request)
    {
        $query = $request->input('q'); // Récupérer la requête de recherche
    
        // Rechercher les abonnés dont le nom ou l'email correspond à la requête et qui ont le rôle "subscriber"
        $subscribers = User::where('role', 'subscriber') // Filtrer par rôle
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%')
                  ->orWhere('email', 'LIKE', '%' . $query . '%');
            })
            ->get();
    
        // Renvoy er une vue partielle avec les résultats
        return view('editor.partial', ['subscribers' => $subscribers]);
    }
    public function index()
    {
        return view('subscriber.dashboard'); // Remplacez par la vue pour l'éditeur
        
{
    $subscribers = User::where('role', 'subscriber')->get(); // Récupérer tous les abonnés
    return view('manager.subscribers.index', ['subscribers' => $subscribers]);
}
    }

public function addSubscriber(Request $request)
{
    
    try {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Création de l'utilisateur
        $subscriber = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'subscriber',
        ]);

        return response()->json([
            'success' => true,
            'subscriber' => $subscriber,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}
    

// nadia part :
    public function showCategory($id)
    {
        $category = Category::findOrFail($id);
        $user = auth()->user();

        // Définir $isSubscribed à false par défaut
        $isSubscribed = false;

        if ($user) {
            // Vérifiez si l'utilisateur est abonné à la catégorie
            $isSubscribed = $user->categories->contains($id);
        }

        // Récupérer les articles associés à la catégorie
        $posts = Post::where('category_id', $id)->get();

        return view('subscriber.categories.show', compact('category', 'isSubscribed', 'posts'));
    
    }


// app/Http/Controllers/SubscriberController.php

public function subscribeCategory(Request $request, $id)
{
    $category = Category::findOrFail($id);
    $user = auth()->user();
    $isSubscribed = false;

    if ($user->categories->contains($id)) {
        $user->categories->detach($id);
    } else {
        $user->categories->attach($id);
        $isSubscribed = true;
    }

    return response()->json(['status' => 'success', 'isSubscribed' => $isSubscribed]);
}


public function create()
{
    $categories = Category::all();
    return view('subscriber.posts.create', compact('categories'));
}

public function storePost(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'category_id' => 'required|integer|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('posts', 'public'); // Stocke dans storage/app/public/posts
    }
    $post = new Post();
    $post->title = $validatedData['title'];
    $post->content = $validatedData['content'];
    $post->category_id = $validatedData['category_id'];
    $post->user_id = auth()->id();
    $post->stat = 'pending';
    $post->image = $imagePath;
    $post->save();

    return redirect()->route('posts.create')->with('success', 'Article proposé avec succès.');
}

public function showpost($postId)
{
    $post = Post::findOrFail($postId);
    $user = Auth::user();
    
    // Vérifier si les données existent avant d'enregistrer
    if ($user && $post) {
        // Enregistrer l'historique de consultation
        PostUserHistory::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'viewed_at' => now(),
        ]);
        return view('subscriber.posts.show', compact('post'));
    }

    // Si les données sont invalides
    return redirect()->back()->with('error', 'Utilisateur ou article invalide.');
}

    


public function postStatus()
{
    $posts = Post::where('user_id', auth()->id())->get();
    return view('subscriber.posts.status', compact('posts'));
}



public function ratePost(Request $request, $id)
{
    $validatedData = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
    ]);

    $post = Post::findOrFail($id);
    $userId = auth()->id();

    // Vérifier si l'utilisateur a déjà noté cet article
    $rating = $post->ratings()->where('user_id', $userId)->first();

    if ($rating) {
        // Mise à jour de la note existante
        $rating->update(['rating' => $validatedData['rating']]);
    } else {
        // Création d'une nouvelle note
        $post->ratings()->create([
            'user_id' => $userId,
            'rating' => $validatedData['rating'],
        ]);
    }
    $totalRatings = $post->ratings()->count();

    return response()->json([
        'success' => true,
        'message' => 'Votre évaluation a été enregistrée !',
        'rating' => $validatedData['rating'],
        'totalRatings' => $totalRatings
    ]);
}


public function addMessage(Request $request, $id)
    {
        $validatedData = $request->validate([
            'message' => 'required|string',
        ]);

        $post = Post::findOrFail($id);
        $post->messages()->create([
            'user_id' => auth()->id(),
            'content' => $validatedData['message'],
        ]);

        return redirect()->route('post.show', $id)->with('success', 'Message ajouté avec succès!');
    }
    public function subscribedCategories()
    {
        $categories = Auth::user()->categories; // Récupère les catégories abonnées par l'utilisateur connecté
        return view('subscriber.categories.subscribed', compact('categories'));
    }
    public function showHistory()
    {
        $user = Auth::user();
    
        // Récupérer les posts consultés par l'utilisateur
        $postsHistory = $user->postsHistory()->latest()->get();
    
        return view('subscriber.profile', compact('postsHistory'));
    }
    public function recommendBasedOnInterests()
    {
        $user = Auth::user();
    
        // Récupérer les centres d'intérêt de l'utilisateur
        $interests = $user->interests->pluck('name'); // Récupère une liste de mots-clés
    
        // Si aucun centre d'intérêt n'est défini, ne rien recommander
        if ($interests->isEmpty()) {
            $categories = Category::all();
            $collections = Collection::all();
            return view('subscriber.dashboard', ['posts' => collect(), 'categories' => $categories, 'collections' => $collections]);
        }
    
        // Rechercher des articles correspondant aux centres d'intérêt
        $recommendedPosts = Post::where(function ($query) use ($interests) {
                foreach ($interests as $interest) {
                    $query->orWhere('title', 'LIKE', '%' . $interest . '%')
                          ->orWhere('summary', 'LIKE', '%' . $interest . '%')
                          ->orWhere('content', 'LIKE', '%' . $interest . '%');
                }
            })
            ->whereNotIn('id', $user->postsHistory->pluck('post_id')) // Exclure les articles déjà consultés
            ->latest()
            ->get();
    
        // Ajouter les autres données nécessaires à la vue
        $categories = Category::all();
        $collections = Collection::all();
    
        return view('subscriber.dashboard', [
            'posts' => $recommendedPosts,
            'categories' => $categories,
            'collections' => $collections,
        ]);
 
    }

    
    public function toggleSubscription(Category $category)
    {   
        // Vérifier si l'utilisateur est connecté
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        // Logs pour vérifier que les ID sont corrects
        Log::info("Utilisateur ID: " . $user->id);
        Log::info("Catégorie ID: " . $category->id);
    
        DB::beginTransaction();
        try {
            // Vérifier si l'utilisateur est déjà abonné
            $isSubscribed = DB::table('category_user')
                ->where('user_id', $user->id)
                ->where('category_id', $category->id)
                ->exists();
    
            if ($isSubscribed) {
                // Désabonner l'utilisateur
                $user->categories()->detach($category->id);
                Log::info("Désabonnement réussi");
                $subscribed = false;
            } else {
                // Abonner l'utilisateur
                $user->categories()->attach($category->id);
                Log::info("Abonnement réussi");
                $subscribed = true;
            }
    
            DB::commit();
            return response()->json(['isSubscribed' => $subscribed]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur dans toggleSubscription: " . $e->getMessage());
            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }
    public function checkSubscription(Category $category)
{
    $user = Auth::user();
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $isSubscribed = $user->categories()->where('category_id', $category->id)->exists();
    return response()->json(['isSubscribed' => $isSubscribed]);
}
    

public function destroy($id)
{
    // Suppression du subscriber
    $subscriber = User::findOrFail($id);
    $subscriber->delete();

    // Redirection avec un message de succès
    return redirect()->route('subscribers.index')->with('success', 'Subscriber deleted successfully.');

        return redirect()->route('subscribers.index')->with('error', 'Subscriber not found.');
    }
    
}    