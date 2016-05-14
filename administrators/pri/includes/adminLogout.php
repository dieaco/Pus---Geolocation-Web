<?php 
 //Crear sesión
 session_start();
 //Vaciar sesión
 $_SESSION = array();
  // Si se desea destruir la sesión completamente, borre también la cookie de sesión.
// Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
 //Destruir Sesión
 session_destroy();
 //Redireccionar a login.php
 header("location: ../index.php");
?>