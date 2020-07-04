<?php


namespace App\Utility;

use PDO;

class Database
{
    static private $_db = null;
    private $_PDO;
    private $_results = [];
    private $_error;
    private $_count;

    public function __construct()
    {
        try
        {
            $this->_PDO = new PDO(
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

    /**
     * @return Database|null
     */
    public static function getInstance()
    {
        if (!isset(self::$_db))
        {
            self::$_db = new Database();
        }
        return (self::$_db);
    }

    /**
     *
     */
    private function resetAttributes()
    {
        $this->_count = 0;
        $this->_results = [];
        $this->_error = false;
    }

    /**
     * @return mixed
     */
    private function error()
    {
        return $this->_error;
    }

    /**
     * @param $sql
     * @param array $params
     * @return $this
     */
    public function query($sql, array $params = [])
    {
        $this->resetAttributes();
        if ($_stmt = $this->_PDO->prepare($sql))
        {
            foreach ($params as $key => $value)
            {
                $_stmt->bindValue($key, $value);
            }
            if ($_stmt->execute())
            {
                $this->_results = $_stmt->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $_stmt->rowCount();
            }
            else
            {
                $this->_error = true;
            }
        }
        return $this;
    }

    /**
     * @param $action
     * @param $table
     * @param array $where
     * @return $this|bool
     */
    public function action($action, $table, array $where = [])
    {
        if (count($where) == 3)
        {
            $operator = $where[1];
            $operators = ["=", ">", "<", ">=", "<="];
            if (in_array($operator, $operators))
            {
                $field = $where[0];
                $value = $where[2];
                $params = [":value" => $value];
                if (!$this->query("{$action} FROM `{$table}` WHERE `{$field}` {$operator} :value", $params)->error())
                {
                    return $this;
                }
            }
        }
        else
        {
            if (!$this->query("{$action} FROM `{$table}`")->error())
            {
                return $this;
            }
        }
        return false;
    }

    /**
     * @param $table
     * @param array $where
     * @return $this|bool
     */
    public function select($table, array $where = [])
    {
        return $this->action("SELECT *", $table, $where);
    }

    /**
     * @param $table
     * @param array $fields
     * @return bool
     */
    public function insert($table, array $fields)
    {
        if (count($fields))
        {
            $params = [];
            foreach ($fields as $key => $value)
            {
                $params[":{$key}"] = $value;
            }
            $columns = implode(", ", array_keys($fields));
            $values = implode(", ", array_keys($params));
            if (!$this->query("INSERT INTO `{$table}` (`{$columns}`) VALUES({$values})", $params)->error())
            {
                return $this->_PDO->lastInsertId();
            }
        }
        return false;
    }

    /**
     * @param $table
     * @param $id
     * @param array $fields
     * @return bool
     */
    public function update($table, $id, array $fields)
    {
        if (count($fields)) {
            $x = 1;
            $set = "";
            $params = [];
            foreach ($fields as $key => $value) {
                $params[":{$key}"] = $value;
                $set .= "`{$key}` = :$key";
                if ($x < count($fields)) {
                    $set .= ", ";
                }
                $x ++;
            }
            if (!$this->query("UPDATE `{$table}` SET {$set} WHERE `id` = {$id}", $params)->error()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $table
     * @param array $where
     * @return $this|bool
     */
    public function delete($table, array $where = [])
    {
        return $this->action("DELETE", $table, $where);
    }

    /**
     * @param null $key
     * @return array|mixed
     */
    public function results($key = null) {
        return(isset($key) ? $this->_results[$key] : $this->_results);
    }

    /**
     * @return array|mixed
     */
    public function first() {
        return($this->results(0));
    }

    /**
     * @return mixed
     */
    public function count() {
        return($this->_count);
    }
}