<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
$username = $_SESSION['auth'] ?? '?';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST['v_text'];
} else{
    $text = $_GET['v_text'];
}

$db = pg_connect("host=db dbname=ddss-database-assignment-2 user=ddss-database-assignment-2 password=ddss-database-assignment-2");

$result = $users = pg_query($db, "INSERT INTO messages (message, author) values ('$text', '$username')");

if ($result) {
    $_SESSION['v_errors']['message'] = 'Something went wrong!';
}
header("Location: /part2.php");
?>

