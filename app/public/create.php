<?php

declare(strict_types=1);
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include_once 'cms-config.php';
include_once ROOT . '/cms-includes/models/Database.php';
include_once ROOT . '/cms-includes/models/Page.php';
require_once "Parsedown.php";

$page_template = new Page();

$title = "Create";
$page_title = "";
$content = "";
$visibility = false;

if ($_POST) {
    //Check if title is aleady in db. Not possible to create same title twice. 
    // $page_title = $_POST['page_title'];
    // $page_title = ucfirst(strtolower(preg_replace('/[^\p{L}\p{N}\s]/u', '', $_POST['page_title'])));

    $page_title = ucfirst(strtolower(preg_replace('/[^\p{L}\p{N}\s]/u', '', $_POST['page_title'])));

    global $page_template;
    $allpages = $page_template->select_all_pages();
    $unique_title = true;

    foreach ($allpages as $value) {
        //Values from db in correct syntax
        $just_letters = preg_replace('/[^\p{L}\p{N}\s]/u', '', $value['page_title']);
        $correct_syntax = ucfirst(strtolower($just_letters));

        if ($page_title == $correct_syntax) {
            $unique_title = false;
            break; // break out of the loop once a match is found
        }
    }

    if (!$unique_title) {
        // Title is not unique, show an error message to the user
        $_SESSION['message'] = "A page with the same title already exists. Please choose a unique title.";
        header('Location: create.php');
        exit();
    } else {
        // Title is unique, continue with creating the page
        // ...
        $page_title = $_POST['page_title'];
        $content = $_POST['content'];

        if (isset($_POST['visibility'])) {
            $visibility = ($_POST['visibility'] === 'true') ? true : false;
        } else {
            $visibility = false;
        }

        //trim
        //save value if only one is filled
        if (!empty($page_title) && !empty($content)) {
            $result = $page_template->create_page($_SESSION['user_id'], $page_title, $content, $visibility);
            header('Location: allpages.php');
            $_SESSION['message'] = "Successfully created page!";
            exit();
        } else {
            $_SESSION['message'] = "All input fields have to be filled";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://unpkg.com/mvp.css@1.12/mvp.css"> -->
    <link rel="stylesheet" href="/cms-content/styles/style.css">
    <title><?php echo $title ?></title>
</head>

<body>

    <?php
    // Write out message from other pages if exists
    if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
        echo "<article><aside><p>" . $_SESSION['message'] . "</p></aside></article>";
        unset($_SESSION['message']); // remove it once it has been written
    }
    ?>

    <?php include ROOT . '/cms-includes/partials/nav.php'; ?>

    <h1>Create new page</h1>

    <form class="flex column" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <label class="mt mb" for="page_title">Page title</label>
        <input required type="text" name="page_title" id="page_title">

        <label class="mt mb" for="content">Content</label>
        <textarea required name="content" id="content" cols="30" rows="10"></textarea>

        <div class="mt">
            <input type="radio" name="visibility" id="public" value="true" <?php if ($visibility) {
                                                                                echo "checked";
                                                                            } ?>>Public

            <input type="radio" name="visibility" id="private" value="false" <?php if (!$visibility) {
                                                                                    echo "checked";
                                                                                } ?>>Draft
        </div>
        <input class="btn mt" type="submit" value="submit">
    </form>

</body>

</html>