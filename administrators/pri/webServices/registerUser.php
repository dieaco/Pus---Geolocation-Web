<?php

header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");

    $userName = $_REQUEST['userName'];
    $userPassword = $_REQUEST['userPassword'];
    $userType = (int) $_REQUEST['userType'];
    $userCompany = (int) $_REQUEST['userCompany'];
    $isLogged = (int) $_REQUEST['userIsLogged'];
    $timeStamp = "logged " . date("d/M/Y") . " a las " . date("h:i:sa");
   
   
    include_once('../includes/connect.php');
    
      $sql = "SELECT user_name, 1 AS ERROR FROM usuarios WHERE user_name = '$userName'";   
      $res1 = mysqli_query($con,$sql);
     
    
    if (mysqli_num_rows($res1) == 0){
       $sql = "INSERT INTO usuarios (user_name, user_password, user_type_id, user_company_id, user_is_logged, user_last_login) VALUES('$userName','$userPassword', '$userType', '$userCompany', '$isLogged', '$timeStamp')";
       
      if(mysqli_query($con,$sql)){       
        
        $sql = "SELECT user_id, 0 AS ERROR FROM usuarios WHERE user_name = '$userName' AND user_password = '$userPassword'";
        $jasonData = array();
        $res = mysqli_query($con,$sql);
        
          if($res){
              
              while($row = mysqli_fetch_assoc ($res))
              {
                  $jasonData[] = array_map('utf8_encode', $row);
              }             
              }  
      
        echo json_encode ($jasonData);
        // echo "Se ingreso correctamente la informacion a la Base de Datos ";
        mysqli_close($con);
       }             
       else{
   
        echo "Fallo en registro de informacion en la base de datos, intente nuevamente";
        mysqli_close($con);
       }
       
    }
    else{
      $jasonData1 = array();
       if($res1){
          while($row = mysqli_fetch_assoc ($res1))
          {
              $jasonData1[] = array_map('utf8_encode', $row);
          }
       }
      
        echo json_encode ($jasonData1);
        // echo "Se ingreso correctamente la informacion a la Base de Datos ";
        mysqli_close($con);
      
    }
?>