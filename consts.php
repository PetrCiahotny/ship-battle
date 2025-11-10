<?php
$webRoot = $_SERVER['DOCUMENT_ROOT'];
$webRootLength = strlen($webRoot);

/** Konstanta absolutní cesty k rootu URL na serveru např.: c:\xampp\httpdocs\adresar) */
define("INCLUDE_PATH", rtrim(realpath(__DIR__), "/\\"));

/** Konstanta relativní cesty k rootu URL na serveru např.: adresar (z URL http://localhost/adresar) */
define("WEB_PATH", rtrim(substr($webRoot, $webRootLength), "/\\"));

