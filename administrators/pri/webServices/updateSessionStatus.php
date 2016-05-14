<?php

header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");

//Variables para almacenamiento de nuevo dispositivo
$userId = (int)$_POST['userId'];
$regId = $_POST['regisId'];
//Variables para validación de inicio de usuario
$userDeviceStatus = 0;
$userIsLogged = 0; 

//Variable utilizada para devolver JSON
$jsonData = array();

include_once "../includes/connect.php";

$sql = "UPDATE usuarios SET user_is_logged = '$userIsLogged' WHERE user_id = '$userId'";   
$res1 = mysqli_query($con,$sql);

$sql = "UPDATE User_Device SET User_device_status = '$userDeviceStatus' WHERE User_id = '$userId' AND   User_device_reg_id = '$regId'";
$res2 = mysqli_query($con,$sql);

$sql = "SELECT 0 AS ERROR, 'Sesión Actulizada a 0' AS MESSAGE";
$res3 = mysqli_query($con,$sql);

while($row = mysqli_fetch_assoc ($res3))
{
    $jsonData[] = array_map('utf8_encode', $row);
}            
echo json_encode ($jsonData);