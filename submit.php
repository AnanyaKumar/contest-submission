<?php
	error_reporting(0);
	session_start();
	if ( !isset($_SESSION['user']) ) header("Location: index.html?error=true");
	$con = mysqli_connect("localhost", "USERNAME", 'PASSWORD', 'DOMAIN');
	
	$user = $_SESSION['user'];
	$prob = mysqli_real_escape_string($con, $_POST['problem']);
		
	$allowed_filetypes = array('.cpp','.c'); //Allowed files
	$max_filesize = 524288; //Max file size, based on problem and host
	
	$filename = $_FILES['submitted_file']['name']; // Get the name of the file (including file extension).
	//echo $filename; //Debug: check file name
	$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
	
	if ( !in_array($ext, $allowed_filetypes) )
    	die('The file you attempted to upload is not allowed. The submission site only accepts C or C++ source code at the moment.');
    	
    if ( filesize($_FILES['submitted_file']['tmp_name']) > $max_filesize )
      	die('The file you attempted to upload is too large.');
      	      	
    $query = 'SELECT * FROM submissions WHERE usr="'.$user.'" AND pname="'.$prob.'"';
    $result = mysqli_query($con, $query);
    $sno = mysqli_num_rows($result)+1;
    $fpath = 'le9ah37dgsjf4/'.$user.'__'.$prob.'_'.$sno.$ext;
       	
   	if ( !move_uploaded_file($_FILES['submitted_file']['tmp_name'], $fpath) )
   	{
   		die('Something, somewhere, went wrong during the file upload.  Please try again.');
   	}
   	
   	$date = new DateTime();
	date_timezone_set($date, timezone_open('Asia/Singapore'));
	$dstr = date_format($date, 'Y-m-d H:i:s');
	
	$query = 'INSERT INTO submissions VALUES ("'.$user.'", "'.$prob.'", "'.$sno.'", "'.$dstr.'", "'.$ext.'")';
	mysqli_query($con, $query);
	
	echo "Upload successful!";
?>