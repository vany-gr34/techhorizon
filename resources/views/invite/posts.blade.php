@extends('invite.layouat')

@section('title', 'Home')

@section('content')
    <div id="home">
        <h1>tec<span>h</span>orizon</h1>
        <ul>
            <li><a href="#">Categories</a></li>
            <li><a href="{{ route('inscription.step1') }}">Join Us</a></li>
            <li><a href="{{ url('/login') }}">Login</a></li>
        </ul>
    </div>

    <ul>
        @foreach ($posts as $post)
            <li>
                <h2>{!! $post->title !!}</h2>
                <p>{{ Str::limit($post->content, 100) }}</p> <!-- Display a short excerpt -->
                <a href="{{ url('/posts/post' . $post->id) }}">Read more</a> <!-- Link to the detailed view -->
            </li>
        @endforeach
    </ul>
@endsection