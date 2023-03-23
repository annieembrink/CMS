<?php 

class Template extends Database
{
    function __construct()
    {
        parent::__construct();
    }

    public function select_all_pages()
    {
        $sql = "SELECT * FROM page";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function create_page($user_id, $page_title, $content, $visibility)
    {
        $user_id = intval($user_id);
        $sql = "INSERT INTO page (user_id, page_title, content, visibility) VALUES (:user_id, :page_title, :content, :visibility)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_title', $page_title, PDO::PARAM_STR);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt->bindValue(':visibility', $visibility, PDO::PARAM_BOOL);
        $stmt->execute();
    }

    public function view_page($id)
    {
        $pagequery = "SELECT * FROM page WHERE id=:id";
        $stmt = $this->db->prepare($pagequery);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete_page($id)
    {
        $sql = "DELETE FROM page WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function edit_page($id, $page_title, $content, $visibility)
    {
        //make sure it's an int
        $id = intval($id);
        //change all to id=:id so avoid sql injections
        $sql = "UPDATE page SET page_title = :page_title, content = :content, visibility = :visibility WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':page_title', $page_title, PDO::PARAM_STR);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt->bindValue(':visibility', $visibility, PDO::PARAM_BOOL);
        return $stmt->execute();
    }
}

?>