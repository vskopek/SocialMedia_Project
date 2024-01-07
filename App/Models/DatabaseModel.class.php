<?php

namespace app\Models;

use PDO;
use PDOException;

/**
 *  Database model that initializes connection with PDO
 *  Handles prepared statements and returns its fetch data
 *  Singleton class
 * @author Václav šKOPEK
 */
class DatabaseModel
{
    /**
     * @var DatabaseModel|null Database model instance
     */
    private static ?DatabaseModel $database = null;

    /**
     * @var PDO PDO connection
     */
    private PDO $pdo;

    /**
     * Constructor that initializes connection to database with PDO
     * Sets PDO error mode to exception and coding to UTF 8
     * Prints out error message on exception
     */
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

    /**
     * Singleton method to return database model instance
     * @return DatabaseModel Database model
     */
    public static function getDatabase(): DatabaseModel
    {
        if(self::$database == null){
            self::$database = new DatabaseModel();
        }

        return self::$database;
    }

    /**
     * Returns ID of last inserted row into the database
     * @return bool|string false if not found | id
     */
    public function returnLastInsertID(): bool|string
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Prepares statement, binds values and executes
     * Returns fetch data with associative fetch mode
     * @param string $statement Statement to be executed
     * @param array $values Array with $key and $value that will be bound to statement values
     * @return bool|array Fetch data
     */
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