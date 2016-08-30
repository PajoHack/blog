<?php 
	include('includes/db_connect.php');
	
	$record_count = $dbc->query("SELECT * FROM posts");
	
	$per_page = 3;
	
	$pages = ceil($record_count->num_rows/$per_page);
	
	if(isset($_GET['p']) && is_numeric($_GET['p'])){
		$page = $_GET['p'];
	}else {
		$page = 1;
	}
	if($page <= 0){
		$start = 0;
	}else {
		$start = $page * $per_page - $per_page;
	}
	$prev = $page -1;
	$next = $page +1;
	
	$query = $dbc->prepare("SELECT post_id, title, LEFT(body, 200) AS body, category, posted FROM posts INNER JOIN categories ON categories.category_id=posts.category_id ORDER BY post_id DESC LIMIT $start, $per_page");
	$query->execute();
	$query->bind_result($post_id, $title, $body, $category, $posted);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
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
				<li><a href="category.php">Categories</a></li>
				<li><a href="contact.php">Contact me</a></li>
				<li><a href="admin/admin.php">Admin</a></li>
				<li><a href="admin/logout.php">Logout</a></li>
			</ul>
		</div>
		<span class="welcomePara">
		
			<p class="welcome">
				<img src="images/comp1.jpg" id="mainImage" alt="Web Dev Pic" class="articleImage" />
				Welcome to this web development blog! Here I post my thoughts on web development and encourage you to leave comments on my blog posts. If you want me to add specific categories to discuss please don’t be afraid to use the contact form to get in touch. Enjoy!
			</p>
		</span>
		
		<?php 
			while($query->fetch()) :
			$lastspace = strrpos($body, ' ');
		?>
		
		<article>
			<h2><?php echo $title ?></h2>
			<p><?php echo substr($body, 0, $lastspace)."<a href='article.php?id=$post_id'>.....Read full post</a>" ?></p>
			<p>Category: <?php echo $category ?> :Date Posted <?php echo $posted ?></p>
			<?php
			echo "<div><a href='admin/del_post.php?pid=$post_id'>Delete</a>&nbsp;<a href='admin/edit_post.php?pid=$post_id'>Edit</a></div>";
			echo "<hr />";
			?>
		</article>
		<?php endwhile?>
		<br />
		<div id="pagination">
		<?php 
			if($prev > 0){
				echo "<a href ='index.php?p=$prev'>Prev <--</a>";
			}
			if($page < $pages){
				echo "<a href ='index.php?p=$next'>--> Next</a>";
			}
		?>
		</div>
		
	</div>
	<script src="js/blog.js"></script>
	</div>
	
</body>
</html>