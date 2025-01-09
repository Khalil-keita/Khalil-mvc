<?php
namespace Khalil\Components\Http;

use Khalil\Components\Http\Interface\RequestInterface;


class Request implements RequestInterface {

    public static function fromGlobal(): static
    {
        return new static();
    }

}