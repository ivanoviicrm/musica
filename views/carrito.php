<?php
if (isset($_COOKIE['carrito'])) {
	$carrito = unserialize($_COOKIE['carrito']);
	
	echo '<table border=1 style="text-align: center; min-width: 300px;">';
	echo '<tr style="background-color: silver;">' .
			'<td> <b>Nombre Canci&oacute;n</b> </td>' .
	'</tr>';
		
	forEach ($carrito as $cancionCookie) {
		echo '<tr>' .
			'<td>' . $cancionCookie . '</td>' .
		'</tr>';
	}
	echo '</table>';

}

?>