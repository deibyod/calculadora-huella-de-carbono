<?php 
include('elementos/cabecera.php'); // Incluimos la cabecera
if( !isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]!="true" ) { // Si no ha iniciado sesión
	header('location:index.php'); // Redirigimos
} else {
	/***************** Agregar Criterio ******************/
	if( $_GET['m']=="agregar" ) { ?>
		
		<h2>Agregar criterio</h2>
		<?php 
		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Recibimos los datos
		$id_usuario = $_SESSION['id_usuario'];
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM criterios LEFT JOIN huella_individual ON codcri_cri=codcri_hui AND codind_hui='$id_usuario' WHERE codind_hui IS NULL");
		// Listado de resultados
		$conteo = mysql_num_rows($consulta);
		if ( $conteo != 0 ) {
			?>
			<!-- Formulario -->
			<input type="text" id="busquedacriterio" placeholder="Buscar criterio..."/>
			<div id="resultado"></div>
			<hr \>
			<?php 
			while ($resultado = mysql_fetch_array($consulta)) {
			echo '<div class="listado">
				<div class="resultadolistado">'.$resultado['nombre_cri'].'</div>'; ?>
				<div class="botoneslistado">
					<form name="huella_agregar" method="post" action="huella.php">
						<input type="hidden" id="agregarcriterio_id" name="agregarcriterio_id" value="<?php echo $resultado['codcri_cri']; ?>">
						<input type="submit" value="Agregar">
					</form>
				</div>
			</div>
			<?php }
		} else {
			echo 'No hay criterios para agregar. Si consideras que faltan criterios por favor contacta con el administrador del sistema.';
		}
	/***************** Registrar criterio ******************/
	} else if( isset($_POST['agregarcriterio_id']) ) { // Si se ha definido el dato 

		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Recibimos los datos
		$agregarcriterio_id = $_POST['agregarcriterio_id'];
		$id_usuario = $_SESSION['id_usuario'];
		// Insertamos los datos
		$inserta = mysql_query("INSERT INTO huella_individual (codcri_hui,codind_hui) VALUES ('$agregarcriterio_id','$id_usuario')",$conexion) or die (mysql_error());
		header('location:huella.php'); // Redirigimos
	/***************** Modificar ******************/
	} else if( isset($_POST['modificarcriterio_id']) && isset($_POST['modificarindividuo_id'])) {

		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Recibimos los datos
		$modificarcriterio_nombre = $_POST['modificarcriterio_nombre'];
		$modificarcriterio_id = $_POST['modificarcriterio_id'];
		$modificarindividuo_id = $_POST['modificarindividuo_id'];
		// Hacemos la consulta
		$consulta = mysql_query("SELECT * FROM huella_individual LEFT JOIN (factores INNER JOIN medidas ON abrmed_fac=abrmed_med) ON codfac_hui=codfac_fac WHERE codcri_hui='$modificarcriterio_id' AND codind_hui='$modificarindividuo_id'");
		$conteo = mysql_num_rows($consulta);
		while ($resultado = mysql_fetch_array($consulta)) { 
			$modificar_consumo = $resultado["consum_hui"];
			$modificar_personas = $resultado["person_hui"];
			$modificar_factor = $resultado["codfac_hui"];
		?>
		<!-- Calculo de CO2 en tiempo de real -->
		<script>
		$(document).ready(function() {
			// CO2 al modificar
			// Ejecución inicial
			co2();
		    // Detección de cambios
		    $("form[name=huella_individual] input,form[name=huella_individual] select").keyup(co2).change(co2);
		    // Calculo de CO2
		    function co2(){
		        var vconsumo = $("#consumo").val();
		        var vperiodo = $("#listado_tiempos").val();
		        var vpersonas = $("#actualizar_personas").val();
		        var vfactor = $("#listado_factores").val();
		        var vtiempo = $("#tiempo_emision").val();
		        var co2total = ( vfactor * ( (vconsumo / vperiodo) / vpersonas) ) * vtiempo;
		        $("#actualizar_consumo").val(vconsumo / vperiodo);
		        if (co2total!="Infinity" && co2total) {
		            $("#co2total").val(co2total);
		        }else{
		            $("#co2total").val("");
		        }
		    }
		});
		</script>
		<!-- Título de criterio -->
		<h2><?php echo $modificarcriterio_nombre; ?></h2>
		<!-- Formulario -->
		<form name="huella_individual" method="post" action="huella.php">
			<fieldset>
				<!-- Criterio e individuo -->
				<input type="hidden" id="actualizarcriterio_id" name="actualizarcriterio_id" value="<?php echo $modificarcriterio_id; ?>">
				<input type="hidden" id="actualizarindividuo_id" name="actualizarindividuo_id" value="<?php echo $modificarindividuo_id; ?>">
				<div>
					<?php
					include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
					// Consulta
					$consultaCampo = mysql_query("SELECT * FROM factores WHERE codcri_fac='$modificarcriterio_id'");
					// Listado de opciones
					while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
						$abreviatura_medida = $resultadoCampo["abrmed_fac"];
					}
					?>
					<!-- Consumo -->
					<div class="seguido">
						<label for="consumo" title="Escribe tu consumo en <?php echo $abreviatura_medida; ?>, preferiblemente de una fuente fiable, por ejemplo un recibo">Consumo <?php echo $abreviatura_medida; ?>*: </label>
						<input type="text" title="<?php echo $resultado['nombre_med']; ?>" id="consumo" name="consumo" size="10" required autofocus data-validation="required length number" data-validation-length="min1" data-validation-allowing="float" value="<?php echo $modificar_consumo; ?>">
						<input type="hidden" id="actualizar_consumo" name="actualizar_consumo" value="<?php echo $modificar_consumo; ?>">
					</div>
					<!-- Tiempo en el que se produjo el consumo -->
					<div class="seguido">
						<label for="listado_tiempos" title="Selecciona el periodo del consumo. Si usase tu recibo, por ejemplo, debe corresponder al periodo del mismo, usualmente mensual">Por: </label>
						<select id="listado_tiempos" name="listado_tiempos">
						<?php
							include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
							// Consulta
							$consultaCampo = mysql_query("SELECT * FROM tiempos");
							// Listado de opciones
							while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
								echo '<option value="'.$resultadoCampo["valort_tie"].'">'.$resultadoCampo["nombre_tie"].'</option>';
							}
						?>
						</select>
					</div>
					<!-- Personas que comparten el consumo -->
					<div class="seguido">
						<label for="actualizar_personas" title="Escribe el n&uacute;mero de personas que comparten el consumo"># de personas*: </label>
						<input type="text" id="actualizar_personas" name="actualizar_personas" size="5" maxlength="10" required data-validation="required length custom" data-validation-length="1-10" data-validation-regexp="^([1-9]+)([0-9]*)$" value="<?php echo $modificar_personas; ?>">
					</div>
					<!-- Factores de emisión -->
					<div class="seguido">
						<label for="listado_factores" title="Selecciona el factor de emisi&oacute;n de alguna de las fuentes disponibles">Factor*: </label>
						<select id="listado_factores" name="listado_factores">
						<?php
							include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
							// Consulta
							$consultaCampo = mysql_query("SELECT * FROM factores INNER JOIN fuentes ON idefue_fac=idefue_fue WHERE codcri_fac='$modificarcriterio_id'");
							// Listado de opciones
							while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
								if ( $resultadoCampo["codfac_fac"] == $modificar_factor ){
									echo '<option value="'.$resultadoCampo["codfac_fac"].'" selected>'.$resultadoCampo["titulo_fue"].' ('.$resultadoCampo["tonco2_fac"].')</option>';
								} else {
									echo '<option value="'.$resultadoCampo["codfac_fac"].'">'.$resultadoCampo["titulo_fue"].' ('.$resultadoCampo["tonco2_fac"].')</option>';
								}
							}
						?>
						</select>
					</div>
					<!-- Emisión de CO2 -->
					<div class="seguido">
						<label for="co2total" title="Toneladas de CO2 equivalente">Tons CO2 eq:</label>
						<input id="co2total" name="co2total" title="Tu emisi&oacute;n de CO2 en este criterio" readonly="readonly" size="10" \>
					</div>
					<!-- Tiempo en que se quiere visualizar la emisión de C02 -->
					<div class="seguido">
						<label for="tiempo_emision" title="Unidad de tiempo de medici&oacute;n para el resultado">Generados por:</label>
						<select id="tiempo_emision" name="tiempo_emision" title="Selecciona una medida de tiempo">
						<?php
							include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
							// Consulta
							$consultaCampo = mysql_query("SELECT * FROM tiempos");
							// Listado de opciones
							while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
								echo '<option value="'.$resultadoCampo["valort_tie"].'">'.$resultadoCampo["nombre_tie"].'</option>';
							}
						?>
						</select>
					</div>
				</div>
			</fieldset>
			<input type="submit" value="Actualizar">
		</form>
		<?php
		// Incluimos la conexion a la base de datos para la consulta
		include_once("elementos/conexion.php");
		// Hacemos la consulta a la base de datos
		$consulta = mysql_query("SELECT * FROM ayudas WHERE codcri_ayu='$modificarcriterio_id'");
		// Recorremos el resultado de la consulta
		$conteo = mysql_num_rows($consulta);
		if ( $conteo != 0 ) {
			echo '<div id="mostrarayudas">';
			while ($resultado = mysql_fetch_array($consulta)) { 
				// Asignamos a variables el valor de cada registro
				$titulo = $resultado["titulo_ayu"];
				$codigocriterio = $resultado["codcri_ayu"];
				$contenidoayuda = $resultado["conayu_ayu"];
				// Mostramos los datos
				echo '
					<h2>'.$titulo.'</h2>
					<div>
					'.$contenidoayuda.'
					</div>';
			} 
			echo '</div>';
		} ?>
		<!-- Botón atrás -->
		<div id="menunavegacion"><ul><li><a href="huella.php" id="atras"><?php echo $atras; ?></a></li></ul></div>
	<?php }
	/***************** Guardar modificación ******************/
	} else if( isset($_POST['actualizarcriterio_id']) && isset($_POST['actualizarindividuo_id']) ) {
		
		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Recibimos los datos
		$actualizarcriterio_id = $_POST['actualizarcriterio_id'];
		$actualizarindividuo_id = $_POST['actualizarindividuo_id'];
		$actualizar_consumo = $_POST['actualizar_consumo'];
		$actualizar_personas = $_POST['actualizar_personas'];
		$actualizar_factor = $_POST['listado_factores'];
		// Actualizamos los datos
		$actualiza = mysql_query("UPDATE huella_individual SET consum_hui='$actualizar_consumo',person_hui='$actualizar_personas',codfac_hui='$actualizar_factor' WHERE codind_hui='$actualizarindividuo_id' AND codcri_hui='$actualizarcriterio_id'",$conexion) or die (mysql_error());
		header('location:huella.php'); // Redirigimos
	/***************** Eliminar ******************/
	} else if( isset($_POST['eliminarcriterio_id']) && isset($_POST['eliminarindividuo_id']) ) {
		
		include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
		// Recibimos los datos
		$id_usuario = $_SESSION['id_usuario'];
		$eliminarcriterio_id = $_POST['eliminarcriterio_id'];
		$eliminarindividuo_id = $_POST['eliminarindividuo_id'];
		if ($id_usuario == $eliminarindividuo_id) {
			// Eliminamos los datos
			$elimina = mysql_query("DELETE FROM huella_individual WHERE codcri_hui='$eliminarcriterio_id' AND codind_hui='$eliminarindividuo_id'") or die (mysql_error());
			header('location:huella.php'); // Redirigimos
		}else{
			echo '<script type="text/javascript">alert("Error. Acción prohibida.");
			window.location ="huella.php";</script>'; // Indicamos el error y redirigimos
		}
	/***************** Menú ******************/
	} else { ?>
		<script>
		$(document).ready(function() {
		    // CO2 general
			// Ejecución inicial
			co2general();
		    // Detección de cambios
		    $("select[name=tiempo]").change(co2general);
		    // Calculo de CO2
		    function co2general(){
				$("fieldset[name^=criterios]").each(function(indice) {
					var vconsumo = $("input[name=consumo\\["+indice+"\\]]").val();
					var vpersonas = $("input[name=personas\\["+indice+"\\]]").val();
					var vfactor = $("input[name=factor\\["+indice+"\\]]").val();
					var vperiodo = $("input[name=periodo\\["+indice+"\\]]").val();
					var vtiempo = $("select[name='tiempo']").val();
					var co2total = ( vfactor * ( (vconsumo / vperiodo) / vpersonas) ) * vtiempo;
			        if (co2total!="Infinity" && co2total) {
			            $("input[name=emision\\["+indice+"\\]]").val(co2total);
			        }else{
			            $("input[name=emision\\["+indice+"\\]]").val("");
			        }
				});
			}
		});
		</script>
		<h2>Huella de carbono</h2>
		<ul class="menu_interno">
			<li><a href="huella.php?m=agregar" class="registrar">Agregar criterio</a></li>
		</ul>
		<div id="huella_general">
			<?php 
			include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
			// Recibimos los datos
			$id_usuario = $_SESSION['id_usuario'];
			// Hacemos la consulta
			$consulta = mysql_query("SELECT * FROM huella_individual INNER JOIN criterios ON codcri_hui=codcri_cri INNER JOIN individuos ON codind_hui=codind_ind LEFT JOIN (factores INNER JOIN fuentes ON idefue_fac=idefue_fue) ON codfac_hui=codfac_fac WHERE codind_hui='$id_usuario'");
			// Listado de resultados
			$conteo = mysql_num_rows($consulta);
			if ( $conteo != 0 ) {
				?>
				<!-- Tiempo en que se quiere visualizar la emisión de C02 -->
				<div>
					<label title="Unidad de tiempo de medici&oacute;n para el resultado">Ver emisi&oacute;n generada por:</label>
					<select name="tiempo" title="Selecciona una medida de tiempo">
					<?php
						include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
						// Consulta
						$consultaCampo = mysql_query("SELECT * FROM tiempos");
						// Listado de opciones
						while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
							if ($resultadoCampo["valort_tie"]=="1"){
								echo '<option selected value="'.$resultadoCampo["valort_tie"].'">'.$resultadoCampo["nombre_tie"].'</option>';
							}else{
								echo '<option value="'.$resultadoCampo["valort_tie"].'">'.$resultadoCampo["nombre_tie"].'</option>';
							}
						}
					?>
					</select>
				</div>
				<?php
				$i = 0;
				while ($resultado = mysql_fetch_array($consulta)) { ?>
				<fieldset name="criterios[<?php echo $i ?>]">
					<h3><?php echo $resultado['nombre_cri'] ?></h3>
					<?php if( $resultado['imagen_cri']!=null ){ echo '<img class="imagenCriterio" src="'.$resultado['imagen_cri'].'">'; } /* Imagen de criterio */ ?>
					<div class="aparte">
						<div>
							<label>Consumo: </label>
							<input name="consumo[<?php echo $i ?>]" type="hidden" readonly value="<?php if (isset($resultado['consum_hui'])) { echo $resultado['consum_hui']; } else { echo ''; }?>">
								<?php if (isset($resultado['consum_hui'])) {
									echo $resultado['consum_hui'].' '.$resultado["abrmed_fac"];
									include_once("elementos/conexion.php"); // Incluimos la conexion a la BD para la consulta
									// Consulta
									$consultaCampo = mysql_query("SELECT * FROM tiempos");
									// Listado de opciones
									while ($resultadoCampo = mysql_fetch_array($consultaCampo)) {
										if ($resultadoCampo["valort_tie"]=="1"){
											echo '<input name="periodo['.$i.']" type="hidden" readonly value="'.$resultadoCampo["valort_tie"].'"> por '.$resultadoCampo["nombre_tie"];
										}
									}
								} else {
									echo 'Sin especificar ';
								}
							?>
							<input name="personas[<?php echo $i ?>]" type="hidden" readonly value="<?php if (isset($resultado['person_hui'])) { echo $resultado['person_hui']; } else { echo ''; }?>">
						</div>
						<div>
							<label>Factor: </label>
							<input name="factor[<?php echo $i ?>]" type="hidden" readonly value="<?php if (isset($resultado['codfac_hui'])) { echo $resultado["tonco2_fac"]; } else { echo ''; }?>">
								<?php  
								if (isset($resultado['codfac_hui'])) {
									echo $resultado["titulo_fue"].' ('.$resultado["tonco2_fac"].' por '.$resultado["abrmed_fac"].')';
								} else {
									echo 'Sin especificar ';
								}?>
						</div>
						<!-- Emisión de CO2 -->
						<div class="seguido">
							<label title="Toneladas de CO2 equivalente">Tons CO2 eq:</label>
							<input type="text" title="Tu emisi&oacute;n de CO2 en este criterio" readonly="readonly" size="10" name="emision[<?php echo $i ?>]">
						</div>
					</div>
					<div class="botoneslistado aparte">
						<form name="huelladecarbono_ver" method="post" action="huella.php">
							<input type="hidden" id="modificarcriterio_nombre" name="modificarcriterio_nombre" value="<?php echo $resultado['nombre_cri']; ?>">
							<input type="hidden" id="modificarcriterio_id" name="modificarcriterio_id" value="<?php echo $resultado['codcri_hui']; ?>">
							<input type="hidden" id="modificarindividuo_id" name="modificarindividuo_id" value="<?php echo $resultado['codind_hui']; ?>">
							<input type="submit" value="Modificar">
						</form>
						<form name="huelladecarbono_ver" method="post" action="huella.php" onsubmit="return confirm('&iquest;Estas seguro(a) de eliminar el criterio de tu huella?');">
							<input type="hidden" id="eliminarcriterio_id" name="eliminarcriterio_id" value="<?php echo $resultado['codcri_hui']; ?>">
							<input type="hidden" id="eliminarindividuo_id" name="eliminarindividuo_id" value="<?php echo $resultado['codind_hui']; ?>">
							<input type="submit" value="Eliminar" class="eliminar">
						</form>
					</div>
				</fieldset>
				<?php 
				$i++;
				}
			} else {
				echo 'No hay criterios incluidos en tu huella de carbono';
			} 
			?>
		</div>
	<?php }
}
include('elementos/pie.php'); // Incluimos el pie
?>
