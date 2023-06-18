<?php

require "connection.php";


$jsonRequestText = $_POST["jsonRequestText"];
$phpRequestObj = json_decode($jsonRequestText);

$profileImg = $_FILES["profileImg"];

$mobile = $phpRequestObj->mobile;
$fname = $phpRequestObj->fname;
$lname = $phpRequestObj->lname;
$email = $phpRequestObj->email;
$password = $phpRequestObj->password;
$rePassword= $phpRequestObj->rePassword;
$country = $phpRequestObj->country;

$alertObj = new stdClass();

if(empty($mobile)){
    $alertObj->alert = 'Please enter mobile';
}else if(strlen($mobile) !== 10){
    $alertObj->alert =  'Mobile Number must have 10 characters';
}else if(!preg_match("/07[0,1,2,3,4,5,6,7,8,9][0-9]/",$mobile)){
    $alertObj->alert = 'Invalid Mobile Number';
} else if (empty($fname)){
    $alertObj->alert = 'Please enter first name';
}else if(strlen($fname) >50){
    $alertObj->alert = 'First Name must have less than 50 characters';
}else if (empty($lname)){
    $alertObj->alert = 'Please enter last name';
}else if(strlen($lname) > 50){
    $alertObj->alert = 'Last Name must have less than 50 characters';
}else if(empty($email)){
    $alertObj->alert = 'Please enter email';
}else if(strlen($email) >= 100){
    $alertObj->alert = 'Email must have less than 100 characters';
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $alertObj->alert = 'Invalid Email';
}else if(empty($password)){
    $alertObj->alert = 'Please enter password';
}else if (strlen($password)<5 || strlen($password) > 10){
    $phpObject->alert = 'Password must be 5-10 characters';
}else if(empty($country)){
    $alertObj->alert = 'Please select your country';
} else{

if($password == $rePassword){

$countryTable = Database::search("SELECT `country_id` FROM `country` WHERE `name`='".$country."'");
$countryTableRow = $countryTable->fetch_assoc();

$country_id = $countryTableRow["country_id"];

Database::iud("INSERT INTO `user`(`fname`,`lname`,`email`,`password`,`mobile`,`country_id_id`,`profile_url`,`about`)
VALUES('".$fname."','".$lname."','".$email."','".$password."','".$mobile."','".$country_id."','"."uploads/".$mobile.".png"."','Hey there! I am OK')");

move_uploaded_file($profileImg["tmp_name"],"uploads/".$mobile.".png");

// $userId = Database::$connection->insert_id;

$alertObj->alert ='success';

}else{
    $alertObj->alert = 'The password you entered do not match';
}

}

$responseJsonObj = json_encode($alertObj);
echo($responseJsonObj);


?>