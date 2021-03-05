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

$colname_estadistica_prestamos = "-1";
if (isset($_GET['date_ini'])) {
  $colname_estadistica_prestamos = $_GET['date_ini'];
}
$colname1_estadistica_prestamos = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_estadistica_prestamos = $_GET['date_fin'];
}
$colname2_estadistica_prestamos = "Prestamos Stand Alone";
if (isset($_GET['producto'])) {
  $colname2_estadistica_prestamos = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_estadistica_prestamos = sprintf("SELECT *, min(date_curse)as fechainicio, max(date_curse)as fechatermino, SUM(cantidad_cursadas)as opcur, SUM(cantidad_reparadas_ope)as opresop, (((SUM(cantidad_reparadas_ope))/SUM(cantidad_cursadas))*100)as pctrep, SUM(cantidad_urgentes)as opurg, SUM(cantidad_fuerahora)as opfh, ((SUM(cantidad_urgentes)/SUM(cantidad_cursadas))*100)as pcturg, ((SUM(cantidad_fuerahora)/SUM(cantidad_cursadas))*100)as pctfh FROM estadistica_operaciones nolock WHERE date_curse BETWEEN %s AND %s AND producto = %s GROUP BY operador, producto ORDER BY SUM(cantidad_cursadas) DESC", GetSQLValueString($colname_estadistica_prestamos, "date"),GetSQLValueString($colname1_estadistica_prestamos, "date"),GetSQLValueString($colname2_estadistica_prestamos, "text"));
$estadistica_prestamos = mysqli_query($comercioexterior, $query_estadistica_prestamos) or die(mysqli_error($comercioexterior));
$row_estadistica_prestamos = mysqli_fetch_assoc($estadistica_prestamos);
$totalRows_estadistica_prestamos = mysqli_num_rows($estadistica_prestamos);

$colname_estadistica_meco = "-1";
if (isset($_GET['date_ini'])) {
  $colname_estadistica_meco = $_GET['date_ini'];
}
$colname1_estadistica_meco = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_estadistica_meco = $_GET['date_fin'];
}
$colname2_estadistica_meco = "Mercado Corredores";
if (isset($_GET['producto'])) {
  $colname2_estadistica_meco = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_estadistica_meco = sprintf("SELECT *, min(date_curse)as fechainicio, max(date_curse)as fechatermino, SUM(cantidad_cursadas)as opcur, SUM(cantidad_reparadas_ope)as opresop, (((SUM(cantidad_reparadas_ope))/SUM(cantidad_cursadas))*100)as pctrep, SUM(cantidad_urgentes)as opurg, SUM(cantidad_fuerahora)as opfh, ((SUM(cantidad_urgentes)/SUM(cantidad_cursadas))*100)as pcturg, ((SUM(cantidad_fuerahora)/SUM(cantidad_cursadas))*100)as pctfh FROM estadistica_operaciones WHERE date_curse BETWEEN %s AND %s AND producto = %s GROUP BY operador, producto ORDER BY SUM(cantidad_cursadas) DESC", GetSQLValueString($colname_estadistica_meco, "date"),GetSQLValueString($colname1_estadistica_meco, "date"),GetSQLValueString($colname2_estadistica_meco, "text"));
$estadistica_meco = mysqli_query($comercioexterior, $query_estadistica_meco) or die(mysqli_error($comercioexterior));
$row_estadistica_meco = mysqli_fetch_assoc($estadistica_meco);
$totalRows_estadistica_meco = mysqli_num_rows($estadistica_meco);

$colname_estadistica_cci = "-1";
if (isset($_GET['date_ini'])) {
  $colname_estadistica_cci = $_GET['date_ini'];
}
$colname1_estadistica_cci = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_estadistica_cci = $_GET['date_fin'];
}
$colname2_estadistica_cci = "Carta de Credito Import";
if (isset($_GET['producto'])) {
  $colname2_estadistica_cci = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_estadistica_cci = sprintf("SELECT *, min(date_curse)as fechainicio, max(date_curse)as fechatermino, SUM(cantidad_cursadas)as opcur, SUM(cantidad_reparadas_ope)as opresop, (((SUM(cantidad_reparadas_ope))/SUM(cantidad_cursadas))*100)as pctrep, SUM(cantidad_urgentes)as opurg, SUM(cantidad_fuerahora)as opfh, ((SUM(cantidad_urgentes)/SUM(cantidad_cursadas))*100)as pcturg, ((SUM(cantidad_fuerahora)/SUM(cantidad_cursadas))*100)as pctfh FROM estadistica_operaciones WHERE date_curse BETWEEN %s AND %s AND producto = %s GROUP BY operador, producto ORDER BY SUM(cantidad_cursadas) DESC", GetSQLValueString($colname_estadistica_cci, "date"),GetSQLValueString($colname1_estadistica_cci, "date"),GetSQLValueString($colname2_estadistica_cci, "text"));
$estadistica_cci = mysqli_query($comercioexterior, $query_estadistica_cci, ) or die(mysqli_error($comercioexterior));
$row_estadistica_cci = mysqli_fetch_assoc($estadistica_cci);
$totalRows_estadistica_cci = mysqli_num_rows($estadistica_cci);

$colname_estadistica_cbi = "-1";
if (isset($_GET['date_ini'])) {
  $colname_estadistica_cbi = $_GET['date_ini'];
}
$colname1_estadistica_cbi = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_estadistica_cbi = $_GET['date_fin'];
}
$colname2_estadistica_cbi = "Cobranza Extranjera de Import";
if (isset($_GET['producto'])) {
  $colname2_estadistica_cbi = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_estadistica_cbi = sprintf("SELECT *, min(date_curse)as fechainicio, max(date_curse)as fechatermino, SUM(cantidad_cursadas)as opcur, SUM(cantidad_reparadas_ope)as opresop, (((SUM(cantidad_reparadas_ope))/SUM(cantidad_cursadas))*100)as pctrep, SUM(cantidad_urgentes)as opurg, SUM(cantidad_fuerahora)as opfh, ((SUM(cantidad_urgentes)/SUM(cantidad_cursadas))*100)as pcturg, ((SUM(cantidad_fuerahora)/SUM(cantidad_cursadas))*100)as pctfh FROM estadistica_operaciones WHERE date_curse BETWEEN %s AND %s AND producto = %s GROUP BY operador, producto ORDER BY SUM(cantidad_cursadas) DESC", GetSQLValueString($colname_estadistica_cbi, "date"),GetSQLValueString($colname1_estadistica_cbi, "date"),GetSQLValueString($colname2_estadistica_cbi, "text"));
$estadistica_cbi = mysqli_query($comercioexterior, $query_estadistica_cbi) or die(mysqli_error($comercioexterior));
$row_estadistica_cbi = mysqli_fetch_assoc($estadistica_cbi);
$totalRows_estadistica_cbi = mysqli_num_rows($estadistica_cbi);

$colname_estadistica_cce = "-1";
if (isset($_GET['date_ini'])) {
  $colname_estadistica_cce = $_GET['date_ini'];
}
$colname1_estadistica_cce = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_estadistica_cce = $_GET['date_fin'];
}
$colname2_estadistica_cce = "Carta de Credito Export";
if (isset($_GET['producto'])) {
  $colname2_estadistica_cce = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_estadistica_cce = sprintf("SELECT *, min(date_curse)as fechainicio, max(date_curse)as fechatermino, SUM(cantidad_cursadas)as opcur, SUM(cantidad_reparadas_ope)as opresop, (((SUM(cantidad_reparadas_ope))/SUM(cantidad_cursadas))*100)as pctrep, SUM(cantidad_urgentes)as opurg, SUM(cantidad_fuerahora)as opfh, ((SUM(cantidad_urgentes)/SUM(cantidad_cursadas))*100)as pcturg, ((SUM(cantidad_fuerahora)/SUM(cantidad_cursadas))*100)as pctfh FROM estadistica_operaciones WHERE date_curse BETWEEN %s AND %s AND producto = %s GROUP BY operador, producto ORDER BY SUM(cantidad_cursadas) DESC", GetSQLValueString($colname_estadistica_cce, "date"),GetSQLValueString($colname1_estadistica_cce, "date"),GetSQLValueString($colname2_estadistica_cce, "text"));
$estadistica_cce = mysqli_query($comercioexterior, $query_estadistica_cce) or die(mysqli_error($comercioexterior));
$row_estadistica_cce = mysqli_fetch_assoc($estadistica_cce);
$totalRows_estadistica_cce = mysqli_num_rows($estadistica_cce);

$colname_estadistica_cbe = "-1";
if (isset($_GET['date_ini'])) {
  $colname_estadistica_cbe = $_GET['date_ini'];
}
$colname1_estadistica_cbe = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_estadistica_cbe = $_GET['date_fin'];
}
$colname2_estadistica_cbe = "Cobranza Extranjera de Export";
if (isset($_GET['producto'])) {
  $colname2_estadistica_cbe = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_estadistica_cbe = sprintf("SELECT *, min(date_curse)as fechainicio, max(date_curse)as fechatermino, SUM(cantidad_cursadas)as opcur, SUM(cantidad_reparadas_ope)as opresop, (((SUM(cantidad_reparadas_ope))/SUM(cantidad_cursadas))*100)as pctrep, SUM(cantidad_urgentes)as opurg, SUM(cantidad_fuerahora)as opfh, ((SUM(cantidad_urgentes)/SUM(cantidad_cursadas))*100)as pcturg, ((SUM(cantidad_fuerahora)/SUM(cantidad_cursadas))*100)as pctfh FROM estadistica_operaciones WHERE date_curse BETWEEN %s AND %s AND producto = %s GROUP BY operador, producto ORDER BY SUM(cantidad_cursadas) DESC", GetSQLValueString($colname_estadistica_cbe, "date"),GetSQLValueString($colname1_estadistica_cbe, "date"),GetSQLValueString($colname2_estadistica_cbe, "text"));
$estadistica_cbe = mysqli_query($comercioexterior, $query_estadistica_cbe) or die(mysqli_error($comercioexterior));
$row_estadistica_cbe = mysqli_fetch_assoc($estadistica_cbe);
$totalRows_estadistica_cbe = mysqli_num_rows($estadistica_cbe);

$colname_estadistica_cambio = "-1";
if (isset($_GET['date_ini'])) {
  $colname_estadistica_cambio = $_GET['date_ini'];
}
$colname1_estadistica_cambio = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_estadistica_cambio = $_GET['date_fin'];
}
$colname2_estadistica_cambio = "DL600-CapXIII-CAPXIV";
if (isset($_GET['producto'])) {
  $colname2_estadistica_cambio = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_estadistica_cambio = sprintf("SELECT *, min(date_curse)as fechainicio, max(date_curse)as fechatermino, SUM(cantidad_cursadas)as opcur, SUM(cantidad_reparadas_ope)as opresop, (((SUM(cantidad_reparadas_ope))/SUM(cantidad_cursadas))*100)as pctrep, SUM(cantidad_urgentes)as opurg, SUM(cantidad_fuerahora)as opfh, ((SUM(cantidad_urgentes)/SUM(cantidad_cursadas))*100)as pcturg, ((SUM(cantidad_fuerahora)/SUM(cantidad_cursadas))*100)as pctfh FROM estadistica_operaciones WHERE date_curse BETWEEN %s AND %s AND producto = %s GROUP BY operador, producto ORDER BY SUM(cantidad_cursadas) DESC", GetSQLValueString($colname_estadistica_cambio, "date"),GetSQLValueString($colname1_estadistica_cambio, "date"),GetSQLValueString($colname2_estadistica_cambio, "text"));
$estadistica_cambio = mysqli_query($comercioexterior, $query_estadistica_cambio) or die(mysqli_error($comercioexterior));
$row_estadistica_cambio = mysqli_fetch_assoc($estadistica_cambio);
$totalRows_estadistica_cambio = mysqli_num_rows($estadistica_cambio);

$colname_estadistica_bga = "-1";
if (isset($_GET['date_ini'])) {
  $colname_estadistica_bga = $_GET['date_ini'];
}
$colname1_estadistica_bga = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_estadistica_bga = $_GET['date_fin'];
}
$colname2_estadistica_bga = "Boleta de Garantia";
if (isset($_GET['producto'])) {
  $colname2_estadistica_bga = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_estadistica_bga = sprintf("SELECT *, min(date_curse)as fechainicio, max(date_curse)as fechatermino, SUM(cantidad_cursadas)as opcur, SUM(cantidad_reparadas_ope)as opresop, (((SUM(cantidad_reparadas_ope))/SUM(cantidad_cursadas))*100)as pctrep, SUM(cantidad_urgentes)as opurg, SUM(cantidad_fuerahora)as opfh, ((SUM(cantidad_urgentes)/SUM(cantidad_cursadas))*100)as pcturg, ((SUM(cantidad_fuerahora)/SUM(cantidad_cursadas))*100)as pctfh FROM estadistica_operaciones WHERE date_curse BETWEEN %s AND %s AND producto = %s GROUP BY operador, producto ORDER BY SUM(cantidad_cursadas) DESC", GetSQLValueString($colname_estadistica_bga, "date"),GetSQLValueString($colname1_estadistica_bga, "date"),GetSQLValueString($colname2_estadistica_bga, "text"));
$estadistica_bga = mysqli_query($comercioexterior, $query_estadistica_bga) or die(mysqli_error($comercioexterior));
$row_estadistica_bga = mysqli_fetch_assoc($estadistica_bga);
$totalRows_estadistica_bga = mysqli_num_rows($estadistica_bga);

$colname_estadistica_tbc = "-1";
if (isset($_GET['date_ini'])) {
  $colname_estadistica_tbc = $_GET['date_ini'];
}
$colname1_estadistica_tbc = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_estadistica_tbc = $_GET['date_fin'];
}
$colname2_estadistica_tbc = "Credito IIIB5";
if (isset($_GET['producto'])) {
  $colname2_estadistica_tbc = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_estadistica_tbc = sprintf("SELECT *, min(date_curse)as fechainicio, max(date_curse)as fechatermino, SUM(cantidad_cursadas)as opcur, SUM(cantidad_reparadas_ope)as opresop, (((SUM(cantidad_reparadas_ope))/SUM(cantidad_cursadas))*100)as pctrep, SUM(cantidad_urgentes)as opurg, SUM(cantidad_fuerahora)as opfh, ((SUM(cantidad_urgentes)/SUM(cantidad_cursadas))*100)as pcturg, ((SUM(cantidad_fuerahora)/SUM(cantidad_cursadas))*100)as pctfh FROM estadistica_operaciones WHERE date_curse BETWEEN %s AND %s AND producto = %s GROUP BY operador, producto ORDER BY SUM(cantidad_cursadas) DESC", GetSQLValueString($colname_estadistica_tbc, "date"),GetSQLValueString($colname1_estadistica_tbc, "date"),GetSQLValueString($colname2_estadistica_tbc, "text"));
$estadistica_tbc = mysqli_query($comercioexterior, $query_estadistica_tbc) or die(mysqli_error($comercioexterior));
$row_estadistica_tbc = mysqli_fetch_assoc($estadistica_tbc);
$totalRows_estadistica_tbc = mysqli_num_rows($estadistica_tbc);

$colname_estadistica_sbe = "-1";
if (isset($_GET['date_ini'])) {
  $colname_estadistica_sbe = $_GET['date_ini'];
}
$colname1_estadistica_sbe = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_estadistica_sbe = $_GET['date_fin'];
}
$colname2_estadistica_sbe = "L/C Stand By Emitida";
if (isset($_GET['producto'])) {
  $colname2_estadistica_sbe = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_estadistica_sbe = sprintf("SELECT *, min(date_curse)as fechainicio, max(date_curse)as fechatermino, SUM(cantidad_cursadas)as opcur, SUM(cantidad_reparadas_ope)as opresop, (((SUM(cantidad_reparadas_ope))/SUM(cantidad_cursadas))*100)as pctrep, SUM(cantidad_urgentes)as opurg, SUM(cantidad_fuerahora)as opfh, ((SUM(cantidad_urgentes)/SUM(cantidad_cursadas))*100)as pcturg, ((SUM(cantidad_fuerahora)/SUM(cantidad_cursadas))*100)as pctfh FROM estadistica_operaciones WHERE date_curse BETWEEN %s AND %s AND producto = %s GROUP BY operador, producto ORDER BY SUM(cantidad_cursadas) DESC", GetSQLValueString($colname_estadistica_sbe, "date"),GetSQLValueString($colname1_estadistica_sbe, "date"),GetSQLValueString($colname2_estadistica_sbe, "text"));
$estadistica_sbe = mysqli_query($comercioexterior, $query_estadistica_sbe) or die(mysqli_error($comercioexterior));
$row_estadistica_sbe = mysqli_fetch_assoc($estadistica_sbe);
$totalRows_estadistica_sbe = mysqli_num_rows($estadistica_sbe);

$colname_estadistica_str = "-1";
if (isset($_GET['date_ini'])) {
  $colname_estadistica_str = $_GET['date_ini'];
}
$colname1_estadistica_str = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_estadistica_str = $_GET['date_fin'];
}
$colname2_estadistica_str = "L/C Stand By Recibida";
if (isset($_GET['producto'])) {
  $colname2_estadistica_str = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_estadistica_str = sprintf("SELECT *, min(date_curse)as fechainicio, max(date_curse)as fechatermino, SUM(cantidad_cursadas)as opcur, SUM(cantidad_reparadas_ope)as opresop, (((SUM(cantidad_reparadas_ope))/SUM(cantidad_cursadas))*100)as pctrep, SUM(cantidad_urgentes)as opurg, SUM(cantidad_fuerahora)as opfh, ((SUM(cantidad_urgentes)/SUM(cantidad_cursadas))*100)as pcturg, ((SUM(cantidad_fuerahora)/SUM(cantidad_cursadas))*100)as pctfh FROM estadistica_operaciones WHERE date_curse BETWEEN %s AND %s AND producto = %s GROUP BY operador, producto ORDER BY SUM(cantidad_cursadas) DESC", GetSQLValueString($colname_estadistica_str, "date"),GetSQLValueString($colname1_estadistica_str, "date"),GetSQLValueString($colname2_estadistica_str, "text"));
$estadistica_str = mysqli_query($comercioexterior, $query_estadistica_str) or die(mysqli_error($comercioexterior));
$row_estadistica_str = mysqli_fetch_assoc($estadistica_str);
$totalRows_estadistica_str = mysqli_num_rows($estadistica_str);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Estadistica Cuadro de Mando - Operaciones</title>
<style type="text/css">
<!--
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
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
    <td align="right" valign="middle"><a href="estadistica_operaciones_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen1','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen1" width="80" height="25" border="0" id="Imagen1" /></a></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td width="100%" align="center" valign="middle" bgcolor="#FF0000" class="Estilo3">ESTADISTICA - CUADRO MANDO OPERACIONES</td>
  </tr>
</table>
<br />
<?php if($row_estadistica_prestamos !=0) { ?>

<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="8" align="left" valign="middle" class="titulocolumnas"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0" /><span class="titulodetalle">Estadistica</span> <span class="tituloverde"><?php echo strtoupper($row_estadistica_prestamos['producto']); ?></span> <span class="titulodetalle">Desde</span> <span class="tituloverde"><?php echo $row_estadistica_prestamos['fechainicio']; ?></span><span class="titulodetalle"> Hasta </span><span class="tituloverde"><?php echo $row_estadistica_prestamos['fechatermino']; ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Cursadas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Rep. x Operaciones</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Reparos</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Urgentes</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Urgencias</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Fuera de Horario</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Fuera Horario</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna"><strong><?php echo strtoupper($row_estadistica_prestamos['operador']); ?></strong></td>
      <td align="right" valign="middle" class="Verde2"><?php echo number_format($row_estadistica_prestamos['opcur'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_prestamos['opresop'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_prestamos['pctrep'], 2, ',', '.'); ?></td>
      <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_prestamos['opurg'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_prestamos['pcturg'], 2, ',', '.'); ?></td>
      <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_prestamos['opfh'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_prestamos['pctfh'], 2, ',', '.'); ?></td>
    </tr>
    <?php } while ($row_estadistica_prestamos = mysqli_fetch_assoc($estadistica_prestamos)); ?>
  <?php }?>
</table>
<br />
<?php if($row_estadistica_meco !=0) { ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="8" align="left" valign="middle" class="titulocolumnas"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Estadistica</span> <span class="tituloverde"><?php echo strtoupper($row_estadistica_meco['producto']); ?></span> <span class="titulodetalle">Desde</span> <span class="tituloverde"><?php echo $row_estadistica_meco['fechainicio']; ?></span><span class="titulodetalle"> Hasta </span><span class="tituloverde"><?php echo $row_estadistica_meco['fechatermino']; ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Cursadas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Rep. x Operaciones</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Reparos</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Urgentes</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Urgencias</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Fuera de Horario</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Fuera Horario</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="left" valign="middle" class="respuestacolumna"><strong><?php echo strtoupper($row_estadistica_meco['operador']); ?></strong></td>
    <td align="right" valign="middle" class="Verde2"><?php echo number_format($row_estadistica_meco['opcur'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_meco['opresop'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_meco['pctrep'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_meco['opurg'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_meco['pcturg'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_meco['opfh'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_meco['pctfh'], 2, ',', '.'); ?></td>
  </tr>
  <?php } while ($row_estadistica_meco = mysqli_fetch_assoc($estadistica_meco)); ?>
  <?php } ?>
</table>
<br />
<?php if($row_estadistica_cci !=0) { ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="8" align="left" valign="middle" class="titulocolumnas"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Estadistica</span> <span class="tituloverde"><?php echo strtoupper($row_estadistica_cci['producto']); ?></span> <span class="titulodetalle">Desde</span> <span class="tituloverde"><?php echo $row_estadistica_cci['fechainicio']; ?></span><span class="titulodetalle"> Hasta </span><span class="tituloverde"><?php echo $row_estadistica_cci['fechatermino']; ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Cursadas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Rep. x Operaciones</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Reparos</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Urgentes</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Urgencias</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Fuera de Horario</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Fuera Horario</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="left" valign="middle" class="respuestacolumna"><strong><?php echo strtoupper($row_estadistica_cci['operador']); ?></strong></td>
    <td align="right" valign="middle" class="Verde2"><?php echo number_format($row_estadistica_cci['opcur'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_cci['opresop'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_cci['pctrep'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_cci['opurg'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_cci['pcturg'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_cci['opfh'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_cci['pctfh'], 2, ',', '.'); ?></td>
  </tr>
  <?php } while ($row_estadistica_cci = mysqli_fetch_assoc($estadistica_cci)); ?>
  <?php } ?>
</table>
<br />
<?php if($row_estadistica_cbi !=0) { ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="8" align="left" valign="middle" class="titulocolumnas"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Estadistica</span> <span class="tituloverde"><?php echo strtoupper($row_estadistica_cbi['producto']); ?></span> <span class="titulodetalle">Desde</span> <span class="tituloverde"><?php echo $row_estadistica_cbi['fechainicio']; ?></span><span class="titulodetalle"> Hasta </span><span class="tituloverde"><?php echo $row_estadistica_cbi['fechatermino']; ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Cursadas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Rep. x Operaciones</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Reparos</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Urgentes</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Urgencias</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Fuera de Horario</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Fuera Horario</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="left" valign="middle" class="respuestacolumna"><strong><?php echo strtoupper($row_estadistica_cbi['operador']); ?></strong></td>
    <td align="right" valign="middle" class="Verde2"><?php echo number_format($row_estadistica_cbi['opcur'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_cbi['opresop'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_cbi['pctrep'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_cbi['opurg'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_cbi['pcturg'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_cbi['opfh'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_cbi['pctfh'], 2, ',', '.'); ?></td>
  </tr>
  <?php } while ($row_estadistica_cbi = mysqli_fetch_assoc($estadistica_cbi)); ?>
  <?php } ?>
</table>
<br />
<?php if($row_estadistica_cce !=0) { ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="8" align="left" valign="middle" class="titulocolumnas"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Estadistica</span> <span class="tituloverde"><?php echo strtoupper($row_estadistica_cce['producto']); ?></span> <span class="titulodetalle">Desde</span> <span class="tituloverde"><?php echo $row_estadistica_cce['fechainicio']; ?></span><span class="titulodetalle"> Hasta </span><span class="tituloverde"><?php echo $row_estadistica_cce['fechatermino']; ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Cursadas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Rep. x Operaciones</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Reparos</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Urgentes</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Urgencias</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Fuera de Horario</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Fuera Horario</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="left" valign="middle" class="respuestacolumna"><strong><?php echo strtoupper($row_estadistica_cce['operador']); ?></strong></td>
    <td align="right" valign="middle" class="Verde2"><?php echo number_format($row_estadistica_cce['opcur'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_cce['opresop'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_cce['pctrep'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_cce['opurg'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_cce['pcturg'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_cce['opfh'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_cce['pctfh'], 2, ',', '.'); ?></td>
  </tr>
  <?php } while ($row_estadistica_cce = mysqli_fetch_assoc($estadistica_cce)); ?>
  <?php } ?>
</table>
<br />
<?php if($row_estadistica_cbe !=0) { ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="8" align="left" valign="middle" class="titulocolumnas"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Estadistica</span> <span class="tituloverde"><?php echo strtoupper($row_estadistica_cbe['producto']); ?></span> <span class="titulodetalle">Desde</span> <span class="tituloverde"><?php echo $row_estadistica_cbe['fechainicio']; ?></span><span class="titulodetalle"> Hasta </span><span class="tituloverde"><?php echo $row_estadistica_cbe['fechatermino']; ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Cursadas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Rep. x Operaciones</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Reparos</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Urgentes</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Urgencias</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Fuera de Horario</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Fuera Horario</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="left" valign="middle" class="respuestacolumna"><strong><?php echo strtoupper($row_estadistica_cbe['operador']); ?></strong></td>
    <td align="right" valign="middle" class="Verde2"><?php echo number_format($row_estadistica_cbe['opcur'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_cbe['opresop'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_cbe['pctrep'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_cbe['opurg'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_cbe['pcturg'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_cbe['opfh'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_cbe['pctfh'], 2, ',', '.'); ?></td>
  </tr>
  <?php } while ($row_estadistica_cbe = mysqli_fetch_assoc($estadistica_cbe)); ?>
  <?php } ?>
</table>
<br />
<?php if($row_estadistica_cambio !=0) { ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="8" align="left" valign="middle" class="titulocolumnas"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Estadistica</span> <span class="tituloverde"><?php echo strtoupper($row_estadistica_cambio['producto']); ?></span> <span class="titulodetalle">Desde</span> <span class="tituloverde"><?php echo $row_estadistica_cambio['fechainicio']; ?></span><span class="titulodetalle"> Hasta </span><span class="tituloverde"><?php echo $row_estadistica_cambio['fechatermino']; ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Cursadas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Rep. x Operaciones</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Reparos</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Urgentes</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Urgencias</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Fuera de Horario</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Fuera Horario</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="left" valign="middle" class="respuestacolumna"><strong><?php echo strtoupper($row_estadistica_cambio['operador']); ?></strong></td>
    <td align="right" valign="middle" class="Verde2"><?php echo number_format($row_estadistica_cambio['opcur'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_cambio['opresop'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_cambio['pctrep'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_cambio['opurg'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_cambio['pcturg'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_cambio['opfh'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_cambio['pctfh'], 2, ',', '.'); ?></td>
  </tr>
  <?php } while ($row_estadistica_cambio = mysqli_fetch_assoc($estadistica_cambio)); ?>
  <?php } ?>
</table>
<br />
<?php if($row_estadistica_bga !=0) { ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="8" align="left" valign="middle" class="titulocolumnas"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Estadistica </span><span class="tituloverde"><?php echo strtoupper($row_estadistica_bga['producto']); ?> </span><span class="titulodetalle">Desde</span> <span class="tituloverde"><?php echo $row_estadistica_bga['fechainicio']; ?></span><span class="titulodetalle"> Hasta </span><span class="tituloverde"><?php echo $row_estadistica_bga['fechatermino']; ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Cursadas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Rep. x Operaciones</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Reparos</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Urgentes</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Urgencias</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Fuera de Horario</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Fuera Horario</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="left" valign="middle" class="respuestacolumna"><strong><?php echo strtoupper($row_estadistica_bga['operador']); ?></strong></td>
    <td align="right" valign="middle" class="Verde2"><?php echo number_format($row_estadistica_bga['opcur'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_bga['opresop'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_bga['pctrep'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_bga['opurg'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_bga['pcturg'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_bga['opfh'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_bga['pctfh'], 2, ',', '.'); ?></td>
  </tr>
  <?php } while ($row_estadistica_bga = mysqli_fetch_assoc($estadistica_bga)); ?>
  <?php } ?>
</table>
<br />
<?php if($row_estadistica_tbc !=0) { ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="8" align="left" valign="middle" class="titulocolumnas"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Estadistica</span> <span class="tituloverde"><?php echo strtoupper($row_estadistica_tbc['producto']); ?></span> <span class="titulodetalle">Desde</span> <span class="tituloverde"><?php echo $row_estadistica_tbc['fechainicio']; ?></span><span class="titulodetalle"> Hasta </span><span class="tituloverde"><?php echo $row_estadistica_tbc['fechatermino']; ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Cursadas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Rep. x Operaciones</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Reparos</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Urgentes</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Urgencias</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Fuera de Horario</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Fuera Horario</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="left" valign="middle" class="respuestacolumna"><strong><?php echo strtoupper($row_estadistica_tbc['operador']); ?></strong></td>
    <td align="right" valign="middle" class="Verde2"><?php echo number_format($row_estadistica_tbc['opcur'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_tbc['opresop'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_tbc['pctrep'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_tbc['opurg'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_tbc['pcturg'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_tbc['opfh'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_tbc['pctfh'], 2, ',', '.'); ?></td>
  </tr>
  <?php } while ($row_estadistica_tbc = mysqli_fetch_assoc($estadistica_tbc)); ?>
  <?php } ?>
</table>
<br />
<?php if($row_estadistica_sbe !=0) { ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="8" align="left" valign="middle" class="titulocolumnas"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Estadistica</span> <span class="tituloverde"><?php echo strtoupper($row_estadistica_sbe['producto']); ?></span> <span class="titulodetalle">Desde</span> <span class="tituloverde"><?php echo $row_estadistica_sbe['fechainicio']; ?></span><span class="titulodetalle"> Hasta </span><span class="tituloverde"><?php echo $row_estadistica_sbe['fechatermino']; ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Cursadas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Rep. x Operaciones</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Reparos</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Urgentes</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Urgencias</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Fuera de Horario</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Fuera Horario</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="left" valign="middle" class="respuestacolumna"><strong><?php echo strtoupper($row_estadistica_sbe['operador']); ?></strong></td>
    <td align="right" valign="middle" class="Verde2"><?php echo number_format($row_estadistica_sbe['opcur'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_sbe['opresop'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_sbe['pctrep'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_sbe['opurg'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_sbe['pcturg'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_sbe['opfh'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_sbe['pctfh'], 2, ',', '.'); ?></td>
  </tr>
  <?php } while ($row_estadistica_sbe = mysqli_fetch_assoc($estadistica_sbe)); ?>
  <?php } ?>
</table>
<br />
<?php if($row_estadistica_str !=0) { ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="8" align="left" valign="middle" class="titulocolumnas"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Estadistica</span> <span class="tituloverde"><?php echo strtoupper($row_estadistica_str['producto']); ?></span> <span class="titulodetalle">Desde</span> <span class="tituloverde"><?php echo $row_estadistica_str['fechainicio']; ?></span><span class="titulodetalle"> Hasta </span><span class="tituloverde"><?php echo $row_estadistica_str['fechatermino']; ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Cursadas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Rep. x Operaciones</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Reparos</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Urgentes</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Urgencias</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Fuera de Horario</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Fuera Horario</td>
  </tr>
  
  <?php do { ?>
  <tr>
    <td align="left" valign="middle" class="respuestacolumna"><strong><?php echo strtoupper($row_estadistica_str['operador']); ?></strong></td>
    <td align="right" valign="middle" class="Verde2"><?php echo number_format($row_estadistica_str['opcur'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_str['opresop'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_str['pctrep'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_str['opurg'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_str['pcturg'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_str['opfh'], 0, ',', '.'); ?></td>
    <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_str['pctfh'], 2, ',', '.'); ?></td>
  </tr>
  <?php } while ($row_estadistica_str = mysqli_fetch_assoc($estadistica_str)); ?>
  <?php } ?>
</table>
</body>
</html>
<?php
mysqli_free_result($estadistica_prestamos);
mysqli_free_result($estadistica_meco);
mysqli_free_result($estadistica_cci);
mysqli_free_result($estadistica_cbi);
mysqli_free_result($estadistica_cce);
mysqli_free_result($estadistica_cbe);
mysqli_free_result($estadistica_cambio);
mysqli_free_result($estadistica_bga);
mysqli_free_result($estadistica_tbc);
mysqli_free_result($estadistica_sbe);
mysqli_free_result($estadistica_str);
?>