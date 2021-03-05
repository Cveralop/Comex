<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=operaciones_reparadas.xls"); 
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

$colname2_DetailRS1 = "1";
if (isset($_GET['date_ini'])) {
  $colname2_DetailRS1 = $_GET['date_ini'];
}
$colname3_DetailRS1 = "1";
if (isset($_GET['date_fin'])) {
  $colname3_DetailRS1 = $_GET['date_fin'];
}
$colname4_DetailRS1 = "Reparada.";
if (isset($_GET['estado'])) {
  $colname4_DetailRS1 = $_GET['estado'];
}
$colname5_DetailRS1 = "Solucionado.";
if (isset($_GET['estado'])) {
  $colname5_DetailRS1 = $_GET['estado'];
}
$colname6_DetailRS1 = "BMG";
if (isset($_GET['segmento'])) {
  $colname6_DetailRS1 = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT opcci.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opcci, usuarios WHERE date_ingreso between %s and %s and (opcci.especialista_curse = usuarios.usuario) and (estado = %s or estado = %s) and usuarios.segmento <> %s", GetSQLValueString($colname2_DetailRS1, "date"),GetSQLValueString($colname3_DetailRS1, "date"),GetSQLValueString($colname4_DetailRS1, "text"),GetSQLValueString($colname5_DetailRS1, "text"),GetSQLValueString($colname6_DetailRS1, "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$colname2_opcce = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opcce = $_GET['date_ini'];
}
$colname3_opcce = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opcce = $_GET['date_fin'];
}
$colname4_opcce = "Reparada.";
if (isset($_GET['estado'])) {
  $colname4_opcce = $_GET['estado'];
}
$colname5_opcce = "Solucionado.";
if (isset($_GET['estado'])) {
  $colname5_opcce = $_GET['estado'];
}
$colname6_opcce = "BMG";
if (isset($_GET['segmento'])) {
  $colname6_opcce = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcce = sprintf("SELECT opcce.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opcce, usuarios WHERE date_ingreso between %s and %s and (opcce.especialista_curse = usuarios.usuario) and (estado = %s or estado = %s) and usuarios.segmento <> %s", GetSQLValueString($colname2_opcce, "date"),GetSQLValueString($colname3_opcce, "date"),GetSQLValueString($colname4_opcce, "text"),GetSQLValueString($colname5_opcce, "text"),GetSQLValueString($colname6_opcce, "text"));
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
$colname4_opcbi = "Reparada.";
if (isset($_GET['estado'])) {
  $colname4_opcbi = $_GET['estado'];
}
$colname5_opcbi = "Solucionado.";
if (isset($_GET['estado'])) {
  $colname5_opcbi = $_GET['estado'];
}
$colname6_opcbi = "BMG";
if (isset($_GET['segmento'])) {
  $colname6_opcbi = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcbi = sprintf("SELECT opcbi.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opcbi, usuarios WHERE date_ingreso between %s and %s and (opcbi.especialista_curse = usuarios.usuario) and (estado = %s or estado = %s) and usuarios.segmento <> %s", GetSQLValueString($colname2_opcbi, "date"),GetSQLValueString($colname3_opcbi, "date"),GetSQLValueString($colname4_opcbi, "text"),GetSQLValueString($colname5_opcbi, "text"),GetSQLValueString($colname6_opcbi, "text"));
$opcbi = mysqli_query($comercioexterior, $query_opcbi) or die(mysqli_error());
$row_opcbi = mysqli_fetch_assoc($opcbi);
$totalRows_opcbi = mysqli_num_rows($opcbi);

$colname2_opcbe = "-1";
if (isset($_GET['date_ini'])) {
  $colname2_opcbe = $_GET['date_ini'];
}
$colname3_opcbe = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opcbe = $_GET['date_fin'];
}
$colname4_opcbe = "Reparada.";
if (isset($_GET['estado'])) {
  $colname4_opcbe = $_GET['estado'];
}
$colname5_opcbe = "Solucionado.";
if (isset($_GET['estado'])) {
  $colname5_opcbe = $_GET['estado'];
}
$colname6_opcbe = "BMG";
if (isset($_GET['segmento'])) {
  $colname6_opcbe = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcbe = sprintf("SELECT opcbe.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opcbe, usuarios WHERE date_ingreso between %s and %s and (opcbe.especialista_curse = usuarios.usuario) and (estado = %s or estado = %s) and usuarios.segmento <> %s", GetSQLValueString($colname2_opcbe, "date"),GetSQLValueString($colname3_opcbe, "date"),GetSQLValueString($colname4_opcbe, "text"),GetSQLValueString($colname5_opcbe, "text"),GetSQLValueString($colname6_opcbe, "text"));
$opcbe = mysqli_query($comercioexterior, $query_opcbe) or die(mysqli_error());
$row_opcbe = mysqli_fetch_assoc($opcbe);
$totalRows_opcbe = mysqli_num_rows($opcbe);

$colname2_oppre = "-1";
if (isset($_GET['date_ini'])) {
  $colname2_oppre = $_GET['date_ini'];
}
$colname3_oppre = "1";
if (isset($_GET['date_fin'])) {
  $colname3_oppre = $_GET['date_fin'];
}
$colname4_oppre = "Reparada.";
if (isset($_GET['estado'])) {
  $colname4_oppre = $_GET['estado'];
}
$colname5_oppre = "Solucionado.";
if (isset($_GET['estado'])) {
  $colname5_oppre = $_GET['estado'];
}
$colname6_oppre = "BMG";
if (isset($_GET['segmento'])) {
  $colname6_oppre = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_oppre = sprintf("SELECT oppre.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM oppre, usuarios WHERE date_ingreso between %s and %s and (oppre.especialista_curse = usuarios.usuario) and (estado = %s or estado = %s) and usuarios.segmento <> %s", GetSQLValueString($colname2_oppre, "date"),GetSQLValueString($colname3_oppre, "date"),GetSQLValueString($colname4_oppre, "text"),GetSQLValueString($colname5_oppre, "text"),GetSQLValueString($colname6_oppre, "text"));
$oppre = mysqli_query($comercioexterior, $query_oppre) or die(mysqli_error());
$row_oppre = mysqli_fetch_assoc($oppre);
$totalRows_oppre = mysqli_num_rows($oppre);

$colname2_opmec = "-1";
if (isset($_GET['date_ini'])) {
  $colname2_opmec = $_GET['date_ini'];
}
$colname3_opmec = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opmec = $_GET['date_fin'];
}
$colname4_opmec = "Reparada.";
if (isset($_GET['estado'])) {
  $colname4_opmec = $_GET['estado'];
}
$colname5_opmec = "Solucionado.";
if (isset($_GET['estado'])) {
  $colname5_opmec = $_GET['estado'];
}
$colname6_opmec = "BMG";
if (isset($_GET['segmento'])) {
  $colname6_opmec = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opmec = sprintf("SELECT opmec.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opmec, usuarios WHERE date_ingreso between %s and %s and (opmec.especialista_curse = usuarios.usuario) and (estado = %s or estado = %s) and usuarios.segmento <> %s", GetSQLValueString($colname2_opmec, "date"),GetSQLValueString($colname3_opmec, "date"),GetSQLValueString($colname4_opmec, "text"),GetSQLValueString($colname5_opmec, "text"),GetSQLValueString($colname6_opmec, "text"));
$opmec = mysqli_query($comercioexterior, $query_opmec) or die(mysqli_error());
$row_opmec = mysqli_fetch_assoc($opmec);
$totalRows_opmec = mysqli_num_rows($opmec);

$colname2_opbga = "-1";
if (isset($_GET['date_ini'])) {
  $colname2_opbga = $_GET['date_ini'];
}
$colname3_opbga = "Reparada.";
if (isset($_GET['date_fin'])) {
  $colname3_opbga = $_GET['date_fin'];
}
$colname4_opbga = "Reparada.";
if (isset($_GET['estado'])) {
  $colname4_opbga = $_GET['estado'];
}
$colname5_opbga = "Solucionado.";
if (isset($_GET['estado'])) {
  $colname5_opbga = $_GET['estado'];
}
$colname6_opbga = "BMG";
if (isset($_GET['segmento'])) {
  $colname6_opbga = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opbga = sprintf("SELECT opbga.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opbga, usuarios WHERE date_ingreso between %s and %s and (opbga.especialista_curse = usuarios.usuario) and (estado = %s or estado = %s) and usuarios.segmento <> %s", GetSQLValueString($colname2_opbga, "date"),GetSQLValueString($colname3_opbga, "text"),GetSQLValueString($colname4_opbga, "text"),GetSQLValueString($colname5_opbga, "text"),GetSQLValueString($colname6_opbga, "text"));
$opbga = mysqli_query($comercioexterior, $query_opbga) or die(mysqli_error());
$row_opbga = mysqli_fetch_assoc($opbga);
$totalRows_opbga = mysqli_num_rows($opbga);

$colname2_opsbe = "-1";
if (isset($_GET['date_ini'])) {
  $colname2_opsbe = $_GET['date_ini'];
}
$colname3_opsbe = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opsbe = $_GET['date_fin'];
}
$colname4_opsbe = "Reparada.";
if (isset($_GET['estado'])) {
  $colname4_opsbe = $_GET['estado'];
}
$colname5_opsbe = "Solucionado.";
if (isset($_GET['estado'])) {
  $colname5_opsbe = $_GET['estado'];
}
$colname6_opsbe = "BMG";
if (isset($_GET['segmento'])) {
  $colname6_opsbe = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opsbe = sprintf("SELECT opste.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opste, usuarios WHERE date_ingreso between %s and %s and (opste.especialista_curse = usuarios.usuario) and (estado = %s or estado = %s) and usuarios.segmento <> %s", GetSQLValueString($colname2_opsbe, "date"),GetSQLValueString($colname3_opsbe, "date"),GetSQLValueString($colname4_opsbe, "text"),GetSQLValueString($colname5_opsbe, "text"),GetSQLValueString($colname6_opsbe, "text"));
$opsbe = mysql_query($query_opsbe, $comercioexterior) or die(mysqli_error());
$row_opsbe = mysqli_fetch_assoc($opsbe);
$totalRows_opsbe = mysqli_num_rows($opsbe);

$colname2_opstr = "-1";
if (isset($_GET['date_ini'])) {
  $colname2_opstr = $_GET['date_ini'];
}
$colname3_opstr = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opstr = $_GET['date_fin'];
}
$colname4_opstr = "Reparada.";
if (isset($_GET['evento'])) {
  $colname4_opstr = $_GET['evento'];
}
$colname5_opstr = "Solucionado.";
if (isset($_GET['estado'])) {
  $colname5_opstr = $_GET['estado'];
}
$colname6_opstr = "BMG";
if (isset($_GET['segmento'])) {
  $colname6_opstr = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opstr = sprintf("SELECT opstr.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opstr, usuarios WHERE date_ingreso between %s and %s and (opstr.especialista_curse = usuarios.usuario) and (estado = %s or estado = %s) and usuarios.segmento <> %s", GetSQLValueString($colname2_opstr, "date"),GetSQLValueString($colname3_opstr, "date"),GetSQLValueString($colname4_opstr, "text"),GetSQLValueString($colname5_opstr, "text"),GetSQLValueString($colname6_opstr, "text"));
$opstr = mysqli_query($comercioexterior, $query_opstr) or die(mysqli_error());
$row_opstr = mysqli_fetch_assoc($opstr);
$totalRows_opstr = mysqli_num_rows($opstr);

$colname2_opcex = "-1";
if (isset($_GET['date_ini'])) {
  $colname2_opcex = $_GET['date_ini'];
}
$colname3_opcex = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opcex = $_GET['date_fin'];
}
$colname4_opcex = "Reparada.";
if (isset($_GET['evento'])) {
  $colname4_opcex = $_GET['evento'];
}
$colname5_opcex = "Solucionado.";
if (isset($_GET['estado'])) {
  $colname5_opcex = $_GET['estado'];
}
$colname6_opcex = "BMG";
if (isset($_GET['segmento'])) {
  $colname6_opcex = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcex = sprintf("SELECT opcex.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opcex, usuarios WHERE date_ingreso between %s and %s and (opcex.especialista_curse = usuarios.usuario) and (estado = %s or estado = %s) and usuarios.segmento <> %s", GetSQLValueString($colname2_opcex, "date"),GetSQLValueString($colname3_opcex, "date"),GetSQLValueString($colname4_opcex, "text"),GetSQLValueString($colname5_opcex, "text"),GetSQLValueString($colname6_opcex, "text"));
$opcex = mysqli_query($comercioexterior, $query_opcex) or die(mysqli_error());
$row_opcex = mysqli_fetch_assoc($opcex);
$totalRows_opcex = mysqli_num_rows($opcex);

$colname2_optbc = "-1";
if (isset($_GET['date_ini'])) {
  $colname2_optbc = $_GET['date_ini'];
}
$colname3_optbc = "1";
if (isset($_GET['date_fin'])) {
  $colname3_optbc = $_GET['date_fin'];
}
$colname4_optbc = "Reparada.";
if (isset($_GET['estado'])) {
  $colname4_optbc = $_GET['estado'];
}
$colname5_optbc = "Solucionado.";
if (isset($_GET['estado'])) {
  $colname5_optbc = $_GET['estado'];
}
$colname6_optbc = "BMG";
if (isset($_GET['segmento'])) {
  $colname6_optbc = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_optbc = sprintf("SELECT optbc.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM optbc, usuarios WHERE date_ingreso between %s and %s and (optbc.especialista_curse = usuarios.usuario) and (estado = %s or estado = %s) and usuarios.segmento <> %s", GetSQLValueString($colname2_optbc, "date"),GetSQLValueString($colname3_optbc, "date"),GetSQLValueString($colname4_optbc, "text"),GetSQLValueString($colname5_optbc, "text"),GetSQLValueString($colname6_optbc, "text"));
$optbc = mysqli_query($comercioexterior, $query_optbc) or die(mysqli_error());
$row_optbc = mysqli_fetch_assoc($optbc);
$totalRows_optbc = mysqli_num_rows($optbc);

$colname2_opcdpa = "-1";
if (isset($_GET['date_ini'])) {
  $colname2_opcdpa = $_GET['date_ini'];
}
$colname3_opcdpa = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opcdpa = $_GET['date_fin'];
}
$colname4_opcdpa = "Reparada.";
if (isset($_GET['estado'])) {
  $colname4_opcdpa = $_GET['estado'];
}
$colname5_opcdpa = "Solucionado.";
if (isset($_GET['estado'])) {
  $colname5_opcdpa = $_GET['estado'];
}
$colname6_opcdpa = "BMG";
if (isset($_GET['segmento'])) {
  $colname6_opcdpa = $_GET['segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcdpa = sprintf("SELECT opcdpa.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg FROM opcdpa, usuarios WHERE date_ingreso between %s and %s and (opcdpa.especialista_curse = usuarios.usuario) and (estado = %s or estado = %s) and usuarios.segmento <> %s", GetSQLValueString($colname2_opcdpa, "date"),GetSQLValueString($colname3_opcdpa, "date"),GetSQLValueString($colname4_opcdpa, "text"),GetSQLValueString($colname5_opcdpa, "text"),GetSQLValueString($colname6_opcdpa, "text"));
$opcdpa = mysqli_query($comercioexterior, $query_opcdpa) or die(mysqli_error());
$row_opcdpa = mysqli_fetch_assoc($opcdpa);
$totalRows_opcdpa = mysqli_num_rows($opcdpa);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Op Reparadas - Detalle</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
.Estilo2 {font-size: 9px; color: #0000FF; }
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #000;
}
body {
	background-image: url();
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FF0000;
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
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['ne']); ?></td>
      <td align="left" valign="middle">CARTA DE CR&Eacute;DITO DE IMPORTACI&Oacute;N</td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['evento']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['reparo_obs']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['estado']); ?></td>
    </tr>
    <?php } while ($row_DetailRS1 = mysqli_fetch_assoc($DetailRS1)); ?>
</table>
<br>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingresa</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opcce['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcce['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['ne']); ?></td>
      <td align="left" valign="middle">CARTA DE CR&Eacute;DITO DE EXPORTAC&Oacute;N</td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['evento']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['reparo_obs']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['estado']); ?></td>
    </tr>
    <?php } while ($row_opcce = mysqli_fetch_assoc($opcce)); ?>
</table>
<br>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opcbi['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcbi['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['ne']); ?></td>
      <td align="left" valign="middle">COBRANZA EXTRANJERA DE IMPORTACI&Oacute;N Y OPI</td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['evento']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['reparo_obs']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['estado']); ?></td>
    </tr>
    <?php } while ($row_opcbi = mysqli_fetch_assoc($opcbi)); ?>
</table>
<br>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opcbe['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcbe['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbe['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbe['seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbe['ne']); ?></td>
      <td align="left" valign="middle">COBRANZA EXTRANJERA DE EXPORTACI&Oacute;N</td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbe['evento']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbe['reparo_obs']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbe['estado']); ?></td>
    </tr>
    <?php } while ($row_opcbe = mysqli_fetch_assoc($opcbe)); ?>
</table>
<br>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_oppre['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_oppre['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['ne']); ?></td>
      <td align="left" valign="middle">PR&Eacute;STAMOS</td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['evento']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['reparo_obs']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['estado']); ?></td>
    </tr>
    <?php } while ($row_oppre = mysqli_fetch_assoc($oppre)); ?>
</table>
<br>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opmec['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opmec['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['ne']); ?></td>
      <td align="left" valign="middle">MERCADO DE CORREDORES</td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['evento']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['reparo_obs']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['estado']); ?></td>
    </tr>
    <?php } while ($row_opmec = mysqli_fetch_assoc($opmec)); ?>
</table>
<br>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opbga['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['ne']); ?></td>
      <td align="left" valign="middle">BOLETA DE GARAT&Iacute;A</td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['evento']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['reparo_obs']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['estado']); ?></td>
    </tr>
    <?php } while ($row_opbga = mysqli_fetch_assoc($opbga)); ?>
</table>
<br>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opsbe['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opsbe['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opsbe['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opsbe['seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opsbe['ne']); ?></td>
      <td align="left" valign="middle">STAND BY EMITIDA</td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opsbe['evento']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opsbe['reparo_obs']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opsbe['estado']); ?></td>
    </tr>
    <?php } while ($row_opsbe = mysqli_fetch_assoc($opsbe)); ?>
</table>
<br>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opstr['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opstr['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['ne']); ?></td>
      <td align="left" valign="middle">STAND BY RECIBIDA</td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['evento']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['reparo_obs']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['estado']); ?></td>
    </tr>
    <?php } while ($row_opstr = mysqli_fetch_assoc($opstr)); ?>
</table>
<br>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opcex['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcex['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['ne']); ?></td>
      <td align="left" valign="middle">CR&Eacute;DITO EXTERNO</td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['evento']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['reparo_obs']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['estado']); ?></td>
    </tr>
    <?php } while ($row_opcex = mysqli_fetch_assoc($opcex)); ?>
</table>
<br>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_optbc['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_optbc['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_optbc['nombre_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_optbc['seg']; ?></td>
      <td align="left" valign="middle"><?php echo $row_optbc['ne']; ?></td>
      <td align="left" valign="middle">IIIB5</td>
      <td align="left" valign="middle"><?php echo $row_optbc['evento']; ?></td>
      <td align="left" valign="middle"><?php echo $row_optbc['reparo_obs']; ?></td>
      <td align="left" valign="middle"><?php echo $row_optbc['estado']; ?></td>
    </tr>
    <?php } while ($row_optbc = mysqli_fetch_assoc($optbc)); ?>
</table>
<br>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Especialista </td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opcdpa['fecha_ingreso']; ?><a href="../../../territorial_original/controlsegmento/untitled.php?recordID=<?php echo $row_opcdpa['id']; ?>"></a></td>
      <td align="center" valign="middle"><?php echo $row_opcdpa['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['nombre_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['seg']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['ne']; ?></td>
      <td align="left" valign="middle">CESIONES DE DERECHO PAGO ANTICIPADO</td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['evento']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['reparo_obs']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['estado']; ?></td>
    </tr>
    <?php } while ($row_opcdpa = mysqli_fetch_assoc($opcdpa)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
mysqli_free_result($opcce);
mysqli_free_result($opcbi);
mysqli_free_result($opcbe);
mysqli_free_result($oppre);
mysqli_free_result($opmec);
mysqli_free_result($opbga);
mysqli_free_result($opsbe);
mysqli_free_result($opstr);
mysqli_free_result($opcex);
mysqli_free_result($optbc);
mysqli_free_result($opcdpa);
?>