@extends('invite.layouat')

@section('title', 'Catégories')

@section('content')


<style>/* Style général de la page */
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    color: #333;
    margin: 0;
    padding: 20px;
}

/* Titre principal */
h1 {
    color: #1e90ff; /* Bleu Dodger */
    text-align: center;
    margin-bottom: 20px;
    font-size: 28px;
}

/* Liste des catégories */
ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

ul li {
    background-color: #e0f7ff; /* Fond bleu clair */
    padding: 10px 20px;
    border-radius: 5px;
    border: 1px solid #1e90ff; /* Bordure bleue */
    margin-bottom: 10px; /* Espace entre les catégories */
    transition: background-color 0.3s ease;
}

ul li:hover {
    background-color:rgb(163, 217, 241); /* Bleu plus clair au survol */
}

ul li a {
    color:rgb(27, 87, 147); /* Bleu Dodger */
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
}

ul li a:hover {
    text-decoration: underline;
}</style>
    <h1>Catégories</h1>
    <ul>
        @foreach($categories as $category)
        <li>
                    <a href="{{ route('category.show', ['id' => $category->id]) }}">
                        {{ $category->name }}
                    </a>
                </li>
        @endforeach
    </ul>
    
@endsection