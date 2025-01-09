<?php

namespace Khalil\Components\Database\Interface;

interface DatabaseInterface
{
    public static function getInstance(): DatabaseInterface;

    public function connect(): \PDO;


}
