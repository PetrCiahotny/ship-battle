<?php
/*
 * Copyright (c) 2025.
 * Petr Ciahotný
 */

class Logger
{
    protected static bool $allowLog = true;
    protected static array $debugArray = [];

    public static function debug(string|array|Throwable $message): void {
        self::$debugArray[] = $message;
    }

    public static function renderDebug(): void {
        ?>
            <div><?php
                foreach (self::$debugArray as $message) {?>
                    <div class="debugLine"><?= $message ?></div>
                <?php }
            ?>
            </div>
                <?php if(GameBase::isPost()){ ?>
                    <pre><?= print_r($_POST, true); ?></pre>
        <?php   }
    }

    public static function log(string|array $message, string $logPrefix = '') : void
    {

        //$dir = "C:\\xampp\\htdocs\\lode\\logs\\"; // "/var/log/lode/";
        $dir = "/var/log/lode/";
        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
            chmod($dir, 0777);
        }

        $date = date("Y-m-d");
        $log_file = "{$dir}{$logPrefix}{$date}.log";

        if(is_array($message)){
            $message = print_r($message, true);
        }

        if(self::$allowLog) {
            $f = fopen($log_file, "a");
            if($f) {
                fwrite($f, date("H-i-s") ." [".($_SESSION['id'] ?? 0)."] ". "\n{$message}\n\n");
                fclose($f);
            }
        }
    }
}
