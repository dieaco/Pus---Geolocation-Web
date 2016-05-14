<?php
header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");

//Variable utilizada para devolver JSON
$jsonData = array();
//Variables temporales para conexión a DB 
require "../includes/connect.php";
    
//VARIABLES POR REQUEST
$userId = $_REQUEST['userId'];


$sql = "SELECT 
            messages.id, 
            messages.mensaje, 
            IF(User_Device.User_device_status = 1, 'Activo', 'Inactivo') AS User_device_status, IF(User_Device.User_device_status = 1, CONCAT('<a type=\'button\' class=\'btn btn-primary btnForward\' data-regId=\'',User_Device.User_device_reg_id,'\' data-message=\'',messages.mensaje,'\'>Reenviar</a>'), '') AS Forward 
        FROM 
            messages 
            LEFT JOIN status ON messages.id = status.id_MSG 
            JOIN User_Device 
        WHERE 
            messages.id NOT IN (
                SELECT 
                    messages.id 
                FROM 
                    messages 
                    INNER JOIN status ON messages.id = status.id_MSG 
                WHERE 
                    status.user_id = '$userId'
            )
            AND User_Device.User_id = '$userId'"; 

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