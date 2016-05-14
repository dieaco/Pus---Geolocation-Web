<?php

header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");

//Variables para actualización
$messageId = (int)$_POST['messageId'];
$userId = (int)$_POST['userId'];
$timestamp = "Leido " . date("d/M/Y") . " a las " . date("h:i:sa");
$isRead = 1;
$isDeleted = 0;

//Variable utilizada para devolver JSON
$jsonData = array();

include_once "../includes/connect.php";

$sql = "SELECT 1 AS ERROR, 'Mensaje ya leído previamente por usuario', id_MSG, user_id FROM status WHERE id_MSG = '$messageId' AND user_id = '$userId'";
$res1 = mysqli_query($con,$sql);

if(mysqli_num_rows($res1) != 0){
    
    $sql = "UPDATE status SET cuando = '$timestamp', is_read = '$isRead' WHERE id_MSG = '$messageId' AND user_id = '$userId'";
    $res2 = mysqli_query($con,$sql);
    if($res2){
        while($row = mysqli_fetch_assoc ($res1))
        {
            $jsonData[] = array_map('utf8_encode', $row);
        }            
        echo json_encode ($jsonData);
    }
    
}else{
    $sql = "INSERT INTO status (id_MSG, is_read, is_deleted, cuando, user_id) VALUES('$messageId', '$isRead', '$isDeleted', '$timestamp', '$userId')";
    $res3 = mysqli_query($con,$sql);
    
    if($res3){
        $sql = "SELECT 0 AS ERROR, 'Mensaje no leído previamente' AS MESSAGE";
        $res4 = mysqli_query($con,$sql);
        
        while($row = mysqli_fetch_assoc($res4)){
            $jsonData[] = array_map('utf8_encode', $row);
        }
        
        echo json_encode($jsonData);
    }
}