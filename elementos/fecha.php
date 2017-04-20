 <?
/* Script en PHP para mostrar la fecha del servidor web */
/* Definición de los meses del año en español */

$mes[0]="-";
$mes[1]="enero";
$mes[2]="febrero";
$mes[3]="marzo";
$mes[4]="abril";
$mes[5]="mayo";
$mes[6]="junio";
$mes[7]="julio";
$mes[8]="agosto";
$mes[9]="septiembre";
$mes[10]="octubre";
$mes[11]="noviembre";
$mes[12]="diciembre";

/* Definición de los días de la semana */

$dia[0]="Domingo";
$dia[1]="Lunes";
$dia[2]="Martes";
$dia[3]="Miércoles";
$dia[4]="Jueves";
$dia[5]="Viernes";
$dia[6]="Sábado";

/* Implementación de las variables que calculan la fecha */

$gisett=(int)date("w");
$mesnum=(int)date("m");

/* Variable que calcula la hora */

$hora = date(" H:i",time());

/* Presentación de los resultados en una forma similar a la siguiente: Miércoles, 23 de junio de 2004 | 17:20 */

echo $dia[$gisett].", ".date("d")." de ".$mes[$mesnum]." de ".date("Y")." | ".$hora;
?> 