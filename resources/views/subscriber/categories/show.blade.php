@extends('layout')
@section('title', $category->name)
@section('content')



<style>
:root {
  --primary-color:rgb(3, 53, 86);
  --secondary-color: #2c3e50;
  --accent-color: #e74c3c;
  --background-color: #ecf0f1;
  --text-color:rgb(2, 22, 43);
  --card-bg:rgb(255, 255, 255);
}

body {
  font-family: 'Roboto', sans-serif;
  background: linear-gradient(135deg, var(--background-color) 0%, #bdc3c7 100%);
  color: var(--text-color);
  margin: 0;
  padding: 0;
  min-height: 100vh;
}

.category-container {
  max-width: 1200px;
  margin: 40px auto;
  padding: 30px;
  background-color: rgba(255, 255, 255, 0.9);
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  backdrop-filter: blur(10px);
}

h1 {
  font-size: 3em;
  color: var(--secondary-color);
  text-align: center;
  margin-bottom: 20px;
  position: relative;
  padding-bottom: 15px;
}

h1::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 100px;
  height: 4px;
  background: linear-gradient(to right, var(--primary-color), var(--accent-color));
  border-radius: 2px;
}

p {
  font-size: 1.1em;
  line-height: 1.6;
  text-align: center;
  max-width: 800px;
  margin: 0 auto 30px;
}

.subscription-actions {
  text-align: center;
  margin-bottom: 40px;
}

.btn {
  padding: 12px 25px;
  font-size: 1em;
  border: none;
  border-radius: 50px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: bold;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.btn-primary {
  background: linear-gradient(45deg, var(--primary-color), #2980b9);
  color: white;
}

.btn-danger {
  background: linear-gradient(45deg, var(--accent-color), #c0392b);
  color: white;
}

.btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
}

.posts {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 30px;
}

.post {
  background-color: var(--card-bg);
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  position: relative;
}

.post:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

.post-image {
  height: 200px;
  overflow: hidden;
}

.post-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.post:hover .post-image img {
  transform: scale(1.1);
}

.post h2 {
  padding: 20px 20px 10px;
  margin: 0;
  font-size: 1.4em;
}

.post h2 a {
  color: var(--secondary-color);
  text-decoration: none;
  transition: color 0.3s ease;
}

.post h2 a:hover {
  color: var(--primary-color);
}

.post p {
  padding: 0 20px 20px;
  margin: 0;
  font-size: 0.9em;
  color: #7f8c8d;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.post {
  animation: fadeIn 0.5s ease forwards;
  opacity: 0;
}

.post:nth-child(1) { animation-delay: 0.1s; }
.post:nth-child(2) { animation-delay: 0.2s; }
.post:nth-child(3) { animation-delay: 0.3s; }
.post:nth-child(4) { animation-delay: 0.4s; }
.post:nth-child(5) { animation-delay: 0.5s; }

@media (max-width: 768px) {
  .category-container {
    padding: 20px;
    margin: 20px;
  }

  h1 {
    font-size: 2.5em;
  }

  .posts {
    grid-template-columns: 1fr;
  }
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="category-container">
        <h1>{{ $category->name }}</h1>
        <div class="subscription-actions">
    <button id="subscribeButton" class="{{ $isSubscribed ? 'btn btn-danger' : 'btn btn-primary' }}" 
            onclick="toggleSubscription('{{ $category->id }}')">
        {{ $isSubscribed ? 'Se désabonner' : 'S\'abonner' }}
    </button>
</div>

        <!-- Liste des articles dans cette catégorie -->
        <div class="posts">
        @foreach($posts as $post)
        <div class="post">
            <div class="post-image">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid">
            </div>
            <h2><a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a></h2>
            <p>{{ $post->summary }}</p>
        </div>
        @endforeach
        </div>
</div>



<script>
    function toggleSubscription(categoryId) {
        fetch(`/categories/${categoryId}/subscribe`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            const button = document.getElementById('subscribeButton');
            if (data.subscribed) {
                button.classList.remove('btn-primary');
                button.classList.add('btn-danger');
                button.textContent = 'Se désabonner';
            } else {
                button.classList.remove('btn-danger');
                button.classList.add('btn-primary');
                button.textContent = 'S\'abonner';
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
</script>

@endsection