<?php 
	session_start();
	include('../includes/db_connect.php');
	
	if(!isset($_SESSION['user_id'])){
		header('Location: login.php');
		exit();
	}
	$error_msg = "";
	if(isset($_POST['submit'])){
		$title = $_POST['title'];
		$body = $_POST['body'];
		$category = $_POST['category'];
		
		$title = $dbc->real_escape_string($title);
		$body = $dbc->real_escape_string($body);
		$user_id = $_SESSION['user_id'];
		$date = date('Y-m-d G:i:s');
		$body = htmlentities($body);
		if($title && $body && $category){
			$query = $dbc->query("INSERT INTO posts (user_id, title, body, category_id, posted) VALUES ('$user_id', '$title', '$body', '$category', '$date')");
			if($query){
				$error_msg = "Post Added Successfully";
			}else {
				$error_msg = 'Post error!';
			}
		}else {
			$error_msg = 'Please complete all fields!';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="../css/blog.css">
	<style>
		#container {
			margin: auto;
			width: 800px;
		}
		label {
			display: block;
		}
		.backGroundImage {
			background-image: url("../images/comp3.jpg");
			background-size: cover;
			background-repeat: no-repeat;
		}
		#error_msg {
			color: red;
		}
	</style> 
	 
</head>
<body>

	<div class="backGroundImage">
	
		<div id="container">
		
			<h1>New Blog post</h1>
	
			<div id="menu">
				<ul>
					<li><a href="../index.php">Home</a></li>
					<li><a href="category.php">Categories</a></li>
					<li><a href="admin/admin.php">Admin</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
		
				<br />
	
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
				<label>Title:</label><input type="text" name="title" />
				<label for="body">Body:</label>
				<textarea name="body" cols=50 rows=10 maxlength="200"></textarea>
				<label>Category:</label>
					<select name="category">
						<?php 
							$query = $dbc->query("SELECT * FROM categories");
							while($row = $query->fetch_object()){
								echo "<option value='".$row->category_id."'>".$row->category."</option>";
							}
						?>
					</select>
				<br />
				<input class= "submit" type="submit" name="submit" value="Submit" />
			</form>
			
				<br />
			<div id="error_msg">  
				<?php echo $error_msg; ?>
			</div>
		</div>
	</div> <!-- End of background image div -->
</body>
</html>