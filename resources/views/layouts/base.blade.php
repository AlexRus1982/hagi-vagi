<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Cookie uuid для идентификации просмотренных товаров и списка желаний -->
        <meta name="cookie-uuid" content="{{ Config::get('cookie-uuid') }}">

        <link href="/css/preloader.css" rel="stylesheet">

        <link rel="icon" href="/images/favicon.ico" type="image/x-icon">

        <title>@yield('page.title', 'Ларавел')</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

        <link href="/css/mobile.css" rel="stylesheet">
        <link href="/css/variables.css" rel="stylesheet">
        <link href="/css/footer.css" rel="stylesheet">
        <link href="/css/basket.css" rel="stylesheet">
        <link href="/css/wishes.css" rel="stylesheet">
        
        @stack('css')
    </head>

    <body>
        @include('includes.preloader')

        <div class="info-panel"></div>
        <style>
            .info-panel {
                position: fixed;
                top: 75px;
                left: calc(100% - 80px);
                display: flex;
                flex-direction: column;
                z-index: 1000;
            }
        </style>

        @include('includes.basket')
        @include('includes.wishes')

        <div class="d-flex flex-column justify-content-between min-vh-100 text-center">
            @include('includes.header')
    
            <main class="d-flex flex-column flex-grow-1 py-3"> 
                @yield('content')
            </main>
    
            @include('includes.footer')
        </div>

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script type="module" src="/js/init.js"></script>

        @stack('js')

        <!-- preloader script -->
        <script>
            $(document).ready(function() { 
                $('.preloader').addClass('off');
                setTimeout(() => {
                    $('.preloader').remove();
                    // $('.preloader svg').remove();
                    $('.start').removeClass('start');
                }, 1000);
            });
        </script>

    </body>

</html>