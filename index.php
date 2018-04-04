<?php 
session_start();
require_once("./include/membersite_config.php");
if($_REQUEST["task"]=="logout"){
$fgmembersite->LogOut();
}
if($_REQUEST["page"]==""){$_REQUEST["page"]="custommap";}
include("top.php");
echo'<div class="forGreen">';
include_once($_REQUEST["page"].".php");
echo'</div>';
include_once("bottom.php");
?>

