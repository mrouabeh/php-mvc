<?php


namespace App\Model;


use App\Core\Model;

class User extends Model
{
    protected $table = "users";

    public function get(string $email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->bindParam(":email", $email);
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