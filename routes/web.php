<?php
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;

Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



Route::get('/posts/post{post}', function (Post $post) {
    return view('invite.post', [
        "post" => $post
    ]);
})->name('articles.shows');
Route::get('/choose-role', function () {
    return view('choose-role');
})->name('choose-role');

Route::middleware(['auth'])->group(function () {
    // Pour les éditeurs
    Route::get('/editor/dashboard', [EditorController::class, 'index'])->name('editor.dashboard');

    // Pour les managers
    Route::get('/manager/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');

    // Pour les abonnés
    Route::get('/subscriber/dashboard', [SubscriberController::class, 'recommendBasedOnInterests'])->name('subscriber.dashboard');
});

Route::get('/register', function () {
    return view('inscription.step1'); // Vérifiez que cette vue existe bien.
})->name('inscription.step1');

// Routes de l'inscription
Route::post('/register/step1', [RegistrationController::class, 'registerStep1'])->name('register.step1');
Route::post('/register/step2', [RegistrationController::class, 'registerStep2'])->name('register.step2');
Route::post('/register/submit', [RegistrationController::class, 'completeRegistration'])->name('register.submit');

// Route pour afficher le formulaire de sélection des articles
Route::get('/editor/proposed', [EditorController::class, 'proposedArticles'])
    ->name('editor.featured.form')
    ->middleware('auth'); // Protéger la route avec l'authentification



// Route pour afficher une collection spécifique
Route::get('/collection/{collection}', [EditorController::class, 'showCollection'])
    ->name('collection.show');
// awdi 9lk route 

Route::get('/editor/dashboard', [EditorController::class, 'dashboard'])->name('editor.dashboard');
Route::get('/editor/users', [EditorController::class, 'users'])->name('editor.users');
Route::get('/editor/articles', [EditorController::class, 'articles'])->name('editor.articles');
Route::get('/editor/subscribers', [EditorController::class, 'subscribers'])->name('editor.subscribers');
Route::get('/editor/managers',[EditorController::class, 'managers'])->name('editor.managers');

Route::post('/subscribers/{id}/delete', [EditorController::class, 'destroy'])->name('editor.subscribers.delete');
// routes/web.php (Laravel example)
Route::post('/editor/subscribers/{id}/block', [EditorController::class, 'block'])->name('subscribers.block');
Route::post('/editor/subscribers/{id}/unblock', [EditorController::class, 'unblock'])->name('subscribers.unblock');
Route::post('/editor/subscribers/{id}/edit', [EditorController::class, 'update'])->name('subscribers.update');


Route::get('/editor/subscribers/search', [SubscriberController::class, 'search'])->name('subscribers.search');

Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
Route::post('/editor/subscribers/add', [SubscriberController::class, 'addSubscriber'])->name('editor.subscribers.add');

Route::delete('/editor/subscribers/delete/{id}', [EditorController::class, 'destroy'])->name('editor.subscribers.delete');

// biggest part link between invite and editor :>
Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
Route::post('/collections/update-active', [CollectionController::class, 'updateActive'])->name('collections.updateActive');
Route::delete('/collections/{id}', [CollectionController::class, 'destroy'])->name('collections.destroy');

Route::get('/posts', [CollectionController::class, 'posts'])->name('invite.posts');
Route::get('/proposed-articles', [PostController::class, 'showProposed'])->name('proposed.articles');

Route::post('/collections/create-from-selected', [CollectionController::class, 'createFromSelected'])->name('collections.createFromSelected');
Route::get('/categories', [ManagerController::class, 'showcategories'])->name('categories.index');


Route::get('/articles', [EditorController::class, 'getAllArticles'])->name('articles.index');
Route::post('/articles/{id}/activate', [EditorController::class, 'activate'])->name('articles.activate');
Route::post('/categories/assign-manager', [EditorController::class, 'assignManager']);
Route::post('/managers/add', [EditorController::class, 'addManager'])->name('managers.add');
Route::get('/categories/search-manager', [EditorController::class, 'searchManager'])->name('categories.search-manager');
Route::delete('/categories/{categoryId}/delete', [EditorController::class, 'delete'])->name('categories.delete');
Route::post('/admin/managers/{id}/block', [ManagerController::class, 'blockManager'])->name('admin.managers.block');
Route::post('/admin/managers/{id}/unblock', [ManagerController::class, 'unblockManager'])->name('admin.managers.unblock');


// Routes pour les catégories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('category.show');



Route::post('/categories/{id}/toggle', [CategoryController::class, 'toggleSubscription'])->name('categories.toggleSubscription');
Route::get('/categories/subscribed', [CategoryController::class, 'subscribed'])->name('categories.subscribed');

// Page des catégories abonnées


// Routes pour les articles
Route::get('/posts/create', [SubscriberController::class, 'create'])->name('posts.create');


Route::post('/posts', [SubscriberController::class, 'storepost'])->name('posts.store');
Route::get('/posts/status', [SubscriberController::class, 'postStatus'])->name('posts.status');
Route::get('posts/{id}', [SubscriberController::class, 'show'])->name('posts.show');



// routes/web.php

Route::get('categories/subscribed', [CategoryController::class, 'subscribed'])->name('categories.subscribed');

// Routes pour les catégories
Route::post('/categories/{id}/subscribe', [SubscriberController::class, 'subscribeCategory'])->name('categories.subscribe');
Route::get('/categories/{id}', [SubscriberController::class, 'showCategory'])->name('category.show');

;
// Route pour le profil
Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');


Route::post('/categories/{id}/sub', [SubscriberController::class, 'toggleSubscription'])
    ->middleware('auth') 
    ->name('categories.abonne');

Route::get('/post/{id}', [SubscriberController::class, 'showpost'])->name('post.show');


// Route pour évaluer un post
Route::post('/posts/{id}/rate', [SubscriberController::class, 'ratePost'])->name('posts.rate');

// Route pour ajouter un message
Route::post('/posts/{id}/message', [SubscriberController::class, 'addMessage'])->name('posts.addMessage');

// Route pour afficher les catégories abonnées
Route::get('/categories/subscribed', [CategoryController::class, 'showSubscribed'])->name('subscriber.categories.subscribed');
Route::get('/user/space', [ProfileController::class, 'index'])
    ->middleware('auth')
    ->name('user.space');
    Route::delete('/user/space/unsubscribe/{category}', [ProfileController::class, 'unsubscribe'])
    ->middleware('auth')
    ->name('user.unsubscribe');
    Route::get('/categories/{id}/check-subscription', [SubscriberController::class, 'checkSubscription']);
    Route::get('/categories', [PostController::class, 'showpublic'])->name('public.index');

    Route::get('/manager/messages', [Managercontroller::class, 'messager'])->name('messages.index');
    Route::post('/messages/{id}/approve', [ManagerController::class, 'approve'])->name('messages.approve');
    Route::post('/messages/{id}/reject', [ManagerController::class, 'reject'])->name('messages.reject');
    Route::middleware(['auth'])->group(function () {
        // Pour les managers
        Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    
        Route::get('/manager/articles', [ManagerController::class, 'articles'])->name('manager.articles');
        Route::get('/manager/articles/{id}', [ManagerController::class, 'showArticle'])->name('manager.articles.show');
    });
    Route::get('/manager/subscribers', [ManagerController::class, 'showSubscribers'])->name('manager.subscribers');
    
    // Route pour la déconnexion
    Route::post('/manager/logout', [ManagerController::class, 'logout'])->name('manager.logout');
    
    
    // Route pour afficher les articles des abonnés
    Route::get('/manager/subscribers-articles', [ManagerController::class, 'subscribersArticles'])
        ->name('manager.subscribers-articles');
    
    // Route pour mettre à jour le statut d'un article
    Route::post('/manager/post/update-status/{id}', [ManagerController::class, 'updateArticleStatus'])
         ->name('manager.post.update-status');
    
    // Route pour afficher les détails d'un article
    Route::get('/manager/posts/{id}', [ManagerController::class, 'showArticle'])->name('manager.article.show');
    Route::get('/manager/most-rated-articles', [ManagerController::class, 'mostRatedArticles'])
        ->name('manager.mostRatedArticles')
        ->middleware('auth');
        
        Route::middleware('auth', 'manager')->group(function () {
            Route::post('/articles/{article}/comments/{comment}/approve', [ManagerController::class, 'approveComment'])->name('manager.comments.approve');
            Route::post('/articles/{article}/comments/{comment}/reject', [ManagerController::class, 'rejectComment'])->name('manager.comments.reject');
        });
    // Route pour afficher la liste des abonnés
    Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::delete('/subscribers/{id}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
    
    Route::middleware(['auth'])->group(function () {
    // Pour les éditeurs
    Route::get('/editor/dashboard', [EditorController::class, 'index'])->name('editor.dashboard');

    // Pour les managers
    Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');

    // Pour les abonnés
    Route::get('/subscriber/dashboard', [SubscriberController::class, 'index'])->name('subscriber.dashboard');
});


Route::get('/manager/layout', [ManagerController::class, 'showLayout'])
    ->name('manager.layout')
    ->middleware('auth'); // Ensures only logged-in users can access it
