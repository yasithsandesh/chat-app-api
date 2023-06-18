<?php

require "connection.php";

$requestJsonUsersId = $_POST["requestJsonUsersId"];
$phpUsersIdObj = json_decode($requestJsonUsersId);

$user1 = $phpUsersIdObj->id1;
$user2 = $phpUsersIdObj->id2;
$status_id = $phpUsersIdObj->key;

Database::iud("UPDATE `chat` SET `status_id`='".$status_id."' WHERE (`user_from_id`='".$user2."' AND `user_to_id`='".$user1."')");

$chatTable = Database::search("SELECT * FROM `chat` INNER JOIN `status` ON `chat`.`status_id`=`status`.`id`
WHERE (`user_from_id`='".$user1."' AND `user_to_id`='".$user2."') OR (`user_from_id`='".$user2."' AND `user_to_id`='".$user1."') ORDER BY `date_time` ASC");

$chatArray = array();

for($x = 0;$x<$chatTable->num_rows;$x++){

    $chatTableRow = $chatTable->fetch_assoc();

    $chatObject = new stdClass();
    $chatObject->msg = $chatTableRow["message"];

    $phpDateTimeObj = strtotime($chatTableRow["date_time"]);
    $timeStr = date('h:i a',$phpDateTimeObj);

    $chatObject->time = $timeStr;

    if($chatTableRow["user_from_id"] == $user1){
        $chatObject->side = 'right';
    }else{
        $chatObject->side = 'left';
    }

    $chatObject->status = strtolower($chatTableRow["type"]);

    $chatArray[$x] = $chatObject;
}

$responseJson = json_encode($chatArray);
echo($responseJson);

?>