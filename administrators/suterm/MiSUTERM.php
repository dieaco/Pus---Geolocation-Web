<?php 
    if(!isset($_SESSION)){
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--<meta name="viewport" content="width=device-width, initial-scale=0">-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">  
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="Entuizer">

        <title>Mensajes Masivos</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Personal Styles -->
        <link rel="stylesheet" href="css/Suterm.css" type="text/css"/>
        <!-- FontAwesome icons -->
        <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-1.12.0.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

        <!--validamos si se ha hecho o no el inicio de sesion correctamente
        si no se ha hecho la sesion nos regresará a index.php-->
        <?php   
        if(!isset($_SESSION['username'])) 
        {       
        ?>
            <script languaje="javascript">
                alert("Acceso denegado. Antes debe iniciar sesión.");
                location.href = "index.php";
            </script>
        <?php
            exit(); 
        }
        ?>      
    </head>
    <body> 

        <nav class="navbar navbar-default">

            <div class="container-fluid">
                <?php require "includes/navigation.php"; ?>
            </div><!-- /.container-fluid -->

        </nav>

        <!-- Comienza contenedor principal -->
        <div class="container-fluid">
            <form class="form-signin" method="POST" id="masiveMessages">
                <img src="img/logo.png" class="img-responsive center-block">
                <h2  align="center" class="form-signin-heading">¡Envía un mensaje a todos tus coolaboradores!</h2><br>
                <div class="loadImage form-control">
                    <input type="checkbox" id="cbLoadImage"></input>
                    <span> Cargar imagen</span>
                </div>
                <input type="file" id="inputImage" name="inputImage" class="form-control"></input>
                <label for="inputEmail" class="sr-only">Mensaje:</label>
                <textarea id="message" class="form-control" placeholder="Escribe aquí tu mensaje..." rows="7" required name="message"></textarea><br>
                <!-- Alerta de error -->
                <div class="alert alert-danger">
                    <strong>¡Alerta!</strong> <p></p>
                </div>
                <!-- Alerta de éxito -->
                <div class="alert alert-success">
                    <strong>¡Éxito!</strong> <p></p>
                </div>
                <button class="btn btn-lg btn-primary btn-block" id="btnSend" type="submit">Enviar <i id="ajaxLoader" class="fa fa-cog fa-spin fa-2x text-center hidden" style="color: white;"></i></button>                
            </form>
        </div><!-- Termina contenedor pricipal -->

        
        <!-- Personal scripts -->
        <script type="text/javascript">
            $(document).ready(function() {
                $('.alert').hide();

                $('#cbLoadImage').on('change', function(event) {
                    event.preventDefault();
                    if($(this).is(':checked')){
                        console.log('Se checó');
                        $('#inputImage').fadeIn(300);
                    }else{
                        console.log('Se quitó check'); 
                        console.log($('#inputImage').val());
                        $('#inputImage').replaceWith($('#inputImage').clone(true));
                        $('#inputImage').fadeOut(300);
                    }
                });

                $('#btnSend').click(function(event) {console.log('se hizo click');
                    /* Act on the event */
                    $('.alert').fadeOut(500);
                    var text = $('#message').val();
                    if(text.length < 10){
                        $('.alert-danger p').text('No se permite el envío de mensajes vacíos ni muy cortos, escriba al menos 10 caracteres.');
                        $('.alert-danger').fadeIn(500);
                    }else{
                        $('#ajaxLoader').removeClass('hidden');

                        var formData = new FormData($('#masiveMessages')[0]);

                        $.ajax({
                            url: 'test.php',
                            type: 'POST',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(data){
                                if(data == 0){
                                    $('.alert-danger p').text('El mensaje no ha sido enviado a ningún coolaborador.');
                                    $('.alert-danger').fadeIn(500);
                                    $('#message').val("");
                                    $('#cbLoadImage').attr('checked', false);
                                    $('#inputImage').replaceWith($('#inputImage').clone(true));
                                    $('#inputImage').fadeOut(300);
                                }else if(data == -1){
                                    $('.alert-danger p').text('Ocurrió un error al cargar la imagen, intente nuevamente.');
                                    $('.alert-danger').fadeIn(500);
                                }else if(data == -2){
                                    $('.alert-danger p').text('Ya existe una imagen con el mismo nombre, se le recomienda renombrarla.');
                                    $('.alert-danger').fadeIn(500);
                                }else if(data == -3){
                                    $('.alert-danger p').text('No es un tipo de archivo permitido o excede a los 5MB.');
                                    $('.alert-danger').fadeIn(500);
                                }else{
                                    $('.alert-success p').text('El mensaje ha sido enviado a un total de '+data+' coolaboradores.');
                                    $('.alert-success').fadeIn(500);
                                    $('#message').val("");
                                    $('#cbLoadImage').attr('checked', false);
                                    $('#inputImage').replaceWith($('#inputImage').clone(true));
                                    $('#inputImage').fadeOut(300);
                                }
                                $('#ajaxLoader').addClass('hidden');                                                               
                                
                                console.log('Respuesta JSON:'+data);   
                            },
                            error: function(data){
                                $('.alert-danger p').text('Ocurrió un error en la transferencia de datos, intente nuevamente.');
                                $('.alert-danger').fadeIn(500);
                            }
                        });                        
                    }

                    event.preventDefault();
                });

                $('#message').keyup(function(event) {
                    /* Act on the event */
                    $('.alert').hide(500);
                });
            });
        </script>
    </body>            
 
</html>