<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" ) { // Si no ha iniciado sesión
	header('location:index.php'); // Redirigimos
/***************** Modificar ******************/
} else if( isset($_POST['etiqueta_title']) && permisos(45) ) {
	
	// Recibimos los datos
	$etiqueta_title = $_POST['etiqueta_title'];
	$titulo_principal = $_POST['titulo_principal'];
	$tema = $_POST['tema'];
	?>
	<h2><?php echo $titulo_modificar_configuracion; ?></h2>
	<!-- Formulario -->
	<form name="modificar_configuracion" method="post" action="configuracion.php">
		<!-- Mensaje de campos obligatorios -->
		<p><?php echo $mensaje_campos_obligatorios; ?></p>
		<!-- Grupo de campos del formulario -->
	<!-- Formulario -->
	<form name="ver_configuracion" method="post" action="micuenta.php">
		<fieldset>
			<div class="aparte">
				<label for="etiqueta_title_modificar"><?php echo $label_etiqueta_title; ?></label>
				<input type="text" id="etiqueta_title_modificar" name="etiqueta_title_modificar" size="60" value="<?php echo $etiqueta_title; ?>">
			</div>
			<div class="aparte">
				<label for="titulo_principal"><?php echo $label_titulo_principal; ?></label>
				<input type="text" id="titulo_principal" name="titulo_principal" size="60" value="<?php echo $titulo_principal; ?>">
			</div>
			<div class="aparte">
				<label for="tema"><?php echo $label_tema; ?></label>
				<select id="tema" name="tema">
					<? 
					if(@$directorio = opendir('temas/')) { 
						while (false !== ($archivo = readdir($directorio))) { 
							if ($archivo != '.' && $archivo != '..') { 
								echo '<option>'.$archivo.'</option>'; 
							} 
						} 
						closedir($directorio); 
					}else { 
						echo 'Error! No se han encontrado temas.'; 
					} 
					?> 
				</select>
			</div>
		</fieldset>
		<input type="submit" value="<?php echo $actualizar; ?>">
	</form>
<?php
/***************** Guardar modificación ******************/
} else if( isset($_POST['etiqueta_title_modificar']) ) {
	// Recibimos los datos
	$etiqueta_title = $_POST['etiqueta_title_modificar'];
	$titulo_principal = $_POST['titulo_principal'];
	$tema = $_POST['tema'];
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Hacemos la consulta
	$actualiza = mysql_query("UPDATE configuracion SET concon_con='$etiqueta_title' WHERE codcon_con='etiqueta_title'",$conexion) or die (mysql_error());
	$actualiza = mysql_query("UPDATE configuracion SET concon_con='$titulo_principal' WHERE codcon_con='titulo_principal'",$conexion) or die (mysql_error());
	$actualiza = mysql_query("UPDATE configuracion SET concon_con='$tema' WHERE codcon_con='tema'",$conexion) or die (mysql_error());
	echo '<script type="text/javascript">alert("Cambios guardados correctamente. Se veran reflejados en el proximo inicio de sesion.");
	window.location ="configuracion.php";</script>'; 
/***************** Configuración ******************/
} else {
	if ( permisos(45) ) { //Comprobamos que tenga permisos
		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM configuracion");
		// Resultado
		while($resultado = mysql_fetch_assoc($consulta)) { 
		   	if ($resultado['codcon_con']=='etiqueta_title') {
				$etiqueta_title = $resultado['concon_con'];
		   	}
		   	if ($resultado['codcon_con']=='titulo_principal') {
				$titulo_principal = $resultado['concon_con'];
		   	}
		   	if ($resultado['codcon_con']=='tema') {
				$tema = $resultado['concon_con'];
		   	}
		} ?>
		<h2><?php echo $titulo_modificar_configuracion; ?></h2>
		<!-- Formulario -->
		<form name="ver_configuracion" method="post" action="configuracion.php">
			<fieldset>
				<div class="aparte">
					<label for="etiqueta_title"><?php echo $label_etiqueta_title; ?></label>
					<input type="hidden" id="etiqueta_title" name="etiqueta_title" value="<?php echo $etiqueta_title; ?>" readonly> <?php echo $etiqueta_title; ?>
				</div>
				<div class="aparte">
					<label for="titulo_principal"><?php echo $label_titulo_principal; ?></label>
					<input type="hidden" id="titulo_principal" name="titulo_principal" value="<?php echo $titulo_principal; ?>" readonly> <?php echo $titulo_principal; ?>
				</div>
				<div class="aparte">
					<label for="tema"><?php echo $label_tema; ?></label>
					<input type="hidden" id="tema" name="tema" value="<?php echo $tema; ?>" readonly> <?php echo $tema; ?>
				</div>
			</fieldset>
			<input type="submit" value="<?php echo $modificar; ?>">
		</form>
	<?php } 
}
include('elementos/pie.php'); // Incluimos el pie
?>
