<!DOCTYPE html>
<?php
include 'include.php';

if ($logged_in)
{
    header('Location: index.php');
    die();
}
?>
<html lang='en'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Doodle Desk</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(rgba(255,255,255,0.1), rgba(0,0,0,0.5)), 
                        url('images/desk.jpg') center/cover fixed;
            color: white;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
        }

        .nav-links a {
            margin-left: 20px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        /* HERO SECTION */
        .hero {
            text-align: center;
            margin-top: 80px;
        }

        .hero h1 {
            font-size: 3rem;
            font-family: Georgia, serif;
        }

        .hero p {
            font-size: 1.2rem;
            margin: 20px 0;
        }

        .hero .cta {
            padding: 12px 25px;
            background-color: #ffcc00;
            color: black;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
        }

        /* FEATURES SECTION */
        .features {
            background: rgba(0,0,0,0.7);
            padding: 60px 20px;
            margin-top: 80px;
            text-align: center;
        }

        .features h2 {
            margin-bottom: 40px;
        }

        .feature-grid {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .feature {
            max-width: 250px;
        }

        .logo {
            width: 200px;
            margin-top: 20px;
        }

    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <img src="images/DDLogo_transparent.png" class="logo" alt="Logo">

        <div class="nav-links">
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
        </div>
    </div>

    <!-- HERO -->
    <div class="hero">
        <h1>DoodleDesk</h1>
        <p>Your digital workspace for quick notes, ideas, and organization.</p>
        <a href="signup.php" class="cta">Get Started</a>
    </div>

    <!-- FEATURES -->
    <div class="features">
        <h2>Why Use DoodleDesk?</h2>

        <div class="feature-grid">
            <div class="feature">
                <h3>📝 Sticky Notes</h3>
                <p>Create and manage notes just like a real desk.</p>
            </div>

            <div class="feature">
                <h3>⚡ Fast & Simple</h3>
                <p>No clutter. Just quick access to what matters.</p>
            </div>

            <div class="feature">
                <h3>📱 Anywhere</h3>
                <p>Access your notes from any device.</p>
            </div>
        </div>
    </div>

</body>
</html>