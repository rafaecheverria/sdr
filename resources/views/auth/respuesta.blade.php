<!doctype html>

<html lang="en">

<head>

    <meta charset="utf-8" />

    <link rel="apple-touch-icon" sizes="76x76" href="static/img/apple-icon.png">

    <link rel="icon" type="image/png" href="static/img/favicon.png">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>{{config('app.name')}}</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->

    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <link href="css/light-bootstrap-dashboard.css?v=2.0.1" rel="stylesheet" />

    <!-- CSS Just for demo purpose, don't include it in your project -->

    <link href="css/demo.css" rel="stylesheet" />

    <link href="css/login.css" rel="stylesheet" />

</head>

<body>

    <div class="wrapper wrapper-full-page">

        <!-- Navbar -->

        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute">

            <div class="container">

                <div class="navbar-wrapper">
                    <a class="navbar-brand" href="javascript:void(0)">Sistema de Reclutamiento Digital</a>
                  
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link">
                                <i class="nc-icon nc-chart-pie-35"></i> Vacantes
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="{{ route('register') }}" class="nav-link">
                                <i class="nc-icon nc-badge"></i> Registrarse
                            </a>
                        </li>
                        <li class="nav-item  active ">
                            <a href="{{ route('login') }}" class="nav-link">
                                <i class="nc-icon nc-mobile"></i> Iniciar Sesion
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="full-page  section-image" data-color="orange" data-image="static/img/full-screen-image-1.jpg">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="content">
                <div class="container">
                    <a class="navbar-brand" href="javascript:void(0)">Gracias por registrarte, te hemos enviado un Correo Electrònico para confirmar tu cuenta</a>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <nav>
                    <ul class="footer-menu">
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Blog
                            </a>
                        </li>
                    </ul>
                    <p class="copyright text-center">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                    </p>
                </nav>
            </div>
        </footer>
    </div>
</body>

<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/bootstrap-switch.js"></script>
<script src="js/light-bootstrap-dashboard.js?v=2.0.1" type="text/javascript"></script>
<script src="js/demo.js"></script>
<script src="js/login.js"></script>

<script>
    $(document).ready(function() {
        demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>

</html>