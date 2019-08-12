$(document).ready(function() {

$( "#ingresar" ).click(function(event){ 

    event.preventDefault()

    var dataString  = $( '#form_login' ).serializeArray()

    var route = "login";

    $.ajax({

        url: route,

        type: 'post',

        datatype: 'json',

        data:dataString,

        success:function(data){

            if(data.estado){

                window.location = "main";    

            }else{

                swal({
                    title: "Error de verificación",
                    text: "No has confirmado tu correo electronico",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonClass: "btn btn-info btn-fill",
                    confirmButtonText: "Enviar un nuevo enlace",
                    cancelButtonClass: "btn btn-danger btn-fill",
                    closeOnConfirm: false,
                }, function() {

                    $.ajax({

                        url: "enviarEnlace/"+data.id,
                
                        type: 'post',
                
                        datatype: 'json',
                
                        data:dataString,
                
                        success:function(data){
                
                            swal("Envío Exitoso!", "Hemos enviado un nuevo enlace a tu email.", "success"); 
                    
                        },

                    });
                    
                });
            }

        },

        error:function(data){

          var error = data.responseJSON.errors;
          console.log(error)

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