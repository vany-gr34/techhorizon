@extends('invite.layouat')

@section('title', 'invite.login')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            color: #1e3a8a;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .welcome-message {
            color: #3b82f6;
            text-align: center;
            margin-bottom: 1.5rem;
            font-style: italic;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            color: #1e3a8a;
            margin-bottom: 0.5rem;
        }
        input {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            font-size: 1rem;
        }
        button {
            background-color: #1e3a8a;
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #1e40af;
        }
        .error {
            color: #ef4444;
            margin-top: -0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Connexion</h1>
        <p class="welcome-message">Bienvenue ! Nous sommes ravis de vous revoir.</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>

