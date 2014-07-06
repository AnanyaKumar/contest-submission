<?php
function getProblem ( $con, $pname ) //Check if a problem exists and return a secure version of the name
{
	$query = 'SELECT * FROM problems WHERE pname = "'.$pname.'"';
	$result = mysqli_query($con, $query);
	if ( mysqli_num_rows($result) == 0 ) return false;
	$row = mysqli_fetch_array($result);
	return $row['pname'];
}

function isValidExt ( $ext ) //Checks if the extension is valid
{
	if ( $ext == '.c' || $ext == '.cpp' ) return true;
	else return false;
}

?>