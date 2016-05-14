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
            IF(User_Device.User_device_status = 1, 'Activo', 'Inactivo') AS User_device_status, 
            IF(User_Device.User_device_status = 1, CONCAT('<a type=\'button\' class=\'btn btn-primary btnForward\' data-regId=\'',User_Device.User_device_reg_id,'\' data-message=\'',messages.mensaje,'\'>Reenviar</a>'), '') AS Forward
        FROM 
            messages LEFT JOIN status ON messages.id = status.id_MSG 
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
            AND User_Device.User_id = '$userId'
            ORDER BY messages.id DESC"; 

$res = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($res)){
    
    $sql2 = "SELECT CONCAT('<a type=\'button\' href=\'\#showGeolocation\' class=\'btn btn-primary btnGeolocation\' data-toggle=\'modal\' data-latitude=\'',IFNULL(message_geolocation.message_geolocation_latitude, ''),'\' data-longitude=\'',IFNULL(message_geolocation.message_geolocation_longitude, ''),'\'>Ver ubicacion</a>') AS Geolocation
            FROM message_geolocation
            WHERE message_geolocation.user_id = '$userId'
                    AND message_geolocation.message_id = '$row[0]'";

    $res2 = mysqli_query($con,$sql2);
    
    if(mysqli_num_rows($res2) == 0){
        array_push($jsonData,
        array('id'=>$row['id'],
              'mensaje'=>$row['mensaje'],
              'User_device_status'=>$row['User_device_status'],
              'Forward'=>$row['Forward'],
              'Geolocation'=>'Sin ubicación'
        ));        
    }else{
        while($row2 = mysqli_fetch_array($res2)){
            array_push($jsonData,
            array('id'=>$row['id'],
                  'mensaje'=>$row['mensaje'],
                  'User_device_status'=>$row['User_device_status'],
                  'Forward'=>$row['Forward'],
                  'Geolocation'=>$row2['Geolocation']
            ));
        }       
    }  
    
}
 
echo json_encode(array("data"=>$jsonData));
 
mysqli_close($con);

?>