@extends('layout')

@section('title', 'Suivi de mes Articles')

@section('content')

<style>

:root {
  --primary-color: #3498db;
  --secondary-color: #2c3e50;
  --background-color: #ecf0f1;
  --text-color: #34495e;
  --card-bg: #fff;
  --pending-color: #f39c12;
  --accepted-color: #2ecc71;
  --rejected-color: #e74c3c;
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
  max-width: 1000px;
  margin: 50px auto;
  padding: 40px;
}

h1 {
  text-align: center;
  color: var(--secondary-color);
  font-size: 2.5rem;
  margin-bottom: 40px;
  font-weight: 600;
}

.status-section {
  margin-bottom: 40px;
}

h2 {
  color: var(--primary-color);
  font-size: 1.8rem;
  margin-bottom: 20px;
  font-weight: 500;
  border-bottom: 2px solid var(--primary-color);
  padding-bottom: 10px;
}

.post {
  background-color: var(--card-bg);
  border-radius: 12px;
  padding: 25px;
  margin-bottom: 20px;
  box-shadow: var(--shadow);
  transition: var(--transition);
}

.post:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
}

.post h3 {
  color: var(--secondary-color);
  font-size: 1.4rem;
  margin-bottom: 15px;
  font-weight: 600;
}

.post p {
  margin: 10px 0;
  font-size: 1rem;
}

.post strong {
  font-weight: 600;
}

.pending {
  border-left: 5px solid var(--pending-color);
}

.accepted {
  border-left: 5px solid var(--accepted-color);
}

.rejected {
  border-left: 5px solid var(--rejected-color);
}

.post p:last-child {
  margin-bottom: 0;
}

@media (max-width: 768px) {
  .container {
    padding: 20px;
    margin: 30px 15px;
  }

  h1 {
    font-size: 2rem;
  }

  h2 {
    font-size: 1.5rem;
  }

  .post {
    padding: 20px;
  }

  .post h3 {
    font-size: 1.2rem;
  }
}

</style>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<div class="container">
    <h1>Suivi de mes Articles</h1>

    <!-- Articles en attente -->
    <div class="status-section">
        <h2> Articles en attente</h2>
        @foreach($posts->where('stat', 'pending') as $post)
            <div class="post pending">
                <h3>{{ $post->title }}</h3>
                <p>Catégorie: {{ $post->category->name }}</p>
                <p>Status: <strong>{{ $post->stat }}</strong></p>
                <p>Publié le: {{ $post->created_at->format('d M Y') }}</p>
            </div>
        @endforeach
    </div>

    <!-- Articles acceptés -->
    <div class="status-section">
        <h2>Articles acceptés</h2>
        @foreach($posts->where('stat', 'accepted') as $post)
            <div class="post accepted">
                <h3>{{ $post->title }}</h3>
                <p>Catégorie: {{ $post->category->name }}</p>
                <p>Status: <strong>{{ $post->status }}</strong></p>
                <p>Publié le: {{ $post->created_at->format('d M Y') }}</p>
            </div>
        @endforeach
    </div>

    <!-- Articles rejetés -->
    <div class="status-section">
        <h2> Articles rejetés</h2>
        @foreach($posts->where('stat', 'Rejected') as $post)
            <div class="post rejected">
                <h3>{{ $post->title }}</h3>
                <p>Catégorie: {{ $post->category->name }}</p>
                <p>Status: <strong>{{ $post->status }}</strong></p>
                <p>Publié le: {{ $post->created_at->format('d M Y') }}</p>
            </div>
        @endforeach
    </div>
</div>

