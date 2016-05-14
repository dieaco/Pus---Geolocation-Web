<?php
header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");

$userId = $_REQUEST['userId'];

//Variable utilizada para devolver JSON
$jsonData = array();
//Variables temporales para conexión a DB 
require "../includes/connect.php";

$sql = "SELECT u.user_geolocation_latitude, u.user_geolocation_longitude, u.user_name
		FROM usuarios AS u 
		WHERE u.user_id = '$userId'"; 

$res = mysqli_query($con,$sql);

if(mysqli_num_rows($res)){
    while($row = mysqli_fetch_assoc ($res))
    {
        $jsonData[] = array_map('utf8_encode', $row);
    }
    echo json_encode ($jsonData);
}
mysqli_close($con);

?>