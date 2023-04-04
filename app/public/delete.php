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

$page_template = new Page();

$id = $_GET['id'];

$result = $page_template->delete_page($id);

if($result == 1) {
    header('Location: allpages.php');
} else {
    $_SESSION['message'] = "Couldn't delete page, try again later.";
    header('Location: allpages.php');
    exit();
}
?>
