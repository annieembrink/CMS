<?php 

declare(strict_types=1);
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include_once 'cms-config.php';
include_once ROOT . '/cms-includes/global-functions.php';
include_once ROOT . '/cms-includes/models/Database.php';
include_once ROOT . '/cms-includes/models/Template.php';
require_once "Parsedown.php";

$template = new Template();

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css@1.12/mvp.css"> 
    <link rel="stylesheet" href="/cms-content/styles/style.css">
    <title>Pages</title>
</head>
<body>
    <main>
    <?php 
    // Write out message from other pages if exists
    if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
        echo "<article><aside><p>". $_SESSION['message'] . "</p></aside></article>";
        unset( $_SESSION['message']); // remove it once it has been written
    }
    ?>
    <?php include ROOT . '/cms-includes/partials/nav.php'; ?>
    <a href="logout.php">Logout</a>
    <h1>Published pages</h1>
    <?php 

        // Query the database
        // $sqlquery = "SELECT * FROM page";
        $result = $template->select_all_pages();

        // print_r($result);

        foreach ($result as $row) {
            # code...
            $created_by_user = $template->select_one_user($row['user_id']);
            if($row['visibility'] == 1) {
                $id = $row['id']; 

                echo "<aside>
                <p>" . $row['page_title'] . "</p>
                <small> Created by user_id: " . $created_by_user['username'] . "</small>
                <div>
                    <a href='delete.php?id=$id'>Delete</a>
                    <a href='edit.php?id=$id'>Edit</a>
                    <a href='view.php?id=$id'>View</a>
                </div>
            </aside>
            <hr>";
            }
            }
              
    ?>
    </main>
</body>
</html>