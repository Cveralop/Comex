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
if (isset($_GET['date_ini'])) {
  $colname_estadistica_postventa = $_GET['date_ini'];
}
$colname1_estadistica_postventa = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_estadistica_postventa = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_estadistica_postventa = sprintf("SELECT *, min(date_curse)as fechainicio, max(date_curse)as fechatermino, SUM(cantidad_cursadas)as opcur, SUM(cantidad_reparadas_ope)as opresop, (((SUM(cantidad_reparadas_ope))/SUM(cantidad_cursadas))*100)as pctrep, SUM(cantidad_urgentes)as opurg, SUM(cantidad_fuerahora)as opfh, ((SUM(cantidad_urgentes)/SUM(cantidad_cursadas))*100)as pcturg, ((SUM(cantidad_fuerahora)/SUM(cantidad_cursadas))*100)as pctfh FROM estadistica_operaciones WHERE date_curse BETWEEN %s AND %s GROUP BY operador ORDER BY opcur DESC", GetSQLValueString($colname_estadistica_postventa, "date"),GetSQLValueString($colname1_estadistica_postventa, "date"));
$estadistica_postventa = mysqli_query($comercioexterior, $query_estadistica_postventa) or die(mysqli_error($comercioexterior));
$row_estadistica_postventa = mysqli_fetch_assoc($estadistica_postventa);
$totalRows_estadistica_postventa = mysqli_num_rows($estadistica_postventa);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Estadistica Cuadro de Mando - Operaciones</title>
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
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="estadistica_operaciones_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen1','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen1" width="80" height="25" border="0" id="Imagen1" /></a></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td colspan="2" align="center" valign="middle" bgcolor="#FF0000" class="Estilo3">ESTADISTICA - CUADRO MANDO OPERACIONES</td>
  </tr>
  <tr>
    <td width="16%" align="right" valign="middle">Fecha Desde:</td>
    <td width="84%" align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_estadistica_postventa['fechainicio']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Fecha Hasta:</td>
    <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_estadistica_postventa['fechatermino']; ?></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td width="20%" align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Cursadas</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Rep. x Operaciones</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Reparos</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Urgentes</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Urgencias</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">Op. Fuera de Horario</td>
    <td width="10%"  align="center" valign="middle" class="titulocolumnas">% Fuera Horario</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna"><strong><?php echo strtoupper($row_estadistica_postventa['operador']); ?></strong></td>
      <td align="right" valign="middle" class="Verde2"><?php echo number_format($row_estadistica_postventa['opcur'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_postventa['opresop'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle" class="rojopequeno"><?php echo number_format($row_estadistica_postventa['pctrep'], 2, ',', '.'); ?></td>
      <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_postventa['opurg'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle" class="Rojo2"><?php echo number_format($row_estadistica_postventa['pcturg'], 2, ',', '.'); ?></td>
      <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_postventa['opfh'], 0, ',', '.'); ?></td>
      <td align="right" valign="middle" class="Amarillo2"><?php echo number_format($row_estadistica_postventa['pctfh'], 2, ',', '.'); ?></td>
    </tr>
    <?php } while ($row_estadistica_postventa = mysqli_fetch_assoc($estadistica_postventa)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($estadistica_postventa);
?>