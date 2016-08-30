<?php 
	include('includes/db_connect.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Category List</title>
		<link rel="stylesheet" type="text/css" href="css/blog.css">
		<style>
		.backGroundImage {
			background-image: url("images/comp3.jpg");
			background-size: cover;
			background-repeat: no-repeat;
		}
</style>
	</head>
	<body>
		
		<div class="backGroundImage">
		
		<div id="container">
			<h1>Web Development Blog</h1>
			
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="contact.php">Contact me</a></li>
			</ul>
		</div>
		
			<div><h2>List of Categories</h2></div>
		
		<?php 
			
			$query = "SELECT category, GROUP_CONCAT(DISTINCT title SEPARATOR ', ') titles
			FROM categories, posts
			WHERE categories.category_id = posts.category_id
			GROUP BY category";
			
			$result = mysqli_query($dbc, $query)
				or die('Error querying database.');
				
			while ($row = mysqli_fetch_array($result)){
				echo "<h2>".$row['category']."</h2>";
				echo $row['titles']."<br />";
				echo "<hr />";
			}
			
		?>
		</div>
		
		</div> <!-- End of background image div -->
	</body>
</html>