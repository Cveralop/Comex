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

$colname_cumplimiento = "-1";
if (isset($_GET['date_ini'])) {
  $colname_cumplimiento = $_GET['date_ini'];
}
$colname1_cumplimiento = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_cumplimiento = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cumplimiento = sprintf("SELECT *, (((sum(cursadas)+sum(reparadas))/sum(recibidas))*100)as pct, min(date_ingreso)as fechainicio, max(date_ingreso)as fechatermino, sum(recibidas)as rec, sum(cursadas)as cur, sum(reparadas)as rep, sum(pendientes)as pen FROM cumplimiento_operaciones_dia nolock WHERE date_ingreso between %s and %s GROUP BY producto, evento ORDER BY date_ingreso, producto, evento ASC", GetSQLValueString($colname_cumplimiento, "date"),GetSQLValueString($colname1_cumplimiento, "date"));
$cumplimiento = mysqli_query($comercioexterior, $query_cumplimiento) or die(mysqli_error($comercioexterior));
$row_cumplimiento = mysqli_fetch_assoc($cumplimiento);
$totalRows_cumplimiento = mysqli_num_rows($cumplimiento);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cumplimiento Curse Operaciones</title>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #F00;
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
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td height="21" align="center" valign="middle" bgcolor="#FF0000" class="titulopaguina">CUMPLIMIENTO CURSE OPERACIONES RECIBIDAS HASTA LAS 15:00 HRS</td>
  </tr>
  <tr>
    <td height="21" align="center" valign="middle" bgcolor="#FF0000" class="titulopaguina">Fecha Desde <?php echo $row_cumplimiento['fechainicio']; ?> Hasta <?php echo $row_cumplimiento['fechatermino']; ?></td>
  </tr>
</table>
<br />
<?php //if ($row_cumplimiento != 0) {   ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td class="titulocolumnas">Producto</td>
    <td class="titulocolumnas">Evento</td>
    <td class="titulocolumnas">Operaciones Recibidas</td>
    <td class="titulocolumnas">Operaciones Cursadas</td>
    <td class="titulocolumnas">Operaciones Reparadas</td>
    <td class="titulocolumnas">Operaciones Pendientes</td>
    <td class="titulocolumnas"> % Cumplimiento</td>
  </tr>
 
  <?php do { ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna"><?php echo $row_cumplimiento['producto']; ?></td>
      <td align="left" valign="middle" class="respuestacolumna"><?php echo $row_cumplimiento['evento']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_cumplimiento['rec']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_cumplimiento['cur']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_cumplimiento['rep']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_cumplimiento['pen']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_cumplimiento['pct'], 2, ',', '.'); ?> %</td>
    </tr>
    <?php } while ($row_cumplimiento = mysqli_fetch_assoc($cumplimiento)); ?>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="cumplimiento_curse_operaciones_mes_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen1','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen1" width="80" height="25" border="0" id="Imagen1" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($cumplimiento);
?>