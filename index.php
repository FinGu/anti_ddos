<?php
include("funcs/include.php");

if(verify\check_and_create() != general\responses::success)
    die("!");

$handler2 = new reverse_proxy($_SERVER['REQUEST_URI'], "http://localhost/test.php", "deps/reverse_proxy.php", false);

$handler2->execute();

?>
