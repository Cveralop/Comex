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
$colname3_bei = "Si";
if (isset($_GET['segmento_comercial_pyme'])) {
  $colname3_bei = $_GET['segmento_comercial_pyme'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_bei = sprintf("SELECT producto,min(date_ingreso)as fechainicio, max(date_ingreso)as fechatermino, sum(cantidad_visadas)as visadas,  sum(cantidad_cursadas)as cursadas, sum(cantidad_reparadas)as reparadas, sum(cantidad_rechazadas)as rechazadas, sum(cantidad_dentrohorario)as dentrohorario, sum(cantidad_fuerahorario)as fuerahorario, sum(cantidad_excepciones)as excepciones, sum(monto_usd)as monto FROM panel_control_total nolock WHERE date_ingreso between %s and %s and segmento_comercial_pyme = %s GROUP BY producto ORDER BY producto DESC ", GetSQLValueString($colname1_bei, "date"),GetSQLValueString($colname2_bei, "date"),GetSQLValueString($colname3_bei, "text"));
$bei = mysqli_query($comercioexterior, $query_bei) or die(mysqli_error($comercioexterior));
$row_bei = mysqli_fetch_assoc($bei);
$totalRows_bei = mysqli_num_rows($bei);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Panel de Control - Detalle</title>
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
    <td colspan="2" align="center" valign="middle" bgcolor="#FF0000" class="titulopaguina">Panel de Control (DATHBOARD) PYME</td>
  </tr>
  <tr>
    <td width="16%" align="right" valign="middle">Fecha Desde:</td>
    <td width="84%" align="left" valign="middle">
    <?php if($row_bei != 0) { 
    echo $row_bei['fechainicio']; }?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Fecha Hasta:</td>
<td align="left" valign="middle">
<?php if($row_bei != 0) {
echo $row_bei['fechatermino']; }?></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="panel_control_mae_pyme.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen1','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen1" width="80" height="25" border="0" id="Imagen1" /></a></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
<td colspan="9" align="left" valign="middle" class="titulocolumnas"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><span class="titulo_menu">Detalle Informe Panel de Control - DathBoard Todos los Eventos</span></td>
  </tr>
  <tr>
    <td width="28%" align="center" valign="middle" class="titulocolumnas">Producto</td>
    <td width="12%" align="center" valign="middle" class="titulocolumnas">OP. Visadas</td>
    <td width="12%" align="center" valign="middle" class="titulocolumnas">OP. Cursadas</td>
    <td width="12%" align="center" valign="middle" class="titulocolumnas">OP. Reparadas</td>
    <td width="12%" align="center" valign="middle" class="titulocolumnas">OP. Rechazadas</td>
    <td width="12%" align="center" valign="middle" class="titulocolumnas">OP. Dentro Horario</td>
    <td width="12%" align="center" valign="middle" class="titulocolumnas">OP.  Fuera Horario</td>
    <td width="12%" align="center" valign="middle" class="titulocolumnas">Op. Excepcionadas</td>
    <td width="12%" align="center" valign="middle" class="titulocolumnas">Monto en MMU$D</td>
  </tr>
  <?php if($row_bei != 0) { ?>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo strtoupper($row_bei['producto']); ?></td>
      <td align="center" valign="middle"><?php echo number_format($row_bei['visadas'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo number_format($row_bei['cursadas'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo number_format($row_bei['reparadas'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo number_format($row_bei['rechazadas'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo number_format($row_bei['dentrohorario'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo number_format($row_bei['fuerahorario'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo number_format($row_bei['excepciones'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle"><?php echo number_format(($row_bei['monto']/1000), 0, ',', '.'); ?></td>
    </tr>
    <?php } while ($row_bei = mysqli_fetch_assoc($bei)); ?>
  <?php } ?>
</table>
<br />
</body>
</html>
<?php
mysqli_free_result($bei);
?>