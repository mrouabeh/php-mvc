<?php


namespace App\Core;

use App\Utility\Database;

use PDO;
use Exception;

abstract class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all()
    {
        if (isset($this->table))
        {
            $stmt = $this->db->query("SELECT * FROM {$this->table}");
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));
            return $stmt->fetchAll();
        }
    }

    public function find(int $id)
    {
        if (isset($this->table))
        {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));
            if ($stmt->execute())
            {
                return $stmt->fetch();
            }
            else
            {
                throw new Exception("sql execution failed");
            }
        }
    }

    public function insert(array $fields)
    {
        if (count($fields))
        {
            $params = [];
            foreach ($fields as $key => $value)
            {
                $params[":{$key}"] = $value;
            }
            $colums = implode(", ", array_keys($fields));
            $values = implode(", ", array_keys($params));

//            TODO: check that columns exist
            $sql = "INSERT INTO {$this->table} (`{$colums}`) VALUES ({$values})";
            $stmt = $this->db->prepare($sql);
            foreach ($params as $key => $value)
            {
                $stmt->bindParam($key, $value);
            }
            $stmt->execute();
        }
        return false;
    }
}