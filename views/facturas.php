<?php
// Cargo el nav (menu)
require_once 'views/nav.php';
?>
<table border="1">
	<tr>
		<td>InvoiceId</td>
		<td>CustomerId</td>
		<td>InvoiceDate</td>
		<td>BillingAddress</td>
		<td>BillingCity</td>
		<td>BillingState</td>
		<td>BillingCountry</td>
		<td>BillingPostalCode</td>
		<td>Total</td>
	</tr>
	<?php foreach ($facturas as $factura) : ?>
		<?php echo '<tr><td>' . $factura['InvoiceId'] . '</td>' ?>
		<?php echo '<td>' . $factura['CustomerId'] . '</td>' ?>
		<?php echo '<td>' . $factura['InvoiceDate'] . '</td>' ?>
		<?php echo '<td>' . $factura['BillingAddress'] . '</td>' ?>
		<?php echo '<td>' . $factura['BillingCity'] . '</td>' ?>
		<?php echo '<td>' . $factura['BillingState'] . '</td>' ?>
		<?php echo '<td>' . $factura['BillingCountry'] . '</td>' ?>
		<?php echo '<td>' . $factura['BillingPostalCode'] . '</td>' ?>
		<?php echo '<td>' . $factura['Total'] . '</td></tr>' ?>
	<?php endforeach; ?>
</table>