<?php
header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");

//Variable utilizada para devolver JSON
$jsonData = array();
//Variables temporales para conexión a DB 
require "../includes/connect.php";
//VARIABLES POR REQUEST
$messageId = $_REQUEST['messageId'];

//Mensaje
$messageText = '';

$sqlMessage = "SELECT mensaje FROM messages WHERE id = '$messageId'";
$resMessage = mysqli_query($con,$sqlMessage);
while($row = mysqli_fetch_array($resMessage)){
    $messageText = $row['mensaje'];
}

$sql = "SELECT usuarios.user_id, usuarios.user_name, User_Device.User_device_reg_id, IF(User_Device.User_device_status = 1, 'Activo', 'Inactivo') AS User_device_status, IF(User_Device.User_device_status = 1, CONCAT('<a type=\'button\' class=\'btn btn-primary btnForward\' data-id=\'',usuarios.user_id,'\' data-regId=\'',User_Device.User_device_reg_id,'\' data-message=\'','$messageText','\'>Reenviar</a>'), '') AS Forward
        FROM usuarios LEFT JOIN User_Device ON usuarios.user_id = User_Device.User_id
        WHERE usuarios.user_id NOT 
            IN (
                SELECT status.user_id
                FROM status INNER JOIN usuarios ON status.user_id = usuarios.user_id
                WHERE id_MSG = '$messageId'
            )
            AND user_type_id = 1";   

$res = mysqli_query($con,$sql);

if(mysqli_num_rows($res)){
    while($row = mysqli_fetch_assoc ($res))
    {
        $jsonData[] = array_map('utf8_encode', $row);
    }
    echo json_encode (array("data"=>$jsonData));
}
mysqli_close($con);

?>