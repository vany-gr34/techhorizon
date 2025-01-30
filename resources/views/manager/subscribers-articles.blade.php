
@extends('manager.layout')
@section('header-title', 'Subscribers Articles Space')
@section('content')
<link href="{{ asset('css/subscribers-articles.css') }}" rel="stylesheet">
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>
                        <span id="status-{{ $post->id }}">
                            {{ $post->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('manager.article.show', $post->id) }}" class="btn btn-primary">View</a>
                        <form id="form-{{ $post->id }}" onsubmit="updateStatus(event, {{ $post->id }})" style="display:inline;">
                            @csrf
                            <button type="submit" name="action" value="accept" class="btn btn-success">Accept</button>
                            <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                            <button type="submit" name="action" value="propose" class="btn btn-info">Propose</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Aucun article trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function updateStatus(event, postId) {
    event.preventDefault();
    
    const form = event.target;
    const action = event.submitter.value;
    const token = document.querySelector('input[name="_token"]').value;
    
    // Utilisation de la route correcte
    fetch(`/manager/post/update-status/${postId}`,{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            action: action,
            _token: token
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            const statusSpan = document.getElementById(`status-${postId}`);
            
            // Supprimer toutes les classes bg- existantes
            statusSpan.classList.remove('bg-warning', 'bg-success', 'bg-danger', 'bg-info');
            
            // Ajouter la nouvelle classe en fonction de l'action
            switch(action) {
                case 'accept':
                    statusSpan.classList.add('bg-success');
                    statusSpan.textContent = 'Accepted';
                    break;
                case 'reject':
                    statusSpan.classList.add('bg-danger');
                    statusSpan.textContent = 'Rejected';
                    break;
                case 'propose':
                    statusSpan.classList.add('bg-info');
                    statusSpan.textContent = 'Proposed';
                    break;
            }
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue lors de la mise à jour du statut');
    });
}
</script>
@endsection