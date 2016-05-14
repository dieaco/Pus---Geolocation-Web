<?php
	include "connect.php";
	/*$nombre = $_REQUEST['nombre'];
	$apellidos = $_REQUEST['apellidos'];	
	$telefono = $_REQUEST['telefono'];
	$mensaje = $_REQUEST['mensaje'];
	$correo = $_REQUEST['correo']; */	

	$para = $_REQUEST['for'];
	$correo = 'administracionPush';

	$sql = "SELECT user_password FROM usuarios WHERE user_name = '$para'";   
    $res = mysqli_query($con,$sql);

    $row = mysqli_fetch_array($res);

	$header = 'From: ' . $correo . " \r\n";
	$header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
	$header .= "Mime-Version: 1.0 \r\n";
	$header .= "Content-Type: text/plain";

	$mensajeDatos = "Este correo fue enviado por la " . "administración de la App Push" . ". \r\n\n\n";
	$mensajeDatos .= "Su contraseña es: " . $row['user_password'] . " \r\n";

	$asunto = 'Recuperación de Contraseña App Push';

	if(mail($para, $asunto, utf8_decode($mensajeDatos), $header))
		{
			echo "0";//echo"<script>alert('Gracias, su mensaje ha sido enviado correctamente.')</script>";
			
		}		
	else
		echo "1";//echo"<script>alert('Lo sentimos, su mensaje no se ha podido enviar.')</script>";
?>