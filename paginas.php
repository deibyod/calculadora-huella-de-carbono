<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
/* if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true") { // Si no ha iniciado sesión */
	/*header('location:index.php'); // Redirigimos*/
/***************** Registrar ******************/
/*} else*/ if( $_GET['m']=="registrar" && permisos(47) ) { // Si se ha definido el dato ?>
	<!-- Titulo -->
	<h2><?php echo $titulo_registrar_pagina; ?></h2>
	<!-- Formulario -->
	<form name="paginas" method="post" action="paginas.php">
		<!-- Mensaje de campos obligatorios -->
		<p><?php echo $mensaje_campos_obligatorios; ?></p>
		<!-- Grupo de campos del formulario -->
		<fieldset>
			<!-- Campo -->
			<div>
				<label for="titulo_pagina" title="<?php echo $label_titulo_pagina_tooltip; ?>"><?php echo $label_titulo_pagina.$obligatorio; ?>: </label>
				<input type="text" id="titulo_pagina" name="titulo_pagina" size="40" maxlength="80" required data-validation="required length custom" data-validation-length="3-80" data-validation-regexp="^([A-Za-z0-9&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$">
			</div>
			<!-- Campo -->
			<div>
				<label for="contenido_pagina" title="<?php echo $label_contenido_pagina_tooltip; ?>"><?php echo $label_contenido_pagina.$obligatorio; ?>: </label>
				<textarea id="contenido_pagina" name="contenido_pagina" rows="4" cols="50" required data-validation="required length" data-validation-length="min10"></textarea> 
			</div>
			<div>
				<input type="checkbox" id="pie_pagina" name="pie_pagina" value="1"><?php echo $mensaje_poner_en_pie_de_pagina; ?><br>
			</div>
		</fieldset>
		<!-- Botón Submit -->
		<input type="submit" value="<?php echo $registrar; ?>">
	</form>
	<!-- Botón atrás -->
	<div id="menunavegacion"><ul><li><a href="paginas.php" id="atras"><?php echo $atras; ?></a></li></ul></div>
<?php
/***************** Guardar registro ******************/
} else if( isset($_POST['titulo_pagina']) ) { // Si se ha definido el dato 
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php");
	// Recibimos los datos del formulario
	$titulo_pagina = $_POST['titulo_pagina'];
	$contenido_pagina = $_POST['contenido_pagina'];
	if( isset($_POST['pie_pagina']) ){
		$pie_pagina = $_POST['pie_pagina'];;
	} else {
		$pie_pagina = 0;
	}
	// Insertamos los datos en la base de datos
	$inserta = mysql_query("INSERT INTO paginas (titulo_pag,conpag_pag,piepag_pag) VALUES ('$titulo_pagina','$contenido_pagina','$pie_pagina')",$conexion) or die (mysql_error());
	header('location:paginas.php'); // Redirigimos
/***************** Ver pagina ******************/
} else if( isset($_GET['p']) ) { // Si se ha definido el dato y tiene permiso
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php");
	// Recibimos los datos del formulario
	$pagina = $_GET['p'];
	// Hacemos la consulta a la base de datos
	$consulta = mysql_query("SELECT * FROM paginas WHERE codpag_pag='$pagina'");
	// Recorremos el resultado de la consulta
	while ($resultado = mysql_fetch_array($consulta)) { 
		// Asignamos a variables el valor de cada registro
		$titulo = $resultado["titulo_pag"];
		$contenidopagina = $resultado["conpag_pag"];
		$pie_pagina = $resultado["piepag_pag"];
		// Mostramos los datos
		echo '
		<div class="pagina">
			<h2>'.$titulo.'</h2>
			'.$contenidopagina.'
		</div>';
		if( $pie_pagina == 1 && ( permisos(46) || permisos(47) || permisos(48) || permisos(49) ) ){
			echo '<div>'.$visible_en_pie_de_pagina.'</div>';
		}
	} ?>
	<!-- Botones de opciones -->
	<div>
		<div class="botoneslistado">
			<?php if (permisos(48)) { //Comprobamos que tenga permisos ?>
			<!-- Boton modificar -->
			<form name="pagina_ver" method="post" action="paginas.php">
				<input type="hidden" id="modificar_id" name="modificar_id" value="<?php echo $pagina; ?>">
				<input type="submit" value="<?php echo $modificar; ?>">
			</form>
			<?php }	?>
			<?php if (permisos(49) && $resultado['codpag_pag']!=0) { //Comprobamos que tenga permisos ?>
			<!-- Boton eliminar -->
			<form name="pagina_ver" method="post" action="paginas.php" onsubmit="return confirm('<?php echo $alerta_eliminar_pagina; ?>');">
				<input type="hidden" id="eliminar_id" name="eliminar_id" value="<?php echo $pagina; ?>">
				<input type="submit" value="<?php echo $eliminar ?>" class="eliminar">
			</form>
			<?php }	?>
		</div>
	</div>
	<?php if( $pie_pagina == 1 && ( permisos(46) || permisos(47) || permisos(48) || permisos(49) ) ){ ?>
	<!-- Botón atrás -->
	<div id="menunavegacion"><ul><li><a href="paginas.php" id="atras"><?php echo $atras; ?></a></li></ul></div>
	<?php }	?>
<?php	
/***************** Modificar ******************/
} else if( isset($_POST['modificar_id']) && permisos(48) ) { // Si se ha definido el dato y tiene permiso
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php");
	// Recibimos los datos del formulario
	$modificar_id = $_POST['modificar_id'];
	// Hacemos la consulta a la base de datos
	$consulta = mysql_query("SELECT * FROM paginas WHERE codpag_pag='$modificar_id'");
	// Recorremos el resultado de la consulta
	while ($resultado = mysql_fetch_array($consulta)) { 
		// Asignamos variables al registro
		$actualizar_titulo = $resultado["titulo_pag"];
		$actualizar_contenidopagina = $resultado["conpag_pag"];
		$actualizar_pie = $resultado["piepag_pag"];
	}
	?>
	<!-- Titulo -->
	<h2><?php echo $titulo_modificar_pagina; ?></h2>
	<!-- Formulario -->
	<form name="paginas_modificar" method="post" action="paginas.php">
		<!-- Mensaje de campos obligatorios -->
		<p><?php echo $mensaje_campos_obligatorios; ?></p>
		<!-- Grupo de campos del formulario -->
		<fieldset>
			<!-- Datos de uso interno -->
			<input type="hidden" id="actualizar_id" name="actualizar_id" value="<?php echo $modificar_id; ?>">
			<!-- Campo -->
			<div>
				<label for="actualizar_titulo" title="<?php echo $label_titulo_pagina_tooltip; ?>"><?php echo $label_titulo_pagina.$obligatorio; ?>: </label>
				<input type="text" id="actualizar_titulo" name="actualizar_titulo" size="40" maxlength="80" required data-validation="required length custom" data-validation-length="3-80" data-validation-regexp="^([A-Za-z0-9&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$" value="<?php echo $actualizar_titulo; ?>">
			</div>
			<!-- Campo -->
			<div>
				<label for="contenido_pagina" title="<?php echo $label_contenido_pagina_tooltip; ?>"><?php echo $label_contenido_pagina.$obligatorio; ?>: </label><br>
				<textarea id="contenido_pagina" name="contenido_pagina" rows="4" cols="50" required data-validation="required length" data-validation-length="min10"><?php echo $actualizar_contenidopagina; ?></textarea> 
			</div>
			<div>
				<input type="checkbox" id="pie_pagina" name="pie_pagina" <?php if ($actualizar_pie == 1){ echo 'checked'; }?> value="1"><?php echo $mensaje_poner_en_pie_de_pagina; ?><br>
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
	$actualizar_contenidopagina = $_POST['contenido_pagina'];
	$actualizar_pie = $_POST['contenido_pagina'];
	// Actualizamos los datos en la base de datos
	$actualiza = mysql_query("UPDATE paginas SET titulo_pag='$actualizar_titulo',conpag_pag='$actualizar_contenidopagina',piepag_pag='$actualizar_pie' WHERE codpag_pag='$actualizar_id'",$conexion) or die (mysql_error());
	header('location:paginas.php'); // Redirigimos
/***************** Eliminar ******************/
} else if( isset($_POST['eliminar_id']) && permisos(49) ) { 
	// Incluimos la conexion a la base de datos para la consulta
	include_once("elementos/conexion.php");
	// Recibimos los datos del formulario
	$eliminar_id = $_POST['eliminar_id'];
	// Eliminamos el registro de la base de datos
	$elimina = mysql_query("DELETE FROM paginas WHERE codpag_pag='$eliminar_id'");
	header('location:paginas.php'); // Redirigimos
	?>
<?php
/***************** Menú ******************/
} else { 
	if ( permisos(46) || permisos(47) || permisos(48) || permisos(49) ) { //Comprobamos que tenga permisos ?>
		<!-- Titulo -->
		<h2><?php echo $titulo_paginas; ?></h2>
		<!-- Menú -->
		<ul class="menu_interno">
			<?php if ( permisos(47) ) { //Comprobamos que tenga permisos ?>
			<li><a href="paginas.php?m=registrar" class="registrar"><?php echo $menu_registrar_pagina; ?></a></li>
			<?php }	?>
		</ul>
		<?php 
		// Incluimos la conexion a la base de datos para la consulta
		include_once("elementos/conexion.php"); 
		// Hacemos la consulta a la base de datos
		$consulta = mysql_query("SELECT * FROM paginas");
		// Contamos los resultados
		$conteo = mysql_num_rows($consulta);
		if ( $conteo != 0 ) { // Si hay resultados
			// Mostramos los resultados
			while ($resultado = mysql_fetch_array($consulta)) {
			echo '
			<div class="listado">
				<div class="resultadolistado">'.$resultado['titulo_pag'].'</div>'; ?>
				<div class="botoneslistado">
					<!-- Boton ver pagina completa -->
					<form name="paginas_ver" method="get" action="paginas.php">
						<input type="hidden" id="p" name="p" value="<?php echo $resultado['codpag_pag']; ?>">
						<input type="submit" value="<?php echo $boton_ver_pagina_completa; ?>">
					</form>
					<?php if (permisos(48)) { //Comprobamos que tenga permisos ?>
					<!-- Boton modificar -->
					<form name="paginas_ver" method="post" action="paginas.php">
						<input type="hidden" id="modificar_id" name="modificar_id" value="<?php echo $resultado['codpag_pag']; ?>">
						<input type="submit" value="<?php echo $modificar; ?>">
					</form>
					<?php }	?>
					<?php if (permisos(49) && $resultado['codpag_pag']!=0) { //Comprobamos que tenga permisos ?>
					<!-- Boton eliminar -->
					<form name="paginas_ver" method="post" action="paginas.php" onsubmit="return confirm('<?php echo $alerta_eliminar_pagina; ?>');">
						<input type="hidden" id="eliminar_id" name="eliminar_id" value="<?php echo $resultado['codpag_pag']; ?>">
						<input type="submit" value="<?php echo $eliminar; ?>" class="eliminar">
					</form>
					<?php }	?>
				</div>
			</div>
			<?php }
		} else { // Si no hay resultados
			echo $paginas_sin_resultado;
		} 
	} else {
		echo $error_acceso_no_autorizado;
	}
}
include('elementos/pie.php'); // Incluimos el pie
?>
