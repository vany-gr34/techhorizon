@extends('editor.layout')

@section('title', 'Collections')

@section('content')
<link rel="stylesheet" href="{{ asset('css/numero.css') }}">

   
    <h2>Collection Active </h2>
    @if ($activeCollection)
        <div class="collection-container">
            <h3>{{ $activeCollection->collection }}</h3>
            <div class="articles-container">
                @foreach ($activeCollection->posts as $post)
                    @php
                        $imagePath = str_replace('\\', '/', $post->image);
                    @endphp

                    <div class="article-box" 
                         data-image="{{ asset('storage/' . $imagePath) }}" 
                         data-url="{{ url('/posts/post' . $post->id) }}">
                        <div class="article-content">
                            <h4>{{ $post->title }}</h4>
                            <p>{{ $post->summary }}</p>
                            <p><strong>Thème:</strong> {{ $post->category->name }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p>Aucune collection active pour le moment.</p>
    @endif

    <!-- Afficher les collections non actives -->
    <h2>Collections Non Actives</h2>
    <form method="POST" action="{{ route('collections.updateActive') }}">
        @csrf
        @method('POST')

        @foreach ($inactiveCollections as $collection)
            <div class="collection-container">
                <h3>
                    {{ $collection->collection }}
                    <input type="radio" name="active_collection" value="{{ $collection->id }}">
                </h3>
                <div class="articles-container">
                    @foreach ($collection->posts as $post)
                        @php
                            $imagePath = str_replace('\\', '/', $post->image);
                        @endphp

                        <div class="article-box" 
                             data-image="{{ asset('storage/' . $imagePath) }}" 
                             data-url="{{ url('/posts/post' . $post->id) }}">
                            <div class="article-content">
                                <h4>{{ $post->title }}</h4>
                                <p>{{ $post->summary }}</p>
                                <p><strong>Thème:</strong> {{ $post->category->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit">Mettre à jour la collection active</button> </form>
                <!-- Formulaire de suppression en dehors du formulaire principal -->
                <form method="POST" action="{{ route('collections.destroy', $collection->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette collection ?')">Supprimer</button>
               
            </div>
        @endforeach

       
    </form>
<script>document.addEventListener("DOMContentLoaded", () => {
  const articleContainers = document.querySelectorAll(".articles-container")
  const modal = document.getElementById("articleModal")
  const modalContent = document.getElementById("modalContent")
  const closeBtn = document.querySelector(".close")
  const collectionContainers = document.querySelectorAll(".collection-container")
  const radioButtons = document.querySelectorAll('input[type="radio"][name="active_collection"]')

  function updateSelectedCollection() {
    collectionContainers.forEach((container) => {
      container.classList.remove("selected")
    })

    radioButtons.forEach((radio) => {
      if (radio.checked) {
        const container = radio.closest(".collection-container")
        if (container) {
          container.classList.add("selected")
        }
      }
    })
  }

  radioButtons.forEach((radio) => {
    radio.addEventListener("change", updateSelectedCollection)
  })

  // Initial check for pre-selected radio button
  updateSelectedCollection()

  articleContainers.forEach((container) => {
    const articles = container.querySelectorAll(".article-box")
    articles.forEach((article, index) => {
      const image = article.getAttribute("data-image")
      article.style.setProperty("--bg-image", `url(${image})`)

      // Set initial stacked position
      article.style.transform = `translateZ(${-index * 50}px) translateY(${-index * 10}px)`
      article.style.zIndex = articles.length - index

      article.addEventListener("click", function (e) {
        e.stopPropagation()
        if (!container.classList.contains("spread")) {
          container.classList.add("spread")
          container.style.height = "auto"
          articles.forEach((a) => (a.style.transform = "none"))
        } else {
          // If already spread, show modal
          const url = this.getAttribute("data-url")
          const content = this.innerHTML
          modalContent.innerHTML = content
          openModal()
        }
      })
    })
  })

  // Click outside articles to stack them again
  document.addEventListener("click", (e) => {
    if (!e.target.closest(".articles-container")) {
      articleContainers.forEach((container) => {
        if (container.classList.contains("spread")) {
          container.classList.remove("spread")
          container.style.height = "300px"
          const articles = container.querySelectorAll(".article-box")
          articles.forEach((article, index) => {
            article.style.transform = `translateZ(${-index * 50}px) translateY(${-index * 10}px)`
          })
        }
      })
    }
  })

  closeBtn.onclick = closeModal

  window.onclick = (event) => {
    if (event.target == modal) {
      closeModal()
    }
  }

  function openModal() {
    modal.style.display = "block"
    setTimeout(() => {
      modal.classList.add("show")
    }, 10)
  }

  function closeModal() {
    modal.classList.remove("show")
    setTimeout(() => {
      modal.style.display = "none"
    }, 300)
  }
})


</script>

    <script src="{{ asset('js/invite.js') }}"></script>

@endsection