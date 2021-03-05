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

$colname2_opcci = "Reparada.";
if (isset($_GET['estado'])) {
  $colname2_opcci = $_GET['estado'];
}
$colname9_opcci = "Apertura.";
if (isset($_GET['evento'])) {
  $colname9_opcci = $_GET['evento'];
}
$colname10_opcci = "Modificacion.";
if (isset($_GET['evento'])) {
  $colname10_opcci = $_GET['evento'];
}
$colname11_opcci = "Modificacion.";
if (isset($_GET['evento'])) {
  $colname11_opcci = $_GET['evento'];
}
$colname3_opcci = "rsoto";
if (isset($_GET['especialista_curse'])) {
  $colname3_opcci = $_GET['especialista_curse'];
}
$colname4_opcci = "mdvilla";
if (isset($_GET['especialista_curse'])) {
  $colname4_opcci = $_GET['especialista_curse'];
}
$colname5_opcci = "ameza";
if (isset($_GET['especialista_curse'])) {
  $colname5_opcci = $_GET['especialista_curse'];
}
$colname6_opcci = "efuentes";
if (isset($_GET['especialista_curse'])) {
  $colname6_opcci = $_GET['especialista_curse'];
}
$colname7_opcci = "jmarto1";
if (isset($_GET['especialista_curse'])) {
  $colname7_opcci = $_GET['especialista_curse'];
}
$colname8_opcci = "johannam";
if (isset($_GET['especialista_curse'])) {
  $colname8_opcci = $_GET['especialista_curse'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcci = sprintf("SELECT * FROM opcci WHERE estado = %s and (especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s) and (evento = %s or evento = %s or evento = %s)", GetSQLValueString($colname2_opcci, "text"),GetSQLValueString($colname3_opcci, "text"),GetSQLValueString($colname4_opcci, "text"),GetSQLValueString($colname5_opcci, "text"),GetSQLValueString($colname6_opcci, "text"),GetSQLValueString($colname7_opcci, "text"),GetSQLValueString($colname8_opcci, "text"),GetSQLValueString($colname9_opcci, "text"),GetSQLValueString($colname10_opcci, "text"),GetSQLValueString($colname11_opcci, "text"));
$opcci = mysqli_query($comercioexterior, $query_opcci) or die(mysqli_error($comercioexterior));
$row_opcci = mysqli_fetch_assoc($opcci);
$colname_opcci = "1";
if (isset($_GET['fecha_ingreso'])) {
  $colname_opcci = $_GET['fecha_ingreso'];
}
$colname9_opcci = "Apertura.";
if (isset($_GET['evento'])) {
  $colname9_opcci = $_GET['evento'];
}
$colname10_opcci = "Modificacion.";
if (isset($_GET['evento'])) {
  $colname10_opcci = $_GET['evento'];
}
$colname11_opcci = "Modificacion.";
if (isset($_GET['evento'])) {
  $colname11_opcci = $_GET['evento'];
}
$colname3_opcci = "rsoto";
if (isset($_GET['especialista_curse'])) {
  $colname3_opcci = $_GET['especialista_curse'];
}
$colname4_opcci = "mdvilla";
if (isset($_GET['especialista_curse'])) {
  $colname4_opcci = $_GET['especialista_curse'];
}
$colname5_opcci = "ameza";
if (isset($_GET['especialista_curse'])) {
  $colname5_opcci = $_GET['especialista_curse'];
}
$colname6_opcci = "efuentes";
if (isset($_GET['especialista_curse'])) {
  $colname6_opcci = $_GET['especialista_curse'];
}
$colname7_opcci = "jmarto1";
if (isset($_GET['especialista_curse'])) {
  $colname7_opcci = $_GET['especialista_curse'];
}
$colname8_opcci = "johannam";
if (isset($_GET['especialista_curse'])) {
  $colname8_opcci = $_GET['especialista_curse'];
}
$colname2_opcci = "Reparada.";
if (isset($_GET['estado'])) {
  $colname2_opcci = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcci = sprintf("SELECT * FROM opcci WHERE fecha_ingreso = %s and estado = %s and (especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s) and (evento = %s or evento = %s or evento = %s)", GetSQLValueString($colname_opcci, "text"),GetSQLValueString($colname2_opcci, "text"),GetSQLValueString($colname3_opcci, "text"),GetSQLValueString($colname4_opcci, "text"),GetSQLValueString($colname5_opcci, "text"),GetSQLValueString($colname6_opcci, "text"),GetSQLValueString($colname7_opcci, "text"),GetSQLValueString($colname8_opcci, "text"),GetSQLValueString($colname9_opcci, "text"),GetSQLValueString($colname10_opcci, "text"),GetSQLValueString($colname11_opcci, "text"));
$opcci = mysqli_query($comercioexterior, $query_opcci) or die(mysqli_error($comercioexterior));
$row_opcci = mysqli_fetch_assoc($opcci);
$totalRows_opcci = mysqli_num_rows($opcci);
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
    <td align="center" valign="middle">Fecha Ingreso</td>
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
      <td align="center" valign="middle"><?php echo $row_opcci['date_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['nombre_cliente']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opcci['segmento']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['especialista_curse']); ?></td>
      <td align="center" valign="middle">CARTA DE CREDITO IMPORT.</td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['evento']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['reparo_obs']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['estado']); ?></td>
    </tr>
    <?php } while ($row_opcci = mysqli_fetch_assoc($opcci)); ?>
</table>
<br />
</body>
</html>
<?php
mysqli_free_result($opcci);
?>
