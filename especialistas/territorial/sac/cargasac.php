<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,TER";
$MM_donotCheckaccess = "false";
// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 
  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}
$MM_restrictGoTo = "../erroracceso.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
#Registro inicio LOG'S Carga SAC
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_loginicio = "INSERT INTO logs_tareas_manuales (tarea, descripcion_tarea, fecha_hora_inicio)
SELECT 'Carga SAC', 'Carga sac para distribucion bei', current_timestamp()";
$loginicio = mysqli_query($comercioexterior, $query_loginicio) or die(mysqli_error());
#Borrar Base SAC Tansitorio
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "TRUNCATE TABLE `sactransit`";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error());
#Borrar Base SAC
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "TRUNCATE TABLE `sac`";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error());
#Cargar Archivo en SAC Tansitorio
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "LOAD DATA LOCAL INFILE 'd:\\\\comercioexterior\\\\sac\\\\sac.csv' REPLACE INTO TABLE sactransit FIELDS TERMINATED BY ';' ignore 2 lines";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error());
#Reemplazo de Puntos en Valores en Rur Cliente SAC Tansitorio
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_replacepunto = "UPDATE sactransit SET rut_cliente= replace(rut_cliente,'.',''), rut_cliente= replace(rut_cliente,'-','')";
$replacepunto = mysqli_query($comercioexterior, $query_replacepunto) or die(mysqli_error());
#Cargar Base SAC desde Base SAC Transitorio
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_excepciones = sprintf("INSERT INTO sac (nro_req, fecha_inicio, fecha_creacion, rut_cliente, nombre_cliente, segmento, especialista, tipificacion, etapa_actual, estado_gestion_etapa, tiempo_estandar_etapa, unidad_actual, ingresado_por, punto_contacto, lugar_contacto)
SELECT sactransit.nro_req, sactransit.fecha_inicio, sactransit.fecha_creacion, sactransit.rut_cliente, sactransit.nombre_cliente, cliente.segmento, cliente.especialista, sactransit.tipificacion, sactransit.etapa_actual, sactransit.estado_gestion_etapa, sactransit.tiempo_estandar_etapa, sactransit.unidad_actual, sactransit.ingresado_por, sactransit.punto_contacto, sactransit.lugar_contacto FROM sactransit LEFT JOIN cliente ON sactransit.rut_cliente = cliente.rut_cliente", GetSQLValueString($colname_excepciones, "text"),GetSQLValueString($colname1_excepciones, "text"),GetSQLValueString($colname2_excepciones, "text"));
$excepciones = mysqli_query($comercioexterior, $query_excepciones) or die(mysqli_error($comercioexterior));
#Registro termino LOG'S Carga SAC
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_logtermino = "UPDATE logs_tareas_manuales SET fecha_hora_termino = current_timestamp() WHERE tarea = 'Carga SAC' and fecha_hora_inicio <= current_timestamp() ORDER BY fecha_hora_inicio DESC LIMIT 1";
$logtermino = mysqli_query($comercioexterior, $query_logtermino) or die(mysqli_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 24px;
	color: #FFF;
	font-weight: bold;
}
body {
	background-color: #F00;
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 24px;
	color: #FFF;
}
a:link {
	text-decoration: none;
	color: #F00;
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
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="95%" border="0" align="center">
  <tr>
    <td bgcolor="#FF0000">CARGA SAC</td>
  </tr>
</table>
<br />
<br />
<br />
<form name="fcuentareg" id="fcuentareg">
  <table width="95%" border="0" align="center">
    <tr>
      <td align="left" valign="middle" bgcolor="#FF0000"> ESTIMADO SEÑOR USUARIO INFORMO A USTEDED QUE LOS SAC ESTAN  SIENDO CARGADO   DENTRO DE LOS PROXIMOS
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
      <td align="right" valign="middle"><a href="../ni.php">&lt;&lt;VOLVER&gt;&gt;</a></td>
    </tr>
  </table>
</form>
</body>
</html>