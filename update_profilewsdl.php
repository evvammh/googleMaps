<?php

// Pull in the NuSOAP code
require_once('nusoap.php');

// Create the server instance
$server = new soap_server();
// Initialize WSDL support
$server->configureWSDL('update_profilewsdl', 'urn:update_profilewsdl');
// Register the method to expose
$server->register('update_profile', // method name
        array('name' => 'xsd:string'
    , 'email' => 'xsd:string'
    , 'username' => 'xsd:string'
    , 'password' => 'xsd:string'
    , 'phone_number' => 'xsd:string'
    , 'default_airport' => 'xsd:string'
    , 'default_airspeed' => 'xsd:string'
   
        ), // input parameters
        array('return' => 'xsd:string'), // output parameters
        'urn:update_profilewsdl', // namespace
        'urn:update_profilewsdl#update_profile', // soapaction
        'rpc', // style
        'encoded', // use
        'This method updates the user information.'			// documentation
);

// Define the method as a PHP function
function update_profile($name, $email, $username, $password, $phone_number, $default_airport) {

    $_POST["name"] = $name;
    $_POST["email"] = $email;
    $_POST["username"] = $username;
    $_POST["password"] = $password;
    $_POST["phone_number"] = $phone_number;
    $_POST["default_airport"] = $default_airport;
    $_POST["default_airspeed"] = $default_airspeed;
   

    /*     * ****Change the database username and password according to invironment***** */
    $link = mysql_connect('localhost', 'root', '') or die('Cannot connect to the DB');
    mysql_select_db('testdb', $link) or die('Cannot select the DB');
 
    
     $query = "UPDATE  `testdb`.`fgusers` SET
`email`= '" . $_POST["email"] . "',
`phone_number` = '" . $_POST["phone_number"] . "',
`password`= '" . $_POST["password"] . "',
`default_airport` = '" . $_POST["default_airport"] . "',
`default_airspeed` = '" . $_POST["default_airspeed"] . "'
WHERE username='" . $_POST["username"] . "'";


//return $query;
    $result = mysql_query($query, $link);


    $_POST["submitted"] = 1;
    if ($result) {
        return "saved";
    } else {
        return "fail";
    }
}

// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
