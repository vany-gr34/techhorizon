<?php

namespace App\Http\Controllers;
use App\Models\post;
use Illuminate\Http\Request;
use App\Models\category;

class PostController extends Controller
{
    public function showProposed()
    {
        $proposedArticles = post::where('status', 'proposed')->get();
        return view('editor.proposed', compact('proposedArticles'));
    }  public function showPublic()
{
    $categories = Category::with(['posts' => function ($query) {
        $query->where('status', 'public');
    }])->get();

    return view('invite.public', compact('categories'));
}
  
public function articlesDesAbonnes()
{
    // Récupérer les articles avec le statut "pending"
    $posts = Post::where('stat', "pending")
        ->with('user') // Charger la relation avec l'auteur
        ->get();

    return view('manager.subscribers-articles', compact('posts'));
}

// Mettre à jour le statut d'un article


    public function updateArticleStatus(Request $request, $id)
    {
        // Find the article by ID
        $post = Post::findOrFail($id);

        // Get the action from the request
        $action = $request->input('action');

        // Update the article status based on the action
        switch ($action) {
            case 'accept':
                $post->status = 'accepted';
                break;
            case 'reject':
                $post->status = 'rejected';
                break;
            case 'propose':
                $post->status = 'proposed';
                break;
            default:
                return redirect()->back()->with('error', 'Invalid action.');
        }

        // Save the updated article
        $post->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Article status updated successfully.');
    }
}
    
