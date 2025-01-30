@extends('editor.layout')

@section('title', 'Dashboard')

@section('header-title')
    Happy to see you again 
    <span style="display: inline-block; margin-left: 5px;"><strong>{!! auth()->user()->name !!}</strong></span>
@endsection
@section('content')
    <div class="stats-grid">
        <div class="stat-box">
            <h3>Users</h3>
            <p>{{ $userCount }}</p>
        </div>

       
        <a href="{{ route('articles.index') }}"  style="text-decoration: none;">
        <div class="stat-box">
            <h3>Articles</h3>
            <p>{{ $articleCount }}</p>
        </div></a>
        <a href="{{ route('articles.index') }}"  style="text-decoration: none;">
        <div class="stat-box">
        <h3>private articles</h3>
        <p>{{  $privateCount }}</p>
        </div></a>
        <a href="{{ route('articles.index') }}"  style="text-decoration: none;">
        <div class="stat-box">
        <h3>public articles</h3>
        <p>{{ $publicCount}}</p>
        </div></a>
        <a href="{{ route('proposed.articles') }}" style="text-decoration: none;">
    <div class="stat-box" style="cursor: pointer;">
        <h3>Proposed Articles</h3>
        <p>{{ $proposedCount }}</p>
    </div>
</a> 

            
        <div class="stat-box">
            <h3>categories</h3>
            <p>{{ $catgoryCount }}</p>
        </div>


        <a href="{{ route('editor.subscribers') }}"  style="text-decoration: none;"><div class="stat-box">
            <h3>subscribers</h3>
            <p>{{ $subscribersCount }}</p>
        </div></a>
        
       
        <a href="{{ route('editor.managers') }}"  style="text-decoration: none;"> 
        <div class="stat-box">
            <h3>managers</h3>
            <p>{{ $managersCount }}</p>
        </div></a>
      
<a href="{{ route('collections.index') }}" style="text-decoration: none;">
<div class="stat-box">
            <h3>collections</h3>
            <p>{{ $collectionsCount}}</p>
        </div> 
        </a>
        
        
     
        
    </div>
    
@endsection
