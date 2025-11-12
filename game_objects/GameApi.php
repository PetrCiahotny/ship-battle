<?php
/*
 * Copyright (c) 2025.
 * Petr Ciahotný
 */

include_once  $_SERVER["DOCUMENT_ROOT"]."/game_objects/GameBase.php";
include_once  $_SERVER["DOCUMENT_ROOT"]."/Db.php";
include_once  $_SERVER["DOCUMENT_ROOT"]."/game_objects/Logger.php";

class GameApi extends GameBase
{
    protected static ?GameApi $instance = null;
    public static function getInstance(): self
    {
        // TODO: Implement getInstance() method.
        throw new Exception('Not implemented');
    }
}