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

// Query the database
$sqlquery = "SELECT * FROM page WHERE id=$id";
$result = $pdo->query($sqlquery);
$page = $result->fetch();

echo $page;

if($_POST) 
{

    $page_title = $_POST['page_title'];
    $content = $_POST['content'];
    $visibility = $_POST['visibility'];

    //trim
    //save value if only one is filled
    if(!empty($page_title) && !empty($content)) {
        $result = $template->create_page($page_title, $content, $visibility);
    } else {
        $_SESSION['message'] = "All input fields have to be filled";
    }
    
}

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

    <h1>Preview page</h1>

    <?php 
        $Parsedown = new Parsedown();
        $html = $Parsedown->text($page['content']);

        echo $html;
    ?>
    
</body>
</html>