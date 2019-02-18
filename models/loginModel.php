<?php
function loguearse($db, $email, $password) {
	$sql = "SELECT * FROM Customer WHERE Email = '$email' and lastName = '$password'";
	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

	$count = mysqli_num_rows($result);

	if($count == 1) {
		$_SESSION['email_usuario'] = $email;
		$_SESSION['id_usuario'] = $row['CustomerId'];
		
		header("location: index.php?action=welcome");
	}else {
		$error = "Your Login Name or Password is invalid";
	}

}
?>