<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
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
$colname_opbga = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_opbga = $_GET['rut_cliente'];
}
$colname2_opbga = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opbga = $_GET['date_ini'];
}
$colname3_opbga = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opbga = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opbga = sprintf("SELECT * FROM opbga WHERE rut_cliente = %s and date_ingreso between %s and %s ORDER BY date_ingreso ASC", GetSQLValueString($colname_opbga, "text"),GetSQLValueString($colname2_opbga, "date"),GetSQLValueString($colname3_opbga, "date"));
$opbga = mysqli_query($comercioexterior, $query_opbga) or die(mysqli_error());
$row_opbga = mysqli_fetch_assoc($opbga);
$totalRows_opbga = mysqli_num_rows($opbga);
$colname_opcbe = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_opcbe = $_GET['rut_cliente'];
}
$colname2_opcbe = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opcbe = $_GET['date_ini'];
}
$colname3_opcbe = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opcbe = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcbe = sprintf("SELECT * FROM opcbe WHERE rut_cliente = %s and date_ingreso between %s and %s  ORDER BY date_ingreso DESC", GetSQLValueString($colname_opcbe, "text"),GetSQLValueString($colname2_opcbe, "date"),GetSQLValueString($colname3_opcbe, "date"));
$opcbe = mysqli_query($comercioexterior, $query_opcbe) or die(mysqli_error());
$row_opcbe = mysqli_fetch_assoc($opcbe);
$totalRows_opcbe = mysqli_num_rows($opcbe);
$colname_opcbi = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_opcbi = $_GET['rut_cliente'];
}
$colname2_opcbi = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opcbi = $_GET['date_ini'];
}
$colname3_opcbi = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opcbi = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcbi = sprintf("SELECT * FROM opcbi WHERE rut_cliente = %s and date_ingreso between %s and %s  ORDER BY date_ingreso DESC", GetSQLValueString($colname_opcbi, "text"),GetSQLValueString($colname2_opcbi, "date"),GetSQLValueString($colname3_opcbi, "date"));
$opcbi = mysqli_query($comercioexterior, $query_opcbi) or die(mysqli_error());
$row_opcbi = mysqli_fetch_assoc($opcbi);
$totalRows_opcbi = mysqli_num_rows($opcbi);
$colname_opcce = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_opcce = $_GET['rut_cliente'];
}
$colname2_opcce = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opcce = $_GET['date_ini'];
}
$colname3_opcce = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opcce = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcce = sprintf("SELECT * FROM opcce WHERE rut_cliente = %s and date_ingreso between %s and %s  ORDER BY date_curse DESC", GetSQLValueString($colname_opcce, "text"),GetSQLValueString($colname2_opcce, "date"),GetSQLValueString($colname3_opcce, "date"));
$opcce = mysqli_query($comercioexterior, $query_opcce) or die(mysqli_error());
$row_opcce = mysqli_fetch_assoc($opcce);
$totalRows_opcce = mysqli_num_rows($opcce);
$colname_opcci = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_opcci = $_GET['rut_cliente'];
}
$colname2_opcci = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opcci = $_GET['date_ini'];
}
$colname3_opcci = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opcci = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcci = sprintf("SELECT * FROM opcci WHERE rut_cliente = %s and date_ingreso between %s and %s  ORDER BY date_curse DESC", GetSQLValueString($colname_opcci, "text"),GetSQLValueString($colname2_opcci, "date"),GetSQLValueString($colname3_opcci, "date"));
$opcci = mysqli_query($comercioexterior, $query_opcci) or die(mysqli_error());
$row_opcci = mysqli_fetch_assoc($opcci);
$totalRows_opcci = mysqli_num_rows($opcci);
$colname_opdppa = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_opdppa = $_GET['rut_cliente'];
}
$colname2_opdppa = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opdppa = $_GET['date_ini'];
}
$colname3_opdppa = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opdppa = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opdppa = sprintf("SELECT * FROM opcdpa WHERE rut_cliente = %s and date_ingreso between %s and %s ORDER BY date_ingreso DESC", GetSQLValueString($colname_opdppa, "text"),GetSQLValueString($colname2_opdppa, "date"),GetSQLValueString($colname3_opdppa, "date"));
$opdppa = mysql_query($query_opdppa, $comercioexterior) or die(mysqli_error());
$row_opdppa = mysqli_fetch_assoc($opdppa);
$totalRows_opdppa = mysqli_num_rows($opdppa);
$colname_opcex = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_opcex = $_GET['rut_cliente'];
}
$colname2_opcex = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opcex = $_GET['date_ini'];
}
$colname3_opcex = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opcex = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcex = sprintf("SELECT * FROM opcex WHERE rut_cliente = %s and date_ingreso between %s and %s  ORDER BY date_ingreso DESC", GetSQLValueString($colname_opcex, "text"),GetSQLValueString($colname2_opcex, "date"),GetSQLValueString($colname3_opcex, "date"));
$opcex = mysqli_query($comercioexterior, $query_opcex) or die(mysqli_error());
$row_opcex = mysqli_fetch_assoc($opcex);
$totalRows_opcex = mysqli_num_rows($opcex);
$colname_opmec = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_opmec = $_GET['rut_cliente'];
}
$colname2_opmec = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opmec = $_GET['date_ini'];
}
$colname3_opmec = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opmec = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opmec = sprintf("SELECT * FROM opmec WHERE rut_cliente = %s and date_ingreso between %s and %s  ORDER BY date_ingreso DESC", GetSQLValueString($colname_opmec, "text"),GetSQLValueString($colname2_opmec, "date"),GetSQLValueString($colname3_opmec, "date"));
$opmec = mysqli_query($comercioexterior, $query_opmec) or die(mysqli_error());
$row_opmec = mysqli_fetch_assoc($opmec);
$totalRows_opmec = mysqli_num_rows($opmec);
$colname_oppre = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_oppre = $_GET['rut_cliente'];
}
$colname2_oppre = "1";
if (isset($_GET['date_ini'])) {
  $colname2_oppre = $_GET['date_ini'];
}
$colname3_oppre = "1";
if (isset($_GET['date_fin'])) {
  $colname3_oppre = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_oppre = sprintf("SELECT * FROM oppre WHERE rut_cliente = %s and date_ingreso between %s and %s  ORDER BY date_ingreso DESC", GetSQLValueString($colname_oppre, "text"),GetSQLValueString($colname2_oppre, "date"),GetSQLValueString($colname3_oppre, "date"));
$oppre = mysqli_query($comercioexterior, $query_oppre) or die(mysqli_error());
$row_oppre = mysqli_fetch_assoc($oppre);
$totalRows_oppre = mysqli_num_rows($oppre);
$colname_opste = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_opste = $_GET['rut_cliente'];
}
$colname2_opste = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opste = $_GET['date_ini'];
}
$colname3_opste = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opste = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opste = sprintf("SELECT * FROM opste WHERE rut_cliente = %s and date_ingreso between %s and %s  ORDER BY date_ingreso DESC", GetSQLValueString($colname_opste, "text"),GetSQLValueString($colname2_opste, "date"),GetSQLValueString($colname3_opste, "date"));
$opste = mysqli_query($comercioexterior, $query_opste) or die(mysqli_error());
$row_opste = mysqli_fetch_assoc($opste);
$totalRows_opste = mysqli_num_rows($opste);
$colname_opstr = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_opstr = $_GET['rut_cliente'];
}
$colname2_opstr = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opstr = $_GET['date_ini'];
}
$colname3_opstr = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opstr = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opstr = sprintf("SELECT * FROM opstr WHERE rut_cliente = %s and date_ingreso between %s and %s  ORDER BY date_ingreso DESC", GetSQLValueString($colname_opstr, "text"),GetSQLValueString($colname2_opstr, "date"),GetSQLValueString($colname3_opstr, "date"));
$opstr = mysqli_query($comercioexterior, $query_opstr) or die(mysqli_error());
$row_opstr = mysqli_fetch_assoc($opstr);
$totalRows_opstr = mysqli_num_rows($opstr);
$colname_optbc = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_optbc = $_GET['rut_cliente'];
}
$colname2_optbc = "1";
if (isset($_GET['date_ini'])) {
  $colname2_optbc = $_GET['date_ini'];
}
$colname3_optbc = "1";
if (isset($_GET['date_fin'])) {
  $colname3_optbc = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_optbc = sprintf("SELECT * FROM optbc WHERE rut_cliente = %s and date_ingreso between %s and %s  ORDER BY date_ingreso DESC", GetSQLValueString($colname_optbc, "text"),GetSQLValueString($colname2_optbc, "date"),GetSQLValueString($colname3_optbc, "date"));
$optbc = mysqli_query($comercioexterior, $query_optbc) or die(mysqli_error());
$row_optbc = mysqli_fetch_assoc($optbc);
$totalRows_optbc = mysqli_num_rows($optbc);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gerencia Regional - Rut Cliente</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #F00;
	font-weight: bold;
}
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {color: #FFFFFF;
	font-weight: bold;
}
.Estilo16 {	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo31 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
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
<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="95%" align="left" valign="middle"><span class="Estilo3">CONSULTA POR RUT CLIENTE</span></td>
    <td width="5%" align="left" valign="middle"><span class="Estilo31"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></span>      </div></td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulodetalle">Control de Operaciones Enviadas a Proceso</span></td>
    </tr>
    <tr>
      <td width="22%" align="right" valign="middle" bgcolor="#CCCCCC">Rut Cliente:</td>
      <td width="78%" align="left" valign="middle" bgcolor="#CCCCCC"><label>
        <input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15" />
        <span class="rojopequeno">(Sin Puntos ni Guión)</span></label></td>
    </tr>
    <tr>
      <td align="right" valign="middle" bgcolor="#CCCCCC">Fecha Ingreso:</td>
      <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
        <span class="rojopequeno">Desde</span>
        <input name="date_ini" type="text" class="etiqueta12" id="date_ini" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" />
        <span class="rojopequeno">Hasta</span>
<input name="date_fin" type="text" class="etiqueta12" id="date_fin" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" />
      <span class="rojopequeno">(Formato aaaa-mm-dd)</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle" bgcolor="#CCCCCC"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar Operaciones" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td width="92%" align="left" valign="middle"><span class="respuestacolumna_rojo">(Las dudas y/o consultas debe dirigirlas a su especialista)</span></td>
    <td width="8%" align="right" valign="middle"><a href="../../gerenciaregional.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen15','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen15" width="80" height="25" border="0" id="Imagen15" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_opbga > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="8" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0" /><span class="titulocolumnas"><span class="titulodetalle">Rut Cliente </span></span><span class="tituloverde"><?php echo strtoupper($row_opbga['rut_cliente']); ?></span><span class="titulocolumnas"><span class="titulodetalle"> Nombre Cliente </span></span><span class="tituloverde"><?php echo strtoupper($row_opbga['nombre_cliente']); ?></span><span class="titulocolumnas"><span class="titulodetalle"> Total </span></span><span class="tituloverde"><?php echo $totalRows_opbga ?></span></td>
    </tr>
    <tr>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Registro</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Motivo Reparo</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Curse</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operacion</td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="middle" class="respuestacolumna_rojo"><?php echo $row_opbga['id']; ?></td>
        <td valign="middle">Boleta de Garantía</td>
        <td valign="middle"><?php echo $row_opbga['evento']; ?></td>
        <td valign="middle"><?php echo $row_opbga['estado']; ?></td>
        <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opbga['reparo_obs']; ?></td>
        <td valign="middle"><?php echo $row_opbga['fecha_curse']; ?></td>
        <td valign="middle"><?php echo $row_opbga['nro_operacion']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opbga['moneda_operacion']); ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_opbga['monto_operacion'], 2, ',', '.'); ?></span></td>
      </tr>
      <?php } while ($row_opbga = mysqli_fetch_assoc($opbga)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcbe > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="8" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Rut Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opcbe['rut_cliente']); ?></span><span class="titulodetalle"> Nombre Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opcbe['nombre_cliente']); ?></span><span class="titulodetalle"> Total </span><span class="tituloverde"><?php echo $totalRows_opcbe ?></span></td>
    </tr>
    <tr>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Registro</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Motivo Reparo</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Curse</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro. Operacion</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcbe['id']; ?></td>
        <td valign="middle">Cobranza Extranjera  de Exportación</td>
        <td valign="middle"><?php echo $row_opcbe['evento']; ?></td>
        <td valign="middle"><?php echo $row_opcbe['estado']; ?></td>
        <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcbe['reparo_obs']; ?></td>
        <td valign="middle"><?php echo $row_opcbe['fecha_curse']; ?></td>
        <td valign="middle"><?php echo $row_opcbe['nro_operacion']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opcbe['moneda_operacion']); ?></span> <span class="respuestacolumna_azul"> <?php echo number_format($row_opcbe['monto_operacion'], 2, ',', '.'); ?></span></td>
      </tr>
      <?php } while ($row_opcbe = mysqli_fetch_assoc($opcbe)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcbi > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="9" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Rut Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opcbi['rut_cliente']); ?></span><span class="titulodetalle"> Nombre Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opcbi['nombre_cliente']); ?></span><span class="titulodetalle"> Total </span><span class="tituloverde"><?php echo $totalRows_opcbi ?></span></td>
    </tr>
    <tr>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Registro</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Motivo Reparo</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Curse</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operacion</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operación</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Tipo Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcbi['id']; ?></td>
        <td valign="middle">Cobranza Extranjeta de Importación</td>
        <td valign="middle"><?php echo $row_opcbi['evento']; ?></td>
        <td valign="middle"><?php echo $row_opcbi['estado']; ?></td>
        <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcbi['reparo_obs']; ?></td>
        <td valign="middle"><?php echo $row_opcbi['fecha_curse']; ?></td>
        <td valign="middle"><?php echo $row_opcbi['nro_operacion']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opcbi['moneda_operacion']); ?> </span><span class="respuestacolumna_azul"> <?php echo number_format($row_opcbi['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_opcbi['tipo_operacion']; ?></td>
      </tr>
      <?php } while ($row_opcbi = mysqli_fetch_assoc($opcbi)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcce > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="8" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Rut Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opcce['rut_cliente']); ?></span><span class="titulodetalle"> Nombre Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opcce['nombre_cliente']); ?></span><span class="titulodetalle"> Total </span><span class="tituloverde"><?php echo $totalRows_opcce ?></span></td>
    </tr>
    <tr>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Registro</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Motivo Reparo</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Curse</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operacion</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcce['id']; ?></td>
        <td valign="middle">Carta de Credito de Exportación</td>
        <td valign="middle"><?php echo $row_opcce['evento']; ?></td>
        <td valign="middle"><?php echo $row_opcce['estado']; ?></td>
        <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcce['reparo_obs']; ?></td>
        <td valign="middle"><?php echo $row_opcce['fecha_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcce['nro_operacion']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opcce['moneda_operacion']); ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_opcce['monto_operacion'], 2, ',', '.'); ?></span></td>
      </tr>
      <?php } while ($row_opcce = mysqli_fetch_assoc($opcce)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcci > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="9" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Rut Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opcci['rut_cliente']); ?></span><span class="titulodetalle"> Nombre Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opcci['nombre_cliente']); ?></span><span class="titulodetalle"> Total </span><span class="tituloverde"><?php echo $totalRows_opcci ?></span></td>
    </tr>
    <tr>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Registro</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Motivo Reparo</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Curse</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operación</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Doctos</td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcci['id']; ?></td>
        <td valign="middle">Carta de Crédito de Importación</td>
        <td valign="middle"><?php echo $row_opcci['evento']; ?></td>
        <td valign="middle"><?php echo $row_opcci['estado']; ?></td>
        <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcci['reparo_obs']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opcci['fecha_curse']; ?></td>
        <td valign="middle"><?php echo $row_opcci['nro_operacion']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opcci['moneda_operacion']); ?></span><span class="respuestacolumna_azul"> <?php echo number_format($row_opcci['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opcci['moneda_documentos']); ?></span><span class="respuestacolumna_azul"> <?php echo number_format($row_opcci['monto_documentos'], 2, ',', '.'); ?></span></td>
      </tr>
      <?php } while ($row_opcci = mysqli_fetch_assoc($opcci)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opdppa > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="8" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Rut Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opdppa['rut_cliente']); ?></span><span class="titulodetalle"> Nombre Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opdppa['nombre_cliente']); ?></span><span class="titulodetalle"> Total </span><span class="tituloverde"><?php echo $totalRows_opdppa ?></span></td>
    </tr>
    <tr>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Registro</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Motivo Reparo</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Curse</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opdppa['id']; ?></td>
        <td align="center" valign="middle">Ceciones de Derecho </td>
        <td align="center" valign="middle"><?php echo $row_opdppa['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opdppa['estado']; ?></td>
        <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opdppa['reparo_obs']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opdppa['fecha_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opdppa['nro_operacion']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opdppa['moneda_operacion']); ?></span> <span class="respuestacolumna_azul"> <?php echo $row_opdppa['monto_operacion']; ?></span></td>
      </tr>
      <?php } while ($row_opdppa = mysqli_fetch_assoc($opdppa)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcex > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="9" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Rut Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opcex['rut_cliente']); ?></span><span class="titulodetalle"> Nombre Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opcex['nombre_cliente']); ?></span><span class="titulodetalle"> Total </span><span class="tituloverde"><?php echo $totalRows_opcex ?></span></td>
    </tr>
    <tr>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Registro</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Motivo Reparo</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Curse</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operación</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Tipo</td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcex['id']; ?></td>
        <td valign="middle">Crédito Externo</td>
        <td valign="middle"><?php echo $row_opcex['evento']; ?></td>
        <td valign="middle"><?php echo $row_opcex['estado']; ?></td>
        <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcex['reparo_obs']; ?></td>
        <td valign="middle"><?php echo $row_opcex['fecha_curse']; ?></td>
        <td valign="middle"><?php echo $row_opcex['nro_operacion']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opcex['moneda_operacion']); ?></span><span class="respuestacolumna_azul"> <?php echo number_format($row_opcex['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_opcex['tipo_operacion']; ?></td>
      </tr>
      <?php } while ($row_opcex = mysqli_fetch_assoc($opcex)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opmec > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="8" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Rut Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opmec['rut_cliente']); ?></span><span class="titulodetalle"> Nombre Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opmec['nombre_cliente']); ?></span><span class="titulodetalle"> Total </span><span class="tituloverde"><?php echo $totalRows_opmec ?></span></td>
    </tr>
    <tr>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Registro</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Motivo Reparo</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Curse</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="middle" class="respuestacolumna_rojo"><?php echo $row_opmec['id']; ?></td>
        <td valign="middle">Mercado de Corredores </td>
        <td valign="middle"><?php echo $row_opmec['evento']; ?></td>
        <td valign="middle"><?php echo $row_opmec['estado']; ?></td>
        <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opmec['reparo_obs']; ?></td>
        <td valign="middle"><?php echo $row_opmec['fecha_curse']; ?></td>
        <td valign="middle"><?php echo $row_opmec['nro_operacion']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opmec['moneda_operacion']); ?></span><span class="respuestacolumna_azul"> <?php echo number_format($row_opmec['monto_operacion'], 2, ',', '.'); ?></span></td>
      </tr>
      <?php } while ($row_opmec = mysqli_fetch_assoc($opmec)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_oppre > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="9" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Rut Cliente </span><span class="tituloverde"><?php echo strtoupper($row_oppre['rut_cliente']); ?></span><span class="titulodetalle"> Nombre Cliente</span><span class="tituloverde"><?php echo strtoupper($row_oppre['nombre_cliente']); ?></span><span class="titulodetalle"> Total </span><span class="tituloverde"><?php echo $totalRows_oppre ?></span></td>
    </tr>
    <tr>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Registro</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Motivo Reparo</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Curse</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operación</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Tipo Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="middle" class="respuestacolumna_rojo"><?php echo $row_oppre['id']; ?></td>
        <td valign="middle">Prestamo </td>
        <td valign="middle"><?php echo $row_oppre['evento']; ?></td>
        <td valign="middle"><?php echo $row_oppre['estado']; ?></td>
        <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_oppre['reparo_obs']; ?></td>
        <td valign="middle"><?php echo $row_oppre['fecha_curse']; ?></td>
        <td valign="middle"><?php echo $row_oppre['nro_operacion']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_oppre['moneda_operacion']); ?></span><span class="respuestacolumna_azul"> <?php echo number_format($row_oppre['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_oppre['tipo_operacion']; ?></td>
      </tr>
      <?php } while ($row_oppre = mysqli_fetch_assoc($oppre)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opste > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="9" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Rut Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opste['rut_cliente']); ?></span><span class="titulodetalle"> Nombre Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opste['nombre_cliente']); ?></span><span class="titulodetalle"> Total </span><span class="tituloverde"><?php echo $totalRows_opste ?></span></td>
    </tr>
    <tr>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Registro</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Motivo Reparo</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Curse</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operación</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Tipo Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="middle" class="respuestacolumna_rojo"><?php echo $row_opste['id']; ?></td>
        <td valign="middle">Stand By Emitida </td>
        <td valign="middle"><?php echo $row_opste['evento']; ?></td>
        <td valign="middle"><?php echo $row_opste['estado']; ?></td>
        <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opste['reparo_obs']; ?></td>
        <td valign="middle"><?php echo $row_opste['fecha_curse']; ?></td>
        <td valign="middle"><?php echo $row_opste['nro_operacion']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opste['moneda_operacion']); ?></span><span class="respuestacolumna_azul"> <?php echo number_format($row_opste['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_opste['tipo_operacion']; ?></td>
      </tr>
      <?php } while ($row_opste = mysqli_fetch_assoc($opste)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opstr > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="9" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Rut Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opstr['rut_cliente']); ?></span><span class="titulodetalle"> Nombre Cliente </span><span class="tituloverde"><?php echo strtoupper($row_opstr['nombre_cliente']); ?></span><span class="titulodetalle"> Total </span><span class="tituloverde"><?php echo $totalRows_opstr ?></span></td>
    </tr>
    <tr>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Registro</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Motivo Reparo</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Curse</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operación</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Tipo Operacion</td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="middle" class="respuestacolumna_rojo"><?php echo $row_opstr['id']; ?></td>
        <td valign="middle">Stand By Recibida </td>
        <td valign="middle"><?php echo $row_opstr['evento']; ?></td>
        <td valign="middle"><?php echo $row_opstr['estado']; ?></td>
        <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opstr['reparo_obs']; ?></td>
        <td valign="middle"><?php echo $row_opstr['fecha_curse']; ?></td>
        <td valign="middle"><?php echo $row_opstr['nro_operacion']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opstr['moneda_operacion']); ?></span><span class="respuestacolumna_azul"> <?php echo number_format($row_opstr['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_opstr['tipo_operacion']; ?></td>
      </tr>
      <?php } while ($row_opstr = mysqli_fetch_assoc($opstr)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_optbc > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="8" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulodetalle">Rut Cliente </span><span class="tituloverde"><?php echo strtoupper($row_optbc['rut_cliente']); ?></span><span class="titulodetalle"> Nombre Cliente </span><span class="tituloverde"><?php echo strtoupper($row_optbc['nombre_cliente']); ?></span><span class="titulodetalle"> Total </span><span class="tituloverde"><?php echo $totalRows_optbc ?></span></td>
    </tr>
    <tr>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Registro</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Motivo Reparo</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Curse</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
      <td valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td valign="middle" class="respuestacolumna_rojo"><?php echo $row_optbc['id']; ?></td>
        <td valign="middle">IIIB5</td>
        <td valign="middle"><?php echo $row_optbc['evento']; ?></td>
        <td valign="middle"><?php echo $row_optbc['estado']; ?></td>
        <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_optbc['reparo_obs']; ?></td>
        <td valign="middle"><?php echo $row_optbc['fecha_curse']; ?></td>
        <td valign="middle"><?php echo $row_optbc['nro_operacion']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_optbc['moneda_operacion']); ?></span><span class="respuestacolumna_azul"> <?php echo number_format($row_optbc['monto_operacion'], 2, ',', '.'); ?></span></td>
      </tr>
      <?php } while ($row_optbc = mysqli_fetch_assoc($optbc)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($opbga);
mysqli_free_result($opcbe);
mysqli_free_result($opcbi);
mysqli_free_result($opcce);
mysqli_free_result($opcci);
mysqli_free_result($opdppa);
mysqli_free_result($opcex);
mysqli_free_result($opmec);
mysqli_free_result($oppre);
mysqli_free_result($opste);
mysqli_free_result($opstr);
mysqli_free_result($optbc);
?>