<?php
$response = array(
  'valid' => false,
  'message' => 'Error. Variable perdida.'
);

if( isset($_POST['contrasenia_antigua']) ) {

  session_start();
  $usuario = $_SESSION['usuario'];
  $contrasenia = md5($_POST['contrasenia_antigua']); // Encriptamos en MD5
  $contrasenia = stripslashes($contrasenia); // Eliminamos el simbolo /
  $contrasenia = mysql_real_escape_string($contrasenia);
  include_once("../elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
  $consulta = mysql_query("SELECT * FROM individuos WHERE nomusu_ind='$usuario' AND contra_ind='$contrasenia'");
  $conteo = mysql_num_rows($consulta);
  if($conteo == 1) { // Validamos la existencia y coherencia de los datos de acceso
    $response = array('valid' => true);
  } else {
    $response = array('valid' => false, 'message' => 'Contraseña incorrecta.');
  }
}

echo json_encode($response);
?>