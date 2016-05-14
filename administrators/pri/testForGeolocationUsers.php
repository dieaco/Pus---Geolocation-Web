<?php
include 'includes/connect.php';
header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");
    
define("GOOGLE_API_KEY", "AIzaSyDV7gCH6-UZbFG8cG_HXvc8-zXn0Vmpnng");
define("GOOGLE_GCM_URL", "https://android.googleapis.com/gcm/send");



function send_gcm_notify($reg_id, $message, $userId, $finalJsonArray) {
    $jsonArray =  $finalJsonArray;

    $fields = array(
        'registration_ids'  => array( $reg_id ),
        'data'              => array( "message" => $message,
                                        "messageId" => 'n',
                                        "geolocation" => 'y' ),
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

    array_push($jsonArray,
    array('success'=>substr($result,46,1),
          'userId'=>$userId
    ));

    return $jsonArray;
    //echo json_encode($jsonArray);
}

$finalJsonArray = array();

$sql = "SELECT * 
        FROM User_Device 
        WHERE User_device_status = 1 
        GROUP BY User_device_reg_id"; 

$res = mysqli_query($con,$sql);

while($row = mysqli_fetch_assoc ($res))
{
    $message = $row['User_device_id'];
    $regId = $row['User_device_reg_id'];
    $userId = $row['User_id'];

    $finalJsonArray = send_gcm_notify($regId, $message, $userId, $finalJsonArray);
}

echo json_encode($finalJsonArray);

mysqli_close($con);

?>