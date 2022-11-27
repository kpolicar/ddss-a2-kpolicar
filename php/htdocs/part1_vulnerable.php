<?php
	session_start();
	require_once __DIR__ . '/vendor/autoload.php';


	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$password = $_POST['v_password'];
		$username = $_POST['v_username'];
		$remember = $_POST['v_remember'];
	} else{
		$password = $_GET['v_password'];
		$username = $_GET['v_username'];
		$remember = $_GET['v_remember'];
	}

	$db = pg_connect("host=db dbname=ddss-database-assignment-2 user=ddss-database-assignment-2 password=ddss-database-assignment-2");

	$users = pg_query($db, "SELECT * FROM users WHERE username='$username' AND password='$password'");
	// printTable($users);
	$arr = pg_fetch_all($users);

	$_SESSION['records'] = $arr;
	header("Location: /part1.php?username=$username&password=$password");
?>

