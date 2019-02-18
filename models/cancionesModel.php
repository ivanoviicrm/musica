<?php

function obtenerTodasLasCanciones($db) {
	$canciones = array();
	
	// Como son 3k de canciones saco las 20 primeras para el ejercicio
	$sql = "SELECT Name FROM Track LIMIT 20";
	
	if ($resultado = mysqli_query($db, $sql)) {
		while($row = mysqli_fetch_assoc($resultado)) {
			$canciones[] = $row;
		}
	} else {
		die('cancionesModel -> NO SE PUDO OBTENER LA LISTA DE CANCIONES DE LA BBDDD');
	}
	
	return $canciones;
}

// Funcion que insetara en la BDD el epdido
// Recibe un array con el nombre de las canciones
function comprarCanciones($db, $canciones) {
	// var_dump($canciones);
	// var_dump($_SESSION);
	$infoSongs = [];
	
	// Obtengo todos los datos de las canciones para hacer los inserts
	foreach ($canciones as $cancion) {
		$sql = "SELECT * FROM Track WHERE Name = '$cancion'";
		if ($resultado = mysqli_query($db,$sql)) {
			while($row = mysqli_fetch_assoc($resultado)) {
				$infoSongs[] = $row;
			}
		}
	}
	/*
	array (size=9)
      'TrackId' => string '4' (length=1)
      'Name' => string 'Restless and Wild' (length=17)
      'AlbumId' => string '3' (length=1)
      'MediaTypeId' => string '2' (length=1)
      'GenreId' => string '1' (length=1)
      'Composer' => string 'F. Baltes, R.A. Smith-Diesel, S. Kaufman, U. Dirkscneider & W. Hoffman' (length=70)
      'Milliseconds' => string '252051' (length=6)
      'Bytes' => string '4331779' (length=7)
      'UnitPrice' => string '0.99' (length=4)
	*/
	
	// var_dump($infoSongs);
	
	// Obtengo el Id para un nuevo InvoiceId (que suare mas abajo)
	$InvoiceId = obtenerIdUltimoInvoice($db);
	// var_dump($InvoiceId);
	
	$total = 0;
	// Consigo el total (cuantia) del pedido (para el invoice)
	foreach ($infoSongs as $song) {
		$total += $song['UnitPrice'];
	}
	// var_dump($total);

	// Hago un insert en Invoice
	if (insertarInvoice($db, $InvoiceId, $total)) {
		// Por cada cancion hago un insert en InvoiceLine
		foreach ($infoSongs as $song) {
			// Si falla el insert de invoiceLine
			if (!insertarInvoiceLine($db, $song, $InvoiceId)) {
				mysqli_rollback($db);
			}
		}
		
	// Si falla el insert de invoice
	} else {
		mysqli_rollback($db);
	}
	
	
}

function obtenerIdUltimoInvoice($db) {
	$id = false;
	
	$sql = "SELECT max(InvoiceId) FROM Invoice;";
	if ($resultado = mysqli_query($db, $sql)) {
		if ($row = mysqli_fetch_assoc($resultado)) {
			$id = $row['max(InvoiceId)'];
		}
	}

	return $id + 1;
}

function obtenerIdUltimoInvoiceLine($db) {
	$id = false;
	
	$sql = "SELECT max(InvoiceLineId) FROM InvoiceLine;";
	if ($resultado = mysqli_query($db, $sql)) {
		if ($row = mysqli_fetch_assoc($resultado)) {
			$id = $row['max(InvoiceLineId)'];
		}
	}

	return $id + 1;
}

function insertarInvoiceLine($db, $song, $InvoiceId) {
	$valido = true;
	$InvoiceLineId = obtenerIdUltimoInvoiceLine($db);
	$TrackId = $song['TrackId'];
	$UnitPrice =  $song['UnitPrice'];
	$sql = "INSERT INTO InvoiceLine (InvoiceLineId, InvoiceId, TrackId, UnitPrice, Quantity)"
	. "VALUES($InvoiceLineId, $InvoiceId, $TrackId, $UnitPrice, 1)";
	
	if ($resultado = mysqli_query($db, $sql)) {
		echo '<div style="text-align: center; background-color: green; border: 1px solid darkgreen; color: lime; width: 300px; padding: 5px; margin-bottom: 10px;"> Se insert&oacute; correctamente el invoiceLine </div>';
	} else {
		echo '<div style="text-align: center; background-color: darkred; border: 1px solid red; color: white; width: 300px; padding: 5px; margin-bottom: 10px;"> No se pudo insertar INVOICELINE: </div>';
		var_dump($sql);
		$valido = false;
	}
	
	return $valido;
}

function insertarInvoice($db, $InvoiceId, $total) {
	$valido = true;
	$customerId = $_SESSION['id_usuario'];
	$sql = "INSERT INTO Invoice (InvoiceId, CustomerId, InvoiceDate, BillingAddress, BillingCity, BillingCountry, BillingPostalCode, Total) "
	. "VALUES ($InvoiceId, $customerId, NOW(), null, null, null, null, $total)";
	if ($resultado = mysqli_query($db, $sql)) {
		echo '<div style="text-align: center; background-color: green; border: 1px solid darkgreen; color: lime; width: 300px; padding: 5px; margin-bottom: 10px;"> Se insert&oacute; correctamente el invoice </div>';
	} else {
		echo '<div style="text-align: center; background-color: darkred; border: 1px solid red; color: white; width: 300px; padding: 5px; margin-bottom: 10px;"> No se pudo insertar INVOICE: </div>';
		var_dump($sql);
		$valido = false;
	}
	
	return $valido;
}

?>