<?php

require "connection.php";

$requestJson = $_POST["requestJson"];
$requestPhpObj = json_decode($requestJson);


$from_id = $requestPhpObj->from_user_id;
$to_id = $requestPhpObj->to_user_id;
$message = $requestPhpObj->message;

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date_time = $d->format("Y-m-d H:i:s");

Database::iud(" INSERT INTO `chat`(`message`,`date_time`,`user_from_id`,`user_to_id`,`status_id`)
VALUES('".$message."','".$date_time."','".$from_id."','".$to_id."','1')");

?>