<?php 

declare(strict_types=1);
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

require_once 'User.php';
require_once 'cms-config.php';
require_once 'Database.php';

$user_template = new User();

$title = "Login"; 

if($_POST) 
{
    $username = $_POST['username'];
    $form_password = $_POST['form_password'];

    $result = $user_template->login($username, $form_password);
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


<h1>Login</h1>
    
<!-- Login -->
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

<input type="text" name="username" placeholder="username">
<input type="password" name="form_password" placeholder="password">
<input class="btn mt" type="submit" value="login">

</form>

</body>
</html>