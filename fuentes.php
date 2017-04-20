<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" ) { // Si no ha iniciado sesión
	header('location:index.php'); // Redirigimos
/***************** Registrar ******************/
} else if( $_GET['m']=="registrar" && permisos(20) ) { ?>
	
	<h2>Registrar fuente</h2>
	<!-- Formulario -->
	<form name="fuentes" method="post" action="fuentes.php">
		<p>Los campos con * son obligatorios</p>
		<fieldset>
			<div>
				<label for="titulo_fuente" title="Escribe el titulo de la fuente">T&iacute;tulo de la fuente*: </label>
				<input type="text" id="titulo_fuente" name="titulo_fuente" size="80" maxlength="100" required data-validation="required length custom" data-validation-length="3-100" data-validation-regexp="^([A-Za-z0-9&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$">
			</div>
			<div>
				<label for="ubicacion" title="Escribe la ubicaci&oacute;n física o virtual de donde se obtuveron los datos">Ubicaci&oacute;n*: </label>
				<input type="text" id="ubicacion" name="ubicacion" size="70" maxlength="200" required data-validation="required length" data-validation-length="3-200">
			</div>
			<div>
				<label for="listado_paises" title="Selecciona el pa&iacute;s al que se refieren los datos">Pa&iacute;s*: </label>
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
			<div>
				<label for="listado_organizaciones_fuente" title="Selecciona la(s) organizaci&oacute;n(es) que ofrece(n) la fuente">Organizaci&oacute;n fuente*: </label><br \>
				<?php
					include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
					// Consulta
					$consultaCampo = mysql_query("SELECT * FROM organizaciones_fuente INNER JOIN paises ON organizaciones_fuente.idpais_orf=paises.id");
					// Listado de opciones
					$aux = 0;
					while ($resultadoCampo = mysql_fetch_assoc($consultaCampo)) {
						if ( $aux == 0 ){
							echo '<input type="checkbox" data-validation="checkbox_group" data-validation-qty="min1" name="organizacion_fuente[]" value="'.$resultadoCampo["ideorf_orf"].'">'.$resultadoCampo["organi_orf"].' ('.$resultadoCampo["nombre"].')<br \>';
						}else{
							echo '<input type="checkbox" name="organizacion_fuente[]" value="'.$resultadoCampo["ideorf_orf"].'">'.$resultadoCampo["organi_orf"].' ('.$resultadoCampo["nombre"].')<br \>';
						}
						++$aux;
					}
				?>
			</div>
		</fieldset>
		<input type="submit" value="Registrar">
	</form>
<?php
/***************** Guardar registro ******************/
} else if( isset($_POST['titulo_fuente']) ) { // Si se ha definido el dato 

	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$titulo_fuente = $_POST['titulo_fuente'];
	$ubicacion = $_POST['ubicacion'];
	$listado_paises = $_POST['listado_paises'];
	// Hacemos la consulta
	$inserta = mysql_query("INSERT INTO fuentes (titulo_fue,ubicac_fue,idpais_fue) VALUES ('$titulo_fuente','$ubicacion','$listado_paises')",$conexion) or die (mysql_error());

	$consulta = mysql_query("SELECT idefue_fue FROM fuentes WHERE titulo_fue='$titulo_fuente' AND ubicac_fue='$ubicacion' AND idpais_fue='$listado_paises'");
	while ($resultado = mysql_fetch_array($consulta)) { 
		$identificador_fuente = $resultado['idefue_fue'];
	}
	if(!empty($_POST['organizacion_fuente'])) {
	    foreach($_POST['organizacion_fuente'] as $organizacion_enviada) {
			// Hacemos la consulta
			$inserta = mysql_query("INSERT INTO rel_orgfuente_fuente (ideorf_rof,idefue_rof) VALUES ('$organizacion_enviada','$identificador_fuente')",$conexion) or die (mysql_error());
	    }
	}
	header('location:fuentes.php'); // Redirigimos
/***************** Modificar ******************/
} else if( isset($_POST['modificar_id']) && permisos(21) ) {
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$modificar_id = $_POST['modificar_id'];
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM fuentes WHERE idefue_fue='$modificar_id'");
	while ($resultado = mysql_fetch_array($consulta)) { 
		$actualizar_identificadorfuente = $resultado["idefue_fue"];
		$actualizar_titulo = $resultado["titulo_fue"];
		$actualizar_ubicacion = $resultado["ubicac_fue"];
		$actualizar_pais = $resultado["idpais_fue"];
	?>
	<h2>Modificar fuente</h2>
	<!-- Formulario -->
	<form name="fuentes_modificar" method="post" action="fuentes.php">
		<p>Los campos con * son obligatorios</p>
		<fieldset>
			<input type="hidden" id="actualizar_id" name="actualizar_id" value="<?php echo $modificar_id; ?>">
			<div>
				<label for="actualizar_titulo" title="Escribe el titulo de la fuente">T&iacute;tulo de la fuente*: </label>
				<input type="text" id="actualizar_titulo" name="actualizar_titulo" size="80" maxlength="100" required data-validation="required length custom" data-validation-length="3-100" data-validation-regexp="^([A-Za-z0-9&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$" value="<?php echo $actualizar_titulo; ?>">
			</div>
			<div>
				<label for="ubicacion" title="Escribe la ubicaci&oacute;n física o virtual de donde se obtuveron los datos">Ubicaci&oacute;n*: </label>
				<input type="text" id="ubicacion" name="ubicacion" size="70" maxlength="200" required data-validation="required length" data-validation-length="3-200" value="<?php echo $actualizar_ubicacion; ?>">
			</div>
			<div>
				<label for="listado_paises" title="Selecciona el pa&iacute;s al que se refieren los datos">Pa&iacute;s*: </label>
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
			<div>
				<label for="listado_organizaciones_fuente" title="Selecciona la(s) organizaci&oacute;n(es) que ofrece(n) la fuente">Organizaci&oacute;n fuente*: </label><br \>
				<?php
					include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
					// Consulta
					$consultaCampo = mysql_query("SELECT * FROM organizaciones_fuente INNER JOIN paises ON organizaciones_fuente.idpais_orf=paises.id LEFT JOIN rel_orgfuente_fuente ON organizaciones_fuente.ideorf_orf=rel_orgfuente_fuente.ideorf_rof");
					// Listado de opciones
					$aux = 0;
					while ($resultadoCampo = mysql_fetch_assoc($consultaCampo)) {
						if ( $resultadoCampo["ideorf_rof"]!=null && $resultadoCampo["ideorf_orf"]==$resultadoCampo["ideorf_rof"] && $resultado["idefue_fue"]==$resultadoCampo["idefue_rof"] ) {
							if ( $aux == 0 ){
								echo '<input type="checkbox" data-validation="checkbox_group" data-validation-qty="min1" name="organizacion_fuente[]" checked value="'.$resultadoCampo["ideorf_orf"].'">'.$resultadoCampo["organi_orf"].' ('.$resultadoCampo["nombre"].')<br \>';
							}else{
								echo '<input type="checkbox" name="organizacion_fuente[]" checked value="'.$resultadoCampo["ideorf_orf"].'">'.$resultadoCampo["organi_orf"].' ('.$resultadoCampo["nombre"].')<br \>';
							}
						} else {
							if ( $aux == 0 ){
								echo '<input type="checkbox" data-validation="checkbox_group" data-validation-qty="min1" name="organizacion_fuente[]" value="'.$resultadoCampo["ideorf_orf"].'">'.$resultadoCampo["organi_orf"].' ('.$resultadoCampo["nombre"].')<br \>';
							}else{
								echo '<input type="checkbox" name="organizacion_fuente[]" value="'.$resultadoCampo["ideorf_orf"].'">'.$resultadoCampo["organi_orf"].' ('.$resultadoCampo["nombre"].')<br \>';
							}
						}
						++$aux;
					}
				?>
			</div>
		</fieldset>
		<input type="submit" value="Actualizar">
	</form>
	<?php }
/***************** Guardar modificación ******************/
} else if( isset($_POST['actualizar_id']) && isset($_POST['actualizar_titulo']) ) {
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$actualizar_id = $_POST['actualizar_id'];
	$actualizar_titulo = $_POST['actualizar_titulo'];
	$actualizar_ubicacion = $_POST["ubicacion"];
	$actualizar_pais = $_POST["listado_paises"];
	// Hacemos la consulta
	$actualiza = mysql_query("UPDATE fuentes SET titulo_fue='$actualizar_titulo',ubicac_fue='$actualizar_ubicacion',idpais_fue='$actualizar_pais' WHERE idefue_fue='$actualizar_id'",$conexion) or die (mysql_error());

	// Hacemos la consulta
	$elimina = mysql_query("DELETE FROM rel_orgfuente_fuente WHERE idefue_rof='$actualizar_id'") or die (mysql_error());
	if(!empty($_POST['organizacion_fuente'])) {
	    foreach($_POST['organizacion_fuente'] as $organizacion_enviada) {
			// Hacemos la consulta
			$inserta = mysql_query("INSERT INTO rel_orgfuente_fuente (ideorf_rof,idefue_rof) VALUES ('$organizacion_enviada','$actualizar_id')",$conexion) or die (mysql_error());
	    }
	}

	header('location:fuentes.php'); // Redirigimos
/***************** Eliminar ******************/
} else if( isset($_POST['eliminar_id']) && permisos(22) ) { 
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$eliminar_id = $_POST['eliminar_id'];
	// Hacemos la consulta
	$elimina = mysql_query("DELETE FROM fuentes WHERE idefue_fue='$eliminar_id'");
	header('location:fuentes.php'); // Redirigimos
	?>
<?php
/***************** Menú ******************/
} else {
	if ( permisos(19) || permisos(20) || permisos(21) || permisos(22) ) { //Comprobamos que tenga permisos ?>
		<h2>Fuentes</h2>
		<ul class="menu_interno">
			<?php if (permisos(20)) { //Comprobamos que tenga permisos ?>
			<li><a href="fuentes.php?m=registrar" class="registrar">Registrar fuente</a></li>
			<?php }	?>
		</ul>
		<?php 
		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM fuentes INNER JOIN paises ON fuentes.idpais_fue = paises.id") or die(mysql_error());
		// Listado de resultados
		$conteo = mysql_num_rows($consulta);
		if ( $conteo != 0 ) {
			while ($resultado = mysql_fetch_array($consulta)) {
			echo '<div class="listado"><div class="resultadolistado">'.$resultado['titulo_fue'].'</div>
				<div class="resultadolistado">'.$resultado['ubicac_fue'].'</div>
				<div class="resultadolistado">'.$resultado['nombre'].'</div>
				<div class="resultadolistado">';
				$identificador_fuente = $resultado['idefue_fue'];
				$consultaCampo = mysql_query("SELECT * FROM rel_orgfuente_fuente INNER JOIN organizaciones_fuente ON rel_orgfuente_fuente.ideorf_rof = organizaciones_fuente.ideorf_orf WHERE idefue_rof='$identificador_fuente'") or die(mysql_error());
				while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
					echo '- '.$resultadoCampo['organi_orf']; 
				} 
				echo '</div>'; ?>
				<div class="botoneslistado">
					<?php if (permisos(21)) { //Comprobamos que tenga permisos ?>
					<form name="fuentes_ver" method="post" action="fuentes.php">
						<input type="hidden" id="modificar_id" name="modificar_id" value="<?php echo $resultado['idefue_fue']; ?>">
						<input type="submit" value="Modificar">
					</form>
					<?php }	?>
					<?php if (permisos(22)) { //Comprobamos que tenga permisos ?>
					<form name="fuentes_ver" method="post" action="fuentes.php" onsubmit="return confirm('¿Estas seguro(a) de eliminar esta fuente?');">
						<input type="hidden" id="eliminar_id" name="eliminar_id" value="<?php echo $resultado['idefue_fue']; ?>">
						<input type="submit" value="Eliminar" class="eliminar">
					</form>
					<?php }	?>
				</div>
			</div>
			<?php }
		} else {
			echo 'No hay fuentes registradas';
		}
	} else {
		echo $error_acceso_no_autorizado;
	}
}
include('elementos/pie.php'); // Incluimos el pie
?>
