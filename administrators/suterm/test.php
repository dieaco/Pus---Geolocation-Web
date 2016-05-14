<?php
    
define("GOOGLE_API_KEY", "AIzaSyDkDbVOMWlzZbxe4ud1mNr5TJlAk347L8g");
define("GOOGLE_GCM_URL", "https://android.googleapis.com/gcm/send");

include_once "includes/connect.php";

//Función para envío de notificación
function send_gcm_notify($reg_id, $message) {
    $fields = array(
        'registration_ids'  => array( $reg_id ),
        'data'              => array( "message" => $message ),
    );

    $headers = array(
        'Authorization: key=' . GOOGLE_API_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, GOOGLE_GCM_URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $result = curl_exec($ch);

    if ($result === FALSE) {
        die('Problema con la Ejecucion del CURL ' . curl_error($ch));
    }

    curl_close($ch);
    //echo substr($result,46,1);
    //Devuelve 1 si hubo éxito ó 0 si falló el envío
    return substr($result,46,1);
}

//Variables a insertar en la BD
$message = $_REQUEST['message'];
$timestamp = date("d-M-Y") . " - " .date("h:i:sa");
$totalSent = 0;
$totalUnsent = 0;

//Se buscan los dispositivos registrados y que estés activos(con sesión iniciada) para enviar notificación
$sql2 = "SELECT * FROM User_Device WHERE User_device_status = 1 GROUP BY User_device_reg_id ";

$res2 = mysqli_query($con,$sql2);

//variable para control de respuesta en la carga de imagen
$ROOT = "";

if(isset($_FILES["inputImage"]["name"])){
    if($_FILES["inputImage"]["name"] == ""){
        while($row2 = mysqli_fetch_array($res2)){
            $reg_id = $row2[1];
            //Se contabiliza el total de notificaciones enviadas y no enviadas
            if(send_gcm_notify($reg_id, $message) == 1){
                $totalSent = $totalSent + 1;
            }else{
                $totalUnsent = $totalUnsent + 1;
            }
        }
        //Se inserta mensaje
        $sql = "INSERT INTO messages (mensaje, timestamp, total_sent, total_unsent) VALUES('$message', '$timestamp', '$totalSent', '$totalUnsent')";
        $res = mysqli_query($con,$sql);
        //Se devuelve el número de notificaciones que fueron enviadas exitosamente
        echo $totalSent;
    }else{
        //Se verifica que la imagen haya sido almacenada con éxito
        $ROOT = getImageFromForm();

        if($ROOT == "1"){//Ocurrió error al subir la imagen
            echo "-1";
        }else if($ROOT == "2"){//Ya existe imagen con ese nombre en la ruta
            echo "-2";
        }else if($ROOT == "3"){//No es un archivo compatible o excede el tamaño permitido a cargar
            echo "-3";
        }else{//Se registra y se envia notificación
            while($row2 = mysqli_fetch_array($res2)){
                $reg_id = $row2[1];
                //Se contabiliza el total de notificaciones enviadas y no enviadas
                if(send_gcm_notify($reg_id, $message) == 1){
                    $totalSent = $totalSent + 1;
                }else{
                    $totalUnsent = $totalUnsent + 1;
                }
            }

            //Se inserta mensaje
            $sql = "INSERT INTO messages (mensaje, timestamp, total_sent, total_unsent, picture) VALUES('$message', '$timestamp', '$totalSent', '$totalUnsent', '$ROOT')";
            $res = mysqli_query($con,$sql);
            //Se devuelve el número de notificaciones que fueron enviadas exitosamente
            echo $totalSent;

        }
    }
}

//Se cierra conexión
mysqli_close($con);


//Función para almacenar imagenes en servidor
function getImageFromForm(){
    $finalRoot = "";
    //Definir Tamaño de archivo 5MB
    define('LIMITE', 20000);
    //Definir arreglo con extensiones permitidas usar serialize
    define('ARREGLO', serialize( array('image/jpg', 'image/jpeg', 'image/gif','image/png')));
     
    $PERMITIDOS = unserialize(ARREGLO); //Usar unserialize para obtener el arreglo    
 
    if (in_array($_FILES['inputImage']['type'], $PERMITIDOS) && $_FILES['inputImage']['size'] <= LIMITE * 1024){

        //Desde subir.php a la carpeta imagenes hay que salir un directorio
        //../imagenes/nombreDeArchivo

        $rutaEnServidor = "img_for_messages/" . $_FILES['inputImage']['name'];

        $finalRoot = "http://www.entuizer.tech/administrators/suterm/img_for_messages/" . $_FILES['inputImage']['name'];

        if (!file_exists($rutaEnServidor)){
            $resultado = move_uploaded_file($_FILES["inputImage"]["tmp_name"], $rutaEnServidor);
            if ($resultado){
                return $finalRoot;

            }else {
                /*echo'<script type="text/javascript">
                    alert("Ocurrió un error al mover archivo");
                    </script>';*/
                $finalRoot = "1";
                return $finalRoot;
            }

        }else{

            /*echo'<script type="text/javascript">
                    alert("Este archivo ya existe en la BD");
                    </script>';*/
            $finalRoot = "2";
            return $finalRoot;
        }

    }else {
        /*echo'<script type="text/javascript">
                    alert("Tipo de archivo no permitido o excede tamaño");
                    </script>';*/
        $finalRoot = "3";
        return $finalRoot;
    }
}
 

?>