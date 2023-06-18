<?php

require "connection.php";

$jsonRequestText = $_POST["jsonRequestText"];
$phpRequestObj = json_decode($jsonRequestText);

$mobile = $phpRequestObj->mobile;
$password = $phpRequestObj->password;

$userTable = Database::search("SELECT * FROM `user` WHERE `mobile`='".$mobile."' AND `password`='".$password."'");

$phpResponseObj = new stdClass();

if($userTable->num_rows == 0){
    $phpResponseObj->msg = "Error";
}else{
    $phpResponseObj->msg = "Success";
    $userTableRow = $userTable->fetch_assoc();
    $phpResponseObj->user = $userTableRow;
}

$jsonResponseText = json_encode($phpResponseObj);

echo($jsonResponseText);

?>