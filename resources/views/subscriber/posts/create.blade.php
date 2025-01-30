@extends('layout')

@section('title', 'Proposer un Article')

@section('content')
    <div class="container">


    <style>
:root {
  --primary-color: #3498db;
  --secondary-color: #2c3e50;
  --background-color: #ecf0f1;
  --text-color: #34495e;
  --input-bg: #fff;
  --input-border: #bdc3c7;
  --input-focus: #3498db;
  --button-hover: #2980b9;
  --shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  --transition: all 0.3s ease;
}

body {
  font-family: 'Poppins', sans-serif;
  background-color: var(--background-color);
  color: var(--text-color);
  line-height: 1.6;
  margin: 0;
  padding: 0;
}

.container {
  max-width: 800px;
  margin: 50px auto;
  background: var(--input-bg);
  padding: 40px;
  border-radius: 12px;
  box-shadow: var(--shadow);
}

h1 {
  text-align: center;
  color: var(--secondary-color);
  font-size: 2.5rem;
  margin-bottom: 30px;
  font-weight: 600;
}

form {
  display: grid;
  gap: 25px;
}

.form-group {
  position: relative;
}

label {
  display: block;
  font-weight: 500;
  margin-bottom: 8px;
  color: var(--secondary-color);
  transition: var(--transition);
}

input[type="text"],
textarea,
select,
input[type="file"] {
  width: 100%;
  padding: 12px;
  border: 2px solid var(--input-border);
  border-radius: 8px;
  font-size: 1rem;
  color: var(--text-color);
  background-color: var(--input-bg);
  transition: var(--transition);
}

input[type="text"]:focus,
textarea:focus,
select:focus {
  border-color: var(--input-focus);
  outline: none;
  box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
}

textarea {
  resize: vertical;
  min-height: 120px;
}

select {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2334495e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 16px;
}

input[type="file"] {
  padding: 10px;
  font-size: 0.9rem;
}

input[type="file"]::-webkit-file-upload-button {
  visibility: hidden;
  margin-right: 15px;
}

input[type="file"]::before {
  content: 'Choisir un fichier';
  display: inline-block;
  background: var(--primary-color);
  color: white;
  padding: 8px 12px;
  border-radius: 6px;
  cursor: pointer;
}

button[type="submit"] {
  width: 100%;
  padding: 14px 20px;
  background-color: var(--primary-color);
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
  text-transform: uppercase;
  letter-spacing: 1px;
}

button[type="submit"]:hover {
  background-color: var(--button-hover);
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

@media (max-width: 768px) {
  .container {
    padding: 30px;
    margin: 30px 15px;
  }

  h1 {
    font-size: 2rem;
  }

  input[type="text"],
  textarea,
  select,
  input[type="file"],
  button[type="submit"] {
    font-size: 0.95rem;
  }
}
</style>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
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
