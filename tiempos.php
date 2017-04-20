<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" ) { // Si no ha iniciado sesión
	header('location:index.php'); // Redirigimos
/***************** Registrar ******************/
} else if( $_GET['m']=="registrar" && permisos(29) ) { ?>
	
	<h2>Registrar espacio de tiempo</h2>
	<!-- Formulario -->
	<form name="tiempos" method="post" action="tiempos.php">
		<p>Los campos con * son obligatorios</p>
		<fieldset>
			<div>
				<label for="valor_tiempo" title="Escribe el valor del espacio de tiempo basado en una(1) hora">Valor de espacio de tiempo (en base a 1 hora)*: </label>
				<input type="text" id="valor_tiempo" name="valor_tiempo" size="10" required data-validation="required length number" data-validation-length="min1" data-validation-allowing="float">
			</div>
			<div>
				<label for="denominacion" title="Asigna un nombre al espacio de tiempo">Denominaci&oacute;n*: </label>
				<input type="text" id="denominacion" name="denominacion" size="10" maxlength="30" required data-validation="required length" data-validation-length="2-30">
			</div>
		</fieldset>
		<input type="submit" value="Registrar">
	</form>
	<!-- Botón atrás -->
	<div id="menunavegacion"><ul><li><a href="tiempos.php" id="atras"><?php echo $atras; ?></a></li></ul></div>
<?php
/***************** Guardar registro ******************/
} else if( isset($_POST['valor_tiempo']) ) { // Si se ha definido el dato 

	// Recibimos los datos
	$valor_tiempo = $_POST['valor_tiempo'];
	$denominacion = $_POST['denominacion'];
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM tiempos WHERE valort_tie='$valor_tiempo'");
	$conteo = mysql_num_rows($consulta);
	if ( $conteo == 1 ) {
		echo '<script type="text/javascript">alert("Error. Ese espacio de tiempo ya existe.");
		window.location ="tiempos.php";</script>'; // Indicamos el error y redirigimos
	} else {
		// Hacemos la consulta
		$inserta = mysql_query("INSERT INTO tiempos (valort_tie,nombre_tie) VALUES ('$valor_tiempo','$denominacion')",$conexion) or die (mysql_error());
		header('location:tiempos.php'); // Redirigimos
	}
/***************** Modificar ******************/
} else if( isset($_POST['modificar_id']) && permisos(30) ) {
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$modificar_id = $_POST['modificar_id'];
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM tiempos WHERE valort_tie='$modificar_id'");
	while ($resultado = mysql_fetch_array($consulta)) { 
		$actualizar_valor_tiempo = $resultado["valort_tie"];
		$actualizar_denominacion = $resultado["nombre_tie"];
	}
	?>
	<h2>Modificar espacio de tiempo</h2>
	<!-- Formulario -->
	<form name="tiempos_modificar" method="post" action="tiempos.php">
		<p>Los campos con * son obligatorios</p>
		<fieldset>
			<input type="hidden" id="actualizar_id" name="actualizar_id" value="<?php echo $modificar_id; ?>">
			<div>
				<label for="actualizar_valor_tiempo" title="Escribe el valor del espacio de tiempo basado en una(1) hora">Valor de espacio de tiempo (en base a 1 hora)*: </label>
				<input type="text" id="actualizar_valor_tiempo" name="actualizar_valor_tiempo" size="10" required data-validation="required length number" data-validation-length="min1" data-validation-allowing="float" value="<?php echo $actualizar_valor_tiempo; ?>">
			</div>
			<div>
				<label for="denominacion" title="Da un nombre al lapso de tiempo">Denominaci&oacute;n*: </label>
				<input type="text" id="denominacion" name="denominacion" size="10" maxlength="30" required data-validation="required length" data-validation-length="2-30" value="<?php echo $actualizar_denominacion; ?>">
			</div>
		</fieldset>
		<input type="submit" value="Actualizar">
	</form>
	<!-- Botón atrás -->
	<div id="menunavegacion"><ul><li><a href="tiempos.php" id="atras"><?php echo $atras; ?></a></li></ul></div>
<?php
/***************** Guardar modificación ******************/
} else if( isset($_POST['actualizar_id']) && isset($_POST['actualizar_valor_tiempo']) ) {
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$actualizar_id = $_POST['actualizar_id'];
	$actualizar_valor_tiempo = $_POST['actualizar_valor_tiempo'];
	$actualizar_denominacion = $_POST["denominacion"];
	// Hacemos la consulta
	$actualiza = mysql_query("UPDATE tiempos SET valort_tie='$actualizar_valor_tiempo',nombre_tie='$actualizar_denominacion' WHERE valort_tie='$actualizar_id'",$conexion) or die (mysql_error());
	header('location:tiempos.php'); // Redirigimos
/***************** Eliminar ******************/
} else if( isset($_POST['eliminar_id']) && permisos(31) ) { 
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$eliminar_id = $_POST['eliminar_id'];
	// Hacemos la consulta
	$elimina = mysql_query("DELETE FROM tiempos WHERE valort_tie='$eliminar_id'");
	header('location:tiempos.php'); // Redirigimos
	?>
<?php
/***************** Menú ******************/
} else {
	if ( permisos(29) || permisos(30) || permisos(31) ) { //Comprobamos que tenga permisos ?>
		<h2>Tiempos</h2>
		<ul class="menu_interno">
			<?php if (permisos(29)) { //Comprobamos que tenga permisos ?>
			<li><a href="tiempos.php?m=registrar" class="registrar">Registrar espacio de tiempo</a></li>
			<?php }	?>
		</ul>
		<?php 
		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM tiempos");
		// Listado de resultados
		$conteo = mysql_num_rows($consulta);
		if ( $conteo != 0 ) {
			while ($resultado = mysql_fetch_array($consulta)) {
			echo '<div class="listado">
				<div class="resultadolistado">'.$resultado['valort_tie'].'</div>
				<div class="resultadolistado">'.$resultado['nombre_tie'].'</div>'; ?>
				<div class="botoneslistado">
					<?php if (permisos(30)) { //Comprobamos que tenga permisos ?>
					<form name="tiempos_ver" method="post" action="tiempos.php">
						<input type="hidden" id="modificar_id" name="modificar_id" value="<?php echo $resultado['valort_tie']; ?>">
						<input type="submit" value="Modificar">
					</form>
					<?php }	?>
					<?php if (permisos(31)) { //Comprobamos que tenga permisos ?>
					<form name="tiempos_ver" method="post" action="tiempos.php" onsubmit="return confirm('¿Estas seguro(a) de eliminar este espacio de tiempo?');">
						<input type="hidden" id="eliminar_id" name="eliminar_id" value="<?php echo $resultado['valort_tie']; ?>">
						<input type="submit" value="Eliminar" class="eliminar">
					</form>
					<?php }	?>
				</div>
			</div>
			<?php }
		} else {
			echo 'No hay tiempos registrados';
		}
		?>
		<!-- Botón atrás -->
		<div id="menunavegacion"><ul><li><a href="micuenta.php" id="atras"><?php echo $atras; ?></a></li></ul></div>
		<?php
	} else {
		echo $error_acceso_no_autorizado;
	}
}
include('elementos/pie.php'); // Incluimos el pie
?>
