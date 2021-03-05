<?php require_once('../../Connections/comercioexterior.php'); ?>
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

$colname_devengonro = "-1";
if (isset($_GET['fecha_vcto'])) {
  $colname_devengonro = $_GET['fecha_vcto'];
}
$colname2_devengonro = "Si";
if (isset($_GET['pago_automatico'])) {
  $colname2_devengonro = $_GET['pago_automatico'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_devengonro = sprintf("SELECT devengo.*,(pago_automatico.ctemn)as mn, (pago_automatico.ctemx)as mx FROM devengo, pago_automatico WHERE devengo.fecha_vcto <= %s and (devengo.nro_operacion = pago_automatico.nro_operacion) and pago_automatico.pago_automatico = %s ORDER BY fecha_vcto ASC", GetSQLValueString($colname_devengonro, "text"),GetSQLValueString($colname2_devengonro, "text"));
$devengonro = mysqli_query($comercioexterior, $query_devengonro) or die(mysqli_error());
$row_devengonro = mysqli_fetch_assoc($devengonro);
$totalRows_devengonro = mysqli_num_rows($devengonro);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operaciones Pago Automatico</title>
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
	color: #00F;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
}
-->
</style>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">OPERACIONES PAGO AUTOMATICO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">BUSQUEDA POR FECHA DE VCTO</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" bgcolor="#999999" class="titulo_menu"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" />Busqueda por Fecha de Vencimiento</td>
    </tr>
    <tr>
      <td width="19%" align="right">Vencimiento</td>
      <td width="81%" align="left"><label>
        <input name="fecha_vcto" type="text" class="etiqueta12" id="fecha_vcto" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" />
      <span class="rojopequeno">(aaaa-mm-dd)</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar" />
        <input name="button2" type="reset" class="boton" id="button2" value="Limpiar" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../oppre/prestamos.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_devengonro > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
      <td bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
      <td bgcolor="#999999" class="titulocolumnas">Secuencia</td>
      <td bgcolor="#999999" class="titulocolumnas">Moneda</td>
      <td bgcolor="#999999" class="titulocolumnas">Monto Origen Operación</td>
      <td bgcolor="#999999" class="titulocolumnas">Valor Cuota a Pagar</td>
      <td bgcolor="#999999" class="titulocolumnas">Vcto Operación</td>
      <td bgcolor="#999999" class="titulocolumnas">Nro Cuota a Pagar</td>
      <td bgcolor="#999999" class="titulocolumnas">Cta Cte MN</td>
      <td bgcolor="#999999" class="titulocolumnas">Cta CTe MX</td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="middle"><?php echo $row_devengonro['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_devengonro['nombre_cliente']; ?></td>
        <td valign="middle" class="rojopequeno"><?php echo $row_devengonro['nro_operacion']; ?></td>
        <td valign="middle"><?php echo $row_devengonro['secuencia']; ?></td>
        <td valign="middle"><?php echo $row_devengonro['moneda']; ?></td>
        <td align="right" valign="middle"><?php echo number_format($row_devengonro['capital_original'], 2, ',', '.'); ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_devengonro['saldo_vigente'], 2, ',', '.'); ?></td>
        <td valign="middle"><?php echo $row_devengonro['fecha_vcto']; ?></td>
        <td valign="middle" class="respuestacolumna_rojo"><?php echo $row_devengonro['secuencia']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_devengonro['mn']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_devengonro['mx']; ?></td>
      </tr>
      <?php } while ($row_devengonro = mysqli_fetch_assoc($devengonro)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($devengonro);
?>