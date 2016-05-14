<?php
require('connect.php');

//Datos enviados para realizar validación de usuario
$usuario = $_POST["inputEmail"];   
$password = $_POST["inputPassword"];

//Consultamos que existe el usuario y que sea un administrador
$result = mysqli_query($con,"SELECT user_id, user_name, user_password, user_type_id FROM usuarios WHERE user_name = '$usuario' AND user_type_id = 2");

//Validamos si el nombre del administrador existe en la base de datos o es correcto
if($row = mysqli_fetch_array($result))
{     
//Si el usuario es correcto ahora validamos su contraseña
 if($row["user_password"] == $password)
 {
  //Creamos sesión
  session_start();  
  //Almacenamos el nombre de usuario en una variable de sesión usuario
  $_SESSION['username'] = $usuario;  
  $_SESSION['userId'] = $row['user_id'];
  //Redireccionamos a la pagina: index.php
  ?>
  <script languaje="javascript">  
  location.href = "../MiSUTERM.php";
  alert("Bienvenido al Sistema Push");
  </script>
  <?php
  
 }
 else
 {
  //En caso que la contraseña sea incorrecta enviamos un msj y redireccionamos a login.php
  ?>
  <script languaje="javascript">  
  location.href = "../index.php";
  alert("¡La contraseña es incorrecta!");
  </script>
  <?php
            
 }
}
else
{
 //en caso que el nombre de administrador es incorrecto enviamos un msj y redireccionamos a login.php
  ?>
  <script languaje="javascript">  
  location.href = "../index.php";
  alert("¡El usuario es incorrecto!");
  </script>
  <?php
        
}

//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
mysqli_free_result($result);

/*Mysql_close() se usa para cerrar la conexión a la Base de datos y es 
**necesario hacerlo para no sobrecargar al servidor, bueno en el caso de
**programar una aplicación que tendrá muchas visitas ;) .*/
mysqli_close();
?>