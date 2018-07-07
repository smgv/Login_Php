<?php

session_start();

if (isset($_POST['submit'])) 
 {
	# code...

	include_once 'dbh.inc.php';

	$uid = $_POST['uid'];
	$pwd = $_POST['pwd'];

	//error handler
	if (empty($uid) || empty($pwd)) 
	 {
		# code...
		header("Location: ../index.php?login=empty");
 	  	exit();
	 }
	else
	 {
	 	$sql = "SELECT * FROM user WHERE user_uid='$uid'";
	 	$result = mysqli_query($conn, $sql);
	 	$resultcheck = mysqli_num_rows($result);
	 	if ($resultcheck < 1) 
	 	 {
	 		# code...
	 		header("Location: ../index.php?login=error");
 			exit();
	 	 }
	 	else
	 	 {
	 	 	if ($row = mysqli_fetch_assoc($result))
	 	 	 {
	 	 		# code...
	 	 		//dehashing the password
	 	 		$hashPwdcheck = password_verify($pwd, $row['user_pwd']);
	 	 		if ($hashPwdcheck == false) 
	 	 		 {
	 	 			# code...
	 	 			header("Location: ../index.php?login=error1");
 					exit();
	 	 		 }
	 	 		elseif ($hashPwdcheck == true) 
	 	 		 {
	 	 			# code...
	 	 			// log user 
	 	 			$_SESSION['user_id'] = $row['user_id'];
	 	 			$_SESSION['user_first'] = $row['user_first'];
	 	 			$_SESSION['user_last'] = $row['user_last'];
	 	 			$_SESSION['user_email'] = $row['user_email'];
	 	 			$_SESSION['user_uid'] = $row['user_uid'];
	 	 			header("Location: ../index.php?login=success");
 					exit();

	 	 		 }
	 	 	 }

	 	 }
	 }
 }
else
 {
 	header("Location: ../includes/index.php?login=error");
 	exit();
 }


?>