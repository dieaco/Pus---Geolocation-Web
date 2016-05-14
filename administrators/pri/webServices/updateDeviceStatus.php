<?php

header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");

//Variables para almacenamiento de nuevo dispositivo
$userId = (int)$_POST['userId'];
$regId = $_POST['regisId'];
//Variables para validación de inicio de usuario
$userDeviceStatus = 0;

//Variable utilizada para devolver JSON
$jsonData = array();

//Variables temporales para conexión a DB  
/*define('HOST','localhost');
define('USER','934497');
define('PASS','Entuizer16');
define('DB','934497');*/

include_once('../includes/connect.php');

$sql = "UPDATE User_Device SET User_device_status = '$userDeviceStatus' WHERE User_id = '$userId' AND   User_device_reg_id = '$regId'";
$res2 = mysqli_query($con,$sql);

echo "Se actualizó status del dispositivo con RegId = ".$regId." para el Usuario = ".$userId;