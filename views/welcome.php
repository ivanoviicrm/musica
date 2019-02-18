<?php
	
?>
<html>
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
		<h1>Logueado como: <?php echo $_SESSION['email_usuario']; ?></h1> 

		<?php require_once 'views/nav.php'?>
		
   </body>
   
</html>