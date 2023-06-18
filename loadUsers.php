<?php

require "connection.php";

if(isset($_POST["requestJSONText"])){

    $requestJSONText = $_POST["requestJSONText"];
    $requestPhpObj = json_decode($requestJSONText);
    
    $userTable = Database::search("SELECT * FROM `user` WHERE `id`!='".$requestPhpObj->id."' AND (`fname` LIKE '".$_POST["text"]."%' OR `lname` LIKE '".$_POST["text"]."%') ");
    
    $phpResponseArray = array();
    
    for($x=0;$x<$userTable->num_rows;$x++){
        $phpArrayItemObject = new stdClass();
    
        $userTableRow = $userTable->fetch_assoc();
    
        $phpArrayItemObject->pic = $userTableRow["profile_url"];
        $phpArrayItemObject->name = $userTableRow["fname"]." ".$userTableRow["lname"];
        $phpArrayItemObject->id = $userTableRow["id"];
    
        $userChatTable = Database::search("SELECT * FROM `chat` WHERE (`user_from_id`='".$requestPhpObj->id."' AND `user_to_id`='".$userTableRow["id"]."')
        OR(`user_from_id`='".$userTableRow["id"]."' AND `user_to_id`='".$requestPhpObj->id."') ORDER BY `date_time` DESC");
    
        if($userChatTable->num_rows == 0){
            $phpArrayItemObject->msg = "";
            $phpArrayItemObject->time = "";
            $phpArrayItemObject->count = "0";
            $phpArrayItemObject->rstatus ="0";
        }else{

            $userChatTable2 = Database::search("SELECT * FROM `chat` WHERE (`user_from_id`='".$userTableRow["id"]."' AND `user_to_id`='".$requestPhpObj->id."') ORDER BY `date_time` DESC");
            //unseen chat count
            $unseenChatCount = 0;
    
            //first row 
            $lastChatRow = $userChatTable2->fetch_assoc();
            if($lastChatRow["status_id"]==1){
                $unseenChatCount++;
            }
    
            $phpArrayItemObject->msg = $lastChatRow["message"];
    
            $phpDateTimeObj = strtotime($lastChatRow["date_time"]);
            $timeStr = date('h:i a',$phpDateTimeObj);
    
            $phpArrayItemObject->time = $timeStr;
    
            for($t=0;$t<$userChatTable2->num_rows;$t++){
                //other rows
                $newChatRow = $userChatTable2->fetch_assoc();
                if($newChatRow==1){
                    $unseenChatCount++;
                }
            }
    
            $phpArrayItemObject->count = $unseenChatCount;

            $phpArrayItemObject->rstatus ="0";
    
        }
    
        array_push($phpResponseArray,$phpArrayItemObject);
    
    }
    
    $jsonResponseObject = json_encode($phpResponseArray);
    echo($jsonResponseObject);
    
}


?>