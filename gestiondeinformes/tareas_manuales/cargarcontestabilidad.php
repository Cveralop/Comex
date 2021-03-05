<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  global $comercioexterior;

  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($comercioexterior, $theValue) : mysqli_escape_string($comercioexterior, $theValue);
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
#Registro inicio LOG'S Contestabilidad
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_loginicio = "INSERT INTO logs_tareas_manuales (tarea, descripcion_tarea, fecha_hora_inicio)
SELECT 'Carga contestabilidad', 'Carga contestabilidad post venta', current_timestamp()";
$loginicio = mysqli_query($comercioexterior, $query_loginicio) or die(mysqli_error($comercioexterior));
#Borrar Contestabilidad Transitoria
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "TRUNCATE TABLE contestabilidad_transit";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error($comercioexterior));
#Borrar Contestabilidad
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "TRUNCATE TABLE contestabilidad";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error($comercioexterior));
#Carga Archivo Contestabilidad
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "LOAD DATA LOCAL INFILE 'd:\\\\comercioexterior\\\\contestabilidad\\\\contestabilidad_goc.csv' REPLACE INTO TABLE contestabilidad_transit FIELDS TERMINATED BY ';' ignore 1 lines";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error($comercioexterior));
#Reemplazo de Puntos en Valores Contestabilidad Transitoria
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_replacepunto = "UPDATE contestabilidad_transit SET pct_contesta = replace(pct_contesta,'%','') , pct_contesta = replace(pct_contesta, ',', '.')";
$replacepunto = mysqli_query($comercioexterior, $query_replacepunto) or die(mysqli_error($comercioexterior));
#Cargar Base Contestabilidad Desde Contestabilidad Transitoria
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_excepciones = sprintf("INSERT INTO contestabilidad (anexo, ll_recibida, pct_contesta, fecha_medicion, especialista_curse)
SELECT contestabilidad_transit.anexo, ll_recibida, pct_contesta, fecha_medicion, usuarios.nombre FROM contestabilidad_transit LEFT JOIN usuarios ON contestabilidad_transit.anexo = usuarios.anexo", GetSQLValueString($colname_excepciones, "text"),GetSQLValueString($colname1_excepciones, "text"),GetSQLValueString($colname2_excepciones, "text"));
$excepciones = mysqli_query($comercioexterior, $query_excepciones) or die(mysqli_error($comercioexterior));
mysqli_select_db($comercioexterior, $database_comercioexterior);
#Actualizar Base Estadistica Post Venta desde Banse Contestabilidad
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_excepciones = sprintf("UPDATE estadistica_postventa INNER JOIN contestabilidad ON estadistica_postventa.especialista_curse = contestabilidad.especialista_curse SET estadistica_postventa.pct_contesta = contestabilidad.pct_contesta", GetSQLValueString($colname_excepciones, "text"),GetSQLValueString($colname1_excepciones, "text"),GetSQLValueString($colname2_excepciones, "text"));
$excepciones = mysqli_query($comercioexterior, $query_excepciones) or die(mysqli_error($comercioexterior));
mysqli_select_db($comercioexterior, $database_comercioexterior);
#Registro termino LOG'S Contestabilidad
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_logtermino = "UPDATE logs_tareas_manuales SET fecha_hora_termino = current_timestamp() WHERE tarea = 'Carga contestabilidad' and fecha_hora_inicio <= current_timestamp() ORDER BY fecha_hora_inicio DESC LIMIT 1";
$logtermino = mysqli_query($comercioexterior, $query_logtermino) or die(mysqli_error($comercioexterior));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Carga Contestabilidad</title>
<style type="text/css">
@import url("../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 24px;
	color: #FFF;
	font-weight: bold;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
	background-color: #F00;
}
a:link {
	color: #F00;
	font-weight: bold;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #00F;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
a {
	font-size: 24px;
}
</style>
</head>
<body>
<table width="95%" border="0" align="center">
  <tr>
    <td bgcolor="#FF0000">CARGA CONTESTABILIDAD</td>
  </tr>
</table>
<br />
<br />
<br />
<html>
	<head>
<script> 
var segundos=5
var direccion='http://pdpto38:8303/comex/gestiondeinformes/gestiondeinformes.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<script language="javascript">
			var tiempo = 3;
			function cuentaRegresiva(){
				if (tiempo > 0){
				tiempo--
				}
				else{
				tiempo=0
				}
				document.fcuentareg.tiempoact.value=tiempo
				setTimeout("cuentaRegresiva()",1000)
			}
</script>
	<body onload="cuentaRegresiva()">
<form name="fcuentareg">
		  <table width="95%" border="0" align="center">
		    <tr>
		      <td align="left" valign="middle" bgcolor="#FF0000"> ESTIMADO SEÑOR USUARIO INFORMO A USTEDED QUE LA CONTESTABILIDAD ESTA SIENDO CARGADA   DENTRO DE LOS PROXIMOS 
	            <input name="tiempoact" type="text" class="nroregistro" size="3" maxlength="3" />	           
	          SEGUNDOS, CUANDO EL CONTADOR LLEGUE A CERO PUEDE REGRESAR AL MENU DE OPCIONES.</td>
	        </tr>
		    <tr>
		      <td align="left" valign="middle" bgcolor="#FF0000">ATTE, EL ADMINISTRADOR DEL GOC.</td>
	        </tr>
	      </table>
  <br />
		  <table width="95%" border="0" align="center">
		    <tr>
		      <td align="right" valign="middle"><a href="../gestiondeinformes.php">&lt;&lt;VOLVER&gt;&gt;</a></td>
	        </tr>
  </table>
</form>
</body>
</html>
</body>
</html>