<?php
/*
 * Copyright (c) 2025.
 * Petr Ciahotný
 */

?>
<form method="post" class="cover">
    <h2>přihlášení</h2>
    <input type="text" name="name" value="<?= $_POST['name'] ?? '' ?>" id="name" />
    <input type="password" name="password" value="" id="password" />
    <button name="action" value="přihlásit se" type="submit">přihlásit se</button>
</form>

