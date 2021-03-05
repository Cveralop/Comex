<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=estado_operaciones.xls"); 
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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcci = sprintf("SELECT opcci.*,(cliente.segmento)as seg, (cliente.sub_segmento)as sub_seg, (cliente.sucursal)as suc, (cliente.oficina)as ofi, (cliente.territorial)as terr, (cliente.zonal)as zo, (cliente.nombre_ejecutivo)as eje, (cliente.ejecutivo)as ejeni, (cliente.especialista)as esp FROM opcci LEFT JOIN cliente ON opcci.rut_cliente=cliente.rut_cliente WHERE opcci.date_ingreso between %s and %s", GetSQLValueString($colname2_opcci, "date"),GetSQLValueString($colname3_opcci, "date"));
$opcci = mysqli_query($comercioexterior, $query_opcci) or die(mysqli_error());
$row_opcci = mysqli_fetch_assoc($opcci);
$totalRows_opcci = mysqli_num_rows($opcci);
$colname2_opcce = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opcce = $_GET['date_ini'];
}
$colname6_opcce = "BMG";
if (isset($_GET['segmento'])) {
  $colname6_opcce = $_GET['segmento'];
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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcbi = sprintf("SELECT opcbi.*,(cliente.segmento)as seg, (cliente.sub_segmento)as sub_seg, (cliente.sucursal)as suc, (cliente.oficina)as ofi, (cliente.territorial)as terr, (cliente.zonal)as zo, (cliente.nombre_ejecutivo)as eje, (cliente.ejecutivo)as ejeni, (cliente.especialista)as esp FROM opcbi LEFT JOIN cliente ON opcbi.rut_cliente=cliente.rut_cliente WHERE opcbi.date_ingreso between %s and %s", GetSQLValueString($colname2_opcbi, "date"),GetSQLValueString($colname3_opcbi, "date"));
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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcbe = sprintf("SELECT opcbe.*,(cliente.segmento)as seg, (cliente.sub_segmento)as sub_seg, (cliente.sucursal)as suc, (cliente.oficina)as ofi, (cliente.territorial)as terr, (cliente.zonal)as zo, (cliente.nombre_ejecutivo)as eje, (cliente.ejecutivo)as ejeni, (cliente.especialista)as esp FROM opcbe LEFT JOIN cliente ON opcbe.rut_cliente=cliente.rut_cliente WHERE opcbe.date_ingreso between %s and %s", GetSQLValueString($colname2_opcbe, "date"),GetSQLValueString($colname3_opcbe, "date"));
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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_oppre = sprintf("SELECT oppre.*,(cliente.segmento)as seg, (cliente.sub_segmento)as sub_seg, (cliente.sucursal)as suc, (cliente.oficina)as ofi, (cliente.territorial)as terr, (cliente.zonal)as zo, (cliente.nombre_ejecutivo)as eje, (cliente.ejecutivo)as ejeni, (cliente.especialista)as esp FROM oppre LEFT JOIN cliente ON oppre.rut_cliente=cliente.rut_cliente WHERE oppre.date_ingreso between %s and %s", GetSQLValueString($colname2_oppre, "date"),GetSQLValueString($colname3_oppre, "date"));
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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opmec = sprintf("SELECT opmec.*,(cliente.segmento)as seg, (cliente.sub_segmento)as sub_seg, (cliente.sucursal)as suc, (cliente.oficina)as ofi, (cliente.territorial)as terr, (cliente.zonal)as zo, (cliente.nombre_ejecutivo)as eje, (cliente.ejecutivo)as ejeni, (cliente.especialista)as esp FROM opmec LEFT JOIN cliente ON opmec.rut_cliente=cliente.rut_cliente WHERE opmec.date_ingreso between %s and %s", GetSQLValueString($colname2_opmec, "date"),GetSQLValueString($colname3_opmec, "date"));
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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opbga = sprintf("SELECT opbga.*,(cliente.segmento)as seg, (cliente.sub_segmento)as sub_seg, (cliente.sucursal)as suc, (cliente.oficina)as ofi, (cliente.territorial)as terr, (cliente.zonal)as zo, (cliente.nombre_ejecutivo)as eje, (cliente.ejecutivo)as ejeni, (cliente.especialista)as esp FROM opbga LEFT JOIN cliente ON opbga.rut_cliente=cliente.rut_cliente WHERE opbga.date_ingreso between %s and %s", GetSQLValueString($colname2_opbga, "date"),GetSQLValueString($colname3_opbga, "text"));
$opbga = mysqli_query($comercioexterior, $query_opbga) or die(mysqli_error());
$row_opbga = mysqli_fetch_assoc($opbga);
$totalRows_opbga = mysqli_num_rows($opbga);
$colname2_opste = "-1";
if (isset($_GET['date_ini'])) {
  $colname2_opste = $_GET['date_ini'];
}
$colname3_opste = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opste = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opste = sprintf("SELECT opste.*,(cliente.segmento)as seg, (cliente.sub_segmento)as sub_seg, (cliente.sucursal)as suc, (cliente.oficina)as ofi, (cliente.territorial)as terr, (cliente.zonal)as zo, (cliente.nombre_ejecutivo)as eje, (cliente.ejecutivo)as ejeni, (cliente.especialista)as esp FROM opste LEFT JOIN cliente ON opste.rut_cliente=cliente.rut_cliente WHERE opste.date_ingreso between %s and %s", GetSQLValueString($colname2_opste, "date"),GetSQLValueString($colname3_opste, "date"));
$opste = mysqli_query($comercioexterior, $query_opste) or die(mysqli_error());
$row_opste = mysqli_fetch_assoc($opste);
$totalRows_opste = mysqli_num_rows($opste);
$colname2_opstr = "-1";
if (isset($_GET['date_ini'])) {
  $colname2_opstr = $_GET['date_ini'];
}
$colname3_opstr = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opstr = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opstr = sprintf("SELECT opstr.*,(cliente.segmento)as seg, (cliente.sub_segmento)as sub_seg, (cliente.sucursal)as suc, (cliente.oficina)as ofi, (cliente.territorial)as terr, (cliente.zonal)as zo, (cliente.nombre_ejecutivo)as eje, (cliente.ejecutivo)as ejeni, (cliente.especialista)as esp FROM opstr LEFT JOIN cliente ON opstr.rut_cliente=cliente.rut_cliente WHERE opstr.date_ingreso between %s and %s", GetSQLValueString($colname2_opstr, "date"),GetSQLValueString($colname3_opstr, "date"));
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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcex = sprintf("SELECT opcex.*,(cliente.segmento)as seg, (cliente.sub_segmento)as sub_seg, (cliente.sucursal)as suc, (cliente.oficina)as ofi, (cliente.territorial)as terr, (cliente.zonal)as zo, (cliente.nombre_ejecutivo)as eje, (cliente.ejecutivo)as ejeni, (cliente.especialista)as esp FROM opcex LEFT JOIN cliente ON opcex.rut_cliente=cliente.rut_cliente WHERE opcex.date_ingreso between %s and %s", GetSQLValueString($colname2_opcex, "date"),GetSQLValueString($colname3_opcex, "date"));
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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_optbc = sprintf("SELECT optbc.*,(cliente.segmento)as seg, (cliente.sub_segmento)as sub_seg, (cliente.sucursal)as suc, (cliente.oficina)as ofi, (cliente.territorial)as terr, (cliente.zonal)as zo, (cliente.nombre_ejecutivo)as eje, (cliente.ejecutivo)as ejeni, (cliente.especialista)as esp FROM optbc LEFT JOIN cliente ON optbc.rut_cliente=cliente.rut_cliente WHERE optbc.date_ingreso between %s and %s", GetSQLValueString($colname2_optbc, "date"),GetSQLValueString($colname3_optbc, "date"));
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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcdpa = sprintf("SELECT opcdpa.*,(cliente.segmento)as seg, (cliente.sub_segmento)as sub_seg, (cliente.sucursal)as suc, (cliente.oficina)as ofi, (cliente.territorial)as terr, (cliente.zonal)as zo, (cliente.nombre_ejecutivo)as eje, (cliente.ejecutivo)as ejeni, (cliente.especialista)as esp FROM opcdpa LEFT JOIN cliente ON opcdpa.rut_cliente=cliente.rut_cliente WHERE opcdpa.date_ingreso between %s and %s", GetSQLValueString($colname2_opcdpa, "date"),GetSQLValueString($colname3_opcdpa, "date"));
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
@import url("../../../estilos/estilo12.css");
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
</head>
<body>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Sub Segmento</td>
    <td align="center" valign="middle">Sucursal</td>
    <td align="center" valign="middle">Oficina</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Zonal</td>
    <td align="center" valign="middle">Ejecutivo Cuenta</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opcci['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['sub_seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['suc']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['ofi']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['terr']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['zo']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['eje']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['ejeni']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['esp']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['especialista_curse']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['territorial']); ?></td>
      <td align="left" valign="middle">CARTA DE CR&Eacute;DITO DE IMPORTACI&Oacute;N</td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['evento']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['reparo_obs']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['estado']); ?></td>
    </tr>
    <?php } while ($row_opcci = mysqli_fetch_assoc($opcci)); ?>
</table>
<br>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingresa</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Sub Segmento</td>
    <td align="center" valign="middle">Sucursal</td>
    <td align="center" valign="middle">Oficina</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Zonal</td>
    <td align="center" valign="middle">Ejecutivo Cuenta</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Territorial</td>
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
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['sub_seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['suc']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['ofi']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['terr']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['zo']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['eje']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['ejeni']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['esp']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['especialista_curse']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['territorial']); ?></td>
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
    <td align="center" valign="middle">Sub Segmento</td>
    <td align="center" valign="middle">Sucursal</td>
    <td align="center" valign="middle">Oficina</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Zonal</td>
    <td align="center" valign="middle">Ejecutivo Cuenta</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Expecialista</td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Territorial</td>
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
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['sub_seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['suc']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['ofi']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['terr']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['zo']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['eje']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['ejeni']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['esp']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['especialista_curse']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['territorial']); ?></td>
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
    <td align="center" valign="middle">Sub Segmento</td>
    <td align="center" valign="middle">Sucursal</td>
    <td align="center" valign="middle">Oficina</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Zonal</td>
    <td align="center" valign="middle">Ejecutivo Cuenta</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Territorial</td>
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
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['sub_seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['suc']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['ofi']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['terr']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['zo']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbi['eje']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbe['ejeni']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbe['esp']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbe['especialista_curse']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcbe['territorial']); ?></td>
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
    <td align="center" valign="middle">Sub Segmento</td>
    <td align="center" valign="middle">Sucursal</td>
    <td align="center" valign="middle">Oficina</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Zonal</td>
    <td align="center" valign="middle">Ejecutivo Cuenta</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Territorial</td>
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
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['sub_seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['suc']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['ofi']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['terr']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['zo']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['eje']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['ejeni']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['esp']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['especialista_curse']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_oppre['territorial']); ?></td>
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
    <td align="center" valign="middle">Sub Segmento</td>
    <td align="center" valign="middle">Sucursal</td>
    <td align="center" valign="middle">Oficina</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Zonal</td>
    <td align="center" valign="middle">Ejecutivo Cuenta</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Territorial</td>
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
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['sub_seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['suc']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['ofi']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['terr']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['zo']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['eje']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['ejeni']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['esp']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['especialista_curse']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opmec['territorial']); ?></td>
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
    <td align="center" valign="middle">Sub Segmento</td>
    <td align="center" valign="middle">Sucursal</td>
    <td align="center" valign="middle">Oficina</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Zonal</td>
    <td align="center" valign="middle">Ejecutivo Cuenta</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Territorial</td>
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
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['sub_seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['suc']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['ofi']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['terr']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['zo']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['eje']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['ejeni']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['esp']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['especialista_curse']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['territorial']); ?></td>
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
    <td align="center" valign="middle">Sub Segmento</td>
    <td align="center" valign="middle">Sucursal</td>
    <td align="center" valign="middle">Oficina</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Zonal</td>
    <td align="center" valign="middle">Ejecutivo Cuenta</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opste['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['sub_sec']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['suc']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['ofi']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['terr']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['zo']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['eje']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['ejeni']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['esp']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['especialista_curse']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['territorial']); ?></td>
      <td align="left" valign="middle">STAND BY EMITIDA</td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['evento']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['reparo_obs']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['estado']); ?></td>
    </tr>
    <?php } while ($row_opste = mysqli_fetch_assoc($opste)); ?>
</table>
<br>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Sub Segmento</td>
    <td align="center" valign="middle">Sucursal</td>
    <td align="center" valign="middle">Oficina</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Zonal</td>
    <td align="center" valign="middle">Ejecutivo Cuenta</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Territorial</td>
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
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['sub_seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['suc']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['ofi']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['terr']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['zo']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['eje']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['ejeni']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['esp']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['especialista_curse']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opstr['territorial']); ?></td>
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
    <td align="center" valign="middle">Sub Segmento</td>
    <td align="center" valign="middle">Sucursal</td>
    <td align="center" valign="middle">Oficina</td>
    <td align="center" valign="middle">Territoriaal</td>
    <td align="center" valign="middle">Zonal</td>
    <td align="center" valign="middle">Ejecutivo Cuenta</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Territorial</td>
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
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['sub_seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['suc']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['ofi']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['terr']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['zo']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['eje']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['ejeni']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['esp']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['especialista_curse']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcex['territorial']); ?></td>
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
    <td align="center" valign="middle">Sub Segmento</td>
    <td align="center" valign="middle">Sucursal</td>
    <td align="center" valign="middle">Oficina</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Zonal</td>
    <td align="center" valign="middle">Ejecutivo Cuenta</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Especialsita Curse</td>
    <td align="center" valign="middle">Territorial</td>
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
      <td align="left" valign="middle"><?php echo $row_optbc['sub_seg']; ?></td>
      <td align="left" valign="middle"><?php echo $row_optbc['suc']; ?></td>
      <td align="left" valign="middle"><?php echo $row_optbc['ofi']; ?></td>
      <td align="left" valign="middle"><?php echo $row_optbc['terr']; ?></td>
      <td align="left" valign="middle"><?php echo $row_optbc['zo']; ?></td>
      <td align="left" valign="middle"><?php echo $row_optbc['eje']; ?></td>
      <td align="left" valign="middle"><?php echo $row_optbc['ejeni']; ?></td>
      <td align="left" valign="middle"><?php echo $row_optbc['esp']; ?></td>
      <td align="left" valign="middle"><?php echo $row_optbc['especialista_curse']; ?></td>
      <td align="left" valign="middle"><?php echo $row_optbc['territorial']; ?></td>
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
    <td align="center" valign="middle">Sub Segmento</td>
    <td align="center" valign="middle">Sucursal</td>
    <td align="center" valign="middle">Oficina</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Zonal</td>
    <td align="center" valign="middle">Ejecutivo Cuenta</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Especialista </td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Detalle Reparo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opcdpa['fecha_ingreso']; ?><a href="../controlsegmento/untitled.php?recordID=<?php echo $row_opcdpa['id']; ?>"></a></td>
      <td align="center" valign="middle"><?php echo $row_opcdpa['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['nombre_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['seg']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['sub_seg']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['suc']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['ofi']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['terr']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['zo']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['eje']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['ejeni']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['esp']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['especialista_curse']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcdpa['territorial']; ?></td>
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
mysqli_free_result($opcdpa);
mysqli_free_result($opcci);
?>