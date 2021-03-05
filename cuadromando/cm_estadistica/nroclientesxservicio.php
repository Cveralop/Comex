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

$colname_nroclientesxservicio = "-1";
if (isset($_GET['date_ini'])) {
  $colname_nroclientesxservicio = $_GET['date_ini'];
}
$colname1_nroclientesxservicio = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_nroclientesxservicio = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_nroclientesxservicio = sprintf("SELECT *, COUNT(DISTINCT rut_cliente)as cliser, MIN(date_curse)as fini, MAX(date_curse)as ffin FROM cm_clientesxserv WHERE date_curse BETWEEN %s AND %s GROUP BY producto ORDER BY cliser DESC", GetSQLValueString($colname_nroclientesxservicio, "date"),GetSQLValueString($colname1_nroclientesxservicio, "date"));
$nroclientesxservicio = mysqli_query($comercioexterior, $query_nroclientesxservicio) or die(mysqli_error($comercioexterior));
$row_nroclientesxservicio = mysqli_fetch_assoc($nroclientesxservicio);
$totalRows_nroclientesxservicio = mysqli_num_rows($nroclientesxservicio);

$colname_sumbga = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumbga = $_GET['date_ini'];
}
$colname1_sumbga = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumbga = $_GET['date_fin'];
}
$colname2_sumbga = "Boleta de Garantia";
if (isset($_GET['producto'])) {
  $colname2_sumbga = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumbga = sprintf("SELECT *, COUNT(DISTINCT rut_cliente)as bga FROM cm_clientesxserv WHERE date_curse BETWEEN %s AND %s AND producto = %s  GROUP BY date_ingreso", GetSQLValueString($colname_sumbga, "date"),GetSQLValueString($colname1_sumbga, "date"),GetSQLValueString($colname2_sumbga, "text"));
$sumbga = mysqli_query($comercioexterior, $query_sumbga) or die(mysqli_error($comercioexterior));
$row_sumbga = mysqli_fetch_assoc($sumbga);
$totalRows_sumbga = mysqli_num_rows($sumbga);

$colname_sumcce = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumcce = $_GET['date_ini'];
}
$colname1_sumcce = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumcce = $_GET['date_fin'];
}
$colname2_sumcce = "Carta de Credito Export";
if (isset($_GET['producto'])) {
  $colname2_sumcce = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumcce = sprintf("SELECT *, COUNT(DISTINCT rut_cliente)as cce FROM cm_clientesxserv WHERE date_curse BETWEEN %s AND %s AND producto = %s  GROUP BY date_ingreso", GetSQLValueString($colname_sumcce, "date"),GetSQLValueString($colname1_sumcce, "date"),GetSQLValueString($colname2_sumcce, "text"));
$sumcce = mysqli_query($comercioexterior, $query_sumcce) or die(mysqli_error($comercioexterior));
$row_sumcce = mysqli_fetch_assoc($sumcce);
$totalRows_sumcce = mysqli_num_rows($sumcce);

$colname_sumcci = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumcci = $_GET['date_ini'];
}
$colname1_sumcci = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumcci = $_GET['date_fin'];
}
$colname2_sumcci = "Carta de Credito Import";
if (isset($_GET['producto'])) {
  $colname2_sumcci = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumcci = sprintf("SELECT *, COUNT(DISTINCT rut_cliente)as cci FROM cm_clientesxserv WHERE date_curse BETWEEN %s AND %s AND producto = %s  GROUP BY date_ingreso", GetSQLValueString($colname_sumcci, "date"),GetSQLValueString($colname1_sumcci, "date"),GetSQLValueString($colname2_sumcci, "text"));
$sumcci = mysqli_query($comercioexterior, $query_sumcci) or die(mysqli_error($comercioexterior));
$row_sumcci = mysqli_fetch_assoc($sumcci);
$totalRows_sumcci = mysqli_num_rows($sumcci);

$colname_sumcbe = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumcbe = $_GET['date_ini'];
}
$colname1_sumcbe = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumcbe = $_GET['date_fin'];
}
$colname2_sumcbe = "Cobranza Extranjera de Export";
if (isset($_GET['producto'])) {
  $colname2_sumcbe = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumcbe = sprintf("SELECT *, COUNT(DISTINCT rut_cliente)as cbe FROM cm_clientesxserv WHERE date_curse BETWEEN %s AND %s AND producto = %s  GROUP BY date_ingreso", GetSQLValueString($colname_sumcbe, "date"),GetSQLValueString($colname1_sumcbe, "date"),GetSQLValueString($colname2_sumcbe, "text"));
$sumcbe = mysqli_query($comercioexterior, $query_sumcbe) or die(mysqli_error($comercioexterior));
$row_sumcbe = mysqli_fetch_assoc($sumcbe);
$totalRows_sumcbe = mysqli_num_rows($sumcbe);

$colname_sumcbi = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumcbi = $_GET['date_ini'];
}
$colname1_sumcbi = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumcbi = $_GET['date_fin'];
}
$colname2_sumcbi = "Cobranza Extranjera de Import";
if (isset($_GET['producto'])) {
  $colname2_sumcbi = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumcbi = sprintf("SELECT *, COUNT(DISTINCT rut_cliente)as cbi FROM cm_clientesxserv WHERE date_curse BETWEEN %s AND %s AND producto = %s  GROUP BY date_ingreso", GetSQLValueString($colname_sumcbi, "date"),GetSQLValueString($colname1_sumcbi, "date"),GetSQLValueString($colname2_sumcbi, "text"));
$sumcbi = mysqli_query($comercioexterior, $query_sumcbi) or die(mysqli_error($comercioexterior));
$row_sumcbi = mysqli_fetch_assoc($sumcbi);
$totalRows_sumcbi = mysqli_num_rows($sumcbi);

$colname_sumtbc = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumtbc = $_GET['date_ini'];
}
$colname1_sumtbc = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumtbc = $_GET['date_fin'];
}
$colname2_sumtbc = "Credito IIIB5";
if (isset($_GET['producto'])) {
  $colname2_sumtbc = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumtbc = sprintf("SELECT *, COUNT(DISTINCT rut_cliente)as tbc FROM cm_clientesxserv WHERE date_curse BETWEEN %s AND %s AND producto = %s  GROUP BY date_ingreso", GetSQLValueString($colname_sumtbc, "date"),GetSQLValueString($colname1_sumtbc, "date"),GetSQLValueString($colname2_sumtbc, "text"));
$sumtbc = mysqli_query($comercioexterior, $query_sumtbc) or die(mysqli_error($comercioexterior));
$row_sumtbc = mysqli_fetch_assoc($sumtbc);
$totalRows_sumtbc = mysqli_num_rows($sumtbc);

$colname_sumcex = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumcex = $_GET['date_ini'];
}
$colname1_sumcex = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumcex = $_GET['date_fin'];
}
$colname2_sumcex = "DL600-CapXIII-CAPXIV";
if (isset($_GET['producto'])) {
  $colname2_sumcex = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumcex = sprintf("SELECT *, COUNT(DISTINCT rut_cliente)as cex FROM cm_clientesxserv WHERE date_curse BETWEEN %s AND %s AND producto = %s  GROUP BY date_ingreso", GetSQLValueString($colname_sumcex, "date"),GetSQLValueString($colname1_sumcex, "date"),GetSQLValueString($colname2_sumcex, "text"));
$sumcex = mysqli_query($comercioexterior, $query_sumcex) or die(mysqli_error($comercioexterior));
$row_sumcex = mysqli_fetch_assoc($sumcex);
$totalRows_sumcex = mysqli_num_rows($sumcex);

$colname_sumste = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumste = $_GET['date_ini'];
}
$colname1_sumste = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumste = $_GET['date_fin'];
}
$colname2_sumste = "L/C Stand By Emitida";
if (isset($_GET['producto'])) {
  $colname2_sumste = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumste = sprintf("SELECT *, COUNT(DISTINCT rut_cliente)as ste FROM cm_clientesxserv WHERE date_curse BETWEEN %s AND %s AND producto = %s  GROUP BY date_ingreso", GetSQLValueString($colname_sumste, "date"),GetSQLValueString($colname1_sumste, "date"),GetSQLValueString($colname2_sumste, "text"));
$sumste = mysqli_query($comercioexterior, $query_sumste) or die(mysqli_error($comercioexterior));
$row_sumste = mysqli_fetch_assoc($sumste);
$totalRows_sumste = mysqli_num_rows($sumste);

$colname_sumstr = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumstr = $_GET['date_ini'];
}
$colname1_sumstr = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumstr = $_GET['date_fin'];
}
$colname2_sumstr = "L/C Stand By Recibida";
if (isset($_GET['producto'])) {
  $colname2_sumstr = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumstr = sprintf("SELECT *, COUNT(DISTINCT rut_cliente)as str FROM cm_clientesxserv WHERE date_curse BETWEEN %s AND %s AND producto = %s  GROUP BY date_ingreso", GetSQLValueString($colname_sumstr, "date"),GetSQLValueString($colname1_sumstr, "date"),GetSQLValueString($colname2_sumstr, "text"));
$sumstr = mysqli_query($comercioexterior, $query_sumstr) or die(mysqli_error($comercioexterior));
$row_sumstr = mysqli_fetch_assoc($sumstr);
$totalRows_sumstr = mysqli_num_rows($sumstr);

$colname_summec = "-1";
if (isset($_GET['date_ini'])) {
  $colname_summec = $_GET['date_ini'];
}
$colname1_summec = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_summec = $_GET['date_fin'];
}
$colname2_summec = "Mercado Corredores";
if (isset($_GET['producto'])) {
  $colname2_summec = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_summec = sprintf("SELECT *, COUNT(DISTINCT rut_cliente)as mec FROM cm_clientesxserv WHERE date_curse BETWEEN %s AND %s AND producto = %s  GROUP BY date_ingreso", GetSQLValueString($colname_summec, "date"),GetSQLValueString($colname1_summec, "date"),GetSQLValueString($colname2_summec, "text"));
$summec = mysqli_query($comercioexterior, $query_summec) or die(mysqli_error($comercioexterior));
$row_summec = mysqli_fetch_assoc($summec);
$totalRows_summec = mysqli_num_rows($summec);

$colname_sumpre = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumpre = $_GET['date_ini'];
}
$colname1_sumpre = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumpre = $_GET['date_fin'];
}
$colname2_sumpre = "Prestamos Stand Alone";
if (isset($_GET['producto'])) {
  $colname2_sumpre = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumpre = sprintf("SELECT *, COUNT(DISTINCT rut_cliente)as pre FROM cm_clientesxserv WHERE date_curse BETWEEN %s AND %s AND producto = %s  GROUP BY date_ingreso", GetSQLValueString($colname_sumpre, "date"),GetSQLValueString($colname1_sumpre, "date"),GetSQLValueString($colname2_sumpre, "text"));
$sumpre = mysqli_query($comercioexterior, $query_sumpre) or die(mysqli_error($comercioexterior));
$row_sumpre = mysqli_fetch_assoc($sumpre);
$totalRows_sumpre = mysqli_num_rows($sumpre);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nro Clientes por Servicio</title>
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
    <td width="79%" align="left" valign="middle"><span class="Estilo3"> </span><span class="Estilo3">NRO CLIENTES POR SERVICIO</span></td>
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
    <td align="right" valign="middle"><a href="../estadistica_operaciones.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><span class="subtitulopaguina"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Busqueda por Rango Fecha</span></td>
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
<?php if ($totalRows_nroclientesxservicio > 0) { // Show if recordset not empty ?>
  <table width="70%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><span class="subtitulopaguina"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /></span>Desde <span class="tituloverde"><?php echo $row_nroclientesxservicio['fini']; ?></span> Hasta <span class="tituloverde"><?php echo $row_nroclientesxservicio['ffin']; ?></span></td>
    </tr>
    <tr>
      <td width="70%" align="center" valign="middle" class="titulocolumnas">Servicio</td>
      <td width="30%" align="center" valign="middle" class="titulocolumnas">Nro Cliente por Servicio</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_nroclientesxservicio['producto']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_nroclientesxservicio['cliser'], 0, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_nroclientesxservicio = mysqli_fetch_assoc($nroclientesxservicio)); ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna_azul">Total</td>
      <td align="right" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_sumbga['bga'] + $row_sumcce['cce'] + $row_sumcci['cci'] + $row_sumcbe['cbe'] + $row_sumcbi['cbi'] + $row_sumtbc['tbc'] + $row_sumcex['cex'] + $row_sumste['ste'] + $row_sumstr['str'] + $row_summec['mec'] + $row_sumpre['pre'], 0, ',', '.'); ?>
      </td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($nroclientesxservicio);
mysqli_free_result($sumbga);
mysqli_free_result($sumcce);
mysqli_free_result($sumcci);
mysqli_free_result($sumcbe);
mysqli_free_result($sumcbi);
mysqli_free_result($sumtbc);
mysqli_free_result($sumcex);
mysqli_free_result($sumste);
mysqli_free_result($sumstr);
mysqli_free_result($summec);
mysqli_free_result($sumpre);
?>