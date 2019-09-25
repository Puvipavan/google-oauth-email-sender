<?php
session_start();

$client_id = "CLIENT ID HERE";
$secret = "CLIENT SECRET HERE";
$api_key = "API KEY HERE";
$login_url = "https://accounts.google.com/o/oauth2/v2/auth?scope=https://www.googleapis.com/auth/gmail.metadata https://www.googleapis.com/auth/gmail.send&access_type=offline&include_granted_scopes=true&state=state_parameter_passthrough_value&redirect_uri=http://localhost/callback.php&response_type=code&client_id=".$client_id;

?>