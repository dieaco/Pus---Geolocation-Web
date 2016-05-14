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
            status.cuando, 
            CONCAT('<a type=\'button\' href=\'\#showGeolocation\' class=\'btn btn-primary btnGeolocation\' data-toggle=\'modal\' data-latitude=\'',IFNULL(message_geolocation.message_geolocation_latitude, ''),'\' data-longitude=\'',IFNULL(message_geolocation.message_geolocation_longitude, ''),'\'>Ver ubicacion</a>') AS Geolocation 
        FROM 
            messages 
            INNER JOIN status ON messages.id = status.id_MSG 
            LEFT JOIN message_geolocation ON messages.id = message_geolocation.message_id
        WHERE 
            status.user_id = '$userId'"; 

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