<?php
/*
 * Copyright (c) 2025.
 * Petr Ciahotný
 */


class LogStruct{
    public string $message = '';
    public array $context = [] ;
    public string $className = '';
    public array $callStack = [];
    public string $fileInfo = '';
    protected static bool $allowRender = true;

    public function __construct(string $message, array $context = [], string $className = '')
    {
        $this->message = $message;
        $this->context = $context;
        $this->className = $className;
        $this->callStack = debug_backtrace();
        if(count($this->callStack) > 2){
            $this->fileInfo = $this->callStack[2]['file'].'::'.($this->callStack[2]['function'] ?? '--').'::'.$this->callStack[2]['line'];
        }
    }
}

class Logger
{
    protected static bool $allowLog = true;

    /**
     * @var array<LogStruct> $debugArray
     */
    protected static array $debugArray = [];


    public static function renderDebug(): void {
        if(!self::$allowLog){
            return;
        }
        ?>
            <div id="log-wrapper">
            <script>
                function toggleBackTrace(el){
                    el.parentNode.querySelector('pre')?.classList.toggle('d-none');
                }
            </script>
            <fieldset id="log-panel">
                <legend>Logger</legend>
                <ul>
                <?php
                foreach (self::$debugArray as $message) {?>
                    <li class="debugLine <?= $message->className ?>">
                        <?= $message->message ?>
                        <?php if(count($message->context) > 0) {
                            echo '<ul>';
                            foreach ($message->context as $key=>$context) {
                                echo "<li>{$key}: {$context}</li>";
                            }
                            echo '</ul>';
                        }
                        echo  "<div class='stackTrace'><div class='back-trace c-pointer' onclick='toggleBackTrace(this)'>back trace - {$message->fileInfo}</div><div class='backTrace'>";
                        echo "<pre class='d-none'>".print_r($message->callStack, true)."</pre>";
                        echo  "</div></div>";
                        ?>
                    </li>
                <?php }
                ?>
                </ul>
                <div class="method">GET:</div>
                <pre><?= print_r($_GET, true); ?></pre>
                <div class="method">POST:</div>
                <pre><?= print_r($_POST, true); ?></pre>
            </fieldset>
            </div>
        <?php
    }

    public static function log(string $message, array $context = [], string $logPrefix = '') : void
    {
        //$dir = "C:\\xampp\\htdocs\\lode\\logs\\"; // "/var/log/lode/";
        $dir = "/var/log/lode/";
        if(!file_exists($dir)){
            mkdir($dir, 0777, true);
            chmod($dir, 0777);
        }

        $date = date("Y-m-d");

        $log_file = "{$dir}{$logPrefix}{$date}.log";
        $contextStr = '';
        if(count($context) > 0){
            $contextStr = "\nContext: \n".print_r($context, true);
        }

        $ls = new LogStruct($message, $context, $logPrefix);
        self::$debugArray[] = $ls;
        if(self::$allowLog) {
            $f = fopen($log_file, "a");
            if($f) {
                fwrite($f, date("H-i-s") ." [".($_SESSION['id'] ?? 0)."] ". "\n{$message}\n\n");
                fclose($f);
            }
        }
    }
}
