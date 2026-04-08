<!-- This is the landing page for DoodleDesk!
 After logging in, users will be met with a 'board'
 with all of their notes. Here users will be able to add
 sticky notes that contain information they need -->

<!DOCTYPE html>
<?php
include 'include.php';

// If user is already logged in, redirect them to the homepage
if ($logged_in)
{
    header('Location: index.php');
    die();
}?>
 <html lang='en'>
     <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <link rel="stylesheet" href="style.css">
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
             .container {
                 display: flex;
                 flex-direction: column; 
                 align-items: center; 
             } 
         </style>
     </head>
 
     <body>
        <?php include 'header.php'; ?>
         <div class="container">
             <h1>Welcome To</h1>
             <img src='images/DDLogo_transparent.png' alt="Logo" class="logo">
         </div>
         <!-- Container for all user options -->
         <div class="options"> 
             <a href="login.php" class="bigButton">Login</a>
             <a href="signup.php" class="bigButton">Sign Up</a>
         </div>
 
 
         <script type="text/javascript" src="script.js"></script>
 
     </body>
 </html>
 