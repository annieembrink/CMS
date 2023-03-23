<?php

declare(strict_types=1);
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include_once 'cms-config.php';
include_once ROOT . '/cms-includes/global-functions.php';
include_once ROOT . '/cms-includes/models/Database.php';
include_once ROOT . '/cms-includes/models/Template.php';
require_once "Parsedown.php";

$template = new Template();

$title = "Create";
$page_title = "";
$content = "";
$visibility = false;

if ($_POST) {
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
        $result = $template->create_page($_SESSION['user_id'], $page_title, $content, $visibility);
        header('Location: allpages.php');
        $_SESSION['message'] = "Successfully created page!";
        exit();
    } else {
        $_SESSION['message'] = "All input fields have to be filled";
    }
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
        echo "<article><aside><p>" . $_SESSION['message'] . "</p></aside></article>";
        unset($_SESSION['message']); // remove it once it has been written
    }
    ?>

    <?php include ROOT . '/cms-includes/partials/nav.php'; ?>

    <a id="logout" href="logout.php">Logout</a>


    <h1>Create new page</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <label for="page_title">Page title</label>
        <input required type="text" name="page_title" id="page_title">

        <label for="content">Content</label>
        <!-- <textarea hidden name="content" id="content" cols="30" rows="10"><?php $editor_js_value ?></textarea> -->

        <textarea hidden name="content" id="content" cols="30" rows="10"><?php echo $content ?></textarea>


        <div id="editorjs"></div>

        <input type="radio" name="visibility" id="public" value="true" <?php if ($visibility) {
                                                                            echo "checked";
                                                                        } ?>>Public

        <input type="radio" name="visibility" id="private" value="false" <?php if (!$visibility) {
                                                                                echo "checked";
                                                                            } ?>>Draft

        <br>
        <input type="submit" value="submit">
    </form>


    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>

    <script>
        const editor = new EditorJS({
            holder: 'editorjs',
            tools: {
                header: Header,
                list: {
                    class: List,
                    inlineToolbar: true,
                },
            }
        });

        // Add event listener for form submit
        document.querySelector('form').addEventListener('submit', (event) => {
            // Update the value of the hidden textarea field with the content of the editor
            editor.save().then((outputData) => {
                document.getElementById('content').innerText = JSON.stringify(outputData);
                // Submit the form
                document.querySelector('form').submit();
            }).catch((error) => {
                console.log('Error: ', error);
            });
            event.preventDefault(); // Prevent the form from submitting before the editor is saved
        });
    </script>


</body>

</html>