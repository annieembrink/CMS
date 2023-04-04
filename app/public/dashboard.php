<?php 

declare(strict_types=1);
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include_once 'cms-config.php';
include_once ROOT . '/cms-includes/models/Database.php';
include_once ROOT . '/cms-includes/models/Page.php';
include_once ROOT . '/cms-includes/models/User.php';

$page_template = new Page();
$user_template = new User();

$title = "Dashboard"; 
$logged_in_user = $user_template->select_one_user($_SESSION['user_id']);
$all_users = $user_template->select_all_users();
$all_pages = $page_template->select_all_pages();


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
            echo "<article><aside><p class='bg-white mt'>". $_SESSION['message'] . "</p></aside></article>";
            unset( $_SESSION['message']); // remove it once it has been written
        }
    ?>

<?php include ROOT . '/cms-includes/partials/nav.php'; ?>

    <h1>Dashboard</h1>

    <div>
    <h3 class='mb'>Contributors: </h3>
    <?php
    foreach ($all_users as $user) {
        echo "<p class='mb'>" . $user['username'] . "</p>";
    }
    ?>
    </div>
    
    <div class="mt">
    <h3 class='mb'>Published pages: </h3>
    <?php
    foreach ($all_pages as $page) {
        //Removes symbols but keeps letters
        $just_letters = preg_replace('/[^\p{L}\p{N}\s]/u', '', $page['page_title']);
        $correct_syntax = ucfirst(strtolower($just_letters));
        if($page['visibility'] == 1) {
            echo "<p class='mb'>" . $correct_syntax . "</p>";
        }
    }
    ?>
    </div>
    <div class="mt">
    <h3 class='mb'>Drafts: </h3>
    <?php
    foreach ($all_pages as $page) {
        //Removes symbols but keeps letters
        $just_letters = preg_replace('/[^\p{L}\p{N}\s]/u', '', $page['page_title']);
        $correct_syntax = ucfirst(strtolower($just_letters));
        if($page['visibility'] == 0) {
            echo "<p class='mb'>" . $correct_syntax . "</p>";
        }
    }
    ?>
    </div>

<?php include ROOT . '/cms-includes/partials/footer.php'; ?>
    
</body>
</html>