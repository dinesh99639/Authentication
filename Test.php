<?php

require 'Authentication.php';

// Data
$data = Array(
	"data"=>"some data"
);
print_r("Original data: ".json_encode($data)."<br/><br/>");

// Initiating the Authentication by passing the key to the constructor
$secret = "YOUR_SECRET_KEY";
echo "Secret key: ".$secret."<br/>";
$auth = new Authentication($secret);

echo "<br/>Encoding <br/>";
$session = $auth->encode($data);
print_r(json_encode($session, JSON_PRETTY_PRINT)."<br/><br/>");

// verifying signature by using correct data
print_r("Validation <br/><br/>Data: ".json_encode($session['data'])."<br/>");
$isValid = $auth->verify($session);
if ($isValid) echo "Valid<br/><br/>";
else echo "Invalid<br/><br/>";

// verifying signature by using modified data
$session['data'] .= "100";
print_r("Data: ".json_encode($session['data'])."<br/>");
$isValid = $auth->verify($session);
if ($isValid) echo "Valid<br/><br/>";
else echo "Invalid<br/><br/>";



?>