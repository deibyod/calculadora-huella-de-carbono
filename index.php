<?php 
session_start();
include('elementos/cabecera.php');
// Incluimos la conexion a la base de datos para la consulta
include_once("elementos/conexion.php");
// Hacemos la consulta a la base de datos
$consulta = mysql_query("SELECT conpag_pag FROM paginas WHERE codpag_pag=0") or die( mysql_error() );
// Recorremos el resultado de la consulta
while ($resultado = mysql_fetch_assoc($consulta)) { 
	// Asignamos a variables el valor de cada registro
	$contenido = $resultado["conpag_pag"];
	// Mostramos los datos
	echo $contenido;
} 
include('elementos/pie.php'); 
?>