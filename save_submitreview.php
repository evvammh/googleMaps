<?php 
include_once("config.php");
include_once("$ABSPATH/include/functions.php");
include_once("$ABSPATH/classes/reviews.class.php");
$obj = new Reviews();
$obj->saveReview();
?>