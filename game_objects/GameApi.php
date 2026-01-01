<?php
/*
 * Copyright (c) 2025.
 * Petr Ciahotný
 */

require_once realpath("../consts.php");
include_once  "Game.php";

include_once  INCLUDE_PATH."/game_objects/GameBase.php";

class GameApi extends GameBase
{
    protected static ?GameApi $instance = null;

    public static function process()
    {
        if(Player::getInstance()->logged()) {
            $data = json_decode(file_get_contents('php://input'), true);
            $oldState = $data["state"];
            $oldGames = $data["games"];
            $currentState = Game::getInstance()->getCurrentState()->value;
            $availGames = Game::getInstance()->getAvailAbleGamesIds();
            $reload = ($oldState != $currentState || $oldGames != $availGames) ? 1 : 0;
            $resp = [
                'state' => 'OK',
                'oldState' => $oldState,
                'currentState' => $currentState,
                'reloadGame' => $reload,
            ];
        }else{
            $resp = ['state' => 'ERROR'];
        }
        echo json_encode($resp);
    }

    public static function getInstance(): self
    {
        // TODO: Implement getInstance() method.
        throw new Exception('Not implemented');
    }
}

GameApi::process();