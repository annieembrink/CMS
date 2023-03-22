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

if($_POST) 
{

    $page_title = $_POST['page_title'];
    $content = $_POST['content'];
    $visibility = $_POST['visibility'];

    //trim
    //save value if only one is filled
    if(!empty($page_title) && !empty($content)) {
        $result = $template->create_page($page_title, $content, $visibility);
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
            echo "<article><aside><p>". $_SESSION['message'] . "</p></aside></article>";
            unset( $_SESSION['message']); // remove it once it has been written
        }
    ?>

<?php include ROOT . '/cms-includes/partials/nav.php'; ?>

    <a id="logout" href="logout.php">Logout</a>

    <h1>Create new page</h1>

    <div>
        <p># Heading level 1</p>
        <p>## Heading level 2...</p>
        <p>...and so on until level 6</p>
        <p>**bold text**</p>
        <p>*italicized text*</p>
        <p>***bold and italic***</p>
        <p>- First li in ul</p>
        <p><a href="https://www.markdownguide.org/basic-syntax/">For more markdown syntax</a></p>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <label for="page_title">Page title</label>
        <input required type="text" name="page_title" id="page_title">

        <label for="content">Content</label>
        <textarea required name="content" id="content" cols="30" rows="10"></textarea>

        <input type="radio" name="visibility" id="public" value="true" <?php if ($visibility) { echo "checked"; } ?>>Publish
        
        <input type="radio" name="visibility" id="private" value="false" <?php if (!$visibility) { echo "checked"; } ?>>Save draft

        <br>
        <a href="view.php">Preview page</a>
        <input type="submit" value="submit">
    </form>
    
</body>
</html>