<?php
// Miro que esté registrado y logueado
if (!isset($_SESSION['email_usuario'])) {
	header('Location: index.php');
}
?>