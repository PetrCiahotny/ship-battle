<?php
/*
 * Copyright (c) 2025.
 * Petr Ciahotný
 */

include_once "consts.php";

include_once "game_objects/Game.php";
include_once "game_objects/Player.php";
include_once "game_objects/Board.php";
include_once "game_objects/History.php";
Game::getInstance()->init();
Player::getInstance()->init();
Board::getInstance()->init();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
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
            <h1><a href=<?= WEB_PATH ?>/>Ship battle <span class="lod"></span></a></h1> <?php Player::getInstance()->getUserLinks(); ?>
        </header>
        <?php
            GameBase::renderMessages();
        ?>
        <div class="battleBody">
            <?php
            switch (GameBase::getParamByKey(0)) {
                case 'user':
                    Player::getInstance()->render();
                    break;
                case 'history':
                    History::getInstance()->render();
                    break;
                default:
                    Game::getInstance()->render();
                    
                    break;
            }
            ?>
        </div>
    </body>
</html>
