<?php
enum MessageLevel: string
{
    case INFO = 'info';
    case WARNING = 'warning';
    case ERROR = 'error';
    case SUCCESS = 'success';

    public function toString() : string{
        return  $this->value;
    }
}

class Message{
    protected string $message = "";

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getLevel(): MessageLevel
    {
        return $this->level;
    }

    public function setLevel(MessageLevel $level): void
    {
        $this->level = $level;
    }
    protected MessageLevel $level = MessageLevel::INFO;
    public function __construct(string $message, MessageLevel $level){
        $this->message = $message;
        $this->level = $level;
    }
}