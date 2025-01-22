<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('invite.login');
    }

    // Handle the login submission
    public function login(Request $request)
    {
        // Validate the login form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Check if the credentials are correct


        
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Authentication successful, log the user in
            Auth::login($user);

            // Redirect based on the user's role
            return $this->redirectUser($user);
        }

        // If authentication fails, redirect back with an error
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
            dd($request->all())
        ]);
    }

    // Redirect the user based on their role
    protected function redirectUser($user)
    {
        if ($user->role == 'editor') {
            return redirect()->route('editor.dashboard');
        } elseif ($user->role == 'manager') {
            return redirect()->route('manager.dashboard');
        } elseif ($user->role == 'subscriber') {
            return redirect()->route('subscriber.dashboard');
        }

        // Default redirect
        return redirect()->route('posts');
    }

    // Logout the user
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
