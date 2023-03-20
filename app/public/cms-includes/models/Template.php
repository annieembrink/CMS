<?php 

class Template extends Database
{
    function __construct()
    {
        parent::__construct();
    }

    public function register($username, $password)
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

    public function login($username, $form_password)
    {
        try {
            $user_query = "SELECT * FROM user WHERE username = '$username'";
            $stmt = $this->db->prepare($user_query);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $hash = $user['password'];
            $correct_password = password_verify($form_password, $hash);
            var_dump($correct_password);

            if(!$correct_password)
            {
                $_SESSION['message'] = "Invalid password";
                header("location: login.php");
                exit();
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

?>