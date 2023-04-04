<?php 
include_once ROOT . '/cms-includes/models/User.php';

$user_template = new User();
if(isset($_SESSION['user_id'])) {
    $logged_in_user = $user_template->select_one_user($_SESSION['user_id']);
    echo "<footer><p>Account: " . $logged_in_user['username'] . "</p></footer>";
}
?>