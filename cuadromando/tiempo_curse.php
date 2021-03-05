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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_oppre = "SELECT *,SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo_curse)))as tc,SUM(nro_cuotas_pendientes)as pendientes, ADDTIME(SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo_curse))),curtime())as total FROM tiempo_curse WHERE producto = 'Prestamos Stand Alone' GROUP BY operador ORDER BY operador ASC";
$oppre = mysqli_query($comercioexterior, $query_oppre) or die(mysqli_error($comercioexterior));
$row_oppre = mysqli_fetch_assoc($oppre);
$totalRows_oppre = mysqli_num_rows($oppre);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tiempo Curse Operaciones</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../imagenes/JPEG/edificio_corporativo.jpg);
}
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
.titulo_menu_rojo {	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	color: #FFF;
	background-color: #F00;
	font-weight: bold;
}
-->
</style>
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=60
var direccion='http://pdpto38:8303/comex/cuadromando/tiempo_curse.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<link href="../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
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
</style></head>
<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="79%" align="left" valign="middle"><span class="Estilo3"> </span><span class="Estilo3">TIEMPO CURSE OPERACIONES</span></td>
    <td width="21%" align="right" valign="middle"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60">
      <param name="movie" value="../imagenes/SWF/reloj_3.swf" />
      <param name="quality" value="high" />
      <embed src="../imagenes/SWF/reloj_3.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="250" height="60"></embed>
    </object>
      </div></td>
  </tr>
</table>
<br />
<br />
<?php if ($totalRows_oppre > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><span class="titulocolumnas"><img src="../imagenes/GIF/notepad.gif" width="19" height="21" /></span><span class="titulodetalle">Prestamos Stand Alone</span></td>
    </tr>
    <tr>
      <td width="40%" align="center" valign="middle" class="titulocolumnas">Operadores</td>
      <td width="20%" align="center" valign="middle" class="titulocolumnas">Cantidad Operaciones Pendientes de Curse por Operador</td>
      <td width="20%" align="center" valign="middle" class="titulocolumnas">Total Horas de Proceso por Operador</td>
      <td width="20%" align="center" valign="middle" class="titulocolumnas">Hora Estimada de Termino por Operador</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_oppre['operador']); ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_oppre['pendientes']; ?></td>
        <td align="center" valign="middle" class="Amarillo2"><?php echo $row_oppre['tc']; ?></td>
        <td align="center" valign="middle" class="Rojo2"><?php echo $row_oppre['total']; ?></td>
      </tr>
      <?php } while ($row_oppre = mysqli_fetch_assoc($oppre)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($oppre);
?>