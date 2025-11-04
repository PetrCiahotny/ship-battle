<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once $_SERVER["DOCUMENT_ROOT"] . "/game_objects/Game.php";
include_once Game::getInstance()->getRoot() . "/game_objects/Player.php";
include_once Game::getInstance()->getRoot() . "/game_objects/Board.php";
include_once Game::getInstance()->getRoot() . "/game_objects/History.php";
Game::getInstance()->init();
Player::getInstance()->init();
Board::getInstance()->init();
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet"  href="/styles.css"/>
        <script type="text/javascript" src="/script.js?v3"></script>
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
            <h1><a href="/">Ship battle <span></span></a></h1> <?php Player::getInstance()->getUserLinks(); ?>
        </header>
        <?php
            Game::getInstance()->renderMessages();
            Player::getInstance()->renderMessages();
            Board::getInstance()->renderMessages();
        ?>
        <div class="battleBody">
            <?php
            switch (Game::getInstance()->getRouteAtIndex(0)) {
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
