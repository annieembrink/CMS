<?php 

declare(strict_types=1);
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
    $password = $_POST['password'];
    print_r($_POST);
    $result = $template->insertOne($username, $password);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
</head>
<body>
    
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

<input type="text" name="username" placeholder="username" value="<?= $username ?>">
<input type="password" name="password" placeholder="password" value="<?= $password ?>">
<input type="submit" value="register">

</form>

</body>
</html>