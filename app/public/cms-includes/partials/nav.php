<nav>
    <ul id="nav-ul" class="flex list-style justify">
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<li><a class="bg-white" href="logout.php">Logout</a></li>';
            echo '<li class="align-center"><a href="dashboard.php">Dashboard</a></li>';
            echo '<li class="align-center"><a href="allpages.php">Published</a></li>';
            echo '<li class="align-center"><a href="mydrafts.php">Drafts</a></li>';
            echo '<li class="align-center"><a href="create.php">Create new page</a></li>';
        } else {
            echo '<li><a href="register.php">Register</a></li>';
            echo '<li><a href="login.php">Login</a></li>';
            echo '<li><a href="allpages.php">Published</a></li>';
        }
        ?>
    </ul>
</nav>
