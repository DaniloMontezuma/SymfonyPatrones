<?php
namespace App\Service;

interface EmailMessageInterface
{
    public function getBody(): string;
}
