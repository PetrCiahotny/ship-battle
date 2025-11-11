<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


$webRoot = $_SERVER['DOCUMENT_ROOT'];
$webRootLength = strlen($webRoot);

/** Konstanta absolutní cesty k rootu URL na serveru např.: c:\xampp\httpdocs\adresar) */
define("INCLUDE_PATH", rtrim(realpath(__DIR__), "/\\"));

/** Konstanta relativní cesty k rootu URL na serveru např.: adresar (z URL http://localhost/adresar) */
define("WEB_PATH", rtrim(substr($webRoot, $webRootLength), "/\\"));

define("APP_NAME", 'Ship battle');