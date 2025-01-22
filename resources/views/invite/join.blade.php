@extends('invite.layouat')

@section('title', 'Register')

@section('content')
    <h1>Register</h1>

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <input type="hidden" name="role" value="{{ $role }}">
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>
        <button type="submit">connexion</button>
    </form>
@endsection
