<?php //todo: instead of session, store it in cookies and put the result of $arr in cookies
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

	$users = pg_query($db, "SELECT * FROM users WHERE username='$username'");
	$arr = pg_fetch_all($users);

	$success = false;
	if (empty($arr)) {
		$_SESSION['errors']['username'] = "A user with username \"$username\" does not exist!";
	} else {
		$success = collect($arr)->contains(function ($user) use ($password) {
			return (new \Illuminate\Hashing\BcryptHasher)->check($password, $user['password']);
		});
	}

	$_SESSION['v_records'] = $arr;
	if ($success) {
		$_SESSION['auth'] = $username;
		header("Location: /?message=Success");
	} else {
		$_SESSION['v_errors']['password'] = 'Invalid password!';
		header("Location: /part1.php?username=$username&password=$password");
	}
?>

