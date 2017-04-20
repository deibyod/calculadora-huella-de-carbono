<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]=="true" ) { // Si ha iniciado sesión
	header('location:principal.php'); // Redirigimos
/***************** Guardar registro ******************/
} else if( isset($_POST['usuario']) && isset($_POST['contrasenia']) && isset($_POST['nombre']) ) { // Si se han definido los datos

	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	// Recibimos los datos
	$usuario = strtolower($_POST['usuario']); // Ponemos en minusculas
	$contrasenia = md5($_POST['contrasenia']); // Encriptamos en MD5
	$nombre = ucwords(strtolower($_POST['nombre'])); // Ponemos la primera letra de cada palabra en mayúsculas (Poniendo en minusculas primero)
	$primer_apellido = ucwords(strtolower($_POST['primer_apellido'])); // Ponemos la primera letra de cada palabra en mayúsculas (Poniendo en minusculas primero)
	$segundo_apellido = ucwords(strtolower($_POST['segundo_apellido'])); // Ponemos la primera letra de cada palabra en mayúsculas (Poniendo en minusculas primero)
	$identificacion = $_POST['identificacion'];
	$correo = $_POST['correo'];
	$fecha_nacimiento = $_POST['fecha_nacimiento'];
	$idioma_predeterminado = $_POST['idioma_predeterminado'];
	$fecha_registro = date("Y-m-d"); // Obtenemos la fecha del servidor
	
	if( preg_match("/^[a-z\d_]{3,30}$/i",$usuario) ) { // Validamos el formato de los datos del lado del servidor
		// Hacemos la consulta a la base de datos
		$consulta = mysql_query("SELECT * FROM individuos");
		$conteo = mysql_num_rows($consulta);
		if ( $conteo == 0 ) {
			// Hacemos la consulta
			$inserta = mysql_query("INSERT INTO individuos (nomusu_ind,contra_ind,nombre_ind,apell1_ind,apell2_ind,ideind_ind,correo_ind,fecnac_ind,idioma_ind,fecreg_ind,codrol_ind) VALUES ('$usuario','$contrasenia','$nombre','$primer_apellido','$segundo_apellido','$identificacion','$correo','$fecha_nacimiento','$idioma_predeterminado','$fecha_registro','0')",$conexion) or die (mysql_error());
			echo '<script type="text/javascript">alert("Felicitaciones! Tu cuenta se ha creado exitosamente. Eres el nuevo administrador del sistema.");
			window.location ="micuenta.php";</script>'; // Confirmamos y redirigimos
		} else {
			// Hacemos la consulta
			$inserta = mysql_query("INSERT INTO individuos (nomusu_ind,contra_ind,nombre_ind,apell1_ind,apell2_ind,ideind_ind,correo_ind,fecnac_ind,idioma_ind,fecreg_ind) VALUES ('$usuario','$contrasenia','$nombre','$primer_apellido','$segundo_apellido','$identificacion','$correo','$fecha_nacimiento','$idioma_predeterminado','$fecha_registro')",$conexion) or die (mysql_error());
			echo '<script type="text/javascript">alert("Felicitaciones! Tu cuenta se ha creado exitosamente.");
			window.location ="micuenta.php";</script>'; // Confirmamos y redirigimos
		}
	} else {
		echo '<script type="text/javascript">alert("Error!.");
		window.location ="micuenta.php";</script>'; // Notificamos error y redirigimos
	}
/***************** Registrar ******************/
} else if( isset($_POST['usuario']) ) { // Si se ha definido el dato

	include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
	$usuario = $_POST['usuario']; // Recibimos el dato

	$consulta = mysql_query("SELECT * FROM individuos WHERE nomusu_ind='$usuario'") or die (mysql_error());
	$conteo = mysql_num_rows($consulta);
	if( $conteo == 0 ) { // Validamos la no existencia del dato ?>
		<!-- Formulario -->
		<form name="registro_completo" method="post" action="registro.php">
			<!-- Mensaje de campos obligatorios -->
			<p><?php echo $mensaje_campos_obligatorios; ?></p>
			<!-- Grupo de campos del formulario -->
			<fieldset>
				<div>
					<label for="usuario"><?php echo $label_nombre_de_usuario; ?>: </label>
					<input type="text" id="usuario" name="usuario" value="<?php echo $usuario; ?>" readonly>
				</div>
				<div class="seguido">
					<label for="contrasenia_confirmation" title="Elige una contraseña"><?php echo $label_contrasenia.$obligatorio; ?>: </label>
					<input type="password" id="contrasenia_confirmation" name="contrasenia_confirmation" size="10" maxlength="30" required autofocus data-validation="required strength" data-validation-strength="2">
				</div>
				<div class="seguido">
					<label for="contrasenia" title="Repite la contraseña">Repetir contraseña*: </label>
					<input type="password" id="contrasenia" name="contrasenia" size="10" maxlength="30" required data-validation="required confirmation">
				</div>
			</fieldset>
			<fieldset>
				<div class="seguido">
					<label for="nombre" title="Escribe tu nombre"><?php echo $label_nombre.$obligatorio; ?>: </label>
					<input type="text" id="nombre" name="nombre" size="10" maxlength="40" required data-validation="required length custom" data-validation-length="2-40" data-validation-regexp="^([A-Za-z&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute; ]+)$">
				</div>
				<div class="seguido">
					<label for="primer_apellido" title="Escribe tu primer apellido">Primer apellido*: </label>
					<input type="text" id="primer_apellido" name="primer_apellido" size="10" maxlength="20" required data-validation="required length custom" data-validation-length="2-20" data-validation-regexp="^([A-Za-z&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute;]+)$">
				</div>
				<div class="seguido">
					<label for="segundo_apellido" title="Escribe tu segundo apellido">Segundo apellido*: </label>
					<input type="text" id="segundo_apellido" name="segundo_apellido" size="10" maxlength="20" required data-validation="required length custom" data-validation-length="2-20" data-validation-regexp="^([A-Za-z&ntilde;&aacute;&eacute;&iacute;&oacute;&uacute;]+)$">
				</div>
				<div class="seguido">
					<label for="identificacion" title="Escribe tu n&uacute;mero de identificaci&oacute;n (opcional)"><?php echo $label_numero_de_identificacion; ?>: </label>
					<input type="text" id="identificacion" name="identificacion" size="10" maxlength="15" data-validation="length alphanumeric" data-validation-length="0-15">
				</div>
			</fieldset>
			<fieldset>
				<div>
					<label for="correo" title="Escribe tu correo electrónico"><?php echo $label_correo.$obligatorio; ?>: </label>
					<input type="email" id="correo" name="correo" size="30" maxlength="50" autocomplete="off" required data-validation="required email">
				</div>
				<div>
					<label for="fecha_nacimiento" title="Indica tu fecha de nacimiento"><?php echo $label_recha_de_nacimiento.$obligatorio; ?>: </label>
					<input type="text" id="fecha_nacimiento" name="fecha_nacimiento" size="10" maxlength="30" placeholder="ejp: 1990-01-30" required data-validation="birthdate" data-validation-format="yyyy-mm-dd">
				</div>
				<div>
					<label for="idioma_predeterminado" title="Selecciona el idioma predeterminado">Idioma*: </label>
					<select id="idioma_predeterminado" name="idioma_predeterminado">
						<?php $directorio=dir("idiomas/");
						while ($archivo = $directorio->read()){
							$archivo_idioma = substr($archivo, 0, -4);
							if ($archivo!="." && $archivo!=".."){
								echo '<option value="'.$archivo_idioma.'">'.$archivo_idioma.'</option>';
							}
						} $directorio->close(); ?>
					</select>
				</div>


			</fieldset>
			<input type="submit" value="Registrarme">
		</form>

	<?php 
	} else {
		header("Location:micuenta-php"); // Redirigimos
	}
/***************** Usuario de registro ******************/
} else { ?>
	<!-- Formulario -->
	<form name="registro" method="post" action="registro.php">
		<label for="usuario" title="Elige un nombre de usuario"><?php echo $label_nombre_de_usuario; ?>: </label>
		<input type="text" id="usuario" name="usuario" size="10" maxlength="30" required autofocus data-validation="required length alphanumeric" data-validation-length="3-30">
		<input type="submit" value="Comprobar">
	</form>

<?php 
}
include('elementos/pie.php'); // Incluimos el pie
?>