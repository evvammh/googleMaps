<?php 
//session_start();
//Paths & URL
$ABSPATH=dirname(__FILE__);
include("$ABSPATH/include/common.php");
include("$ABSPATH/classes/dbcon.php");
//Local Database connection
$DB_NAME = "testdb";
$DB_USER = "root";
$DB_PASSWORD = "";
$DB_HOST = "localhost";
define("DBPREFIX", "");
the done [jfsgorhjgahages 
//Configuration Variables
$conf_obj=new dbcon;
$conf_obj->Query("select * from ".DBPREFIX."config");
if($conf_rs=$conf_obj->FetchRow())
{
	$confArr=$conf_obj->fieldname();
	for($i=0;$i<sizeof($confArr);$i++)
	{
		${strtoupper($confArr[$i])}=$conf_rs[$confArr[$i]];
	}	
}
ini_set("session.gc_maxlifetime",50);
?>