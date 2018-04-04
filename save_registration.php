<?PHP
require_once("./include/membersite_config.php");


$_POST["name"]=$_GET["name"];
$_POST["email"]=$_GET["email"];
$_POST["username"]=$_GET["username"];
$_POST["password"]=$_GET["password"];
$_POST["phone_number"]=$_GET["phone_number"];
$_POST["default_airport"]=$_GET["default_airport"];
$_POST["default_airspeed"]=$_GET["default_airspeed"];
$_POST["chk_email"]=$_GET["chk_email"];/*supposed to pass 1 or 0*/
$_POST["chk_sms"]=$_GET["chk_sms"];/*supposed to pass 1 or 0*/
$_POST["chk_pdf_file"]=$_GET["chk_pdf_file"];/*supposed to pass 1 or 0*/
$_POST["submitted"]=1;
 $url="http://localhost/golfpilot/save_registration.php?name=name&email=aalddd@dmai.com&username=66ui&password=Mind1234&phone_number=9990140564&default_airport=delhi&default_airspeed=1&chk_email=1&chk_sms=1&chk_pdf_file=1";
echo"<pre>";print_r($_POST);echo"</pre>";

   if($fgmembersite->RegisterUser())
   {
        echo"saved";
   }
   else{
   echo"fail";
   }

?>