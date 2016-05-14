<?php

//if($_SERVER['REQUEST_METHOD']=='POST'){
    $regID = $_POST['regID'];
    $info = $_POST['info'];
    $usuario = "Helmut";
   // $timestamp = "Leido " . date("d/M/Y") . " a las " . date("h:i:sa");
   
   
    //echo "se recibio:".$handler;
    
include_once "includes/connect.php";


   // if (isset($_POST['regID'])) {
    
      $sql = "SELECT regID FROM devices WHERE regID = '$regID'";   
      $res = mysqli_query($con,$sql);
     
    
          if (mysqli_num_rows($res) == 0){
           
             $sql = "INSERT INTO devices (id_dev, regID, info, username) VALUES('','$regID','$info','$info')";
            // $res = mysqli_query($con,$sql);
             
             if(mysqli_query($con,$sql)){
              
              echo "Se ingreso correctamente la informacion a la Base de Datos";
              mysqli_close($con);
             }
             
             
             
             
          }
             /*
             else{
         
              echo "Fallo en registro de informacion en la base de datos, intente nuevamente";
              mysqli_close($con);
             }
          }

*/

 

    




//}


?>