<?php 
	session_start();
	include_once("../includes/db_connect.php");
	
	//if (!isset($_SESSION['password'])){
	//	header("Location: login.php");
	//	return;
	//}
	
	if (!isset($_GET['pid'])){
		header("Location: ../index.php");
	}
	
	$pid = $_GET['pid'];
	
	if (isset($_POST['update'])){
		$title = strip_tags($_POST['title']);
		$content = strip_tags($_POST['body']);
		
		$title = mysqli_real_escape_string($dbc, $title);
		$content = mysqli_real_escape_string($dbc, $content);
		
		$date = date('Y-m-d H:i:s');
		
		$sql = "UPDATE posts SET title='$title', body='$content', posted='$date' WHERE post_id='$pid'";
		
		if ($title == "" || $content == ""){
			echo "Title & Content required in order to complete successful post!";
			return;
		}
		
		mysqli_query($dbc, $sql);
		
		header("Location: ../index.php");
	}
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Posts</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="../css/blog.css">
		<style>
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
			
			<h1>Edit Post</h1>
			<?php
				$sql2 = "SELECT * FROM posts WHERE post_id=$pid LIMIT 1";
				$result = mysqli_query($dbc, $sql2);
				
				if (mysqli_num_rows($result) > 0){
					while ($row = mysqli_fetch_assoc($result)){
						$id = $row['post_id'];
						$title = $row['title'];
						$content = $row['body'];
						
					echo "<form action='edit_post.php?pid=$pid' method='post' enctype='multipart/form-data'>";
					echo "<input placeholder='Title' name='title' type='text' value='$title' autofocus size ='48'><br />";
					echo "<br />";
					echo "<textarea placeholder='Content' name='body' rows='20' cols='50'>$content</textarea><br />";
					echo "<br />";
					}
				}
			?>
				<input name="update" type="submit" value="update">
			</form>
			</div>
			</div>
		</body>
	</html>