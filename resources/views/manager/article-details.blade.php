@extends('manager.layout')

@section('title', $post->title)
@section('header-title', 'DevOps Category')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/articleDetails.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

<div class="article-container">
    <div class="article-details">
        <div class="article-header">
            <h1>{{ $post->title }}</h1>
            <p><strong>Author:</strong> {{ $post->user ? $post->user->name : 'Unknown' }}</p>
            <p><strong>Publication date:</strong> {{ $post->created_at ? $post->created_at->format('d/m/Y') : 'N/A' }}</p>
        </div>

        <div class="content">
            {!! nl2br(e($post->content)) !!}
        </div>
    </div>

    <div class="comments-section">
        <h2>Comments</h2>
        @forelse($post->messages as $message)
            <div class="comment" id="comment-{{ $message->id }}">
                <div class="comment-content">
                    <p><strong>{{ $message->user ? $message->user->name : 'Anonymous' }}:</strong> {{ $message->content }}</p>
                    <p><small>{{ $message->created_at ? $message->created_at->format('d/m/Y H:i') : 'N/A' }}</small></p>
                </div>

                @if(auth()->user() && auth()->user()->isManager())
                    <div class="comment-actions">
                        <!-- Affichage du statut -->
                        @if($message->is_approved === 1)
                            <span class="status-approved" id="status-{{ $message->id }}">Approved <i class="fas fa-check-circle"></i></span>
                        @elseif($message->is_approved === 0)
                            <span class="status-rejected" id="status-{{ $message->id }}">Rejected <i class="fas fa-times-circle"></i></span>
                        @else
                            <span class="status-pending" id="status-{{ $message->id }}">Pending <i class="fas fa-clock"></i></span>
                        @endif

                        <!-- Boutons d'actions seulement si le commentaire est en attente -->
                        @if(is_null($message->is_approved))
                            <form action="{{ route('manager.messages.approve', [$post->id, $message->id]) }}" method="POST" class="d-inline" id="approve-form-{{ $message->id }}">
                                @csrf
                                <button type="button" class="btn-approve" onclick="approveMessage('{{ $message->id }}')">Approve</button>
                            </form>
                            <form action="{{ route('manager.messages.reject', [$post->id, $message->id]) }}" method="POST" class="d-inline" id="reject-form-{{ $message->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-reject" onclick="rejectMessage('{{ $message->id }}')">Reject</button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <p class="no-comments">No comments yet.</p>
        @endforelse
    </div>
</div>

<script>
    function approveMessage(id) {
        fetch(`/post/{{ $post->id }}/message/${id}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`#status-${id}`).innerHTML = 'Approved <i class="fas fa-check-circle"></i>';
                document.querySelector(`#approve-form-${id}`).remove();
                document.querySelector(`#reject-form-${id}`).remove();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function rejectMessage(id) {
        fetch(`/post/{{ $post->id }}/message/${id}/reject`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`#status-${id}`).innerHTML = 'Rejected <i class="fas fa-times-circle"></i>';
                document.querySelector(`#approve-form-${id}`).remove();
                document.querySelector(`#reject-form-${id}`).remove();
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

@endsection
