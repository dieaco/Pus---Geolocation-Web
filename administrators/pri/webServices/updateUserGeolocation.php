<?php
header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");

$userLatitude = $_REQUEST['userLatitude'];
$userLongitude = $_REQUEST ['userLongitude'];
$userId = $_REQUEST['userId'];

echo $userLatitude." - ".$userLongitude." - ".$userId;

//Variables temporales para conexión a DB 
require "../includes/connect.php";

$sql = "UPDATE usuarios AS u 
		SET u.user_geolocation_latitude = '$userLatitude', u.user_geolocation_longitude = '$userLongitude', u.user_last_geolocation_update = now()
		WHERE u.user_id = '$userId'";

$res = mysqli_query($con,$sql);



mysqli_close($con);

?>