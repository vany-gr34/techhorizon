<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Message;
use Illuminate\Support\Facades\Log;

class ManagerController extends Controller
{
   public function dashboard()
    {
        // Récupérer le manager connecté
        $manager = auth()->user();
        $headerTitle = 'Welcome To Your Space, ' . $manager->name . ' !';

        // Initialiser les variables avec des valeurs par défaut
        $postCountForCategory = 0;
        $subscribersCountForCategory = 0;
        $mostRatedArticlesCount = 0;
        $subscribersArticlesCount = 0;

        // Récupérer la catégorie du manager
        $category = Category::where('user_id', $manager->id)->first();

        if ($category) {
            $categoryId = $category->id;

            // Nombre d'abonnés pour cette catégorie
            $subscribersCountForCategory = $category->subscribers()->count();

            // Nombre d'articles pour cette catégorie
            $postCountForCategory = Post::where('category_id', $categoryId)->where('stat', 'accepted')->count();

            $mostRatedArticles = collect();
    
        if ($category) {
            // Récupérer les articles avec leurs évaluations (notes) et calculer la moyenne
            $mostRatedArticles = Post::where('category_id', $category->id)
                ->with(['ratings']) // Charger la relation des évaluations
                ->get()
                ->map(function ($post) {
                    // Calculer la moyenne des évaluations
                    $post->average_rating = $post->ratings->avg('note') ?? 0; // Assurer que la moyenne est définie (0 si aucune évaluation)
                    return $post;
                })
                ->filter(function ($post) {
                    // Filtrer les articles avec une note moyenne de 4 ou 5
                    return $post->average_rating >= 4;
                })
                ->sortByDesc('average_rating') // Trier par la moyenne des évaluations (du plus élevé au plus bas)
                ->take(10); // Limiter à 10 articles les mieux notés
        }

            // Calculer le nombre d'articles les mieux notés
            $mostRatedArticlesCount = $mostRatedArticles->count();

            // Nombre d'articles des abonnés avec un statut pending
            $subscribersArticlesCount = Post::where('category_id', $categoryId)
            ->where('stat', 'pending')  // Si 'pending' 
            ->count()           
            ;
        }

        // Retourner la vue avec toutes les données
        return view('manager.dashboard', compact(
            'headerTitle',
            'category',
            'manager',
            'postCountForCategory',
            'subscribersCountForCategory',
            'mostRatedArticlesCount',
            'subscribersArticlesCount'
 ));
}


    public function articles()
    {
        // Récupérer le manager connecté
        $manager = auth()->user();

        // Récupérer la catégorie du manager
        $category = Category::where('user_id', $manager->id)->first();

        // Initialiser la variable des articles
        $posts = collect();

        if ($category) {
            // Récupérer les articles de la catégorie du manager
            $posts = Post::where('category_id', $category->id)->get();
        }

        // Retourner la vue avec les articles
        return view('manager.articles', compact('posts','category','manager'));
    }

    public function showArticle($id)
    {      // Récupérer le manager connecté
        $manager = auth()->user();

        // Récupérer la catégorie du manager
        $category = Category::where('user_id', $manager->id)->first();
        // Récupérer l'article spécifique avec ses relations
        $post = Post::with(['user', 'ratings', 'messages.user'])
                    ->findOrFail($id);
        
        // Calculer la moyenne des évaluations pour cet article
        $post->average_rating = $post->ratings->avg('note') ?? 0; // Calculer la moyenne des notes
    
        // Récupérer la note de l'utilisateur connecté (si elle existe)
        $userRating = $post->ratings->where('user_id', auth()->id())->first();
        
        // Charger les commentaires approuvés avec l'article
        
       
    
        // Retourner la vue avec les détails de l'article
        return view('manager.article-details', compact('post', 'userRating','manager','category'));
}


    public function logout(Request $request)
    {
        // Déconnecter l'utilisateur
        auth()->logout();

        // Invalider la session
        $request->session()->invalidate();

        // Régénérer le token CSRF
        $request->session()->regenerateToken();

        // Rediriger vers la page de connexion
        return redirect('/login');
    }

    public function mostRatedArticles()
    {
        // Récupérer le manager connecté
        $manager = auth()->user();
        
        // Récupérer la catégorie du manager
        $category = Category::where('user_id', $manager->id)->first();
        
        // Initialiser la variable des articles les mieux notés
        $mostRatedArticles = collect();
        
        if ($category) {
            // Récupérer les articles avec leurs évaluations (notes) et calculer la moyenne
            $mostRatedArticles = Post::where('category_id', $category->id)
                ->with(['ratings']) // Charger la relation des évaluations
                ->get()
                ->map(function ($post) {
                    // Calculer la moyenne des évaluations
                    $post->average_rating = $post->ratings->avg('rating') ?? 0 ; // Supposons que 'value' contient la note (1 à 5)
                    return $post;
                })
                ->sortByDesc('average_rating') // Trier par la moyenne des évaluations
                ->take(10); // Limiter à 10 articles
        }
        
        // Retourner la vue avec les articles les mieux notés
        return view('manager.most-rated-articles', compact('mostRatedArticles','category','manager'));
    }    
    
    public function subscribersArticles(Request $request)
    {
        // Récupérer le manager connecté
        $manager = auth()->user();

        // Récupérer la catégorie du manager
        $category = Category::where('user_id', $manager->id)->first();

        // Initialiser la variable des articles
        $posts = collect();

        if ($category) {
            // Récupérer les articles des abonnés pour cette catégorie
            $posts = Post::where('category_id', $category->id)
                            ->where('stat', 'pending')
                            ->with('user')
                            ->get();
        }

        // Retourner la vue avec les articles des abonnés
        return view('manager.subscribers-articles', compact('posts','category','manager'));
    }
    public function approveComment(Post $post, Message $message)
    {
        // Vérifier que le message appartient bien à l'article
        if ($message->post_id !== $post->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }
    
        // Vérifier si le commentaire est déjà approuvé
        if ($message->approved !== 1) {
            $message->approved = 1;
            $message->save();
        }
    
        // Retourner une réponse JSON
        return response()->json([
            'success' => true,
            'message' => 'Comment approved successfully!',
            'status' => 'approved'
        ]);
    }
    
    public function rejectComment(Post $post, Message $message)
    {
        // Vérifier que le message appartient bien à l'article
        if ($message->post_id !== $post->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }
    
        // Vérifier si le commentaire est déjà rejeté
        if ($message->approved !== 0) {
            $message->approved = 0;
            $message->save();
        }
    
        // Retourner une réponse JSON
        return response()->json([
            'success' => true,
            'message' => 'Comment rejected successfully!',
            'status' => 'rejected'
        ]);
    }

        public function updateArticleStatus(Request $request, $id)
    {
        // Debug : vérifier les données reçues
        \Log::info('Requête reçue pour l\'article ' . $id, $request->all());

        // Validation de l'action
        $validated = $request->validate([
            'action' => 'required|in:accept,reject,propose',
        ]);

        \Log::info('Action validée : ' . $validated['action']);

        // Récupérer l'article
        $post = Post::findOrFail($id);

        // Debug : vérifier si l'article est trouvé
        \Log::info('Article trouvé : ' . $post->title);

        // Mise à jour du statut
        switch ($request->action) {
            case 'accept':
                $post->stat = 'Accepted';
                break;
            case 'reject':
                $post->stat = 'Rejected';
                break;
            case 'propose':
                $post->stat = 'Proposed';
                break;
        }

        $post->save();

        \Log::info('Statut mis à jour : ' . $post->stat);

        // Retourner une réponse JSON
        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour avec succès',
            'status' => $post->stat,
        ]);
    }

public function blockManager($id)
{
    $manager = User::where('role', 'manager')->findOrFail($id);

    // Block the manager
    $manager->is_blocked = true;
    $manager->save();

    return response()->json([
        'success' => true,
        'message' => 'Manager blocked successfully.'
    ], 200);
}
public function unblockManager($id)
{
    $manager = User::where('role', 'manager')->findOrFail($id);

    // Unblock the manager
    $manager->is_blocked = false;
    $manager->save();

    return response()->json([
        'success' => true,
        'message' => 'Manager unblocked successfully.'
    ], 200);
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
        $manager = Manager::create([
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
}
