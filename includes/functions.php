<?php 
//include('db_connect.php');

$dbc = mysqli_connect('localhost', 'root', '', 'blog')
    or die('Error connecting to MySQL server.');

function get_posts($id = null, $cat_id = null){
    $posts = array();
    $query = "SELECT post_id, title, body, posts.category_id, posted
    FROM posts
    INNER JOIN categories ON categories.category_id = posts.category_id";
    if(isset($id)){
        $id = (int)$id;
        $query .= " WHERE `posts`.`post_id` = {$id} ";
             }
    if(isset($cat_id)){
        $cat_id = (int)$cat_id;
        $query .= " WHERE `categories.category_id` = {$cat_id} ";
             }       
    $query .= "ORDER BY `post_id` DESC";
    
    $result = mysqli_query($dbc, $query)
			or die('Error querying database.');
    
    while($row = mysqli_fetch_assoc($result)){
    $posts[] = $row;
   }
   return $posts;
}


?>