<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" ) { // Si no ha iniciado sesión
	header('location:index.php'); // Redirigimos
/***************** Registrar ******************/
} else if( $_GET['m']=="registrar" && permisos(16) ) { ?>
	<!-- Titulo -->
	<h2>Registrar medida</h2>
	<!-- Formulario -->
	<form name="medidas" method="post" action="medidas.php">
		<!-- Mensaje de campos obligatorios -->
		<p><?php echo $mensaje_campos_obligatorios; ?></p>
		<!-- Grupo de campos del formulario -->
		<fieldset>
			<div>
				<label for="abreviatura_medida" title="Escribe la abreviatura de la unidad de medida">Abreviatura*: </label>
				<input type="text" id="abreviatura_medida" name="abreviatura_medida" size="10" maxlength="15" required data-validation="required length" data-validation-length="1-15">
			</div>
			<div>
				<label for="nombre_medida" title="Escribe el nombre de la unidad de medida">Nombre*: </label>
				<input type="text" id="nombre_medida" name="nombre_medida" size="30" maxlength="40" required data-validation="required length alphanumeric" data-validation-length="3-40" data-validation-allowing="&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ">
			</div>
		</fieldset>
		<input type="submit" value="Registrar">
	</form>
<?php
/***************** Guardar registro ******************/
} else if( isset($_POST['abreviatura_medida']) ) { // Si se ha definido el dato 

	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$abreviatura_medida = $_POST['abreviatura_medida'];
	$nombre_medida = $_POST['nombre_medida'];
	// Hacemos la consulta
	$inserta = mysql_query("INSERT INTO medidas (abrmed_med,nombre_med) VALUES ('$abreviatura_medida','$nombre_medida')",$conexion) or die (mysql_error());
	header('location:medidas.php'); // Redirigimos
/***************** Modificar ******************/
} else if( isset($_POST['modificar_id']) && permisos(17) ) {
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$modificar_id = $_POST['modificar_id'];
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM medidas WHERE abrmed_med='$modificar_id'");
	while ($resultado = mysql_fetch_array($consulta)) { 
		$actualizar_abreviatura = $resultado["abrmed_med"];
		$actualizar_nombre = $resultado["nombre_med"];
	}
	?>
	<h2>Modificar unidad de medida</h2>
	<!-- Formulario -->
	<form name="medidas_modificar" method="post" action="medidas.php">
		<p>Los campos con * son obligatorios</p>
		<fieldset>
			<input type="hidden" id="actualizar_id" name="actualizar_id" value="<?php echo $modificar_id; ?>">
			<div>
				<label for="actualizar_abreviatura" title="Escribe un título descriptivo y corto">Nombre de la organización*: </label>
				<input type="text" id="actualizar_abreviatura" name="actualizar_abreviatura" size="10" maxlength="15" required data-validation="required length" data-validation-length="1-15" value="<?php echo $actualizar_abreviatura; ?>">
			</div>
			<div>
				<label for="actualizar_nombre" title="Escribe un título descriptivo y corto">Nombre de la organización*: </label>
				<input type="text" id="actualizar_nombre" name="actualizar_nombre" size="30" maxlength="40" required data-validation="required length alphanumeric" data-validation-length="3-40" data-validation-allowing="&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; " value="<?php echo $actualizar_nombre; ?>">
			</div>
		</fieldset>
		<input type="submit" value="Actualizar">
	</form>
<?php
/***************** Guardar modificación ******************/
} else if( isset($_POST['actualizar_id']) && isset($_POST['actualizar_nombre']) ) {
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$actualizar_id = $_POST['actualizar_id'];
	$actualizar_abreviatura = $_POST['actualizar_abreviatura'];
	$actualizar_nombre = $_POST['actualizar_nombre'];
	// Hacemos la consulta
	$actualiza = mysql_query("UPDATE medidas SET abrmed_med='$actualizar_abreviatura',nombre_med='$actualizar_nombre' WHERE abrmed_med='$actualizar_id'",$conexion) or die (mysql_error());
	header('location:medidas.php'); // Redirigimos
/***************** Eliminar ******************/
} else if( isset($_POST['eliminar_id']) && permisos(18) ) { 
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$eliminar_id = $_POST['eliminar_id'];
	// Hacemos la consulta
	$elimina = mysql_query("DELETE FROM medidas WHERE abrmed_med='$eliminar_id'");
	header('location:medidas.php'); // Redirigimos
	?>
<?php
/***************** Menú ******************/
} else { 
	if ( permisos(15) || permisos(16) || permisos(17) || permisos(18) ) { //Comprobamos que tenga permisos ?>
		<h2>Unidades de Medida</h2>
		<ul class="menu_interno">
			<?php if (permisos(16)) { //Comprobamos que tenga permisos ?>
			<li><a href="medidas.php?m=registrar" class="registrar">Registrar unidad de medida</a></li>
			<?php }	?>
		</ul>
		<?php 
		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM medidas");
		// Listado de resultados
		$conteo = mysql_num_rows($consulta);
		if ( $conteo != 0 ) {
			while ($resultado = mysql_fetch_array($consulta)) {
			echo '<div class="listado"><div class="resultadolistado">'.$resultado['nombre_med'].' ('.$resultado['abrmed_med'].')</div>'; ?>
				<div class="botoneslistado">
					<?php if (permisos(17)) { //Comprobamos que tenga permisos ?>
					<form name="medidas_ver" method="post" action="medidas.php">
						<input type="hidden" id="modificar_id" name="modificar_id" value="<?php echo $resultado['abrmed_med']; ?>">
						<input type="submit" value="Modificar">
					</form>
					<?php }	?>
					<?php if (permisos(18)) { //Comprobamos que tenga permisos ?>
					<form name="medidas_ver" method="post" action="medidas.php" onsubmit="return confirm('¿Estas seguro(a) de eliminar esta unidad de medida?');">
						<input type="hidden" id="eliminar_id" name="eliminar_id" value="<?php echo $resultado['abrmed_med']; ?>">
						<input type="submit" value="Eliminar" class="eliminar">
					</form>
					<?php }	?>
				</div>
			</div>
			<?php }
		} else {
			echo 'No hay medidas registradas';
		} 
	} else {
		echo $error_acceso_no_autorizado;
	}
}
include('elementos/pie.php'); // Incluimos el pie
?>
