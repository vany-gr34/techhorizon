@extends('invite.layouat')

@section('title', 'Home')

@section('content')
 <link rel="stylesheet" href="{{ asset('css/invite.css') }}">
 
<div id="home">  
        <h1>Tec<span>h</span>orizon</h1>
        <div id="bar">
        <ul> 
        <li><a href="#aboutus">about us</a></li>
            <li><a href="{{ route('public.index')}}"> Categories</a></li>
            <li><a href="{{ route('register.step1') }}">Join Us</a></li>
            <li><a href="{{ url('/login') }}">Login</a></li>
        </ul></div>
    </div>
    @if ($activeCollection)
    <div class="articles-container">
        @foreach ($activeCollection->posts as $post)
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
    <p>Aucune collection active pour le moment.</p>
@endif
    <script src="{{ asset('js/invite.js') }}"></script>
   <h1 id=aboutus>About us</h1>
    <ul class="benefits">
        <li>🚀 Access exclusive content on AI, IoT, cybersecurity, and more.</li>
        <li>💡 Engage in discussions with experts and like-minded individuals.</li>
        <li>📅 Stay updated on the latest tech trends.</li>
        <li>🎁 Enjoy special offers and event invitations.</li>
    </ul>
    
    <div class="stats">
        <div class="stat">
            <span class="number">10,000+</span>
            <span class="label">Members</span>
        </div>
        <div class="stat">
            <span class="number">500+</span>
            <span class="label">Articles</span>
        </div>
        <div class="stat">
            <span class="number">100+</span>
            <span class="label">Events</span>
        </div>
    </div>
    <div class="why-join">
        <h2>Why Join TechHorizon?</h2>
        <p>
            TechHorizon is more than just a platform. It's a community where you can:
        </p>
        <ul>
            <li>Learn from the best tech experts.</li>
            <li>Share your knowledge and projects.</li>
            <li>Access exclusive resources to boost your career.</li>
            <li>Participate in free events and webinars.</li>
        </ul>
    </div>
    

@endsection