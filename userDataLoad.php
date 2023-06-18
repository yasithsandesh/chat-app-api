<?php
require 'connection.php';
if(isset($_GET["userId"])){

    $userId = $_GET["userId"];

   $userDataTable = Database::search("SELECT * FROM `user` INNER JOIN `country` ON `user`.`country_id_id`=`country`.`country_id` WHERE `id`='".$userId."'");
   $userDataTableRow = $userDataTable->fetch_assoc();

   $userDataArray = array();

   $userData = new stdClass();

   $userData->name = $userDataTableRow["fname"]." ".$userDataTableRow["lname"];
   $userData->about = $userDataTableRow["about"];
   $userData->mobile = $userDataTableRow["mobile"];
   $userData->email = $userDataTableRow["email"];
   $userData->country = $userDataTableRow["name"];

   array_push($userDataArray,$userData);

   $userDataJsonObj = json_encode($userDataArray);


   echo($userDataJsonObj);
}else{

$id = $_GET['id'];

$array = array();

$object = new stdClass();

//response data

$userTable = Database::search("SELECT * FROM `user` WHERE `id`='".$id."'");
$userTableRow = $userTable->fetch_assoc();




$object->pic = $userTableRow["profile_url"];
$object->fname = $userTableRow["fname"];
$object->lname = $userTableRow["lname"];
$object->mobile = $userTableRow["mobile"];
$object->about = $userTableRow["about"];

array_push($array,$object);

$jsonResponse = json_encode($array);

echo($jsonResponse);

}
