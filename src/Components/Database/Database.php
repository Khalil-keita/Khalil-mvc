<?php
namespace Khalil\Components\Database;

use Khalil\Components\Database\Interface\DatabaseInterface;
use PDO;

final class Database implements DatabaseInterface {

    public static function getInstance(): DatabaseInterface
    {
        return new static(); // TODO
    }

    public function connect(): PDO{
        return new PDO(); //TODO
    }

}