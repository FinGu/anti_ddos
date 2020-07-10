<?php
namespace cookie;

use general;
use checks;

function fetch_session_data($session){
    global $db_obj;

    $sess_query = $db_obj->query("SELECT * FROM sessions WHERE `session`=?", [$session]);

    if($sess_query->numRows() == 0)
        return general\responses::invalid_cookie;

    return $sess_query->fetch();
}

function delete_session_cookie($session){
    global $db_obj;

    $db_obj->query("DELETE FROM sessions WHERE `session`=?", [$session]);

    return general\responses::success;
}

function create_session_cookie($ip) {
    global $db_obj, $cookie_expiry;

    $session_id = general\rand_str(14);

    $db_obj->query("INSERT INTO sessions(ip, `session`, expiry) VALUES(?,?,?)", array(
        $ip,
        $session_id,
        strtotime("+{$cookie_expiry} minutes")
    ));

    setcookie("adsess", $session_id);

    return general\responses::success;
}

function validate_session_cookie($session){
    global $db_obj;

    $sess_values = fetch_session_data($session);

    if($sess_values == general\responses::invalid_cookie)
        return $sess_values;

    if($sess_values["expiry"] > time() && $sess_values["ip"] == general\get_ip())
        return general\responses::success;

    delete_session_cookie($session);

    return general\responses::invalid_cookie;
}

function increment_session_rq_amount($session){
    global $db_obj, $cookie_rate_limit;

    $cook_val = fetch_session_data($session);

    if($cook_val == general\responses::invalid_cookie)
        return $cook_val;

    $new_rq_amount = $cook_val["rqs"] + 1;

    if($new_rq_amount > $cookie_rate_limit){
        checks\blacklist_ip($cook_val["ip"]);

        return general\responses::unsafe_not_allowed;
    }

    $db_obj->query("UPDATE sessions SET rqs=? WHERE `session`=?", [$new_rq_amount, $session]); //i'm quite sure this's slow as hell

    return general\responses::success;
}