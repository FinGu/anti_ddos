<?php
if(isset($_POST["post"])) //post test
    die("post");

if(isset($_GET["test"])) //get test
    die($_GET["test"]);

?>

<html>
<title>test</title>
<body><form method="post"> yo <br> <button name="post">abc</button> </form> </body>
</html>