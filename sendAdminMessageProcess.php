<?php

session_start();
require "connection.php";

$msg_txt = $_POST["t"];
$email = $_POST["r"];

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

// $sender;

// if(isset($_SESSION["u"])){

//     $sender = $_SESSION["u"]["email"];

// }else if(isset($_SESSION["au"])){

//     $sender = $_SESSION["au"]["email"];

// }

if(isset($msg_txt) && isset($email)){

    if(isset($_SESSION["u"]["email"])){
        Database::iud("INSERT INTO `chat`(`content`,`date_time`,`status`,`from`,`to`) VALUES 
        ('".$msg_txt."','".$date."','0','dinithidjava@gmail.com','".$email."')");

        echo "success";
    } else if (isset($_SESSION["au"]["email"])){
        Database::iud("INSERT INTO `chat`(`content`,`date_time`,`status`,`from`,`to`) VALUES 
        ('".$msg_txt."','".$date."','0','".$email."','dinithidjava@gmail.com')");

        echo "success";
    }

} else {
    echo "Something went wrong";
}

// if(empty($receiver)){
//     Database::iud("INSERT INTO `chat`(`content`,`date_time`,`status`,`from`,`to`) VALUES 
//     ('".$msg_txt."','".$date."','0','".$sender."','".$receiver."')");

//     echo "success";
// }else{
//     Database::iud("INSERT INTO `chat`(`content`,`date_time`,`status`,`from`,`to`) VALUES 
//     ('".$msg_txt."','".$date."','0','".$sender."','dinithidjava@gmail.com')");

//     echo "success2";
// }

?>