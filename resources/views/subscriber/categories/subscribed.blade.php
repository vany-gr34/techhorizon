<!-- resources/views/subscriber/categories/subscribed.blade.php -->

@extends('layout')

@section('title', 'Catégories Abonnées')

@section('content')
<div class="subscribed-categories-container">
    <h1>Catégories Abonnées</h1>

    @if($categories->isNotEmpty())
        <ul>
            @foreach($categories as $category)
                <li>{{ $category->name }}</li>
            @endforeach
        </ul>
    @else
        <p>Vous n'êtes abonné à aucune catégorie pour l'instant.</p>
    @endif
</div>
@endsection
