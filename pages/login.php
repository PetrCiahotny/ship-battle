<?php
include_once "../consts.php";


?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        RELATIVE: <?= WEB_PATH ?><hr/>
        ABSOLUTE: <?= INCLUDE_PATH ?><hr/>
        WEB ROOT: <?= $_SERVER['DOCUMENT_ROOT'] ?><hr/>
        <?php include_once INCLUDE_PATH . "/components/login.php"; ?>
    </body>
</html>
