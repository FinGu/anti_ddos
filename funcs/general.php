<?php
namespace general;

class responses{
    const unsafe_not_allowed = "unsafe_not_allowed";
    const unsafe_allowed = "unsafe_allowed";
    const safe_allowed = "safe_allowed";

    const success = "success";

    const invalid_cookie = "invalid_cookie";
}

function get_ip(){
    if(isset($_SERVER["REMOTE_ADDR"]))
        return $_SERVER["REMOTE_ADDR"];

    if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        return $_SERVER["HTTP_X_FORWARDED_FOR"];

    if(isset($_SERVER["REMOTE_ADDR"]))
        return $_SERVER["REMOTE_ADDR"];

    return "unknown";
}

function rand_str($length = 10){
    $ret = '';

    $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

    for($i = 0; $i < $length; $i++){
        $rand_index = mt_rand(0, strlen($alphabet) - 1);

        $ret .= $alphabet[$rand_index];
    }
    return $ret;
}
