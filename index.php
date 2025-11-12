<?php
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
        <title>Ship battle</title>
        <link rel="stylesheet"  href="styles.css"/>
        <script type="text/javascript" src="script.js?v3"></script>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <style>
            .shipGrid {
                padding: 0;
                display: grid;
                grid-template-columns: repeat(10, 3.5vw);
                grid-template-rows: repeat(10, 3.5vw);
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
            <h1><a href=<?= WEB_PATH ?>/>Ship battle <span></span></a></h1>
            <div>
                <a href="<?= WEB_PATH ?>/pages/login.php">přihlášení</a> / <a href="<?= WEB_PATH ?>/index.php?type=user&action=register">registrace</a>
            </div>
        </header>

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
