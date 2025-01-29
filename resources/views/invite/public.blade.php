@extends('invite.layouat')

@section('content')

<link rel="stylesheet" href="{{ asset('css/invite.css') }}">

@foreach ($categories as $category)
    <div class="category">
        <h2>{{ $category->name }}</h2>

        @if ($category->posts->count() > 0)
            <div class="articles-container">
                @foreach ($category->posts as $post)
                    @php
                        $imagePath = str_replace('\\', '/', $post->image);
                    @endphp

                    <div class="article-box" 
                         data-image="{{ asset('storage/' . $imagePath) }}" 
                         data-url="{{ url('/posts/post' . $post->id) }}">
                        <div class="article-content">
                            <h2>{{ $post->title }}</h2>
                            <p>{{ $post->summary }}</p>
                            <p><strong>Thème:</strong> {{ $post->category->name }}</p> <!-- Accéder à la relation category -->
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>Aucun article public disponible pour cette catégorie.</p>
        @endif
    </div>
@endforeach

<script src="{{ asset('js/invite.js') }}"></script>
@endsection
