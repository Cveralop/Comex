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

$colname_acuserecibocaratula = "Acuse Recibo Caratula";
if (isset($_GET['estado'])) {
  $colname_acuserecibocaratula = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_acuserecibocaratula = sprintf("SELECT * FROM trasabilidad WHERE estado = %s ORDER BY producto, evento ASC", GetSQLValueString($colname_acuserecibocaratula, "text"));
$acuserecibocaratula = mysqli_query($comercioexterior, $query_acuserecibocaratula) or die(mysqli_error($comercioexterior));
$row_acuserecibocaratula = mysqli_fetch_assoc($acuserecibocaratula);
$totalRows_acuserecibocaratula = mysqli_num_rows($acuserecibocaratula);

$colname_espe_visacion = "Ingreso Espe. v/s Visacion";
if (isset($_GET['estado'])) {
  $colname_espe_visacion = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_espe_visacion = sprintf("SELECT * FROM trasabilidad WHERE estado = %s ORDER BY producto, evento ASC", GetSQLValueString($colname_espe_visacion, "text"));
$espe_visacion = mysqli_query($comercioexterior, $query_espe_visacion) or die(mysqli_error($comercioexterior));
$row_espe_visacion = mysqli_fetch_assoc($espe_visacion);
$totalRows_espe_visacion = mysqli_num_rows($espe_visacion);

$colname_visacion_asignacion = "Visacion v/s Asignacion";
if (isset($_GET['estado'])) {
  $colname_visacion_asignacion = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_visacion_asignacion = sprintf("SELECT * FROM trasabilidad WHERE estado = %s ORDER BY producto, evento ASC", GetSQLValueString($colname_visacion_asignacion, "text"));
$visacion_asignacion = mysqli_query($comercioexterior, $query_visacion_asignacion) or die(mysqli_error($comercioexterior));
$row_visacion_asignacion = mysqli_fetch_assoc($visacion_asignacion);
$totalRows_visacion_asignacion = mysqli_num_rows($visacion_asignacion);

$colname_asignacion_altaoperador = "Asignacion v/s Alta Operador";
if (isset($_GET['estado'])) {
  $colname_asignacion_altaoperador = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_asignacion_altaoperador = sprintf("SELECT * FROM trasabilidad WHERE estado = %s ORDER BY producto, evento ASC", GetSQLValueString($colname_asignacion_altaoperador, "text"));
$asignacion_altaoperador = mysqli_query($comercioexterior, $query_asignacion_altaoperador) or die(mysqli_error($comercioexterior));
$row_asignacion_altaoperador = mysqli_fetch_assoc($asignacion_altaoperador);
$totalRows_asignacion_altaoperador = mysqli_num_rows($asignacion_altaoperador);

$colname_altaoperador_altasupervisor = "Alta Operador v/s Alta Supervisor";
if (isset($_GET['estado'])) {
  $colname_altaoperador_altasupervisor = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_altaoperador_altasupervisor = sprintf("SELECT * FROM trasabilidad WHERE estado = %s ORDER BY producto, evento ASC", GetSQLValueString($colname_altaoperador_altasupervisor, "text"));
$altaoperador_altasupervisor = mysqli_query($comercioexterior, $query_altaoperador_altasupervisor) or die(mysqli_error($comercioexterior));
$row_altaoperador_altasupervisor = mysqli_fetch_assoc($altaoperador_altasupervisor);
$totalRows_altaoperador_altasupervisor = mysqli_num_rows($altaoperador_altasupervisor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trazabilidad Operaciones</title>
<style type="text/css">
<!--
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #F00;
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
<link href="../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=60
var direccion='http://pdpto38:8303/comex/cuadromando/trazabilidad.php' 
milisegundos=segundos*1000
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
</head>
<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="79%" align="left" valign="middle"><span class="Estilo3"> </span><span class="Estilo3">TRAZABILIDAD OPERACIONES</span></td>
    <td width="21%" align="right" valign="middle"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60">
      <param name="movie" value="../imagenes/SWF/reloj_3.swf" />
      <param name="quality" value="high" />
      <embed src="../imagenes/SWF/reloj_3.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="250" height="60"></embed>
    </object>
      </div></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="6" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../imagenes/GIF/notepad.gif" width="19" height="21" />Acuse Recibo Caratulas GOC</td>
  </tr>
  <tr>
    <td width="30%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso Caratula</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Minimo (Minutos)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Maximo (Minutos)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Promedio (Minutos)</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo $row_acuserecibocaratula['producto']; ?></td>
      <td align="left" valign="middle"><?php echo $row_acuserecibocaratula['evento']; ?></td>
      <td valign="middle"><?php echo $row_acuserecibocaratula['date_ing']; ?></td>
      <td valign="middle" class="Verde2"><?php echo $row_acuserecibocaratula['minimo']; ?></td>
      <td valign="middle" class="Rojo2"><?php echo $row_acuserecibocaratula['maximo']; ?></td>
      <td valign="middle" class="Amarillo2"><?php echo $row_acuserecibocaratula['promedio']; ?></td>
    </tr>
    <?php } while ($row_acuserecibocaratula = mysqli_fetch_assoc($acuserecibocaratula)); ?>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="6" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Ingreso Especialista v/s Visación</td>
  </tr>
  <tr>
    <td width="30%" align="center" valign="middle" class="titulocolumnas">Producto</td>
    <td width="20%" align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td width="20%" align="center" valign="middle" class="titulocolumnas">Fecha Ingreso Especialista</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">Tiempo Minimo (Minutos)</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">Tiempo Maximo (Minutos)</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">Tiempo Promedio (Minutos)</td>
  </tr>
  <?php do { ?>
    <tr>
      <td height="16" align="left" valign="middle"><?php echo $row_espe_visacion['producto']; ?></td>
      <td align="left" valign="middle"><?php echo $row_espe_visacion['evento']; ?></td>
      <td align="center" valign="middle"><?php echo $row_espe_visacion['date_espe']; ?></td>
      <td align="center" valign="middle" class="Verde2"><?php echo number_format($row_espe_visacion['minimo'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle" class="Rojo2"><?php echo number_format($row_espe_visacion['maximo'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle" class="Amarillo2"><?php echo number_format($row_espe_visacion['promedio'], 2, ',', '.'); ?></td>
    </tr>
    <?php } while ($row_espe_visacion = mysqli_fetch_assoc($espe_visacion)); ?>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="6" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Visación v/s Asignación Operaciones</td>
  </tr>
  <tr>
    <td width="30%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso Especialista</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Minimo (Minutos)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Maximo (Minutos)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Promedio (Minutos)</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo $row_visacion_asignacion['producto']; ?></td>
      <td align="left" valign="middle"><?php echo $row_visacion_asignacion['evento']; ?></td>
      <td align="center" valign="middle"><?php echo $row_visacion_asignacion['date_espe']; ?></td>
      <td align="center" valign="middle" class="Verde2"><?php echo number_format($row_visacion_asignacion['minimo'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle" class="Rojo2"><?php echo number_format($row_visacion_asignacion['maximo'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle" class="Amarillo2"><?php echo number_format($row_visacion_asignacion['promedio'], 2, ',', '.'); ?></td>
    </tr>
    <?php } while ($row_visacion_asignacion = mysqli_fetch_assoc($visacion_asignacion)); ?>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="6" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Asignación Operaciones v/s Alta Operador</td>
  </tr>
  <tr>
    <td width="30%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso Especialista</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Minimo (Minutos)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Maximo (Minutos)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Promedio (Minutos)</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo $row_asignacion_altaoperador['producto']; ?></td>
      <td align="left" valign="middle"><?php echo $row_asignacion_altaoperador['evento']; ?></td>
      <td align="center" valign="middle"><?php echo $row_asignacion_altaoperador['date_espe']; ?></td>
      <td align="center" valign="middle" class="Verde2"><?php echo number_format($row_asignacion_altaoperador['minimo'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle" class="Rojo2"><?php echo number_format($row_asignacion_altaoperador['maximo'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle" class="Amarillo2"><?php echo number_format($row_asignacion_altaoperador['promedio'], 2, ',', '.'); ?></td>
    </tr>
    <?php } while ($row_asignacion_altaoperador = mysqli_fetch_assoc($asignacion_altaoperador)); ?>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="6" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Alta Operador v/s Alta Supervisor</td>
  </tr>
  <tr>
    <td width="30%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso Especialista</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Minimo (Minutos)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Maximo (Minutos)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Promedio (Minutos)</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo $row_altaoperador_altasupervisor['producto']; ?></td>
      <td align="left" valign="middle"><?php echo $row_altaoperador_altasupervisor['evento']; ?></td>
      <td align="center" valign="middle"><?php echo $row_altaoperador_altasupervisor['date_espe']; ?></td>
      <td align="center" valign="middle" class="Verde2"><?php echo number_format($row_altaoperador_altasupervisor['minimo'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle" class="Rojo2"><?php echo number_format($row_altaoperador_altasupervisor['maximo'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle" class="Amarillo2"><?php echo number_format($row_altaoperador_altasupervisor['promedio'], 2, ',', '.'); ?></td>
    </tr>
    <?php } while ($row_altaoperador_altasupervisor = mysqli_fetch_assoc($altaoperador_altasupervisor)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($acuserecibocaratula);
mysqli_free_result($espe_visacion);
mysqli_free_result($visacion_asignacion);
mysqli_free_result($asignacion_altaoperador);
mysqli_free_result($altaoperador_altasupervisor);
?>