<?php

use Khalil\Components\Http\Request;
use Khalil\Kernel;

require "../vendor/autoload.php";

$request = Request::fromGlobal();

$kernel = new Kernel(Kernel::ENV_DEV, true);

$response = $kernel->handle($request);

$response->send();