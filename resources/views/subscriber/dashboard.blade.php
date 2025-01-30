<!-- resources/views/subscriber/home.blade.php -->

@extends('layout')

@section('title', 'Accueil')

@section('content')
<style>
    
:root {
    --primary-blue: #6c73b9;
    --primary-dark: #012970;
    --text-color: #444444;
    --light-bg: #f6f9ff;
  }
body {
    font-family: Arial, sans-serif;
    background-color:--light-bg;
    color: #333;
    line-height: 1.6;
    padding: 20px;
}

h1, h2 {
    color:rgb(9, 28, 48);
}




li:hover {
    background-color: #e8f0fe;
    transform: translateX(5px);
    
}

li::before {
    color:rgb(73, 91, 114);
    font-weight: bold;
    font-size: 1.2em;
    margin-right: 10px;
}

li a {
    color: #202124;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
    flex-grow: 1;
}

li a:hover {
    color: #1a73e8;
}

@media (max-width: 768px) {
    ul {
        max-width: 100%;
        padding: 0 15px;
    }
    
    li {
        padding: 10px 12px;
    }
}











 .articles-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    padding: 50px;
    background: var(--light-bg);
  }
  
  .article-box {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    position: relative;
    min-height: 300px;
    cursor: pointer;
  }
  
  .article-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: var(--bg-image); /* Utilise la variable CSS */
    background-size: cover;
    background-position: center;
    z-index: 1; /* Place l'arrière-plan derrière le contenu */
  }
  .article-box input[type="checkbox"] {
    margin-right: 10px; /* Un espace entre la case à cocher et le contenu */
    transform: scale(1.2); /* Rendre la case plus visible, si nécessaire */
}
  
  .article-content {
    position: relative;
    padding: 20px;
    background: rgba(255, 255, 255, 0.9);
    height: 100%;
    transform: translateY(60%);
    transition: transform 0.3s ease;
    z-index: 2; /* Place le contenu au-dessus de l'arrière-plan */
  }
  
  .article-box:hover .article-content {
    transform: translateY(0);
  }
  
  .article-content h2 {
    color: var(--primary-dark);
    margin: 0 0 15px 0;
    font-size: 20px;
  }
  
  .article-content p {
    margin: 10px 0;
    color: var(--text-color);}





:root {
    --primary-blue: #6c73b9;
    --primary-dark: #012970;
    --text-color: #444444;
    --light-bg: #f6f9ff;
  }
  
  /* Base styles */

  
  /* Navigation/Header Styles */
  #home {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #fff;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);

  }
  
  
  #home h1 {
    margin: 0;
    font-size: 30px;
    color: var(--primary-dark);
    padding-left: 50px;
  }
  
  #home h1 span {
    color: var(--primary-blue);
  }
  
  #bar {
    display: flex;
    justify-content: flex-end;
    padding-right: 50px;
  }
  
  #bar ul {
    list-style: none;
    display: flex;
    gap: 30px;
    margin: 0;
    padding: 20px 0;
  }
  .dikchi{
    display: flex;
    align-items: center;
    padding: 20px;

  }
  ul {
    display: flex;
    flex-wrap: wrap;
    list-style-type: none;
    padding: 0;
    margin: 0;
}

li {
    margin-right: 20px;
    margin-bottom: 10px;
}

li:last-child {
    margin-right: 0;
}

li a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
}

li a:hover {
    color: #007bff;
}
  #bar button {
    text-decoration: none;
    color: var(--primary-dark);
    font-weight: 600;
    transition: color 0.3s;
  }
  
  #bar a:hover {
    color: var(--primary-blue);
  }
  
  
</style>

<div id="home">  
        <h1>Tec<span>h</span>orizon</h1>
        <div id="bar">
        <ul> 
        <li> <a href="{{ route('user.space') }}"> Profil</a>   </li>
            <li> <a href="{{ route('posts.create') }}">Add Article </a></li>
            <li>  <a href="{{ route('posts.status') }}">My Articles </button></li>
            <li></li>
        </ul></div>
    </div>
    @if(isset($categories) && !$categories->isEmpty())
        <ul>
            @foreach($categories as $category)
            <li>
              <i class="dikchi"></i>
                    <a href="{{ route('category.show', ['id' => $category->id]) }}">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucune catégorie disponible pour l'instant.</p>
    @endif
    
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<h1>Recommandations</h1>
<div class="articles-container">
    @foreach ($posts as $post)
        @php
            $imagePath = str_replace('\\', '/', $post->image);
        @endphp
        <div class="article-box" data-image="{{ asset('storage/' . $imagePath) }}" data-url="{{ route('post.show', ['id' => $post->id]) }}">

            <!-- Contenu de l'article -->
            <div class="article-content">
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->summary }}</p>
                <p><strong>Thème:</strong> {{ $post->category->name }}</p>
                <p><strong>Statut:</strong> 
                    @if ($post->status == 'public')
                        <span style="color: green; font-weight: bold;">Public</span>
                    @else
                        <span style="color: red; font-weight: bold;">Privé</span>
                    @endif
                </p>
               
                
            </div>
        </div>
    @endforeach
</div>
@foreach ($collections as $collection)
            <div class="collection-container">
                <h3>
                    {{ $collection->collection }}
                   
                </h3>
                <div class="articles-container">
                    @foreach ($collection->posts as $post)
                        @php
                            $imagePath = str_replace('\\', '/', $post->image);
                        @endphp

                        <div class="article-box" 
                             data-image="{{ asset('storage/' . $imagePath) }}" 
                             data-url="{{ route('post.show', ['id' => $post->id]) }}">
                            <div class="article-content">
                                <h4>{{ $post->title }}</h4>
                                <p>{{ $post->summary }}</p>
                                <p><strong>Thème:</strong> {{ $post->category->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
  @endforeach
<script >document.addEventListener('DOMContentLoaded', function () {
    const articleBoxes = document.querySelectorAll('.article-box');

    articleBoxes.forEach(box => {
        // Définir l'image de fond
        const imagePath = box.getAttribute('data-image');
        box.style.setProperty('--bg-image', `url('${imagePath}')`);

        // Ajouter un écouteur d'événement pour le clic
        box.addEventListener('click', function () {
            const articleUrl = box.getAttribute('data-url');
            window.location.href = articleUrl; // Rediriger vers l'URL de l'article
        });
    });
});</script>
@endsection

