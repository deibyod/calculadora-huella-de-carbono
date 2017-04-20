<?php
function permisos($codigo){
  $usuario = $_SESSION['usuario'];
  include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
  $consulta = mysql_query("SELECT * FROM individuos INNER JOIN permisos ON codrol_ind=codrol_per AND codprc_per='$codigo' WHERE nomusu_ind='$usuario' AND codrol_ind IS NOT NULL");
  $conteo = mysql_num_rows($consulta);
  if ( $conteo != 0 ) { 
    return true;
  } else {
    return false;
  }
}
?>