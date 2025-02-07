<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @if(isset($authUserDetail))
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('authors.index') }}">{{ __('Authors') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('books.create') }}">{{ __('Create Book') }}</a>
                        </li>
                    </ul>
                    @endif

                    <!-- Right Side Of Navbar -->
                     <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @if(!isset($authUserDetail))
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Welcome,  <b> {{ $authUserDetail['first_name']  ??  '' }}  {{ $authUserDetail['last_name']  ??  '' }} </b>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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
            @include('common.error-msg')
            @yield('content')
            @include('common.form')
        </main>
    </div>



    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ url('jquery/jquery-3.2.1.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

       // For delete
        $(document).on("click", '.btnDelete', function(event) {
            event.preventDefault();

            var title = $(this).data('title');
            var url = $(this).data('url');

            if (confirm("Are you sure? You will not be able to recover this " + title)) {
                var form = $('#deleteForm');
                form.attr('action', url);
                form.submit();
            }
        });

        $(document).ready(function(){
            setTimeout(function(){$('.alertdisapper').fadeOut();}, 4000);
        });
    </script>
    @yield('js')
</body>
</html>
