<?php 

	if (!isset($_GET['id'])){
		header('Locaion: index.php');
		exit();
	}else {
		$id = $_GET['id'];
	}
	include('includes/db_connect.php');
	if(!is_numeric($id)){
		header('Locaion: index.php');
	}
	$sql = "SELECT title, body FROM posts WHERE post_id='$id'";
	
	$query = mysqli_query($dbc, $sql);
	
	if(mysqli_num_rows($query)!=1){
		header('Location: index.php');
		exit();
    }
	$error_msg = "";
	if(isset($_POST['submit'])){
		$email = $_POST['email'];
		$name = $_POST['name'];
		$comment = $_POST['comment'];
		if($email && $name && $comment){
			//
			$email = $dbc->real_escape_string($email);
			$name = $dbc->real_escape_string($name);
			$comment = $dbc->real_escape_string($comment);
			$id = $dbc->real_escape_string($id);
			if($addComment = $dbc->prepare("INSERT INTO comments (post_id, name, email_add, comment) VALUES (?,?,?,?)")){
				$addComment->bind_param('ssss', $id, $name, $email, $comment);
				$addComment->execute();
				$error_msg = "Thank you for your comment";
				$addComment->close();
			}
		}else {
			$error_msg = "All fields are required!";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="css/blog.css">
</head>
<style>
	#container {
		margin: auto;
		width: 800px;
		padding: 5px;
	}
	label {
		display: block; 
	}
	.backGroundImage {
		background-image: url("images/comp3.jpg");
		background-size: cover;
		background-repeat: no-repeat;
	}
	#error_msg {
		color: red;
	}
</style>
<body>

	<div class="backGroundImage">
	
		<div id="container">
	
		<h1>Full Article</h1>
	
	<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="contact.php">Contact me</a></li>
			</ul>
	</div>
		
		<div id="post">
			<?php 
				$row = $query->fetch_object();
				echo "<h2>".$row->title."</h2>";
				echo "<p>".$row->body."</p>";
			?>
		</div>
		<hr />
		<div id="add_comment">
			<form action="<?php echo $_SERVER['PHP_SELF']."?id=$id"?>" method="post">
				<div>
					<label>Email Address</label><input type="email" name="email" />
				</div>
				<div>
					<label>Name</label><input type="text" name="name" />
				</div>
				<div>
					<label>Comment</label><textarea name="comment" maxlength="200"></textarea>
				</div>
					<input type="submit" name="submit" value="Submit" />
			</form>
			</div>
			<br />
			<div id="error_msg">  
			<?php echo $error_msg; ?>
			</div>
				<hr />
			<div id="comments">
			<?php 
				$query = $dbc->query("SELECT * FROM comments WHERE post_id='$id' ORDER BY comment_id DESC");
				while($row = $query->fetch_object()):
			?>
			<div>
				<h5><?php  $row->name ?></h5>
				<blockquote><?php  $row->comment ?></blockquote>
			</div>
				<?php endwhile; ?>
			</div>
		</div>
	</div> <!-- End of background image div -->
</body>
</html>