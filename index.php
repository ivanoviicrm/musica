<?php
session_start();

// Hago que si no está logeuado no pueda ver las paginas de mi sitio.
 if (isset($_GET['action'])) {
	require_once 'utils/comprobarSesion.php';
}

// Cargo la BBDDD
require_once 'db/config.php';

// Cargo el controlador (Que tiene las funciones que usare abajo)
require_once 'controllers/mainController.php';

// Cargo la acción que recibo por get en la url
if (!isset($_GET['action'])) {
	login($db); // Por defecto lanzo el login
} else if ($_GET['action'] == 'welcome') {
	welcome();
} else if ($_GET['action'] == 'downmusic') {
	downmusic($db);
} else if ($_GET['action'] == 'histfacturas') {
	histfacturas($db);
} else if ($_GET['action'] == 'facturas') {
	facturas($db);
} else if ($_GET['action'] == 'logout') {
	logout();
}


?>