<!-- This is the landing page for DoodleDesk!
 After logging in, users will be met with a 'board'
 with all of their notes. Here users will be able to add
 sticky notes that contain information they need -->

<!DOCTYPE html>
<?php
include 'include.php';
$page = 1;
if (array_key_exists('page', $_GET) && is_numeric($_GET['page']))
    $page = (int)($_GET['page']);
?>
<html lang='en'>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <script>const NOTES_KEY = "notes_p<?php echo $page ?>";</script>
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
        <?php include 'header.php'; ?>
        <h1>Page <?php echo $page ?></h1>
        
        <!-- Container for all user options -->
        <div class ="options"> 
            <a href="?page=<?php echo $page + 1 ?>" class="button"> Next Page</a>
            <a href="?page=<?php echo max(1, $page - 1) ?>" class="button"> Previous Page</a>
            <a href="settings.php" class="button"> Settings</a>
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
