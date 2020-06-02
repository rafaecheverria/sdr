$(document).ready(function() {

$( "#ingresar" ).click(function(event){ 

    event.preventDefault()

    var dataString  = $( '#form_login' ).serializeArray()

    var route = "login";

    $.ajax({

        url: route,

        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

        type: 'post',

        datatype: 'json',

        data:dataString,

        success:function(data){

            window.location = "main"; 


        },

        error:function(data){

          var error = data.responseJSON.errors;

            for(var i in error){

                var message = error[i];

                $.notify({icon: "nc-icon nc-notification-70", message: message},{type: 'warning', timer: 1000})

            }

        }

    })

})

$( "#registro" ).click(function(event){ 

    event.preventDefault()

    var dataString  = $( '#form-registro' ).serializeArray()

    console.log(dataString)

    var route = "registro";

    $.ajax({

        url: route,

        type: 'post',

        datatype: 'json',

        data:dataString,

        success:function(data){

            document.getElementById("form-registro").reset();

            swal("Se registrò exitosamente!", "Revise su correo electronico para confirmar su cuenta", "success")
        },

        error:function(data){

          var error = data.responseJSON.errors;

            for(var i in error){

                console.log(error[i])

                var message = error[i];

                $.notify({icon: "nc-icon nc-notification-70", message: message},{type: 'warning', bottom:'right', timer: 1000});



            }

        }

    })

})

})