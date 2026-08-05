<?php

declare(strict_types=1);

namespace ShifaFlow;

use PDO;

final class Database
{
    public static function connection(bool $withoutDatabase = false): PDO
    {
        $host = Env::get('DB_HOST', Env::get('MYSQLHOST', '127.0.0.1'));
        $port = Env::get('DB_PORT', Env::get('MYSQLPORT', '3306'));
        $database = Env::get('DB_NAME', Env::get('MYSQLDATABASE', 'shifaflow'));
        $user = Env::get('DB_USER', Env::get('MYSQLUSER', 'root'));
        $password = Env::get('DB_PASSWORD', Env::get('MYSQLPASSWORD', ''));

        $dsn = sprintf('mysql:host=%s;port=%s;%scharset=utf8mb4', $host, $port, $withoutDatabase ? '' : 'dbname=' . $database . ';');

        return new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false,
        ]);
    }
}
