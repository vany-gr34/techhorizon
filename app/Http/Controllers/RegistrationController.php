<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\category;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Interest;
class RegistrationController extends Controller
{
    
 // Étape 1 : Affichage du formulaire
 public function showStepOne()
 {
     return view('register.step1');
 }

 // Étape 1 : Traitement du formulaire
 public function processStepOne(Request $request)
 {
     $validated = $request->validate([
         'name' => 'required|string|max:255',
         'email' => 'required|email|unique:users,email',
         'password' => 'required|min:6|confirmed',
         'role' => 'required|in:subscriber,manager',
     ]);

     // Stocker temporairement les données en session
     Session::put('registration_data', $validated);

     return redirect()->route('register.step2');
 }

 // Étape 2 : Affichage selon le rôle
 public function showStepTwo()
 {
     $data = Session::get('registration_data');
     if (!$data) {
         return redirect()->route('register.step1');
     }

    
     $intersts = Interest::all(); 
     return view('register.step2', compact('data','intersts'));
 }

 // Étape 2 : Traitement selon le rôle
 public function processStepTwo(Request $request)
 {
     $data = Session::get('registration_data');
     if (!$data) {
         return redirect()->route('register.step1');
     }

     if ($data['role'] === 'subscriber') {
         $validated = $request->validate([
             'interests' => 'required|array',
         ]);
     } else {
         $validated = $request->validate([
             'category_name' => 'required|string|max:255|unique:categories,name',
         ]);
     }

     // Création de l'utilisateur
     $user = User::create([
         'name' => $data['name'],
         'email' => $data['email'],
         'password' => Hash::make($data['password']),
         'role' => $data['role'],
     ]);
        if ($data['role'] === 'subscriber') {
            $validated = $request->validate([
                'interests' => 'required|array',
            ]);
            $user->interests()->attach($validated['interests']);
        }
         else {
   
         Category::create([
             'name' => $validated['category_name'],
             'user_id' => $user->id,
         ]);
     }

    
     Session::forget('registration_data');

     return redirect()->route('login')->with('success', 'Inscription réussie.');
 }
}