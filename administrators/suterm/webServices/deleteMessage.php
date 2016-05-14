<?php
/*header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");*/

//Variable utilizada para devolver JSON
$jsonData = array();
//Variables temporales para conexión a DB 
require "../includes/connect.php";
//Variables por post
$messageId = $_REQUEST['messageId'];

$sql = "DELETE FROM messages WHERE id = '$messageId'";   

$res = mysqli_query($con,$sql);

$sql2 = "SELECT * FROM messages WHERE id = '$messageId'";

$res2 = mysqli_query($con,$sql2);

if(mysqli_num_rows($res2) == 0){
    //Se elimina status de todos los usuarios del mensaje que ha sido eliminado
    $sqlStatus = "DELETE FROM status WHERE id_MSG = '$messageId'";

    $resStatus = mysqli_query($con,$sqlStatus);

    $sql3 = "SELECT 0 AS ERROR, 'Mensaje eliminado correctamente' AS MESSAGE";

    $res3 = mysqli_query($con,$sql3);

    while($row = mysqli_fetch_assoc ($res3))
    {
        $jsonData[] = array_map('utf8_encode', $row);
    }
    echo json_encode ($jsonData);

}else{
    $sql3 = "SELECT 1 AS ERROR, 'El mensaje no ha podido ser eliminado, intente nuevamente' AS MESSAGE";

    $res3 = mysqli_query($con,$sql3);

    while($row = mysqli_fetch_assoc ($res3))
    {
        $jsonData[] = array_map('utf8_encode', $row);
    }
    echo json_encode ($jsonData);
}

?>