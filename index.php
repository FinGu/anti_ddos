<?php
include("funcs/include.php");

if(verify\check_and_create() != general\responses::success)
    die("!");

$handler = new reverse_proxy($_SERVER['REQUEST_URI'], "http://localhost/test.php", "deps/reverse_proxy.php", false);

$handler->execute();

?>
