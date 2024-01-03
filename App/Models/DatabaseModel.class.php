<?php

namespace app\Models;

use PDO;
use PDOException;

class DatabaseModel
{
    private static ?DatabaseModel $database = null;

    private PDO $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=" . MYSQL_SERVER . ";dbname=" . MYSQL_DB, MYSQL_USERNAME, MYSQL_PASSWORD);

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("set names utf8");
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function getDatabase(): DatabaseModel
    {
        if(self::$database == null){
            self::$database = new DatabaseModel();
        }

        return self::$database;
    }

    public function returnLastInsertID(): bool|string
    {
        return $this->pdo->lastInsertId();
    }

    public function prepareAndExecuteStatement(string $statement, array $values): bool|array
    {
        try {
            $st = $this->pdo->prepare($statement);

            foreach ($values as $key => $value) {
                $st->bindValue($key, $value);
            }

            $st->execute();

            $st->setFetchMode(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        return $st->fetchAll();
    }
}