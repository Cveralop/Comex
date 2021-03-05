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

$colname1_bei = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_bei = $_GET['date_ini'];
}
$colname2_bei = "-1";
if (isset($_GET['date_fin'])) {
  $colname2_bei = $_GET['date_fin'];
}
$colname3_bei = "0";
if (isset($_GET['tiempo_evento'])) {
  $colname3_bei = $_GET['tiempo_evento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_bei = sprintf("SELECT producto, min(date_ingreso)as date_ini, max(date_ingreso)as date_fin, evento, count(evento)as cantidad, tiempo_evento FROM base_operaciones nolock WHERE date_ingreso between %s and %s and tiempo_evento > %s GROUP BY producto, evento ORDER BY producto, evento DESC", GetSQLValueString($colname1_bei, "date"),GetSQLValueString($colname2_bei, "date"),GetSQLValueString($colname3_bei, "int"));
$bei = mysqli_query($comercioexterior, $query_bei) or die(mysqli_error($comercioexterior));
$row_bei = mysqli_fetch_assoc($bei);
$totalRows_bei = mysqli_num_rows($bei);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Liena de Gastos Total - Detalle</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #000;
	font-weight: bold;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%" border="0" align="center">
  <tr>
    <td colspan="2" align="center" valign="middle" bgcolor="#FF0000" class="titulopaguina">LINEA DE GASTOS TOTAL</td>
  </tr>
  <tr>
    <td width="16%" align="right" valign="middle">Fecha Desde:</td>
    <td width="84%" align="left" valign="middle">
    <?php if($row_bei !=0) {
    echo $row_bei['date_ini']; }?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Fecha Hasta:</td>
<td align="left" valign="middle">
<?php if($row_bei !=0) {
echo $row_bei['date_fin']; }?></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="linea_gastomae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen1','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen1" width="80" height="25" border="0" id="Imagen1" /></a></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
<td colspan="5" align="left" valign="middle" class="titulocolumnas"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><span class="titulo_menu">Linea Gastos Total</span></td>
  </tr>
  <tr>
    <td width="40%" align="center" valign="middle" class="titulocolumnas">Producto</td>
    <td width="15%" align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td width="15%" align="center" valign="middle" class="titulocolumnas">Cantidad</td>
    <td width="15%" align="center" valign="middle" class="titulocolumnas">Tiempo</td>
    <td width="15%" align="center" valign="middle" class="titulocolumnas">Tiempo Total</td>
  </tr>
  <?php if($row_bei != 0) { ?>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo strtoupper($row_bei['producto']); ?></td>
      <td align="left" valign="middle"><?php echo $row_bei['evento']; ?></td>
      <td align="right" valign="middle"><?php echo number_format($row_bei['cantidad'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle"><?php echo $row_bei['tiempo_evento']; ?></td>
      <td align="right" valign="middle"><?php echo number_format(($row_bei['cantidad'] * $row_bei['tiempo_evento']) , 0, ',', '.'); ?></td>
    </tr>
    <?php } while ($row_bei = mysqli_fetch_assoc($bei)); ?>
  <?php } ?>
</table>
<br />
<br />
</body>
</html>
<?php
mysqli_free_result($bei);
?>