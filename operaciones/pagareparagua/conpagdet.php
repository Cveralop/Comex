<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=nomina_pagare_paraguas.xls"); 
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
$colname_DetailRS1 = "-1";
if (isset($_GET['estado'])) {
  $colname_DetailRS1 = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM pagareparagua WHERE estado = %s", GetSQLValueString($colname_DetailRS1, "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Consulta Pagar&eacute; Paragua - Detalle</title>
<style type="text/css">
<!--
@import url("../../estilos/estilo12.css");
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
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
.Estilo5 {
	font-size: 16px;
	color: #FF0000;
	font-weight: bold;
}
.Estilo6 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script>
<!--
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
//-->
</script>
</head>
<body>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center">Fecha Ingreso</td>
    <td align="center">Fecha Sus. Pag.</td>
    <td align="center">Fecha Sus. Conv.</td>
    <td align="center">Rut Cliente</td>
    <td align="center">Nombre Cliente</td>
    <td align="center">Moneda / Monto Pagare</td>
    <td align="center">Moneda / Monto Convenio</td>
    <td align="center">Doc 1</td>
    <td align="center">Doc 2</td>
    <td align="center">Doc 3</td>
    <td align="center">Doc 4</td>
    <td align="center">Doc 5</td>
    <td align="center">Rut Aval 1</td>
    <td align="center">Rut Aval 2</td>
    <td align="center">Rut Aval 3</td>
    <td align="center">Rut Aval 4</td>
    <td align="center">Producto</td>
    <td align="center">Sucursal</td>
    <td align="center">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['fecha_suscripcion_pagare']; ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['fecha_suscripcion_convenio']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></td>
      <td align="right" valign="middle"><?php echo strtoupper($row_DetailRS1['moneda_pagare']); ?> <?php echo $row_DetailRS1['monto_pagare']; ?></td>
      <td align="right" valign="middle"><?php echo strtoupper($row_DetailRS1['moneda_convenio']); ?> <?php echo $row_DetailRS1['monto_convenio']; ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['doc_1']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['doc_2']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['doc_3']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['doc_4']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['doc_5']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['aval_rut_1']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['aval_rut_2']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['aval_rut_3']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['aval_rut_4']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['producto']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['sucursal']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['estado']); ?></td>
    </tr>
    <?php } while ($row_DetailRS1 = mysqli_fetch_assoc($DetailRS1)); ?>
</table>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>