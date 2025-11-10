<?php

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ship battle</title>
        <link rel="stylesheet"  href="styles.css"/>
        <script type="text/javascript" src="script.js?v3"></script>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <style>
            .shipGrid {
                padding: 0;
                display: grid;
                grid-template-columns: repeat(<?= Game::getInstance()->gridCellCount ?>, <?= Game::getInstance()->cellSize ?>);
                grid-template-rows: repeat(<?= Game::getInstance()->gridCellCount ?>, <?= Game::getInstance()->cellSize ?>);
            }
            .shipCheck{
                width: 100%;
                height: 100%;
                margin: 0;
                border: solid 1px red;
            }
        </style>

    </head>
    <body>
        <header class="wave1 header">
        <h1><a href=<?= RELATIVE_ROOT ?>/>Ship battle <span></span></a></h1> <?php Player::getInstance()->getUserLinks(); ?>
        </header>
<?php
GameBase::renderMessages();
?>
