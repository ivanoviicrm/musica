<?php

function obtenerTodasLasFacturas($db) {
	$facturas = [];

	$sql = "SELECT * FROM Invoice WHERE CustomerId=".$_SESSION['id_usuario'];
	// var_dump($sql);
	if ($resultado = mysqli_query($db, $sql)) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$facturas[] = $row;
		}
	}
	
	return $facturas;
}

?>