<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Interest;
use App\Models\category;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Interest;
use App\Models\Category;

class RegistrationController extends Controller
{
    public function registerStep1(Request $request)
    {
        // Valider les données de l'étape 1
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:subscriber,manager',
        ]);

        // Stocker temporairement les données dans la session
        session([
            'registration_data' => $request->only('name', 'email', 'password', 'role'),
        ]);

        return response()->json(['message' => 'Step 1 completed']);
    }

    public function registerStep2(Request $request)
{
    try {
        $role = session('registration_data')['role'] ?? null;

        if (!$role) {
            return response()->json(['error' => 'Session expired.'], 400);
        }

        if ($role === 'subscriber') {
            $interests = Interest::all();
            $html = view('inscription.step3', compact('interests'))->render();
        } else {
            $html = view('inscription.stepM3')->render();
        }

        return response()->json(['html' => $html]);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function completeRegistration(Request $request)
{
    // Vérifier si les données de session sont présentes
    $data = session('registration_data');
    if (!$data) {
        return redirect()->route('register.step1')->withErrors(['error' => 'Session expired. Please start the registration again.']);
    }

    // Vérification si l'email existe déjà
    $existingUser = User::where('email', $data['email'])->first();
    if ($existingUser) {
        return redirect()->back()->withErrors(['email' => 'The email address is already in use.']);
    }

    // Créer l'utilisateur
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'role' => $data['role'],
    ]);

    // Si l'utilisateur est un subscriber, attacher les intérêts
    if ($data['role'] === 'subscriber') {
        // Sauvegarder les intérêts
        $request->validate(['interests' => 'required|array']);
        $user->interests()->attach($request->interests);
        return redirect()->route('subscriber.dashboard')->with('success', 'Registration complete!');
    } else {
        // Sauvegarder la catégorie pour le manager
        $request->validate(['category_name' => 'required|string|max:255']);
        Category::create([
            'name' => $request->category_name,
            'user_id' => $user->id,
        ]);
        return redirect()->route('manager.dashboard')->with('success', 'Registration complete!');
    }

    // Nettoyer la session
    session()->flush();
}
}