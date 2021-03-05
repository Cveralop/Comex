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
#Registro inicio LOG'S Carga Sub - Contable
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_loginicio = "INSERT INTO logs_tareas_manuales (tarea, descripcion_tarea, fecha_hora_inicio)
SELECT 'Carga Sub - Contable', 'Carga subsidiario del dia', current_timestamp()";
$loginicio = mysqli_query($comercioexterior, $query_loginicio) or die(mysqli_error($comercioexterior));
#Borrar Base Vcto Sub - Contable Transit
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "TRUNCATE TABLE `subcontabletransit`";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error($comercioexterior));
#Borrar Base Vcto Sub - Contable
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "TRUNCATE TABLE `subcontable`";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error($comercioexterior));
#Cargar Archivo en Sub - Contable Transitorio
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "LOAD DATA LOCAL INFILE 'd:\\\\comercioexterior\\\\subcontable\\\\subsidiario.csv' REPLACE INTO TABLE subcontabletransit FIELDS TERMINATED BY ';' ignore 1 lines";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error($comercioexterior));
#Reemplazo de Puntos en Valores con Montos Sub - Contable Transitorio
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_replacepunto = "UPDATE subcontabletransit SET date_proceso = DATE(STR_TO_DATE(date_proceso,'%d/%m/%Y')), monto_debe = replace(monto_debe,'.',''), monto_haber = replace(monto_haber,'.',''), monto_debe = replace(monto_debe,',','.') , monto_haber = replace(monto_haber,',','.')";
$replacepunto = mysqli_query($comercioexterior, $query_replacepunto) or die(mysqli_error($comercioexterior));
#Cargar Base Sub - Contable desde Base Sub - Contable Transitorio
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_excepciones = sprintf("INSERT INTO subcontable (date_proceso, oficina_origen, oficina_destino, moneda, cuenta_contable, nro_operacion, rut_cliente, nombre_cliente, codigo_evento, nombre_evento, nro_traspaso, monto_debe, monto_haber)
SELECT subcontabletransit.date_proceso, subcontabletransit.oficina_origen, subcontabletransit.oficina_destino, subcontabletransit.moneda, subcontabletransit.cuenta_contable, subcontabletransit.nro_operacion, subcontabletransit.rut_cliente, subcontabletransit.nombre_cliente, subcontabletransit.codigo_evento, subcontabletransit.nombre_evento, subcontabletransit.nro_traspaso, subcontabletransit.monto_debe, subcontabletransit.monto_haber FROM subcontabletransit group by nro_operacion", GetSQLValueString($colname_excepciones, "text"),GetSQLValueString($colname1_excepciones, "text"),GetSQLValueString($colname2_excepciones, "text"));
$excepciones = mysqli_query($comercioexterior, $query_excepciones) or die(mysqli_error($comercioexterior));
#Registro termino LOG´S Carga Sub - Contable
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_logtermino = "UPDATE logs_tareas_manuales SET fecha_hora_termino = current_timestamp() WHERE tarea = 'Carga Sub - Contable' and fecha_hora_inicio <= current_timestamp() ORDER BY fecha_hora_inicio DESC LIMIT 1";
$logtermino = mysqli_query($comercioexterior, $query_logtermino) or die(mysqli_error($comercioexterior));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sub - Contable</title>
<style type="text/css">
<!--
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
-->
</style>
</head>
<body>
<table width="95%" border="0" align="center">
  <tr>
    <td bgcolor="#FF0000">CARGA SUBSIDIARIO CONTABLE</td>
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
		      <td align="left" valign="middle" bgcolor="#FF0000"> ESTIMADO SEÑOR USUARIO INFORMO A USTEDED QUE EL SUBSIDIARIO CONTABLE DE BKT ESTA SIENDO CARGADO   DENTRO DE LOS PROXIMOS 
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
		  <br />
</form>
</body>
</html>
</body>
</html>