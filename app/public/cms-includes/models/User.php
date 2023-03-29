<?php 

class User extends Database
{
    function __construct()
    {
        parent::__construct();
    }

    public function select_all_users()
    {
        $sql = "SELECT * FROM user";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function select_one_user($id)
    {
        $sql = "SELECT * FROM user WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function register($username, $hashed_password)
    {
        try {
            $user_query = "SELECT * FROM user WHERE username=:username";
            $stmt = $this->db->prepare($user_query);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user) {
                $_SESSION['message'] = "Username is already taken";
                header("location: register.php");
                exit();
            } else {
                $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':username', $username, PDO::PARAM_STR);
                $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
                $stmt->execute();
                $this->db->lastInsertId();
                $_SESSION['message'] = "Successfully created user!";
                header("location: login.php");
                exit();
            }
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    public function login($username, $form_password)
    {
        try {
            $user_query = "SELECT * FROM user WHERE username=:username";
            $stmt = $this->db->prepare($user_query);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                $_SESSION['message'] = "Username does not exists";
                header("location: login.php");
                exit();
            } else {
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
                header("location: dashboard.php");
                exit();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

?>