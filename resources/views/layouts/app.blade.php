<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="{{ asset('favicon.png') }}" />
    <title>{{ $meta_title }} | Ver Online Latino </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="{{ $meta_claves }}">
    <meta name="description" content="{{ $meta_description }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap/jquery.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap/popper.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-133162795-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-133162795-1');
</script>



</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-h56.png') }}" alt="Ver Latino Online">
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse row " id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @foreach ($genres as $genre)
                            @if ($genre->id == 2 || $genre->id == 1 || $genre->id == 7 || $genre->id == 12 || $genre->id == 4 || $genre->id == 14)
                                
                                
                                <li>
                                    <a class="" href="/peliculas-de/{{ $genre->slug }}" >{{ $genre->name }}</a>
                                </li>
                            @endif
                         @endforeach
                            <div class="dropleft">
                                <a class="dropdown-toggle" href="#" role="button" id="genres" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Todos
                                </a>
                              
                                <div class="dropdown-menu" aria-labelledby="genres">
                                        <div class="desplegable-genres">
                                            @foreach ($genres as $genre)
                                                <a class="dropdown-item" href="/peliculas-de/{{ $genre->slug }}">{{ $genre->name }}</a>
                                            @endforeach 
                                        </div>
                                </div>
                            </div>
                    </ul>
                </div>
                <div class="user">
                    <ul>
                                                <!-- Authentication Links -->
                                            @guest
                                                {{-- <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    @if (Route::has('register'))
                                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                                    @endif
                                                </li> --}}
                                            @else
                                                <li class="nav-item dropdown">
                                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                        {{ Auth::user()->name }} <span class="caret"></span>
                                                    </a>
                    
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                                           onclick="event.preventDefault();
                                                                         document.getElementById('logout-form').submit();">
                                                            {{ __('Logout') }}
                                                        </a>
                    
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </li>
                                            @endguest
                    </ul>
                </div>
                <div class="search input-txt">
                    {{ Form::open( ['route'=> 'buscar', 'method'=>'GET'] ) }}
                        {{ Form::text('search', null, ['placeholder' => 'Buscar películas online - (escribe una palabra, frase o fragmento y presiona ENTER)']) }}
                        {{-- {{ Form::button('submit', null )}} --}}
                    {{ Form::close() }}
                </div>
            </div>
        </nav>

        <main class="">
            @yield('content')
        </main>
    </div>
</body>
</html>
