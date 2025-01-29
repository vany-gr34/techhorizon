@extends('layout')

@section('content')
<head>
    <!-- FontAwesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<style>:root {
  --primary-blue:rgb(35, 51, 78);
  --secondary-blue: #60a5fa;
  --light-blue:rgb(160, 153, 202);
  --dark-blue:rgb(102, 106, 119);
  --bg-blue:rgb(204, 206, 207);
  --white: #ffffff;
}

body {
  font-family: 'Arial', sans-serif;
  background-color: var(--bg-blue);
  color: var(--dark-blue);
  margin: 0;
  padding: 0;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.user-header {
  text-align: center;
  margin-bottom: 3rem;
}

.user-icon {
  font-size: 6rem;
  color: var(--primary-blue);
  margin-bottom: 1rem;
}

h1 {
  color: var(--dark-blue);
  margin: 0;
}

.content-wrapper {
  display: flex;
  justify-content: space-between;
  gap: 2rem;
}

.sidebar {
  flex: 1;
  background-color: var(--white);
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.sidebar-title {
  display: flex;
  align-items: center;
  margin-bottom: 1.5rem;
  color: var(--primary-blue);
}

.sidebar-title i {
  margin-right: 0.5rem;
  font-size: 1.5rem;
}

.subscription-count {
  font-size: 3rem;
  font-weight: bold;
  color: var(--primary-blue);
  margin-bottom: 1rem;
}

.table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0 0.5rem;
}

.table th,
.table td {
  padding: 0.75rem;
  text-align: left;
}

.table th {
  background-color: var(--light-blue);
  color: var(--dark-blue);
  font-weight: bold;
}

.table tr {
  background-color: var(--white);
  transition: all 0.3s ease;
}

.table tr:hover {
  background-color: var(--light-blue);
  transform: translateY(-2px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn {
  display: inline-block;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-size: 0.9rem;
  cursor: pointer;
  transition: all 0.3s ease;
  border: none;
}

.btn-danger {
  background-color: #ef4444;
  color: var(--white);
}

.btn-danger:hover {
  background-color: #dc2626;
  transform: translateY(-1px);
  box-shadow: 0 2px 4px rgba(220, 38, 38, 0.2);
}

.history-list {
  list-style-type: none;
  padding: 0;
}

.history-list li {
  margin-bottom: 1rem;
  padding: 0.75rem;
  background-color: var(--white);
  border-radius: 8px;
  transition: all 0.3s ease;
}

.history-list li:hover {
  background-color: var(--light-blue);
  transform: translateY(-2px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.history-list a {
  color: var(--primary-blue);
  text-decoration: none;
  display: block;
}

.history-list a:hover {
  color: var(--dark-blue);
}

.history-date {
  font-size: 0.8rem;
  color: var(--secondary-blue);
  margin-top: 0.25rem;
}

.fade-in {
  opacity: 0;
  transform: translateY(20px);
  animation: fadeIn 0.5s ease-out forwards;
}

@keyframes fadeIn {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

 

</style>

<head>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<div class="container">
    <div class="user-header fade-in">
        <i class="fas fa-user-circle user-icon"></i>
        <h1>Bienvenue, {{ $user->name }}</h1>
    </div>

    <div class="content-wrapper">
        <div class="sidebar fade-in" style="animation-delay: 0.2s;">
            <div class="sidebar-title">
                <i class="fas fa-history"></i>
                <h2>Historique</h2>
            </div>
            <ul class="history-list">
                @foreach($postsHistory as $history)
                    <li>
                        <a href="{{ route('posts.show', $history->post_id) }}">
                            {{ $history->post->title }}
                            <div class="history-date">vu le {{ $history->viewed_at }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="sidebar fade-in" style="animation-delay: 0.4s;">
            <div class="sidebar-title">
                <i class="fas fa-layer-group"></i>
                <h2>Mes abonnements</h2>
            </div>
            <div class="subscription-count">{{$count}}</div>
            @if($categories->isEmpty())
                <p>Vous n'êtes abonné à aucune catégorie pour l'instant.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom de la catégorie</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <form action="{{ route('user.unsubscribe', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Retirer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>




<script>document.addEventListener("DOMContentLoaded", () => {
  // Fade in effect for elements
  const fadeElements = document.querySelectorAll(".fade-in")
  fadeElements.forEach((element, index) => {
    element.style.animationDelay = `${0.2 * index}s`
  })

  // Hover effect for table rows
  const tableRows = document.querySelectorAll(".table tbody tr")
  tableRows.forEach((row) => {
    row.addEventListener("mouseenter", () => {
      row.style.backgroundColor = "var(--light-blue)"
    })
    row.addEventListener("mouseleave", () => {
      row.style.backgroundColor = "var(--white)"
    })
  })

  // Confirm unsubscribe action
  const unsubscribeForms = document.querySelectorAll('form[action^="/user/unsubscribe"]')
  unsubscribeForms.forEach((form) => {
    form.addEventListener("submit", (e) => {
      if (!confirm("Êtes-vous sûr de vouloir retirer cet abonnement ?")) {
        e.preventDefault()
      }
    })
  })

  // Animate subscription count
  const subscriptionCount = document.querySelector(".subscription-count")
  const targetCount = Number.parseInt(subscriptionCount.textContent)
  let currentCount = 0
  const duration = 1500 // 1.5 seconds
  const interval = 50 // Update every 50ms
  const increment = targetCount / (duration / interval)

  const countAnimation = setInterval(() => {
    currentCount += increment
    if (currentCount >= targetCount) {
      clearInterval(countAnimation)
      currentCount = targetCount
    }
    subscriptionCount.textContent = Math.round(currentCount)
  }, interval)

  // Add hover effect to history items
  const historyItems = document.querySelectorAll(".history-list li")
  historyItems.forEach((item) => {
    item.addEventListener("mouseenter", () => {
      item.style.transform = "translateY(-5px)"
    })
    item.addEventListener("mouseleave", () => {
      item.style.transform = "translateY(0)"
    })
  })
})



</script>
@endsection
