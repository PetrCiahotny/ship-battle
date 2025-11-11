<?php
include_once "game_objects/Message.php";

abstract class  GameBase
{
    /**
     * @var array<Message> $messages
     */
    protected static array $messages = array();
    protected static ?array $routes = null;
    

    protected function __construct()
    {
    }

    public function init() : void
    {

    }

    protected function addMessage(string $message, MessageLevel $level) : void{
        self::$messages[] = new Message($message, $level);
    }

    public static function renderMessages() : void
    {
        foreach (self::$messages as $message) {
            ?>
                <div class="message <?= $message->getLevel()->toString() ?>">
                    <?= $message->getMessage() ?>
                </div>
            <?php
        }
    }

    public static function reload() : void{
        header('Location: '.WEB_PATH.'/');
        die();
    }

    public function render() : void
    {

    }

    public static function getLinkUrl(string $route): string
    {
        $params = explode('/', trim($route, "/"));
        $ret = WEB_PATH. "/index.php";
        switch (count($params)) {
            case 1:
                $ret .= '?type='.$params[0];
                break;
            case 2:
                $ret .= '?type='.$params[0];
                $ret .= '&action='.$params[1];
                break;
            case 3:
                $ret .= '?type='.$params[0];
                $ret .= '&action='.$params[1];
                $ret .= '&id='.$params[2];
                break;
        }
        return $ret;
        //return RELATIVE_ROOT. "/index.php?route=" . $route;
    }


    public static function getParamByKey(int|string $index): string
    {
        if(self::$routes === null){
            if (isset($_GET['route'])) {
                $parts = explode('?', $_GET['route'], 2);
                self::$routes = explode('/', trim($parts[0], "/"));
                if(isset(self::$routes[0])){
                    self::$routes['type'] = self::$routes[0];
                    if(isset(self::$routes[1])){
                        self::$routes['action'] = self::$routes[1];
                        if(isset(self::$routes[2])){
                            self::$routes['id'] = self::$routes[2];
                        }
                    }
                }
            } else {
                self::$routes = array();
                if(isset($_GET['type'])){
                    self::$routes[0] = $_GET['type'];
                    self::$routes['type'] = $_GET['type'];
                    if(isset($_GET['action'])){
                        self::$routes[1] = $_GET['action'];
                        self::$routes['action'] = $_GET['action'];
                        if(isset($_GET['id'])){
                            self::$routes[2] = $_GET['id'];
                            self::$routes['id'] = $_GET['id'];
                        }
                    }
                }else{
                    self::$routes = [];
                }

            }
        }
        return self::$routes[$index] ?? '';
    }


    protected static function isPost(): bool
    {
        return $_SERVER["REQUEST_METHOD"] == "POST";
    }

    public abstract static function getInstance() : self;
}