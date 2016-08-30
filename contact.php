<?php 
$action = isset($_POST['action']) ? $_POST['action'] : '';
$error_msg = ""; 
if ($action=="")     
    { 
    ?> 
    
    <?php 
    }  
else                
    { 
    $name=$_REQUEST['name']; 
    $email=$_REQUEST['email']; 
    $message=$_REQUEST['message']; 
    if (($name=="")||($email=="")||($message=="")) 
        { 
		$error_msg = "All fields are required, please fill <a href=\"\">the form</a> again."; 
        } 
    else{         
        $from="From: $name<$email>\r\nReturn-path: $email"; 
        $subject="Message sent using your contact form"; 
        mail("pajohack@gmail.com", $subject, $message, $from); 
        echo "Email sent!"; 
        } 
    }   
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
		#error_msg {
			color: red;
		}
	</style>
	</head>
	<body>
		<div class="backGroundImage">
			<div id="container">
			
			<h1>Contact Me</h1>
	
			<form  action="" method="POST" enctype="multipart/form-data"> 
				<input type="hidden" name="action" value="submit"> 
				Your name:<br> 
				<input name="name" type="text" value="" size="30"/><br> 
				Your email:<br> 
				<input name="email" type="email" value="" size="30"/><br> 
				Your message:<br> 
				<textarea name="message" rows="7" cols="30"></textarea><br> 
				<input type="submit" value="Send email"/> 
			</form> 
				<div id="error_msg">  
					<?php echo $error_msg; ?>
				</div>
				<br />
				<div><a href="index.php">Cancel</a></div>
			</div>
		</div>
	</body>
</html>

