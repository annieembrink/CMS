<?php 

declare(strict_types=1);
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

include_once 'cms-config.php';
include_once ROOT . '/cms-includes/models/Database.php';
include_once ROOT . '/cms-includes/models/User.php';

$user_template = new User();
$username = "";
$form_password = "";

$title = "Register"; 

if($_POST) 
{
    $username = $_POST['username'];

    $form_password = $_POST['form_password'];
    $hashed_password = password_hash($form_password, PASSWORD_DEFAULT);
    $result = $user_template->register($username, $hashed_password);
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
            echo "<article><aside><p class='bg-white mt'>". $_SESSION['message'] . "</p></aside></article>";
            unset( $_SESSION['message']); // remove it once it has been written
        }
    ?>

<?php include ROOT . '/cms-includes/partials/nav.php'; ?>

<h1>Create account</h1>
    
<!-- REGISTER -->
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

<input type="text" name="username" placeholder="username" value="<?php echo $username ?>">
<input type="password" name="form_password" placeholder="password" value="<?php $form_password ?>">
<input class="btn mt" type="submit" value="register">

</form>

</body>
</html>