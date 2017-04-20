<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" ) { // Si no ha iniciado sesión
	header('location:index.php'); // Redirigimos
/***************** Registrar ******************/
} else if( $_GET['m']=="registrar" && permisos(8) ) { // Si se ha definido el dato ?>
	<!-- Titulo -->
	<h2><?php echo $titulo_registrar_ayuda; ?></h2>
	<?php
	include_once("elementos/conexion.php"); // Incluimos la conexion a la base de datos para la consulta
	// Consulta
	$consultaCampo = mysql_query("SELECT * FROM criterios ORDER BY nombre_cri");
	// Conteo de resultados
	$conteo = mysql_num_rows($consultaCampo);
	if ( $conteo != 0 ) { // Si hay resultados ?>
		<!-- Formulario -->
		<form name="ayudas" method="post" action="ayudas.php">
			<!-- Mensaje de campos obligatorios -->
			<p><?php echo $mensaje_campos_obligatorios; ?></p>
			<!-- Grupo de campos del formulario -->
			<fieldset>
				<!-- Campo -->
				<div>
					<label for="titulo_ayuda" title="<?php echo $label_titulo_ayuda_tooltip; ?>"><?php echo $label_titulo_ayuda.$obligatorio; ?>: </label>
					<input type="text" id="titulo_ayuda" name="titulo_ayuda" size="40" maxlength="80" required data-validation="required length custom" data-validation-length="3-80" data-validation-regexp="^([A-Za-z0-9&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$">
				</div>
				<!-- Campo -->
				<div>
					<label for="listado_criterios" title="<?php echo $label_criterios_ayuda_tooltip; ?>"><?php echo $label_criterios_ayuda.$obligatorio; ?>: </label>
					<select id="listado_criterios" name="listado_criterios">
						<?php
						// Listado de opciones
						while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
							echo '<option value="'.$resultadoCampo["codcri_cri"].'">'.$resultadoCampo["nombre_cri"].'</option>';
						}
						?>
					</select>
				</div>
				<!-- Campo -->
				<div>
					<label for="contenido_ayuda" title="<?php echo $label_contenido_ayuda_tooltip; ?>"><?php echo $label_contenido_ayuda.$obligatorio; ?>: </label>
					<textarea id="contenido_ayuda" name="contenido_ayuda" rows="4" cols="50" required data-validation="required length" data-validation-length="min10"></textarea> 
				</div>
			</fieldset>
			<!-- Botón Submit -->
			<input type="submit" value="<?php echo $registrar; ?>">
		</form>
	<?php
	} else { // Si no hay resultados
		echo $error_registrar_ayuda_sin_criterios;
	}
/***************** Guardar registro ******************/
} else if( isset($_POST['titulo_ayuda']) ) { // Si se ha definido el dato 
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php");
	// Recibimos los datos del formulario
	$titulo_ayuda = $_POST['titulo_ayuda']; 
	$listado_criterios = $_POST['listado_criterios'];
	$contenido_ayuda = $_POST['contenido_ayuda'];
	// Insertamos los datos en la base de datos
	$inserta = mysql_query("INSERT INTO ayudas (titulo_ayu,codcri_ayu,conayu_ayu) VALUES ('$titulo_ayuda','$listado_criterios','$contenido_ayuda')",$conexion) or die (mysql_error());
	header('location:ayudas.php'); // Redirigimos
/***************** Ver ayuda ******************/
} else if( isset($_POST['ver_id']) && permisos(7) ) { // Si se ha definido el dato y tiene permiso
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php");
	// Recibimos los datos del formulario
	$ver_id = $_POST['ver_id'];
	// Hacemos la consulta a la base de datos
	$consulta = mysql_query("SELECT * FROM ayudas WHERE codayu_ayu='$ver_id'");
	// Recorremos el resultado de la consulta
	while ($resultado = mysql_fetch_array($consulta)) { 
		// Asignamos a variables el valor de cada registro
		$titulo = $resultado["titulo_ayu"];
		$codigocriterio = $resultado["codcri_ayu"];
		$contenidoayuda = $resultado["conayu_ayu"];
		// Mostramos los datos
		echo '
		<div class="ayuda">
			<h2>'.$titulo.'</h2>
			<p><b>Criterio</b>'.$codigocriterio.'</p>
			'.$contenidoayuda.'
		</div>';
	} ?>
	<!-- Botones de opciones -->
	<div>
		<div class="botoneslistado">
			<!-- Boton modificar -->
			<form name="ayuda_ver" method="post" action="ayudas.php">
				<input type="hidden" id="modificar_id" name="modificar_id" value="<?php echo $codigocriterio; ?>">
				<input type="submit" value="<?php echo $modificar; ?>">
			</form>
			<!-- Boton eliminar -->
			<form name="ayuda_ver" method="post" action="ayudas.php" onsubmit="return confirm('<?php echo $alerta_eliminar_ayuda; ?>');">
				<input type="hidden" id="eliminar_id" name="eliminar_id" value="<?php echo $codigocriterio; ?>">
				<input type="submit" value="<?php echo $eliminar ?>" class="eliminar">
			</form>
		</div>
	</div>
<?php	
/***************** Modificar ******************/
} else if( isset($_POST['modificar_id']) && permisos(9) ) { // Si se ha definido el dato y tiene permiso
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php");
	// Recibimos los datos del formulario
	$modificar_id = $_POST['modificar_id'];
	// Hacemos la consulta a la base de datos
	$consulta = mysql_query("SELECT * FROM ayudas WHERE codayu_ayu='$modificar_id'");
	// Recorremos el resultado de la consulta
	while ($resultado = mysql_fetch_array($consulta)) { 
		// Asignamos variables al registro
		$actualizar_titulo = $resultado["titulo_ayu"];
		$actualizar_codigocriterio = $resultado["codcri_ayu"];
		$actualizar_contenidoayuda = $resultado["conayu_ayu"];
	}
	?>
	<!-- Titulo -->
	<h2><?php echo $titulo_modificar_ayuda; ?></h2>
	<!-- Formulario -->
	<form name="ayudas_modificar" method="post" action="ayudas.php">
		<!-- Mensaje de campos obligatorios -->
		<p><?php echo $mensaje_campos_obligatorios; ?></p>
		<!-- Grupo de campos del formulario -->
		<fieldset>
			<!-- Datos de uso interno -->
			<input type="hidden" id="actualizar_id" name="actualizar_id" value="<?php echo $modificar_id; ?>">
			<!-- Campo -->
			<div>
				<label for="actualizar_titulo" title="<?php echo $label_titulo_ayuda_tooltip; ?>"><?php echo $label_titulo_ayuda.$obligatorio; ?>: </label>
				<input type="text" id="actualizar_titulo" name="actualizar_titulo" size="40" maxlength="80" required data-validation="required length custom" data-validation-length="3-80" data-validation-regexp="^([A-Za-z0-9&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$" value="<?php echo $actualizar_titulo; ?>">
			</div>
			<!-- Campo -->
			<div>
				<label for="listado_criterios" title="<?php echo $label_criterios_ayuda_tooltip; ?>"><?php echo $label_criterios_ayuda.$obligatorio; ?>: </label>
				<?php
					include_once("elementos/conexion.php"); // Incluimos la conexion a la base de datos para la consulta
					// Consulta
					$consultaCampo = mysql_query("SELECT * FROM criterios ORDER BY nombre_cri");
					echo '<select id="listado_criterios" name="listado_criterios">';
					// Listado de opciones
					while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
						if ( $resultadoCampo["codcri_cri"] == $actualizar_codigocriterio ){
							echo '<option value="'.$resultadoCampo["codcri_cri"].'" selected="selected">'.$resultadoCampo["nombre_cri"].'</option>';
						} else {
							echo '<option value="'.$resultadoCampo["codcri_cri"].'">'.$resultadoCampo["nombre_cri"].'</option>';
						}
					}
					echo '</select>';
				?>
			</div>
			<!-- Campo -->
			<div>
				<label for="contenido_ayuda" title="<?php echo $label_contenido_ayuda_tooltip; ?>"><?php echo $label_contenido_ayuda.$obligatorio; ?>: </label><br>
				<textarea id="contenido_ayuda" name="contenido_ayuda" rows="4" cols="50" required data-validation="required length" data-validation-length="min10"><?php echo $actualizar_contenidoayuda; ?></textarea> 
			</div>
		</fieldset>
		<!-- Botón Submit -->
		<input type="submit" value="<?php echo $actualizar; ?>">
	</form>
<?php
/***************** Guardar modificación ******************/
} else if( isset($_POST['actualizar_id']) && isset($_POST['actualizar_titulo']) ) { // Si se ha definido el dato
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php"); 
	// Recibimos los datos del formulario
	$actualizar_id = $_POST['actualizar_id'];
	$actualizar_titulo = $_POST['actualizar_titulo'];
	$actualizar_codigocriterio = $_POST['listado_criterios'];
	$actualizar_contenidoayuda = $_POST['contenido_ayuda'];
	// Actualizamos los datos en la base de datos
	$actualiza = mysql_query("UPDATE ayudas SET titulo_ayu='$actualizar_titulo',codcri_ayu='$actualizar_codigocriterio',conayu_ayu='$actualizar_contenidoayuda' WHERE codayu_ayu='$actualizar_id'",$conexion) or die (mysql_error());
	header('location:ayudas.php'); // Redirigimos
/***************** Eliminar ******************/
} else if( isset($_POST['eliminar_id']) && permisos(10) ) { 
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php");
	// Recibimos los datos del formulario
	$eliminar_id = $_POST['eliminar_id'];
	// Eliminamos el registro de la base de datos
	$elimina = mysql_query("DELETE FROM ayudas WHERE codayu_ayu='$eliminar_id'");
	header('location:ayudas.php'); // Redirigimos
	?>
<?php
/***************** Menú ******************/
} else { 
	if ( permisos(10) || permisos(9) || permisos(8) || permisos(7) ) { //Comprobamos que tenga permisos ?>
		<!-- Titulo -->
		<h2><?php echo $titulo_ayudas; ?></h2>
		<!-- Menú -->
		<ul class="menu_interno">
			<?php if ( permisos(8) ) { //Comprobamos que tenga permisos ?>
			<li><a href="ayudas.php?m=registrar" class="registrar"><?php echo $menu_registrar_ayuda; ?></a></li>
			<?php }	?>
		</ul>
		<?php 
		// Incluimos la conexion a la base de datos para la consulta
		include_once("elementos/conexion.php"); 
		// Si se ha indicado una ayuda específica
		if ( isset($_POST['ayudas_id']) ) { 
			// Recibimos el dato del formulario
			$ayudas_id = $_POST['ayudas_id'];
			// Hacemos la consulta a la base de datos
			$consulta = mysql_query("SELECT * FROM ayudas INNER JOIN criterios ON codcri_ayu=codcri_cri WHERE codcri_ayu='$ayudas_id' ORDER BY codayu_ayu");
		} else { // Si NO se ha indicado una ayuda específica
			// Hacemos la consulta a la base de datos
			$consulta = mysql_query("SELECT * FROM ayudas INNER JOIN criterios ON codcri_ayu=codcri_cri ORDER BY codcri_ayu");
		}
		// Contamos los resultados
		$conteo = mysql_num_rows($consulta);
		if ( $conteo != 0 ) { // Si hay resultados
			// Mostramos los resultados
			while ($resultado = mysql_fetch_array($consulta)) {
			echo '
			<div class="listado">
				<div class="resultadolistado">'.$resultado['titulo_ayu'].'</div>
				<div class="resultadolistado">'.$resultado['nombre_cri'].'</div>'; ?>
				<div class="botoneslistado">
					<!-- Boton ver ayuda completa -->
					<form name="ayudas_ver" method="post" action="ayudas.php">
						<input type="hidden" id="ver_id" name="ver_id" value="<?php echo $resultado['codayu_ayu']; ?>">
						<input type="submit" value="<?php echo $boton_ver_ayuda_completa; ?>">
					</form>
					<?php if (permisos(9)) { //Comprobamos que tenga permisos ?>
					<!-- Boton modificar -->
					<form name="ayudas_ver" method="post" action="ayudas.php">
						<input type="hidden" id="modificar_id" name="modificar_id" value="<?php echo $resultado['codayu_ayu']; ?>">
						<input type="submit" value="<?php echo $modificar; ?>">
					</form>
					<?php }	?>
					<?php if (permisos(10)) { //Comprobamos que tenga permisos ?>
					<!-- Boton eliminar -->
					<form name="ayudas_ver" method="post" action="ayudas.php" onsubmit="return confirm('<?php echo $alerta_eliminar_ayuda; ?>');">
						<input type="hidden" id="eliminar_id" name="eliminar_id" value="<?php echo $resultado['codayu_ayu']; ?>">
						<input type="submit" value="<?php echo $eliminar; ?>" class="eliminar">
					</form>
					<?php }	?>
				</div>
			</div>
			<?php }
		} else { // Si no hay resultados
			echo $ayudas_sin_resultado;
		} 
	} else {
		echo $error_acceso_no_autorizado;
	}
}
include('elementos/pie.php'); // Incluimos el pie
?>
