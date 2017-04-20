<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" ) { // Si no ha iniciado sesión
	header('location:index.php'); // Redirigimos
/***************** Registrar ******************/
} else if( $_GET['m']=="registrar" && permisos(12) ) { // Si se ha definido el dato ?>
	<!-- Titulo -->
	<h2><?php echo $titulo_registrar_factor; ?></h2>
	<!-- Formulario -->
	<form name="factores" method="post" action="factores.php">
		<!-- Mensaje de campos obligatorios -->
		<p><?php echo $mensaje_campos_obligatorios; ?></p>
		<!-- Grupo de campos del formulario -->
		<fieldset>
			<!-- Campo -->
			<div class="seguido">
				<label for="listado_criterios" title="<?php echo $label_criterios_factor_tooltip; ?>"><?php echo $label_criterios_factor.$obligatorio; ?>: </label>
				<?php
					include_once("elementos/conexion.php"); // Incluimos la conexion a la base de datos para la consulta
					// Consulta
					$consultaCampo = mysql_query("SELECT * FROM criterios");
					echo '<select id="listado_criterios" name="listado_criterios">';
					// Listado de opciones
					while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
						echo '<option value="'.$resultadoCampo["codcri_cri"].'">'.$resultadoCampo["nombre_cri"].'</option>';
					}
					echo '</select>';
				?>
			</div>
			<!-- Campo -->
			<div class="seguido">
				<label for="listado_medidas" title="<?php echo $label_medidas_factor_tooltip; ?>"><?php echo $label_medidas_factor.$obligatorio; ?>: </label>
				<?php
					include_once("elementos/conexion.php"); // Incluimos la conexion a la base de datos para la consulta
					// Consulta
					$consultaCampo = mysql_query("SELECT * FROM medidas");
					echo '<select id="listado_medidas" name="listado_medidas">';
					// Listado de opciones
					while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
						echo '<option value="'.$resultadoCampo["abrmed_med"].'">'.$resultadoCampo["nombre_med"].' ('.$resultadoCampo["abrmed_med"].')</option>';
					}
					echo '</select>';
				?>
			</div>
			<!-- Campo -->
			<div class="seguido">
				<label for="listado_fuentes" title="<?php echo $label_fuentes_factor_tooltip; ?>"><?php echo $label_fuentes_factor.$obligatorio; ?>: </label>
				<?php
					include_once("elementos/conexion.php"); // Incluimos la conexion a la base de datos para la consulta
					// Consulta
					$consultaCampo = mysql_query("SELECT * FROM fuentes INNER JOIN paises ON fuentes.idpais_fue=paises.id");
					echo '<select id="listado_fuentes" name="listado_fuentes">';
					// Listado de opciones
					while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
						echo '<option value="'.$resultadoCampo["idefue_fue"].'">'.$resultadoCampo["titulo_fue"].' ('.$resultadoCampo["nombre"].')</option>';
					}
					echo '</select>';
				?>
			</div>
			<!-- Campo -->
			<div class="seguido">
				<label for="toneladas_co2" title="<?php echo $label_toneladas_co2_tooltip; ?>"><?php echo $label_toneladas_co2.$obligatorio; ?>: </label>
				<input type="text" id="toneladas_co2" name="toneladas_co2" size="15" required data-validation="required length number" data-validation-length="min1" data-validation-allowing="float">
			</div>
		</fieldset>
		<!-- Botón Submit -->
		<input type="submit" value="<?php echo $registrar; ?>">
	</form>
<?php
/***************** Guardar registro ******************/
} else if( isset($_POST['toneladas_co2']) ) { // Si se ha definido el dato 
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php"); 
	// Recibimos los datos del formulario
	$listado_criterios = $_POST['listado_criterios'];
	$listado_medidas = $_POST['listado_medidas'];
	$listado_fuentes = $_POST['listado_fuentes'];
	$toneladas_co2 = $_POST['toneladas_co2'];
	// Insertamos los datos en la base de datos
	$inserta = mysql_query("INSERT INTO factores (codcri_fac,abrmed_fac,idefue_fac,tonco2_fac) VALUES ('$listado_criterios','$listado_medidas','$listado_fuentes','$toneladas_co2')",$conexion) or die (mysql_error());
	header('location:factores.php'); // Redirigimos
/***************** Modificar ******************/
} else if( isset($_POST['modificar_id']) && permisos(13) ) { // Si se ha definido el dato y tiene permiso
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php"); 
	// Recibimos los datos del formulario
	$modificar_id = $_POST['modificar_id'];
	// Hacemos la consulta a la base de datos
	$consulta = mysql_query("SELECT * FROM factores WHERE codfac_fac='$modificar_id'") or die (mysql_error());
	// Recorremos el resultado de la consulta
	while ($resultado = mysql_fetch_array($consulta)) { 
		// Asignamos a variables el valor en cada registro
		$actualizar_codigofactor = $resultado["codfac_fac"];
		$actualizar_codigocriterio = $resultado['codcri_fac'];
		$actualizar_abreviaturamedida = $resultado['abrmed_fac'];
		$actualizar_identificadorfuente = $resultado['idefue_fac'];
		$actualizar_toneladas_co2 = $resultado['tonco2_fac'];
	}
	?>
	<!-- Titulo -->
	<h2><?php echo $titulo_modificar_factor; ?></h2>
	<!-- Formulario -->
	<form name="factores_modificar" method="post" action="factores.php">
		<!-- Mensaje de campos obligatorios -->
		<p><?php echo $mensaje_campos_obligatorios; ?></p>
		<!-- Grupo de campos del formulario -->
		<fieldset>
			<!-- Datos de uso interno -->
			<input type="hidden" id="actualizar_id" name="actualizar_id" value="<?php echo $modificar_id; ?>">
			<!-- Campo -->
			<div class="seguido">
				<label for="listado_criterios" title="Selecciona el criterio al que corresponden los datos">Criterio*: </label>
				<?php
					include_once("elementos/conexion.php"); // Incluimos la conexion a la base de datos para la consulta
					// Consulta
					$consultaCampo = mysql_query("SELECT * FROM criterios");
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
			<div class="seguido">
				<label for="listado_medidas" title="Selecciona la unidad de medida utilizada">Medida*: </label>
				<?php
					include_once("elementos/conexion.php"); // Incluimos la conexion a la base de datos para la consulta
					// Consulta
					$consultaCampo = mysql_query("SELECT * FROM medidas");
					echo '<select id="listado_medidas" name="listado_medidas">';
					// Listado de opciones
					while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
						if ( $resultadoCampo["abrmed_med"] == $actualizar_abreviaturamedida ){
							echo '<option value="'.$resultadoCampo["abrmed_med"].'" selected="selected">'.$resultadoCampo["nombre_med"].' ('.$resultadoCampo["abrmed_med"].')</option>';
						} else {
							echo '<option value="'.$resultadoCampo["abrmed_med"].'">'.$resultadoCampo["nombre_med"].' ('.$resultadoCampo["abrmed_med"].')</option>';
						}
					}
					echo '</select>';
				?>
			</div>
			<!-- Campo -->
			<div class="seguido">
				<label for="listado_fuentes" title="Selecciona la fuente de los datos">Fuente*: </label>
				<?php
					include_once("elementos/conexion.php"); // Incluimos la conexion a la base de datos para la consulta
					// Consulta
					$consultaCampo = mysql_query("SELECT * FROM fuentes INNER JOIN paises ON fuentes.idpais_fue=paises.id");
					echo '<select id="listado_fuentes" name="listado_fuentes">';
					// Listado de opciones
					while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
						if ( $resultadoCampo["idefue_fue"] == $actualizar_identificadorfuente ){
							echo '<option value="'.$resultadoCampo["idefue_fue"].'" selected="selected">'.$resultadoCampo["titulo_fue"].' ('.$resultadoCampo["nombre"].')</option>';
						} else {
							echo '<option value="'.$resultadoCampo["idefue_fue"].'">'.$resultadoCampo["titulo_fue"].' ('.$resultadoCampo["nombre"].')</option>';
						}
					}
					echo '</select>';
				?>
			</div>
			<!-- Campo -->
			<div class="seguido">
				<label for="actualizar_toneladas_co2" title="Toneladas de CO2 equivalente que indica la fuente">CO2 equivalente por unidad*: </label>
				<input type="text" id="actualizar_toneladas_co2" name="actualizar_toneladas_co2" size="15" required data-validation="required length number" data-validation-length="min1" data-validation-allowing="float" value="<?php echo $actualizar_toneladas_co2; ?>">
			</div>
		</fieldset>
		<!-- Botón Submit -->
		<input type="submit" value="<?php echo $actualizar; ?>">
	</form>
<?php
/***************** Guardar modificación ******************/
} else if( isset($_POST['actualizar_id']) ) {
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la base de datos para la consulta
	// Recibimos los datos del formulario
	$actualizar_id = $_POST['actualizar_id'];
	$actualizar_codigocriterio = $_POST['listado_criterios'];
	$actualizar_abreviaturamedida = $_POST['listado_medidas'];
	$actualizar_identificadorfuente = $_POST['listado_fuentes'];
	$actualizar_toneladas_co2 = $_POST['actualizar_toneladas_co2'];
	// Hacemos la consulta
	$actualiza = mysql_query("UPDATE factores SET codcri_fac='$actualizar_codigocriterio',abrmed_fac='$actualizar_abreviaturamedida',idefue_fac='$actualizar_identificadorfuente',tonco2_fac='$actualizar_toneladas_co2' WHERE codfac_fac='$actualizar_id'",$conexion) or die (mysql_error());
	header('location:factores.php'); // Redirigimos
/***************** Eliminar ******************/
} else if( isset($_POST['eliminar_id']) && permisos(14) ) { 
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la base de datos para la consulta
	// Recibimos los datos del formulario
	$eliminar_id = $_POST['eliminar_id'];
	// Hacemos la consulta
	$elimina = mysql_query("DELETE FROM factores WHERE codfac_fac='$eliminar_id'");
	header('location:factores.php'); // Redirigimos
	?>
<?php
/***************** Menú ******************/
} else {
	if ( permisos(11) || permisos(12) || permisos(13) || permisos(14) ) { //Comprobamos que tenga permisos ?>
		<h2>Factores</h2>
		<ul class="menu_interno">
			<?php if (permisos(12)) { //Comprobamos que tenga permisos ?>
			<li><a href="factores.php?m=registrar" class="registrar">Registrar factor</a></li>
			<?php }	?>
		</ul>
		<?php 
		include_once("elementos/conexion.php"); // Incluimos la conexion a la base de datos para la consulta
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM factores INNER JOIN criterios ON factores.codcri_fac = criterios.codcri_cri INNER JOIN medidas ON factores.abrmed_fac = medidas.abrmed_med INNER JOIN fuentes ON factores.idefue_fac = fuentes.idefue_fue") or die (mysql_error());
		// Listado de resultados
		$conteo = mysql_num_rows($consulta);
		if ( $conteo != 0 ) {
			while ($resultado = mysql_fetch_array($consulta)) {
			echo '<div class="listado"><div class="resultadolistado">'.$resultado['nombre_cri'].'</div>
				<div class="resultadolistado">'.$resultado['tonco2_fac'].'</div>
				<div class="resultadolistado">'.$resultado['nombre_med'].'</div>
				<div class="resultadolistado">'.$resultado['titulo_fue'].'</div>'; ?>
				<div class="botoneslistado">
					<?php if (permisos(13)) { //Comprobamos que tenga permisos ?>
					<form name="factores_ver" method="post" action="factores.php">
						<input type="hidden" id="modificar_id" name="modificar_id" value="<?php echo $resultado['codfac_fac']; ?>">
						<input type="submit" value="Modificar">
					</form>
					<?php }	?>
					<?php if (permisos(14)) { //Comprobamos que tenga permisos ?>
					<form name="factores_ver" method="post" action="factores.php" onsubmit="return confirm('¿Estas seguro(a) de eliminar este factor?');">
						<input type="hidden" id="eliminar_id" name="eliminar_id" value="<?php echo $resultado['codfac_fac']; ?>">
						<input type="submit" value="Eliminar" class="eliminar">
					</form>
					<?php }	?>
				</div>
			</div>
			<?php }
		} else {
			echo 'No hay factores registrados';
		} 
	} else {
		echo $error_acceso_no_autorizado;
	}
}
include('elementos/pie.php'); // Incluimos el pie
?>
