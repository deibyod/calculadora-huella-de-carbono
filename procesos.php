<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" ) { // Si no ha iniciado sesión
	header('location:index.php'); // Redirigimos
/***************** Ver ******************/
} else {
	if ( permisos(41) || permisos(42) || permisos(43) || permisos(44) ) { //Comprobamos que tenga permisos ?>
		<h2>Procesos</h2>
		<?php 
		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM procesos");
		// Listado de resultados
		?>
		<div class="tabulado">
			<table>
				<tr>
					<th>C&oacute;digo</th>
					<th>Nombre</th>
				</tr>
			<?php
			while ($resultado = mysql_fetch_array($consulta)) { ?>
				<tr>
					<td><?php echo $resultado['codprc_prc']; ?></td>
					<td><?php echo $resultado['nombre_prc']; ?></td>
				</tr>
			<?php } ?>
			</table>
		</div>
		<div id="menunavegacion"><ul><li><a href="micuenta.php" id="atras"><?php echo $atras; ?></a></li></ul></div>
<?php } else{
		echo $error_acceso_no_autorizado;
	}
}
include('elementos/pie.php'); // Incluimos el pie
?>
