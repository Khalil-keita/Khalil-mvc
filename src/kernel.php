<?php
namespace Khalil;

use Khalil\Components\Http\Interface\RequestInterface;
use Khalil\Components\Http\Interface\ResponseInterface;
use Khalil\Components\Http\Response;


final class Kernel
{

    public const ENV_DEV = "dev";
    public const ENV_PROD = "prod";

    public function __construct(
        public readonly string $environement,
        public readonly bool $debug
    ) {
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        return new Response(); //TODO
    }

}