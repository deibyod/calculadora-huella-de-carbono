<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" ) { // Si no ha iniciado sesión
	header('location:index.php'); // Redirigimos
/***************** Gestionar ******************/
} else if( $_GET['m']=="gestionar" ) { 
	if ( permisos(1) || permisos(2) ) { //Comprobamos que tenga permisos ?>
		<h2>Gestionar organizaciones</h2>
		<?php 
		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM organizaciones");
		// Listado de resultados
		$conteo = mysql_num_rows($consulta);
		if ( $conteo != 0 ) {
			while ($resultado = mysql_fetch_array($consulta)) {
			echo '<div class="listado">
				<div class="resultadolistado">'.$resultado['nombre_org'].'</div>'; ?>
				<div class="botoneslistado">
					<?php if ( permisos(2) ) { //Comprobamos que tenga permisos ?>
					<form name="organizaciones_ver" method="post" action="organizaciones.php" onsubmit="return confirm('¿Estas seguro(a) de eliminar esta organizaci&oacute;n? No se notificar&aacute; a su administrador(a).');">
						<input type="hidden" id="eliminar_id_gestor" name="eliminar_id_gestor" value="<?php echo $resultado['ideorg_org']; ?>">
						<input type="submit" value="Eliminar" class="eliminar">
					</form>
					<?php }	?>
				</div>
			</div>
			<?php }
		} else {
			echo 'No hay organizaciones registradas.';
		} 
	} else {
		echo $error_acceso_no_autorizado;
	}
/***************** Buscar ******************/
} else if( $_GET['m']=="buscar" ) { ?>
	
	<h2>Buscar organizaci&oacute;n</h2>
	<!-- Formulario -->
	<input type="text" id="busqueda" />
	<div id="resultado"></div>
<?php
/***************** Registrar ******************/
} else if( $_GET['m']=="registrar" ) { ?>
	
	<h2>Registrar organizaci&oacute;n</h2>
	<!-- Formulario -->
	<form name="organizaciones" method="post" action="organizaciones.php">
		<p>Los campos con * son obligatorios</p>
		<fieldset>
			<div>
				<label for="nombre_organizacion" title="Escribe un t&iacute;tulo descriptivo y corto">Nombre de la organizaci&oacute;n*: </label>
				<input type="text" id="nombre_organizacion" name="nombre_organizacion" size="40" maxlength="50" required data-validation="required length custom" data-validation-length="3-50" data-validation-regexp="^([A-Za-z&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$">
			</div>
		</fieldset>
		<input type="submit" value="Registrar">
	</form>
<?php
/***************** Guardar registro ******************/
} else if( isset($_POST['nombre_organizacion']) ) { // Si se ha definido el dato 

	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$nombre_organizacion = $_POST['nombre_organizacion'];
	$id_usuario = $_SESSION['id_usuario'];
	// Insertamos los datos
	$inserta = mysql_query("INSERT INTO organizaciones (nombre_org) VALUES ('$nombre_organizacion')",$conexion) or die (mysql_error());
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM organizaciones WHERE nombre_org='$nombre_organizacion'");
	while ($resultado = mysql_fetch_array($consulta)) { 
		$codigo_organizacion = $resultado["ideorg_org"];
	}
	// Insertamos los datos
	$inserta = mysql_query("INSERT INTO rel_individuo_organizacion (codind_rio,ideorg_rio,estado_rio,admini_rio) VALUES ('$id_usuario','$codigo_organizacion','Aprobado','1')",$conexion) or die (mysql_error());
	header('location:organizaciones.php'); // Redirigimos
/***************** Modificar ******************/
} else if( isset($_POST['modificar_id']) ) {
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$modificar_id = $_POST['modificar_id'];
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM organizaciones WHERE ideorg_org='$modificar_id'");
	while ($resultado = mysql_fetch_array($consulta)) { 
		$actualizar_nombre = $resultado["nombre_org"];
	}
	?>
	<h2>Modificar organizaci&oacute;n</h2>
	<!-- Formulario -->
	<form name="organizaciones_modificar" method="post" action="organizaciones.php">
		<p>Los campos con * son obligatorios</p>
		<fieldset>
			<div>
				<input type="hidden" id="actualizar_id" name="actualizar_id" value="<?php echo $modificar_id; ?>">
				<label for="actualizar_nombre" title="Escribe un t&iacute;tulo descriptivo y corto">Nombre de la organizaci&oacute;n*: </label>
				<input type="text" id="actualizar_nombre" name="actualizar_nombre" size="40" maxlength="50" required data-validation="required length custom" data-validation-length="3-50" data-validation-regexp="^([A-Za-z&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$" value="<?php echo $actualizar_nombre; ?>">
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
	// Hacemos la consulta
	$actualiza = mysql_query("UPDATE organizaciones SET nombre_org='$actualizar_nombre' WHERE ideorg_org='$actualizar_id'",$conexion) or die (mysql_error());
	header('location:organizaciones.php'); // Redirigimos
/***************** Vincular ******************/
} else if( isset($_POST['vincular_id']) ) { 
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$id_usuario = $_SESSION['id_usuario'];
	$vincular_id = $_POST['vincular_id'];
	// Hacemos la consulta
	$inserta = mysql_query("INSERT INTO rel_individuo_organizacion (codind_rio,ideorg_rio,estado_rio) VALUES ('$id_usuario','$vincular_id','Pendiente')",$conexion) or die (mysql_error());
	echo '<script type="text/javascript">alert("Tu solicitud para vincularte ha sido enviada.");
		window.location ="organizaciones.php";</script>'; // Indicamos el error y redirigimos
/***************** Solicitudes ******************/
} else if( isset($_POST['solicitudes_id']) ) { ?>
	
	<h2>Solicitudes de vinculaci&oacute;n</h2>
	<?php
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$id_usuario = $_SESSION['id_usuario'];
	$solicitudes_id = $_POST['solicitudes_id'];
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM rel_individuo_organizacion INNER JOIN individuos ON codind_rio=codind_ind WHERE ideorg_rio='$solicitudes_id'");
	while ($resultado = mysql_fetch_array($consulta)) {
		if ( $resultado['codind_rio'] == $id_usuario &&  $resultado['admini_rio'] == 1 ) {
			$administrador_rio = true;
		}
	}
	if ( $administrador_rio == true ) { 
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM rel_individuo_organizacion INNER JOIN individuos ON codind_rio=codind_ind WHERE ideorg_rio='$solicitudes_id' AND estado_rio='Pendiente'");
		// Listado de resultados
		$conteo = mysql_num_rows($consulta);
		if ( $conteo != 0 ) {
			while ($resultado = mysql_fetch_array($consulta)) {
			echo '<div class="listado">
				<div class="resultadolistado">'.$resultado['nombre_ind'].' '.$resultado['apell1_ind'].' '.$resultado['apell2_ind'].'</div>'; ?>
					<div class="botoneslistado">
						<form name="solicitudes_ver" method="post" action="organizaciones.php">
							<input type="hidden" id="individuo_org_id" name="individuo_org_id" value="<?php echo $resultado['ideorg_rio']; ?>">
							<input type="hidden" id="aprobar_individuo_id" name="aprobar_individuo_id" value="<?php echo $resultado['codind_ind']; ?>">
							<input type="submit" value="Aprobar">
						</form>
						<form name="solicitudes_ver" method="post" action="organizaciones.php">
							<input type="hidden" id="individuo_org_id" name="individuo_org_id" value="<?php echo $resultado['ideorg_rio']; ?>">
							<input type="hidden" id="rechazar_individio_id" name="rechazar_individio_id" value="<?php echo $resultado['codind_ind']; ?>">
							<input type="submit" value="Rechazar">
						</form>
					</div>
				<?php echo '</div>';
			}
		} else {
			echo 'No hay solicitudes de vinculaci&oacute;n a la organizaci&oacute;n';
		} 
	}
/***************** Nombrar administrador de organizacion ******************/
} else if( isset($_POST['aprobar_individuo_id']) || isset($_POST['rechazar_individio_id']) ) { 

	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$individuo_org_id = $_POST['individuo_org_id'];
	if ( isset($_POST['aprobar_individuo_id']) ) {
		// Recibimos los datos
		$aprobar_individuo_id = $_POST['aprobar_individuo_id'];
		// Hacemos la consulta
		$actualiza = mysql_query("UPDATE rel_individuo_organizacion SET estado_rio='Aprobado' WHERE codind_rio='$aprobar_individuo_id' AND ideorg_rio='$individuo_org_id'",$conexion) or die (mysql_error());
	}elseif ( isset($_POST['rechazar_individio_id']) ) {
		// Recibimos los datos
		$rechazar_individio_id = $_POST['rechazar_individio_id'];
		// Hacemos la consulta
		$elimina = mysql_query("DELETE FROM rel_individuo_organizacion WHERE codind_rio='$rechazar_individio_id' AND ideorg_rio='$individuo_org_id'");
	}
	header('location:organizaciones.php'); // Redirigimos
/***************** Personas Vinculadas ******************/
} else if( isset($_POST['vinculados_id']) ) { 
	
	?>
	<h2>Personas v&iacute;nculadas</h2>
	<?php
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$id_usuario = $_SESSION['id_usuario'];
	$vinculados_id = $_POST['vinculados_id'];
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM rel_individuo_organizacion INNER JOIN individuos ON codind_rio=codind_ind WHERE ideorg_rio='$vinculados_id'");
	while ($resultado = mysql_fetch_array($consulta)) {
		if ( $resultado['codind_rio'] == $id_usuario &&  $resultado['admini_rio'] == 1 ) {
			$administrador_rio = true;
		}
	}
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM rel_individuo_organizacion INNER JOIN individuos ON codind_rio=codind_ind WHERE ideorg_rio='$vinculados_id' AND estado_rio='Aprobado'");
	// Listado de resultados
	$conteo = mysql_num_rows($consulta);
	if ( $conteo != 0 ) {
		while ($resultado = mysql_fetch_array($consulta)) {
		echo '<div class="listado">
			<div class="resultadolistado">'.$resultado['nombre_ind'].' '.$resultado['apell1_ind'].' '.$resultado['apell2_ind'];
			if ( $resultado['codind_rio'] == $id_usuario ) {
				echo ' <b>(T&uacute;)</b>';
			}
			echo'</div>'; 
			if ( $administrador_rio == true && $resultado['codind_rio'] != $id_usuario &&  $resultado['admini_rio']!=1 ) { ?>
				<div class="botoneslistado">
					<form name="vinculados_ver" method="post" action="organizaciones.php">
						<input type="hidden" id="nombraradmin_individuo_id" name="nombraradmin_individuo_id" value="<?php echo $resultado['codind_ind']; ?>">
						<input type="hidden" id="nombraradmin_organizacion_id" name="nombraradmin_organizacion_id" value="<?php echo $vinculados_id; ?>">
						<input type="submit" value="Nombrar administrador">
					</form>
				</div>
			<?php }
			echo '</div>';
		}
	} else {
		echo 'No hay personas vinculadas a la organizaci&oacute;n';
	} 
/***************** Nombrar administrador de organizacion ******************/
} else if( isset($_POST['nombraradmin_individuo_id']) && isset($_POST['nombraradmin_organizacion_id']) ) { 

	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$nombraradmin_individuo_id = $_POST['nombraradmin_individuo_id'];
	$nombraradmin_organizacion_id = $_POST['nombraradmin_organizacion_id'];
	// Hacemos la consulta
	$actualiza = mysql_query("UPDATE rel_individuo_organizacion SET admini_rio='1' WHERE codind_rio='$nombraradmin_individuo_id' AND ideorg_rio='$nombraradmin_organizacion_id'",$conexion) or die (mysql_error());
	header('location:organizaciones.php'); // Redirigimos
/***************** Desvincular ******************/
} else if( isset($_POST['desvincular_id']) ) { 
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$id_usuario = $_SESSION['id_usuario'];
	$desvincular_id = $_POST['desvincular_id'];
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM rel_individuo_organizacion WHERE ideorg_rio='$desvincular_id' AND codind_rio='$id_usuario' AND admini_rio='1'");
	$conteo = mysql_num_rows($consulta);
	if ( $conteo == 1 ) {
		echo '<script type="text/javascript">alert("Error. No puedes desvincularte de una organizac&oacute;n que solo tu administras.");
		window.location ="organizaciones.php";</script>'; // Indicamos el error y redirigimos
	} else {
		// Hacemos la consulta
		$elimina = mysql_query("DELETE FROM rel_individuo_organizacion WHERE codind_rio='$id_usuario' AND ideorg_rio='$desvincular_id'");
		header('location:organizaciones.php'); // Redirigimos
	}
/***************** Eliminar ******************/
} else if( isset($_POST['eliminar_id']) ) { 
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$id_usuario = $_SESSION['id_usuario'];
	$eliminar_id = $_POST['eliminar_id'];
	// Hacemos la consulta
	$elimina = mysql_query("DELETE FROM rel_individuo_organizacion WHERE codind_rio='$id_usuario' AND ideorg_rio='$eliminar_id'");
	$elimina = mysql_query("DELETE FROM organizaciones WHERE ideorg_org='$eliminar_id'");
	header('location:organizaciones.php'); // Redirigimos
	?>
<?php
/***************** Eliminar (Gestion) ******************/
} else if( isset($_POST['eliminar_id_gestor']) ) { 
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$eliminar_id = $_POST['eliminar_id_gestor'];
	// Hacemos la consulta
	$elimina = mysql_query("DELETE FROM rel_individuo_organizacion WHERE ideorg_rio='$eliminar_id'");
	$elimina = mysql_query("DELETE FROM organizaciones WHERE ideorg_org='$eliminar_id'");
	echo '<script type="text/javascript">window.location = "organizaciones.php?m=gestionar";</script>'; // Redirigimos
	?>
<?php
/***************** Menú ******************/
} else { ?>

	<h2>Organizaciones</h2>
	<ul class="menu_interno">
		<li><a href="organizaciones.php?m=buscar" class="ver">Buscar organizaci&oacute;nes</a></li>
		<li><a href="organizaciones.php?m=registrar" class="registrar">Registrar organizaci&oacute;n</a></li>
	</ul>

	<?php 
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$id_usuario = $_SESSION['id_usuario'];
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM organizaciones INNER JOIN rel_individuo_organizacion ON ideorg_rio=ideorg_org WHERE codind_rio='$id_usuario'");
	// Listado de resultados
	$conteo = mysql_num_rows($consulta);
	if ( $conteo != 0 ) {
		while ($resultado = mysql_fetch_array($consulta)) {
		echo '<div class="listado">
			<div class="resultadolistado">'.$resultado['nombre_org'].'</div>'; ?>
			<div class="botoneslistado">
				<form name="organizaciones_ver" method="get" action="huella_organizacion.php">
					<input type="hidden" id="o" name="o" value="<?php echo $resultado['ideorg_org']; ?>">
					<input type="submit" value="Huella">
				</form>
				<?php if ( $resultado['estado_rio'] == "Aprobado" ) { ?>
				<form name="organizaciones_ver" method="post" action="organizaciones.php">
					<input type="hidden" id="vinculados_id" name="vinculados_id" value="<?php echo $resultado['ideorg_org']; ?>">
					<input type="submit" value="Personas vinculadas">
				</form>
				<?php }else{echo ' (Pendiente) ';} ?>
				<form name="organizaciones_ver" method="post" action="organizaciones.php" onsubmit="return confirm('¿Estas seguro(a) de desvincularte?');">
					<input type="hidden" id="desvincular_id" name="desvincular_id" value="<?php echo $resultado['ideorg_org']; ?>">
					<input type="submit" value="Desvincularme">
				</form>
				<?php
				if ( $resultado['admini_rio'] == "1" ) { ?>
					<form name="organizaciones_ver" method="post" action="organizaciones.php">
						<input type="hidden" id="solicitudes_id" name="solicitudes_id" value="<?php echo $resultado['ideorg_org']; ?>">
						<input type="submit" value="Solicitudes">
					</form>
					<form name="organizaciones_ver" method="post" action="organizaciones.php">
						<input type="hidden" id="modificar_id" name="modificar_id" value="<?php echo $resultado['ideorg_org']; ?>">
						<input type="submit" value="Modificar">
					</form>
					<form name="organizaciones_ver" method="post" action="organizaciones.php" onsubmit="return confirm('¿Estas seguro(a) de eliminar la organizaci&oacute;n?');">
						<input type="hidden" id="eliminar_id" name="eliminar_id" value="<?php echo $resultado['ideorg_org']; ?>">
						<input type="submit" value="Eliminar" class="eliminar">
					</form>
				<?php } ?>
			</div>
		</div>
		<?php }
	} else {
		echo 'No estas v&iacute;nculado(a) a ninguna organizaci&oacute;n';
	} 
}
include('elementos/pie.php'); // Incluimos el pie
?>
