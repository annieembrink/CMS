<?php 

declare(strict_types=1);
include_once 'cms-config.php';
include_once ROOT . '/cms-includes/global-functions.php';
include_once ROOT . '/cms-includes/models/Database.php';
include_once ROOT . '/cms-includes/models/Template.php';

$template = new Template();
$username = "";
$password = "";

$title = "Login"; 

session_start();

if($_POST) 
{
    $username = $_POST['username'];
    $form_password = $_POST['password'];
    $result = $template->login($username, $password);
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

<h1>Login</h1>
    
<!-- Login -->
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

<input type="text" name="username" placeholder="username" value="<?= $username ?>">
<input type="password" name="password" placeholder="password" value="<?= $password ?>">
<input type="submit" value="login">

</form>

</body>
</html>