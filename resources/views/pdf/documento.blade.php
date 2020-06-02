<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" media="all" /> -->
    <!-- <link rel="stylesheet" href="css/demo.css" media="all" /> -->
    <!-- <link rel="stylesheet" href="css/light-bootstrap-dashboard.css" media="all" /> -->
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>MEMORANDUM</title>
    <style>

        body { font-family: "Times New Roman", Times, serif; }
 
        .sinpadding [class*="col-"] {
            padding: 0;
        }

        .padd{
            
            margin-bottom: 15px;
        }

        #logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }

        #imagen{
        width: 200px;
        }

        .letra{
            font-size: 13px;
            /* font-family: Arial Narrow,Arial,sans-serif;  */
        
        }
        .table-borderless td,
        .table-borderless th {
            border: 0;
        }

    </style>

    <body>
        <header>
            <div id="logo">
                <img src="static/img/logo.png" alt="incanatoIT" id="imagen">
            </div>
        </header>
        <br>
        <br>
        <hr>
        <!-- <h2 class="text-center"><span>MEMORANDUM Nº1</span></h2> -->
            <h4>
                <p class="text-center">MEMORANDUM Nº1</p>
            </h4>
            <div class="container">
                <section>
                    <table class="table table-sm table-borderless table-condensed letra">
                        <tbody>

                            <tr class="padd">
                            <th scope="row">A:</th>
                                <td class="col-12">{{$destinatario}}
                                <p style="font-size:11px; margin-bottom:0px;">{{$cargo_destinatario}} - {{$depto_destino}}</p>
                                <p style="font-size:11px;">{{$region_depto_destinatario}}</p>
                                </td>
                            </tr>
                
                            <tr class="padd">
                            <th scope="row">DE:</th>
                                <td class="col-12">{{$remitente}}
                                <p style="font-size:11px; margin-bottom:0px;">{{$cargo_remitente}} - {{$depto_origen}}</p>
                                <p style="font-size:11px;">{{$region_depto_remitente}}</p>
                                </td>
                            </tr>

                            <tr>
                            <th scope="row">FECHA:</th>
                                <td colspan="2">{{$fecha_documento}}</td>
                                
                            </tr>
                            <tr>
                            <th scope="row">ASUNTO:</th>
                                <td colspan="2">{{$asunto}}.</td>
                            </tr>
                            
                        </tbody>
                        </table>
                </section>
            </div>
        <hr>
        
        <div class="container">
            {!! $detalle !!}
        </div>

        <footer>
            <div id="gracias">

            aqui va la firma
            </div>
        </footer>
    </body>
</html>