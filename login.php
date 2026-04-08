<!--This is the login form. 
after clicking login the user will be sent here to fill in their credentials.
They will then be sent to the homepage source w3schools-->

<!DOCTYPE html>
<?php
include 'include.php';

// If user is already logged in, redirect them to the homepage
if ($logged_in)
{
    header('Location: index.php');
    die();
}?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url('images/doodlebg.jpeg') center/cover fixed;
        }
        .login-form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .login-form h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .login-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-form input[type="checkbox"] {
            margin-right: 5px;
        }
        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <form class="login-form" method="POST">
        <h2>Login</h2>
        <input type="hidden" name="action_type" value="login" />
        <label for="emailOrUsername">Enter Email or Username:</label>
        <input type="text" id="emailOrUsername" name="emailOrUsername" required>
        <span id="emailError" style="color: red; display: none;">Please enter your email or username.</span>
        
        <label for="password">Enter Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="button" id="togglePasswordButton">Show</button>
        <span id="passwordError" style="color: red; display: none;">Please enter your password.</span>

        <script>
            const emailInput = document.getElementById('emailOrUsername');
            const passwordInput = document.getElementById('password');
            const togglePasswordButton = document.getElementById('togglePasswordButton');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            const form = document.querySelector('.login-form');

            togglePasswordButton.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordButton.textContent = 'Hide';
            } else {
                passwordInput.type = 'password';
                togglePasswordButton.textContent = 'Show';
            }
            });

            form.addEventListener('submit', (event) => {
            let valid = true;

            if (!emailInput.value.trim()) {
                emailError.style.display = 'block';
                valid = false;
            } else {
                emailError.style.display = 'none';
            }

            if (!passwordInput.value.trim()) {
                passwordError.style.display = 'block';
                valid = false;
            } else {
                passwordError.style.display = 'none';
            }

            if (!valid) {
                event.preventDefault();
            }
            });
        </script>
        
        <label>
            <input type="checkbox" name="remember"> Remember me?
        </label>
        
        <button type="submit">Submit</button>
    </form>
</body>
</html>