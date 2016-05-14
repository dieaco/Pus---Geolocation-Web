<?php
header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");

//Variables para almacenamiento de nuevo dispositivo
$username = $_REQUEST['username'];
//Variable utilizada para devolver JSON
$jsonData = array();
//Variables temporales para conexión a DB 
require "../includes/connect.php";

$sql = "SELECT 0 AS ERROR, usuarios.user_id, user_name, IFNULL( User_device_status, 0 ) AS User_device_status, IFNULL( User_device_reg_id,  'Vacío' ) AS User_device_reg_id
        FROM usuarios
        LEFT JOIN User_Device ON usuarios.user_id = User_Device.User_id
        WHERE user_type_id =1
        AND user_name LIKE  '%$username%'";   

$res = mysqli_query($con,$sql);

if(mysqli_num_rows($res) != 0){
    while($row = mysqli_fetch_assoc ($res))
    {
        $jsonData[] = array_map('utf8_encode', $row);
    }
    echo json_encode ($jsonData);
}else{
    $sql = "SELECT 1 AS ERROR";

    $res = mysqli_query($con,$sql);
    while($row = mysqli_fetch_assoc ($res))
    {
        $jsonData[] = array_map('utf8_encode', $row);
    }
    echo json_encode ($jsonData);
}

?>