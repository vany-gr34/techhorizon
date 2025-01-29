@extends('layout')

@section('title', 'Proposer un Article')

@section('content')
    <div class="container">


    <style>
/* Style général */
body {
    font-family: 'Arial', sans-serif;
    background-color: #e3f2fd; /* Bleu clair */
    margin: 0;
    padding: 0;
    color: #0d47a1; /* Bleu foncé */
    line-height: 1.6;
}

/* Conteneur principal */
.container {
    max-width: 800px;
    margin: 50px auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Titre principal */
h1 {
    text-align: center;
    color: #0d47a1;
    font-size: 2rem;
    margin-bottom: 20px;
}

/* Formulaire */
form {
    width: 100%;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #1565c0; /* Bleu moyen */
}

input[type="text"], textarea, select {
    width: 100%;
    padding: 10px;
    border: 1px solid #90caf9; /* Bordure bleue claire */
    border-radius: 5px;
    font-size: 1rem;
    color: #0d47a1;
    background-color: #f6fbff;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus, textarea:focus, select:focus {
    border-color: #1565c0;
    outline: none;
    box-shadow: 0 0 5px rgba(21, 101, 192, 0.3);
}

textarea {
    resize: vertical;
}

/* Boutons */
button[type="submit"] {
    display: inline-block;
    width: 100%;
    padding: 12px 20px;
    background-color: #1565c0; /* Bleu foncé */
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1.2rem;
    font-weight: bold;
    cursor: pointer;
    text-transform: uppercase;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

button[type="submit"]:hover {
    background-color: #0d47a1;
    transform: scale(1.02);
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        padding: 20px;
    }

    h1 {
        font-size: 1.8rem;
    }

    button[type="submit"] {
        font-size: 1rem;
    }
}
</style>
        <h1>Proposer un Article</h1>

        <!-- Formulaire de soumission d'un article -->
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Titre de l'Article</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="content">Contenu de l'Article</label>
                <textarea id="content" name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Catégorie</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">Sélectionnez une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
        <label for="image">Image de l'Article</label>
        <input type="file" id="image" name="image" class="form-control-file" accept="image/*">
    </div>
            <button type="submit" class="btn btn-primary">Soumettre l'Article</button>
        </form>
    </div>
@endsection
