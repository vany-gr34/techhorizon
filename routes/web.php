<?php
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;

Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/posts', function () {
    return view('invite.posts',[
        "posts"=> post::all()
    ]);
});
Route::get('/posts/post{post}', function (Post $post) {
    return view('invite.post', [
        "post" => $post
    ]);
});
Route::get('/choose-role', function () {
    return view('choose-role');
})->name('choose-role');

Route::middleware(['auth'])->group(function () {
    // Pour les éditeurs
    Route::get('/editor/dashboard', [EditorController::class, 'index'])->name('editor.dashboard');

    // Pour les managers
    Route::get('/manager/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');

    // Pour les abonnés
    Route::get('/subscriber/dashboard', [SubscriberController::class, 'index'])->name('subscriber.dashboard');
});

// Step 1: Choose Role
Route::get('/inscription/step1', [RegistrationController::class, 'showStep1'])->name('inscription.step1');
Route::post('/inscription/step1', [RegistrationController::class, 'processStep1'])->name('inscription.step1.submit');

// Step 2: Personal Information
Route::get('/inscription/step2', [RegistrationController::class, 'showStep2'])->name('inscription.step2');
Route::post('/inscription/step2', [RegistrationController::class, 'processStep2'])->name('inscription.step2.submit');

// Step 3: Interests (for subscribers)
Route::get('/inscription/step3', [RegistrationController::class, 'showStep3'])->name('inscription.step3');
Route::post('/inscription/step3', [RegistrationController::class, 'processStep3'])->name('inscription.step3.submit');

// Step M3: Create Category (for managers)
Route::get('/inscription/stepM3', [RegistrationController::class, 'showStepM3'])->name('inscription.stepM3');
Route::post('/inscription/stepM3', [RegistrationController::class, 'processStepM3'])->name('inscription.stepM3.submit');