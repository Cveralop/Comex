<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=cuadratura_goc_vs_subsidiario.xls"); 
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
$query_cuadratura = "SELECT cuadratura.*,(subcontable.nro_operacion)as nro_ope, (subcontable.rut_cliente)as rut_clie, (subcontable.nombre_cliente)as nom_clie FROM cuadratura LEFT JOIN subcontable ON cuadratura.nro_operacion = subcontable.nro_operacion";
$cuadratura = mysqli_query( $comercioexterior, $query_cuadratura) or die(mysqli_error( $comercioexterior));
$row_cuadratura = mysqli_fetch_assoc($cuadratura);
$totalRows_cuadratura = mysqli_num_rows($cuadratura);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cuadratura GOC v/s Contabilidad</title>
<style type="text/css">
<!--
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #000;
}
body {
	background-image: url();
}
a {
	font-size: 10px;
	color: #000;
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
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="7" align="center" valign="middle" bgcolor="#999999" class="titulopaguina">GESTOR DE OPERACIONES COMEX</td>
    <td colspan="3" align="center" valign="middle" bgcolor="#FF0000" class="titulopaguina">SUBSIDIARIO</td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Producto</td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado</td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operación</td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_cuadratura['date_curse']; ?></td>
      <td align="left" valign="middle"><?php echo $row_cuadratura['producto']; ?></td>
      <td align="left" valign="middle"><?php echo $row_cuadratura['evento']; ?></td>
      <td align="center" valign="middle"><?php echo $row_cuadratura['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_cuadratura['nombre_cliente']; ?></td>
      <td align="center" valign="middle"><?php echo $row_cuadratura['nro_operacion']; ?></td>
      <td align="center" valign="middle"><?php echo $row_cuadratura['estado']; ?></td>
      <td align="center" valign="middle"><?php echo $row_cuadratura['nro_ope']; ?></td>
      <td align="center" valign="middle"><?php echo $row_cuadratura['rut_clie']; ?></td>
      <td align="left" valign="middle"><?php echo $row_cuadratura['nom_clie']; ?></td>
    </tr>
    <?php } while ($row_cuadratura = mysqli_fetch_assoc($cuadratura)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($cuadratura);
?>