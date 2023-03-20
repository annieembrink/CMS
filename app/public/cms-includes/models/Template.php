<?php 

class Template extends Database
{
    function __construct()
    {
        parent::__construct();
    }

    public function insertOne($username, $password)
    {
        try {
            $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

?>