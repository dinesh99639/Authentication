<?php

require 'Authentication.php';

// Data
$data = Array(
	"data" => "some data"
);

$session_data = Array(
	"expiry" => time() + 2592000,
	"data" => $data
);

print_r("Original data: ".json_encode($session_data)."<br/><br/>");
// print_r("Original form: ".json_decode($session_data)."<br/><br/>");

// Initiating the Authentication by passing the key to the constructor
$secret = "YOUR_SECRET_KEY";
echo "Secret key: ".$secret."<br/>";
$auth = new Authentication($secret);

echo "<br/>Encoding <br/>";
$session = $auth->encode($session_data);
print_r(json_encode($session, JSON_PRETTY_PRINT)."<br/><br/>");

print_r(json_decode($session['session'])->data);
// print_r("Original form: ".json_decode($session)."<br/><br/>");

// verifying signature by using correct data
print_r("Validation <br/><br/>Data: ".json_encode($session['session'])."<br/>");
$isValid = $auth->verify($session);
if ($isValid) echo "Valid<br/><br/>";
else echo "Invalid<br/><br/>";


// verifying signature by using modified data
$session['session'] .= "100";
print_r("Data: ".json_encode($session['session'])."<br/>");
$isValid = $auth->verify($session);
if ($isValid) echo "Valid<br/><br/>";
else echo "Invalid<br/><br/>";


// Changin Expiry time
$session['session'][11] = "0";
print_r("Data: ".json_encode($session['session'])."<br/>");
$isValid = $auth->verify($session);
if ($isValid) echo "Valid<br/><br/>";
else echo "Invalid<br/><br/>";


?>