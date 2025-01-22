@extends('invite.layouat')

@section('title', 'invite.login')

@section('content')
<h1>Connexion</h1>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required value="{{ old('email') }}">
        @error('email')
            <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        @error('password')
            <p>{{ $message }}</p>
        @enderror
    </div>

    <button type="submit">Se connecter</button>
</form>
@endsection
