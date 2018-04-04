<?php

include_once("config.php");
include_once("$ABSPATH/include/functions.php");
include_once("$ABSPATH/classes/forgotpassword.class.php");
$obj = new Forgotpassword();
if ($_REQUEST["task"] == "save_password") {
    $obj->save_new_password();
} else {
    $obj->sendForgotpassword();
}
?>