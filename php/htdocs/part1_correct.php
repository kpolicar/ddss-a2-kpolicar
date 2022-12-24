<?php
try {
	error_reporting(0);
	session_start();
	require_once __DIR__ . '/vendor/autoload.php';

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$password = $_POST['c_password'];
		$username = $_POST['c_username'];
		$remember = $_POST['c_remember'];
	} else{
		$password = $_GET['c_password'];
		$username = $_GET['c_username'];
		$remember = $_GET['c_remember'];
	}

	$db = pg_connect("host=db dbname=ddss-database-assignment-2 user=ddss-database-assignment-2 password=ddss-database-assignment-2");

	$users = pg_query_params($db, "SELECT * FROM users WHERE username=$1", [$username]);
	$arr = pg_fetch_all($users);

	$success = !empty($arr) && collect($arr)->contains(function ($user) use ($password) {
			return (new \Illuminate\Hashing\BcryptHasher)->check($password, $user['password']);
		});

	if ($success) {
		$_SESSION['auth'] = $username;
		header("Location: /?message=Success");
	} else {
		$_SESSION['c_errors']['credentials'] = 'Could not find a user matching the credentials!';
		header("Location: /part1.php?username=$username&password=$password");
	}
} catch (Exception $e) {
	exit(500);
}
?>

