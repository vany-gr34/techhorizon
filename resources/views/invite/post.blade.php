@extends('invite.layouat')

@section('title', $post->title)

@section('content')
<link rel="stylesheet" href="{{ asset('css/post.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <div class="post-container">
        <article class="post-content">
            <h1>{{ $post->title }}</h1>
            <h2>{{ $post->summary }}</h2>
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="post-image">
            <p>{{ $post->content }}</p>
            </div>
        <a href="/posts">Back home</a>
    </article>
@endsection
