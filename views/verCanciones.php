<?php require_once 'views/nav.php'; ?>
<form action="" method="POST">
	<div>
		<label for="cancnion">Seleccione canci&oacute;n:</label>
		<select name="cancion">
			<?php foreach ($todasLasCanciones as $cancion) : ?>
				<?php echo '<option>' . $cancion['Name'] . '</option>' ?>				
			<?php endforeach; ?>
		</select>
	</div>
	<div style="margin-top: 10px;">
		<input type="submit" value="A&nacute;adir al Carrito" name="anadir">
		<input type="submit" value="Limpiar el Carrito" name="limpiar">
		<input type="submit" value="Realizar Compra" name="comprar">
	</div>
</form>
