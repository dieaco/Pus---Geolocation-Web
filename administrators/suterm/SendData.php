<?php
include_once('includes/connect.php');
 
$sql = "SELECT messages.id, messages.mensaje, messages.timestamp,
                IFNULL( status.is_read, 0 ) AS is_read , IFNULL( status.user_id, 0 ) AS user_id 
        FROM messages
        LEFT JOIN status ON messages.id = status.id_MSG
        ORDER BY messages.id DESC 
        LIMIT 10";
 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
array_push($result,
array('id'=>$row[0],
      'mensaje'=>$row[1],
      'timestamp'=>$row[2],
      'isRead'=>$row[3],
      'userId'=>$row[4]
));
}
 
echo json_encode(array("result"=>$result));
 
mysqli_close($con);
 
?>