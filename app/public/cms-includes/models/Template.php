<?php 

class Template extends Database
{
    function __construct()
    {
        parent::__construct();
    }

    public function register($username, $hashed_password)
    {
        try {
            $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->execute();

            $result = $this->db->lastInsertId();
            
            $_SESSION['message'] = "Successfully created user!";
            header("location: login.php");
            exit();
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

            $hash_from_db = $user['password'];

            $correct_password = password_verify($form_password, $hash_from_db);

            if(!$correct_password)
            {
                $_SESSION['message'] = "Invalid password";
                header("location: login.php");
                exit();
            } 

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['message'] = "Successfully logged in";
            header("location: template.php");
            exit();

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

?>