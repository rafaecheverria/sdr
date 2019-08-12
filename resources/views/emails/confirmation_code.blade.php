<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <title>{{config('app.name')}}</title>

    </head>

    <body>

        <h2>Hola {{$rut}}, Bienvenido a SDR</h2>
        <p>Por Favor confirma tu correo electrònico</p>
        <p>Para ello simplemente debes hacer click en el siguiente enlace:</p>

        <a href="{{url('register/verify/'.$confirmation_code)}}">Click para confirmar su email</a>

    </body>


</html>
