<?php
namespace verify;

use general;
use cookie;
use checks;

function check_and_create(){
    $ip = general\get_ip();

    $validate_cookie = cookie\validate_session_cookie($_COOKIE["adsess"] ?? null);

    if($validate_cookie == general\responses::success) {
        cookie\increment_session_rq_amount($_COOKIE["adsess"]);

        return $validate_cookie;
    }

    if(checks\is_ip_blacklisted($ip))
        return general\responses::unsafe_not_allowed;

    $ip_allowed = checks\ip_risk_check($ip);

    if($ip_allowed == general\responses::unsafe_not_allowed) {
        checks\blacklist_ip($ip);

        return $ip_allowed;
    }

    if($ip_allowed == general\responses::unsafe_allowed) {
        $vh_result = checks\validate_headers();

        if ($vh_result != general\responses::success) {
            checks\blacklist_ip($ip);

            return $vh_result;
        }
    }

    cookie\create_session_cookie($ip);

    return general\responses::success;
}