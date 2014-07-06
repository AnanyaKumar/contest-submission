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
	
	<h2> Contest Home Page </h2>
	
	Please select the contest you wish to take part in. <br> <br>
	
	<table class="list" cols=4 border=1 cellspacing=0>
		<tr><th class="first" width = '150'>Name</th><th width = '150'>Start Time</th><th width = '150'>End Time</th><th width = '120'>Ongoing?</th></tr>
		
		<?php
		$con = mysqli_connect("localhost", "USERNAME", 'PASSWORD', 'DOMAIN');
		$user = $_SESSION['user'];
		$query = 'SELECT * FROM contests WHERE cname IN (SELECT cname FROM participate where usr = "'.$user.'")';
		$result = mysqli_query($con, $query);
			
		while ( $row = mysqli_fetch_array($result) )
		{
			$cname = $row['cname'];
			$stime = $row['stime'];
			$etime = $row['etime'];
			$isopen = $row['isopen'];
			
			echo '<tr>';
			echo '<td class="first"> <a href="contest.php?cname='.$cname.'">'.$cname.'</a></td>';
			echo '<td>'.$stime.'</td>';
			echo '<td>'.$etime.'</td>';
			if ( $isopen == 0 ) echo '<td>No</td>';
			else echo '<td>Yes</td>';
			echo '</tr>';
		}
		?>
	</table>
	
</body>

</html>