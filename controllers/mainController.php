<?php

function login($db) {
	// Cargo el modelo de login
	require_once 'models/loginModel.php';
	// Cargo la vista del fomulario
	require_once 'views/login.php';
	// Si recibo por post algo (esto viene del index.php)
	if (isset($_POST['email']) && !empty($_POST['email']) &&  isset($_POST['password']) && !empty($_POST['password'])) {
		// llamo a la funcion loguarse del modelo
		loguearse($db, $_POST['email'], $_POST['password']);
	}
}

function welcome() {
	// Cargo la vista de welcome
	require_once 'views/welcome.php';
}

function downmusic($db) {
	// Cargo el modelo de canciones
	require_once 'models/cancionesModel.php';
	// Obtengo la lista de canciones (funcion del modelo)
	$todasLasCanciones = obtenerTodasLasCanciones($db);
	// Cargo la vista con las canciones para que el cliente pueda verlas y elegir la que quiera
	require_once 'views/verCanciones.php';
	
	// Si recibo algo por post de este formulario:
	if (isset($_POST['anadir'])) {
		// Si existe la cookie...
		if (isset($_COOKIE['carrito'])) {
			// Obtengo la cookie (array)
			$carrito = unserialize($_COOKIE['carrito']);
			$existencia = false;
			// Recorro el array apra ver si ya tengo esa cancion en el carrito
			for ($i = 0; $i < count($carrito); $i++) {
				if ($carrito[$i] == $_POST['cancion']) { // Si está
					$existencia = true;
				}
			}
			// Si no está la canción
			if (!$existencia) {
				// Agrego la cancion al array
				$carrito[] = $_POST['cancion'];
			}
			// Actualizo la cookie
			setcookie('carrito', serialize($carrito), time() + (86400 * 30), "/");
			
		} else {
			// Array donde guardare las canciones seleccionadas
			$carrito[] = $_POST['cancion'];
			// Creo la cookie
			setcookie('carrito', serialize($carrito), time() + (86400 * 30), "/");
		}
		
		// Actualizo para ver los cambios:
		header('Location:index.php?action=downmusic');
		
	} else if (isset($_POST['limpiar'])) {
		// Limio la cookie (la sobreescribo vacia)
		$carrito = [];
		setcookie('carrito', serialize($carrito), time() + (86400 * 30), "/");
		header('Location:index.php?action=downmusic');
	
	} else if (isset($_POST['comprar'])) {
		comprarCanciones($db, unserialize($_COOKIE['carrito']));
	}
	
	// Muestro el carrito:
	require_once 'views/carrito.php';
}

function histfacturas($db) {
	// Cargo el modelo
	require_once 'models/todasFacturasModel.php';
	// Obtengo todas las facturas del cliente: (funcion dentro de modelo todasFacturasModel.php)
	$facturas = obtenerTodasLasFacturas($db);
	// Cargo la vista
	require_once 'views/facturas.php';
}

function facturas($db) {
	// Cargo el modelo
	require_once 'models/facturasEntreFechasModel.php';
	// Si no he recibido anda por post cargo el formulario
	if (!isset($_POST['fechaDesde']) && !isset($_POST['fechaHasta'])) {
		// Cargo el formulario
		require_once 'views/formularioFechas.php';
	} else {
		// Obtengo todas las facturas del cliente en las fechas estabelcidas: (funcion dentro de modelo facturasEntreFechasModel.php)
		$facturas = obtenerFacturasEntreFechas($db, $_POST['fechaDesde'], $_POST['fechaHasta']);
		// Cargo la vista
		require_once 'views/facturas.php';
	}
}

function logout() {
	// Cierro sesión.
	if (session_destroy()) {
		header('Location: index.php');
	}
}

?>