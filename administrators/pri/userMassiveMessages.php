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

        <title>Mensajes masivos por usuario</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Personal Styles -->
        <link rel="stylesheet" href="css/Suterm.css" type="text/css"/>
        <!-- FontAwesome icons -->
        <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css">
        <!-- Datatables Styles -->
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-1.12.0.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Datatables scripts -->
        <script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
        <!-- Google Maps API -->
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBZ2Xj42ZaBfyUis0-u1dtTVC24OEizRHY"></script>

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

        <style type="text/css">
        #map{
            margin: auto;
            width: 100%;
            height: 400px;
        }
        </style>     
    </head>
    <body> 

        <nav class="navbar navbar-default">

            <div class="container-fluid">
                <?php require "includes/navigation.php"; ?>
            </div><!-- /.container-fluid -->

        </nav>

        <!-- Comienza contenedor principal -->
        <div class="container-fluid">

            <!-- Tabla con colaboradores que coincidan con el parámetro solicitado -->
            <div class="row">
                <div class="col-md-12" >
                <button type="button" id="btnHide" class="btn btn-primary"><i class="fa fa-eye fa-1x"></i> Mostrar Mensajes</button>
                <!-- Tabla addQuery -->
                    <table id="addQuery" class="display table table-stripped" style="max-width: none !important;display: none !important">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Leídos</th>
                                <th>No Leídos</th>
                                <th>Recibidos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- AQUÍ SE INSERTA CONSULTA QUE SE HACE VÍA AJAX -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Leídos</th>
                                <th>No Leídos</th>
                                <th>Recibidos</th>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- Termina tabla addQuery -->
                    <!-- Inicia tabla quien vio -->
                    <table id="addWhoRead" class="display table table-stripped" style="max-width: none !important; width: 100% !important; display: none">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mensaje</th>
                                <th>¿Cuándo lo vio?</th>
                                <th>Ubicación</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Mensaje</th>
                                <th>¿Cuándo lo vio?</th>
                                <th>Ubicación</th>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- Termina tabla quien vio -->
                    <!-- Inicia tabla quien vio -->
                    <table id="addWhoUnread" class="display table table-stripped" style="max-width: none !important; width: 100% !important; display: none">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mensaje</th>
                                <th>Status usuario</th>
                                <th>Acciones</th>
                                <th>Ubicación</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Mensaje</th>
                                <th>Status usuario</th>
                                <th>Acciones</th>
                                <th>Ubicación</th>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- Termina tabla quien vio -->
                </div>
            </div>

        </div><!-- Termina contenedor pricipal -->

        <!-- Ventana Modal para confirmar eliminación de mensaje -->
        <div id="showGeolocation" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ubicación</h4>
              </div>
              <div class="modal-body">
                <p></p>
                <div id="map"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>

        <!-- Máscara Ajax Loader -->
        <div id="ajaxMask">
            <div id="ajaximgLoader"><img src="data:image/gif;base64,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" /></div>
        </div>
        <!-- Termina Máscara Ajax Loader -->
        
        <!-- Personal scripts -->
        <script type="text/javascript">
            $(document).ready(function() {
                $('#ajaxMask').fadeIn(300);
                if($('#ajaxMask:visible')){
                    $.post('webServices/getUserMassiveMessages.php', {param1: 'value1'}, function(data, textStatus, xhr) {
                        $('#addQuery tbody').html(data);
                        $('#addQuery').fadeIn(300);

                        //Carga paginación de tabla
                        $('#addQuery').DataTable({                    
                            "language": {                        
                                "lengthMenu": 'Mostrar <select>'+
                                              '<option value="10">10</option>'+
                                              '<option value="20">20</option>'+
                                              '<option value="50">50</option>'+
                                              '<option value="100">100</option>'+
                                              '<option value="-1">Todos</option>'+
                                              '</select> mensajes',
                                "emptyTable": 'No se encontraron mensajes',
                                "info": 'Mostrando (_START_ - _END_) de _TOTAL_ mensajes',
                                "loadingRecords": 'Cargando mensajes...',
                                "search": 'Buscar',
                                "zeroRecords": 'No se encontraron coincidencias',
                                "paginate": {
                                    "first": 'Primero',
                                    "last": 'Último',
                                    "next": 'Siguiente',
                                    "previous": 'Anterior'
                                }
                            },
                            "fnInitComplete": function(settings, json){
                                console.log('termino datatable');
                                $('#ajaxMask').fadeOut(300);
                            }
                        });
                    });
                }                

                //Muestra tabla con usuarios que vieron mensaje
                $('#addQuery').on('click', '.btnWhoRead', function(event) {console.log('mostrar usuarios');
                    event.preventDefault();
                    //Mostramos mascara ajax y olcultamos wrapper de primera tabla
                    $('#ajaxMask').fadeIn(300);
                    $('#addQuery_wrapper').fadeOut(300);
                    var userId = $(this).data('id');
                    //Carga paginación de tabla
                    $('#addWhoRead').DataTable({
                        "ajax": "webServices/getUserMessagesRead.php?userId="+userId,
                        "columns": [
                            {"data": "id"},
                            {"data": "mensaje"},
                            {"data": "cuando"},
                            {"data": "Geolocation"}
                        ],                  
                        "language": {                        
                            "lengthMenu": 'Mostrar <select>'+
                                          '<option value="10">10</option>'+
                                          '<option value="20">20</option>'+
                                          '<option value="50">50</option>'+
                                          '<option value="100">100</option>'+
                                          '<option value="-1">Todos</option>'+
                                          '</select> mensajes',
                            "emptyTable": 'No se encontraron mensajes',
                            "info": 'Mostrando (_START_ - _END_) de _TOTAL_ mensajes',
                            "loadingRecords": 'Cargando mensajes...',
                            "search": 'Buscar',
                            "zeroRecords": 'No se encontraron coincidencias',
                            "paginate": {
                                "first": 'Primero',
                                "last": 'Último',
                                "next": 'Siguiente',
                                "previous": 'Anterior'
                            }
                        },
                        "destroy": "true"
                    });
                    //Ocultamos máscara Ajax y y mostramos wrapper de segunda tabla
                    $('#ajaxMask').fadeOut(300);
                    $('#btnHide').fadeIn(300);
                    $('#addWhoRead_wrapper, #addWhoRead').fadeIn(300);
                });

                //Muestra tabla con usuarios que no vieron el mensaje
                $('#addQuery').on('click', '.btnWhoUnread', function(event) {console.log('mostrar usuarios');
                    event.preventDefault();
                    //Mostramos mascara ajax y olcultamos wrapper de primera tabla
                    $('#ajaxMask').fadeIn(300);
                    $('#addQuery_wrapper').fadeOut(300);
                    var userId = $(this).data('id');
                    //Carga paginación de tabla
                    $('#addWhoUnread').DataTable({
                        "ajax": "webServices/getUserMessagesUnread.php?userId="+userId,
                        "columns": [
                            {"data": "id"},
                            {"data": "mensaje"},
                            {"data": "User_device_status"},
                            {"data": "Forward"},
                            {"data": "Geolocation"}
                        ],                  
                        "language": {                        
                            "lengthMenu": 'Mostrar <select>'+
                                          '<option value="10">10</option>'+
                                          '<option value="20">20</option>'+
                                          '<option value="50">50</option>'+
                                          '<option value="100">100</option>'+
                                          '<option value="-1">Todos</option>'+
                                          '</select> mensajes',
                            "emptyTable": 'No se encontraron mensajes',
                            "info": 'Mostrando (_START_ - _END_) de _TOTAL_ mensajes',
                            "loadingRecords": 'Cargando mensajes...',
                            "search": 'Buscar',
                            "zeroRecords": 'No se encontraron coincidencias',
                            "paginate": {
                                "first": 'Primero',
                                "last": 'Último',
                                "next": 'Siguiente',
                                "previous": 'Anterior'
                            }
                        },
                        "destroy": "true"
                    });
                    //Ocultamos máscara Ajax y y mostramos wrapper de segunda tabla
                    $('#ajaxMask').fadeOut(300);
                    $('#btnHide').fadeIn(300);
                    $('#addWhoUnread_wrapper, #addWhoUnread').fadeIn(300);
                });                            

                //Oculta segunda tabla y muestra primera tabla
                $('#btnHide').click(function(event) {
                    /* Act on the event */
                    $('#ajaxMask').fadeIn(300);
                    $('#btnHide').fadeOut(300);
                    $('#addWhoRead_wrapper, #addWhoRead').fadeOut(300);
                    $('#addWhoUnread_wrapper, #addWhoUnread').fadeOut(300);
                    $('#ajaxMask').fadeOut(300);
                    $('#addQuery_wrapper').fadeIn(300);
                });

                //Botón para reenvío de mensaje a aquellos que no lo han visto y que están activos para recibir notificaciones
                $('#addWhoUnread').on('click', '.btnForward', function(event) {console.log('botón forward');
                    event.preventDefault();
                    $('#ajaxMask').fadeIn(300);
                    var regId = $(this).data('regid');
                    var message = $(this).data('message');console.log(regId+" - "+message);
                    $.post('test2.php', {message: message, regId: regId}, function(data, textStatus, xhr) {
                        /*optional stuff to do after success */console.log("respuesta: "+data);                        
                        if(data == 1){
                            alert('¡Mensaje reenviado exitosamente!');    
                        }else{
                            alert('¡Ocurrió un error durante el reenvío, intente nuevamente!');
                        }                        
                    });
                    $('#ajaxMask').fadeOut(300);
                });                


                //Muestra ventana modal con la ubicación del usuario en un GOOGLE MAP
                $('#addWhoUnread').on('click', '.btnGeolocation', function(event) {
                    console.log('Mostrar ubiación en mapa No Leídos');
                    //event.preventDefault();

                    var userLatitude = $(this).data('latitude');
                    var userLongitude = $(this).data('longitude');

                    $('#showGeolocation').on('shown.bs.modal', function(){
                        console.log(event.target.className);
                        /*console.log('se mostró la ventana modal');
                        var userLatitude = $('.btnGeolocation').data('latitude');
                        var userLongitude = $('.btnGeolocation').data('longitude');*/
                        console.log('Coordenadas: '+userLatitude+", "+userLongitude);
                        if(userLatitude == ''){
                            $('.modal-body p').text('Se desconoce la ubicación del usuario al recibir éste mensaje');
                            startMap(0, 0);
                        }else{
                            $('.modal-body p').text('Coordenadas: '+userLatitude+", "+userLongitude);
                            startMap(userLatitude, userLongitude);
                            
                        }
                    });
                });

                //Muestra ventana modal con la ubicación del usuario en un GOOGLE MAP
                $('#addWhoRead').on('click', '.btnGeolocation', function(event) {
                    console.log('Mostrar ubiación en mapa Leídos');
                    //event.preventDefault();

                    var userLatitude = $(this).data('latitude');
                    var userLongitude = $(this).data('longitude');

                    $('#showGeolocation').on('shown.bs.modal', function(){
                        console.log(event.target.className);
                        /*console.log('se mostró la ventana modal');
                        var userLatitude = $('.btnGeolocation').data('latitude');
                        var userLongitude = $('.btnGeolocation').data('longitude');*/
                        console.log('Coordenadas: '+userLatitude+", "+userLongitude);
                        if(userLatitude == ''){
                            $('.modal-body p').text('Se desconoce la ubicación del usuario al recibir éste mensaje');
                            startMap(0, 0);
                        }else{
                            $('.modal-body p').text('Coordenadas: '+userLatitude+", "+userLongitude);
                            startMap(userLatitude, userLongitude);
                            
                        }
                    });
                });                

                //CARGA MAPA CON COORDENADAS ESPECÍFICAS DE UBICACIÓN PARA CADA USUARIO
                function startMap(latitude, longitude) {
                    var myLatlng = new google.maps.LatLng(latitude, longitude);

                    var mapOptions = {
                        center: myLatlng,
                        zoom: 10,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    }

                    var map = new google.maps.Map(document.getElementById('map'),mapOptions);

                    //Marcador de la Ubicación
                    var marker = new google.maps.Marker({
                        position: myLatlng,
                        title:'Usuario'
                    });
                    marker.setMap(map);

                    // Ampliación al presionar en el marcador de la ubicación
                    google.maps.event.addListener(marker,'click',function() {
                        map.setZoom(17);
                        map.setCenter(marker.getPosition());
                      });
                }


            });
            
        </script>
    </body>            
 
</html>