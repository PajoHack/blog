<?php 
	session_start(); // start session & check the user id.
	if(!isset($_SESSION['user_id'])){
		header("Location: login.php");
		exit();
	}
	include('../includes/db_connect.php');
	// Count blog posts
	$post_count = $dbc->query("SELECT * FROM posts");
	// Count comments
	$comment_count = $dbc->query("SELECT * FROM comments");
	
	if(isset($_POST['submit'])){
		$newCategory = $_POST['newCategory'];
		if(!empty($newCategory)){
			$sql = "INSERT INTO categories (category) VALUES ('$newCategory')";
			$query = $dbc->query($sql);
			if($query){
				echo 'New Category added.';
			}else {
				echo 'Error';
			}
		}else {
			echo 'Please enter a new category';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="../css/blog.css">
</head>

<style>
	.backGroundImage {
		background-image: url("../images/comp3.jpg");
		background-size: cover;
		background-repeat: no-repeat;
	}
</style>

<body>

	<div class="backGroundImage">
	<div id="container">
		<h1>Admin Control Panel</h1>
		<div id="menu">
			<ul>
				<li><a href="../index.php">Home</a></li>
				<li><a href="new_post.php">New Blog Entry</a></li>
				<li><a href="admin.php">Admin</a></li>
				<li><a href="logout.php">Log Out</a></li>
			</ul>
		</div>
		<div id="maincontent">
			<table>
				<tr>
					<td>Total Blog Posts</td>
					<td><?php echo $post_count->num_rows?></td>
				</tr>
				<tr>
					<td>Total Comments</td>
					<td><?php echo $comment_count->num_rows?></td>
				</tr>
			</table>
			<div id="categoryForm">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
					<label for="category">Add New Category</label>
					<input type="text" name="newCategory" />
					<input type="submit" name="submit" value="Submit" />
				</form>
			</div>
		</div>
	</div>
	</div> <!-- End of background image div -->
</body>
</html>