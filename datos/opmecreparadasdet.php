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

$colname2_opmec = "Reparada.";
if (isset($_GET['estado'])) {
  $colname2_opmec = $_GET['estado'];
}
$colname3_opmec = "rsoto";
if (isset($_GET['especialista_curse'])) {
  $colname3_opmec = $_GET['especialista_curse'];
}
$colname4_opmec = "mdvilla";
if (isset($_GET['especialista_curse'])) {
  $colname4_opmec = $_GET['especialista_curse'];
}
$colname5_opmec = "ameza";
if (isset($_GET['especialista_curse'])) {
  $colname5_opmec = $_GET['especialista_curse'];
}
$colname6_opmec = "efuentes";
if (isset($_GET['especialista_curse'])) {
  $colname6_opmec = $_GET['especialista_curse'];
}
$colname7_opmec = "jmarto1";
if (isset($_GET['especialista_curse'])) {
  $colname7_opmec = $_GET['especialista_curse'];
}
$colname8_opmec = "johannam";
if (isset($_GET['especialista_curse'])) {
  $colname8_opmec = $_GET['especialista_curse'];
}
$colname_opmec = "1";
if (isset($_GET['fecha_ingreso'])) {
  $colname_opmec = $_GET['fecha_ingreso'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opmec = sprintf("SELECT * FROM opmec WHERE estado = %s and fecha_ingreso = %s and (especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s and especialista_curse <> %s)", GetSQLValueString($colname2_opmec, "text"),GetSQLValueString($colname_opmec, "text"),GetSQLValueString($colname3_opmec, "text"),GetSQLValueString($colname4_opmec, "text"),GetSQLValueString($colname5_opmec, "text"),GetSQLValueString($colname6_opmec, "text"),GetSQLValueString($colname7_opmec, "text"),GetSQLValueString($colname8_opmec, "text"));
$opmec = mysqli_query($comercioexterior, $query_opmec) or die(mysqli_error($comercioexterior));
$row_opmec = mysqli_fetch_assoc($opmec);
$totalRows_opmec = mysqli_num_rows($opmec);
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
      <td align="center" valign="middle"><?php echo $row_opmec['date_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opmec['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opmec['nombre_cliente']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opmec['segmento']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opmec['especialista_curse']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opmec['evento']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opmec['evento']; ?></td>
      <td align="left" valign="middle"><?php echo $row_opmec['reparo_obs']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opmec['estado']; ?></td>
    </tr>
    <?php } while ($row_opmec = mysqli_fetch_assoc($opmec)); ?>
</table>
<br />
</body>
</html>
<?php
mysqli_free_result($opmec);
?>
