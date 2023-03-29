<?php 

class Page extends Database
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

    // "SELECT * FROM page WHERE published = 1 ORDER BY menu_priority ASC, page_name ASC";
}

?>