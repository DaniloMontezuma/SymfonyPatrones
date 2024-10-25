<?php
namespace App\Service;

class EmailMessage implements EmailMessageInterface
{
    private string $body;

    public function __construct(string $body)
    {
        $this->body = $body;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
