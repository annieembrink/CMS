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

$template = new Template();

$title = "Dashboard"; 
$logged_in_user = $template->select_one_user($_SESSION['user_id']);
$all_users = $template->select_all_users();
$all_pages = $template->select_all_pages();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css@1.12/mvp.css">
    <link rel="stylesheet" href="/cms-content/styles/style.css">
    <title><?php echo $title ?></title>
</head>
<body>

<?php 
        // Write out message from other pages if exists
        if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
            echo "<article><aside><p>". $_SESSION['message'] . "</p></aside></article>";
            unset( $_SESSION['message']); // remove it once it has been written
        }
    ?>

<?php include ROOT . '/cms-includes/partials/nav.php'; ?>

    <a id="logout" href="logout.php">Logout</a>

    <h1>Dashboard</h1>
    <h2>Welcome <?= $logged_in_user['username']?></h2>

    <h4>Contributers: </h4>
    <?php
    foreach ($all_users as $user) {
        echo "<p>" . $user['username'] . "</p>";
    }
    ?>
    <h4>Published pages: </h4>
    <?php
    foreach ($all_pages as $page) {
        //Removes symbols but keeps letters
        $just_letters = preg_replace('/[^\p{L}\p{N}\s]/u', '', $page['page_title']);
        $correct_syntax = ucfirst(strtolower($just_letters));
        if($page['visibility'] == 1) {
            echo "<p>" . $correct_syntax . "</p>";
        }
    }
    ?>
    
</body>
</html>