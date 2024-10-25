<?php
namespace App\Decorator;

class HeaderDecorator
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function getContent()
    {
        return '<h2>Contact Form Submission</h2>' . $this->message;
    }
}
