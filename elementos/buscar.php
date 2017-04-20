<?php
session_start();
$buscar = $_POST['b'];
if(!empty($buscar)) {
	buscar($buscar);
}
function buscar($b) {
	$b = utf8_decode($b);
	include_once("conexion.php"); // Incluimos la conexion a la BD para la consulta
	$consulta = mysql_query("SELECT * FROM organizaciones WHERE nombre_org LIKE '%".$b."%'",$conexion);
	$conteo = mysql_num_rows($consulta);
	if($conteo == 0){
		echo "No se han encontrado resultados para '<b>".$b."</b>'.";
	} else {
		$id_usuario = $_SESSION['id_usuario'];
		while($row=mysql_fetch_array($consulta)){
			$identificador_organizacion = $row['ideorg_org'];
			$nombre = utf8_encode( $row['nombre_org'] );
			echo '<div class="listado">
				<div class="resultadolistado">'.$nombre.'</div>
				<div class="botoneslistado">';
				$consultaCampo = mysql_query("SELECT * FROM rel_individuo_organizacion WHERE codind_rio='$id_usuario' AND ideorg_rio='$identificador_organizacion'",$conexion);
				$conteoCampo = mysql_num_rows($consultaCampo);
				if ( $conteoCampo == 0 ) { ?>
					<form name="organizaciones_buscar" method="post" action="organizaciones.php">
						<input type="hidden" id="vincular_id" name="vincular_id" value="<?php echo $identificador_organizacion; ?>">
						<input type="submit" value="Vincularme">
					</form>
				<?php } else {
				} ?>
				</div>
			</div>
		<?php }
	}
}
$buscarcriterio = $_POST['bc'];
if(!empty($buscarcriterio)) {
	buscarcriterio($buscarcriterio);
}
function buscarcriterio($b) {
	$b = utf8_decode($b);
	include_once("conexion.php"); // Incluimos la conexion a la BD para la consulta
	$consulta = mysql_query("SELECT * FROM criterios WHERE nombre_cri LIKE '%".$b."%'",$conexion);
	/*SELECT * FROM criterios LEFT JOIN huella_individual ON codcri_cri=codcri_hui AND codind_hui='$id_usuario' WHERE codind_hui IS NULL*/
	$conteo = mysql_num_rows($consulta);
	if($conteo == 0){
		echo "No se han encontrado resultados para '<b>".$b."</b>'.";
	} else {
		$id_usuario = $_SESSION['id_usuario'];
		while($row=mysql_fetch_array($consulta)){
			$codigo_criterio = $row['codcri_cri'];
			$nombre = utf8_encode( $row['nombre_cri'] );
			echo '<div class="listado">
				<div class="resultadolistado">'.$nombre.'</div>
				<div class="botoneslistado">';
				$consultaCampo = mysql_query("SELECT * FROM huella_individual WHERE codind_hui='$id_usuario' AND codcri_hui='$codigo_criterio'",$conexion);
				$conteoCampo = mysql_num_rows($consultaCampo);
				if ( $conteoCampo == 0 ) { ?>
					<form name="huella_agregar" method="post" action="huella.php">
						<input type="hidden" id="agregarcriterio_id" name="agregarcriterio_id" value="<?php echo $codigo_criterio; ?>">
						<input type="submit" value="Agregar">
					</form>
				<?php } ?>
				</div>
			</div>
		<?php }
	}
}
?>