<?php


namespace App\Utility;

use PDO;

class Database
{
    static protected $db;

    public function __construct()
    {
        self::init();
    }

    public static function init()
    {
        try
        {
            self::$db = new PDO(
                DSN,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]
            );
        }
        catch (PDOException $e)
        {
            die("Error :" . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$db))
        {
            self::init();
        }
        return (self::$db);
    }
}