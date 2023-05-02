<?php
session_start();
require_once 'config.php';

if (isset($_POST['login'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$sql = "SELECT * FROM users WHERE email = '$email'";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
		if (password_verify($password, $row['password'])) {
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['username'] = $row['username'];
			header('Location: dashboard.php');
		} else {
			$_SESSION['error'] = 'Invalid password';
			header('Location: index.php');
		}
	} else {
		$_SESSION['error'] = 'Email not found';
		header('Location: index.php');
	}
}

mysqli_close($conn);
?>
