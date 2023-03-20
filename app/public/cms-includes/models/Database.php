<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/cms-config.php';

class Database {

    protected $db;

    protected function __construct() {

        $dsn = "mysql:host=". DB_HOST .";dbname=". DB_NAME;

        try {

            $this->db = new PDO($dsn, DB_USER, DB_PASSWORD);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->db->setAttribute(PDO::ATTR_PERSISTENT, true);

        } catch (PDOException $e) {
            print_r($e);
        }
    }
}


// class DisplayDBVersion extends Database 
// {
//     function __construct() {
        
//         // call parent constructor
//         parent::__construct();

//         $query = $this->db->query('SHOW VARIABLES like "version"');
//         $rows = $query->fetch();
        
//         echo '<pre>';
//         echo 'Database version: ';
//         foreach ($rows as $key => $value) {    
//             print_r($key . ': ' . $value);
//         }
//         echo '</pre>';
//     }
// }

?>