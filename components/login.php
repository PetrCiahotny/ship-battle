<?php
    include_once INCLUDE_PATH."/game_objects/Player.php";

?>
<form method="post" class="cover">
    <h2>přihlášení</h2>
    <input type="text" name="name" value="<?= $_POST['name'] ?? '' ?>" id="name" />
    <input type="password" name="password" value="" id="password" />
    <button name="action" value="přihlásit se" type="submit">přihlásit se</button>
</form>
<div>
    <?= $_SESSION['count'] ?>
</div>
