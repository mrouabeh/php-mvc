<?php


namespace App\Core;

use App\Utility\Database;
use Exception;
use PDO;

class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all()
    {
        if ($this->table)
        {
            $stmt = $this->db->query("SELECT * FROM {$this->table}");
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));
            return $stmt->fetchAll();
        }
    }

    public function find(int $id)
    {
        if ($this->table)
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

    public function select()
    {

    }

    public function insert($data)
    {

    }

    public function update($id)
    {

    }

    public function delete($id)
    {

    }
}