<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=OP_Recibidas_Contabilizadas.xls"); 
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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_oprecibidas = "SELECT * FROM contabilidad_oprecibidas ORDER BY dias_pendientes DESC";
$oprecibidas = mysql_query($query_oprecibidas, $comercioexterior) or die(mysqli_error());
$row_oprecibidas = mysqli_fetch_assoc($oprecibidas);
$totalRows_oprecibidas = mysqli_num_rows($oprecibidas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bajar Orden de Pago Contabilizadas</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	color: #000;
}
-->
</style></head>
<body>
<table border="1" align="center">
  <tr>
    <td colspan="16" align="left" valign="middle">Son en Total <?php echo $totalRows_oprecibidas ?> Registros</td>
  </tr>
  <tr>
    <td align="center" valign="middle">Sucursal</td>
    <td align="center" valign="middle">Cuenta Contable</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre (En OP Recibida)</td>
    <td align="center" valign="middle">Moneda</td>
    <td align="center" valign="middle">Monto</td>
    <td align="center" valign="middle">Saldo</td>
    <td align="center" valign="middle">Nro de Vigente</td>
    <td align="center" valign="middle">Fecha de Ingreso</td>
    <td align="center" valign="middle">Dias Pendientes</td>
    <td align="center" valign="middle">Nombre Cliente (Base Banco)</td>
    <td align="center" valign="middle">Nombre Ejecutivo de Cuentas</td>
    <td align="center" valign="middle">Nombre Ejecutivo NI</td>
    <td align="center" valign="middle">Nombre Especialista NI</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Segmento</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_oprecibidas['sucursal']; ?></td>
      <td align="center" valign="middle"><?php echo $row_oprecibidas['cuenta']; ?></td>
      <td align="center" valign="middle"><?php echo $row_oprecibidas['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_oprecibidas['nombre']; ?></td>
      <td align="center" valign="middle"><?php echo $row_oprecibidas['moneda']; ?></td>
      <td align="right" valign="middle"><?php echo number_format($row_oprecibidas['monto'], 2, ',', '.'); ?></td>
      <td align="right" valign="middle"><?php echo number_format($row_oprecibidas['saldo'], 2, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo $row_oprecibidas['nro_vigente']; ?></td>
      <td align="center" valign="middle"><?php echo $row_oprecibidas['fecha_vigente']; ?></td>
      <td align="center" valign="middle"><?php echo $row_oprecibidas['dias_pendientes']; ?></td>
      <td align="left" valign="middle"><?php echo $row_oprecibidas['nombre_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_oprecibidas['ejecutivo_cuentas']; ?></td>
      <td align="left" valign="middle"><?php echo $row_oprecibidas['ejecutivo_ni']; ?></td>
      <td align="left" valign="middle"><?php echo $row_oprecibidas['post_venta']; ?></td>
      <td align="left" valign="middle"><?php echo $row_oprecibidas['territorial']; ?></td>
      <td align="left" valign="middle"><?php echo $row_oprecibidas['segmento']; ?></td>
    </tr>
    <?php } while ($row_oprecibidas = mysqli_fetch_assoc($oprecibidas)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($oprecibidas);
?>