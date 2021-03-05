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
$colname1_opcci = "Si";
if (isset($_GET['fuera_horario'])) {
  $colname1_opcci = $_GET['fuera_horario'];
}
$colname_opcci = "1";
if (isset($_GET['date_ingreso'])) {
  $colname_opcci = $_GET['date_ingreso'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcci = sprintf("SELECT * FROM opcce WHERE fuera_horario = %s and estado = %s and date_ingreso = %s and (especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s)", GetSQLValueString($colname1_opcci, "text"),GetSQLValueString($colname2_opcci, "text"),GetSQLValueString($colname_opcci, "date"),GetSQLValueString($colname3_opcci, "text"),GetSQLValueString($colname4_opcci, "text"),GetSQLValueString($colname5_opcci, "text"),GetSQLValueString($colname6_opcci, "text"),GetSQLValueString($colname7_opcci, "text"),GetSQLValueString($colname8_opcci, "text"));
$opcci = mysqli_query($comercioexterior, $query_opcci) or die(mysqli_error($comercioexterior));
$row_opcci = mysqli_fetch_assoc($opcci);
$totalRows_opcci = mysqli_num_rows($opcci);

$colname_opcce = "-1";
if (isset($_GET['date_ingreso'])) {
  $colname_opcce = $_GET['date_ingreso'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcce = sprintf("SELECT * FROM opcce WHERE date_ingreso = %s ", GetSQLValueString($colname_opcce, "date"));
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
    <td align="center" valign="middle">Productos</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Motivo</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opcci['date_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opcci['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcci['nombre_cliente']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opcci['segmento']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opcci['especialista_curse']; ?></td>
      <td align="center" valign="middle">Carta de Crédito Export.&nbsp; </td>
      <td align="center" valign="middle"><?php echo $row_opcci['evento']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opcci['reparo_obs']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opcci['estado']; ?></td>
    </tr>
    <?php } while ($row_opcci = mysqli_fetch_assoc($opcci)); ?>
</table>
<br />
</body>
</html>
<?php
mysqli_free_result($opcci);

mysqli_free_result($opcce);
?>