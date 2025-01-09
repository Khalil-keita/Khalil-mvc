<?php
namespace Khalil\Components\Http;

use Khalil\Components\Http\Interface\ResponseInterface;

class Response implements ResponseInterface
{
    public function send(): string
    {
        return "";
    }
}