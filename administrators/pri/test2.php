<?php
    
define("GOOGLE_API_KEY", "AIzaSyDV7gCH6-UZbFG8cG_HXvc8-zXn0Vmpnng");
define("GOOGLE_GCM_URL", "https://android.googleapis.com/gcm/send");

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
    echo substr($result,46,1);
}


$message = $_REQUEST['message'];
$regId = $_REQUEST['regId'];

send_gcm_notify($regId, $message);

?>