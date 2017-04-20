<?php
  if(!isset($_POST['enviar'])){
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Subir imagen</title>
</head>
<body>
<h1>Subir imagen</h1>
<form method='post' action='subir_imagen.php' enctype='multipart/form-data'>  
  Selecciona la imagen<br /><input name="img" type="file" />
  <input name='enviar' type='submit' value='Subir' />
</form>
<?php
  }else{
    // Subimos la imagen
    if (is_uploaded_file($_FILES['img']['tmp_name'])){
      // Recibimos la imagen
      $imagen = $_FILES['img']['name'];
      // Obtenemos el nombre de la imagen y la extensión
      $imagen1 = explode(".",$imagen);
      $nombre = limpiar_cadena($imagen1[0]);
      if( ($imagen1[1] == "jpg") || ($imagen1[1] == "png") || ($imagen1[1] == "svg") || ($imagen1[1] == "gif") ){	
        // Generamos un nombre aleatorio con la fehca, hora y números y le asignamos la extensión obtenida anteriormente
        $imagen2 = date("Y-m-d_H-i-s_").rand(100,9999)."_".$nombre.".".$imagen1[1];
        // Colocamos la imagen en la carpeta correspondiente con el nuevo nombre
        move_uploaded_file($_FILES['img']['tmp_name'], "../imagenes/criterios/".$imagen2);
        // Asignamos a la foto permisos
        $ruta="../imagenes/criterios/".$imagen2;
        chmod($ruta,0777);
        // Insertamos la URL al formulario
        echo "<script>
                window.opener.document.getElementById('imagen_criterio').value = 'imagenes/criterios/".$imagen2."';
                alert('Imagen subida correctamente');
                window.close();
              </script>";
      }else{
        echo "<p align='center'><span style='color:red;font-size:28px;'>Solo se permiten im&aacute;genes .jpg, .png, .svg y .gif</span><br />";
        echo "<a href='subir_imagen.php'><span style='font-size:28px;'>Volver a intentarlo</span></a></p>";
      }
    }
  }
  // Función para eliminar caracteres especiales del nombre de la imagen
  function limpiar_cadena($string) {
    // Reemplazar letras tipo caracter especial a su equivalente en letra sencilla
    $string = trim($string);
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
    // Eliminar caracteres especiales
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", " "),
        '',
        $string
    );
    return $string;
  }
?>
</body>
</html>
