<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EnM Hardware') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Styles -->
    <style>
        :root {
            --primary-color: #e63946;
            --secondary-color: #1d3557;
            --light-color: #f1faee;
            --accent-color: #a8dadc;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
        }
        
        .navbar {
            background-color: var(--secondary-color) !important;
            padding: 0.75rem 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            color: var(--light-color) !important;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .nav-link {
            color: var(--light-color) !important;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--accent-color) !important;
        }
        
        .search-form {
            width: 100%;
            max-width: 400px;
        }
        
        .search-form .form-control {
            border-radius: 20px 0 0 20px;
            border: none;
        }
        
        .search-form .btn {
            border-radius: 0 20px 20px 0;
            background-color: var(--primary-color);
            color: white;
            border: none;
        }
        
        .user-photo {
            width: 30px;
            height: 30px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 5px;
            border: 2px solid var(--light-color);
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
        }
        
        .dropdown-item i {
            width: 20px;
            margin-right: 5px;
            color: var(--secondary-color);
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <i class="fas fa-tools"></i> EnM Hardware
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">
                                <i class="fas fa-hammer"></i> {{ __('Products') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i> {{ __('Cart') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <form class="search-form d-flex" action="{{ route('products.search') }}" method="GET">
                                <input class="form-control me-0" type="search" name="query" placeholder="Search hardware..." aria-label="Search">
                                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt"></i> {{ __('Login') }}
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus"></i> {{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if(Auth::user()->profile_photo)
                                        <img src="{{ Auth::user()->profile_photo }}" alt="Profile Photo" class="user-photo">
                                    @else
                                        <i class="fas fa-user-circle"></i>
                                    @endif
                                    {{ Auth::user()->name }}
                                </a>
                            
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="fas fa-user"></i> {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('reviews.index') }}">
                                        <i class="fas fa-star"></i> {{ __('My Reviews') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="fas fa-box"></i> {{ __('My Orders') }}
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>