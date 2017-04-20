<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" ) { // Si no ha iniciado sesión
	header('location:index.php'); // Redirigimos
/***************** Registrar ******************/
} else if( $_GET['m']=="registrar" && permisos(4) ) { // Si se ha definido el dato ?>
	<!-- Titulo -->
	<h2><?php echo $titulo_registrar_criterio; ?></h2>
	<!-- Formulario -->
	<form name="criterios" method="post" action="criterios.php">
		<!-- Mensaje de campos obligatorios -->
		<p><?php echo $mensaje_campos_obligatorios; ?></p>
		<!-- Grupo de campos del formulario -->
		<fieldset>
			<!-- Campo -->
			<div>
				<label for="nombre_criterio" title="<?php echo $label_nombre_criterio_tooltip; ?>"><?php echo $label_nombre_criterio.$obligatorio; ?>: </label>
				<input type="text" id="nombre_criterio" name="nombre_criterio" size="30" maxlength="40" required data-validation="required length custom" data-validation-length="3-40" data-validation-regexp="^([A-Za-z0-9&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$">
			</div>
			<!-- Campo -->
			<div>
				<label for="imagen_criterio" title="<?php echo $label_imagen_criterio_tooltip; ?>"><?php echo $label_imagen_criterio; ?>: </label>
				<input type="text" id="imagen_criterio" name="imagen_criterio" size="30">
				<button type="button" onclick="javascript:popUp('elementos/subir_imagen.php');">Seleccionar imagen</button>
			</div>
		</fieldset>
		<!-- Botón Submit -->
		<input type="submit" value="<?php echo $registrar; ?>">
	</form>
<?php
/***************** Guardar registro ******************/
} else if( isset($_POST['nombre_criterio']) ) { // Si se ha definido el dato 
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php"); 
	// Recibimos los datos del formulario
	$nombre_criterio = $_POST['nombre_criterio'];
	$imagen_criterio = $_POST['imagen_criterio'];
	// Insertamos los datos en la base de datos
	$inserta = mysql_query("INSERT INTO criterios (nombre_cri, imagen_cri) VALUES ('$nombre_criterio','$imagen_criterio')",$conexion) or die (mysql_error());
	header('location:criterios.php'); // Redirigimos
/***************** Modificar ******************/
} else if( isset($_POST['modificar_id']) && permisos(5) ) { // Si se ha definido el dato y tiene permiso
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php"); 
	// Recibimos los datos del formulario
	$modificar_id = $_POST['modificar_id'];
	// Hacemos la consulta a la base de datos
	$consulta = mysql_query("SELECT * FROM criterios WHERE codcri_cri='$modificar_id'");
	// Recorremos el resultado de la consulta
	while ($resultado = mysql_fetch_array($consulta)) { 
		// Asignamos a variables el valor en cada registro
		$actualizar_codigocriterio = $resultado["codcri_cri"];
		$actualizar_nombre = $resultado["nombre_cri"];
		$actualizar_imagen = $resultado["imagen_cri"];
	}
	?>
	<!-- Titulo -->
	<h2><?php echo $titulo_modificar_criterio; ?></h2>
	<!-- Formulario -->
	<form name="criterios_modificar" method="post" action="criterios.php">
		<!-- Mensaje de campos obligatorios -->
		<p><?php echo $mensaje_campos_obligatorios; ?></p>
		<!-- Grupo de campos del formulario -->
		<fieldset>
			<!-- Datos de uso interno -->
			<input type="hidden" id="actualizar_id" name="actualizar_id" value="<?php echo $modificar_id; ?>">
			<!-- Campo -->
			<div>
				<label for="actualizar_nombre" title="<?php echo $label_nombre_criterio_tooltip; ?>"><?php echo $label_nombre_criterio.$obligatorio; ?>: </label>
				<input type="text" id="actualizar_nombre" name="actualizar_nombre" size="30" maxlength="40" required data-validation="required length custom" data-validation-length="3-40" data-validation-regexp="^([A-Za-z0-9&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$" value="<?php echo $actualizar_nombre; ?>">
			</div>
			<!-- Campo -->
			<div>
				<label for="imagen_criterio" title="<?php echo $label_imagen_criterio_tooltip; ?>"><?php echo $label_imagen_criterio; ?>: </label>
				<input type="text" id="imagen_criterio" name="imagen_criterio" size="30" value="<?php echo $actualizar_imagen; ?>">
				<button type="button" onclick="javascript:popUp('elementos/subir_imagen.php');">Seleccionar imagen</button>
			</div>
		</fieldset>
		<!-- Botón Submit -->
		<input type="submit" value="<?php echo $actualizar; ?>">
	</form>
<?php
/***************** Guardar modificación ******************/
} else if( isset($_POST['actualizar_id']) && isset($_POST['actualizar_nombre']) ) { // Si se ha definido el dato
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php"); 
	// Recibimos los datos del formulario
	$actualizar_id = $_POST['actualizar_id'];
	$actualizar_nombre = $_POST['actualizar_nombre'];
	$imagen_criterio = $_POST['imagen_criterio'];
	// Actualizamos los datos en la base de datos
	$actualiza = mysql_query("UPDATE criterios SET nombre_cri='$actualizar_nombre', imagen_cri='$imagen_criterio' WHERE codcri_cri='$actualizar_id'",$conexion) or die (mysql_error());
	header('location:criterios.php'); // Redirigimos
/***************** Eliminar ******************/
} else if( isset($_POST['eliminar_id']) && permisos(6) ) { // Si se ha definido el dato y tiene permiso
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php"); 
	// Recibimos los datos del formulario
	$eliminar_id = $_POST['eliminar_id'];
	// Eliminamos el registro de la base de datos
	$elimina = mysql_query("DELETE FROM criterios WHERE codcri_cri='$eliminar_id'");
	header('location:criterios.php'); // Redirigimos
	?>
<?php
/***************** Menú / Ver ******************/
} else { 
	if ( permisos(3) || permisos(4) || permisos(5) || permisos(6) || permisos(7) || permisos(8) || permisos(9) || permisos(10) ) { //Comprobamos que tenga permisos ?>
		<!-- Titulo -->
		<h2><?php echo $titulo_criterios; ?></h2>
		<!-- Menú -->
		<ul class="menu_interno">
			<?php if (permisos(4)) { //Comprobamos que tenga permisos ?>
			<li><a href="criterios.php?m=registrar" class="registrar"><?php echo $menu_registrar_criterio; ?></a></li>
			<?php }	?>
		</ul>
		<?php 
		// Incluimos la conexion a la base de datos para la consulta
		include_once("elementos/conexion.php"); 
		// Hacemos la consulta a la base de datos
		$consulta = mysql_query("SELECT * FROM criterios");
		// Contamos los resultados
		$conteo = mysql_num_rows($consulta);
		if ( $conteo != 0 ) { // Si hay resultados
			// Mostramos los resultados
			while ($resultado = mysql_fetch_array($consulta)) {
			echo '
			<div class="listado">
				<div class="resultadolistado">'.$resultado['nombre_cri'].'</div>'; ?>
				<div class="botoneslistado">
					<?php if ( permisos(7) || permisos(8) || permisos(9) || permisos(10) ) { //Comprobamos que tenga permisos ?>
					<!-- Boton ver ayudas -->
					<form name="criterios_ver" method="post" action="ayudas.php">
						<input type="hidden" id="ayudas_id" name="ayudas_id" value="<?php echo $resultado['codcri_cri']; ?>">
						<input type="submit" value="<?php echo $boton_ver_ayudas_de_criterio; ?>">
					</form>
					<?php }	?>
					<?php if (permisos(5)) { //Comprobamos que tenga permisos ?>
					<!-- Boton modificar -->
					<form name="criterios_ver" method="post" action="criterios.php">
						<input type="hidden" id="modificar_id" name="modificar_id" value="<?php echo $resultado['codcri_cri']; ?>">
						<input type="submit" value="<?php echo $modificar; ?>">
					</form>
					<?php }	?>
					<?php if (permisos(6)) { //Comprobamos que tenga permisos ?>
					<!-- Boton eliminar -->
					<form name="criterios_ver" method="post" action="criterios.php" onsubmit="return confirm('<?php echo $alerta_eliminar_ayuda; ?>');">
						<input type="hidden" id="eliminar_id" name="eliminar_id" value="<?php echo $resultado['codcri_cri']; ?>">
						<input type="submit" value="<?php echo $eliminar; ?>" class="eliminar">
					</form>
					<?php }	?>
				</div>
			</div>
			<?php }
		} else { // Si no hay resultados
			echo $criterios_sin_resultado;
		}
	} else {
		echo $error_acceso_no_autorizado;
	}
}
include('elementos/pie.php'); // Incluimos el pie
?>

