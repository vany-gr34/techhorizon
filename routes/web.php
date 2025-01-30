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
use App\Http\Controllers\HomeController;
use Symfony\Contracts\Service\Attribute\SubscribedService;

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
    Route::get('/editor/dashboard', [EditorController::class, 'index'])->name('editor.dashboard');
   
    Route::get('/subscriber/dashboard', [SubscriberController::class, 'recommendBasedOnInterests'])->name('subscriber.dashboard');
});


Route::get('/editor/proposed', [EditorController::class, 'proposedArticles'])
    ->name('editor.featured.form')
    ->middleware('auth'); 



Route::get('/collection/{collection}', [EditorController::class, 'showCollection'])
    ->name('collection.show');


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
Route::GET('/public', [PostController::class,'showPublic'])->name('public.index');


// routes/web.php

Route::get('categories/subscribed', [CategoryController::class, 'subscribed'])->name('categories.subscribed');

// Routes pour les catégories
Route::post('/categories/{id}/subscribe', [SubscriberController::class, 'subscribeCategory'])->name('categories.subscribe');
Route::get('/categories/{id}', [SubscriberController::class, 'showCategory'])->name('category.show');

;
// Route pour le profil
Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');




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
    Route::middleware(['auth'])->group(function () {
     //douae
        Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    
        Route::get('/manager/articles', [ManagerController::class, 'articles'])->name('manager.articles');
        Route::get('/manager/articles/{id}', [ManagerController::class, 'showArticle'])->name('manager.articles.show');
    });
    
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
   
        Route::get('/manager/subscribers', [SubscriberController::class, 'showSubscribers'])->name('manager.subscribers');
        Route::delete('category/{category}/subscriber/{userId}', [SubscriberController::class, 'destroy'])->name('manager.subscribers.destroy');
        Route::post('/post/{post}/message/{message}/approve', [ManagerController::class, 'approveComment'])->name('manager.messages.approve');
        Route::delete('/post/{post}/message/{message}/reject', [ManagerController::class, 'rejectComment'])->name('manager.messages.reject');
Route::get('/register', [RegistrationController::class, 'showStepOne'])->name('register.step1');
Route::post('/register', [RegistrationController::class, 'processStepOne']);

Route::get('/register/step2', [RegistrationController::class, 'showStepTwo'])->name('register.step2');
Route::post('/register/step2', [RegistrationController::class, 'processStepTwo']);


Route::post('/categories/{category}/subscribe', [SubscriberController::class, 'toggleSubscription'])
    ->middleware('auth');
