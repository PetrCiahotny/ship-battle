<?php
/**
 * Tento soubor musí být umisten v rootu (korenu) aplikace, napr. c:\Xampp\htdocs\lode
 */
session_start();

define("enviroment", "xamp");
//define("enviroment", "docker"); 


header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


/** Konstanta absolutní cesty k rootu URL na serveru např.: c:\xampp\htdocs\lode) */
define("INCLUDE_PATH", rtrim(realpath(__DIR__), "/\\"));

/** Konstanta relativní cesty k rootu URL na serveru např.: adresar (z URL http://localhost/lode) */
//define("WEB_PATH", rtrim(dirname($_SERVER['PHP_SELF']), "/"));
define("WEB_PATH", str_replace("\\", "/", substr(__DIR__, mb_strlen($_SERVER['DOCUMENT_ROOT']))));

define("APP_NAME", 'Ship battle');

include_once INCLUDE_PATH."/game_objects/GameBase.php";