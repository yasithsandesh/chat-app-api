<?php

require "connection.php";

$jsonuserObj = $_POST['jsonRequestObj'];

$profileImg = $_FILES["profileImg"];

$phpuserdataObj = json_decode($jsonuserObj);


$id = $phpuserdataObj->id;
$fname = $phpuserdataObj->fname;
$lname = $phpuserdataObj->lname;
$mobile = $phpuserdataObj->mobile;
$about = $phpuserdataObj->about;
$phpResObj = new stdClass();

if (!preg_match("/07[0,1,2,3,4,5,6,7,8,9][0-9]/", $mobile)) {
    $phpResObj->msg = 'Invalid Mobile Number';
} else {
    $user_tb = Database::search("SELECT * FROM `user` WHERE `id`='" . $id . "'");
    $user_tb_row = $user_tb->fetch_assoc();

    if ($profileImg == null) {


        if (empty($user_tb_row["about"])) {
            Database::iud("INSERT INTO `user`(`about`)VALUES('" . $about . "') WHERE `id`='" . $id . "'");
            Database::iud("UPDATE `user` SET `fname`='" . $fname . "',`lname`='" . $lname . "',`mobile`='" . $mobile . "' WHERE `id`='" . $id . "' ");



            $phpResObj->msg = "done";
        } else {
            Database::iud("UPDATE `user` SET `fname`='" . $fname . "',`lname`='" . $lname . "',`mobile`='" . $mobile . "', `about`='" . $about . "'  WHERE `id`='" . $id . "' ");



            $phpResObj->msg = "done";
        }
    } else {


        if (empty($user_tb_row["about"])) {
            Database::iud("INSERT INTO `user`(`about`)VALUES('" . $about . "') WHERE `id`='" . $id . "'");
            Database::iud("UPDATE `user` SET `fname`='" . $fname . "',`lname`='" . $lname . "',`mobile`='" . $mobile . "', `profile_url`=''" . "uploads/" . $mobile . ".png" . "' WHERE `id`='" . $id . "' ");

            move_uploaded_file($profileImg["tmp_name"], "uploads/" . $mobile . ".png");

            $phpResObj->msg = "done";
        } else {
            Database::iud("UPDATE `user` SET `fname`='" . $fname . "',`lname`='" . $lname . "',`mobile`='" . $mobile . "', `about`='" . $about . "' , `profile_url`=''" . "uploads/" . $mobile . ".png" . "' WHERE `id`='" . $id . "' ");

            move_uploaded_file($profileImg["tmp_name"], "uploads/" . $mobile . ".png");

            $phpResObj->msg = "done";
        }
    }
}

$jsonResponseAlert = json_encode($phpResObj);
echo ($jsonResponseAlert);
