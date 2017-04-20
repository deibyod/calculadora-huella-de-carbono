<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
echo '<h1>'.$error_pagina_no_encontrada.'</h1>
<script type="text/javascript">
	setTimeout(function() {
	  window.location ="index.php";
	}, 4000);
</script>'; // Notificamos error y redirigimos
include('elementos/pie.php'); // Incluimos el pie
?>
