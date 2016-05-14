<?php
	include "connect.php";
	/*$nombre = $_REQUEST['nombre'];
	$apellidos = $_REQUEST['apellidos'];	
	$telefono = $_REQUEST['telefono'];
	$mensaje = $_REQUEST['mensaje'];
	$correo = $_REQUEST['correo']; */

	$jsonData = array();	

	$para = $_REQUEST['for'];
	$correo = 'administracionPush';

	$sql = "SELECT 0 AS ERROR, 'Se envío mensaje' AS MESSAGE, user_password, user_id FROM usuarios WHERE user_name = '$para'";   
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
        $jsonData[] = array_map('utf8_encode', $row);            
        echo json_encode ($jsonData);
		//echo "0";//echo"<script>alert('Gracias, su mensaje ha sido enviado correctamente.')</script>";
		
	}		
	else{
		$sql = "SELECT 1 AS ERROR, 'No se envío correo' AS MESSAGE";
		if($res = mysqli_query($con,$sql)){           
            while($row = mysqli_fetch_assoc ($res))
            {
                $jsonData[] = array_map('utf8_encode', $row);
            }            
            echo json_encode ($jsonData);
        }
		//echo "1";//echo"<script>alert('Lo sentimos, su mensaje no se ha podido enviar.')</script>";
	}
?>