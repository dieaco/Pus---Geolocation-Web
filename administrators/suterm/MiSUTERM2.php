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

        <title>Mensajes Personalizados</title>

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

            <!-- Formulario para búsqueda de coolaborador -->
            <form class="searching-form">
                <div>
                    <input type="text" id="inputSearch" class="form-control" placeholder="Busca coolaborador..."/>
                    <button type="button" id="btnSearch" class="btn btn-primary">Buscar</button>
                </div>
            </form>

            <!-- Tabla con colaboradores que coincidan con el parámetro solicitado -->
            <div class="row">
                <div class="col-md-12" id="addQuery">                  
                </div>
            </div>

            <form class="form-signin hidden" method="POST" id="masiveMessages">
                <img src="img/logo.png" class="img-responsive center-block">
                <h2  align="center" class="form-signin-heading" id="txtHeaderMessage"></h2><br>
                <label for="inputEmail" class="sr-only">Mensaje:</label>
                <textarea id="message" class="form-control" placeholder="Escribe aquí tu mensaje..." rows="7" required></textarea><br>
                <input type="hidden" id="txtRegId"></input>
                <!-- Alerta de error -->
                <div class="alert alert-danger">
                    <strong>¡Alerta!</strong> No se permite el envío de mensajes vacíos, escriba al menos 10 caracteres.
                </div>
                <!-- Alerta de éxito -->
                <div class="alert alert-success">
                    <strong>¡Éxito!</strong> Tú mensaje ha sido enviado.
                </div>
                <button class="btn btn-lg btn-primary btn-block" id="btnSend" type="submit">Enviar <i id="ajaxLoader" class="fa fa-cog fa-spin fa-2x text-center hidden" style="color: white;"></i></button>                
            </form>
        </div><!-- Termina contenedor pricipal -->

        <!-- Máscara Ajax Loader -->
        <div id="ajaxMask">
            <div id="ajaximgLoader"><img src="data:image/gif;base64,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" /></div>
        </div>
        <!-- Termina Máscara Ajax Loader -->
        
        <!-- Personal scripts -->
        <script type="text/javascript">
            $(document).ready(function() {
                //Oculta alertas
                $('.alert').hide();

                //Se detecta cuando se presiona la tecla ENTER y se dispara el evento click del botón de búsqueda
                $('#inputSearch').keypress(function(e) {

                    if(e.which == 13) {
                        $('#btnSearch').trigger('click');
                        return false;
                    }
                });

                //Acción del botón buscar usuario
                $('#btnSearch').on('click', function(event) {
                    event.preventDefault();
                    $('#ajaxMask').fadeIn(300);
                    $('.alert').hide(500);
                    $('#masiveMessages').fadeOut(500);
                    $('#addQuery').fadeIn(500);
                    $('#addQuery').text("");
                    var text = $('#inputSearch').val();
                    if(text.length < 3){
                        alert("¡Debes escribir al menos 3 caracteres!");
                        $('#ajaxMask').fadeOut(300);
                    }else{
                        
                        $.post('webServices/getUserRegIdForPersonalMessages.php', {username: text}, function(data, textStatus, xhr) {
                            var table;
                            table += "<table class='table table-striped'>";
                            table += "<thead>";
                            table += "<tr>";
                            table += "<th>Nombre Usuario</th>";
                            table += "<th>Status</th>";
                            table += "<th class='text-center'>Acciones</th>";
                            table += "</tr>";
                            table += "</thead>";
                            table += "<tbody>";
                            $.each(data, function(index, item) {console.log(item.ERROR);
                                 if(item.ERROR == 1){
                                    table += "<tr>";
                                    table += "<td colspan='4'>No se encontraron coincidencias con su búsqueda</td>";
                                    table += "</tr>";
                                 }else{
                                    table += "<tr>";
                                    table += "<td>"+item.user_name+"</td>";
                                    if(item.User_device_status == 1){                                        
                                        table += "<td>Activo</td>";
                                        table += "<td><button class='btn btn-primary center-block btnMensaje' name='"+item.User_device_reg_id+"' id='"+item.user_name+"'>Mensaje</button></td>";
                                    }else{
                                        table += "<td>Inactivo</td>";
                                        table += "<td></td>";
                                    }
                                    
                                    table += "</tr>";
                                 }
                            });
                            table += "</tbody>";
                            table += "</table>";
                            $('#addQuery').append(table);
                        });
                        $('#ajaxMask').fadeOut(300);                     
                    }                    

                });

                //Éste botón muestra el formulario de envío de mensaje, asignando el regId del usuario que se seleccionó
                $('#addQuery').on('click', '.btnMensaje', function(event) {
                    event.preventDefault();
                    /* Act on the event */
                    var regId = $(this).attr('name');
                    var username = $(this).attr('id');console.log('regId: '+regId+' - username: '+username);
                    $('#addQuery').fadeOut(500);
                    $('#txtHeaderMessage').text('¡Envía un mensaje a '+username+'!');
                    $('#masiveMessages').removeClass('hidden');
                    $('#masiveMessages').fadeIn(500);
                    $('#txtRegId').attr('value', regId);
                });

                //Acción del botón enviar mensaje
                $('#btnSend').click(function(event) {console.log('se hizo click');
                    /* Act on the event */
                    var text = $('#message').val();
                    var regId = $('#txtRegId').val();
                    if(text.length < 10){
                        $('.alert-danger').fadeIn(500);
                    }else{
                        $('#ajaxLoader').removeClass('hidden');

                        $.post('test2.php', {message: text, regId: regId}, function(data, textStatus, xhr) {
                            /*optional stuff to do after success */
                            $('#ajaxLoader').addClass('hidden');
                            $('#message').val("");
                            $('.alert-success').fadeIn(500);
                            console.log('Respuesta JSON:'+data);
                        });
                    }

                    event.preventDefault();
                });

                //Oculta alertas cada que se escribe mensaje
                $('#message').keyup(function(event) {
                    /* Act on the event */
                    $('.alert').hide(500);
                });
            });
        </script>
    </body>            
 
</html>