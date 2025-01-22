@extends('invite.layouat')

@section('title', $post->title)

@section('content')
    <article>
        <h1>{{ $post->title }}</h1>
        <p><strong>Category:</strong> {{ $post->category->name ?? 'Uncategorized' }}</p>
        <p><strong>Author:</strong> {{ $post->user->name ?? 'Unknown' }}</p>
        <p>{{ $post->content }}</p>
        
        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" width="600">
        @endif

        <a href="/posts">Back home</a>
    </article>
@endsection
