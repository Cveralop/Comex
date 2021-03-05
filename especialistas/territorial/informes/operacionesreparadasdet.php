<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=opera_repa_terr.xls"); 
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
$colname2_opcci = "TER";
if (isset($_GET['perfil'])) {
  $colname2_opcci = $_GET['perfil'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcci = sprintf("SELECT * FROM oppendientes WHERE perfil = %s ORDER BY date_espe ASC", GetSQLValueString($colname2_opcci, "text"));
$opcci = mysqli_query($comercioexterior, $query_opcci) or die(mysqli_error());
$row_opcci = mysqli_fetch_assoc($opcci);
$totalRows_opcci = mysqli_num_rows($opcci);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Op Reparadas - Detalle</title>
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
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Fecha Especialista</td>
    <td align="center" valign="middle">Fecha Asignaci&oacute;n</td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Operador</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Motivo Reparo</td>
    <td align="center" valign="middle">Nro Operaci&oacute;n</td>
    <td align="center" valign="middle">Moneda / Monto Operaci&oacute;n</td>
    <td align="center" valign="middle">Urgente</td>
    <td align="center" valign="middle">Fuera Horario</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['nombre_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['date_espe']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['date_asig']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['especialista_curse']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['territorial']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['operador']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['producto']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['evento']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['reparo_obs']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['nro_operacion']); ?></td>
      <td align="right" valign="middle"><?php echo strtoupper($row_opcci['moneda_operacion'])?> <?php echo number_format($row_opcci['monto_operacion'], 2, ',', '.'); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['urgente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['fuera_horario']); ?></td>
    </tr>
    <?php } while ($row_opcci = mysqli_fetch_assoc($opcci)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($opcci);
?>