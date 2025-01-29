@extends('editor.layout')

@section('title', 'Articles')

@section('content')
<link rel="stylesheet" href="{{ asset('css/proposed.css') }}">

<h1>Gérer les Articles</h1>

<!-- Conteneur des articles -->
<div class="articles-container">
    @foreach ($posts as $post)
        @php
            $imagePath = str_replace('\\', '/', $post->image);
        @endphp

        <div class="article-box" data-image="{{ asset('storage/' . $imagePath) }}" data-url="{{ url('/posts/post' . $post->id) }}">
            <!-- Contenu de l'article -->
            <div class="article-content">
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->summary }}</p>
                <p><strong>Thème:</strong> {{ $post->category->name }}</p>
                <p><strong>Statut:</strong> 
                    @if ($post->status == 'public')
                        <span style="color: green; font-weight: bold;">Public</span>
                    @else
                        <span style="color: red; font-weight: bold;">Privé</span>
                    @endif
                </p>
                <!-- Formulaire pour changer le statut -->
                @if ($post->status != 'public')
                    <form method="POST" action="{{ route('articles.activate', $post->id) }}">
                        @csrf
                        <button type="submit" style="background-color: blue; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">
                            Rendre Public
                        </button>
                    </form>
                @else
                    <button disabled style="background-color: grey; color: white; padding: 5px 10px; border: none; border-radius: 5px;">
                        Déjà Public
                    </button>
                @endif
            </div>
        </div>
    @endforeach
</div>

<script src="{{ asset('js/invite.js') }}"></script>
@endsection
