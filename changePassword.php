<?php

require 'connection.php';

if(isset($_POST["passwordJsonObj"])){
    $passwordJsonObj = $_POST["passwordJsonObj"];
    $passwordPhpObj = json_decode($passwordJsonObj);

    $userId = $passwordPhpObj->userId;
    $password = $passwordPhpObj->password;
    $reEnterPassword = $passwordPhpObj->reEnterPassword;

    $phpObject = new stdClass();

    if(strlen($password)<5 || strlen($password) >10){
        $phpObject->alert = 'Password must be 5-10 characters';
    }else{
        if($password == $reEnterPassword){

            $phpObject->id = $userId;
            Database::iud("UPDATE `user` SET `password`='".$password."'  WHERE `id`='".$userId."'");
    
            $phpObject->alert = 'Password changed successfully';
    
        }else{
    
            $phpObject->alert = 'The password you entered do not match';
    
        }
    }

    
    $jsonResponseAlert = json_encode($phpObject);
    echo($jsonResponseAlert);

}

?>