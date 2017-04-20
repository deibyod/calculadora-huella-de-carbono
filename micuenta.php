<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" && !isset($_POST['loginusuario']) ) { // Si no ha iniciado sesión
/***************** Iniciar sesión ******************/ ?>
	<!-- Formulario -->
	<form id="acceso" name="acceso" method="post" action="micuenta.php">
		<div>
			<div>
				<label for="loginusuario"><?php echo $label_nombre_de_usuario; ?>: </label>
				<input type="text" id="loginusuario" name="loginusuario" size="10" maxlength="30" required autofocus data-validation="required">
			</div>
			<div>
				<label for="logincontrasenia"><?php echo $label_contrasenia; ?>: </label>
				<input type="password" id ="logincontrasenia" name="logincontrasenia" size="10" required data-validation="required">
			</div>
		</div>
		<div>
			<input type="submit" value="<?php echo $boton_iniciar_sesion; ?>">
		</div>
	</form>
<?php 
/***************** Activar sesión ******************/
} else if( isset($_POST['loginusuario']) ) { // Si se ha definido el dato

	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$loginusuario = $_POST['loginusuario'];
	$logincontrasenia = md5($_POST['logincontrasenia']); // Encriptamos en MD5
	$loginusuario = stripslashes($loginusuario); // Eliminamos el simbolo /
	$logincontrasenia = stripslashes($logincontrasenia); // Eliminamos el simbolo /
	$loginusuario = mysql_real_escape_string($loginusuario); 
	$logincontrasenia = mysql_real_escape_string($logincontrasenia);
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM individuos WHERE nomusu_ind='$loginusuario' AND contra_ind='$logincontrasenia'") or die (mysql_error());
	$conteo = mysql_num_rows($consulta);
	if($conteo == 1) { // Validamos la existencia y coherencia de los datos de acceso
		while($resultado = mysql_fetch_assoc($consulta)) { // Creamos la sesión
	    	$_SESSION['autenticado'] = true;
	    	$_SESSION['id_usuario']=$resultado['codind_ind'];
	    	$_SESSION['usuario']=$resultado['nomusu_ind'];
			$_SESSION['nombre']=$resultado['nombre_ind'];
			$_SESSION['primer_apellido']=$resultado['apell1_ind'];
			$_SESSION['segundo_apellido']=$resultado['apell2_ind'];
			$_SESSION['idioma']=$resultado['idioma_ind'];
	    }
	    echo '<script type="text/javascript">window.location ="micuenta.php";</script>'; // Redirigimos
	} else { 
		echo '<script type="text/javascript">alert("'.$error_datos_de_acceso_incorrectos.'");
		window.location ="micuenta.php";</script>'; // Notificamos error y redirigimos
	}
/***************** Ver datos del usuario ******************/
} else if( $_GET['m']=="ver" ) { 

	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$usuario = $_SESSION['usuario'];
	// Hacemos la consulta
	$consulta = mysql_query("SELECT * FROM individuos WHERE nomusu_ind='$usuario'");
	// Resultado
	while($resultado = mysql_fetch_assoc($consulta)) { 
	   	$codigo_individuo = $resultado['codind_ind'];
	   	$usuario = $resultado['nomusu_ind'];
	   	$nombre = $resultado['nombre_ind'];
		$primer_apellido = $resultado['apell1_ind'];
		$segundo_apellido = $resultado['apell2_ind'];
		$identificacion = $resultado['ideind_ind'];
		$correo = $resultado['correo_ind'];
		$fecha_nacimiento = $resultado['fecnac_ind'];
		$fecha_registro = $resultado['fecreg_ind'];
		$idioma_predeterminado = $resultado['idioma_ind'];
		?>
		<!-- Formulario -->
		<form name="ver_misdatos" method="post" action="micuenta.php">
			<fieldset>
				<input type="hidden" id="modificar_id" name="modificar_id" value="<?php echo $codigo_individuo; ?>" readonly>
				<div class="aparte">
					<label for="usuario"><?php echo $label_nombre_de_usuario; ?>:</label>
					<input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario; ?>" readonly> <?php echo $usuario; ?>
				</div>
				<div class="aparte">
					<label for="fecha_registro"><?php echo $label_fecha_de_registro; ?>:</label>
					<input type="hidden" id="fecha_registro" name="fecha_registro" value="<?php echo $fecha_registro; ?>" readonly> <?php echo $fecha_registro; ?>
				</div>

			</fieldset>
			<fieldset>
			<div class="aparte">
				<div class="seguido">
					<label for="nombre"><?php echo $label_nombre; ?>:</label>
					<input type="hidden" id="nombre" name="nombre" size="10" value="<?php echo $nombre; ?>" readonly> <?php echo $nombre; ?>
				</div>
				<div class="seguido">
					<input type="hidden" id="primer_apellido" name="primer_apellido" size="10" value="<?php echo $primer_apellido; ?>" readonly> <?php echo $primer_apellido; ?>
				</div>
				<div class="seguido">
					<input type="hidden" id="segundo_apellido" name="segundo_apellido" size="10" value="<?php echo $segundo_apellido; ?>" readonly> <?php echo $segundo_apellido; ?>
				</div>
			</div>
			</fieldset>
			<fieldset>
				<div class="aparte">
					<label for="identificacion"><?php echo $label_numero_de_identificacion; ?>:</label>
					<input type="hidden" id="identificacion" name="identificacion" size="10" value="<?php echo $identificacion; ?>" readonly> <?php echo $identificacion; ?>
				</div>
				<div class="aparte">
					<label for="correo"><?php echo $label_correo; ?>:</label>
					<input type="hidden" id="correo" name="correo" size="30" value="<?php echo $correo; ?>" readonly> <?php echo $correo; ?>
				</div>
				<div class="aparte">
					<label for="fecha_nac"><?php echo $label_recha_de_nacimiento; ?>: </label>
					<input type="hidden" id="fecha_nac" name="fecha_nac" value="<?php echo $fecha_nacimiento; ?>" readonly> <?php echo $fecha_nacimiento; ?>
				</div>
				<div class="aparte">
					<label for="idioma_predeterminado"><?php echo $label_idioma; ?>: </label>
					<input type="hidden" id="idioma_predeterminado" name="idioma_predeterminado" value="<?php echo $idioma_predeterminado; ?>" readonly> <?php echo $idioma_predeterminado; ?>
				</div>
			</fieldset>
			<input type="submit" value="<?php echo $boton_modificar_datos; ?>">
		</form>
		<form name="ver_misdatos" method="post" action="micuenta.php">
			<input type="hidden" id="cambiar_contrasenia_id" name="cambiar_contrasenia_id" value="<?php echo $codigo_individuo; ?>">
			<input type="submit" value="<?php echo $boton_cambiar_contrasenia; ?>" class="cambiar_contrasenia">
		</form>
		<form name="ver_misdatos" method="post" action="micuenta.php" onsubmit="return confirm('<?php echo $alerta_eliminar_cuenta; ?>');">
			<input type="hidden" id="eliminar_id" name="eliminar_id" value="<?php echo $codigo_individuo; ?>">
			<input type="submit" value="<?php echo $boton_eliminar_cuenta; ?>" class="eliminar">
		</form>
		<!-- Botón atrás -->
		<div id="menunavegacion"><ul><li><a href="micuenta.php?m=ver" id="atras"><?php echo $atras; ?></a></li></ul></div>
	<?php } ?>
<?php
/***************** Modificar ******************/
} else if( isset($_POST['modificar_id']) ) {
	
	// Recibimos los datos
	$codigo_individuo = $_POST['modificar_id'];
	$usuario = $_POST['usuario'];
	$nombre = $_POST['nombre'];
	$primer_apellido = $_POST['primer_apellido'];
	$segundo_apellido = $_POST['segundo_apellido'];
	$identificacion = $_POST['identificacion'];
	$correo = $_POST['correo'];
	$fecha_nacimiento = $_POST['fecha_nac'];
	$idioma_predeterminado = $_POST['idioma_predeterminado'];
	?>
	<!-- Titulo -->
	<h2><?php echo $titulo_modificar_datos; ?></h2>
	<!-- Formulario -->
	<form name="registro_completo" method="post" action="micuenta.php">
		<!-- Mensaje de campos obligatorios -->
		<p><?php echo $mensaje_campos_obligatorios; ?></p>
		<!-- Grupo de campos del formulario -->
		<fieldset>
			<input type="hidden" id="actualizar_id" name="actualizar_id" value="<?php echo $codigo_individuo; ?>" readonly>
			<div>
				<label for="usuario"><?php echo $label_nombre_de_usuario; ?>: </label>
				<input type="text" id="usuario" name="usuario" value="<?php echo $usuario; ?>" readonly>
			</div>
		</fieldset>
		<fieldset>
			<div class="seguido">
				<label for="nombre" title="Escribe tu nombre"><?php echo $label_nombre.$obligatorio; ?>: </label>
				<input type="text" id="nombre" name="nombre" size="10" maxlength="40" required data-validation="required length custom" data-validation-length="2-40" data-validation-regexp="^([A-Za-z&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$" value="<?php echo $nombre; ?>">
			</div>
			<div class="seguido">
				<label for="primer_apellido" title="Escribe tu primer apellido">Primer apellido*: </label>
				<input type="text" id="primer_apellido" name="primer_apellido" size="10" maxlength="20" required data-validation="required length custom" data-validation-length="2-20" data-validation-regexp="^([A-Za-z&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute;]+)$" value="<?php echo $primer_apellido; ?>">
			</div>
			<div class="seguido">
				<label for="segundo_apellido" title="Escribe tu segundo apellido">Segundo apellido*: </label>
				<input type="text" id="segundo_apellido" name="segundo_apellido" size="10" maxlength="20" required data-validation="required length custom" data-validation-length="2-20" data-validation-regexp="^([A-Za-z&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute;]+)$" value="<?php echo $segundo_apellido; ?>">
			</div>
			<div class="seguido">
				<label for="identificacion" title="Escribe tu n&uacute;mero de identificaci&oacute;n (opcional)">Nro de identificaci&oacute;n: </label>
				<input type="text" id="identificacion" name="identificacion" size="10" maxlength="15" data-validation="length alphanumeric" data-validation-length="0-15" value="<?php echo $identificacion; ?>">
			</div>
		</fieldset>
		<fieldset>
			<div>
				<label for="correo" title="Escribe tu correo electr&oacute;nico">Correo*: </label>
				<input type="email" id="correo" name="correo" size="30" maxlength="50" autocomplete="off" required data-validation="required email" value="<?php echo $correo; ?>">
			</div>
			<div>
				<label for="fecha_nac" title="Indica tu fecha de nacimiento">Fecha de nacimiento*: </label>
				<input type="text" id="fecha_nac" name="fecha_nac" size="10" maxlength="30" required data-validation="birthdate" data-validation-format="yyyy-mm-dd" value="<?php echo $fecha_nacimiento; ?>">
			</div>
			<div>
				<label for="idioma_predeterminado" title="Selecciona el idioma predeterminado">Idioma*: </label>
				<select id="idioma_predeterminado" name="idioma_predeterminado">
					<?php $directorio=dir("idiomas/");
					while ($archivo = $directorio->read()){
						$archivo_idioma = substr($archivo, 0, -4);
						if ($archivo!="." && $archivo!=".."){
							if ( $archivo_idioma == $idioma_predeterminado ){
								echo '<option value="'.$archivo_idioma.'" selected>'.$archivo_idioma.'</option>';
							} else {
								echo '<option value="'.$archivo_idioma.'">'.$archivo_idioma.'</option>';
							}
						}
					} $directorio->close(); ?>
				</select>
			</div>
		</fieldset>
		<input type="submit" value="Actualizar">
	</form>
	<!-- Botón atrás -->
	<div id="menunavegacion"><ul><li><a href="micuenta.php?m=ver" id="atras"><?php echo $atras; ?></a></li></ul></div>
<?php
/***************** Guardar modificación ******************/
} else if( isset($_POST['actualizar_id']) ) {
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$actualizar_id = $_POST['actualizar_id'];
	$usuario = $_POST['usuario'];
	$nombre = $_POST['nombre'];
	$primer_apellido = $_POST['primer_apellido'];
	$segundo_apellido = $_POST['segundo_apellido'];
	$identificacion = $_POST['identificacion'];
	$correo = $_POST['correo'];
	$fecha_nacimiento = $_POST['fecha_nac'];
	$idioma_predeterminado = $_POST['idioma_predeterminado'];
	// Hacemos la consulta
	$actualiza = mysql_query("UPDATE individuos SET nombre_ind='$nombre',apell1_ind='$primer_apellido',apell2_ind='$segundo_apellido',ideind_ind='$identificacion',correo_ind='$correo',fecnac_ind='$fecha_nacimiento',idioma_ind='$idioma_predeterminado' WHERE codind_ind='$actualizar_id' AND nomusu_ind='$usuario'",$conexion) or die (mysql_error());
	header('location:micuenta.php?m=ver'); // Redirigimos
/***************** Cambiar contraseña ******************/
} else if( isset($_POST['cambiar_contrasenia_id']) ) {
	
	// Recibimos los datos
	$codigo_individuo = $_POST['cambiar_contrasenia_id'];
	?>
	<h2>Cambiar contrase&ntilde;a</h2>
	<!-- Formulario -->
	<form name="cambiar_contrasenia" method="post" action="micuenta.php">
		<p>Los campos con * son obligatorios</p>
		<input type="hidden" id="actualizar_contrasenia_id" name="actualizar_contrasenia_id" value="<?php echo $codigo_individuo; ?>" readonly>
			<fieldset>
				<div>
					<label for="contrasenia_antigua" title="Indica la contrase&ntilde;a que tienes en este momento">Contrase&ntilde;a actual*: </label>
					<input type="password" id="contrasenia_antigua" name="contrasenia_antigua" size="10" maxlength="30" autofocus required data-validation="server" data-validation-url="validaciones/validar_contrasenia.php">
				</div>
				<div class="seguido">
					<label for="contrasenia_confirmation" title="Elige una nueva contrase&ntilde;a">Contrase&ntilde;a nueva*: </label>
					<input type="password" id="contrasenia_confirmation" name="contrasenia_confirmation" size="10" maxlength="30" required data-validation="required strength" data-validation-strength="2">
				</div>
				<div class="seguido">
					<label for="contrasenia" title="Repite la nueva contrase&ntilde;a">Repetir contrase&ntilde;a*: </label>
					<input type="password" id="contrasenia" name="contrasenia" size="10" maxlength="30" required data-validation="required confirmation">
				</div>
			</fieldset>
		<input type="submit" value="Cambiar contrase&ntilde;a">
	</form>
	<!-- Botón atrás -->
	<div id="menunavegacion"><ul><li><a href="micuenta.php?m=ver" id="atras"><?php echo $atras; ?></a></li></ul></div>
<?php
/***************** Guardar nueva contraseña ******************/
} else if( isset($_POST['actualizar_contrasenia_id']) ) {

	if ( $_POST['contrasenia_confirmation']==$_POST['contrasenia'] ) {
		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Recibimos los datos
		$usuario = $_SESSION['usuario'];
		$actualizar_contrasenia_id = $_POST['actualizar_contrasenia_id'];
		$contrasenia_antigua = md5($_POST['contrasenia_antigua']); // Encriptamos en MD5
		$contrasenia_antigua = stripslashes($contrasenia_antigua); // Eliminamos el simbolo /
		$contrasenia_antigua = mysql_real_escape_string($contrasenia_antigua);
		$contrasenia_confirmation = md5($_POST['contrasenia_confirmation']); // Encriptamos en MD5
		$contrasenia_confirmation = stripslashes($contrasenia_confirmation); // Eliminamos el simbolo /
		$contrasenia_confirmation = mysql_real_escape_string($contrasenia_confirmation);
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM individuos WHERE nomusu_ind='$usuario' AND contra_ind='$contrasenia_antigua'");
		$conteo = mysql_num_rows($consulta);
		if($conteo == 1) { // Validamos la existencia y coherencia de los datos de acceso
			$actualiza = mysql_query("UPDATE individuos SET contra_ind='$contrasenia_confirmation' WHERE codind_ind='$actualizar_contrasenia_id' AND nomusu_ind='$usuario'",$conexion) or die (mysql_error());
			header('location:micuenta.php?m=ver'); // Redirigimos
		} else { 
			echo 'La contrase&ntilde;a actual es incorrecta. El cambio no fue efectuado.';
		}
	} else {
		echo 'Ńo has confirmado correctamente tu nueva contrase&ntilde;a';
	}
/***************** Eliminar ******************/
} else if( isset($_POST['eliminar_id']) ) { 
	
	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$id_usuario = $_SESSION['id_usuario'];
	$usuario = $_SESSION['usuario'];
	$eliminar_id = $_POST['eliminar_id'];
	// Hacemos la consulta
	if ( $id_usuario == $eliminar_id ) {
		$consulta = mysql_query("SELECT codrol_ind FROM individuos WHERE codind_ind='$eliminar_id' AND nomusu_ind='$usuario' AND codrol_ind='0'");
		$conteo = mysql_num_rows($consulta);
		if($conteo == 0) {
			$elimina = mysql_query("DELETE FROM individuos WHERE codind_ind='$eliminar_id' AND nomusu_ind='$usuario'");
			session_unset();
			session_destroy();
			header('location:index.php'); // Redirigimos
		} else {
			$consulta = mysql_query("SELECT codrol_ind FROM individuos WHERE codrol_ind=0");
			$conteo = mysql_num_rows($consulta);
			if($conteo > 1 ) {
				$elimina = mysql_query("DELETE FROM individuos WHERE codind_ind='$eliminar_id' AND nomusu_ind='$usuario'");
				session_unset();
				session_destroy();
				header('location:index.php'); // Redirigimos
			}else{
				echo '<script type="text/javascript">alert("'.$error_imposible_eliminar_cuenta_administrativa.'");
				window.location ="micuenta.php";</script>'; // Notificamos error y redirigimos
			}
		}
	}
/***************** Menu de usuario ******************/
} else {
	?>
	<h2><?php echo $menu_personal; ?></h2>
	<ul class="menu_central">
		<li><a href="micuenta.php?m=ver" id="misdatos" class="nivel1"><?php echo $menu_mis_datos; ?></a></li> <!-- Menú datos de individuo -->
		<li><a href="huella.php" class="nivel1"><?php echo $menu_mi_huella;?></a></li> <!-- Menú huella individual -->
		<li><a href="organizaciones.php" class="nivel1"><?php echo $menu_organizaciones;?></a></li> <!-- Menú organizaciones -->
	</ul>
	<?php if ( permisos(3) || permisos(4) || permisos(5) || permisos(6) || permisos(7) || permisos(8) || permisos(9) || permisos(10) || permisos(11) || permisos(12) || permisos(13) || permisos(14) || permisos(15) || permisos(16) || permisos(17) || permisos(18) || permisos(19) || permisos(20) || permisos(21) || permisos(22) || permisos(23) || permisos(24) || permisos(25) || permisos(26) || permisos(27) || permisos(29) || permisos(30) || permisos(31) || permisos(32) ) { //Comprobamos que tenga permisos ?>
	<h2><?php echo $menu_de_gestion_de_la_huella;?></h2>
	<?php } ?>
	<ul class="menu_central">
		<?php if ( permisos(3) || permisos(4) || permisos(5) || permisos(6) || permisos(7) || permisos(8) || permisos(9) || permisos(10) ) { //Comprobamos que tenga permisos ?>
		<li><a href="criterios.php" class="nivel1"><?php echo $menu_criterios;?></a></li> <!-- Menú criterios -->
		<?php } ?>
		<?php if ( permisos(7) || permisos(8) || permisos(9) || permisos(10) ) { //Comprobamos que tenga permisos ?>
		<li><a href="ayudas.php" class="nivel2"><?php echo $menu_ayudas;?></a></li> <!-- Menú ayudas -->
		<?php } ?>
	</ul>
	<ul class="menu_central">
		<?php if ( permisos(11) || permisos(12) || permisos(13) || permisos(14) ) { //Comprobamos que tenga permisos ?>
		<li><a href="factores.php" class="nivel1"><?php echo $menu_factores; ?></a></li> <!-- Menú factores -->
		<?php } ?>
		<?php if ( permisos(15) || permisos(16) || permisos(17) || permisos(18) ) { //Comprobamos que tenga permisos ?>
		<li><a href="medidas.php" class="nivel2"><?php echo $menu_unidades_de_medida; ?></a></li> <!-- Menú unidades de medida -->
		<?php } ?>
		<?php if ( permisos(19) || permisos(20) || permisos(21) || permisos(22) ) { //Comprobamos que tenga permisos ?>
		<li><a href="fuentes.php" class="nivel2"><?php echo $menu_fuentes; ?></a></li> <!-- Menú fuentes -->
		<?php } ?>
		<?php if ( permisos(19) || permisos(20) || permisos(21) || permisos(22) || permisos(23) || permisos(24) || permisos(25) || permisos(26) || permisos(27) ) { //Comprobamos que tenga permisos ?>
		<li><a href="organizaciones_fuente.php" class="nivel3"><?php echo $menu_organizaciones_fuente; ?></a></li> <!-- Menú organizaciones fuente -->
		<?php } ?>
	</ul>
	<ul class="menu_central">
		<?php if ( permisos(29) || permisos(30) || permisos(31) ) { //Comprobamos que tenga permisos ?>
		<li><a href="tiempos.php" class="nivel2"><?php echo $menu_tiempos; ?></a></li> <!-- Menú tiempos -->
		<?php } ?>
		<?php if ( permisos(32) ) { //Comprobamos que tenga permisos ?>
		<li><a href="paises.php" class="nivel2"><?php echo $menu_paises; ?></a></li> <!-- Menú paises -->
		<?php } ?>
	</ul>
	<?php if ( permisos(37) || permisos(38) || permisos(39) || permisos(40) || permisos(41) || permisos(42) || permisos(43) || permisos(41) || permisos(42) || permisos(43) || permisos(44) ) { //Comprobamos que tenga permisos ?>
	<h2><?php echo $menu_de_gestion_del_sistema; ?></h2>
	<?php } ?>
	<ul class="menu_central">
		<?php if ( permisos(37) || permisos(38) || permisos(39) || permisos(40) || permisos(41) || permisos(42) || permisos(43) ) { //Comprobamos que tenga permisos ?>
		<li><a href="roles.php" class="nivel1"><?php echo $menu_roles_y_permisos; ?></a></li> <!-- Menú roles y permisos -->
		<?php } ?>
		<?php if ( permisos(41) || permisos(42) || permisos(43) || permisos(44) ) { //Comprobamos que tenga permisos ?>
		<li><a href="procesos.php" class="nivel2"><?php echo $menu_procesos; ?></a></li> <!-- Menú procesos -->
		<?php } ?>
		<?php if ( permisos(33) || permisos(35) || permisos(36) ) { //Comprobamos que tenga permisos ?>
		<li><a href="individuos.php" class="nivel1"><?php echo $menu_individuos; ?></a></li> <!-- Menú roles y permisos -->
		<?php } ?>
		<?php if ( permisos(1) || permisos(2) ) { //Comprobamos que tenga permisos ?>
		<li><a href="organizaciones.php?m=gestionar" class="nivel1"><?php echo $menu_gestion_organizaciones; ?></a></li> <!-- Menú roles y permisos -->
		<?php } ?>
	</ul>
	<ul class="menu_central">
		<?php if ( permisos(46) || permisos(47) || permisos(48) || permisos(49) ) { //Comprobamos que tenga permisos ?>
		<li><a href="paginas.php" class="nivel1"><?php echo $menu_paginas; ?></a></li> <!-- Menú roles y permisos -->
		<?php } ?>
		<?php if ( permisos(45) ) { //Comprobamos que tenga permisos ?>
		<li><a href="configuracion.php" class="nivel1"><?php echo $menu_configuracion; ?></a></li> <!-- Menú roles y permisos -->
		<?php } ?>
	</ul>
<?php }
include('elementos/pie.php'); // Incluimos el pie
?>
