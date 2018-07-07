<?php 

if (isset($_POST['submit'])) 
 {
	# code...
	include_once 'dbh.inc.php';

	$first = $_POST['first'];
	$last = $_POST['last'];
	$email = $_POST['email'];
	$uid = $_POST['uid'];
	$pwd = $_POST['pwd'];

	//Error Handlers
	// check for empty fields
	if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd) ) 
	 {
	# code...
	 	header("Location: ../signup.php?signup=empty");
 		exit();
	 }
	else
	 {	
	 	//check input characters are valid
	 	if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) 
	 	 {
	 		# code...
	 		header("Location: ../signup.php?signup=invalid");
 			exit();
	 	 }
	 	else
	 	 {
	 	 	// check email is valid
	 	 	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
	 	 	 {
	 	 		# code...
	 	 		header("Location: ../signup.php?signup=invalidemail");
 			    exit();
	 	 	 }
	 	 	else
	 	 	 {
	 	 	 	$sql = "SELECT * FROM user WHERE user_id ='$uid'";
	 	 	 	$result = mysqli_query($conn, $sql);
	 	 	 	$resultcheck = mysqli_num_rows($result);

	 	 	 	if ($resultcheck > 0) 
	 	 	 	 {
	 	 	 		# code...
	 	 	 		header("Location: ../signup.php?signup=usernameexist");
 			    	exit();
	 	 	 	 }
	 	 	 	else
	 	 	 	 {
	 	 	 	 	//hashing the password
	 	 	 	 	$hashPwd = password_hash($pwd, PASSWORD_DEFAULT);
	 	 	 	 	// Insert user data
	 	 	 	 	$sql = "INSERT INTO user(user_first, user_last, user_email, user_uid, user_pwd) VALUES ('$first', '$last', '$email', '$uid', '$hashPwd');";
	 	 	 	 	mysqli_query($conn, $sql);
	 	 	 	 	header("Location: ../signup.php?signup=success");
 			    	exit();
	 	 	 	 }

	 	 	 }
	 	 }

	 }


 }
else
 {
 	header("Location: ../signup.php");
 	exit();

 }



 ?>