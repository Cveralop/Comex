<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=vcto_operaciones.xls"); 
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
if (isset($_GET['rut_ejecutivo'])) {
  $colname_DetailRS1 = $_GET['rut_ejecutivo'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM vctooperaciones WHERE rut_ejecutivo = %s ORDER BY fecha_vcto ASC", GetSQLValueString($colname_DetailRS1, "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>
<table width="95%" border="1">
  <tr>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Nro Operación</td>
    <td align="center" valign="middle">Nro Cuota</td>
    <td align="center" valign="middle">Moneda Operación</td>
    <td align="center" valign="middle">Saldo Operación</td>
    <td align="center" valign="middle">Fecha Vcto</td>
    <td align="center" valign="middle">Ejecutivo Ni</td>
    <td align="center" valign="middle">Post Venta</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['nombre_cliente']; ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['nro_operacion']; ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['secuencia']; ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['moneda']; ?></td>
      <td align="right" valign="middle"><?php echo number_format($row_DetailRS1['saldo_vigente'], 2, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['fecha_vcto']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['ejecutivo_ni']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['especialista_ni']; ?></td>
    </tr>
    <?php } while ($row_DetailRS1 = mysqli_fetch_assoc($DetailRS1)); ?>
</table>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>