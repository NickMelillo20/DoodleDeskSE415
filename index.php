<!-- This is the landing page for DoodleDesk!
 After logging in, users will be met with a 'board'
 with all of their notes. Here users will be able to add
 sticky notes that contain information they need -->

<!DOCTYPE html>
<?php
include 'include.php';

$page = 1;

// If searching
if (isset($_GET['search']) && $_GET['search'] !== '') {
    $search = strtolower(trim($_GET['search']));

    // Case 1: numeric input
    if (is_numeric($search)) {
        $page = (int)$search;
    } 
    // Case 2: search by title
    elseif (isset($_SESSION['page_titles'])) {
        foreach ($_SESSION['page_titles'] as $p => $title) {
            if (strpos(strtolower($title), $search) !== false) {
                $page = $p;
                break;
            }
        }
    }
}
// Fallback: direct page navigation
elseif (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (int)$_GET['page'];
}
?>
<html lang='en'>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <!-- <script>const NOTES_KEY = "notes_p<?php echo $page ?>";</script> -->
        <script>
            const userId = "<?php echo $_SESSION['id'] ?? 'guest'; ?>";
            const NOTES_KEY = `notes_user_${userId}_p<?php echo $page ?>`;
        </script>
        <title>Home - Doodle Desk</title>

        <style>
            h1 {
                text-align: center;
                font-family: Georgia, serif;
            }  
            body {
                background: linear-gradient(rgba(255,255,255,0.1), rgba(0, 0, 0, 0.5)), url('images/desk.jpg') center/cover fixed;
                min-height: 100vh;
            }      

        </style>
    </head>

    <body>
        <!-- Header with page title and options -->
        <?php include 'header.php'; ?>
        <?php
        $defaultTitle = "Page $page";
        $customTitleKey = "custom_title_p$page";
        $customTitle = $_SESSION[$customTitleKey] ?? $defaultTitle;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['custom_title'])) {
            $customTitle = htmlspecialchars($_POST['custom_title'], ENT_QUOTES, 'UTF-8');
            $_SESSION[$customTitleKey] = $customTitle;
            $_SESSION['page_titles'][$page] = $customTitle;
        }
        ?>
        <div style="text-align: center; margin: 20px 0;">
            <h1 style="font-size: 2.5rem; color: #333;"><?php echo $customTitle; ?></h1>
            <form method="POST" style="display: inline-block; margin-top: 10px;">
            <input 
                type="text" 
                name="custom_title" 
                placeholder="Edit Page Title" 
                value="<?php echo $customTitle; ?>" 
                style="padding: 10px; font-size: 1rem; border: 1px solid #ccc; border-radius: 5px; width: 300px;"
            >
            <button 
                type="submit" 
                style="padding: 10px 20px; font-size: 1rem; background-color:rgb(2, 50, 222); color: white; border: none; border-radius: 5px; cursor: pointer;"
            >
                Save
            </button>

            </form>
        </div>
        <!-- Container for all user options -->
        <div class="options"> 
            <a href="?page=<?php echo $page + 1 ?>" class="button"> Next Page</a>
            <a href="?page=<?php echo max(1, $page - 1) ?>" class="button"> Previous Page</a>
            <a href="settings.php" class="button"> Settings</a>
            <form method="GET" action="index.php" style="display: inline-block; margin-left: 10px;">
            <input 
                type="text" 
                name="search" 
                placeholder="Search Page Name or Number" 
                style="padding: 5px; font-size: 1rem; border: 1px solid #ccc; border-radius: 5px; width: 150px;"
                min="1"
                max="100"
            >
            <button 
                type="submit" 
                style="padding: 5px 10px; font-size: 1rem; background-color:rgb(2, 50, 222); color: white; border: none; border-radius: 5px; cursor: pointer;"
            >
                Go
            </button>
            </form>
            <a href="logout.php" class="button" style="float: right;"> Logout</a>
        </div>
        <hr width="100%" size="2" noshade> <!-- Horizontal Line across the top of the screen, credit: Geeks4Geeks-->

        <div class="noteIcon" id="noteIcon" style="cursor:pointer;">
            <img id="addNoteIcon" src="images/notepad.png" alt="Add Note" >
            <span style="color: white;">Add Note</span>
        </div>

        <div class="note-container"></div>
        <script type="text/javascript" src="script.js"></script>
    </body>
</html>
