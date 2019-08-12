<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{config('app.name')}}</title>

        <!-- Fonts -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

        <link href="static/css/nucleo_icons.css" rel="stylesheet" />

         <!-- <link href="css/bootstrap.min.css" rel="stylesheet" /> 

        <link href="css/light-bootstrap-dashboard.css?v=2.0.1" rel="stylesheet" /> -->

        <!-- CSS Just for demo purpose, don't include it in your project -->

         <!-- <link href="css/demo.css" rel="stylesheet" /> -->

        <!-- <link href="css/login.css" rel="stylesheet" /> -->

    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}"> 

    </head>

    <body>

        <div id="app">

            <div class="wrapper">

                @include('layouts.sidebar')

                <div class="main-panel">

                    @include('layouts.nav')

                    @yield('content')

                </div>

            </div>

        </div>

    </body>

    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
    <!-- <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/popper.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/bootstrap-switch.js"></script>
    <script src="js/light-bootstrap-dashboard.js" type="text/javascript"></script>
    <script src="js/demo.js"></script>  -->
    <!-- <script src="js/login.js"></script> -->

</html>
