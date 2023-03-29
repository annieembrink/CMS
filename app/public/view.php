<?php 

declare(strict_types=1);
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include_once 'cms-config.php';
include_once ROOT . '/cms-includes/models/Database.php';
include_once ROOT . '/cms-includes/models/Template.php';
require_once "Parsedown.php";

$template = new Template();

$title = "Preview"; 
$id = $_GET['id'];
$all_pages = $template->select_all_pages();
$page = $template->view_page($id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://unpkg.com/mvp.css@1.12/mvp.css"> -->
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

    <p class="mt bg-white"><a id="" href="allpages.php">Back</a></p>
    <nav>
        <ul class="list-style flex">
            <?php
           foreach ($all_pages as $one_page) {
            # code...
            $id = $one_page['id']; 
            $just_letters = preg_replace('/[^\p{L}\p{N}\s]/u', '', $one_page['page_title']);
            $correct_syntax = ucfirst(strtolower($just_letters));
            echo "<li><a href='view.php?id=$id'>" . $correct_syntax . "</a></li>";
           }
            ?>
        </ul>
    </nav>

    <?php 
        $Parsedown = new Parsedown();
        $html_title = $Parsedown->text($page['page_title']);
        $html = $Parsedown->text($page['content']);

        echo $html_title;
        echo $html;
    ?>
    
</body>
</html>