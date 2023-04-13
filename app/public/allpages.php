<?php 

declare(strict_types=1);
session_start();

include_once 'cms-config.php';
include_once ROOT . '/cms-includes/models/Database.php';
include_once ROOT . '/cms-includes/models/Page.php';
include_once ROOT . '/cms-includes/models/User.php';
require_once "Parsedown.php";

$page_template = new Page();
$user_template = new User();

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css@1.12/mvp.css"> 
    <link rel="stylesheet" href="/cms-content/styles/style.css">
    <title>Pages</title>
</head>
<body>
    <main>
    <?php 
    // Write out message from other pages if exists
    if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
        echo "<article><aside><p class='bg-white mt'>". $_SESSION['message'] . "</p></aside></article>";
        unset( $_SESSION['message']); // remove it once it has been written
    }
    ?>
    <?php include ROOT . '/cms-includes/partials/nav.php'; ?>
    <h1>Published pages</h1>
    <?php 

        // Query the database
        // $sqlquery = "SELECT * FROM page";
        $result = $page_template->select_all_pages();

        // print_r($result);

        foreach ($result as $row) {
            # code...
            $created_by_user = $user_template->select_one_user($row['user_id']);
            if($row['visibility'] == 1) {
                $id = $row['id']; 

                $just_letters = preg_replace('/[^\p{L}\p{N}\s]/u', '', $row['page_title']);
                $correct_syntax = ucfirst(strtolower($just_letters));

                echo "<aside class='mt'>
                <h3>" . $correct_syntax . "</h3>
                <div class='flex justify'>
                <p class='align-bottom'> Created by user: " . $created_by_user['username'] . "</p>
                <span>
                <a class='bg-white' href='view.php?id=$id'>View</a>";

                if (isset($_SESSION['user_id'])) {
                    echo "<a class='bg-white' href='delete.php?id=$id'>Delete</a>
                    <a class='bg-white' href='edit.php?id=$id'>Edit</a>";
                    };
                "</span>
                </div>
            </aside>";
            }
        }
              
    ?>
    </main>
<?php include ROOT . '/cms-includes/partials/footer.php'; ?>

</body>
</html>