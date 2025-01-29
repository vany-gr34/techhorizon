<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manager Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/lwajiha.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <h2>{{ $category->name }} Manager</h2>
            
            <!-- Afficher le nom et l'email du manager -->
            <div class="manager-info">
                <div class="profile-icon">
                    <i class="fas fa-user-circle"></i> <!-- Icône de profil -->
                </div>
                <p><strong>Name:</strong> {{ $manager->name }}</p>
                <p><strong>Email:</strong> {{ $manager->email }}</p>
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="{{ route('manager.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> <!-- Icône Dashboard -->
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manager.subscribers') }}">
                            <i class="fas fa-users"></i> <!-- Icône Subscribers -->
                            Subscribers
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manager.articles') }}">
                            <i class="fas fa-newspaper"></i> <!-- Icône Articles -->
                            Articles
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('manager.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout-button">
                                <i class="fas fa-sign-out-alt"></i> <!-- Icône Logout -->
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>
        <main class="content">
            <header>
                <h1>@yield('header-title')</h1>
            </header>
            <section>
                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>
