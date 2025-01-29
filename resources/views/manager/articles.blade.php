@extends('manager.layout')

@section('title', 'Articles')
@section('header-title', 'DevOps articles')

@section('content')
    <!-- Inclure le fichier CSS articles.css -->
    <link rel="stylesheet" href="{{ asset('css/articles.css') }}">

    <div class="articles-list">
        @if ($posts->count() > 0)
            <ul>
            @foreach($posts as $post)
                <div class="article-item" style="background-image: url('{{ asset('images/' . $post->image) }}');">
                    <div class="article-overlay"></div>
                    <div class="article-content">
                        <a href="{{ route('manager.articles.show', $post->id) }}">
                            <h3>{{ $post->title }}</h3>
                        </a>

                        <div class="article-summary">
                            {{ Str::limit($post->content, 150) }}
                        </div>

                        <div class="article-main-content">
                            {{ Str::limit($post->content, 100) }}
                        </div>

                        <div class="article-rating">
                            Rating: {{ $post->mostRatedArticlesCount }}
                        </div>
                    </div>
                </div>
            @endforeach
            </ul>
        @else
            <div class="no-articles">
                <p>Aucun article trouvé.</p>
            </div>
        @endif
    </div>
@endsection
