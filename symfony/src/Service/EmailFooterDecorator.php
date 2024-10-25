<?php
namespace App\Decorator;

class EmailFooterDecorator
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function getContent()
    {
        return $this->message . '<p>Thank you for contacting us!</p>';
    }
}
