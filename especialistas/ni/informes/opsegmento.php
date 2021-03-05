<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ESP,ADM";
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
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=op_segmento.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0");
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

$colname2_opcci = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opcci = $_GET['date_ini'];
}
$colname3_opcci = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opcci = $_GET['date_fin'];
}
$colname4_opcci = "1";
if (isset($_GET['segmento'])) {
  $colname4_opcci = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcci = sprintf("SELECT opcci.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opcci, usuarios WHERE date_ingreso between %s and %s and usuarios.segmento = %s and (opcci.especialista_curse = usuarios.usuario)", GetSQLValueString($colname2_opcci, "date"),GetSQLValueString($colname3_opcci, "date"),GetSQLValueString($colname4_opcci, "text"));
$opcci = mysqli_query($comercioexterior, $query_opcci) or die(mysqli_error());
$row_opcci = mysqli_fetch_assoc($opcci);
$totalRows_opcci = mysqli_num_rows($opcci);

$colname2_opcce = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opcce = $_GET['date_ini'];
}
$colname3_opcce = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opcce = $_GET['date_fin'];
}
$colname4_opcce = "1";
if (isset($_GET['segmento'])) {
  $colname4_opcce = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcce = sprintf("SELECT opcce.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opcce, usuarios WHERE date_ingreso between %s and %s and usuarios.segmento = %s and (opcce.especialista_curse = usuarios.usuario)", GetSQLValueString($colname2_opcce, "date"),GetSQLValueString($colname3_opcce, "date"),GetSQLValueString($colname4_opcce, "text"));
$opcce = mysqli_query($comercioexterior, $query_opcce) or die(mysqli_error());
$row_opcce = mysqli_fetch_assoc($opcce);
$totalRows_opcce = mysqli_num_rows($opcce);

$colname2_opcbi = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opcbi = $_GET['date_ini'];
}
$colname3_opcbi = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opcbi = $_GET['date_fin'];
}
$colname4_opcbi = "1";
if (isset($_GET['segmento'])) {
  $colname4_opcbi = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcbi = sprintf("SELECT opcbi.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opcbi, usuarios WHERE date_ingreso between %s and %s and usuarios.segmento = %s and (opcbi.especialista_curse = usuarios.usuario)", GetSQLValueString($colname2_opcbi, "date"),GetSQLValueString($colname3_opcbi, "date"),GetSQLValueString($colname4_opcbi, "text"));
$opcbi = mysqli_query($comercioexterior, $query_opcbi) or die(mysqli_error());
$row_opcbi = mysqli_fetch_assoc($opcbi);
$totalRows_opcbi = mysqli_num_rows($opcbi);

$colname2_opcbe = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opcbe = $_GET['date_ini'];
}
$colname3_opcbe = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opcbe = $_GET['date_fin'];
}
$colname4_opcbe = "1";
if (isset($_GET['segmento'])) {
  $colname4_opcbe = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcbe = sprintf("SELECT opcbe.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opcbe, usuarios WHERE date_ingreso between %s and %s and usuarios.segmento = %s and (opcbe.especialista_curse = usuarios.usuario)", GetSQLValueString($colname2_opcbe, "date"),GetSQLValueString($colname3_opcbe, "date"),GetSQLValueString($colname4_opcbe, "text"));
$opcbe = mysqli_query($comercioexterior, $query_opcbe) or die(mysqli_error());
$row_opcbe = mysqli_fetch_assoc($opcbe);
$totalRows_opcbe = mysqli_num_rows($opcbe);

$colname2_oppre = "1";
if (isset($_GET['date_ini'])) {
  $colname2_oppre = $_GET['date_ini'];
}
$colname3_oppre = "1";
if (isset($_GET['date_fin'])) {
  $colname3_oppre = $_GET['date_fin'];
}
$colname4_oppre = "1";
if (isset($_GET['segmento'])) {
  $colname4_oppre = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_oppre = sprintf("SELECT oppre.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM oppre, usuarios WHERE date_ingreso between %s and %s and usuarios.segmento = %s and (oppre.especialista_curse = usuarios.usuario)", GetSQLValueString($colname2_oppre, "date"),GetSQLValueString($colname3_oppre, "date"),GetSQLValueString($colname4_oppre, "text"));
$oppre = mysqli_query($comercioexterior, $query_oppre) or die(mysqli_error());
$row_oppre = mysqli_fetch_assoc($oppre);
$totalRows_oppre = mysqli_num_rows($oppre);

$colname2_opmec = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opmec = $_GET['date_ini'];
}
$colname3_opmec = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opmec = $_GET['date_fin'];
}
$colname4_opmec = "1";
if (isset($_GET['segmento'])) {
  $colname4_opmec = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opmec = sprintf("SELECT opmec.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opmec, usuarios WHERE date_ingreso between %s and %s and usuarios.segmento = %s and (opmec.especialista_curse = usuarios.usuario)", GetSQLValueString($colname2_opmec, "date"),GetSQLValueString($colname3_opmec, "date"),GetSQLValueString($colname4_opmec, "text"));
$opmec = mysqli_query($comercioexterior, $query_opmec) or die(mysqli_error());
$row_opmec = mysqli_fetch_assoc($opmec);
$totalRows_opmec = mysqli_num_rows($opmec);

$colname2_opbga = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opbga = $_GET['date_ini'];
}
$colname3_opbga = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opbga = $_GET['date_fin'];
}
$colname4_opbga = "1";
if (isset($_GET['segmento'])) {
  $colname4_opbga = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opbga = sprintf("SELECT opbga.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opbga, usuarios WHERE date_ingreso between %s and %s and usuarios.segmento = %s and (opbga.especialista_curse = usuarios.usuario)", GetSQLValueString($colname2_opbga, "date"),GetSQLValueString($colname3_opbga, "date"),GetSQLValueString($colname4_opbga, "text"));
$opbga = mysqli_query($comercioexterior, $query_opbga) or die(mysqli_error());
$row_opbga = mysqli_fetch_assoc($opbga);
$totalRows_opbga = mysqli_num_rows($opbga);

$colname2_opste = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opste = $_GET['date_ini'];
}
$colname3_opste = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opste = $_GET['date_fin'];
}
$colname4_opste = "1";
if (isset($_GET['segmento'])) {
  $colname4_opste = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opste = sprintf("SELECT opste.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opste, usuarios WHERE date_ingreso between %s and %s and usuarios.segmento = %s and (opste.especialista_curse = usuarios.usuario)", GetSQLValueString($colname2_opste, "date"),GetSQLValueString($colname3_opste, "date"),GetSQLValueString($colname4_opste, "text"));
$opste = mysqli_query($comercioexterior, $query_opste) or die(mysqli_error());
$row_opste = mysqli_fetch_assoc($opste);
$totalRows_opste = mysqli_num_rows($opste);

$colname2_opstr = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opstr = $_GET['date_ini'];
}
$colname3_opstr = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opstr = $_GET['date_fin'];
}
$colname4_opstr = "1";
if (isset($_GET['segmento'])) {
  $colname4_opstr = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opstr = sprintf("SELECT opstr.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opstr, usuarios WHERE date_ingreso between %s and %s and usuarios.segmento = %s and (opstr.especialista_curse = usuarios.usuario)", GetSQLValueString($colname2_opstr, "date"),GetSQLValueString($colname3_opstr, "date"),GetSQLValueString($colname4_opstr, "text"));
$opstr = mysqli_query($comercioexterior, $query_opstr) or die(mysqli_error());
$row_opstr = mysqli_fetch_assoc($opstr);
$totalRows_opstr = mysqli_num_rows($opstr);

$colname2_opcex = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opcex = $_GET['date_ini'];
}
$colname3_opcex = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opcex = $_GET['date_fin'];
}
$colname4_opcex = "1";
if (isset($_GET['segmento'])) {
  $colname4_opcex = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcex = sprintf("SELECT opcex.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opcex, usuarios WHERE date_ingreso between %s and %s and usuarios.segmento = %s and (opcex.especialista_curse = usuarios.usuario)", GetSQLValueString($colname2_opcex, "date"),GetSQLValueString($colname3_opcex, "date"),GetSQLValueString($colname4_opcex, "text"));
$opcex = mysqli_query($comercioexterior, $query_opcex) or die(mysqli_error());
$row_opcex = mysqli_fetch_assoc($opcex);
$totalRows_opcex = mysqli_num_rows($opcex);

$colname2_optbc = "1";
if (isset($_GET['date_ini'])) {
  $colname2_optbc = $_GET['date_ini'];
}
$colname3_optbc = "1";
if (isset($_GET['date_fin'])) {
  $colname3_optbc = $_GET['date_fin'];
}
$colname4_optbc = "1";
if (isset($_GET['segmento'])) {
  $colname4_optbc = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_optbc = sprintf("SELECT optbc.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM optbc, usuarios WHERE date_ingreso between %s and %s and usuarios.segmento = %s and (optbc.especialista_curse = usuarios.usuario)", GetSQLValueString($colname2_optbc, "date"),GetSQLValueString($colname3_optbc, "date"),GetSQLValueString($colname4_optbc, "text"));
$optbc = mysqli_query($comercioexterior, $query_optbc) or die(mysqli_error());
$row_optbc = mysqli_fetch_assoc($optbc);
$totalRows_optbc = mysqli_num_rows($optbc);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Opraciones Ingresadas por Especialistas</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 9px;
	color: #000;
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
<?php if ($totalRows_opcci > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center">
    <tr>
      <td colspan="7" align="left" valign="middle"> Carta de Crédito de Importación</td>
    </tr>
    <tr>
      <td align="center" valign="middle">Rut Cliente</td>
      <td align="center" valign="middle">Nombre Cliente</td>
      <td align="center" valign="middle">Especialista</td>
      <td align="center" valign="middle">Segmento</td>
      <td align="center" valign="middle">Evento</td>
      <td align="center" valign="middle">Estado</td>
      <td align="center" valign="middle">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcci['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcci['nombre_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcci['ne']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcci['seg']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcci['evento']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcci['estado']); ?></td>
        <td align="right" valign="middle"><?php echo strtoupper($row_opcci['moneda_operacion']); ?> <?php echo number_format($row_opcci['monto_operacion'], 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opcci = mysqli_fetch_assoc($opcci)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcce > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center">
    <tr>
      <td colspan="7">Carta de Crédito de Exportación</td>
    </tr>
    <tr>
      <td align="center" valign="middle">Rut Cliente</td>
      <td align="center" valign="middle">Nombre Cliente</td>
      <td align="center" valign="middle">Especialista</td>
      <td align="center" valign="middle">Segmento</td>
      <td align="center" valign="middle">Evento</td>
      <td align="center" valign="middle">Estado</td>
      <td align="center" valign="middle">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcce['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcce['nombre_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcce['ne']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcce['seg']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcce['evento']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcce['estado']); ?></td>
        <td align="right" valign="middle"><?php echo strtoupper($row_opcce['moneda_operacion']); ?> <?php echo number_format($row_opcce['monto_operacion'], 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opcce = mysqli_fetch_assoc($opcce)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcbi > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center">
    <tr>
      <td colspan="7"> Cobranza Extranjera de Importación y Orden de Pago de Importación</td>
    </tr>
    <tr>
      <td align="center" valign="middle">Rut Cliente</td>
      <td align="center" valign="middle">Nombre Cliente</td>
      <td align="center" valign="middle">Especilaista</td>
      <td align="center" valign="middle">Segmento</td>
      <td align="center" valign="middle">Evento</td>
      <td align="center" valign="middle">Estado</td>
      <td align="center" valign="middle">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['nombre_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['ne']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcbi['seg']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcbi['evento']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcbi['estado']); ?></td>
        <td align="right" valign="middle"><?php echo strtoupper($row_opcbi['moneda_operacion']); ?> <?php echo number_format($row_opcbi['monto_operacion'], 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opcbi = mysqli_fetch_assoc($opcbi)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcbe > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center">
    <tr>
      <td colspan="7" align="left" valign="middle">Cobranza Extranjera de Exportación</td>
    </tr>
    <tr>
      <td align="center" valign="middle">Rut Cliente</td>
      <td align="center" valign="middle">Nombre Cliente</td>
      <td align="center" valign="middle">Especialista</td>
      <td align="center" valign="middle">Segmento</td>
      <td align="center" valign="middle">Evento</td>
      <td align="center" valign="middle">Estado</td>
      <td align="center" valign="middle">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcbe['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcbe['nombre_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcbe['ne']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcbe['seg']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcbe['evento']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcbe['estado']); ?></td>
        <td align="right" valign="middle"><?php echo strtoupper($row_opcbe['moneda_operacion']); ?> <?php echo number_format($row_opcbe['monto_operacion'], 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opcbe = mysqli_fetch_assoc($opcbe)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_oppre > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center">
    <tr>
      <td colspan="7" align="left" valign="middle">Prestamo</td>
    </tr>
    <tr>
      <td align="center" valign="middle">Rut Cliente</td>
      <td align="center" valign="middle">Monto Operación</td>
      <td align="center" valign="middle">Especialista</td>
      <td align="center" valign="middle">Segmento</td>
      <td align="center" valign="middle">Evento</td>
      <td align="center" valign="middle">Estado</td>
      <td align="center" valign="middle">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"><?php echo strtoupper($row_oppre['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_oppre['nombre_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_oppre['ne']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_oppre['seg']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_oppre['evento']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_oppre['estado']); ?></td>
        <td align="right" valign="middle"><?php echo strtoupper($row_oppre['moneda_operacion']); ?> <?php echo number_format($row_oppre['monto_operacion'], 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_oppre = mysqli_fetch_assoc($oppre)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opmec > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center">
    <tr>
      <td colspan="7">Mercado de Corredores </td>
    </tr>
    <tr>
      <td align="center" valign="middle">Rut Cliente</td>
      <td align="center" valign="middle">Nombre Cliente</td>
      <td align="center" valign="middle">Especialista</td>
      <td align="center" valign="middle">Segmento</td>
      <td align="center" valign="middle">Evento</td>
      <td align="center" valign="middle">Estado</td>
      <td align="center" valign="middle">Cantidad</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"><?php echo strtoupper($row_opmec['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opmec['nombre_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opmec['ne']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opmec['seg']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opmec['evento']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opmec['estado']); ?></td>
        <td align="right" valign="middle"><?php echo strtoupper($row_opmec['moneda_operacion']); ?> <?php echo number_format($row_opmec['monto_operacion'], 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opmec = mysqli_fetch_assoc($opmec)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opbga > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center">
    <tr>
      <td colspan="7" align="left" valign="middle">Boleta de Garantia</td>
    </tr>
    <tr>
      <td align="center" valign="middle">Rut Cliente</td>
      <td align="center" valign="middle">Moneda Cliente</td>
      <td align="center" valign="middle">Especialista</td>
      <td align="center" valign="middle">Segmento</td>
      <td align="center" valign="middle">Evento</td>
      <td align="center" valign="middle">Estado</td>
      <td align="center" valign="middle">Moneda / Monto Operacion</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"><?php echo strtoupper($row_opbga['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opbga['moneda_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opbga['ne']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opbga['seg']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opbga['evento']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opbga['estado']); ?></td>
        <td align="right" valign="middle"><?php echo strtoupper($row_opbga['moneda_operacion']); ?> <?php echo number_format($row_opbga['monto_operacion'], 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opbga = mysqli_fetch_assoc($opbga)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opste > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center">
    <tr>
      <td colspan="7" align="left" valign="middle">Stand BY Emitida</td>
    </tr>
    <tr>
      <td align="center" valign="middle">Rut Cliente</td>
      <td align="center" valign="middle">Moneda Cliente</td>
      <td align="center" valign="middle">Especialista</td>
      <td align="center" valign="middle">Segmento</td>
      <td align="center" valign="middle">Evento</td>
      <td align="center" valign="middle">Estado</td>
      <td align="center" valign="middle">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"><?php echo strtoupper($row_opste['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opste['nombre_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opste['ne']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opste['seg']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opste['evento']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opste['estado']); ?></td>
        <td align="right" valign="middle"><?php echo strtoupper($row_opste['moneda_operacion']); ?> <?php echo number_format($row_opste['moneda_operacion'], 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opste = mysqli_fetch_assoc($opste)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opstr > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center">
    <tr>
      <td colspan="7" align="left" valign="middle">Stand BY Recibida</td>
    </tr>
    <tr>
      <td align="center" valign="middle">Rut Cliente</td>
      <td align="center" valign="middle">Moneda Cliente</td>
      <td align="center" valign="middle">Especialista</td>
      <td align="center" valign="middle">Segmento</td>
      <td align="center" valign="middle">Evento</td>
      <td align="center" valign="middle">Estado</td>
      <td align="center" valign="middle">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"><?php echo strtoupper($row_opstr['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opstr['nombre_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opstr['ne']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opstr['seg']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opstr['evento']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opstr['estado']); ?></td>
        <td align="right" valign="middle"><?php echo strtoupper($row_opstr['moneda_operacion']); ?> <?php echo number_format($row_opstr['monto_operacion'], 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opstr = mysqli_fetch_assoc($opstr)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcex > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center">
    <tr>
      <td colspan="7" align="left" valign="middle">Otros Productos de Cambio</td>
    </tr>
    <tr>
      <td align="center" valign="middle">Rut Cliente</td>
      <td align="center" valign="middle">Nombre Cliente</td>
      <td align="center" valign="middle">Especialista</td>
      <td align="center" valign="middle">Segmento</td>
      <td align="center" valign="middle">Evento</td>
      <td align="center" valign="middle">Estado</td>
      <td align="center" valign="middle">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcex['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcex['nombre_cleinte']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_opcex['ne']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcex['seg']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcex['evento']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_opcex['estado']); ?></td>
        <td align="right" valign="middle"><?php echo strtoupper($row_opcex['moneda_operacion']); ?> <?php echo number_format($row_opcex['monto_operacion'], 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opcex = mysqli_fetch_assoc($opcex)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_optbc > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center">
    <tr>
      <td colspan="7" align="left" valign="middle">III B5</td>
    </tr>
    <tr>
      <td align="center" valign="middle">Rut Cliente</td>
      <td align="center" valign="middle">Nombre Cliente</td>
      <td align="center" valign="middle">Especialista</td>
      <td align="center" valign="middle">Segmento</td>
      <td align="center" valign="middle">Evento</td>
      <td align="center" valign="middle">Estado</td>
      <td align="center" valign="middle">Moneda / Monto Operacion</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"><?php echo strtoupper($row_optbc['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_optbc['nombre_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_optbc['ne']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_optbc['seg']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_optbc['evento']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_optbc['estado']); ?></td>
        <td align="right" valign="middle"><?php echo strtoupper($row_optbc['moneda_operacion']); ?> <?php echo number_format($row_optbc['monto_operacion'], 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_optbc = mysqli_fetch_assoc($optbc)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
</body>
</html>
<?php
mysqli_free_result($opcci);
mysqli_free_result($opcce);
mysqli_free_result($opcbi);
mysqli_free_result($opcbe);
mysqli_free_result($oppre);
mysqli_free_result($opmec);
mysqli_free_result($opbga);
mysqli_free_result($opste);
mysqli_free_result($opstr);
mysqli_free_result($opcex);
mysqli_free_result($optbc);
?>