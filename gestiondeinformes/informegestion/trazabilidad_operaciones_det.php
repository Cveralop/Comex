<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=detalle_trazabilidad.xls"); 
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

$colname_trazabilidad_caragoc = "0";
if (isset($_GET['dif_ing_rec'])) {
  $colname_trazabilidad_caragoc = $_GET['dif_ing_rec'];
}
$colname1_trazabilidad_caragoc = "Caratula GOC";
if (isset($_GET['produco'])) {
  $colname1_trazabilidad_caragoc = $_GET['produco'];
}
$colname2_trazabilidad_caragoc = "-1";
if (isset($_GET['date_ini'])) {
  $colname2_trazabilidad_caragoc = $_GET['date_ini'];
}
$colname3_trazabilidad_caragoc = "-1";
if (isset($_GET['date_fin'])) {
  $colname3_trazabilidad_caragoc = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_trazabilidad_caragoc = sprintf("SELECT * FROM trasabilidad_transit nolock WHERE dif_ing_rec > %s and producto = %s and date(date_ing) between %s and %s", GetSQLValueString($colname_trazabilidad_caragoc, "int"),GetSQLValueString($colname1_trazabilidad_caragoc, "text"),GetSQLValueString($colname2_trazabilidad_caragoc, "date"),GetSQLValueString($colname3_trazabilidad_caragoc, "date"));
$trazabilidad_caragoc = mysqli_query($comercioexterior,$query_trazabilidad_caragoc) or die(mysqli_error($comercioexterior));
$row_trazabilidad_caragoc = mysqli_fetch_assoc($trazabilidad_caragoc);
$totalRows_trazabilidad_caragoc = mysqli_num_rows($trazabilidad_caragoc);

$colname_trazabilidad_espevisa = "Caratula GOC";
if (isset($_GET['producto'])) {
  $colname_trazabilidad_espevisa = $_GET['producto'];
}
$colname3_trazabilidad_espevisa = "0";
if (isset($_GET['dif_espe_visa'])) {
  $colname3_trazabilidad_espevisa = $_GET['dif_espe_visa'];
}
$colname1_trazabilidad_espevisa = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_trazabilidad_espevisa = $_GET['date_ini'];
}
$colname2_trazabilidad_espevisa = "-1";
if (isset($_GET['date_fin'])) {
  $colname2_trazabilidad_espevisa = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_trazabilidad_espevisa = sprintf("SELECT * FROM trasabilidad_transit nolockWHERE dif_espe_visa > %s and producto <> %s and date(date_espe) between %s and %s", GetSQLValueString($colname3_trazabilidad_espevisa, "int"),GetSQLValueString($colname_trazabilidad_espevisa, "text"),GetSQLValueString($colname1_trazabilidad_espevisa, "date"),GetSQLValueString($colname2_trazabilidad_espevisa, "date"));
$trazabilidad_espevisa = mysqli_query($comercioexterior, $query_trazabilidad_espevisa) or die(mysqli_error($comercioexterior));
$row_trazabilidad_espevisa = mysqli_fetch_assoc($trazabilidad_espevisa);
$totalRows_trazabilidad_espevisa = mysqli_num_rows($trazabilidad_espevisa);

$colname3_trazabilidad_visaasig = "0";
if (isset($_GET['dif_visa_asig'])) {
  $colname3_trazabilidad_visaasig = $_GET['dif_visa_asig'];
}
$colname_trazabilidad_visaasig = "Caratula GOC";
if (isset($_GET['producto'])) {
  $colname_trazabilidad_visaasig = $_GET['producto'];
}
$colname1_trazabilidad_visaasig = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_trazabilidad_visaasig = $_GET['date_ini'];
}
$colname2_trazabilidad_visaasig = "-1";
if (isset($_GET['date_fin'])) {
  $colname2_trazabilidad_visaasig = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_trazabilidad_visaasig = sprintf("SELECT * FROM trasabilidad_transit nolock WHERE dif_visa_asig > %s and producto <> %s and date(date_espe) between %s and %s", GetSQLValueString($colname3_trazabilidad_visaasig, "int"),GetSQLValueString($colname_trazabilidad_visaasig, "text"),GetSQLValueString($colname1_trazabilidad_visaasig, "date"),GetSQLValueString($colname2_trazabilidad_visaasig, "date"));
$trazabilidad_visaasig = mysqli_query($comercioexterior, $query_trazabilidad_visaasig) or die(mysqli_error($comercioexterior));
$row_trazabilidad_visaasig = mysqli_fetch_assoc($trazabilidad_visaasig);
$totalRows_trazabilidad_visaasig = mysqli_num_rows($trazabilidad_visaasig);

$colname3_trazabilidad_asigoper = "0";
if (isset($_GET['dif_asig_oper'])) {
  $colname3_trazabilidad_asigoper = $_GET['dif_asig_oper'];
}
$colname_trazabilidad_asigoper = "Caratula GOC";
if (isset($_GET['producto'])) {
  $colname_trazabilidad_asigoper = $_GET['producto'];
}
$colname1_trazabilidad_asigoper = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_trazabilidad_asigoper = $_GET['date_ini'];
}
$colname2_trazabilidad_asigoper = "-1";
if (isset($_GET['date_fin'])) {
  $colname2_trazabilidad_asigoper = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_trazabilidad_asigoper = sprintf("SELECT * FROM trasabilidad_transit nolock WHERE dif_asig_oper > %s and producto <> %s and date(date_espe) between %s and %s", GetSQLValueString($colname3_trazabilidad_asigoper, "int"),GetSQLValueString($colname_trazabilidad_asigoper, "text"),GetSQLValueString($colname1_trazabilidad_asigoper, "date"),GetSQLValueString($colname2_trazabilidad_asigoper, "date"));
$trazabilidad_asigoper = mysqli_query($comercioexterior, $query_trazabilidad_asigoper) or die(mysqli_error($comercioexterior));
$row_trazabilidad_asigoper = mysqli_fetch_assoc($trazabilidad_asigoper);
$totalRows_trazabilidad_asigoper = mysqli_num_rows($trazabilidad_asigoper);

$colname3_trazabilidad_opersupe = "0";
if (isset($_GET['dif_oper_supe'])) {
  $colname3_trazabilidad_opersupe = $_GET['dif_oper_supe'];
}
$colname_trazabilidad_opersupe = "Caratula GOC";
if (isset($_GET['producto'])) {
  $colname_trazabilidad_opersupe = $_GET['producto'];
}
$colname1_trazabilidad_opersupe = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_trazabilidad_opersupe = $_GET['date_ini'];
}
$colname2_trazabilidad_opersupe = "-1";
if (isset($_GET['date_fin'])) {
  $colname2_trazabilidad_opersupe = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_trazabilidad_opersupe = sprintf("SELECT * FROM trasabilidad_transit nolock WHERE dif_oper_supe > %s and producto <> %s and date(date_espe) between %s and %s", GetSQLValueString($colname3_trazabilidad_opersupe, "int"),GetSQLValueString($colname_trazabilidad_opersupe, "text"),GetSQLValueString($colname1_trazabilidad_opersupe, "date"),GetSQLValueString($colname2_trazabilidad_opersupe, "date"));
$trazabilidad_opersupe = mysqli_query($comercioexterior, $query_trazabilidad_opersupe) or die(mysqli_error($comercioexterior));
$row_trazabilidad_opersupe = mysqli_fetch_assoc($trazabilidad_opersupe);
$totalRows_trazabilidad_opersupe = mysqli_num_rows($trazabilidad_opersupe);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trazabilidad</title>
<style type="text/css">
<!--
body,td,th {
	font-size: 14px;
	color: #000;
}
-->
</style></head>
<body>
<table width="95%" border="1" align="center">
  <tr>
    <td colspan="10" align="left" valign="middle">Trazabilidad Caratulas GOC con un total de  <?php echo $totalRows_trazabilidad_caragoc ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle">No. Caratula</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Moneda / Monto Operación</td>
    <td align="center" valign="middle">Estado</td>
    <td align="center" valign="middle">Fecha Ingreso Caratula</td>
    <td align="center" valign="middle">Fecha Acuse Recibo Caratula</td>
    <td align="center" valign="middle">Dif. en Hora</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_caragoc['id']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_trazabilidad_caragoc['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_trazabilidad_caragoc['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo $row_trazabilidad_caragoc['producto']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_caragoc['evento']; ?></td>
      <td align="right" valign="middle"><?php echo $row_trazabilidad_caragoc['moneda_operacion']; ?> <?php echo number_format($row_trazabilidad_caragoc['monto_operacion'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_caragoc['estado']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_caragoc['date_ing']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_caragoc['date_rec']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_caragoc['dif_ing_rec']; ?></td>
    </tr>
    <?php } while ($row_trazabilidad_caragoc = mysqli_fetch_assoc($trazabilidad_caragoc)); ?>
</table>
<br />
<table width="95%" border="1" align="center">
  <tr>
    <td colspan="10" align="left" valign="middle">Trazabilidad Operaciones (Especialista v/s Visacion) con un total de <?php echo $totalRows_trazabilidad_espevisa ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle">No. Operación</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Moneda / Monto Operación</td>
    <td align="center" valign="middle">Estado</td>
    <td align="center" valign="middle">Fecha Ingreso Especialista</td>
    <td align="center" valign="middle">Fecha Visación</td>
    <td align="center" valign="middle">Dif. en Hora</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo strtoupper($row_trazabilidad_espevisa['nro_operacion']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_trazabilidad_espevisa['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_trazabilidad_espevisa['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo $row_trazabilidad_espevisa['producto']; ?></td>
      <td align="left" valign="middle"><?php echo $row_trazabilidad_espevisa['evento']; ?></td>
      <td align="right" valign="middle"><?php echo $row_trazabilidad_espevisa['moneda_operacion']; ?> <?php echo number_format($row_trazabilidad_espevisa['monto_operacion'], 2, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_espevisa['estado']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_espevisa['date_espe']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_espevisa['date_visa']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_espevisa['dif_espe_visa']; ?></td>
    </tr>
    <?php } while ($row_trazabilidad_espevisa = mysqli_fetch_assoc($trazabilidad_espevisa)); ?>
</table>
<br />
<table width="95%" border="1" align="center">
  <tr>
    <td colspan="10" align="left" valign="middle">Trazabilidad Operaciones (Visacion v/s Asignación) con un total de <?php echo $totalRows_trazabilidad_visaasig ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle">No. Operación</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Moneda / Monto Operación</td>
    <td align="center" valign="middle">Estado</td>
    <td align="center" valign="middle">Fecha Visación</td>
    <td align="center" valign="middle">Fecha Asignación</td>
    <td align="center" valign="middle">Dif. en Hora</td>
  </tr>
  <?php do { ?>
    <tr>
      <td height="42" align="center" valign="middle"><?php echo strtoupper($row_trazabilidad_visaasig['nro_operacion']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_trazabilidad_visaasig['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_trazabilidad_visaasig['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo $row_trazabilidad_visaasig['producto']; ?></td>
      <td align="left" valign="middle"><?php echo $row_trazabilidad_visaasig['evento']; ?></td>
      <td align="right" valign="middle"><?php echo $row_trazabilidad_visaasig['moneda_operacion']; ?> <?php echo number_format($row_trazabilidad_visaasig['monto_operacion'], 2, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_visaasig['estado']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_visaasig['date_visa']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_visaasig['date_asig']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_visaasig['dif_visa_asig']; ?></td>
    </tr>
    <?php } while ($row_trazabilidad_visaasig = mysqli_fetch_assoc($trazabilidad_visaasig)); ?>
</table>
<br />
<table width="95%" border="1" align="center">
  <tr>
    <td colspan="10" align="left" valign="middle">Trazabilidad Operaciones (Asignación v/s Alta Operador) con un total de <?php echo $totalRows_trazabilidad_asigoper ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle">No. Operación</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Moneda / Monto Operación</td>
    <td align="center" valign="middle">Estado</td>
    <td align="center" valign="middle">Fecha Asignación</td>
    <td align="center" valign="middle">Fecha Alta Operador</td>
    <td align="center" valign="middle">Dif. en Hora</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo strtoupper($row_trazabilidad_asigoper['nro_operacion']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_trazabilidad_asigoper['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_trazabilidad_asigoper['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo $row_trazabilidad_asigoper['producto']; ?></td>
      <td align="left" valign="middle"><?php echo $row_trazabilidad_asigoper['evento']; ?></td>
      <td align="right" valign="middle"><?php echo $row_trazabilidad_asigoper['moneda_operacion']; ?> <?php echo number_format($row_trazabilidad_asigoper['monto_operacion'], 2, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_asigoper['estado']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_asigoper['date_asig']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_asigoper['date_oper']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_asigoper['dif_asig_oper']; ?></td>
    </tr>
    <?php } while ($row_trazabilidad_asigoper = mysqli_fetch_assoc($trazabilidad_asigoper)); ?>
</table>
<br />
<table width="95%" border="1" align="center">
  <tr>
    <td colspan="10" align="left" valign="middle">Trazabilidad Operaciones (Alta Operador v/s Alta Supervisor) con un total de <?php echo $totalRows_trazabilidad_opersupe ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle">No. Operación</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Moneda / Monto Operación</td>
    <td align="center" valign="middle">Estado</td>
    <td align="center" valign="middle">Fecha Alta Operador</td>
    <td align="center" valign="middle">Fecha Alta Supervisor</td>
    <td align="center" valign="middle">Dif. en Hora</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo strtoupper($row_trazabilidad_opersupe['nro_operacion']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_trazabilidad_opersupe['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_trazabilidad_opersupe['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo $row_trazabilidad_opersupe['producto']; ?></td>
      <td align="left" valign="middle"><?php echo $row_trazabilidad_opersupe['evento']; ?></td>
      <td align="right" valign="middle"><?php echo $row_trazabilidad_opersupe['moneda_operacion']; ?> <?php echo number_format($row_trazabilidad_opersupe['monto_operacion'], 2, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_opersupe['estado']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_opersupe['date_oper']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_opersupe['date_supe']; ?></td>
      <td align="center" valign="middle"><?php echo $row_trazabilidad_opersupe['dif_oper_supe']; ?></td>
    </tr>
    <?php } while ($row_trazabilidad_opersupe = mysqli_fetch_assoc($trazabilidad_opersupe)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($trazabilidad_caragoc);
mysqli_free_result($trazabilidad_espevisa);
mysqli_free_result($trazabilidad_visaasig);
mysqli_free_result($trazabilidad_asigoper);
mysqli_free_result($trazabilidad_opersupe);
?>