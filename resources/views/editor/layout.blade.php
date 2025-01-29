<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/dashboarded.css') }}">
    <script src="{{ asset('js/dash.js') }}"></script>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
           
            <h1>Tec<span>h</span>orizon</h1>
             <nav> 
            <div class="admin-info">
           
            <div class="icon">
             <img src="{{ asset('storage/images/icons8-male-user-96.png') }}" alt="Admin Icon">

             </div>
        <div class="details">
              <p><strong>{{ auth()->user()->name }}</strong></p>
            <p>{{ auth()->user()->email }}</p>
        </div>
    </div>
            </nav>
            <nav>
                <ul>
                    <li><a href="{{ route('editor.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('editor.subscribers') }}">Subscribers</a></li>
                    <li><a href="{{ route('collections.index') }}">collections</a></li>
                    <li><a href="{{ route('logout') }}">Logout</a></li>
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
