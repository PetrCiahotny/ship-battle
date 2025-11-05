<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/game_objects/Message.php";


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
        //$this->messages[] = new Message($message, $level);
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
        header("Location: {$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}");
        die();
    }

    public function render() : void
    {

    }

    public static function getRouteLink(string $route): string
    {
        return "/index.php?route=" . $route;
    }

    public static function getRouteAtIndex(int $index): string
    {
        if(self::$routes === null){
            if (isset($_GET['route'])) {
                $parts = explode('?', $_GET['route'], 2);
                self::$routes = explode('/', trim($parts[0], "/"));
            } else {
                self::$routes = [];
            }
        }
        return $index < count(self::$routes) ? self::$routes[$index] : '';
    }


    protected static function isPost(): bool
    {
        return $_SERVER["REQUEST_METHOD"] == "POST";
    }

    public abstract static function getInstance() : self;
}