<?php
	error_reporting(0);
	session_start();
	if ( !isset($_SESSION['user']) ) header("Location: index.html?error=true");
	$con = mysqli_connect("localhost", "USERNAME", 'PASSWORD', 'DOMAIN');
	$user = $_SESSION['user'];
	
	$cname = mysqli_real_escape_string($con, $_GET['cname']);
	$query = 'SELECT isopen FROM contests WHERE cname = "'.$cname.'"';
	$result = mysqli_query($con, $query);
	if ( mysqli_num_rows($result) == 0 ) die('Please return to the contest selection page and choose a valid contest');
	$row = mysqli_fetch_array($result);
	if ( !$row['isopen'] ) die('The contest you are looking for is not currently open');
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
		
	<br>
	
	Problems: 
	
	<?php
	
	//Todo: Is user authorized to go to this contest? Else print error
		
	//Display list of problems (link URLS)
	
	$query = 'SELECT * FROM problems WHERE pname in (SELECT pname FROM prob_contest WHERE cname = "'.$cname.'")';
	//echo $query;
	$result = mysqli_query($con, $query);
	
	while ( $row = mysqli_fetch_array($result) )
	{
		$pname = $row['pname'];
		$url = $row['url'];
		echo '<a href = "'.$url.'"><i>'.$pname.'</i></a> ';
	}
	
	?>
	
	<br><br>
	Use the form below to submit your solution. At the moment the judge only accepts C and C++ source codes.
	Please note that <i> only your final submission </i> to each problem will be graded. You may use this submission
	system to store backups of your source codes.
	
	<form method="post" action="submit.php" enctype="multipart/form-data">
				
		<select name="problem">
			
			<?php
			
			$query = 'SELECT pname FROM prob_contest WHERE cname = "'.$cname.'"';
			$result = mysqli_query($con, $query);
			
			while ( $row = mysqli_fetch_array($result) )
			{
				$pname = $row['pname'];
				echo '<option value="'.$pname.'">'.$pname.'</option>';
			}
			
			?>
		
		</select> &nbsp &nbsp &nbsp
		
		<input type="file" name="submitted_file"  /> <br> <br>
		
		<input type="submit" name=".submit" value="Submit" />
		
	</form>
	
	<?php
	
	$query = 'SELECT pname FROM prob_contest WHERE cname = "'.$cname.'"';
	$result = mysqli_query($con, $query);
	
	while ( $row = mysqli_fetch_array($result) )
	{
		$pname = $row['pname'];
		echo '<br> <br>Your submissions for <i>'.$pname.'</i>:<br><br>';
		
		echo '<table class="list" cols=3 border=1 cellspacing=0>';
		echo '<tr>';
		echo '<th class="first" width = "30">#</th>';
		echo '<th width = "150">Submission</th>';
		echo '<th width = "150">Date & Time</th>';
		echo '</tr>';
		
		$subquery = 'SELECT * FROM submissions WHERE usr="'.$user.'" AND pname="'.$pname.'"';
		$subresult = mysqli_query($con, $subquery);
		
		while ( $column = mysqli_fetch_array($subresult) )
		{
			$sno = $column['sno'];
			$ext = $column['sname'];
			$url = 'download.php?pname='.$pname.'&sno='.$sno.'&ext='.$ext;
			echo '<tr>';
			echo '<td class="first">'.$sno.'</td>';
			echo '<td><a href="'.$url.'">'.$pname.'_'.$sno.$ext.'</a></td>';
			echo '<td>'.$column['stime'].'</td>';
			echo '</tr>';
		}
		
		echo '</table>';
	}
	
	?>
	
	<br>
	
	<p> Quotes to keep you going: </p>
		
	<p><i>"Our greatest weakness lies in giving up. The most certain way to succeed is always to try just one more time." </i> - Thomas A. Edison </p>
	
	<p><i>"Being defeated is often a temporary condition. Giving up is what makes it permanent."</i> - Marilyn von Savant </p>
	
	<p><i>"There is no failure except in no longer trying."	</i> - Elbert Hubbard</p>
	
</body>

</html>