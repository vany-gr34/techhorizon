@extends('layout')

@section('title', 'Suivi de mes Articles')

@section('content')

<style>
/* Style général */
body {
    font-family: 'Arial', sans-serif;
    background-color: #e3f2fd; /* Bleu clair */
    margin: 0;
    padding: 0;
    color: #0d47a1; /* Bleu foncé */
    line-height: 1.6;
}

/* Conteneur principal */
.container {
    max-width: 900px;
    margin: 50px auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Titre principal */
h1 {
    text-align: center;
    color: #0d47a1;
    font-size: 2rem;
    margin-bottom: 30px;
}

/* Carte pour chaque article */
.post {
    background: #f6fbff; /* Bleu très clair */
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #90caf9; /* Bordure bleu clair */
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.post:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Titre de l'article */
.post h3 {
    color: #1565c0; /* Bleu moyen */
    margin-bottom: 10px;
    font-size: 1.5rem;
}

/* Informations de l'article */
.post p {
    margin: 5px 0;
    color: #0d47a1;
}

/* Statut de l'article en gras */
.post strong {
    color: #1565c0;
    font-weight: bold;
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        padding: 20px;
    }

    h1 {
        font-size: 1.8rem;
    }

    .post h3 {
        font-size: 1.3rem;
    }
}
</style>
<div class="container">
    <h1>Suivi de mes Articles</h1>

    <!-- Articles en attente -->
    <div class="status-section">
        <h2> Articles en attente</h2>
        @foreach($posts->where('stat', 'pending') as $post)
            <div class="post pending">
                <h3>{{ $post->title }}</h3>
                <p>Catégorie: {{ $post->category->name }}</p>
                <p>Status: <strong>{{ $post->stat }}</strong></p>
                <p>Publié le: {{ $post->created_at->format('d M Y') }}</p>
            </div>
        @endforeach
    </div>

    <!-- Articles acceptés -->
    <div class="status-section">
        <h2>Articles acceptés</h2>
        @foreach($posts->where('stat', 'accepted') as $post)
            <div class="post accepted">
                <h3>{{ $post->title }}</h3>
                <p>Catégorie: {{ $post->category->name }}</p>
                <p>Status: <strong>{{ $post->status }}</strong></p>
                <p>Publié le: {{ $post->created_at->format('d M Y') }}</p>
            </div>
        @endforeach
    </div>

    <!-- Articles rejetés -->
    <div class="status-section">
        <h2> Articles rejetés</h2>
        @foreach($posts->where('stat', 'Rejected') as $post)
            <div class="post rejected">
                <h3>{{ $post->title }}</h3>
                <p>Catégorie: {{ $post->category->name }}</p>
                <p>Status: <strong>{{ $post->status }}</strong></p>
                <p>Publié le: {{ $post->created_at->format('d M Y') }}</p>
            </div>
        @endforeach
    </div>
</div>

