<?php

//if($_SERVER['REQUEST_METHOD']=='POST'){
    $handler = $_POST['handler'];
    $usuario = "Helmut";
    $text = $_POST['text'];
    $timestamp = "Leido " . date("d/M/Y") . " a las " . date("h:i:sa");
   echo $timestamp;
   
    //echo "se recibio:".$handler;
    
include_once('includes/connect.php');

 $sql = "INSERT INTO status (id, id_MSG, username, is_read, is_deleted, cuando, mensaje) VALUES('','$handler','$usuario','1','0','$timestamp','$text')";

    if(mysqli_query($con,$sql)){

        mysqli_close($con);
}
    
    else{
        echo 'oops! Please try again!';
}


//}


?>