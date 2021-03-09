<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM";
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
#Registro inicio LOG'S Carga Cartera
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_loginicio = "INSERT INTO logs_tareas_manuales (tarea, descripcion_tarea, fecha_hora_inicio)
SELECT 'Carga cartera', 'Carga cartera import. y export.', current_timestamp()";
$loginicio = mysqli_query($comercioexterior, $query_loginicio) or die(mysqli_error($comercioexterior));
#Borrar Base Cartera Operaciones
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_devengotransit = "TRUNCATE TABLE `carteraopera`";
$devengotransit = mysqli_query($comercioexterior, $query_devengotransit) or die(mysqli_error($comercioexterior));
#Cargar Base Cartera Operaciones
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "LOAD DATA LOCAL INFILE 'd:\\\\comercioexterior\\\\cartera\\\\cartera.csv' REPLACE INTO TABLE carteraopera FIELDS TERMINATED BY ';' ignore 1 lines";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error($comercioexterior));
#Sacar Ceros a Campo Rut Cliente
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_borraceros = "UPDATE carteraopera SET `rut_cliente` = concat(cast(substring(rut_cliente,1,length(rut_cliente) -1) as SIGNED),
substring(rut_cliente,length(rut_cliente), 1))";
$borraceros = mysqli_query($comercioexterior, $query_borraceros) or die(mysqli_error($comercioexterior));
#Reemplazo de Fechas al Formato Americano
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_replacepunto = "UPDATE carteraopera SET fecha_otor = DATE(STR_TO_DATE(fecha_otor,'%d/%m/%Y')), fecha_vcto = DATE(STR_TO_DATE(fecha_vcto,'%d/%m/%Y'))";
$replacepunto = mysqli_query($comercioexterior, $query_replacepunto) or die(mysqli_error($comercioexterior));
#Registro Marca Informes Comercial
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_marcainformecom = "UPDATE carteraopera INNER JOIN cliente ON carteraopera.rut_cliente = cliente.rut_cliente SET
carteraopera.informe_comercial = cliente.informe_comercial";
$marcainformecom = mysql_query($query_marcainformecom, $comercioexterior) or die(mysqli_error($comercioexterior));
#Registro termino LOG´S Carga Cartera
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_logtermino = "UPDATE logs_tareas_manuales SET fecha_hora_termino = current_timestamp() WHERE tarea = 'Carga cartera' and fecha_hora_inicio <= current_timestamp() ORDER BY fecha_hora_inicio DESC LIMIT 1";
$logtermino = mysqli_query($comercioexterior, $query_logtermino) or die(mysqli_error($comercioexterior));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Carga Cartera Operaciones</title>
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
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 24px;
	color: #F00;
	font-weight: bold;
}
a:link {
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

</style>
<script> 
var segundos=5
var direccion='http://pdpto38:8303/comex/gestiondeinformes/gestiondeinformes.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<script language="JavaScript" type="text/javascript">
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
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>
<body onload="cuentaRegresiva()">
<table width="95%" border="0" align="center">
  <tr>
    <td align="center" bgcolor="#FF0000">CARGA CARTERA IMPORT. Y EXPORT.(BKT)</td>
  </tr>
</table>
<br />
<br />
<br />
<form name="fcuentareg" id="fcuentareg">
  <table width="95%" border="0" align="center">
    <tr>
      <td align="left" valign="middle" bgcolor="#FF0000"> ESTIMADO SEÑOR USUARIO INFORMO A USTEDED QUE CARTERA IMPORT. Y EXPORT. DE BKT ESTA SIENDO CARGADO   DENTRO DE LOS PROXIMOS
        <input name="tiempoact" type="text" class="nroregistro" size="3" maxlength="3" />
        SEGUNDOS, CUANDO EL CONTADOR LLEGUE A CERO PUEDE REGRESAR AL MENU DE OPCIONES.</td>
    </tr>
    <tr>
      <td align="left" valign="middle" bgcolor="#FF0000">ATTE, EL ADMINISTRADOR.</td>
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