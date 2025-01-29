<!-- resources/views/subscriber/posts/show.blade.php -->
<!-- resources/views/subscriber/posts/show.blade.php -->

@extends('layout')

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
            <div class="post-meta">
                <p id="rating-count">{{ $post->ratings->count() }} vote(s)</p>
                <div class="post-rating">
                    <h3>Évaluer cet article</h3>
                    <div id="rating-stars" class="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star" data-value="{{ $i }}">&#9733;</span>
                        @endfor
                    </div>
                    <p id="rating-message"></p>
                </div>
            </div>
        </article>

        <section class="post-chat">
            <h2>Discussion</h2>
            <form action="{{ route('posts.addMessage', $post->id) }}" method="POST" class="chat-form">
                @csrf
                <textarea name="message" id="message" rows="4" required placeholder="Ajouter un message..."></textarea>
                <button type="submit">Envoyer</button>
            </form>
            <div class="chat-messages">
                @foreach($post->messages as $message)
                    <div class="message">
                        <div class="message-header">
                            <strong>{{ $message->user->name }}</strong>
                            <small>{{ $message->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <p>{{ $message->content }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </div>




<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star');
        let currentRating = {{ $userRating ?? 0 }}; // Note actuelle de l'utilisateur

        function highlightStars(rating) {
            stars.forEach(star => {
                star.classList.toggle('active', star.dataset.value <= rating);
            });
        }

        highlightStars(currentRating);

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const rating = this.dataset.value;
                fetch("{{ route('posts.rate', $post->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ rating: rating })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        highlightStars(rating);
                        document.getElementById('rating-message').innerText = "Merci pour votre évaluation !";
                    }
                })
                .catch(error => console.error('Erreur:', error));
            });
        });
    });
</script>

   
@endsection
