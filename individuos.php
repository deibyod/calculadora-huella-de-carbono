<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" ) { // Si no ha iniciado sesión
	header('location:index.php'); // Redirigimos
/***************** Asignar/Cambiar Rol ******************/
} else if( isset($_POST['cambiarrol_id']) ) {
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$cambiarrol_id = $_POST['cambiarrol_id'];
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM individuos WHERE codind_ind='$cambiarrol_id'");
	$conteo = mysql_num_rows($consulta);
	while ($resultado = mysql_fetch_array($consulta)) { ?>
	<h2>Asignar/Cambiar Rol</h2>
	<!-- Formulario -->
	<form name="individuorol_cambiar" method="post" action="individuos.php">
		<fieldset>
			<input type="hidden" id="actualizar_id" name="actualizar_id" value="<?php echo $cambiarrol_id; ?>">
			<div class="seguido">
				<label for="listado_roles" title="Selecciona el rol a asignar">Rol: </label>
				<select id="listado_roles" name="listado_roles">
				<?php
					if ( $resultado["codrol_ind"] == null ) {
						echo '<option value="" selected></option>';
					} else {
						echo '<option value=""></option>';
					}
					include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
					// Consulta
					$consultaCampo = mysql_query("SELECT * FROM roles");
					// Listado de opciones
					while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
						if ( $resultadoCampo["codrol_rol"] == $resultado["codrol_ind"] ){
							echo '<option value="'.$resultadoCampo["codrol_rol"].'" selected>'.$resultadoCampo["descri_rol"].'</option>';
						} else {
							echo '<option value="'.$resultadoCampo["codrol_rol"].'">'.$resultadoCampo["descri_rol"].'</option>';
						}
					}
				?>
				</select>
			</div>
		</fieldset>
		<input type="submit" value="Actualizar">
	</form>
<?php }
/***************** Guardar modificación ******************/
} else if( isset($_POST['actualizar_id']) ) {
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$actualizar_id = $_POST['actualizar_id'];

	if ( $_POST['listado_roles'] == "" ) { } else {	$rol = $_POST['listado_roles'];	}
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM individuos WHERE codind_ind='$actualizar_id' AND codrol_ind='0'");
	$conteo = mysql_num_rows($consulta);
	if ( $conteo == 0 ){
		if ( $_POST['listado_roles'] == "" ) { 
			$actualiza = mysql_query("UPDATE individuos SET codrol_ind=NULL WHERE codind_ind='$actualizar_id'",$conexion) or die (mysql_error());
		} else {
			$rol = $_POST['listado_roles'];
			$actualiza = mysql_query("UPDATE individuos SET codrol_ind='$rol' WHERE codind_ind='$actualizar_id'",$conexion) or die (mysql_error());
		}
		header('location:individuos.php'); // Redirigimos
	} else {
		$consulta2 = mysql_query("SELECT * FROM individuos WHERE codrol_ind='0'");
		$conteo2 = mysql_num_rows($consulta2);
		if ( $conteo2 > 1 ){
			if ( $_POST['listado_roles'] == "" ) {
				$actualiza = mysql_query("UPDATE individuos SET codrol_ind=NULL WHERE codind_ind='$actualizar_id'",$conexion) or die (mysql_error());
			} else {
				$rol = $_POST['listado_roles'];	
				$actualiza = mysql_query("UPDATE individuos SET codrol_ind='$rol' WHERE codind_ind='$actualizar_id'",$conexion) or die (mysql_error());
			}
			header('location:individuos.php'); // Redirigimos
		} else {
			echo '<script type="text/javascript">alert("Error! No puedes cambiar el rol del unico Super Administrador del Sistema.");
			window.location ="individuos.php";</script>'; // Notificamos error y redirigimos
		}
	}
/***************** Eliminar ******************/
} else if( isset($_POST['eliminar_id']) ) {
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$eliminar_id = $_POST['eliminar_id'];
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM individuos WHERE codind_ind='$eliminar_id' AND codrol_ind='0'");
	$conteo = mysql_num_rows($consulta);
	if ( $conteo == 0 ){
		$elimina = mysql_query("DELETE FROM individuos WHERE codind_ind='$eliminar_id'") or die (mysql_error());
		header('location:individuos.php'); // Redirigimos
	} else {
		$consulta2 = mysql_query("SELECT * FROM individuos WHERE codrol_ind='0'");
		$conteo2 = mysql_num_rows($consulta2);
		if ( $conteo2 > 1 ){
			$elimina = mysql_query("DELETE FROM individuos WHERE codind_ind='$eliminar_id'") or die (mysql_error());
			header('location:individuos.php'); // Redirigimos
		} else {
			echo '<script type="text/javascript">alert("Error! No puedes eliminar el único Super Administrador del Sistema.");
			window.location ="individuos.php";</script>'; // Notificamos error y redirigimos
		}
	}
/***************** Menú ******************/
} else {
	if ( permisos(33) || permisos(35) || permisos(36) ) { //Comprobamos que tenga permisos ?>
		<h2>Individuos</h2>
		<?php 
		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM individuos ORDER BY codrol_ind DESC");
		// Listado de resultados
		$conteo = mysql_num_rows($consulta);
		if ( $conteo != 0 ) {
			while ($resultado = mysql_fetch_array($consulta)) { ?>
			<div class="listado">
				<div class="resultadolistado">
					<div class="seguido">
						<?php 
						if ($resultado['codind_ind']==$_SESSION['id_usuario']){
							echo '(<b>T&uacute;</b>) ';
						}
						echo $resultado['nomusu_ind']; ?>
					</div>
				</div>
				<div class="resultadolistado">
					<div class="seguido">
						<?php echo $resultado['nombre_ind'].' '.$resultado['apell1_ind'].' '.$resultado['apell2_ind']; ?>
					</div>
				</div>
				<div class="resultadolistado">
					<div class="seguido">
						<?php echo $resultado['ideind_ind']; ?>
					</div>
				</div>
				<div class="resultadolistado">
					<div class="seguido">
						<?php echo $resultado['correo_ind']; ?>
					</div>
				</div>
				<div class="resultadolistado">
					<div class="seguido">
						<?php echo $resultado['fecnac_ind']; ?>
					</div>
				</div>
				<div class="resultadolistado">
					<div class="seguido">
						<?php echo $resultado['idioma_ind']; ?>
					</div>
				</div>
				<div class="resultadolistado">
					<div class="seguido">
						<?php echo $resultado['fecreg_ind']; ?>
					</div>
				</div>
				<div class="resultadolistado">
					<div class="seguido">
						<?php echo $resultado['codrol_ind']; ?>
					</div>
				</div>
				<div class="botoneslistado">
					<?php if ( permisos(36) ) { //Comprobamos que tenga permisos ?>
					<form name="individuos_ver" method="post" action="individuos.php">
						<input type="hidden" id="cambiarrol_id" name="cambiarrol_id" value="<?php echo $resultado['codind_ind']; ?>">
						<input type="submit" value="<?php if ($resultado['codrol_ind']==null){echo 'Asignar rol';}else{echo 'Cambiar rol';} ?>">
					</form>
					<?php }	?>
					<?php if ( permisos(35) && $resultado['codind_ind']!=$_SESSION['id_usuario'] ) { //Comprobamos que tenga permisos ?>
					<form name="individuos_ver" method="post" action="individuos.php" onsubmit="return confirm('&iquest;Estas seguro(a) de eliminar este usuario?');">
						<input type="hidden" id="eliminar_id" name="eliminar_id" value="<?php echo $resultado['codind_ind']; ?>">
						<input type="submit" value="Eliminar" class="eliminar">
					</form>
					<?php }	?>
				</div>
			</div>
			<?php }
		} else {
			echo 'No hay individuos con roles asignados';
		} 
	} else {
		echo $error_acceso_no_autorizado;
		echo '<script type="text/javascript">window.location ="micuenta.php";</script>'; // Notificamos error y redirigimos
	}
}
include('elementos/pie.php'); // Incluimos el pie
?>
