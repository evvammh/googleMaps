<?php

// Pull in the NuSOAP code
require_once('nusoap.php');
// Create the client instance
$client = new nusoap_client('http://localhost/golfpilot/registerwsdl.php?wsdl', true);
// Check for an error
$err = $client->getError();
if ($err) {
    // Display the error
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
    // At this point, you know the call that follows will fail
}
// Call the SOAP method
/* * ***pass the values as you want***** */
$result = $client->call('register', array('name' => 'sameer singh'
            , 'email' => 'sameer.aswal@mind-infotech.com'
            //, 'username' => 'samvxveeraswal'
            , 'password' => 'password'
            , 'phone_number' => '9990140564'
            , 'default_airport' => 'delhi'
            , 'default_airspeed' => '3'
            , 'chk_email' => '1'
            , 'chk_sms' => '0'
            , 'chk_pdf_file' => '1'
        ));
// Check for a fault
if ($client->fault) {
    echo '<h2>Fault</h2><pre>';
    print_r($result);
    echo '</pre>';
} else {
    // Check for errors
    $err = $client->getError();
    if ($err) {
        // Display the error
        echo '<h2>Error</h2><pre>' . $err . '</pre>';
    } else {
        // Display the result
        echo '<h2>Result</h2><pre>';
        print_r($result);
        echo '</pre>';
    }
}
// Display the request and response
echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
// Display the debug messages
echo '<h2>Debug</h2>';
echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
?>