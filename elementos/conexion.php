<?php
/****** DATOS QUE DEBES LLENAR MANUALMENTE *******/ 
/* 
Reemplaza los siguientes términos en la línea que inicia '$conexion...':

localhost -> Servidor utilizado. Generalmente localhost.
usuario -> Nombre de usuario de la base de datos
contrasenia -> Contraseña de acceso a la base de datos
basededatos -> Nombre de la base de datos */

$conexion = mysql_connect ('localhost', 'usuario', 'contrasenia') or die ('No se puede conectar a la base de datos');
mysql_select_db ('basededatos', $conexion) or die ('No se puede seleccionar la base de datos');
?>