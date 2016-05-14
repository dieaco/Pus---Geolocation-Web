<?php

//Variable utilizada para devolver JSON
$jsonData = array();
//Variables temporales para conexión a DB 
require "../includes/connect.php";

$tbody .= "";

$sql = "SELECT * FROM usuarios WHERE user_type_id = 1";

$res = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($res)){

    $sql2 = "SELECT 
                    COUNT(id_MSG) AS COUNT_READ_MESSAGES 
                FROM 
                    status 
                    INNER JOIN usuarios ON status.user_id = usuarios.user_id 
                WHERE 
                    status.user_id = '$row[0]'";
    $res2 = mysqli_query($con,$sql2);

    while($row2 = mysqli_fetch_array($res2)){

        $sql3 = "SELECT COUNT(id) AS COUNT_TOTAL_MESSAGES
                    FROM messages";
        $res3 = mysqli_query($con, $sql3);

        while($row3 = mysqli_fetch_array($res3)){
            //Cálculos necesarios para saber cuantos mensajes se enviaron, cuantos vistos y cuantos no vistos
            $totalMessages = $row3['COUNT_TOTAL_MESSAGES'];
            $totalRead = $row2['COUNT_READ_MESSAGES'];
            $totalUnread = $totalMessages - $totalRead;

            $tbody .= "<tr>";
            $tbody .= "<td>".$row['user_id']."</td>";
            $tbody .= "<td>".$row['user_name']."</td>";
            if($totalRead == 0){
                $tbody .= "<td style='text-align:center;'><a type='button' class='btn btn-primary' data-id='".$row['user_id']."'>".$totalRead."</a></td>";       
            }else{
                $tbody .= "<td style='text-align:center;'><a type='button' class='btn btn-primary btnWhoRead' data-id='".$row['user_id']."'>".$totalRead."</a></td>";           
            }
            if($totalUnread == 0){
                $tbody .= "<td style='text-align:center;'><a type='button' class='btn btn-primary' data-id='".$row['user_id']."'>".$totalUnread."</a></td>";
            }else{
                $tbody .= "<td style='text-align:center;'><a type='button' class='btn btn-primary btnWhoUnread' data-id='".$row['user_id']."'>".$totalUnread."</a></td>";
            }
            $tbody .= "<td style='text-align:center;'>".$totalMessages."</td>";
            $tbody .= "</tr>";

        }

    }
}

echo $tbody;

mysqli_close($con);

?>