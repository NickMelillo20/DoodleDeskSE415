<?php
// Don't reinclude
if ($included)
	return;
$included = true;

// Enable errors
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Set date timezone
date_default_timezone_set('US/Eastern');

// Shorthand SQL execute function
function sql_exec(mysqli $mysqli, string $query, string $types, &...$vars)
{
	$stmt = mysqli_prepare($mysqli, $query);
	mysqli_stmt_bind_param($stmt, $types, ...$vars);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	mysqli_stmt_close($stmt);
	return $result;
}

// Connect to database
$mysqli = mysqli_connect('localhost', 'root', '', 'doodledesk');

// Start session
session_start();

// Initialize messages and errors arrays if they don't exist
if (!array_key_exists('messages', $_SESSION))
	$_SESSION['messages'] = [];
if (!array_key_exists('errors', $_SESSION))
	$_SESSION['errors'] = [];

// If session has an id key, user is logged in
$logged_in = array_key_exists('id', $_SESSION);

// If user is not logged in, redirect to login page (if they're not there already)
if (!$logged_in && basename($_SERVER['REQUEST_URI']) == 'index.php')
{
	$_SESSION['errors'][] = "Please log in first!";
	header('Location: front.php');
	die();
}

// Get user from db if logged in
if ($logged_in)
{
	$user = mysqli_fetch_assoc(sql_exec($mysqli,
		'SELECT * FROM user WHERE id = ? LIMIT 1', 'i', $_SESSION['id']));
}

// If action_type in POST form data (user is performing an action)
if (array_key_exists("action_type", $_POST))
{
	// Action logic
	switch ($_POST["action_type"])
	{
		case "login":
			if (empty($_POST['emailOrUsername']) || empty($_POST['password'])) {
				$_SESSION['errors'][] = "Username and password are required.";
				break;
			}

			$result = sql_exec($mysqli, 'SELECT * FROM user WHERE username=? OR email=?',
				'ss', $_POST['emailOrUsername'], $_POST['emailOrUsername']);
			$row = mysqli_fetch_assoc($result);

			if($row && password_verify($_POST['password'], $row['password'])) {
				$_SESSION['messages'][] = "Logged in!";
				$_SESSION['id'] = $row['id'];
				header('Location: index.php');
				die();
			}
			else {
				$_SESSION['errors'][] = "Username or password is incorrect.";
			}
			break;
		case "edit_user":
			$edited_user = mysqli_fetch_assoc(sql_exec($mysqli,
				'SELECT * FROM user WHERE id = ? LIMIT 1', 'i', $_POST['id']));

			$password = empty($_POST['password'])
					? $edited_user['password']
					: password_hash($_POST['password'], PASSWORD_DEFAULT);

			sql_exec($mysqli, '
				INSERT INTO user (id, username, email, password)
				VALUES (?, ?, ?, ?)
				ON DUPLICATE KEY UPDATE username=?, email=?, password=?;
			', 'issssss',
				$_POST['id'],
				$_POST['username'],
				$_POST['email'],
				$password,
				$_POST['username'],
				$_POST['email'],
				$password
			);

			$user_id = is_null($edited_user) ? mysqli_insert_id($mysqli) : $_POST['id'];

			$_SESSION['messages'][] = array_key_exists('id', $_POST) ? "User edited!" : "User created!";
			header('Location: login.php');
			die();
	}

	// Redirect to same page (so their browser GETs, to prevent form resubmission)
	header('Location: '.$_SERVER['REQUEST_URI']);
	die();
}
?>
