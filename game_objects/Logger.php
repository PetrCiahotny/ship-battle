<?php

class Logger
{
    public static function log(string|array $message, string $logPrefix = '') : void
    {

        $dir = "C:\\xampp\\htdocs\\lode\\logs\\"; // "/var/log/lode/";
        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
            chmod($dir, 0777);
        }

        $date = date("Y-m-d");
        $log_file = "{$dir}{$logPrefix}{$date}.log";

        if(is_array($message)){
            $message = print_r($message, true);
        }

        if(true) {
            $f = fopen($log_file, "a");
            if($f) {
                fwrite($f, date("H-i-s") ." [".($_SESSION['id'] ?? 0)."] ". "\n{$message}\n\n");
                fclose($f);
            }
        }
    }
}
