<?php
include_once "consts.php";
//session_start();

/**
 * Konstanta relativní cesty k rootu URL na serveru např.: adresar (z URL http://localhost/adresar)
 */
//define("RELATIVE_ROOT", rtrim(dirname($_SERVER['PHP_SELF']), "/"));

//include_once ROOT . "/game_objects/Game.php";
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
            <h1><a href=<?= WEB_PATH ?>/>Ship battle <span></span></a></h1> <?php Player::getInstance()->getUserLinks(); ?>
        </header>
        <?php
            GameBase::renderMessages();
        ?>
        <div class="battleBody">
            <?php
            switch (GameBase::getParamByIndex(0)) {
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
