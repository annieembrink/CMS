<?php 

declare(strict_types=1);
session_start();

include_once 'cms-config.php';
include_once ROOT . '/cms-includes/global-functions.php';
include_once ROOT . '/cms-includes/models/Database.php';
include_once ROOT . '/cms-includes/models/Template.php';

$template = new Template();
$username = "";
$password = "";

$title = "Template"; 

if($_POST) 
{
    $username = $_POST['username'];
    $form_password = $_POST['password'];
    $password = password_hash($form_password, PASSWORD_DEFAULT);
    $result = $template->register($username, $password);
    header("location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css@1.12/mvp.css">
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

<a href="logout.php">Logout</a>

    <h1>TEMPLATE</h1>
    
<!-- REGISTER -->
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

<input type="text" name="username" placeholder="username" value="<?= $username ?>">
<input type="password" name="password" placeholder="password" value="<?= $password ?>">
<input type="submit" value="register">

</form>

</body>
</html>