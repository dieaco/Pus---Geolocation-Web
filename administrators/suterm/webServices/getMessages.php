<?php
include_once('../includes/connect.php');

$userId = (int)$_REQUEST['userId'];
$limit = (int)$_REQUEST['limit'];
$isReadDefault = 0;
 
$sql = "SELECT id, mensaje, timestamp, IFNULL(picture, '') AS picture
        FROM messages        
        ORDER BY messages.id DESC 
        LIMIT $limit";

$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
    
    $sql2 = "SELECT status.is_read
                FROM messages LEFT JOIN status
                ON messages.id = status.id_MSG
                WHERE status.user_id = '$userId' AND messages.id = '$row[0]'";
    $res2 = mysqli_query($con,$sql2);
    
    if(mysqli_num_rows($res2) == 0){
        array_push($result,
        array('id'=>$row[0],
              'mensaje'=>$row[1],
              'timestamp'=>$row[2],
              'isRead'=>$isReadDefault,
              'userId'=>$userId,
              'picture'=>$row[3]
        ));        
    }else{
        while($row2 = mysqli_fetch_array($res2)){
            array_push($result,
            array('id'=>$row[0],
                  'mensaje'=>$row[1],
                  'timestamp'=>$row[2],
                  'isRead'=>$row2[0],
                  'userId'=>$userId,
                  'picture'=>$row[3]
            ));
        }       
    }  
    
}
 
echo json_encode(array("result"=>$result));
 
mysqli_close($con);
 
?>