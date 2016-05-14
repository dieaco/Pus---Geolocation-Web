<?php
header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");

//Variable utilizada para devolver JSON
$jsonData = array();
//Variables temporales para conexión a DB 
require "../includes/connect.php";
    
//VARIABLES POR REQUEST
$latitude = $_REQUEST['latitude'];
$longitude = $_REQUEST['longitude'];
$messageId = (int)$_REQUEST['messageId'];
$userId = (int)$_REQUEST['userId'];


$sql = "INSERT INTO message_geolocation (message_geolocation_latitude, message_geolocation_longitude, message_id, user_id)
        VALUES('$latitude', '$longitude', '$messageId', '$userId')";   

$res = mysqli_query($con,$sql);

echo "USERID: ".$userId." - MESSAGEID: ".$messageId." - LATITUDE: ".$latitude." - LONGITUDE: ".$longitude;

/*$tbody .= "";

while($row = mysqli_fetch_array($res)){
    $tbody .= "<tr>";
    $tbody .= "<td>".$row['id']."</td>";
    $tbody .= "<td>".$row['mensaje']."</td>";
    $tbody .= "<td>".$row['timestamp']."</td>";
    $tbody .= "<td><a type='button' href='#deleteMessage' class='btn btn-danger btnDeleteMessage' data-toggle='modal' data-id='".$row['id']."'>Eliminar</a></td>";
    $tbody .= "</tr>";
}

echo $tbody;
if(mysqli_num_rows($res)){
    while($row = mysqli_fetch_assoc ($res))
    {
        $jsonData[] = array_map('utf8_encode', $row);
    }
    echo json_encode ($jsonData);
}*/
mysqli_close($con);

?>