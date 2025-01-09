<?php

use Khalil\Components\Http\Request;
use Khalil\Kernel;

$request = Request::fromGlobal();

$kernel = new Kernel;

$response = $kernel->handle($request);

$response->send();