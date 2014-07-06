<?php
	session_start();
	error_reporting(0);
	$con = mysqli_connect("localhost", "USERNAME", 'PASSWORD', 'DOMAIN');
	
	$username = strtolower(mysqli_real_escape_string($con, $_POST['username']));
	$password = mysqli_real_escape_string($con, $_POST['password']);
	
	if ( $username == 'ananya' && $password == 'singap0re' )
	{
		$_SESSION['admin'] = true;
		header("Location: manage.php");
	}
		
	$query = 'SELECT usr FROM users WHERE usr = "'.$username.'" AND pwd = "'.$password.'"';
	$result = mysqli_query($con, $query);
		
	if ( mysqli_num_rows($result) > 0 )
	{
		$_SESSION['user'] = $username;
		header("Location: choosecontest.php");
	}
		
	else
	{
		header("Location: index.html?error=true");
	}
?>