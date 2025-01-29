@extends('editor.layout')


@section('title', 'Proposed Articles')

@section('content')
<link rel="stylesheet" href="{{ asset('css/proposed.css') }}">

<h1>Créer une Nouvelle Collection</h1>

<!-- Formulaire pour créer une collection -->
<form method="POST" action="{{ route('collections.createFromSelected') }}">
    @csrf

    <div class="articles-container">
        @foreach ($proposedArticles as $post)
            @php
                $imagePath = str_replace('\\', '/', $post->image);
            @endphp

            <div class="article-box" data-image="{{ asset('storage/' . $imagePath) }}" 
            data-url="{{ url('/posts/post' . $post->id) }}">
            
        <div class="checkbox-container">
        <input type="checkbox" name="selected_articles[]" value="{{ $post->id }}">
       </div>

    <!-- Contenu de l'article -->
       <div class="article-content">
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->summary }}</p>
        <p><strong>Thème:</strong> {{ $post->category->name }}</p>
     </div>
</div>

        @endforeach
    </div>
 <!-- Champs pour le nom de la nouvelle collection -->
 <div>
            <label for="collection-name">Nom de la Nouvelle Collection :</label>
            <input type="text" name="collection_name" id="collection-name" required>
        </div>

        <button type="submit">Créer la Collection</button>
    </form>
   <script> document.addEventListener('DOMContentLoaded', function () {
    // Sélectionner toutes les cases à cocher dans les articles
    const checkboxes = document.querySelectorAll('.checkbox-container input[type="checkbox"]');

    checkboxes.forEach(checkbox => {
        // Empêcher la propagation de l'événement click
        checkbox.addEventListener('click', function (event) {
            event.stopPropagation();
        });
    });

    // Activer le clic pour les autres parties du div article-box
    const articleBoxes = document.querySelectorAll('.article-box');
    articleBoxes.forEach(box => {
        box.addEventListener('click', function () {
            const url = box.getAttribute('data-url');
            if (url) {
                window.location.href = url;
            }
        });
    });
});
</script>
    <script src="{{ asset('js/invite.js') }}"></script>
@endsection
