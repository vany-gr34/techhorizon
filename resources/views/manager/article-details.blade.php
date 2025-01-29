@extends('manager.layout')


@section('title', $post->title)
@section('header-title', 'DevOps Category')

@section('content')
<link rel="stylesheet" href="{{ asset('css/articleDetails.css') }}">
<div class="article-container">
    <div class="article-details">
        <div class="article-header">
            <h1>{{ $post->title }}</h1>
            <p><strong>Author:</strong> {{ $post->user ? $post->user->name : 'Unknown' }}</p>
            <p><strong>Publication date:</strong> {{ $post->created_at ? $post->created_at->format('d/m/Y') : 'N/A' }}</p>
        </div>
        
        <div class="content">
            {{ $post->content }}
            
        </div>
        
        <div class="rating-section">
            <p><strong>Rating:</strong> {{ $post->mostRatedArticlesCount ?? 'No ratings yet' }}</p>
        </div>
    </div>

    <div class="comments-section">
        <h2>Comments</h2>
        @forelse($post->comments as $comment)
            <div class="comment">
                <div class="comment-content">
                    <p><strong>{{ $comment->user ? $comment->user->name : 'Anonymous' }}:</strong> {{ $comment->content }}</p>
                    <p><small>{{ $comment->created_at ? $comment->created_at->format('d/m/Y H:i') : 'N/A' }}</small></p>
                </div>
                
                @if(auth()->user() && auth()->user()->isManager())
                    @if(!$comment->approved)
                        <div class="comment-actions">
                            <form action="{{ route('manager.comments.approve', [$post, $comment]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-approve">Approve</button>
                            </form>
                            <form action="{{ route('manager.comments.reject', [$post, $comment]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-reject">Reject</button>
                            </form>
                        </div>
                    @endif
                @endif
            </div>
        @empty
            <p class="no-comments">No comments yet.</p>
        @endforelse
    </div>
</div>
@endsection