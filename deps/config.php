<?php
include_once ("simple-mysqli.php");

$db_obj = new \SimpleMySQLi("localhost", "root", "", "anti_ddos");
//https://github.com/WebsiteBeaver/Simple-MySQLi

$cookie_expiry = 1; // 1 minute session
$cookie_rate_limit = 500; //500 requests rate limit, if you pass this amount, you'll get your ip banned
