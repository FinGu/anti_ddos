<?php
//powered by fraudguard.io

namespace checks;

use general;

$user = "";
$pass = "";
//https://app.fraudguard.io/keys

function ip_risk_check($ip){
    global $user, $pass;

    $curl_handle = curl_init();

    curl_setopt($curl_handle, CURLOPT_URL,
        "https://api.fraudguard.io/v2/ip/" .
        curl_escape($curl_handle, $ip));

    curl_setopt($curl_handle, CURLOPT_USERPWD, "$user:$pass");
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

    $response_array = json_decode(curl_exec($curl_handle));

    if($response_array->risk_level >= 4)
        return general\responses::unsafe_not_allowed;

    if($response_array->risk_level >= 2)
        return general\responses::unsafe_allowed;

    return general\responses::safe_allowed;
}
