<?php

//Variable utilizada para devolver JSON
$jsonData = array();
//Variables temporales para conexión a DB 
require "../includes/connect.php";

$sql = "SELECT * FROM messages ORDER BY id ASC";   

$res = mysqli_query($con,$sql);

$tbody .= "";

while($row = mysqli_fetch_array($res)){
    $tbody .= "<tr>";
    $tbody .= "<td>".$row['id']."</td>";
    $tbody .= "<td>".$row['mensaje']."</td>";
    $tbody .= "<td>".$row['timestamp']."</td>";
    $tbody .= "<td><a type='button' href='#deleteMessage' class='btn btn-danger btnDeleteMessage' data-toggle='modal' data-id='".$row['id']."'>Eliminar</a></td>";
    $tbody .= "</tr>";
}

echo $tbody;
/*if(mysqli_num_rows($res)){
    while($row = mysqli_fetch_assoc ($res))
    {
        $jsonData[] = array_map('utf8_encode', $row);
    }
    echo json_encode ($jsonData);
}*/
mysqli_close($con);

?>