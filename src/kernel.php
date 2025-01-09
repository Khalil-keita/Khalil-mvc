<?php
namespace Khalil;

use Khalil\Components\Http\Interface\RequestInterface;
use Khalil\Components\Http\Interface\ResponseInterface;
use Khalil\Components\Http\Response;


final class Kernel{

    public function handle(RequestInterface $request): ResponseInterface
    {
        return new Response(); //TODO
    }

}