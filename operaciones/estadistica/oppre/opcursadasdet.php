<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=oppre_cursadas.xls"); 
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

$colname2_DetailRS1 = "1";
if (isset($_GET['date_ini'])) {
  $colname2_DetailRS1 = $_GET['date_ini'];
}
$colname3_DetailRS1 = "1";
if (isset($_GET['date_fin'])) {
  $colname3_DetailRS1 = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT oppre.*,(usuarios.nombre)as ne,(usuarios.segmento)as seg FROM oppre, usuarios WHERE date_ingreso between %s and %s and (oppre.especialista_curse = usuarios.usuario) ORDER BY date_ingreso ASC", GetSQLValueString($colname2_DetailRS1, "date"),GetSQLValueString($colname3_DetailRS1, "date"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Op Cursadas - Detalle</title>
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
    <td colspan="8" align="left" valign="middle">Operaciones Ingresadas por Especialistas <?php echo $totalRows_DetailRS1 ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['seg']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['ne']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['tipo_operacion']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['evento']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['estado']); ?></td>
    </tr>
    <?php } while ($row_DetailRS1 = mysqli_fetch_assoc($DetailRS1)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>