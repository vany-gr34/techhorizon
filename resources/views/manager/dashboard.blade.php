@extends('manager.layout')

@section('title', 'Dashboard')

@section('header-title')
    Welcome To Your Space, {{ $headerTitle ?? 'Guest!' }}!
@endsection

@section('content')
    <div class="stats-grid">
        <div class="stat-box">
            <h3>Articles</h3>
            <p><a href="{{ route('manager.articles') }}">{{ $postCountForCategory }}</a></p>
        </div>
        <div class="stat-box">
            <h3>Subscribers</h3>
            <p><a href="{{ route('manager.subscribers') }}">{{ $subscribersCountForCategory }}</a></p>
        </div>
        <div class="stat-box">
            <h3>Top Rated</h3>
            <p><a href="{{ route('manager.mostRatedArticles') }}">{{ $mostRatedArticlesCount }}</a></p>
        </div>
        <div class="stat-box">
            <h3>Subscribers's Articles</h3>
            <p><a href="{{ route('manager.subscribers-articles') }}">{{ $subscribersArticlesCount }}</a></p>
        </div>
    </div>
@endsection