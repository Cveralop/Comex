<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=operaciones_reparadas.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0");
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

$colname_reparadas = "-1";
if (isset($_GET['date_ini'])) {
  $colname_reparadas = $_GET['date_ini'];
}
$colname1_reparadas = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_reparadas = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_reparadas = sprintf("SELECT * FROM cumplimiento_operaciones_dia_reparos nolock WHERE date_ingreso between %s and %s", GetSQLValueString($colname_reparadas, "date"),GetSQLValueString($colname1_reparadas, "date"));
$reparadas = mysqli_query($comercioexterior, $query_reparadas) or die(mysqli_error($comercioexterior));
$row_reparadas = mysqli_fetch_assoc($reparadas);
$totalRows_reparadas = mysqli_num_rows($reparadas);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Operaciones Reparadas - Detalle</title>
<style type="text/css">
<!--
@import url("../../estilos/estilo12.css");
.Estilo2 {font-size: 9px; color: #0000FF; }
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000;
}
body {
	background-image: url();
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000;
	font-weight: bold;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
-->
</style>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
</head>
<body>
<table width="95%" border="1" align="center" bordercolor="#666666">
  <tr>
    <td colspan="17" align="left" valign="middle">Son un total de <?php echo $totalRows_reparadas ?> Operaciones</td>
  </tr>
  <tr>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Operador</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Estado</td>
    <td align="center" valign="middle">Reparo</td>
    <td align="center" valign="middle">Nro Operaci&oacute;n</td>
    <td align="center" valign="middle">Moneda / Monto Operaci&oacute;n</td>
    <td align="center" valign="middle">Urgente</td>
    <td align="center" valign="middle">Fuera Horario</td>
    <td align="center" valign="middle">Especialista NI</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Ejectutivo de Cuenta</td>
    <td align="center" valign="middle">Territorial</td>
  </tr>
  <?php if ($row_reparadas != 0) { ?>
   
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo strtoupper($row_reparadas['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_reparadas['nombre_cliente']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_reparadas['date_ingreso']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_reparadas['especialista_curse']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_reparadas['operador']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_reparadas['producto']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_reparadas['evento']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_reparadas['estado']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_reparadas['reparo_obs']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_reparadas['nro_operacion']); ?></td>
      <td align="right" valign="middle"><?php echo strtoupper($row_reparadas['moneda_operacion'])?><?php echo number_format($row_reparadas['monto_operacion'], 2, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_reparadas['urgente']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_reparadas['fuera_horario']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_reparadas['especialista_ni']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_reparadas['ejecutivo_ni']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_reparadas['ejecutivo_cuenta']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_reparadas['territorial']); ?></td>
    </tr>
<?php } while ($row_reparadas = mysqli_fetch_assoc($reparadas)); ?>
  <?php } ?>
</table>
</body>
</html>
<?php
mysqli_free_result($reparadas);
?>