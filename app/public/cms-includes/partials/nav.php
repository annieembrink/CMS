<nav>
    <ul>
        <?php 
        if(isset($_SESSION['user_id']) && $_SESSION['user_id']) {
            echo '<li><a href="template.php">Dashboard</a></li>';
        } else {
            echo '<li><a href="register.php">Register</a></li>';
            echo '<li><a href="login.php">Login</a></li>';
        }
        ?>
    </ul>
</nav>
