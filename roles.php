<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" ) { // Si no ha iniciado sesión
	header('location:index.php'); // Redirigimos
/***************** Registrar ******************/
} else if( $_GET['m']=="registrar" && permisos(38) ) { ?>
	
	<h2>Registrar rol</h2>
	<!-- Formulario -->
	<form name="roles" method="post" action="roles.php">
		<p>Los campos con * son obligatorios</p>
		<fieldset>
			<div>
				<label for="descripcion_rol" title="Escribe un nombre para el rol descriptivo y corto">Descripci&oacute;n del rol*: </label>
				<input type="text" id="descripcion_rol" name="descripcion_rol" size="40" maxlength="50" required data-validation="required length custom" data-validation-length="3-50" data-validation-regexp="^([A-Za-z&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$">
			</div>
		</fieldset>
		<input type="submit" value="Registrar">
	</form>
<?php
/***************** Guardar registro ******************/
} else if( isset($_POST['descripcion_rol']) ) { // Si se ha definido el dato 

	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$descripcion_rol = $_POST['descripcion_rol'];
	// Insertamos los datos
	$inserta = mysql_query("INSERT INTO roles (descri_rol) VALUES ('$descripcion_rol')",$conexion) or die (mysql_error());
	header('location:roles.php'); // Redirigimos
/***************** Permisos ******************/
} else if( isset($_GET['vrol']) && $_GET['vrol']!=0 && (permisos(41) || permisos(42) || permisos(43)) ) { 
	
	?>
	<h2>Permisos</h2>
	<h3>Actuales</h3>
	<?php
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$rolverpermisos_id = $_GET['vrol'];
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM permisos INNER JOIN procesos ON codprc_per=codprc_prc WHERE codrol_per='$rolverpermisos_id'");
	// Listado de resultados
	$conteo = mysql_num_rows($consulta);
	if ( $conteo != 0 ) {
		while ($resultado = mysql_fetch_array($consulta)) {
		echo '<div class="listado">
				<div class="resultadolistado">'.$resultado['nombre_prc'].'</div>'; ?>
				<div class="botoneslistado">
					<?php if (permisos(43)) { //Comprobamos que tenga permisos ?>
					<form name="permisos_ver" method="post" action="roles.php">
						<input type="hidden" id="roleliminarpermiso_id" name="roleliminarpermiso_id" value="<?php echo $rolverpermisos_id; ?>">
						<input type="hidden" id="procesoseliminarpermiso_id" name="procesoseliminarpermiso_id" value="<?php echo $resultado['codprc_per']; ?>">
						<input type="submit" value="Eliminar">
					</form>
					<?php } ?>
				</div>
			</div>
			<?php
		}
	} else {
		echo 'No hay permisos asignados a este rol';
	} 
	?><hr>
	<h3>Disponibles</h3><?php
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM procesos") or die (mysql_error());
	// Listado de resultados
	$conteo = mysql_num_rows($consulta);
	if ( $conteo != 0 ) {
		while ($resultado = mysql_fetch_array($consulta)) {
			$codigo_proceso = $resultado['codprc_prc'];
			$consultaCampo = mysql_query("SELECT * FROM permisos WHERE codrol_per='$rolverpermisos_id' AND codprc_per='$codigo_proceso'") or die (mysql_error());
			$conteoCampo = mysql_num_rows($consultaCampo);
			if ( $conteoCampo == 0 ) {
				echo '<div class="listado">';
					echo '<div class="resultadolistado">'.$resultado['nombre_prc'].'</div>'; ?>
					<div class="botoneslistado">
						<?php if (permisos(42)) { //Comprobamos que tenga permisos ?>
						<form name="permisos_ver" method="post" action="roles.php">
							<input type="hidden" id="rolagregarpermiso_id" name="rolagregarpermiso_id" value="<?php echo $rolverpermisos_id; ?>">
							<input type="hidden" id="procesosagregarpermiso_id" name="procesosagregarpermiso_id" value="<?php echo $resultado['codprc_prc']; ?>">
							<input type="submit" value="Agregar">
						</form>
						<?php } ?>
					</div>
				</div>
			<?php }
		}
	} else {
		echo 'Este rol tiene todos los permisos existentes asignados';
	} 
/***************** Agregar permiso ******************/
} else if( isset($_POST['rolagregarpermiso_id']) && isset($_POST['procesosagregarpermiso_id']) ) { // Si se ha definido el dato 

	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$rolagregarpermiso_id = $_POST['rolagregarpermiso_id'];
	$procesosagregarpermiso_id = $_POST['procesosagregarpermiso_id'];
	// Insertamos los datos
	$inserta = mysql_query("INSERT INTO permisos (codrol_per,codprc_per) VALUES ('$rolagregarpermiso_id','$procesosagregarpermiso_id')",$conexion) or die (mysql_error());
	header('location:roles.php?vrol='.$rolagregarpermiso_id); // Redirigimos
/***************** Eliminar permiso ******************/
} else if( isset($_POST['roleliminarpermiso_id']) && isset($_POST['procesoseliminarpermiso_id']) && permisos(43) ) { // Si se ha definido el dato 

	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$roleliminarpermiso_id = $_POST['roleliminarpermiso_id'];
	$procesoseliminarpermiso_id = $_POST['procesoseliminarpermiso_id'];
	// Eliminamos los datos
	$elimina = mysql_query("DELETE FROM permisos WHERE codrol_per='$roleliminarpermiso_id' AND codprc_per='$procesoseliminarpermiso_id'");
	header('location:roles.php?vrol='.$roleliminarpermiso_id); // Redirigimos
/***************** Modificar ******************/
} else if( isset($_POST['modificar_id']) && permisos(39) ) {
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$modificar_id = $_POST['modificar_id'];
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM roles WHERE codrol_rol='$modificar_id'");
	while ($resultado = mysql_fetch_array($consulta)) { 
		$actualizar_descripcion = $resultado["descri_rol"];
	}
	?>
	<h2>Modificar rol</h2>
	<!-- Formulario -->
	<form name="roles_modificar" method="post" action="roles.php">
		<p>Los campos con * son obligatorios</p>
		<fieldset>
			<div>
				<input type="hidden" id="actualizar_id" name="actualizar_id" value="<?php echo $modificar_id; ?>">
				<label for="actualizar_descripcion" title="Escribe un nombre para el rol descriptivo y corto">Descripci&oacute;n del rol*: </label>
				<input type="text" id="actualizar_descripcion" name="actualizar_descripcion" size="40" maxlength="50" required data-validation="required length custom" data-validation-length="3-50" data-validation-regexp="^([A-Za-z&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$" value="<?php echo $actualizar_descripcion; ?>">
			</div>
		</fieldset>
		<input type="submit" value="Actualizar">
	</form>
<?php
/***************** Guardar modificación ******************/
} else if( isset($_POST['actualizar_id']) && isset($_POST['actualizar_descripcion']) ) {
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$actualizar_id = $_POST['actualizar_id'];
	$actualizar_descripcion = $_POST['actualizar_descripcion'];
	// Hacemos la consulta
	$actualiza = mysql_query("UPDATE roles SET descri_rol='$actualizar_descripcion' WHERE codrol_rol='$actualizar_id'",$conexion) or die (mysql_error());
	header('location:roles.php'); // Redirigimos
/***************** Eliminar ******************/
} else if( isset($_POST['eliminar_id']) && permisos(40) ) { 
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$eliminar_id = $_POST['eliminar_id'];
	// Hacemos la consulta
	$elimina = mysql_query("DELETE FROM roles WHERE codrol_rol='$eliminar_id'");
	header('location:roles.php'); // Redirigimos
	?>
<?php
/***************** Menú ******************/
} else {
	if ( permisos(37) || permisos(38) || permisos(39) || permisos(40) || permisos(41) || permisos(42) || permisos(43) ) { //Comprobamos que tenga permisos ?>
		<h2>Roles</h2>
		<ul class="menu_interno">
			<?php if (permisos(38)) { //Comprobamos que tenga permisos ?>
			<li><a href="roles.php?m=registrar" class="registrar">Registrar rol</a></li>
			<?php } ?>
		</ul>

		<?php 
		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM roles");
		// Listado de resultados
		$conteo = mysql_num_rows($consulta);
		if ( $conteo != 0 ) {
			while ($resultado = mysql_fetch_array($consulta)) {
			echo '<div class="listado">
				<div class="resultadolistado">'.$resultado['descri_rol'].'</div>'; ?>
				<div class="botoneslistado">
					<?php if ((permisos(41) || permisos(42) || permisos(43)) && $resultado['codrol_rol']!=0) { //Comprobamos que tenga permisos ?>
					<form name="roles_ver" method="get" action="roles.php">
						<input type="hidden" id="vrol" name="vrol" value="<?php echo $resultado['codrol_rol']; ?>">
						<input type="submit" value="Ver permisos">
					</form>
					<?php } ?>
					<?php if (permisos(39)) { //Comprobamos que tenga permisos ?>
					<form name="roles_ver" method="post" action="roles.php">
						<input type="hidden" id="modificar_id" name="modificar_id" value="<?php echo $resultado['codrol_rol']; ?>">
						<input type="submit" value="Modificar">
					</form>
					<?php } ?>
					<?php if (permisos(40) && $resultado['codrol_rol']!=0) { //Comprobamos que tenga permisos ?>
					<form name="roles_ver" method="post" action="roles.php" onsubmit="return confirm('&iquest;Estas seguro(a) de eliminar el rol?');">
						<input type="hidden" id="eliminar_id" name="eliminar_id" value="<?php echo $resultado['codrol_rol']; ?>">
						<input type="submit" value="Eliminar" class="eliminar">
					</form>
					<?php } ?>
				</div>
			</div>
			<?php }
		} else {
			echo 'No hay roles registrados';
		} 
	} else{
		echo $error_acceso_no_autorizado;
	}
}
include('elementos/pie.php'); // Incluimos el pie
?>
