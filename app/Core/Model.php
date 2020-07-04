<?php


namespace App\Core;

use App\Utility\Database;

use Exception;

abstract class Model
{
    protected $db;
    protected $table;
    protected $data;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all()
    {
        $this->data = $this->db->select($this->table)->results();
        return $this->data();
    }

    public function find(int $id)
    {
        $data = $this->db->select($this->table, ["id", "=", $id]);
        if ($data->count())
        {
            $this->data = $data->first();
        }
        return $this->data();
    }

    public function get(array $where = [])
    {
        $data = $this->db->select($this->table, $where);
        if ($data->count())
        {
            $this->data = $data->results();
        }
        return $this->data();
    }

    public function data() {
        return($this->data);
    }

    public function create(array $fields)
    {
        return $this->db->insert($this->table, $fields);
    }

    public function update($id, array $fields)
    {
        return($this->db->update($this->table, $id, $fields));
    }

    public function exists()
    {
        return(!empty($this->data));
    }
}