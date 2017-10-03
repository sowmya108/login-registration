<?php
	ob_start();
	session_start();
	include 'dbconnect.php';
	
	// it will never let you open index(login) page if session is set
	if ( isset($_SESSION['user'])!="" ) {
		header("Location: userdetails.php");
		exit;
	}
	
	$error = false;
	
	if( isset($_POST['btn-login']) ) {	
		
		// prevent sql injections/ clear user invalid inputs
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		// prevent sql injections / clear user invalid inputs
		
		if(empty($email)){
			$error = true;
			$emailError = "Please enter your email address.";
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		}
		
		if(empty($pass)){
			$error = true;
			$passError = "Please enter your password.";
		}
		
		// if there's no error, continue to login
		if (!$error) {
			
			$password = hash('sha256', $pass); // password hashing using SHA25
			
			$query = "SELECT userId, userName, userPass FROM users WHERE userEmail='$email'";
			$sth = $dbh->query($query);
			$sth->setFetchMode(PDO::FETCH_ASSOC);
			$data = $sth->fetch();
			if(!empty($data)){
				if($data['userPass']==$password ) {
					$_SESSION['user'] = $data['userId'];
					addUserActivty("logged in",$data['userId']);
					header("Location: userdetails.php");
				} else {
					$errMSG = "Incorrect Credentials, Try again...";
				}
			}	
		}
		
	}
	include "home.php";
?>
</body>
</html>
<?php ob_end_flush(); ?>
