<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=excepciones.xls"); 
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

$colname_excepciones = "Pendiente.";
if (isset($_GET['estado_excepcion'])) {
  $colname_excepciones = $_GET['estado_excepcion'];
}
$colname1_excepciones = "Si";
if (isset($_GET['excepcion'])) {
  $colname1_excepciones = $_GET['excepcion'];
}
$colname2_excepciones = "Cursada.";
if (isset($_GET['estado'])) {
  $colname2_excepciones = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_excepciones = sprintf("SELECT excepciones.*,(usuarios.nombre)as ne, (usuarios.segmento)as seg ,timestampdiff(day,vcto_excepcion,current_timestamp)as dias FROM excepciones, usuarios WHERE estado_excepcion = %s and excepcion = %s and estado = %s and (excepciones.especialista_curse = usuarios.usuario) ORDER BY dias ASC", GetSQLValueString($colname_excepciones, "text"),GetSQLValueString($colname1_excepciones, "text"),GetSQLValueString($colname2_excepciones, "text"));
$excepciones = mysqli_query($comercioexterior, $query_excepciones) or die(mysqli_error($comercioexterior));
$row_excepciones = mysqli_fetch_assoc($excepciones);
$totalRows_excepciones = mysqli_num_rows($excepciones);

$colname_excepciones = "Pendiente.";
if (isset($_GET['estado_excepciones'])) {
  $colname_excepciones = $_GET['estado_excepciones'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_excepciones = sprintf("SELECT * FROM excepciones nolock WHERE estado_excepcion = %s ORDER BY plazo DESC", GetSQLValueString($colname_excepciones, "text"));
$excepciones = mysqli_query($comercioexterior, $query_excepciones) or die(mysqli_error($comercioexterior));
$row_excepciones = mysqli_fetch_assoc($excepciones);
$totalRows_excepciones = mysqli_num_rows($excepciones);

mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_plazo = "SELECT * FROM plazo nolock";
$plazo = mysqli_query($comercioexterior, $query_plazo) or die(mysqli_error($comercioexterior));
$row_plazo = mysqli_fetch_assoc($plazo);
$totalRows_plazo = mysqli_num_rows($plazo);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Listado Excepciones - Completo</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo10 {font-size: 12px}
.Estilo11 {color: #00FF00}
-->
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="95%" border="1" align="center">
  <tr valign="middle">
    <td align="center" valign="middle">Ejecutivo de Cuenta</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Canal</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nro Operaci&oacute;n </td>
    <td align="center" valign="middle">Tipo Excepci&ograve;n</td>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Vcto Excepcion</td>
    <td align="center" valign="middle">Plazo</td>
    <td align="center" valign="middle">En Plazo / Fuera de Plazo</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Especialista NI</td>
    <td align="center" valign="middle">Responsable Excepci&ograve;n</td>
    <td align="center" valign="middle">Autorizado en Operaciones Por</td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="left" valign="middle"><?php echo strtoupper($row_excepciones['ejecutivo_cuenta']); ?></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_excepciones['segmento_comercial']); ?></td>
    <td align="left" valign="middle"><?php echo $row_excepciones['territorial']; ?></td>
    <td align="left" valign="middle"><?php echo $row_excepciones['nombre_cliente']; ?></td>
    <td align="center" valign="middle"><?php echo $row_excepciones['rut_cliente']; ?></td>
    <td align="left" valign="middle"><?php echo $row_excepciones['nro_operacion']; ?></td>
    <td align="left" valign="middle"><?php echo $row_excepciones['tipo_excepcion']; ?></td>
    <td align="center" valign="middle"><?php echo $row_excepciones['fecha_ingreso']; ?></td>
    <td align="center" valign="middle"><?php echo $row_excepciones['vcto_excepcion']; ?></td>
    <td align="center" valign="middle"><?php echo $row_excepciones['plazo']; ?></td>
    <td align="center" valign="middle"><?php echo $row_excepciones['enplazo_fueraplazo']; ?></td>
    <td align="left" valign="middle"><?php echo $row_excepciones['producto']; ?></td>
    <td align="left" valign="middle"><?php echo $row_excepciones['evento']; ?></td>
    <td align="left" valign="middle"><?php echo $row_excepciones['especialista_ni']; ?></td>
    <td align="left" valign="middle"><?php echo $row_excepciones['responsable_excepcion']; ?></td>
    <td align="left" valign="middle"><?php echo $row_excepciones['autorizacion_operaciones']; ?></td>
    </tr>
  <?php } while ($row_excepciones = mysqli_fetch_assoc($excepciones)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($excepciones);
mysqli_free_result($plazo);
?>