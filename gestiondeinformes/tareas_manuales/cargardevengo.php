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
#Registro inicio LOG'S Carga Devengo
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_loginicio = "INSERT INTO logs_tareas_manuales (tarea, descripcion_tarea, fecha_hora_inicio)
SELECT 'Carga devengo', 'Carga documentos enviados a custodia', current_timestamp()";
$loginicio = mysqli_query($comercioexterior, $query_loginicio) or die(mysqli_error($comercioexterior));
#Borrar Base Devengo Transitorio
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_devengotransit = "TRUNCATE TABLE `devengotransit`";
$devengotransit = mysqli_query($comercioexterior, $query_devengotransit) or die(mysqli_error($comercioexterior));
#Borrar Base Devengo
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_vctooperaciones = "TRUNCATE TABLE `devengo`";
$vctooperaciones = mysql_query($query_vctooperaciones, $comercioexterior) or die(mysqli_error($comercioexterior));
#Cargar Archivo en Base Devengo Transitorio
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "LOAD DATA LOCAL INFILE 'd:\\\\comercioexterior\\\\devengo\\\\devengo.csv' REPLACE INTO TABLE devengotransit FIELDS TERMINATED BY ';' ignore 1 lines";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error($comercioexterior));
#Reemplazo de Puntos en Valores con Montos Devengo Transitorio
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_replacepunto = "UPDATE devengotransit SET capital_original = replace(capital_original,'.','') , saldo_vigente = replace(saldo_vigente, '.', '') , tc = replace(tc,'.','') , importe_com = replace(importe_com,'.',''), capital_original = replace(capital_original,',','.'), saldo_vigente = replace(saldo_vigente,',','.'), tbc = replace(tbc,',','.'), sc = replace(sc,',','.'), tasa_final_cliente = replace(tasa_final_cliente,',','.'), tt = replace(tt,',','.'), dife = replace(dife,',','.'), tc = replace(tc,',','.'), importe_com = replace(importe_com,',','.'), fecha_vcto = DATE(STR_TO_DATE(fecha_vcto,'%d/%m/%Y')), fecha_desde = DATE(STR_TO_DATE(fecha_desde,'%d/%m/%Y')), fecha_hasta = DATE(STR_TO_DATE(fecha_hasta,'%d/%m/%Y')), intereses_al = DATE(STR_TO_DATE(intereses_al,'%d/%m/%Y'))";
$replacepunto = mysqli_query($comercioexterior, $query_replacepunto) or die(mysqli_error($comercioexterior));
#Sacar Ceros a Campo Rut Cliente
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_borraceros = "UPDATE devengotransit SET `rut_cliente` = concat(cast(substring(rut_cliente,1,length(rut_cliente) -1) as SIGNED),
substring(rut_cliente,length(rut_cliente), 1))";
$borraceros = mysqli_query($comercioexterior, $query_borraceros) or die(mysqli_error($comercioexterior));
#Cargar Base Devengo desde Base Devengo Transitorio
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_excepciones = sprintf("INSERT INTO devengo (sistema, rut_cliente, nombre_cliente, oficina, int_ganados, int_devengado, cta_activo_pasivo, tipo_operacion, nro_operacion, secuencia, moneda, capital_original, saldo_vigente, tbc, sc, tasa_final_cliente, tt, dife, fecha_vcto, fecha_desde, fecha_hasta, ultimo_pago, dias, tc, importe_com, intereses_al)
SELECT sistema, devengotransit.rut_cliente, devengotransit.nombre_cliente, devengotransit.oficina, int_ganados, int_devengado, cta_activo_pasivo, tipo_operacion, nro_operacion, secuencia, moneda, capital_original, saldo_vigente, tbc, sc, tasa_final_cliente, tt, dife, fecha_vcto, fecha_desde, fecha_hasta, ultimo_pago, dias, tc, importe_com, intereses_al FROM devengotransit ORDER BY fecha_desde, fecha_vcto, secuencia ASC", GetSQLValueString($colname_excepciones, "text"),GetSQLValueString($colname1_excepciones, "text"),GetSQLValueString($colname2_excepciones, "text"));
$excepciones = mysqli_query($comercioexterior, $query_excepciones) or die(mysqli_error($comercioexterior));
#Calculo dias de Cartera Vencida
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_carteracv = "UPDATE devengo SET dias_cv = (timestampdiff(day,fecha_vcto,curdate()))";
$carteracv = mysql_query($query_carteracv, $comercioexterior) or die(mysqli_error($comercioexterior));
#Registro termino LOG´S Carga Devengo
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_logtermino = "UPDATE logs_tareas_manuales SET fecha_hora_termino = current_timestamp() WHERE tarea = 'Carga devengo' and fecha_hora_inicio <= current_timestamp() ORDER BY fecha_hora_inicio DESC LIMIT 1";
$logtermino = mysqli_query($comercioexterior, $query_logtermino) or die(mysqli_error($comercioexterior));
#Registro inicio LOG'S Carga Vencimiento Operaciones
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_loginicio = "INSERT INTO logs_tareas_manuales (tarea, descripcion_tarea, fecha_hora_inicio)
SELECT 'Carga vctooperaciones', 'Carga vencimiento operaciones', current_timestamp()";
$loginicio = mysqli_query($comercioexterior, $query_loginicio) or die(mysqli_error($comercioexterior));
#Borrar Base Vcto Operaciones
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "TRUNCATE TABLE `vctooperaciones`";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error($comercioexterior));
#Cargar Base Vcto Operaciones desde Base Devengo Transitorio
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_excepciones = sprintf("INSERT INTO vctooperaciones (sistema, rut_cliente, nombre_cliente, oficina, int_ganados, int_devengado, cta_activo_pasivo, tipo_operacion, nro_operacion, secuencia, moneda, capital_original, saldo_vigente, tbc, sc, tasa_final_cliente, tt, dife, fecha_vcto, fecha_desde, fecha_hasta, ultimo_pago, dias, tc, importe_com, intereses_al, nombre_ejecutivo, rut_ejecutivo, especialista_ni, ejecutivo_ni,  ultima_linea, banca, segmento, sub_segmento, territorial, zonal, sucursal, cod_suc)
SELECT sistema, devengo.rut_cliente, devengo.nombre_cliente, devengo.oficina, int_ganados, int_devengado, cta_activo_pasivo, tipo_operacion, nro_operacion, secuencia, moneda, capital_original, saldo_vigente, tbc, sc, tasa_final_cliente, tt, dife, fecha_vcto, fecha_desde, fecha_hasta, ultimo_pago, dias, tc, importe_com, intereses_al, cliente.nombre_ejecutivo, cliente.rut_ejecutivo, cliente.especialista, cliente.ejecutivo, cliente.ultima_linea, cliente.banca, cliente.segmento, cliente.sub_segmento, cliente.territorial, cliente.zonal, cliente.oficina, cliente.sucursal FROM devengo LEFT JOIN cliente ON devengo.rut_cliente = cliente.rut_cliente GROUP BY nro_operacion, secuencia ORDER BY fecha_vcto ASC", GetSQLValueString($colname_excepciones, "text"),GetSQLValueString($colname1_excepciones, "text"),GetSQLValueString($colname2_excepciones, "text"));
$excepciones = mysqli_query($comercioexterior, $query_excepciones) or die(mysqli_error($comercioexterior));
#Registro termino LOG´S Carga Vencimiento Operaciones
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_logtermino = "UPDATE logs_tareas_manuales SET fecha_hora_termino = current_timestamp() WHERE tarea = 'Carga vctooperaciones' and fecha_hora_inicio <= current_timestamp() ORDER BY fecha_hora_inicio DESC LIMIT 1";
$logtermino = mysqli_query($comercioexterior, $query_logtermino) or die(mysqli_error($comercioexterior));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Carga Devengo</title>
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
-->
</style>
</head>
<body>
<table width="95%" border="0" align="center">
  <tr>
    <td bgcolor="#FF0000">CARGA DEVENGO</td>
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
		      <td align="left" valign="middle" bgcolor="#FF0000"> ESTIMADO SEÑOR USUARIO INFORMO A USTEDED QUE DEVENGO ESTA SIENDO CARGADO   DENTRO DE LOS PROXIMOS 
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