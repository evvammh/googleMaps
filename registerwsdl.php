<?php

// Pull in the NuSOAP code
require_once('nusoap.php');
require_once('process_registerwsdlclient.php');
// Create the server instance
$server = new soap_server();
// Initialize WSDL support
$server->configureWSDL('registerwsdl', 'urn:registerwsdl');
// Register the method to expose
$server->register('register', // method name
        array('name' => 'xsd:string'
    , 'email' => 'xsd:string'
   // , 'username' => 'xsd:string' //commented as per the new requirements
    , 'password' => 'xsd:string'
    , 'phone_number' => 'xsd:string'
    , 'default_airport' => 'xsd:string'
    , 'default_airspeed' => 'xsd:string'
    , 'chk_email' => 'xsd:string'
    , 'chk_sms' => 'xsd:string'
    , 'chk_pdf_file' => 'xsd:string'
        ), // input parameters
        array('return' => 'xsd:string'), // output parameters
        'urn:registerwsdl', // namespace
        'urn:registerwsdl#register', // soapaction
        'rpc', // style
        'encoded', // use
        'This method saves the user information for registration.'			// documentation
);

// Define the method as a PHP function
function register($name, $email, $password, $phone_number, $default_airport, $default_airspeed, $chk_email, $chk_sms, $chk_pdf_file) {

    $_POST["name"] = $name;
    $_POST["email"] = $email;
    //$_POST["username"] = $username;
    $_POST["password"] = $password;
    $_POST["phone_number"] = $phone_number;
    $_POST["default_airport"] = $default_airport;
    $_POST["default_airspeed"] = $default_airspeed;
    $_POST["chk_email"] = $chk_email; /* supposed to pass 1 or 0 */
    $_POST["chk_sms"] = $chk_sms; /* supposed to pass 1 or 0 */
    $_POST["chk_pdf_file"] = $chk_pdf_file; /* supposed to pass 1 or 0 */

    $obj = new UserRegistration();
    /* To check empty fieldds */
    $objResult = $obj->checkRequiredFields($name, $email, $password, $phone_number, $default_airport, $default_airspeed);
    if ($objResult->result) {
        
    } else {
        return $objResult->message;
    }

    /* To check duplicate username */
    /*
	commented as per the new requirements
	$objResult = $obj->checkUserName($username);
    if ($objResult->result) {
        
    } else {
        return $objResult->message;
    }*/

    /* To check duplicate eamil id */
    $objResult = $obj->checkEmail($email);
    if ($objResult->result) {
        
    } else {
        return $objResult->message;
    }
    

    /*     * ****Change the database username and password according to environment***** */
    $link = mysql_connect('localhost', 'root', '') or die('Cannot connect to the DB');
    mysql_select_db('testdb', $link) or die('Cannot select the DB');
    $query = "INSERT INTO  `testdb`.`fgusers` (
`id_user` ,
`name` ,
`email` ,
`phone_number` ,

`password` ,
`default_airport` ,
`default_airspeed` ,
`confirmcode`
)
VALUES (
NULL ,  '" . $_POST["name"] . "',  '" . $_POST["email"] . "',  '" . $_POST["phone_number"] . "',  '" . $_POST["password"] . "',  '" . $_POST["default_airport"] . "',  '" . $_POST["default_airspeed"] . "',  'y'
);";

//return $query;
    $result = mysql_query($query, $link);


    $_POST["submitted"] = 1;
    if ($result) {
        $obj->sendRegistrationMail($email,$name,$password);
        return "saved";
    } else {
        return "fail";
    }
}

// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
