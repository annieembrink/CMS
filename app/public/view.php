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

    <a id="" href="allpages.php">Back</a>
    <nav>
        <ul>
            <?php
           foreach ($all_pages as $one_page) {
            # code...
            $id = $one_page['id']; 

            echo "<li><a href='view.php?id=$id'>" . $one_page['page_title'] . "</a></li>";
           }
            ?>
        </ul>
    </nav>

    <?php 
        $Parsedown = new Parsedown();
        $html = $Parsedown->text($page['content']);

        echo $html;
    ?>
    
</body>
</html>