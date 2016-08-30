<?php 
	session_start();
	
	$error_msg = "";
	if(isset($_POST['submit'])){ // check to see if login form was submitted
		// grab username, password & store them in variables
		$user = $_POST['username'];
		$pwrd = $_POST['password'];
		// Include DB connection 
		include('../includes/db_connect.php');
		// validate values in the login fields
		if (empty($user) || empty($pwrd)){
			$error_msg = "Username or Password field empty!";
		}else {
			$user = trim(strip_tags($user));
			$user = mysqli_real_escape_string($dbc, $_POST['username']);
			$pwrd = trim(strip_tags($pwrd));
			$pwrd = mysqli_real_escape_string($dbc, $_POST['password']);
			$pwrd = md5($pwrd);
			$query = $dbc->query("SELECT user_id, username FROM user WHERE username='$user' AND password='$pwrd'");
			if($query->num_rows === 1){
				while($row = $query->fetch_object()){
					$_SESSION['user_id'] = $row->user_id;
				}
				header("Location: admin.php");
				exit();
				
			}else {
				$error_msg = "Credentials incorrect!";
			}	
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<style>
	.backGroundImage {
		background-image: url("../images/comp3.jpg");
		background-size: cover;
		background-repeat: no-repeat;
	}
	label {
		color: white;
		padding-left: 5px;
	}
	#error_msg {
	color: red;
	font-weight: bold;
	}
	</style>
</head>
<body>

	<div class="backGroundImage">
		<div id="container">
			<div><a href="../index.php">Home</a></div>
			<br />
			<form action="login.php" method="post">
				<table>
					<tr><label>Username: </label><input type="text" name="username" /></tr>
					<tr><label>Password: </label><input type="password" name="password" /></tr>
					<tr><input type="submit" name="submit" value="Login!" /></tr>
					<tr><div id="error_msg"><?php echo $error_msg; ?></div></tr>
				</table>

			</form>
			<br />
		</div>
	</div> <!-- End of background image div -->
</body>
</html>