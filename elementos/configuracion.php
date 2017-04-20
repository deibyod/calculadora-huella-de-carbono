<?php 
include_once("conexion.php"); // Incluimos la conexion a la BD para la consulta
$consulta = mysql_query("SELECT * FROM configuracion");
while ($resultado = mysql_fetch_array($consulta)) {
	$_SESSION[ $resultado['codcon_con'] ] = $resultado['concon_con'];
}
?>