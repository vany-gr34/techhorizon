<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Message;

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
            $postCountForCategory = Post::where('category_id', $categoryId)->where('status', 'accepted')->count();

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
            ->where('status', 'pending')  // Si 'pending' 
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
    {
        // Récupérer l'article spécifique
        $post = Post::with('user')->findOrFail($id);
            // Charge les commentaires avec l'article
        $post->load('comments.user'); // Charge les commentaires et leurs utilisateurs associés

        // Retourner la vue avec les détails de l'article
        return view('manager.article-details', compact('post'));
    }

    public function showSubscribers()
    {
        // Récupérer le manager connecté
        $manager = auth()->user();

        // Récupérer la catégorie du manager
        $category = Category::where('user_id', $manager->id)->first();

        // Initialiser la variable des abonnés
        $subscribers = collect();

        if ($category) {
            // Récupérer les abonnés liés à la catégorie du manager
            $subscribers = $category->subscribers;
        }

        // Retourner la vue avec les abonnés
        return view('manager.subscribers', compact('subscribers','category','manager'));
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
                    $post->average_rating = $post->ratings->avg('value'); // Supposons que 'value' contient la note (1 à 5)
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
                            ->with('user')
                            ->get();
                            
        }

        // Retourner la vue avec les articles des abonnés
        return view('manager.subscribers-articles', compact('posts','category','manager'));
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
                    $post->status = 'Accepted';
                    break;
                case 'reject':
                    $post->status = 'Rejected';
                    break;
                case 'propose':
                    $post->status = 'Proposed';
                    break;
            }
        
            $post->save();
        
            \Log::info('Statut mis à jour : ' . $post->status);
        
            // Retourner une réponse JSON
            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès',
                'status' => $post->status,
            ]);
        }

        public function approveComment(Post $article, Message $comment)
        {
            $comment->update(['approved' => true]);
            return redirect()->route('articles.show', $article)->with('success', 'Comment approved.');
        }
    
        public function rejectComment(post $article, Message $comment)
        {
            $comment->delete();
            return redirect()->route('articles.show', $article)->with('success', 'Comment rejected.');
        }
}
        
