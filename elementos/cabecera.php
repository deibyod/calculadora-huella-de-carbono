<?php session_start(); 
require("validaciones/permisos.php");
if ( isset($_SESSION['idioma']) ) {
	require("idiomas/".$_SESSION['idioma'].".php");
} else {
	require("idiomas/es-CO.php");
}
if ( !isset($_SESSION['etiqueta_title']) || !isset($_SESSION['tema']) || !isset($_SESSION['titulo_principal']) ) {
	require("elementos/configuracion.php");
}
?>
<!DOCTYPE html>
<html lang="es-ES">
<meta http-equiv="Content-Type" content="text/html; charset="ISO-8859-1" />
<head>
	<title><?php echo $_SESSION['etiqueta_title']; ?></title>
	<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script> 
	<script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script> 
	<script src="js/jquery.form-validator.min.js" type="text/javascript"></script>
	<script src="js/funciones.js" type="text/javascript"></script> 
	<script src="temas/<?php echo $_SESSION['tema']; ?>/estilos.js" type="text/javascript"></script> 
	<link rel="stylesheet" type="text/css" href="temas/<?php echo $_SESSION['tema']; ?>/estilos.css" />
	<link rel="stylesheet" href="temas/<?php echo $_SESSION['tema']; ?>/jquery-ui.css" />
</head>
<body>
	<div id="contenedor">
		<div id="arbol">
			<div id="header">
				<div id="titulo">
					<?php echo $_SESSION['titulo_principal']; ?>
				</div>
				<div id="menu">
					<ul>
						<li>
							<a id="inicio" href="index.php"><?php echo $menu_inicio; ?></a>
						</li>
						<li>
							<a id="micuenta" href="micuenta.php"><?php echo $menu_micuenta; ?></a>
						</li>
						<li>
							<?php if( !isset($_SESSION["autenticado"]) ) { ?>
								<a id="registro" href="registro.php"><?php echo $menu_registrate; ?></a>
							<?php } ?>
						</li>
						<li>
							<?php if( isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]=="true" ){ ?>
								<a id="cerrar_sesion" href="cerrar_sesion.php"><?php echo $menu_cerrarsesion ?></a>
							<?php } ?>
						</li>
					</ul>
				</div>
			</div>
			<div id="tronco">
				<div id="contenido">
