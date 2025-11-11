<?php
    include_once "../consts.php";
?>
<!DOCTYPE html>
<html>
    <?php  include_once "../components/header.php"; ?>
    <body>
        RELATIVE: <?= WEB_PATH ?><hr/>
        ABSOLUTE: <?= INCLUDE_PATH ?><hr/>
        WEB ROOT: <?= $_SERVER['DOCUMENT_ROOT'] ?><hr/>
        <?php include_once "../components/login.php"; ?>
    </body>
</html>
