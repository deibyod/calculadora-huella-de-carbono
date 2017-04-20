<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" ) { // Si no ha iniciado sesión
	header('location:index.php'); // Redirigimos
/***************** Registrar ******************/
} else if( $_GET['m']=="registrar" && permisos(25) ) { ?>
	
	<h2>Registrar organizaci&oacute;n fuente</h2>
	<!-- Formulario -->
	<form name="organizaciones_fuente" method="post" action="organizaciones_fuente.php">
		<p>Los campos con * son obligatorios</p>
		<fieldset>
			<div>
				<label for="nombre_organizacionfuente" title="Escribe el nombre de la organizaci&oacute;n fuente">Nombre de la organizaci&oacute;n*: </label>
				<input type="text" id="nombre_organizacionfuente" name="nombre_organizacionfuente" size="40" maxlength="200" required data-validation="required length custom" data-validation-length="3-200" data-validation-regexp="^([A-Za-z0-9&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$">
			</div>
			<div>
				<label for="ubicacion" title="Escribe la ubicaci&oacute;n física o virtual principal de la organizaci&oacute;n">Ubicaci&oacute;n*: </label>
				<input type="text" id="ubicacion" name="ubicacion" size="40" maxlength="200" required data-validation="required length" data-validation-length="3-200">
			</div>
			<div>
				<label for="listado_paises" title="Selecciona el pa&iacute;s de origen y/o actividad de la organizaci&oacute;n">Pa&iacute;s*: </label>
				<?php
					include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
					// Consulta
					$consultaCampo = mysql_query("SELECT * FROM paises");
					echo '<select id="listado_paises" name="listado_paises">';
					// Listado de opciones
					while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
						echo '<option value="'.$resultadoCampo["id"].'">'.$resultadoCampo["nombre"].'</option>';
					}
					echo '</select>';
				?>
			</div>
		</fieldset>
		<input type="submit" value="Registrar">
	</form>
<?php
/***************** Guardar registro ******************/
} else if( isset($_POST['nombre_organizacionfuente']) ) { // Si se ha definido el dato 

	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$nombre_organizacionfuente = $_POST['nombre_organizacionfuente'];
	$ubicacion = $_POST['ubicacion'];
	$listado_paises = $_POST['listado_paises'];
	// Hacemos la consulta
	$inserta = mysql_query("INSERT INTO organizaciones_fuente (organi_orf,ubicac_orf,idpais_orf) VALUES ('$nombre_organizacionfuente','$ubicacion','$listado_paises')",$conexion) or die (mysql_error());
	header('location:organizaciones_fuente.php'); // Redirigimos
/***************** Modificar ******************/
} else if( isset($_POST['modificar_id']) && permisos(26) ) { 
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$modificar_id = $_POST['modificar_id'];
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM organizaciones_fuente WHERE ideorf_orf='$modificar_id'");
	while ($resultado = mysql_fetch_array($consulta)) { 
		$actualizar_codigoorganizacionfuente = $resultado["ideorf_orf"];
		$actualizar_nombre = $resultado["organi_orf"];
		$actualizar_ubicacion = $resultado["ubicac_orf"];
		$actualizar_pais = $resultado["idpais_orf"];
	}
	?>
	<h2>Modificar organizaci&oacute;n fuente</h2>
	<!-- Formulario -->
	<form name="organizaciones_fuente_modificar" method="post" action="organizaciones_fuente.php">
		<p>Los campos con * son obligatorios</p>
		<fieldset>
			<input type="hidden" id="actualizar_id" name="actualizar_id" value="<?php echo $modificar_id; ?>">
			<div>
				<label for="actualizar_nombre" title="Escribe el nombre de la organizaci&oacute;n fuente">Nombre de la organizaci&oacute;n*: </label>
				<input type="text" id="actualizar_nombre" name="actualizar_nombre" size="40" maxlength="200" required data-validation="required length custom" data-validation-length="3-200" data-validation-regexp="^([A-Za-z0-9&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$" value="<?php echo $actualizar_nombre; ?>">
			</div>
			<div>
				<label for="ubicacion" title="Escribe la ubicaci&oacute;n física o virtual principal de la organizaci&oacute;n">Ubicaci&oacute;n*: </label>
				<input type="text" id="ubicacion" name="ubicacion" size="40" maxlength="200" required data-validation="required length" data-validation-length="3-200" value="<?php echo $actualizar_ubicacion; ?>">
			</div>
			<div>
				<label for="listado_paises" title="Selecciona el pa&iacute;s de origen y/o actividad de la organizaci&oacute;n">Pa&iacute;s*: </label>
				<?php
					include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
					// Consulta
					$consultaCampo = mysql_query("SELECT * FROM paises");
					echo '<select id="listado_paises" name="listado_paises">';
					// Listado de opciones
					while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
						if ( $resultadoCampo["id"] == $actualizar_pais ){
							echo '<option value="'.$resultadoCampo["id"].'" selected="selected">'.$resultadoCampo["nombre"].'</option>';
						} else {
							echo '<option value="'.$resultadoCampo["id"].'">'.$resultadoCampo["nombre"].'</option>';
						}
					}
					echo '</select>';					
				?>
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
	$actualizar_nombre = $_POST['actualizar_nombre'];
	$actualizar_ubicacion = $_POST["ubicacion"];
	$actualizar_pais = $_POST["listado_paises"];
	// Hacemos la consulta
	$actualiza = mysql_query("UPDATE organizaciones_fuente SET organi_orf='$actualizar_nombre',ubicac_orf='$actualizar_ubicacion',idpais_orf='$actualizar_pais' WHERE ideorf_orf='$actualizar_id'",$conexion) or die (mysql_error());
	header('location:organizaciones_fuente.php'); // Redirigimos
/***************** Eliminar ******************/
} else if( isset($_POST['eliminar_id']) && permisos(27) ) { 
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$eliminar_id = $_POST['eliminar_id'];
	// Hacemos la consulta
	$elimina = mysql_query("DELETE FROM organizaciones_fuente WHERE ideorf_orf='$eliminar_id'") or die("<script type='text/javascript'>alert('Error! No puedes eliminar una organización fuente que esta siendo usada'); window.location ='organizaciones_fuente.php';</script>");
	header('location:organizaciones_fuente.php'); // Redirigimos
/***************** Menú ******************/
} else { 
	if ( permisos(19) || permisos(20) || permisos(21) || permisos(22) || permisos(23) || permisos(24) || permisos(25) || permisos(26) || permisos(27) ) { //Comprobamos que tenga permisos ?>
		<h2>Organizaciones fuente</h2>
		<ul class="menu_interno">
			<?php if (permisos(25)) { //Comprobamos que tenga permisos ?>
			<li><a href="organizaciones_fuente.php?m=registrar" class="registrar">Registrar organizaci&oacute;n fuente</a></li>
			<?php }	?>
		</ul>
		<?php 
		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM organizaciones_fuente INNER JOIN paises ON organizaciones_fuente.idpais_orf = paises.id");
		// Listado de resultados
		$conteo = mysql_num_rows($consulta);
		if ( $conteo != 0 ) {
			while ($resultado = mysql_fetch_array($consulta)) {
			echo '<div class="listado"><div class="resultadolistado">'.$resultado['organi_orf'].'</div>
				<div class="resultadolistado">'.$resultado['ubicac_orf'].'</div>
				<div class="resultadolistado">'.$resultado['nombre'].'</div>'; ?>
				<div class="botoneslistado">
					<?php if (permisos(26)) { //Comprobamos que tenga permisos ?>
					<form name="organizaciones_fuente_ver" method="post" action="organizaciones_fuente.php">
						<input type="hidden" id="modificar_id" name="modificar_id" value="<?php echo $resultado['ideorf_orf']; ?>">
						<input type="submit" value="Modificar">
					</form>
					<?php }	?>
					<?php if (permisos(27)) { //Comprobamos que tenga permisos ?>
					<form name="organizaciones_fuente_ver" method="post" action="organizaciones_fuente.php" onsubmit="return confirm('¿Estas seguro(a) de eliminar esta organizaci&oacute;n fuente?');">
						<input type="hidden" id="eliminar_id" name="eliminar_id" value="<?php echo $resultado['ideorf_orf']; ?>">
						<input type="submit" value="Eliminar" class="eliminar">
					</form>
					<?php }	?>
				</div>
			</div>
			<?php }
		} else {
			echo 'No hay organizaciones fuente registradas';
		}
	} else {
		echo $error_acceso_no_autorizado;
	}
}
include('elementos/pie.php'); // Incluimos el pie
?>
