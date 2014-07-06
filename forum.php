<?php
	error_reporting(0);
	session_start();
	if ( !isset($_SESSION['user']) ) header("Location: index.html?error=true");
?>

<!DOCTYPE html>

<html>

<head>
	<link rel="stylesheet" href="judge.css" type="text/css">
	<title> NUSH Judge </title>
</head>

<body>
	<div class="menu">
		<span class = "welcome" style='float:left'> <i><b> Welcome <?php echo $_SESSION['user'] ?> </i></b></span>
		<span class = "options" style='float:right'>
			<a href="forum.php">Forum</a>
			|
			<a href="choosecontest.php">Contests</a>
			|
			<a href="reference.php">Reference</a>
			|
			<a href="logout.php">Logout</a>
		</span>
	</div>
	<br>	
	<div> <hr> </div>
	
	<iframe src="http://nushjudge.freeforums.net/" runat="server" scrolling="auto" width="100%" height="1500" frameborder="0" allowtransparency="true">
</body>

</html>