<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,ESP";
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

$MM_restrictGoTo = "../../erroracceso.php";
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

$colname1_estadistica_postventa = "-1";
if (isset($_GET['date_ini'])) {
  $colname_estadistica_postventa = $_GET['date_ini'];
}
$colname1_estadistica_postventa = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_estadistica_postventa = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_estadistica_postventa = sprintf("SELECT *, min(date_ingreso)as fechainicio, max(date_ingreso)as fechatermino, SUM(cantidad_ingresadas)as oping, SUM(cantidad_pendientes)as oppen, SUM(cantidad_cursadas)as opcur, SUM(cantidad_reparadas_esp)as oprepes, SUM(cantidad_reparadas_ope)as opresop, ((SUM(cantidad_reparadas_esp)/SUM(cantidad_ingresadas))*100)as pctrepesp, ((SUM(cantidad_reparadas_ope)/SUM(cantidad_ingresadas))*100)as pctrepope, SUM(cantidad_urgentes)as opurg, SUM(cantidad_fuerahora)as opfh, ((SUM(cantidad_urgentes)/SUM(cantidad_ingresadas))*100)as pcturg, ((SUM(cantidad_fuerahora)/SUM(cantidad_ingresadas))*100)as pctfh FROM estadistica_postventa nolock WHERE date_ingreso BETWEEN %s AND %s GROUP BY especialista_curse ORDER BY SUM(cantidad_ingresadas) DESC", GetSQLValueString($colname_estadistica_postventa, "date"),GetSQLValueString($colname1_estadistica_postventa, "date"));
$estadistica_postventa = mysqli_query($comercioexterior, $query_estadistica_postventa) or die(mysqli_error());
$row_estadistica_postventa = mysqli_fetch_assoc($estadistica_postventa);
$totalRows_estadistica_postventa = mysqli_num_rows($estadistica_postventa);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Estadistica Cuadro de Mando - Post Venta</title>
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
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
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
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
</head>
<body onload="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="estadistica_postventa_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen1','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen1" width="80" height="25" border="0" id="Imagen1" /></a></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td colspan="2" align="center" valign="middle" bgcolor="#FF0000" class="Estilo3">ESTADISTICA - CUADRO MANDO POST VENTA</td>
  </tr>
  <tr>
    <td width="16%" align="right" valign="middle">Fecha Desde:</td>
    <td width="84%" align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_estadistica_postventa['fechainicio']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Fecha Hasta:</td>
    <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_estadistica_postventa['fechatermino']; ?></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td width="20%" align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Ingresadas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Pendientes</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Cursadas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Rep.  x Especialistas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Reparos Especialistas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Rep. x Operaciones</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Reparos Operaciones</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Urgentes</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Urgencias</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Fuera de Horario</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Fuera Horario</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Contestabilidad</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna"><strong><?php echo strtoupper($row_estadistica_postventa['especialista_curse']); ?></strong></td>
      <td align="right" valign="middle" class="Azul2"><?php echo number_format($row_estadistica_postventa['oping'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle"><?php echo number_format($row_estadistica_postventa['oppen'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle" class="Verde2"><?php echo number_format($row_estadistica_postventa['opcur'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_postventa['oprepes'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_postventa['pctrepesp'], 2, ',', '.'); ?></td>
      <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_postventa['opresop'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_postventa['pctrepope'], 2, ',', '.'); ?></td>
      <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_postventa['opurg'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_postventa['pcturg'], 2, ',', '.'); ?></td>
      <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_postventa['opfh'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_postventa['pctfh'], 2, ',', '.'); ?></td>
      <td align="right" valign="middle" class="Naranja2"><?php echo number_format($row_estadistica_postventa['pct_contesta'], 2, ',', '.'); ?></td>
    </tr>
    <?php } while ($row_estadistica_postventa = mysqli_fetch_assoc($estadistica_postventa)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($estadistica_postventa);
?>