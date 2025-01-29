<?php

namespace App\Http\Controllers;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Models\post;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer la collection active
        $activeCollection = Collection::where('is_active', true)->with('posts.category')->first();

        // Récupérer les collections non actives
        $inactiveCollections = Collection::where('is_active', false)->with('posts.category')->get();

        return view('editor.numeros', [
            'activeCollection' => $activeCollection,
            'inactiveCollections' => $inactiveCollections,
        ]);
    }
    public function updateActive(Request $request)
{   
    // Récupérer l'ID de la collection sélectionnée depuis le formulaire
    $activeCollectionId = $request->input('active_collection');

    // Vérifier qu'une collection a bien été sélectionnée
    if (!$activeCollectionId) {
        return redirect()->back()->with('error', 'Veuillez sélectionner une collection à activer.');
    }

    // Désactiver toutes les collections
    Collection::query()->update(['is_active' => false]);

    // Activer uniquement la collection sélectionnée
    Collection::where('id', $activeCollectionId)->update(['is_active' => true]);

    return redirect()->back()->with('success', 'Collection activée avec succès.');
}

    

public function destroy($id)
{
    $collection = Collection::findOrFail($id);

    // Vérifier si la collection est active
    if ($collection->is_active) {
        return redirect()->back()->with('error', 'Impossible de supprimer la collection active.');
    }

    // Supprimer la collection
    $collection->delete();

    return redirect()->route('collections.index')->with('success', 'Collection supprimée avec succès.');
}
public function posts()
{
    $activeCollection = Collection::with('posts.category') // Récupère les articles et leurs catégories
        ->where('is_active', true)
        ->first();

    return view('invite.posts', compact('activeCollection'));
}
public function createFromSelected(Request $request)
{
    // Valider les données du formulaire
    $validated = $request->validate([
        'selected_articles' => 'required|array', // Liste d'articles sélectionnés
        'collection_name' => 'required|string|max:255', // Nom de la collection
    ]);

    // Créer la nouvelle collection
    $collection = Collection::create([
        'collection' => $validated['collection_name'],
        'is_active' => false, // Collection créée non active par défaut
    ]);

    // Mettre à jour les articles sélectionnés
    post::whereIn('id', $validated['selected_articles'])->update([
        'collection_id' => $collection->id, // Associer à la nouvelle collection
        'status' => 'public', // Changer leur statut à public
    ]);

    // Rediriger avec un message de succès
    return redirect()->route('collections.index')->with('success', 'Nouvelle collection créée avec succès et articles mis à jour.');
}




}
