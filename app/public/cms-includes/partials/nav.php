<nav>
    <ul>
        <?php 
        if(isset($_SESSION['user_id']) && $_SESSION['user_id']) {
            echo '<li><a href="dashboard.php">Dashboard</a></li>';
            echo '<li><a href="allpages.php">Published</a></li>';
            echo '<li><a href="mydrafts.php">Drafts</a></li>';
            echo '<li><a href="create.php">Create new page</a></li>';
        } else {
            echo '<li><a href="register.php">Register</a></li>';
            echo '<li><a href="login.php">Login</a></li>';
        }
        ?>
    </ul>
</nav>
