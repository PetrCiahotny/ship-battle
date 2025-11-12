<?php
/*
 * Copyright (c) 2025.
 * Petr Ciahotný
 */
?>
<form method="post" class="cover">
    <h2>registrace</h2>
    <input type="text" name="name" value="<?= $_POST['name'] ?? '' ?>" id="name" />
    <input type="password" name="password" value="" id="password" />
    <input type="password" name="password1" value="" id="password1" />
    <button name="action" value="register" type="submit">registrovat</button>
</form>