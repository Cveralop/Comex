<?php require_once('../Connections/comercioexterior.php'); ?>
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

$colname2_opcce = "Reparada.";
if (isset($_GET['estado'])) {
  $colname2_opcce = $_GET['estado'];
}
$colname3_opcce = "rsoto";
if (isset($_GET['especialista_curse'])) {
  $colname3_opcce = $_GET['especialista_curse'];
}
$colname4_opcce = "mdvilla";
if (isset($_GET['especialista_curse'])) {
  $colname4_opcce = $_GET['especialista_curse'];
}
$colname5_opcce = "ameza";
if (isset($_GET['especialista_curse'])) {
  $colname5_opcce = $_GET['especialista_curse'];
}
$colname6_opcce = "efuentes";
if (isset($_GET['especialista_curse'])) {
  $colname6_opcce = $_GET['especialista_curse'];
}
$colname7_opcce = "jmarto1";
if (isset($_GET['especialista_curse'])) {
  $colname7_opcce = $_GET['especialista_curse'];
}
$colname8_opcce = "johannam";
if (isset($_GET['especialista_curse'])) {
  $colname8_opcce = $_GET['especialista_curse'];
}
$colname_opcce = "1";
if (isset($_GET['fecha_ingreso'])) {
  $colname_opcce = $_GET['fecha_ingreso'];
}
$colname9_opcce = "Apertura.";
if (isset($_GET['evento'])) {
  $colname9_opcce = $_GET['evento'];
}
$colname10_opcce = "Modificacion.";
if (isset($_GET['evento'])) {
  $colname10_opcce = $_GET['evento'];
}
$colname11_opcce = "Confirmacion.";
if (isset($_GET['evento'])) {
  $colname11_opcce = $_GET['evento'];
}
$colname12_opcce = "Negociacion.";
if (isset($_GET['evento'])) {
  $colname12_opcce = $_GET['evento'];
}
$colname13_opcce = "Alzamiento.";
if (isset($_GET['evento'])) {
  $colname13_opcce = $_GET['evento'];
}
$colname14_opcce = "Pago.";
if (isset($_GET['evento'])) {
  $colname14_opcce = $_GET['evento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcce = sprintf("SELECT * FROM opcce WHERE estado = %s and fecha_ingreso = %s and (especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s) and (evento = %s or evento = %s or evento = %s or evento = %s or evento = %s or %s = %s)", GetSQLValueString($colname2_opcce, "text"),GetSQLValueString($colname_opcce, "text"),GetSQLValueString($colname3_opcce, "text"),GetSQLValueString($colname4_opcce, "text"),GetSQLValueString($colname5_opcce, "text"),GetSQLValueString($colname6_opcce, "text"),GetSQLValueString($colname7_opcce, "text"),GetSQLValueString($colname8_opcce, "text"),GetSQLValueString($colname9_opcce, "text"),GetSQLValueString($colname10_opcce, "text"),GetSQLValueString($colname11_opcce, "text"),GetSQLValueString($colname12_opcce, "text"),GetSQLValueString($colname13_opcce, "text"),GetSQLValueString($colname_opcce, "text"),GetSQLValueString($colname14_opcce, "text"));
$opcce = mysqli_query($comercioexterior, $query_opcce) or die(mysqli_error($comercioexterior));
$row_opcce = mysqli_fetch_assoc($opcce);
$totalRows_opcce = mysqli_num_rows($opcce);
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
</style></head>

<body>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Fec ha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Motivo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opcce['date_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcce['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['nombre_cliente']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opcce['segmento']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcce['especialista_curse']); ?></td>
      <td align="center" valign="middle">CARTA DE CREDITO EXPORT.</td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcce['evento']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcce['reparo_obs']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcce['estado']); ?></td>
    </tr>
    <?php } while ($row_opcce = mysqli_fetch_assoc($opcce)); ?>
</table>
<br />
</body>
</html>
<?php
mysqli_free_result($opcce);
?>
