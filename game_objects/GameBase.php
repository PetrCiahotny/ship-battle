<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/game_objects/Message.php";


abstract class  GameBase
{
    /**
     * @var array<Message> $messages
     */
    protected array $messages = array();
    

    protected function __construct()
    {
    }

    public function init() : void
    {

    }

    protected function addMessage(string $message, MessageLevel $level) : void{
        $this->messages[] = new Message($message, $level);
    }

    public function renderMessages() : void
    {
        foreach ($this->messages as $message) {
            ?>
                <div class="message <?= $message->getLevel()->toString() ?>">
                    <?= $message->getMessage() ?>
                </div>
            <?php
        }
    }

    public function render() : void
    {

    }

    public abstract static function getInstance() : self;
}