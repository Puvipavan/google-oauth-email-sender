<?php
require_once("configs.php");

//Get access token from the authorization code
function exchange_authorization_code($code){
    global $client_id, $secret, $api_key;
    $url = "https://www.googleapis.com/oauth2/v4/token?key=".$api_key;
    $body = array("code" => $code, "client_id" => $client_id, "client_secret" => $secret, "redirect_uri" => "http://localhost/callback.php", "grant_type" => "authorization_code");
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($body));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = json_decode(curl_exec($curl), true);

    if(isset($response["error"])){
        return array(false, $response["error"]);
    }
    return array(true, $response);
    
}

//get email using the access token
function get_email($token){
    global $client_id, $secret, $api_key;
    $url = "https://www.googleapis.com/gmail/v1/users/me/profile?key=".$api_key;
    $headers = array("Authorization: Bearer ".$token);
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = json_decode(curl_exec($curl), true);

    if(isset($response["error"])){
        return array(false, $response["error"]["message"]);
    }
    return array(true, $response['emailAddress']);
}

//Convert email body to rfc5322 standard to send via google api
function base64encode_rfc5322($from_email, $to_email, $subject, $message){
    $email = "From: Email Sender<".$from_email.">
To: ".$to_email."
Subject: ".$subject."

".$message;
    return base64_encode($email);
}

//Send email using api
function send_email($token, $from_email, $to_email, $subject, $message){
    global $client_id, $secret, $api_key;
    
    $from_email = trim($from_email);
    $to_email = trim($to_email);
    $subject = trim($subject);
    
    $payload = '{"raw": "'.base64encode_rfc5322($from_email, $to_email, $subject, $message).'"}';
    $url = "https://www.googleapis.com/gmail/v1/users/me/messages/send?alt=json&key=".$api_key;
    $headers = array("Authorization: Bearer ".$token, 'Content-Type: application/json');
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = json_decode(curl_exec($curl), true);
    
    if(isset($response["error"])){
        return array(false, $response["error"]["message"]);
    }
    return array(true);
}
?>