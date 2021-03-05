<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=negcondisc.xls"); 
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
$colname_negcondisc = "Negociacion.";
if (isset($_GET['evento'])) {
  $colname_negcondisc = $_GET['evento'];
}
$colname1_negcondisc = "Discrepancia.";
if (isset($_GET['tipo_negociacion'])) {
  $colname1_negcondisc = $_GET['tipo_negociacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_negcondisc = sprintf("SELECT * FROM opcci WHERE evento = %s and tipo_negociacion = %s", GetSQLValueString($colname_negcondisc, "text"),GetSQLValueString($colname1_negcondisc, "text"));
$negcondisc = mysqli_query($comercioexterior, $query_negcondisc) or die(mysqli_error($comercioexterior));
$row_negcondisc = mysqli_fetch_assoc($negcondisc);
$totalRows_negcondisc = mysqli_num_rows($negcondisc);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 9px;
}
-->
</style>
<script>
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
</head>
<body>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Nro Registro</td>
    <td align="center" valign="middle">Nro Operación</td>
    <td align="center" valign="middle">Fecha Curse</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Estado Operación</td>
    <td align="center" valign="middle">Moneda Documentos</td>
    <td align="center" valign="middle">Monto Documentos</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_negcondisc['id']; ?>&nbsp; </td>
      <td align="center" valign="middle"><?php echo strtoupper($row_negcondisc['nro_operacion']); ?>&nbsp; </td>
      <td align="center" valign="middle"><?php echo $row_negcondisc['fecha_curse']; ?>&nbsp; </td>
      <td align="center" valign="middle"><?php echo strtoupper($row_negcondisc['rut_cliente']); ?>&nbsp; </td>
      <td align="left" valign="middle"><?php echo strtoupper($row_negcondisc['nombre_cliente']); ?>&nbsp; </td>
      <td align="center" valign="middle"><?php echo $row_negcondisc['estado']; ?>&nbsp; </td>
      <td align="center" valign="middle"><?php echo strtoupper($row_negcondisc['moneda_documentos']); ?>&nbsp; </td>
      <td align="right" valign="middle"><?php echo number_format($row_negcondisc['monto_documentos'], 2, ',', '.'); ?>&nbsp; </td>
    </tr>
    <?php } while ($row_negcondisc = mysqli_fetch_assoc($negcondisc)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($negcondisc);
?>