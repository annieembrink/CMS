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

$title = "Edit"; 

if (isset($_GET['id'])) {
    $_SESSION['page_id'] = $_GET['id'];
}

// Retrieve the page ID from the session variable
if (isset($_SESSION['page_id'])) {
    $page_id = $_SESSION['page_id'];
    $page = $page_template->view_page($page_id);
    $page_title = $page['page_title']; 
    $content = $page['content']; 
    $visibility = $page['visibility'];
} else {
    // Redirect if the page ID is not set
    header('Location: allpages.php');
    exit;
}

if($_POST) {
    $page_title = $_POST['page_title'];
    $content = $_POST['content'];

    if (isset($_POST['visibility'])) {
        $visibility = ($_POST['visibility'] === 'true') ? true : false;
    } else {
        $visibility = false;
    }
    
    //trim
    //save value if only one is filled
    if(!empty($page_title) && !empty($content)) {
        //passinfo bout who changed page? update user_id in page?
        //Update when page was edited?
        $result = $page_template->edit_page($_SESSION['page_id'], $page_title, $content, $visibility);
        header('Location: allpages.php');
        unset($_SESSION['page_id']);
        $_SESSION['message'] = "Successfully updated your page!";
        exit();
    } else {
        $_SESSION['message'] = "Could not update your page, try again later";
        header('Location: allpages.php');
        unset($_SESSION['page_id']);
        exit();
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
            echo "<article><aside><p>". $_SESSION['message'] . "</p></aside></article>";
            unset( $_SESSION['message']); // remove it once it has been written
        }
    ?>

<?php include ROOT . '/cms-includes/partials/nav.php'; ?>

    <h1>Edit page</h1>

    <form class="flex column" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <label class="mt mb" for="page_title">Page title</label>
        <input required type="text" name="page_title" id="page_title" value="<?=$page_title?>">

        <label class="mt mb" for="content">Content</label>
        <textarea required name="content" id="content" cols="30" rows="10"><?php echo $content ?></textarea>

        <div class="mt">
        <input type="radio" name="visibility" id="public" value="true" <?php if ($visibility) { echo "checked"; } ?>>Public
        
        <input type="radio" name="visibility" id="private" value="false" <?php if (!$visibility) { echo "checked"; } ?>>Draft
        </div>
        <input class="btn mt" type="submit" value="submit">
    </form>
    
</body>
</html>