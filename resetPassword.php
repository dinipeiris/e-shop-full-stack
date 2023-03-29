<?php

require "connection.php";

$email = $_POST["e"];
$np = $_POST["n"];
$rnp = $_POST["r"];
$vcode = $_POST["v"];

if(empty($email)){ 
    echo ("Missing e-mail address.");
}else if(empty($np)){ 
    echo ("Please insert a new password.");
}else if(strlen($np) < 5 || strlen($np) > 20){
    echo ("Invalid password.");
}else if($np != $rnp){
    echo ("Passwords do not match.");
}else if(empty($vcode)){ 
    echo ("Please enter your verification code.");
}else{

    $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' AND `verification_code`='".$vcode."'");
    $n = $rs->num_rows;

    if($n == 1){

        Database::iud("UPDATE `user` SET `password` = '".$np."' WHERE `email`='".$email."'");
        echo("success");
    }else{
        echo ("Invalid e-mail or verification code.");
    }

}

?>