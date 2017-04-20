				<div id="carga" align="center">
					<img src="imagenes/cargando.gif"></img>
				</div>
				</div>
			</div>
		</div>
		<div id="footer">
			<div>
				<?php 
				// Incluimos la conexion a la base de datos para la consulta
				include_once("elementos/conexion.php");
				// Hacemos la consulta a la base de datos
				$consulta = mysql_query("SELECT codpag_pag,titulo_pag FROM paginas WHERE piepag_pag=1") or die( mysql_error() );
				// Recorremos el resultado de la consulta
				while ($resultado = mysql_fetch_assoc($consulta)) { 
					// Asignamos a variables el valor de cada registro
					$codigo = $resultado["codpag_pag"];
					$titulo = $resultado["titulo_pag"];
					// Mostramos los datos
					echo '<a href="paginas.php?p='.$codigo.'">'.$titulo.'</a> | ';
				} 
				?>
			</div>
		</div>
	</div>
</body>

</html> 