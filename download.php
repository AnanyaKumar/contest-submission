<?php
	error_reporting(0);
	session_start();
	include 'header.php';
	if ( !isset($_SESSION['user']) ) header("Location: index.html?error=true");
	$con = mysqli_connect("localhost", "USERNAME", 'PASSWORD', 'DOMAIN');
	
	$user = $_SESSION['user'];
	$pname = getProblem($con, $_GET['pname']);
	$sno = (int)($_GET['sno']);
	$ext = $_GET['ext'];
	$src = 'le9ah37dgsjf4/'.$user.'__'.$pname.'_'.$sno.$ext;
	echo $pname . ' ' . $sno . ' ' . $ext . ' ' . isValidExt($ext);
	//header("Location: ".$src);
	
	if ( !$sno ) echo "you die";
	
	if ( !$pname || !is_int($sno) || !isValidExt($ext) || !($fptr = fopen($src, "r")) )
	{
		die('The file you are looking for does not exist');
	}
	
	echo "<xmp>";
	
	while ( !feof($fptr) )
	{
		echo fgets($fptr);
	}
	
	echo "</xmp>";
?>	