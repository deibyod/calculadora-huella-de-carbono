<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" ) { // Si no ha iniciado sesión
	header('location:index.php'); // Redirigimos
/***************** Ver ******************/
} else {
	if ( permisos(32) ) { //Comprobamos que tenga permisos ?>
		<h2>Paises</h2>
		<?php 
		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM paises");
		// Listado de resultados
		?>
		<div class="tabulado">
			<table>
				<tr>
					<th>C&oacute;digo ISO</th>
					<th>C&oacute;digo ISO 2</th>
					<th>C&oacute;digo ISO 3</th>
					<th>Prefijo</th>
					<th>Nombre</th>
					<th>Contienente</th>
					<th>Subcontinente</th>
					<th>C&oacute;digo ISO de la moneda</th>
					<th>Nombre de la moneda</th>
				</tr>
			<?php
			while ($resultado = mysql_fetch_array($consulta)) { ?>
				<tr>
					<td><?php echo $resultado['id']; ?></td>
					<td><?php echo $resultado['iso2']; ?></td>
					<td><?php echo $resultado['iso3']; ?></td>
					<td><?php echo $resultado['prefijo']; ?></td>
					<td><?php echo $resultado['nombre']; ?></td>
					<td><?php echo $resultado['continente']; ?></td>
					<td><?php echo $resultado['subcontinente']; ?></td>
					<td><?php echo $resultado['iso_moneda']; ?></td>
					<td><?php echo $resultado['nombre_moneda']; ?></td>
				</tr>
			<?php } ?>
			</table>
		</div>
		<!-- Botón atrás -->
		<div id="menunavegacion"><ul><li><a href="micuenta.php" id="atras"><?php echo $atras; ?></a></li></ul></div>
<?php } else {
		echo $error_acceso_no_autorizado;
	}
}
include('elementos/pie.php'); // Incluimos el pie
?>
