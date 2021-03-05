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

$colname_opxser = "-1";
if (isset($_GET['date_ini'])) {
  $colname_opxser = $_GET['date_ini'];
}
$colname1_opxser = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_opxser = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opxser = sprintf("SELECT producto, SUM(nro_cuotas)as nroop, MIN(date_curse)as fini, MAX(date_curse)as ffin FROM cm_opxserv WHERE date_curse BETWEEN %s and %s GROUP BY producto ORDER BY nroop DESC", GetSQLValueString($colname_opxser, "date"),GetSQLValueString($colname1_opxser, "date"));
$opxser = mysqli_query($comercioexterior, $query_opxser) or die(mysqli_error($comercioexterior));
$row_opxser = mysqli_fetch_assoc($opxser);
$totalRows_opxser = mysqli_num_rows($opxser);

$colname_optotal = "-1";
if (isset($_GET['date_ini'])) {
  $colname_optotal = $_GET['date_ini'];
}
$colname1_optotal = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_optotal = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_optotal = sprintf("SELECT *, SUM(nro_cuotas)as optotal FROM cm_opxserv WHERE date_curse BETWEEN %s AND %s GROUP BY date_ingreso", GetSQLValueString($colname_optotal, "date"),GetSQLValueString($colname1_optotal, "date"));
$optotal = mysqli_query($comercioexterior, $query_optotal) or die(mysqli_error($comercioexterior));
$row_optotal = mysqli_fetch_assoc($optotal);
$totalRows_optotal = mysqli_num_rows($optotal);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nro Operaciones por Servicio</title>
<style type="text/css">
<!--
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
<style type="text/css">
<!--
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script type="text/javascript">
/*<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
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
//-->*/
</script>
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="79%" align="left" valign="middle"><span class="Estilo3"> </span><span class="Estilo3">NRO OPERACIONES POR SERVICIO</span></td>
    <td width="21%" align="right" valign="middle"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60">
      <param name="movie" value="../../imagenes/SWF/reloj_3.swf" />
      <param name="quality" value="high" />
      <embed src="../../imagenes/SWF/reloj_3.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="250" height="60"></embed>
    </object>
      </div></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../estadistica_operaciones.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen2','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen2" width="80" height="25" border="0" id="Imagen2" /></a></td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="subtitulopaguina"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" />Busqueda por Rango Fecha</td>
    </tr>
    <tr>
      <td width="19%" align="right" valign="middle">Fecha Curse:</td>
      <td width="81%" align="left" valign="middle"><span class="respuestacolumna_rojo">Desde</span>
        <input name="date_ini" type="text" class="etiqueta12" id="date_ini" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" /> 
      <span class="respuestacolumna_rojo">Hasta</span>        <input name="date_fin" type="text" class="etiqueta12" id="date_fin" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><input name="button" type="submit" class="boton" id="button" value="Buscar" /></td>
    </tr>
  </table>
</form>
<br />
<?php if ($totalRows_opxser > 0) { // Show if recordset not empty ?>
  <table width="70%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><span class="subtitulopaguina"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Desde </span><span class="tituloverde"><?php echo $row_opxser['fini']; ?></span><span class="subtitulopaguina"> Hasta </span><span class="tituloverde"><?php echo $row_opxser['ffin']; ?></span></td>
    </tr>
    <tr>
      <td width="70%" align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Servicios</span></td>
      <td width="30%" align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Nro de Operaciones por Servicio</span></td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_opxser['producto']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_opxser['nroop'], 0, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opxser = mysqli_fetch_assoc($opxser)); ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul">Total</td>
        <td align="right" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_optotal['optotal'], 0, ',', '.'); ?></td>
      </tr>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($opxser);
mysqli_free_result($optotal);
?>