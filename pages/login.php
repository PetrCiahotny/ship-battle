<?php
/*
//include_once  $_SERVER["DOCUMENT_ROOT"]."/components/Game.php";
include_once  $_SERVER["DOCUMENT_ROOT"]."/game_objects/Game.php";
include_once  Game::getInstance()->getRoot()."/game_objects/Gamer.php";

include_once Game::getInstance()->getRoot()."/components/Header.php";
?>
<div>
    <h2>přihlášení</h2>
    <?php  ?>
    <div style="border: solid 1px black; padding: 5px 10px; width: 200px">
        <form enctype="application/x-www-form-urlencoded" accept-charset="UTF-8" method="post" style="display: flex; flex-direction: column; gap: 5px; width: 100px">
            <label for="jmeno">Jméno
                <input type="text" name="jmeno" value="<?= $_POST['jmeno'] ?? '' ?>" id="jmeno"/>
            </label>
            <label for="heslo">Heslo
                <input  type="password" name="heslo" <?= $_POST['heslo'] ?? '' ?> id="heslo"/>
            </label>
            <input id="uloz" name="<?= $type == DialogType::LOGIN ? 'login' : 'registrace' ?>" type="submit"/>
        </form>
    </div>
</div>
*/