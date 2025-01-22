<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Interest;
use App\Models\category;

class RegistrationController extends Controller
{
    // Step 1: Choose Role
    public function showStep1()
    {
        return view('inscription.step1');
    }

    public function processStep1(Request $request)
    {
        $request->validate(['role' => 'required|in:manager,subscriber']);
        $request->session()->put('role', $request->role);
        return redirect()->route('inscription.step2');
    }

    // Step 2: Personal Information
    public function showStep2()
    {
        return view('inscription.step2');
    }

    public function processStep2(Request $request)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);
     $role = $request->session()->get('role');
    // Store the data in the session
    $request->session()->put([
        'role' => $role,
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => $request->input('password'), // Store the password in the session
    ]);

    // Redirect based on the role selected in Step 1
   

    if ($role === 'subscriber') {
        return redirect()->route('inscription.step3'); // Redirect to Step 3 for subscribers
    } elseif ($role === 'manager') {
        return redirect()->route('inscription.stepM3'); // Redirect to Step M3 for managers
    }

    // Default fallback redirection
    return redirect('/')->with('error', 'Invalid role selected.');
}
    // Step 3: Interests
    public function showStep3()
    {
        $interests = Interest::all(); // Fetch predefined interests
        return view('inscription.step3', compact('interests'));
    }
    public function showStepM3()
    {
        return view('inscription.stepM3'); // Ensure the view exists at resources/views/inscription/stepM3.blade.php
    }
    public function processStep3(Request $request)
{
    // Validate the selected interests
    $request->validate([
        'interests' => 'required|array', // Ensure at least one interest is selected
        'interests.*' => 'exists:interests,id', // Ensure all selected interests exist in the database
    ]);

    // Create the user with data from the session
    $user = User::create([
        'role' => $request->session()->get('role'),
        'name' => $request->session()->get('name'),
        'email' => $request->session()->get('email'),
        'password' => bcrypt($request->session()->get('password')), // Hash the password
    ]);

    // Attach the selected interests to the user (using a many-to-many relationship)
    $user->interests()->sync($request->interests);

    // Clear the session data (optional)
    $request->session()->forget(['role', 'name', 'email', 'password']);
    

    // Redirect to the posts page with a success message
    return redirect()->route('subscriber.dashboard')->with('success', 'Inscription completed!');
}

    public function processStepM3(Request $request)
{
    // Validate the category creation form
    $request->validate([
        'category_name' => 'required|string|max:255',
    ]);

    // Create the user with data from the session
    $user = User::create([
        'role' => $request->session()->get('role'),
        'name' => $request->session()->get('name'),
        'email' => $request->session()->get('email'),
        'password' => bcrypt($request->session()->get('password')), // Hash the password
    ]);

    // Create the category for the manager
    $category = Category::create([
        'name' => $request->input('category_name'),
        'manager_id' => $user->id, // Associate the category with the manager
    ]);

    // Clear the session data (optional)
    $request->session()->forget(['role', 'name', 'email', 'password']);

    // Redirect to the manager dashboard
    return redirect()->route('manager.dashboard')->with('success', 'Category created and registration completed!');
}}