<?php

header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");

//Variables para almacenamiento de nuevo dispositivo
$regID = $_POST['regisId'];
$numSerie = $_POST['numSerie'];
$userId = (int)$_POST['userId'];
$isLogged = (int)$_POST['userIsLogged'];
//Variables para validación de inicio de usuario
$userName = $_POST['userName'];
$userPassword = $_POST['userPassword'];
$userDeviceStatus = 1;

//Variable utilizada para devolver JSON
$jsonData = array();

include_once "../includes/connect.php";

$sql = "SELECT 0 AS ERROR, user_id, user_name, user_password FROM usuarios WHERE user_name = '$userName' AND user_password = '$userPassword'";   
$res1 = mysqli_query($con,$sql);

if (mysqli_num_rows($res1) != 0){
    
    $sql2 = "SELECT 2 AS ERROR, User_id, User_device_reg_id FROM User_Device WHERE User_device_reg_id = '$regID' AND User_id = '$userId'";
    $res3 = mysqli_query($con,$sql2);
    
    if(mysqli_num_rows($res3) == 0){
        $sql = "INSERT INTO User_Device (User_device_reg_id, User_device_num_serie, User_id, User_device_status) VALUES('$regID','$numSerie','$userId', '$userDeviceStatus')";
    
        if(mysqli_query($con,$sql)){
            $sql = "UPDATE usuarios SET user_is_logged = '$isLogged' WHERE user_id = '$userId'";
            
            if($res = mysqli_query($con,$sql)){           
                while($row = mysqli_fetch_assoc ($res1))
                {
                    $jsonData[] = array_map('utf8_encode', $row);
                }            
                echo json_encode ($jsonData);
            }
        }
    }else{
        $sql = "UPDATE usuarios SET user_is_logged = '$isLogged' WHERE user_id = '$userId'";
            
        if($res = mysqli_query($con,$sql)){
            
            $sql = "UPDATE User_Device SET User_device_status = '$userDeviceStatus' WHERE User_device_reg_id = '$regID' AND User_id = '$userId'";
            $res4 = mysqli_query($con,$sql);
            
            while($row = mysqli_fetch_assoc ($res1))
            {
                $jsonData[] = array_map('utf8_encode', $row);
            }            
            echo json_encode ($jsonData);
        }
    }

}else{
    $sql = "SELECT 1 AS ERROR, 'Usuario invalido' AS MESSAGE";
    $res2 = mysqli_query($con,$sql);
    
    while($row = mysqli_fetch_assoc($res2)){
        $jsonData[] = array_map('utf8_encode', $row);
    }
    
    echo json_encode($jsonData);
}


?>