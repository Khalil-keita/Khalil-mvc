<?php

namespace Khalil\Components\Database;

use PDO;

final class Database
{

    private static $instance = null;
    private readonly string $dsn;
    private readonly string $username;
    private readonly string $password;
    private readonly array $options;

    public function __construct(string $dsn, string $username, string $password, array $options = []){
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
    }

    public static function getInstance(
        string $dsn,
        string $username,
        string $password,
        array $options = []
    ): Database {
        if (self::$instance === null) {
            self::$instance = new self($dsn, $username, $password, $options);
        }
        return self::$instance;
    }
}
