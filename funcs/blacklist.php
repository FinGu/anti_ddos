<?php
namespace checks;

use general;

function is_ip_blacklisted($ip){
    global $db_obj;

    $ip_check = $db_obj->query("SELECT id FROM blacklisted WHERE ip=?", [$ip]);

    if($ip_check->numRows() != 0)
        return true;

    return false;
}

function blacklist_ip($ip){
    global $db_obj;

    $db_obj->query("INSERT INTO blacklisted(ip) VALUE(?)", [$ip]);

    return general\responses::success;
}
