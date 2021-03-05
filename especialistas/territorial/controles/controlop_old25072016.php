<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,TER";
$MM_donotCheckaccess = "false";
// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 
  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}
$MM_restrictGoTo = "../erroracceso.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
?>
<?php
$colname_reparos = "1";
if (isset($_GET['especialista_curse'])) {
  $colname_reparos = $_GET['especialista_curse'];
}
$colname2_reparos = "1";
if (isset($_GET['estado'])) {
  $colname2_reparos = $_GET['estado'];
}
$colname4_reparos = "-1";
if (isset($_GET['date_ini'])) {
  $colname4_reparos = $_GET['date_ini'];
}
$colname5_reparos = "-1";
if (isset($_GET['date_fin'])) {
  $colname5_reparos = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_reparos = sprintf("SELECT * FROM opcci WHERE especialista_curse = %s and date_ingreso between %s and %s and estado LIKE %s ORDER BY date_espe ASC", GetSQLValueString($colname_reparos, "text"),GetSQLValueString($colname4_reparos, "date"),GetSQLValueString($colname5_reparos, "date"),GetSQLValueString("%" . $colname2_reparos . "%", "text"));
$reparos = mysqli_query($comercioexterior, $query_reparos) or die(mysqli_error($comercioexterior));
$row_reparos = mysqli_fetch_assoc($reparos);
$totalRows_reparos = mysqli_num_rows($reparos);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);
$colname_meco = "1";
if (isset($_GET['especialista_curse'])) {
  $colname_meco = $_GET['especialista_curse'];
}
$colname4_meco = "-1";
if (isset($_GET['date_ini'])) {
  $colname4_meco = $_GET['date_ini'];
}
$colname5_meco = "-1";
if (isset($_GET['date_fin'])) {
  $colname5_meco = $_GET['date_fin'];
}
$colname2_meco = "1";
if (isset($_GET['estado'])) {
  $colname2_meco = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_meco = sprintf("SELECT * FROM opmec WHERE especialista_curse = %s and date_ingreso between %s and %s and estado LIKE %s ORDER BY date_espe ASC", GetSQLValueString($colname_meco, "text"),GetSQLValueString($colname4_meco, "date"),GetSQLValueString($colname5_meco, "date"),GetSQLValueString("%" . $colname2_meco . "%", "text"));
$meco = mysqli_query($comercioexterior, $query_meco) or die(mysqli_error($comercioexterior));
$row_meco = mysqli_fetch_assoc($meco);
$totalRows_meco = mysqli_num_rows($meco);
$colname_cbi = "1";
if (isset($_GET['especialista_curse'])) {
  $colname_cbi = $_GET['especialista_curse'];
}
$colname4_cbi = "-1";
if (isset($_GET['date_ini'])) {
  $colname4_cbi = $_GET['date_ini'];
}
$colname5_cbi = "-1";
if (isset($_GET['date_fin'])) {
  $colname5_cbi = $_GET['date_fin'];
}
$colname2_cbi = "1";
if (isset($_GET['estado'])) {
  $colname2_cbi = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cbi = sprintf("SELECT * FROM opcbi WHERE especialista_curse = %s and date_ingreso between %s and %s and estado LIKE %s ORDER BY date_espe ASC", GetSQLValueString($colname_cbi, "text"),GetSQLValueString($colname4_cbi, "date"),GetSQLValueString($colname5_cbi, "date"),GetSQLValueString("%" . $colname2_cbi . "%", "text"));
$cbi = mysqli_query($comercioexterior, $query_cbi) or die(mysqli_error($comercioexterior));
$row_cbi = mysqli_fetch_assoc($cbi);
$totalRows_cbi = mysqli_num_rows($cbi);
$colname4_cce = "-1";
if (isset($_GET['date_ini'])) {
  $colname4_cce = $_GET['date_ini'];
}
$colname5_cce = "-1";
if (isset($_GET['date_fin'])) {
  $colname5_cce = $_GET['date_fin'];
}
$colname2_cce = "1";
if (isset($_GET['estado'])) {
  $colname2_cce = $_GET['estado'];
}
$colname_cce = "1";
if (isset($_GET['especialista_curse'])) {
  $colname_cce = $_GET['especialista_curse'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cce = sprintf("SELECT * FROM opcce WHERE especialista_curse = %s and date_ingreso between %s and %s and estado LIKE %s ORDER BY date_espe ASC", GetSQLValueString($colname_cce, "text"),GetSQLValueString($colname4_cce, "date"),GetSQLValueString($colname5_cce, "date"),GetSQLValueString("%" . $colname2_cce . "%", "text"));
$cce = mysqli_query($comercioexterior, $query_cce) or die(mysqli_error($comercioexterior));
$row_cce = mysqli_fetch_assoc($cce);
$totalRows_cce = mysqli_num_rows($cce);
$colname_pre = "1";
if (isset($_GET['especialista_curse'])) {
  $colname_pre = $_GET['especialista_curse'];
}
$colname4_pre = "-1";
if (isset($_GET['date_ini'])) {
  $colname4_pre = $_GET['date_ini'];
}
$colname5_pre = "-1";
if (isset($_GET['date_fin'])) {
  $colname5_pre = $_GET['date_fin'];
}
$colname2_pre = "1";
if (isset($_GET['estado'])) {
  $colname2_pre = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_pre = sprintf("SELECT * FROM oppre WHERE especialista_curse = %s and date_ingreso between %s and %s and estado LIKE %s ORDER BY date_espe ASC", GetSQLValueString($colname_pre, "text"),GetSQLValueString($colname4_pre, "date"),GetSQLValueString($colname5_pre, "date"),GetSQLValueString("%" . $colname2_pre . "%", "text"));
$pre = mysqli_query($comercioexterior, $query_pre) or die(mysqli_error($comercioexterior));
$row_pre = mysqli_fetch_assoc($pre);
$totalRows_pre = mysqli_num_rows($pre);
$colname_cbe = "1";
if (isset($_GET['especialista_curse'])) {
  $colname_cbe = $_GET['especialista_curse'];
}
$colname4_cbe = "-1";
if (isset($_GET['date_ini'])) {
  $colname4_cbe = $_GET['date_ini'];
}
$colname5_cbe = "-1";
if (isset($_GET['date_fin'])) {
  $colname5_cbe = $_GET['date_fin'];
}
$colname2_cbe = "1";
if (isset($_GET['estado'])) {
  $colname2_cbe = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cbe = sprintf("SELECT * FROM opcbe WHERE especialista_curse = %s and date_ingreso between %s and %s and estado LIKE %s ORDER BY date_espe ASC", GetSQLValueString($colname_cbe, "text"),GetSQLValueString($colname4_cbe, "text"),GetSQLValueString($colname5_cbe, "date"),GetSQLValueString("%" . $colname2_cbe . "%", "text"));
$cbe = mysqli_query($comercioexterior, $query_cbe) or die(mysqli_error($comercioexterior));
$row_cbe = mysqli_fetch_assoc($cbe);
$totalRows_cbe = mysqli_num_rows($cbe);
$colname_cdpa = "1";
if (isset($_GET['especialista_curse'])) {
  $colname_cdpa = $_GET['especialista_curse'];
}
$colname4_cdpa = "-1";
if (isset($_GET['date_ini'])) {
  $colname4_cdpa = $_GET['date_ini'];
}
$colname5_cdpa = "-1";
if (isset($_GET['date_fin'])) {
  $colname5_cdpa = $_GET['date_fin'];
}
$colname2_cdpa = "1";
if (isset($_GET['estado'])) {
  $colname2_cdpa = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cdpa = sprintf("SELECT * FROM opcdpa WHERE especialista_curse = %s and date_ingreso between %s and %s and estado LIKE %s ORDER BY date_espe ASC", GetSQLValueString($colname_cdpa, "text"),GetSQLValueString($colname4_cdpa, "date"),GetSQLValueString($colname5_cdpa, "date"),GetSQLValueString("%" . $colname2_cdpa . "%", "text"));
$cdpa = mysqli_query($comercioexterior, $query_cdpa) or die(mysqli_error($comercioexterior));
$row_cdpa = mysqli_fetch_assoc($cdpa);
$totalRows_cdpa = mysqli_num_rows($cdpa);
$colname_ste = "1";
if (isset($_GET['especialista_curse'])) {
  $colname_ste = $_GET['especialista_curse'];
}
$colname4_ste = "-1";
if (isset($_GET['date_ini'])) {
  $colname4_ste = $_GET['date_ini'];
}
$colname5_ste = "-1";
if (isset($_GET['date_fin'])) {
  $colname5_ste = $_GET['date_fin'];
}
$colname2_ste = "1";
if (isset($_GET['estado'])) {
  $colname2_ste = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ste = sprintf("SELECT * FROM opste WHERE especialista_curse = %s and date_ingreso between %s and %s and estado LIKE %s ORDER BY date_espe ASC", GetSQLValueString($colname_ste, "text"),GetSQLValueString($colname4_ste, "date"),GetSQLValueString($colname5_ste, "date"),GetSQLValueString("%" . $colname2_ste . "%", "text"));
$ste = mysqli_query($comercioexterior, $query_ste) or die(mysqli_error($comercioexterior));
$row_ste = mysqli_fetch_assoc($ste);
$totalRows_ste = mysqli_num_rows($ste);
$colname_cex = "1";
if (isset($_GET['especialista_curse'])) {
  $colname_cex = $_GET['especialista_curse'];
}
$colname4_cex = "-1";
if (isset($_GET['date_ini'])) {
  $colname4_cex = $_GET['date_ini'];
}
$colname5_cex = "-1";
if (isset($_GET['date_fin'])) {
  $colname5_cex = $_GET['date_fin'];
}
$colname2_cex = "1";
if (isset($_GET['estado'])) {
  $colname2_cex = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cex = sprintf("SELECT * FROM opcex WHERE especialista_curse = %s and date_ingreso between %s and %s and estado LIKE %s ORDER BY date_espe ASC", GetSQLValueString($colname_cex, "text"),GetSQLValueString($colname4_cex, "date"),GetSQLValueString($colname5_cex, "date"),GetSQLValueString("%" . $colname2_cex . "%", "text"));
$cex = mysqli_query($comercioexterior, $query_cex) or die(mysqli_error($comercioexterior));
$row_cex = mysqli_fetch_assoc($cex);
$totalRows_cex = mysqli_num_rows($cex);
$colname_tbc = "1";
if (isset($_GET['especialista_curse'])) {
  $colname_tbc = $_GET['especialista_curse'];
}
$colname4_tbc = "-1";
if (isset($_GET['date_ini'])) {
  $colname4_tbc = $_GET['date_ini'];
}
$colname5_tbc = "-1";
if (isset($_GET['date_fin'])) {
  $colname5_tbc = $_GET['date_fin'];
}
$colname2_tbc = "1";
if (isset($_GET['estado'])) {
  $colname2_tbc = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_tbc = sprintf("SELECT * FROM optbc WHERE especialista_curse = %s and date_ingreso between %s and %s and estado LIKE %s ORDER BY date_espe ASC", GetSQLValueString($colname_tbc, "text"),GetSQLValueString($colname4_tbc, "date"),GetSQLValueString($colname5_tbc, "date"),GetSQLValueString("%" . $colname2_tbc . "%", "text"));
$tbc = mysqli_query($comercioexterior, $query_tbc) or die(mysqli_error($comercioexterior));
$row_tbc = mysqli_fetch_assoc($tbc);
$totalRows_tbc = mysqli_num_rows($tbc);
$colname_bga = "1";
if (isset($_GET['especialista_curse'])) {
  $colname_bga = $_GET['especialista_curse'];
}
$colname4_bga = "-1";
if (isset($_GET['date_ini'])) {
  $colname4_bga = $_GET['date_ini'];
}
$colname5_bga = "-1";
if (isset($_GET['date_fin'])) {
  $colname5_bga = $_GET['date_fin'];
}
$colname2_bga = "1";
if (isset($_GET['estado'])) {
  $colname2_bga = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_bga = sprintf("SELECT * FROM opbga WHERE especialista_curse = %s and date_ingreso between %s and %s and estado LIKE %s ORDER BY date_espe ASC", GetSQLValueString($colname_bga, "text"),GetSQLValueString($colname4_bga, "date"),GetSQLValueString($colname5_bga, "date"),GetSQLValueString("%" . $colname2_bga . "%", "text"));
$bga = mysqli_query($comercioexterior, $query_bga) or die(mysqli_error($comercioexterior));
$row_bga = mysqli_fetch_assoc($bga);
$totalRows_bga = mysqli_num_rows($bga);

$colname_convenio = "-1";
if (isset($_GET['especialista_curse'])) {
  $colname_convenio = $_GET['especialista_curse'];
}
$colname4_convenio = "-1";
if (isset($_GET['date_ini'])) {
  $colname4_convenio = $_GET['date_ini'];
}
$colname5_convenio = "-1";
if (isset($_GET['date_fin'])) {
  $colname5_convenio = $_GET['date_fin'];
}
$colname2_convenio = "-1";
if (isset($_GET['estado'])) {
  $colname2_convenio = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_convenio = sprintf("SELECT * FROM convenioweb WHERE especialista_curse = %s  and fecha_ingreso between %s and %s and estado LIKE %s ORDER BY id ASC", GetSQLValueString($colname_convenio, "text"),GetSQLValueString($colname4_convenio, "date"),GetSQLValueString($colname5_convenio, "date"),GetSQLValueString("%" . $colname2_convenio . "%", "text"));
$convenio = mysqli_query($comercioexterior, $query_convenio) or die(mysqli_error($query_convenio));
$row_convenio = mysqli_fetch_assoc($convenio);
$totalRows_convenio = mysqli_num_rows($convenio);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Control OP Enviadas a Proceso - Maestro</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo5 {
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.Estilo8 {color: #00FF00}
.Estilo10 {color: #FFFFFF; font-weight: bold; }
.Estilo11 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo12 {font-size: 14px}
.Estilo13 {color: #FFFFFF}
.Estilo15 {
	color: #00FF00;
	font-size: 12px;
	font-weight: bold;
}
.Estilo18 {font-size: 12px}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
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
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script>
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">OPERACIONES ENVIADAS A PROCESO - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">ESPECIALISTAS TERRITORIALES</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5"><span class="titulodetalle">Control de Operaciones Enviadas a Proceso</span></span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right" valign="middle">Especialista Curse:</div></td>
      <td width="79%" align="left" valign="middle"><input name="especialista_curse" type="text" class="etiqueta12" id="especialista_curse" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20" readonly="readonly"></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Fecha Ingreso:</div></td>
      <td align="left" valign="middle"><span class="respuestacolumna_rojo">Desde</span>
        <input name="date_ini" type="text" class="etiqueta12" id="date_ini" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
      <span class="rojopequeno">Hasta 
      <input name="date_fin" type="text" class="etiqueta12" id="date_fin" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
      (aaaa-mm-dd)</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Estado Ope.:</div></td>
      <td align="left" valign="middle"><select name="estado" class="etiqueta12" id="estado">
        <option value="." selected>Todas</option>
        <option value="Cursada.">Cursada</option>
        <option value="Pendiente.">Pendiente</option>
        <option value="Reparada.">Reparada</option>
        <option value="Rechazada.">Rechazada</option>
        <option value="Preingresada.">Preingresada</option>
        <option value="Solucionado.">Solucionado</option>
</select></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../tr.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_reparos > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="19" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Total Operaciones Enviadas a Curse </span><span class="tituloverde"><?php echo $totalRows_reparos ?></span><span class="Estilo5"><span class="Estilo8"> <span class="Estilo13">Cartas de Cr&eacute;dito Importaci&oacute;n</span></span></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    <td align="center" valign="middle" class="titulocolumnas">Enviar a Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Negociaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador</td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor</td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente</td>
    <td align="center" valign="middle" class="titulocolumnas">Solucionar Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo Cuenta</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo Ni</td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista NI</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_reparos['id']; ?></span>      </div></td>
    <td align="center" valign="middle"><?php if ($row_reparos['estado'] <> 'Cursada.' and $row_reparos['estado'] <> 'Eliminada.' and $row_reparos['estado'] <> 'Pendiente.' and $row_reparos['estado'] <> 'Preingresada.' and $row_reparos['estado'] <> 'Reparada.' and $row_reparos['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_reparos['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_reparos['estado'] <> 'Solucionado.' and $row_reparos['estado'] <> 'Eliminada.' and $row_reparos['estado'] <> 'Pendiente.' and $row_reparos['estado'] <> 'Preingresada.' and $row_reparos['estado'] <> 'Reparada.' and $row_reparos['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_reparos['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_reparos['estado'] <> 'Cursada.' and $row_reparos['estado'] <> 'Solucionado.' and $row_reparos['estado'] <> 'Pendiente.' and $row_reparos['estado'] <> 'Preingresada.' and $row_reparos['estado'] <> 'Reparada.' and $row_reparos['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_reparos['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_reparos['estado'] <> 'Cursada.' and $row_reparos['estado'] <> 'Eliminada.' and $row_reparos['estado'] <> 'Solucionado.' and $row_reparos['estado'] <> 'Preingresada.' and $row_reparos['estado'] <> 'Reparada.' and $row_reparos['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_reparos['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_reparos['estado'] <> 'Cursada.' and $row_reparos['estado'] <> 'Eliminada.' and $row_reparos['estado'] <> 'Pendiente.' and $row_reparos['estado'] <> 'Solucionado.' and $row_reparos['estado'] <> 'Reparada.' and $row_reparos['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="envioacursecci.php?recordID=<?php echo $row_reparos['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_reparos['estado'] <> 'Cursada.' and $row_reparos['estado'] <> 'Eliminada.' and $row_reparos['estado'] <> 'Pendiente.' and $row_reparos['estado'] <> 'Solucionado.' and $row_reparos['estado'] <> 'Reparada.' and $row_reparos['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_reparos['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_reparos['estado'] <> 'Cursada.' and $row_reparos['estado'] <> 'Eliminada.' and $row_reparos['estado'] <> 'Pendiente.' and $row_reparos['estado'] <> 'Preingresada.' and $row_reparos['estado'] <> 'Solucionado.' and $row_reparos['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_reparos['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php echo $row_reparos['date_espe']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_reparos['rut_cliente']; ?></div></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_reparos['nombre_cliente']); ?></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_reparos['nro_operacion']); ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_reparos['evento']; ?></div></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_reparos['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_reparos['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_reparos['moneda_documentos']); ?></span><strong class="respuestacolumna_azul"><?php echo number_format($row_reparos['monto_documentos'], 2, ',', '.'); ?></strong>
      </div></td>
    <td align="center" valign="middle"><?php echo $row_reparos['sub_estado']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_reparos['asignador']); ?></td>
    <td align="center" valign="middle"><?php if ($row_reparos['estado'] <> $row_colores['cursada'] and $row_reparos['estado'] <> $row_colores['pendiente'] and $row_reparos['estado'] <> $row_colores['solucionado'] and $row_reparos['estado'] <> $row_colores['preingresada'] and $row_reparos['estado'] <> $row_colores['eliminada'] and $row_reparos['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_reparos['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_reparos['estado'] <> $row_colores['cursada'] and $row_reparos['estado'] <> $row_colores['pendiente'] and $row_reparos['estado'] <> $row_colores['solucionado'] and $row_reparos['estado'] <> $row_colores['preingresada'] and $row_reparos['estado'] <> $row_colores['eliminada'] and $row_reparos['estado'] <> $row_colores['reparada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_reparos['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_reparos['estado'] <> $row_colores['reparada'] and $row_reparos['estado'] <> $row_colores['pendiente'] and $row_reparos['estado'] <> $row_colores['solucionado'] and $row_reparos['estado'] <> $row_colores['preingresada'] and $row_reparos['estado'] <> $row_colores['eliminada'] and $row_reparos['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_reparos['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_reparos['estado'] <> $row_colores['reparada'] and $row_reparos['estado'] <> $row_colores['cursada'] and $row_reparos['estado'] <> $row_colores['solucionado'] and $row_reparos['estado'] <> $row_colores['preingresada'] and $row_reparos['estado'] <> $row_colores['eliminada'] and $row_reparos['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_reparos['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_reparos['estado'] <> $row_colores['reparada'] and $row_reparos['estado'] <> $row_colores['pendiente'] and $row_reparos['estado'] <> $row_colores['preingresada'] and $row_reparos['estado'] <> $row_colores['cursada'] and $row_reparos['estado'] <> $row_colores['eliminada'] and $row_reparos['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_reparos['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_reparos['estado'] <> $row_colores['reparada'] and $row_reparos['estado'] <> $row_colores['pendiente'] and $row_reparos['estado'] <> $row_colores['solucionado'] and $row_reparos['estado'] <> $row_colores['cursada'] and $row_reparos['estado'] <> $row_colores['eliminada'] and $row_reparos['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_reparos['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_reparos['estado'] <> $row_colores['reparada'] and $row_reparos['estado'] <> $row_colores['pendiente'] and $row_reparos['estado'] <> $row_colores['solucionado'] and $row_reparos['estado'] <> $row_colores['cursada'] and $row_reparos['estado'] <> $row_colores['preingresada'] and $row_reparos['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_reparos['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_reparos['reparo_obs']; ?></td>
    <td align="center" valign="middle"><?php echo $row_reparos['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_reparos['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_reparos['urgente']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_reparos['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_reparos['urgente']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="center" valign="middle"><?php if ($row_reparos['estado'] <> 'Cursada.' and $row_reparos['estado'] <> 'Eliminada.' and $row_reparos['estado'] <> 'Pendiente.' and $row_reparos['estado'] <> 'Preingresada.' and $row_reparos['estado'] <> 'Reparada.' and $row_reparos['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_reparos['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_reparos['estado'] <> 'Solucionado.' and $row_reparos['estado'] <> 'Eliminada.' and $row_reparos['estado'] <> 'Pendiente.' and $row_reparos['estado'] <> 'Preingresada.' and $row_reparos['estado'] <> 'Reparada.' and $row_reparos['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_reparos['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_reparos['estado'] <> 'Cursada.' and $row_reparos['estado'] <> 'Solucionado.' and $row_reparos['estado'] <> 'Pendiente.' and $row_reparos['estado'] <> 'Preingresada.' and $row_reparos['estado'] <> 'Reparada.' and $row_reparos['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_reparos['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_reparos['estado'] <> 'Cursada.' and $row_reparos['estado'] <> 'Eliminada.' and $row_reparos['estado'] <> 'Solucionado.' and $row_reparos['estado'] <> 'Preingresada.' and $row_reparos['estado'] <> 'Reparada.' and $row_reparos['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_reparos['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_reparos['estado'] <> 'Cursada.' and $row_reparos['estado'] <> 'Eliminada.' and $row_reparos['estado'] <> 'Pendiente.' and $row_reparos['estado'] <> 'Solucionado.' and $row_reparos['estado'] <> 'Reparada.' and $row_reparos['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_reparos['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_reparos['estado'] <> 'Cursada.' and $row_reparos['estado'] <> 'Eliminada.' and $row_reparos['estado'] <> 'Pendiente.' and $row_reparos['estado'] <> 'Solucionado.' and $row_reparos['estado'] <> 'Reparada.' and $row_reparos['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_reparos['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_reparos['estado'] <> 'Cursada.' and $row_reparos['estado'] <> 'Eliminada.' and $row_reparos['estado'] <> 'Pendiente.' and $row_reparos['estado'] <> 'Preingresada.' and $row_reparos['estado'] <> 'Solucionado.' and $row_reparos['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="reparodetcci.php?recordID=<?php echo $row_reparos['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="left" valign="middle"><?php echo $row_reparos['ejecutivo_cuenta']; ?></td>
    <td align="left" valign="middle"><?php echo $row_reparos['ejecutivo_ni']; ?></td>
    <td align="left" valign="middle"><?php echo $row_reparos['especialista_ni']; ?></td>
  </tr>
  <?php } while ($row_reparos = mysqli_fetch_assoc($reparos)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_cbi > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td colspan="19" align="left"><span class="Estilo10"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></span><span class="Estilo5">Total Operaciones Enviadas a Curse&nbsp;<span class="tituloverde"><?php echo $totalRows_cbi ?></span> Cobranza Extranjera de Importaci&oacute;n y OPI</span></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Nro Folio </td>
    <td align="center" class="titulocolumnas">Enviar a Curse</td>
    <td align="center" class="titulocolumnas">Fecha Ingreso </td>
    <td align="center" class="titulocolumnas">Rut Cliente </td>
    <td align="center" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </td>
    <td align="center" class="titulocolumnas">Evento</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </td>
    <td align="center" class="titulocolumnas">Estado Operador </td>
    <td align="center" class="titulocolumnas">Supervisor</td>
    <td align="center" class="titulocolumnas">Estado Supervisor </td>
    <td align="center" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" class="titulocolumnas">Fecha Curse</td>
    <td align="center" class="titulocolumnas">Tipo Operaci&oacute;n</td>
    <td align="center" class="titulocolumnas">Urgente</td>
    <td align="center" class="titulocolumnas">Solucionar Reparo</td>
    <td align="center" class="titulocolumnas">Ejecutivo Cuenta</td>
    <td align="center" class="titulocolumnas">Ejecutivo NI</td>
    <td align="center" class="titulocolumnas">Especialista NI</td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="../../../espcomex/controles/untitled.php?recordID=<?php echo $row_cbi['id']; ?>"> </a><span class="respuestacolumna_rojo"><?php echo $row_cbi['id']; ?></span>      </div></td>
    <td align="center"><?php if ($row_cbi['estado'] <> 'Cursada.' and $row_cbi['estado'] <> 'Eliminada.' and $row_cbi['estado'] <> 'Pendiente.' and $row_cbi['estado'] <> 'Preingresada.' and $row_cbi['estado'] <> 'Reparada.' and $row_cbi['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbi['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbi['estado'] <> 'Solucionado.' and $row_cbi['estado'] <> 'Eliminada.' and $row_cbi['estado'] <> 'Pendiente.' and $row_cbi['estado'] <> 'Preingresada.' and $row_cbi['estado'] <> 'Reparada.' and $row_cbi['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbi['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbi['estado'] <> 'Cursada.' and $row_cbi['estado'] <> 'Solucionado.' and $row_cbi['estado'] <> 'Pendiente.' and $row_cbi['estado'] <> 'Preingresada.' and $row_cbi['estado'] <> 'Reparada.' and $row_cbi['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbi['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbi['estado'] <> 'Cursada.' and $row_cbi['estado'] <> 'Eliminada.' and $row_cbi['estado'] <> 'Solucionado.' and $row_cbi['estado'] <> 'Preingresada.' and $row_cbi['estado'] <> 'Reparada.' and $row_cbi['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbi['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbi['estado'] <> 'Cursada.' and $row_cbi['estado'] <> 'Eliminada.' and $row_cbi['estado'] <> 'Pendiente.' and $row_cbi['estado'] <> 'Solucionado.' and $row_cbi['estado'] <> 'Reparada.' and $row_cbi['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="envioacursecbi.php?recordID=<?php echo $row_cbi['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbi['estado'] <> 'Cursada.' and $row_cbi['estado'] <> 'Eliminada.' and $row_cbi['estado'] <> 'Pendiente.' and $row_cbi['estado'] <> 'Solucionado.' and $row_cbi['estado'] <> 'Reparada.' and $row_cbi['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbi['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbi['estado'] <> 'Cursada.' and $row_cbi['estado'] <> 'Eliminada.' and $row_cbi['estado'] <> 'Pendiente.' and $row_cbi['estado'] <> 'Preingresada.' and $row_cbi['estado'] <> 'Solucionado.' and $row_cbi['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbi['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="center"><?php echo $row_cbi['date_espe']; ?> </td>
    <td align="center"><?php echo $row_cbi['rut_cliente']; ?></td>
    <td align="left"><?php echo $row_cbi['nombre_cliente']; ?> </div></td>
    <td align="center" class="respuestacolumna_rojo"><?php echo $row_cbi['nro_operacion']; ?></td>
    <td align="center"><?php echo $row_cbi['evento']; ?> </td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo $row_cbi['moneda_operacion']; ?></span>&nbsp; <strong class="respuestacolumna_azul"><?php echo number_format($row_cbi['monto_operacion'], 2, ',', '.'); ?></strong> </td>
    <td align="center"><?php echo $row_cbi['sub_estado']; ?> </td>
    <td align="center"><?php echo $row_cbi['asignador']; ?> </td>
    <td align="center"><?php if ($row_cbi['estado'] <> $row_colores['cursada'] and $row_cbi['estado'] <> $row_colores['pendiente'] and $row_cbi['estado'] <> $row_colores['solucionado'] and $row_cbi['estado'] <> $row_colores['preingresada'] and $row_cbi['estado'] <> $row_colores['eliminada'] and $row_cbi['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cbi['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cbi['estado'] <> $row_colores['cursada'] and $row_cbi['estado'] <> $row_colores['pendiente'] and $row_cbi['estado'] <> $row_colores['solucionado'] and $row_cbi['estado'] <> $row_colores['preingresada'] and $row_cbi['estado'] <> $row_colores['eliminada'] and $row_cbi['estado'] <> $row_colores['reparada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cbi['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cbi['estado'] <> $row_colores['reparada'] and $row_cbi['estado'] <> $row_colores['pendiente'] and $row_cbi['estado'] <> $row_colores['solucionado'] and $row_cbi['estado'] <> $row_colores['preingresada'] and $row_cbi['estado'] <> $row_colores['eliminada'] and $row_cbi['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cbi['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cbi['estado'] <> $row_colores['reparada'] and $row_cbi['estado'] <> $row_colores['cursada'] and $row_cbi['estado'] <> $row_colores['solucionado'] and $row_cbi['estado'] <> $row_colores['preingresada'] and $row_cbi['estado'] <> $row_colores['eliminada'] and $row_cbi['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_cbi['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cbi['estado'] <> $row_colores['reparada'] and $row_cbi['estado'] <> $row_colores['pendiente'] and $row_cbi['estado'] <> $row_colores['preingresada'] and $row_cbi['estado'] <> $row_colores['cursada'] and $row_cbi['estado'] <> $row_colores['eliminada'] and $row_cbi['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_cbi['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cbi['estado'] <> $row_colores['reparada'] and $row_cbi['estado'] <> $row_colores['pendiente'] and $row_cbi['estado'] <> $row_colores['solucionado'] and $row_cbi['estado'] <> $row_colores['cursada'] and $row_cbi['estado'] <> $row_colores['eliminada'] and $row_cbi['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      </span>
      <span class="Naranja2"><?php echo $row_cbi['estado']; ?></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_cbi['estado'] <> $row_colores['reparada'] and $row_cbi['estado'] <> $row_colores['pendiente'] and $row_cbi['estado'] <> $row_colores['solucionado'] and $row_cbi['estado'] <> $row_colores['cursada'] and $row_cbi['estado'] <> $row_colores['preingresada'] and $row_cbi['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      </span>
      <span class="Gris2"><?php echo $row_cbi['estado']; ?></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" class="respuestacolumna_rojo"><?php echo $row_cbi['reparo_obs']; ?></td>
    <td align="center"><?php echo $row_cbi['date_supe']; ?></td>
    <td align="center"><?php echo $row_cbi['tipo_operacion']; ?> </td>
    <td align="center"><?php if ($row_cbi['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cbi['urgente']; ?></span></span><span class="Estilo12"> </span>
      <?php } // Show if not first page ?>
      <?php if ($row_cbi['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cbi['urgente']; ?></span><span class="Estilo12"> </span>
      <?php } // Show if not first page ?>
    </td>
    <td align="center"><?php if ($row_cbi['estado'] <> 'Cursada.' and $row_cbi['estado'] <> 'Eliminada.' and $row_cbi['estado'] <> 'Pendiente.' and $row_cbi['estado'] <> 'Preingresada.' and $row_cbi['estado'] <> 'Reparada.' and $row_cbi['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbi['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbi['estado'] <> 'Solucionado.' and $row_cbi['estado'] <> 'Eliminada.' and $row_cbi['estado'] <> 'Pendiente.' and $row_cbi['estado'] <> 'Preingresada.' and $row_cbi['estado'] <> 'Reparada.' and $row_cbi['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbi['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbi['estado'] <> 'Cursada.' and $row_cbi['estado'] <> 'Solucionado.' and $row_cbi['estado'] <> 'Pendiente.' and $row_cbi['estado'] <> 'Preingresada.' and $row_cbi['estado'] <> 'Reparada.' and $row_cbi['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbi['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbi['estado'] <> 'Cursada.' and $row_cbi['estado'] <> 'Eliminada.' and $row_cbi['estado'] <> 'Solucionado.' and $row_cbi['estado'] <> 'Preingresada.' and $row_cbi['estado'] <> 'Reparada.' and $row_cbi['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbi['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbi['estado'] <> 'Cursada.' and $row_cbi['estado'] <> 'Eliminada.' and $row_cbi['estado'] <> 'Pendiente.' and $row_cbi['estado'] <> 'Solucionado.' and $row_cbi['estado'] <> 'Reparada.' and $row_cbi['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbi['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbi['estado'] <> 'Cursada.' and $row_cbi['estado'] <> 'Eliminada.' and $row_cbi['estado'] <> 'Pendiente.' and $row_cbi['estado'] <> 'Solucionado.' and $row_cbi['estado'] <> 'Reparada.' and $row_cbi['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbi['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbi['estado'] <> 'Cursada.' and $row_cbi['estado'] <> 'Eliminada.' and $row_cbi['estado'] <> 'Pendiente.' and $row_cbi['estado'] <> 'Preingresada.' and $row_cbi['estado'] <> 'Solucionado.' and $row_cbi['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="reparodetcbi.php?recordID=<?php echo $row_cbi['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="left"><?php echo $row_cbi['ejecutivo_cuenta']; ?></td>
    <td align="left"><?php echo $row_cbi['ejecutivo_ni']; ?></td>
    <td align="left"><?php echo $row_cbi['especialista_ni']; ?></td>
  </tr>
  <?php } while ($row_cbi = mysqli_fetch_assoc($cbi)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_meco > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="left" bgcolor="#999999">
    <td colspan="17" align="left" valign="middle"><span class="Estilo10"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></span><span class="Estilo5">Total Operaciones Enviadas a Curse&nbsp;<span class="tituloverde"><?php echo $totalRows_meco ?></span> Mercado de Corredores</span></td>
  </tr>
  <tr align="center" bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio </td>
    <td align="center" valign="middle" class="titulocolumnas">Enviar a Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador </td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor       
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente</td>
    <td align="center" valign="middle" class="titulocolumnas">Solucionar Reparo </td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo Cuenta</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo NI</td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista NI</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_meco['id']; ?></td>
      <td align="center" valign="middle"><?php if ($row_meco['estado'] <> 'Cursada.' and $row_meco['estado'] <> 'Eliminada.' and $row_meco['estado'] <> 'Pendiente.' and $row_meco['estado'] <> 'Preingresada.' and $row_meco['estado'] <> 'Reparada.' and $row_meco['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_meco['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_meco['estado'] <> 'Solucionado.' and $row_meco['estado'] <> 'Eliminada.' and $row_meco['estado'] <> 'Pendiente.' and $row_meco['estado'] <> 'Preingresada.' and $row_meco['estado'] <> 'Reparada.' and $row_meco['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_meco['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_meco['estado'] <> 'Cursada.' and $row_meco['estado'] <> 'Solucionado.' and $row_meco['estado'] <> 'Pendiente.' and $row_meco['estado'] <> 'Preingresada.' and $row_meco['estado'] <> 'Reparada.' and $row_meco['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_meco['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_meco['estado'] <> 'Cursada.' and $row_meco['estado'] <> 'Eliminada.' and $row_meco['estado'] <> 'Solucionado.' and $row_meco['estado'] <> 'Preingresada.' and $row_meco['estado'] <> 'Reparada.' and $row_meco['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_meco['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_meco['estado'] <> 'Cursada.' and $row_meco['estado'] <> 'Eliminada.' and $row_meco['estado'] <> 'Pendiente.' and $row_meco['estado'] <> 'Solucionado.' and $row_meco['estado'] <> 'Reparada.' and $row_meco['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="envioacursemec.php?recordID=<?php echo $row_meco['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_meco['estado'] <> 'Cursada.' and $row_meco['estado'] <> 'Eliminada.' and $row_meco['estado'] <> 'Pendiente.' and $row_meco['estado'] <> 'Solucionado.' and $row_meco['estado'] <> 'Reparada.' and $row_meco['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_meco['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_meco['estado'] <> 'Cursada.' and $row_meco['estado'] <> 'Eliminada.' and $row_meco['estado'] <> 'Pendiente.' and $row_meco['estado'] <> 'Preingresada.' and $row_meco['estado'] <> 'Solucionado.' and $row_meco['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_meco['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
      <td align="center" valign="middle"><?php echo $row_meco['date_espe']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_meco['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_meco['nombre_cliente']); ?> </td>
      <td align="center" valign="middle"><?php echo $row_meco['evento']; ?></td>
      <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_meco['moneda_operacion']); ?></span><br>
        <strong class="respuestacolumna_azul"><?php echo number_format($row_meco['monto_operacion'], 2, ',', '.'); ?></strong></td>
      <td align="center" valign="middle"><?php echo $row_meco['sub_estado']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_meco['asignador']); ?></td>
      <td align="center" valign="middle"><?php if ($row_meco['estado'] <> $row_colores['cursada'] and $row_meco['estado'] <> $row_colores['pendiente'] and $row_meco['estado'] <> $row_colores['solucionado'] and $row_meco['estado'] <> $row_colores['preingresada'] and $row_meco['estado'] <> $row_colores['eliminada'] and $row_meco['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_meco['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_meco['estado'] <> $row_colores['cursada'] and $row_meco['estado'] <> $row_colores['pendiente'] and $row_meco['estado'] <> $row_colores['solucionado'] and $row_meco['estado'] <> $row_colores['preingresada'] and $row_meco['estado'] <> $row_colores['eliminada'] and $row_meco['estado'] <> $row_colores['reparada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_meco['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_meco['estado'] <> $row_colores['reparada'] and $row_meco['estado'] <> $row_colores['pendiente'] and $row_meco['estado'] <> $row_colores['solucionado'] and $row_meco['estado'] <> $row_colores['preingresada'] and $row_meco['estado'] <> $row_colores['eliminada'] and $row_meco['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_meco['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_meco['estado'] <> $row_colores['reparada'] and $row_meco['estado'] <> $row_colores['cursada'] and $row_meco['estado'] <> $row_colores['solucionado'] and $row_meco['estado'] <> $row_colores['preingresada'] and $row_meco['estado'] <> $row_colores['eliminada'] and $row_meco['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_meco['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_meco['estado'] <> $row_colores['reparada'] and $row_meco['estado'] <> $row_colores['pendiente'] and $row_meco['estado'] <> $row_colores['preingresada'] and $row_meco['estado'] <> $row_colores['cursada'] and $row_meco['estado'] <> $row_colores['eliminada'] and $row_meco['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_meco['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_meco['estado'] <> $row_colores['reparada'] and $row_meco['estado'] <> $row_colores['pendiente'] and $row_meco['estado'] <> $row_colores['solucionado'] and $row_meco['estado'] <> $row_colores['cursada'] and $row_meco['estado'] <> $row_colores['eliminada'] and $row_meco['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_meco['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_meco['estado'] <> $row_colores['reparada'] and $row_meco['estado'] <> $row_colores['pendiente'] and $row_meco['estado'] <> $row_colores['solucionado'] and $row_meco['estado'] <> $row_colores['cursada'] and $row_meco['estado'] <> $row_colores['preingresada'] and $row_meco['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_meco['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
      <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_meco['reparo_obs']; ?></td>
      <td align="center" valign="middle"><?php echo $row_meco['date_supe']; ?></td>
      <td align="center" valign="middle"><?php if ($row_meco['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_meco['urgente']; ?> </span></span>        
		<?php } // Show if not first page ?>
		<?php if ($row_meco['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_meco['urgente']; ?> </span></span>
      <?php } // Show if not first page ?> </td>
      <td align="center" valign="middle"><?php if ($row_meco['estado'] <> 'Cursada.' and $row_meco['estado'] <> 'Eliminada.' and $row_meco['estado'] <> 'Pendiente.' and $row_meco['estado'] <> 'Preingresada.' and $row_meco['estado'] <> 'Reparada.' and $row_meco['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_meco['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_meco['estado'] <> 'Solucionado.' and $row_meco['estado'] <> 'Eliminada.' and $row_meco['estado'] <> 'Pendiente.' and $row_meco['estado'] <> 'Preingresada.' and $row_meco['estado'] <> 'Reparada.' and $row_meco['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_meco['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_meco['estado'] <> 'Cursada.' and $row_meco['estado'] <> 'Solucionado.' and $row_meco['estado'] <> 'Pendiente.' and $row_meco['estado'] <> 'Preingresada.' and $row_meco['estado'] <> 'Reparada.' and $row_meco['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_meco['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_meco['estado'] <> 'Cursada.' and $row_meco['estado'] <> 'Eliminada.' and $row_meco['estado'] <> 'Solucionado.' and $row_meco['estado'] <> 'Preingresada.' and $row_meco['estado'] <> 'Reparada.' and $row_meco['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_meco['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_meco['estado'] <> 'Cursada.' and $row_meco['estado'] <> 'Eliminada.' and $row_meco['estado'] <> 'Pendiente.' and $row_meco['estado'] <> 'Solucionado.' and $row_meco['estado'] <> 'Reparada.' and $row_meco['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_meco['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_meco['estado'] <> 'Cursada.' and $row_meco['estado'] <> 'Eliminada.' and $row_meco['estado'] <> 'Pendiente.' and $row_meco['estado'] <> 'Solucionado.' and $row_meco['estado'] <> 'Reparada.' and $row_meco['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_meco['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_meco['estado'] <> 'Cursada.' and $row_meco['estado'] <> 'Eliminada.' and $row_meco['estado'] <> 'Pendiente.' and $row_meco['estado'] <> 'Preingresada.' and $row_meco['estado'] <> 'Solucionado.' and $row_meco['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="reparodetmec.php?recordID=<?php echo $row_meco['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
      <td align="left" valign="middle"><?php echo $row_meco['ejecutivo_cuenta']; ?></td>
      <td align="left" valign="middle"><?php echo $row_meco['ejecutivo_ni']; ?></td>
      <td align="left" valign="middle"><?php echo $row_meco['especialista_ni']; ?></td>
    </tr>
    <?php } while ($row_meco = mysqli_fetch_assoc($meco)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_cce > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="18" align="left" valign="middle"><span class="Estilo10"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></span><span class="Estilo5">Total Operaciones Enviadas a Curse </span><span class="tituloverde"><?php echo $totalRows_cce ?> </span><span class="Estilo5">Carta de Cr&eacute;dito Exportaci&oacute;n</span></div></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio 
      </div>    </td>
    <td align="center" valign="middle" class="titulocolumnas">Enviar a Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador 
      </div>    </td>
    <td align="center" valign="middle" class="titulocolumnas"><?php echo $row_cce['date_espe']; ?>Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Solucionar Reparo 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo Cuenta</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo NI</td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista NI</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_cce['id']; ?></span>      </div></td>
    <td align="center" valign="middle"><?php if ($row_cce['estado'] <> 'Cursada.' and $row_cce['estado'] <> 'Eliminada.' and $row_cce['estado'] <> 'Pendiente.' and $row_cce['estado'] <> 'Preingresada.' and $row_cce['estado'] <> 'Reparada.' and $row_cce['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cce['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cce['estado'] <> 'Solucionado.' and $row_cce['estado'] <> 'Eliminada.' and $row_cce['estado'] <> 'Pendiente.' and $row_cce['estado'] <> 'Preingresada.' and $row_cce['estado'] <> 'Reparada.' and $row_cce['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cce['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cce['estado'] <> 'Cursada.' and $row_cce['estado'] <> 'Solucionado.' and $row_cce['estado'] <> 'Pendiente.' and $row_cce['estado'] <> 'Preingresada.' and $row_cce['estado'] <> 'Reparada.' and $row_cce['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cce['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cce['estado'] <> 'Cursada.' and $row_cce['estado'] <> 'Eliminada.' and $row_cce['estado'] <> 'Solucionado.' and $row_cce['estado'] <> 'Preingresada.' and $row_cce['estado'] <> 'Reparada.' and $row_cce['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cce['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cce['estado'] <> 'Cursada.' and $row_cce['estado'] <> 'Eliminada.' and $row_cce['estado'] <> 'Pendiente.' and $row_cce['estado'] <> 'Solucionado.' and $row_cce['estado'] <> 'Reparada.' and $row_cce['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="envioacursecce.php?recordID=<?php echo $row_cce['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cce['estado'] <> 'Cursada.' and $row_cce['estado'] <> 'Eliminada.' and $row_cce['estado'] <> 'Pendiente.' and $row_cce['estado'] <> 'Solucionado.' and $row_cce['estado'] <> 'Reparada.' and $row_cce['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cce['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cce['estado'] <> 'Cursada.' and $row_cce['estado'] <> 'Eliminada.' and $row_cce['estado'] <> 'Pendiente.' and $row_cce['estado'] <> 'Preingresada.' and $row_cce['estado'] <> 'Solucionado.' and $row_cce['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cce['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php echo $row_cce['date_espe']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cce['rut_cliente']); ?></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_cce['nombre_cliente']); ?> </td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_cce['nro_operacion']); ?></span></td>
    <td align="center" valign="middle"><?php echo $row_cce['evento']; ?></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_cce['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_cce['monto_operacion'], 2, ',', '.'); ?></strong></td>
    <td align="center" valign="middle"><?php echo $row_cce['sub_estado']; ?></td>
    <td align="center" valign="middle"><?php echo $row_cce['asignador']; ?></td>
    <td align="center" valign="middle"><?php if ($row_cce['estado'] <> $row_colores['cursada'] and $row_cce['estado'] <> $row_colores['pendiente'] and $row_cce['estado'] <> $row_colores['solucionado'] and $row_cce['estado'] <> $row_colores['preingresada'] and $row_cce['estado'] <> $row_colores['eliminada'] and $row_cce['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cce['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cce['estado'] <> $row_colores['cursada'] and $row_cce['estado'] <> $row_colores['pendiente'] and $row_cce['estado'] <> $row_colores['solucionado'] and $row_cce['estado'] <> $row_colores['preingresada'] and $row_cce['estado'] <> $row_colores['eliminada'] and $row_cce['estado'] <> $row_colores['reparada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cce['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cce['estado'] <> $row_colores['reparada'] and $row_cce['estado'] <> $row_colores['pendiente'] and $row_cce['estado'] <> $row_colores['solucionado'] and $row_cce['estado'] <> $row_colores['preingresada'] and $row_cce['estado'] <> $row_colores['eliminada'] and $row_cce['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cce['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cce['estado'] <> $row_colores['reparada'] and $row_cce['estado'] <> $row_colores['cursada'] and $row_cce['estado'] <> $row_colores['solucionado'] and $row_cce['estado'] <> $row_colores['preingresada'] and $row_cce['estado'] <> $row_colores['eliminada'] and $row_cce['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_cce['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cce['estado'] <> $row_colores['reparada'] and $row_cce['estado'] <> $row_colores['pendiente'] and $row_cce['estado'] <> $row_colores['preingresada'] and $row_cce['estado'] <> $row_colores['cursada'] and $row_cce['estado'] <> $row_colores['eliminada'] and $row_cce['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_cce['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cce['estado'] <> $row_colores['reparada'] and $row_cce['estado'] <> $row_colores['pendiente'] and $row_cce['estado'] <> $row_colores['solucionado'] and $row_cce['estado'] <> $row_colores['cursada'] and $row_cce['estado'] <> $row_colores['eliminada'] and $row_cce['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_cce['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_cce['estado'] <> $row_colores['reparada'] and $row_cce['estado'] <> $row_colores['pendiente'] and $row_cce['estado'] <> $row_colores['solucionado'] and $row_cce['estado'] <> $row_colores['cursada'] and $row_cce['estado'] <> $row_colores['preingresada'] and $row_cce['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_cce['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_cce['reparo_obs']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_cce['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_cce['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_cce['urgente']; ?> </span></span>        
		<?php } // Show if not first page ?>
		<?php if ($row_cce['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_cce['urgente']; ?> </span></span>
      <?php } // Show if not first page ?> 
    </div></td>
    <td align="center" valign="middle"><?php if ($row_cce['estado'] <> 'Cursada.' and $row_cce['estado'] <> 'Eliminada.' and $row_cce['estado'] <> 'Pendiente.' and $row_cce['estado'] <> 'Preingresada.' and $row_cce['estado'] <> 'Reparada.' and $row_cce['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cce['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cce['estado'] <> 'Solucionado.' and $row_cce['estado'] <> 'Eliminada.' and $row_cce['estado'] <> 'Pendiente.' and $row_cce['estado'] <> 'Preingresada.' and $row_cce['estado'] <> 'Reparada.' and $row_cce['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cce['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cce['estado'] <> 'Cursada.' and $row_cce['estado'] <> 'Solucionado.' and $row_cce['estado'] <> 'Pendiente.' and $row_cce['estado'] <> 'Preingresada.' and $row_cce['estado'] <> 'Reparada.' and $row_cce['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cce['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cce['estado'] <> 'Cursada.' and $row_cce['estado'] <> 'Eliminada.' and $row_cce['estado'] <> 'Solucionado.' and $row_cce['estado'] <> 'Preingresada.' and $row_cce['estado'] <> 'Reparada.' and $row_cce['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cce['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cce['estado'] <> 'Cursada.' and $row_cce['estado'] <> 'Eliminada.' and $row_cce['estado'] <> 'Pendiente.' and $row_cce['estado'] <> 'Solucionado.' and $row_cce['estado'] <> 'Reparada.' and $row_cce['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cce['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cce['estado'] <> 'Cursada.' and $row_cce['estado'] <> 'Eliminada.' and $row_cce['estado'] <> 'Pendiente.' and $row_cce['estado'] <> 'Solucionado.' and $row_cce['estado'] <> 'Reparada.' and $row_cce['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cce['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cce['estado'] <> 'Cursada.' and $row_cce['estado'] <> 'Eliminada.' and $row_cce['estado'] <> 'Pendiente.' and $row_cce['estado'] <> 'Preingresada.' and $row_cce['estado'] <> 'Solucionado.' and $row_cce['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="reparodetcce.php?recordID=<?php echo $row_cce['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php echo $row_cce['ejecutivo_ni']; ?></td>
    <td align="center" valign="middle"><?php echo $row_cce['ejecutivo_ni']; ?></td>
    <td align="center" valign="middle"><?php echo $row_cce['especialista_ni']; ?></td>
  </tr>
  <?php } while ($row_cce = mysqli_fetch_assoc($cce)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_pre > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="18" align="left" valign="middle"><span class="Estilo13 Estilo10"><strong><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></strong></span><span class="Estilo13 Estilo5"><strong>Total Operaciones Enviadas a Curse </strong></span><span class="Estilo13 Estilo15"><strong><span class="tituloverde"><?php echo $totalRows_pre ?> </span></strong></span><span class="Estilo13 Estilo5"><strong>Pr&eacute;stamos</strong></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio 
      </div>    </td>
    <td align="center" valign="middle" class="titulocolumnas">Enviar a Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador 
      </div>    </td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas"><p>Solucionar Reparo
    </p></td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo Cuenta</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo NI</td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista NI</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_pre['id']; ?></td>
    <td align="center" valign="middle"><?php if ($row_pre['estado'] <> 'Cursada.' and $row_pre['estado'] <> 'Eliminada.' and $row_pre['estado'] <> 'Pendiente.' and $row_pre['estado'] <> 'Preingresada.' and $row_pre['estado'] <> 'Reparada.' and $row_pre['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_pre['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_pre['estado'] <> 'Solucionado.' and $row_pre['estado'] <> 'Eliminada.' and $row_pre['estado'] <> 'Pendiente.' and $row_pre['estado'] <> 'Preingresada.' and $row_pre['estado'] <> 'Reparada.' and $row_pre['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_pre['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_pre['estado'] <> 'Cursada.' and $row_pre['estado'] <> 'Solucionado.' and $row_pre['estado'] <> 'Pendiente.' and $row_pre['estado'] <> 'Preingresada.' and $row_pre['estado'] <> 'Reparada.' and $row_pre['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_pre['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_pre['estado'] <> 'Cursada.' and $row_pre['estado'] <> 'Eliminada.' and $row_pre['estado'] <> 'Solucionado.' and $row_pre['estado'] <> 'Preingresada.' and $row_pre['estado'] <> 'Reparada.' and $row_pre['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_pre['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_pre['estado'] <> 'Cursada.' and $row_pre['estado'] <> 'Eliminada.' and $row_pre['estado'] <> 'Pendiente.' and $row_pre['estado'] <> 'Solucionado.' and $row_pre['estado'] <> 'Reparada.' and $row_pre['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="envioacursepre.php?recordID=<?php echo $row_pre['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_pre['estado'] <> 'Cursada.' and $row_pre['estado'] <> 'Eliminada.' and $row_pre['estado'] <> 'Pendiente.' and $row_pre['estado'] <> 'Solucionado.' and $row_pre['estado'] <> 'Reparada.' and $row_pre['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_pre['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_pre['estado'] <> 'Cursada.' and $row_pre['estado'] <> 'Eliminada.' and $row_pre['estado'] <> 'Pendiente.' and $row_pre['estado'] <> 'Preingresada.' and $row_pre['estado'] <> 'Solucionado.' and $row_pre['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_pre['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php echo $row_pre['date_espe']; ?> </td>
    <td align="center" valign="middle"><?php echo strtoupper($row_pre['rut_cliente']); ?> </td>
    <td align="left" valign="middle"><?php echo $row_pre['nombre_cliente']; ?> </td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_pre['nro_operacion']); ?> </td>
    <td align="center" valign="middle"><?php echo $row_pre['evento']; ?> </td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_pre['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_pre['monto_operacion'], 2, ',', '.'); ?></strong></td>
    <td align="center" valign="middle"><?php echo $row_pre['sub_estado']; ?></td>
    <td align="center" valign="middle"><?php echo $row_pre['asignador']; ?></td>
    <td align="center" valign="middle"><?php if ($row_pre['estado'] <> $row_colores['cursada'] and $row_pre['estado'] <> $row_colores['pendiente'] and $row_pre['estado'] <> $row_colores['solucionado'] and $row_pre['estado'] <> $row_colores['preingresada'] and $row_pre['estado'] <> $row_colores['eliminada'] and $row_pre['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_pre['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_pre['estado'] <> $row_colores['cursada'] and $row_pre['estado'] <> $row_colores['pendiente'] and $row_pre['estado'] <> $row_colores['solucionado'] and $row_pre['estado'] <> $row_colores['preingresada'] and $row_pre['estado'] <> $row_colores['eliminada'] and $row_pre['estado'] <> $row_colores['reparada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_pre['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_pre['estado'] <> $row_colores['reparada'] and $row_pre['estado'] <> $row_colores['pendiente'] and $row_pre['estado'] <> $row_colores['solucionado'] and $row_pre['estado'] <> $row_colores['preingresada'] and $row_pre['estado'] <> $row_colores['eliminada'] and $row_pre['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_pre['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_pre['estado'] <> $row_colores['reparada'] and $row_pre['estado'] <> $row_colores['cursada'] and $row_pre['estado'] <> $row_colores['solucionado'] and $row_pre['estado'] <> $row_colores['preingresada'] and $row_pre['estado'] <> $row_colores['eliminada'] and $row_pre['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_pre['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_pre['estado'] <> $row_colores['reparada'] and $row_pre['estado'] <> $row_colores['pendiente'] and $row_pre['estado'] <> $row_colores['preingresada'] and $row_pre['estado'] <> $row_colores['cursada'] and $row_pre['estado'] <> $row_colores['eliminada'] and $row_pre['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_pre['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_pre['estado'] <> $row_colores['reparada'] and $row_pre['estado'] <> $row_colores['pendiente'] and $row_pre['estado'] <> $row_colores['solucionado'] and $row_pre['estado'] <> $row_colores['cursada'] and $row_pre['estado'] <> $row_colores['eliminada'] and $row_pre['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_pre['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_pre['estado'] <> $row_colores['reparada'] and $row_pre['estado'] <> $row_colores['pendiente'] and $row_pre['estado'] <> $row_colores['solucionado'] and $row_pre['estado'] <> $row_colores['cursada'] and $row_pre['estado'] <> $row_colores['preingresada'] and $row_pre['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_pre['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_pre['reparo_obs']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_pre['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_pre['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_pre['urgente']; ?> </span></span>        
        <?php } // Show if not first page ?>
        <?php if ($row_pre['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_pre['urgente']; ?> </span></span>
      <?php } // Show if not first page ?>  </td>
    <td align="center" valign="middle"><?php if ($row_pre['estado'] <> 'Cursada.' and $row_pre['estado'] <> 'Eliminada.' and $row_pre['estado'] <> 'Pendiente.' and $row_pre['estado'] <> 'Preingresada.' and $row_pre['estado'] <> 'Reparada.' and $row_pre['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_pre['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_pre['estado'] <> 'Solucionado.' and $row_pre['estado'] <> 'Eliminada.' and $row_pre['estado'] <> 'Pendiente.' and $row_pre['estado'] <> 'Preingresada.' and $row_pre['estado'] <> 'Reparada.' and $row_pre['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_pre['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_pre['estado'] <> 'Cursada.' and $row_pre['estado'] <> 'Solucionado.' and $row_pre['estado'] <> 'Pendiente.' and $row_pre['estado'] <> 'Preingresada.' and $row_pre['estado'] <> 'Reparada.' and $row_pre['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_pre['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_pre['estado'] <> 'Cursada.' and $row_pre['estado'] <> 'Eliminada.' and $row_pre['estado'] <> 'Solucionado.' and $row_pre['estado'] <> 'Preingresada.' and $row_pre['estado'] <> 'Reparada.' and $row_pre['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_pre['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_pre['estado'] <> 'Cursada.' and $row_pre['estado'] <> 'Eliminada.' and $row_pre['estado'] <> 'Pendiente.' and $row_pre['estado'] <> 'Solucionado.' and $row_pre['estado'] <> 'Reparada.' and $row_pre['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_pre['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_pre['estado'] <> 'Cursada.' and $row_pre['estado'] <> 'Eliminada.' and $row_pre['estado'] <> 'Pendiente.' and $row_pre['estado'] <> 'Solucionado.' and $row_pre['estado'] <> 'Reparada.' and $row_pre['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_pre['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_pre['estado'] <> 'Cursada.' and $row_pre['estado'] <> 'Eliminada.' and $row_pre['estado'] <> 'Pendiente.' and $row_pre['estado'] <> 'Preingresada.' and $row_pre['estado'] <> 'Solucionado.' and $row_pre['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="reparodetpre.php?recordID=<?php echo $row_pre['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php echo $row_pre['ejecutivo_cuenta']; ?></td>
    <td align="center" valign="middle"><?php echo $row_pre['ejecutivo_ni']; ?></td>
    <td align="center" valign="middle"><?php echo $row_pre['especialista_ni']; ?></td>
  </tr>
  <?php } while ($row_pre = mysqli_fetch_assoc($pre)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_cbe > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="18" align="left" valign="middle"><span class="Estilo13 Estilo10"><strong><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></strong></span><span class="Estilo13 Estilo5"><strong>Total Operaciones Enviadas a Curse </strong></span><span class="Estilo13 Estilo15"><strong><span class="tituloverde"><?php echo $totalRows_cbe ?> </span></strong></span><span class="Estilo13 Estilo5"><strong>Cobranza Extranjera de Exportaci&oacute;n</strong></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio 
      </div>    </td>
    <td align="center" valign="middle" class="titulocolumnas">Enviar a Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador 
      </div>    </td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Solucionar Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo Cuenta</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo NI</td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista NI</td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_cbe['id']; ?></span>      </div></td>
    <td align="center" valign="middle"><?php if ($row_cbe['estado'] <> 'Cursada.' and $row_cbe['estado'] <> 'Eliminada.' and $row_cbe['estado'] <> 'Pendiente.' and $row_cbe['estado'] <> 'Preingresada.' and $row_cbe['estado'] <> 'Reparada.' and $row_cbe['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbe['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbe['estado'] <> 'Solucionado.' and $row_cbe['estado'] <> 'Eliminada.' and $row_cbe['estado'] <> 'Pendiente.' and $row_cbe['estado'] <> 'Preingresada.' and $row_cbe['estado'] <> 'Reparada.' and $row_cbe['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbe['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbe['estado'] <> 'Cursada.' and $row_cbe['estado'] <> 'Solucionado.' and $row_cbe['estado'] <> 'Pendiente.' and $row_cbe['estado'] <> 'Preingresada.' and $row_cbe['estado'] <> 'Reparada.' and $row_cbe['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbe['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbe['estado'] <> 'Cursada.' and $row_cbe['estado'] <> 'Eliminada.' and $row_cbe['estado'] <> 'Solucionado.' and $row_cbe['estado'] <> 'Preingresada.' and $row_cbe['estado'] <> 'Reparada.' and $row_cbe['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbe['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbe['estado'] <> 'Cursada.' and $row_cbe['estado'] <> 'Eliminada.' and $row_cbe['estado'] <> 'Pendiente.' and $row_cbe['estado'] <> 'Solucionado.' and $row_cbe['estado'] <> 'Reparada.' and $row_cbe['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="envioacursecbe.php?recordID=<?php echo $row_cbe['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbe['estado'] <> 'Cursada.' and $row_cbe['estado'] <> 'Eliminada.' and $row_cbe['estado'] <> 'Pendiente.' and $row_cbe['estado'] <> 'Solucionado.' and $row_cbe['estado'] <> 'Reparada.' and $row_cbe['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbe['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbe['estado'] <> 'Cursada.' and $row_cbe['estado'] <> 'Eliminada.' and $row_cbe['estado'] <> 'Pendiente.' and $row_cbe['estado'] <> 'Preingresada.' and $row_cbe['estado'] <> 'Solucionado.' and $row_cbe['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbe['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php echo $row_cbe['date_espe']; ?> </td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cbe['rut_cliente']); ?> </td>
    <td align="left" valign="middle"><?php echo $row_cbe['nombre_cliente']; ?> </td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_cbe['nro_operacion']); ?></td>
    <td align="center" valign="middle"><?php echo $row_cbe['evento']; ?></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_cbe['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_cbe['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle"><?php echo $row_cbe['sub_estado']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_cbe['asignador']; ?> </td>
    <td align="center" valign="middle"><?php if ($row_cbe['estado'] <> $row_colores['cursada'] and $row_cbe['estado'] <> $row_colores['pendiente'] and $row_cbe['estado'] <> $row_colores['solucionado'] and $row_cbe['estado'] <> $row_colores['preingresada'] and $row_cbe['estado'] <> $row_colores['eliminada'] and $row_cbe['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cbe['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cbe['estado'] <> $row_colores['cursada'] and $row_cbe['estado'] <> $row_colores['pendiente'] and $row_cbe['estado'] <> $row_colores['solucionado'] and $row_cbe['estado'] <> $row_colores['preingresada'] and $row_cbe['estado'] <> $row_colores['eliminada'] and $row_cbe['estado'] <> $row_colores['reparada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cbe['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cbe['estado'] <> $row_colores['reparada'] and $row_cbe['estado'] <> $row_colores['pendiente'] and $row_cbe['estado'] <> $row_colores['solucionado'] and $row_cbe['estado'] <> $row_colores['preingresada'] and $row_cbe['estado'] <> $row_colores['eliminada'] and $row_cbe['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cbe['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cbe['estado'] <> $row_colores['reparada'] and $row_cbe['estado'] <> $row_colores['cursada'] and $row_cbe['estado'] <> $row_colores['solucionado'] and $row_cbe['estado'] <> $row_colores['preingresada'] and $row_cbe['estado'] <> $row_colores['eliminada'] and $row_cbe['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_cbe['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cbe['estado'] <> $row_colores['reparada'] and $row_cbe['estado'] <> $row_colores['pendiente'] and $row_cbe['estado'] <> $row_colores['preingresada'] and $row_cbe['estado'] <> $row_colores['cursada'] and $row_cbe['estado'] <> $row_colores['eliminada'] and $row_cbe['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_cbe['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cbe['estado'] <> $row_colores['reparada'] and $row_cbe['estado'] <> $row_colores['pendiente'] and $row_cbe['estado'] <> $row_colores['solucionado'] and $row_cbe['estado'] <> $row_colores['cursada'] and $row_cbe['estado'] <> $row_colores['eliminada'] and $row_cbe['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_cbe['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_cbe['estado'] <> $row_colores['reparada'] and $row_cbe['estado'] <> $row_colores['pendiente'] and $row_cbe['estado'] <> $row_colores['solucionado'] and $row_cbe['estado'] <> $row_colores['cursada'] and $row_cbe['estado'] <> $row_colores['preingresada'] and $row_cbe['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_cbe['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div> </td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_cbe['reparo_obs']; ?></td>
    <td align="center" valign="middle"><?php echo $row_cbe['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_cbe['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_cbe['urgente']; ?> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbe['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_cbe['urgente']; ?> </span>
      <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php if ($row_cbe['estado'] <> 'Cursada.' and $row_cbe['estado'] <> 'Eliminada.' and $row_cbe['estado'] <> 'Pendiente.' and $row_cbe['estado'] <> 'Preingresada.' and $row_cbe['estado'] <> 'Reparada.' and $row_cbe['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbe['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbe['estado'] <> 'Solucionado.' and $row_cbe['estado'] <> 'Eliminada.' and $row_cbe['estado'] <> 'Pendiente.' and $row_cbe['estado'] <> 'Preingresada.' and $row_cbe['estado'] <> 'Reparada.' and $row_cbe['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbe['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbe['estado'] <> 'Cursada.' and $row_cbe['estado'] <> 'Solucionado.' and $row_cbe['estado'] <> 'Pendiente.' and $row_cbe['estado'] <> 'Preingresada.' and $row_cbe['estado'] <> 'Reparada.' and $row_cbe['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbe['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbe['estado'] <> 'Cursada.' and $row_cbe['estado'] <> 'Eliminada.' and $row_cbe['estado'] <> 'Solucionado.' and $row_cbe['estado'] <> 'Preingresada.' and $row_cbe['estado'] <> 'Reparada.' and $row_cbe['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbe['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbe['estado'] <> 'Cursada.' and $row_cbe['estado'] <> 'Eliminada.' and $row_cbe['estado'] <> 'Pendiente.' and $row_cbe['estado'] <> 'Solucionado.' and $row_cbe['estado'] <> 'Reparada.' and $row_cbe['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbe['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbe['estado'] <> 'Cursada.' and $row_cbe['estado'] <> 'Eliminada.' and $row_cbe['estado'] <> 'Pendiente.' and $row_cbe['estado'] <> 'Solucionado.' and $row_cbe['estado'] <> 'Reparada.' and $row_cbe['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cbe['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cbe['estado'] <> 'Cursada.' and $row_cbe['estado'] <> 'Eliminada.' and $row_cbe['estado'] <> 'Pendiente.' and $row_cbe['estado'] <> 'Preingresada.' and $row_cbe['estado'] <> 'Solucionado.' and $row_cbe['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="reparodetcbe.php?recordID=<?php echo $row_cbe['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="left" valign="middle"><?php echo $row_cbe['date_supe']; ?></td>
    <td align="left" valign="middle"><?php echo $row_cbe['date_supe']; ?></td>
    <td align="left" valign="middle"><?php echo $row_cbe['date_supe']; ?></td>
  </tr>
  <?php } while ($row_cbe = mysqli_fetch_assoc($cbe)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_cdpa > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td colspan="18" align="left" valign="middle"><span class="Estilo13 Estilo10"><strong><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></strong></span><span class="Estilo13 Estilo5"><strong>Total Operaciones Enviadas a Curse </strong></span><span class="Estilo13 Estilo15"><strong><span class="tituloverde"><?php echo $totalRows_cdpa ?> </span></strong></span><span class="Estilo13 Estilo5"><strong>Cesi&oacute;n de Derecho o Pago Anticipado</strong></span></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center" valign="middle"><span class="titulocolumnas">Nro Folio</span></div>    </td>
    <td align="center" valign="middle" class="titulocolumnas">Enviar a Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda /<br> 
      Monto Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador
      </div>    </td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Solucionar Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo Cuenta</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo NI</td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista NI</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_cdpa['id']; ?></span></td>
    <td align="center" valign="middle"><?php if ($row_cdpa['estado'] <> 'Cursada.' and $row_cdpa['estado'] <> 'Eliminada.' and $row_cdpa['estado'] <> 'Pendiente.' and $row_cdpa['estado'] <> 'Preingresada.' and $row_cdpa['estado'] <> 'Reparada.' and $row_cdpa['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cdpa['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cdpa['estado'] <> 'Solucionado.' and $row_cdpa['estado'] <> 'Eliminada.' and $row_cdpa['estado'] <> 'Pendiente.' and $row_cdpa['estado'] <> 'Preingresada.' and $row_cdpa['estado'] <> 'Reparada.' and $row_cdpa['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cdpa['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cdpa['estado'] <> 'Cursada.' and $row_cdpa['estado'] <> 'Solucionado.' and $row_cdpa['estado'] <> 'Pendiente.' and $row_cdpa['estado'] <> 'Preingresada.' and $row_cdpa['estado'] <> 'Reparada.' and $row_cdpa['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cdpa['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cdpa['estado'] <> 'Cursada.' and $row_cdpa['estado'] <> 'Eliminada.' and $row_cdpa['estado'] <> 'Solucionado.' and $row_cdpa['estado'] <> 'Preingresada.' and $row_cdpa['estado'] <> 'Reparada.' and $row_cdpa['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cdpa['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cdpa['estado'] <> 'Cursada.' and $row_cdpa['estado'] <> 'Eliminada.' and $row_cdpa['estado'] <> 'Pendiente.' and $row_cdpa['estado'] <> 'Solucionado.' and $row_cdpa['estado'] <> 'Reparada.' and $row_cdpa['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="envioacursecdpa.php?recordID=<?php echo $row_cdpa['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cdpa['estado'] <> 'Cursada.' and $row_cdpa['estado'] <> 'Eliminada.' and $row_cdpa['estado'] <> 'Pendiente.' and $row_cdpa['estado'] <> 'Solucionado.' and $row_cdpa['estado'] <> 'Reparada.' and $row_cdpa['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cdpa['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cdpa['estado'] <> 'Cursada.' and $row_cdpa['estado'] <> 'Eliminada.' and $row_cdpa['estado'] <> 'Pendiente.' and $row_cdpa['estado'] <> 'Preingresada.' and $row_cdpa['estado'] <> 'Solucionado.' and $row_cdpa['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cdpa['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php echo $row_cdpa['date_espe']; ?> </td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cdpa['rut_cliente']); ?> </td>
    <td align="left" valign="middle"><?php echo $row_cdpa['nombre_cliente']; ?> </td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_cdpa['nro_operacion']); ?> </td>
    <td align="center" valign="middle"><?php echo $row_cdpa['evento']; ?> </td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_cdpa['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_cdpa['monto_operacion'], 2, ',', '.'); ?></strong></td>
    <td align="center" valign="middle"><?php echo $row_cdpa['sub_estado']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_cdpa['asignador']; ?> </td>
    <td align="center" valign="middle"><?php if ($row_cdpa['estado'] <> $row_colores['cursada'] and $row_cdpa['estado'] <> $row_colores['pendiente'] and $row_cdpa['estado'] <> $row_colores['solucionado'] and $row_cdpa['estado'] <> $row_colores['preingresada'] and $row_cdpa['estado'] <> $row_colores['eliminada'] and $row_cdpa['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cdpa['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cdpa['estado'] <> $row_colores['cursada'] and $row_cdpa['estado'] <> $row_colores['pendiente'] and $row_cdpa['estado'] <> $row_colores['solucionado'] and $row_cdpa['estado'] <> $row_colores['preingresada'] and $row_cdpa['estado'] <> $row_colores['eliminada'] and $row_cdpa['estado'] <> $row_colores['reparada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cdpa['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cdpa['estado'] <> $row_colores['reparada'] and $row_cdpa['estado'] <> $row_colores['pendiente'] and $row_cdpa['estado'] <> $row_colores['solucionado'] and $row_cdpa['estado'] <> $row_colores['preingresada'] and $row_cdpa['estado'] <> $row_colores['eliminada'] and $row_cdpa['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cdpa['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cdpa['estado'] <> $row_colores['reparada'] and $row_cdpa['estado'] <> $row_colores['cursada'] and $row_cdpa['estado'] <> $row_colores['solucionado'] and $row_cdpa['estado'] <> $row_colores['preingresada'] and $row_cdpa['estado'] <> $row_colores['eliminada'] and $row_cdpa['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_cdpa['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cdpa['estado'] <> $row_colores['reparada'] and $row_cdpa['estado'] <> $row_colores['pendiente'] and $row_cdpa['estado'] <> $row_colores['preingresada'] and $row_cdpa['estado'] <> $row_colores['cursada'] and $row_cdpa['estado'] <> $row_colores['eliminada'] and $row_cdpa['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_cdpa['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cdpa['estado'] <> $row_colores['reparada'] and $row_cdpa['estado'] <> $row_colores['pendiente'] and $row_cdpa['estado'] <> $row_colores['solucionado'] and $row_cdpa['estado'] <> $row_colores['cursada'] and $row_cdpa['estado'] <> $row_colores['eliminada'] and $row_cdpa['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_cdpa['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_cdpa['estado'] <> $row_colores['reparada'] and $row_cdpa['estado'] <> $row_colores['pendiente'] and $row_cdpa['estado'] <> $row_colores['solucionado'] and $row_cdpa['estado'] <> $row_colores['cursada'] and $row_cdpa['estado'] <> $row_colores['preingresada'] and $row_cdpa['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_cdpa['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_cdpa['reparo_obs']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_cdpa['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_cdpa['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_cdpa['urgente']; ?> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cdpa['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_cdpa['urgente']; ?> </span>
      <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php if ($row_cdpa['estado'] <> 'Cursada.' and $row_cdpa['estado'] <> 'Eliminada.' and $row_cdpa['estado'] <> 'Pendiente.' and $row_cdpa['estado'] <> 'Preingresada.' and $row_cdpa['estado'] <> 'Reparada.' and $row_cdpa['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cdpa['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cdpa['estado'] <> 'Solucionado.' and $row_cdpa['estado'] <> 'Eliminada.' and $row_cdpa['estado'] <> 'Pendiente.' and $row_cdpa['estado'] <> 'Preingresada.' and $row_cdpa['estado'] <> 'Reparada.' and $row_cdpa['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cdpa['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cdpa['estado'] <> 'Cursada.' and $row_cdpa['estado'] <> 'Solucionado.' and $row_cdpa['estado'] <> 'Pendiente.' and $row_cdpa['estado'] <> 'Preingresada.' and $row_cdpa['estado'] <> 'Reparada.' and $row_cdpa['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cdpa['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cdpa['estado'] <> 'Cursada.' and $row_cdpa['estado'] <> 'Eliminada.' and $row_cdpa['estado'] <> 'Solucionado.' and $row_cdpa['estado'] <> 'Preingresada.' and $row_cdpa['estado'] <> 'Reparada.' and $row_cdpa['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cdpa['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cdpa['estado'] <> 'Cursada.' and $row_cdpa['estado'] <> 'Eliminada.' and $row_cdpa['estado'] <> 'Pendiente.' and $row_cdpa['estado'] <> 'Solucionado.' and $row_cdpa['estado'] <> 'Reparada.' and $row_cdpa['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cdpa['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cdpa['estado'] <> 'Cursada.' and $row_cdpa['estado'] <> 'Eliminada.' and $row_cdpa['estado'] <> 'Pendiente.' and $row_cdpa['estado'] <> 'Solucionado.' and $row_cdpa['estado'] <> 'Reparada.' and $row_cdpa['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cdpa['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cdpa['estado'] <> 'Cursada.' and $row_cdpa['estado'] <> 'Eliminada.' and $row_cdpa['estado'] <> 'Pendiente.' and $row_cdpa['estado'] <> 'Preingresada.' and $row_cdpa['estado'] <> 'Solucionado.' and $row_cdpa['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="reparodetcdpa.php?recordID=<?php echo $row_cdpa['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="left" valign="middle"><?php echo $row_cdpa['ejecutivo_cuenta']; ?></td>
    <td align="left" valign="middle"><?php echo $row_cdpa['ejecutivo_ni']; ?></td>
    <td align="left" valign="middle"><?php echo $row_cdpa['especialista_ni']; ?></td>
  </tr>
  <?php } while ($row_cdpa = mysqli_fetch_assoc($cdpa)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_ste > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="18" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" class="Estilo13"><span class="Estilo13 Estilo5"><strong>Total Operaciones Enviadas a Curse <span class="tituloverde"><?php echo $totalRows_ste ?></span> Stand By Emitidas</strong></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio 
      </div>    </td>
    <td align="center" valign="middle" class="titulocolumnas">Enviar a Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador 
      </div>    </td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Solucionar Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo Cuenta</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo NI</td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista NI</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_ste['id']; ?></span></td>
    <td align="center" valign="middle"><?php if ($row_ste['estado'] <> 'Cursada.' and $row_ste['estado'] <> 'Eliminada.' and $row_ste['estado'] <> 'Pendiente.' and $row_ste['estado'] <> 'Preingresada.' and $row_ste['estado'] <> 'Reparada.' and $row_ste['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_ste['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_ste['estado'] <> 'Solucionado.' and $row_ste['estado'] <> 'Eliminada.' and $row_ste['estado'] <> 'Pendiente.' and $row_ste['estado'] <> 'Preingresada.' and $row_ste['estado'] <> 'Reparada.' and $row_ste['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_ste['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_ste['estado'] <> 'Cursada.' and $row_ste['estado'] <> 'Solucionado.' and $row_ste['estado'] <> 'Pendiente.' and $row_ste['estado'] <> 'Preingresada.' and $row_ste['estado'] <> 'Reparada.' and $row_ste['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_ste['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_ste['estado'] <> 'Cursada.' and $row_ste['estado'] <> 'Eliminada.' and $row_ste['estado'] <> 'Solucionado.' and $row_ste['estado'] <> 'Preingresada.' and $row_ste['estado'] <> 'Reparada.' and $row_ste['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_ste['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_ste['estado'] <> 'Cursada.' and $row_ste['estado'] <> 'Eliminada.' and $row_ste['estado'] <> 'Pendiente.' and $row_ste['estado'] <> 'Solucionado.' and $row_ste['estado'] <> 'Reparada.' and $row_ste['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="envioacurseste.php?recordID=<?php echo $row_ste['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_ste['estado'] <> 'Cursada.' and $row_ste['estado'] <> 'Eliminada.' and $row_ste['estado'] <> 'Pendiente.' and $row_ste['estado'] <> 'Solucionado.' and $row_ste['estado'] <> 'Reparada.' and $row_ste['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_ste['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_ste['estado'] <> 'Cursada.' and $row_ste['estado'] <> 'Eliminada.' and $row_ste['estado'] <> 'Pendiente.' and $row_ste['estado'] <> 'Preingresada.' and $row_ste['estado'] <> 'Solucionado.' and $row_ste['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_ste['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php echo $row_ste['date_espe']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_ste['rut_cliente']); ?></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_ste['nombre_cliente']); ?></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_ste['nro_operacion']; ?></span></td>
    <td align="center" valign="middle"><?php echo $row_ste['evento']; ?></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_ste['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_ste['monto_operacion'], 2, ',', '.'); ?></strong></td>
    <td align="center" valign="middle"><?php echo $row_ste['sub_estado']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_ste['asignador']; ?></td>
    <td align="center" valign="middle"><?php if ($row_ste['estado'] <> $row_colores['cursada'] and $row_ste['estado'] <> $row_colores['pendiente'] and $row_ste['estado'] <> $row_colores['solucionado'] and $row_ste['estado'] <> $row_colores['preingresada'] and $row_ste['estado'] <> $row_colores['eliminada'] and $row_ste['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_ste['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_ste['estado'] <> $row_colores['cursada'] and $row_ste['estado'] <> $row_colores['pendiente'] and $row_ste['estado'] <> $row_colores['solucionado'] and $row_ste['estado'] <> $row_colores['preingresada'] and $row_ste['estado'] <> $row_colores['eliminada'] and $row_ste['estado'] <> $row_colores['reparada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_ste['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_ste['estado'] <> $row_colores['reparada'] and $row_ste['estado'] <> $row_colores['pendiente'] and $row_ste['estado'] <> $row_colores['solucionado'] and $row_ste['estado'] <> $row_colores['preingresada'] and $row_ste['estado'] <> $row_colores['eliminada'] and $row_ste['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_ste['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_ste['estado'] <> $row_colores['reparada'] and $row_ste['estado'] <> $row_colores['cursada'] and $row_ste['estado'] <> $row_colores['solucionado'] and $row_ste['estado'] <> $row_colores['preingresada'] and $row_ste['estado'] <> $row_colores['eliminada'] and $row_ste['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_ste['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_ste['estado'] <> $row_colores['reparada'] and $row_ste['estado'] <> $row_colores['pendiente'] and $row_ste['estado'] <> $row_colores['preingresada'] and $row_ste['estado'] <> $row_colores['cursada'] and $row_ste['estado'] <> $row_colores['eliminada'] and $row_ste['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_ste['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_ste['estado'] <> $row_colores['reparada'] and $row_ste['estado'] <> $row_colores['pendiente'] and $row_ste['estado'] <> $row_colores['solucionado'] and $row_ste['estado'] <> $row_colores['cursada'] and $row_ste['estado'] <> $row_colores['eliminada'] and $row_ste['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_ste['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_ste['estado'] <> $row_colores['reparada'] and $row_ste['estado'] <> $row_colores['pendiente'] and $row_ste['estado'] <> $row_colores['solucionado'] and $row_ste['estado'] <> $row_colores['cursada'] and $row_ste['estado'] <> $row_colores['preingresada'] and $row_ste['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_ste['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_ste['reparo_obs']; ?></td>
    <td align="center" valign="middle"><?php echo $row_ste['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_ste['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_ste['urgente']; ?> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_ste['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_ste['urgente']; ?> </span>
      <?php } // Show if not first page ?> </div></td>
    <td align="center" valign="middle"><?php if ($row_ste['estado'] <> 'Cursada.' and $row_ste['estado'] <> 'Eliminada.' and $row_ste['estado'] <> 'Pendiente.' and $row_ste['estado'] <> 'Preingresada.' and $row_ste['estado'] <> 'Reparada.' and $row_ste['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_ste['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_ste['estado'] <> 'Solucionado.' and $row_ste['estado'] <> 'Eliminada.' and $row_ste['estado'] <> 'Pendiente.' and $row_ste['estado'] <> 'Preingresada.' and $row_ste['estado'] <> 'Reparada.' and $row_ste['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_ste['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_ste['estado'] <> 'Cursada.' and $row_ste['estado'] <> 'Solucionado.' and $row_ste['estado'] <> 'Pendiente.' and $row_ste['estado'] <> 'Preingresada.' and $row_ste['estado'] <> 'Reparada.' and $row_ste['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_ste['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_ste['estado'] <> 'Cursada.' and $row_ste['estado'] <> 'Eliminada.' and $row_ste['estado'] <> 'Solucionado.' and $row_ste['estado'] <> 'Preingresada.' and $row_ste['estado'] <> 'Reparada.' and $row_ste['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_ste['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_ste['estado'] <> 'Cursada.' and $row_ste['estado'] <> 'Eliminada.' and $row_ste['estado'] <> 'Pendiente.' and $row_ste['estado'] <> 'Solucionado.' and $row_ste['estado'] <> 'Reparada.' and $row_ste['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_ste['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_ste['estado'] <> 'Cursada.' and $row_ste['estado'] <> 'Eliminada.' and $row_ste['estado'] <> 'Pendiente.' and $row_ste['estado'] <> 'Solucionado.' and $row_ste['estado'] <> 'Reparada.' and $row_ste['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_ste['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_ste['estado'] <> 'Cursada.' and $row_ste['estado'] <> 'Eliminada.' and $row_ste['estado'] <> 'Pendiente.' and $row_ste['estado'] <> 'Preingresada.' and $row_ste['estado'] <> 'Solucionado.' and $row_ste['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="reparodetste.php?recordID=<?php echo $row_ste['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></div></td>
    <td align="center" valign="middle"><?php echo $row_ste['ejecutivo_cuenta']; ?></td>
    <td align="center" valign="middle"><?php echo $row_ste['ejecutivo_ni']; ?></td>
    <td align="center" valign="middle"><?php echo $row_ste['especialista_ni']; ?></td>
  </tr>
  <?php } while ($row_ste = mysqli_fetch_assoc($ste)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_bga > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="18" align="left" valign="middle"><span class="Estilo10"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo18">Total Operaciones Enviadas a Curse <span class="tituloverde"><?php echo $totalRows_bga ?></span> Boletas de Garant&iacute;a</span></span></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio </td>
    <td align="center" valign="middle" class="titulocolumnas">Enviar a Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador</td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente</td>
    <td align="center" valign="middle" class="titulocolumnas">Solucionar Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo Cuenta</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo NI</td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista NI</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_bga['id']; ?></td>
    <td align="center" valign="middle"><?php if ($row_bga['estado'] <> 'Cursada.' and $row_bga['estado'] <> 'Eliminada.' and $row_bga['estado'] <> 'Pendiente.' and $row_bga['estado'] <> 'Preingresada.' and $row_bga['estado'] <> 'Reparada.' and $row_bga['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_bga['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_bga['estado'] <> 'Solucionado.' and $row_bga['estado'] <> 'Eliminada.' and $row_bga['estado'] <> 'Pendiente.' and $row_bga['estado'] <> 'Preingresada.' and $row_bga['estado'] <> 'Reparada.' and $row_bga['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_bga['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_bga['estado'] <> 'Cursada.' and $row_bga['estado'] <> 'Solucionado.' and $row_bga['estado'] <> 'Pendiente.' and $row_bga['estado'] <> 'Preingresada.' and $row_bga['estado'] <> 'Reparada.' and $row_bga['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_bga['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_bga['estado'] <> 'Cursada.' and $row_bga['estado'] <> 'Eliminada.' and $row_bga['estado'] <> 'Solucionado.' and $row_bga['estado'] <> 'Preingresada.' and $row_bga['estado'] <> 'Reparada.' and $row_bga['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_bga['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_bga['estado'] <> 'Cursada.' and $row_bga['estado'] <> 'Eliminada.' and $row_bga['estado'] <> 'Pendiente.' and $row_bga['estado'] <> 'Solucionado.' and $row_bga['estado'] <> 'Reparada.' and $row_bga['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="envioacursebga.php?recordID=<?php echo $row_bga['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_bga['estado'] <> 'Cursada.' and $row_bga['estado'] <> 'Eliminada.' and $row_bga['estado'] <> 'Pendiente.' and $row_bga['estado'] <> 'Solucionado.' and $row_bga['estado'] <> 'Reparada.' and $row_bga['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_bga['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_bga['estado'] <> 'Cursada.' and $row_bga['estado'] <> 'Eliminada.' and $row_bga['estado'] <> 'Pendiente.' and $row_bga['estado'] <> 'Preingresada.' and $row_bga['estado'] <> 'Solucionado.' and $row_bga['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_bga['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php echo $row_bga['date_espe']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_bga['rut_cliente']); ?></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_bga['nombre_cliente']); ?></td>
    <td align="center" valign="middle" class="rojopequeno"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_bga['nro_operacion']); ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_bga['evento']; ?></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_bga['moneda_operacion']); ?></span><br>
        <strong class="respuestacolumna_azul"><?php echo number_format($row_bga['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle"><?php echo $row_bga['sub_estado']; ?></td>
    <td align="center" valign="middle"><?php echo $row_bga['asignador']; ?></td>
    <td align="center" valign="middle"><?php if ($row_bga['estado'] <> $row_colores['cursada'] and $row_bga['estado'] <> $row_colores['pendiente'] and $row_bga['estado'] <> $row_colores['solucionado'] and $row_bga['estado'] <> $row_colores['preingresada'] and $row_bga['estado'] <> $row_colores['eliminada'] and $row_bga['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_bga['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_bga['estado'] <> $row_colores['cursada'] and $row_bga['estado'] <> $row_colores['pendiente'] and $row_bga['estado'] <> $row_colores['solucionado'] and $row_bga['estado'] <> $row_colores['preingresada'] and $row_bga['estado'] <> $row_colores['eliminada'] and $row_bga['estado'] <> $row_colores['reparada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_bga['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_bga['estado'] <> $row_colores['reparada'] and $row_bga['estado'] <> $row_colores['pendiente'] and $row_bga['estado'] <> $row_colores['solucionado'] and $row_bga['estado'] <> $row_colores['preingresada'] and $row_bga['estado'] <> $row_colores['eliminada'] and $row_bga['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_bga['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_bga['estado'] <> $row_colores['reparada'] and $row_bga['estado'] <> $row_colores['cursada'] and $row_bga['estado'] <> $row_colores['solucionado'] and $row_bga['estado'] <> $row_colores['preingresada'] and $row_bga['estado'] <> $row_colores['eliminada'] and $row_bga['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_bga['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_bga['estado'] <> $row_colores['reparada'] and $row_bga['estado'] <> $row_colores['pendiente'] and $row_bga['estado'] <> $row_colores['preingresada'] and $row_bga['estado'] <> $row_colores['cursada'] and $row_bga['estado'] <> $row_colores['eliminada'] and $row_bga['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_bga['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_bga['estado'] <> $row_colores['reparada'] and $row_bga['estado'] <> $row_colores['pendiente'] and $row_bga['estado'] <> $row_colores['solucionado'] and $row_bga['estado'] <> $row_colores['cursada'] and $row_bga['estado'] <> $row_colores['eliminada'] and $row_bga['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_bga['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_bga['estado'] <> $row_colores['reparada'] and $row_bga['estado'] <> $row_colores['pendiente'] and $row_bga['estado'] <> $row_colores['solucionado'] and $row_bga['estado'] <> $row_colores['cursada'] and $row_bga['estado'] <> $row_colores['preingresada'] and $row_bga['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_bga['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_bga['reparo_obs']; ?></td>
    <td align="center" valign="middle"><?php echo $row_bga['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_bga['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_bga['urgente']; ?> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_bga['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_bga['urgente']; ?> </span>
      <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php if ($row_bga['estado'] <> 'Cursada.' and $row_bga['estado'] <> 'Eliminada.' and $row_bga['estado'] <> 'Pendiente.' and $row_bga['estado'] <> 'Preingresada.' and $row_bga['estado'] <> 'Reparada.' and $row_bga['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_bga['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_bga['estado'] <> 'Solucionado.' and $row_bga['estado'] <> 'Eliminada.' and $row_bga['estado'] <> 'Pendiente.' and $row_bga['estado'] <> 'Preingresada.' and $row_bga['estado'] <> 'Reparada.' and $row_bga['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_bga['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_bga['estado'] <> 'Cursada.' and $row_bga['estado'] <> 'Solucionado.' and $row_bga['estado'] <> 'Pendiente.' and $row_bga['estado'] <> 'Preingresada.' and $row_bga['estado'] <> 'Reparada.' and $row_bga['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_bga['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_bga['estado'] <> 'Cursada.' and $row_bga['estado'] <> 'Eliminada.' and $row_bga['estado'] <> 'Solucionado.' and $row_bga['estado'] <> 'Preingresada.' and $row_bga['estado'] <> 'Reparada.' and $row_bga['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_bga['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_bga['estado'] <> 'Cursada.' and $row_bga['estado'] <> 'Eliminada.' and $row_bga['estado'] <> 'Pendiente.' and $row_bga['estado'] <> 'Solucionado.' and $row_bga['estado'] <> 'Reparada.' and $row_bga['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_bga['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_bga['estado'] <> 'Cursada.' and $row_bga['estado'] <> 'Eliminada.' and $row_bga['estado'] <> 'Pendiente.' and $row_bga['estado'] <> 'Solucionado.' and $row_bga['estado'] <> 'Reparada.' and $row_bga['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_bga['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_bga['estado'] <> 'Cursada.' and $row_bga['estado'] <> 'Eliminada.' and $row_bga['estado'] <> 'Pendiente.' and $row_bga['estado'] <> 'Preingresada.' and $row_bga['estado'] <> 'Solucionado.' and $row_bga['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="reparodetbga.php?recordID=<?php echo $row_bga['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="left" valign="middle"><?php echo $row_bga['ejecutivo_cuenta']; ?></td>
    <td align="left" valign="middle"><?php echo $row_bga['ejecutivo_ni']; ?></td>
    <td align="left" valign="middle"><?php echo $row_bga['especialista_ni']; ?></td>
  </tr>
  <?php } while ($row_bga = mysqli_fetch_assoc($bga)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_cex > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td colspan="19" align="left"><span class="Estilo13"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="titulodetalle">Total Operaciones Enviadas a Curse </span><span class="tituloverde"><?php echo $totalRows_cex ?></span><span class="titulodetalle"> Otros Productos de Cambio</span></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Nro Folio </td>
    <td align="center" class="titulocolumnas">Enviar a Curse</td>
    <td align="center" class="titulocolumnas">Fecha Ingreso </td>
    <td align="center" class="titulocolumnas">Tipo Operaci&oacute;n </td>
    <td align="center" class="titulocolumnas">Rut Cliente </td>
    <td align="center" class="titulocolumnas">Nombre Cliente </td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </td>
    <td align="center" class="titulocolumnas">Evento</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </td>
    <td align="center" class="titulocolumnas">Estado Operador </td>
    <td align="center" class="titulocolumnas">Supervisor</td>
    <td align="center" class="titulocolumnas">Estado Supervisor </td>
    <td align="center" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" class="titulocolumnas">Fecha Curse</td>
    <td align="center" class="titulocolumnas">Urgente</td>
    <td align="center" class="titulocolumnas">Solucionar Reparo</td>
    <td align="center" class="titulocolumnas">Ejecutivo Cuenta</td>
    <td align="center" class="titulocolumnas">Ejecutivo NI</td>
    <td align="center" class="titulocolumnas">Especialista NI</td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center" class="respuestacolumna_rojo"><?php echo $row_cex['id']; ?></td>
    <td align="center"><?php if ($row_cex['estado'] <> 'Cursada.' and $row_cex['estado'] <> 'Eliminada.' and $row_cex['estado'] <> 'Pendiente.' and $row_cex['estado'] <> 'Preingresada.' and $row_cex['estado'] <> 'Reparada.' and $row_cex['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cex['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cex['estado'] <> 'Solucionado.' and $row_cex['estado'] <> 'Eliminada.' and $row_cex['estado'] <> 'Pendiente.' and $row_cex['estado'] <> 'Preingresada.' and $row_cex['estado'] <> 'Reparada.' and $row_cex['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cex['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cex['estado'] <> 'Cursada.' and $row_cex['estado'] <> 'Solucionado.' and $row_cex['estado'] <> 'Pendiente.' and $row_cex['estado'] <> 'Preingresada.' and $row_cex['estado'] <> 'Reparada.' and $row_cex['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cex['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cex['estado'] <> 'Cursada.' and $row_cex['estado'] <> 'Eliminada.' and $row_cex['estado'] <> 'Solucionado.' and $row_cex['estado'] <> 'Preingresada.' and $row_cex['estado'] <> 'Reparada.' and $row_cex['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cex['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cex['estado'] <> 'Cursada.' and $row_cex['estado'] <> 'Eliminada.' and $row_cex['estado'] <> 'Pendiente.' and $row_cex['estado'] <> 'Solucionado.' and $row_cex['estado'] <> 'Reparada.' and $row_cex['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="envioacursecex.php?recordID=<?php echo $row_cex['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cex['estado'] <> 'Cursada.' and $row_cex['estado'] <> 'Eliminada.' and $row_cex['estado'] <> 'Pendiente.' and $row_cex['estado'] <> 'Solucionado.' and $row_cex['estado'] <> 'Reparada.' and $row_cex['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cex['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cex['estado'] <> 'Cursada.' and $row_cex['estado'] <> 'Eliminada.' and $row_cex['estado'] <> 'Pendiente.' and $row_cex['estado'] <> 'Preingresada.' and $row_cex['estado'] <> 'Solucionado.' and $row_cex['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cex['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="center"><?php echo $row_cex['date_espe']; ?> </td>
    <td align="center"><?php echo $row_cex['tipo_operacion']; ?> </td>
    <td align="center"><?php echo strtoupper($row_cex['rut_cliente']); ?> </td>
    <td align="left"><?php echo strtoupper($row_cex['nombre_cliente']); ?> </td>
    <td align="center" class="respuestacolumna_rojo"><?php echo strtoupper($row_cex['nro_operacion']); ?> </td>
    <td align="center"><?php echo $row_cex['evento']; ?> </td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_cex['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_cex['monto_operacion'], 2, ',', '.'); ?></strong> </td>
    <td align="center"><?php echo $row_cex['sub_estado']; ?> </td>
    <td align="center"><?php echo $row_cex['asignador']; ?> </td>
    <td align="center"><?php if ($row_cex['estado'] <> $row_colores['cursada'] and $row_cex['estado'] <> $row_colores['pendiente'] and $row_cex['estado'] <> $row_colores['solucionado'] and $row_cex['estado'] <> $row_colores['preingresada'] and $row_cex['estado'] <> $row_colores['eliminada'] and $row_cex['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cex['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cex['estado'] <> $row_colores['cursada'] and $row_cex['estado'] <> $row_colores['pendiente'] and $row_cex['estado'] <> $row_colores['solucionado'] and $row_cex['estado'] <> $row_colores['preingresada'] and $row_cex['estado'] <> $row_colores['eliminada'] and $row_cex['estado'] <> $row_colores['reparada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cex['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cex['estado'] <> $row_colores['reparada'] and $row_cex['estado'] <> $row_colores['pendiente'] and $row_cex['estado'] <> $row_colores['solucionado'] and $row_cex['estado'] <> $row_colores['preingresada'] and $row_cex['estado'] <> $row_colores['eliminada'] and $row_cex['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cex['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cex['estado'] <> $row_colores['reparada'] and $row_cex['estado'] <> $row_colores['cursada'] and $row_cex['estado'] <> $row_colores['solucionado'] and $row_cex['estado'] <> $row_colores['preingresada'] and $row_cex['estado'] <> $row_colores['eliminada'] and $row_cex['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_cex['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cex['estado'] <> $row_colores['reparada'] and $row_cex['estado'] <> $row_colores['pendiente'] and $row_cex['estado'] <> $row_colores['preingresada'] and $row_cex['estado'] <> $row_colores['cursada'] and $row_cex['estado'] <> $row_colores['eliminada'] and $row_cex['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_cex['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cex['estado'] <> $row_colores['reparada'] and $row_cex['estado'] <> $row_colores['pendiente'] and $row_cex['estado'] <> $row_colores['solucionado'] and $row_cex['estado'] <> $row_colores['cursada'] and $row_cex['estado'] <> $row_colores['eliminada'] and $row_cex['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_cex['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_cex['estado'] <> $row_colores['reparada'] and $row_cex['estado'] <> $row_colores['pendiente'] and $row_cex['estado'] <> $row_colores['solucionado'] and $row_cex['estado'] <> $row_colores['cursada'] and $row_cex['estado'] <> $row_colores['preingresada'] and $row_cex['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_cex['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" class="respuestacolumna_rojo"><?php echo $row_cex['reparo_obs']; ?></td>
    <td align="center"><?php echo $row_cex['date_supe']; ?></td>
    <td align="center"><?php if ($row_cex['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_cex['urgente']; ?> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cex['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_cex['urgente']; ?> </span>
      <?php } // Show if not first page ?></td>
    <td align="center"><?php if ($row_cex['estado'] <> 'Cursada.' and $row_cex['estado'] <> 'Eliminada.' and $row_cex['estado'] <> 'Pendiente.' and $row_cex['estado'] <> 'Preingresada.' and $row_cex['estado'] <> 'Reparada.' and $row_cex['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cex['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cex['estado'] <> 'Solucionado.' and $row_cex['estado'] <> 'Eliminada.' and $row_cex['estado'] <> 'Pendiente.' and $row_cex['estado'] <> 'Preingresada.' and $row_cex['estado'] <> 'Reparada.' and $row_cex['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cex['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cex['estado'] <> 'Cursada.' and $row_cex['estado'] <> 'Solucionado.' and $row_cex['estado'] <> 'Pendiente.' and $row_cex['estado'] <> 'Preingresada.' and $row_cex['estado'] <> 'Reparada.' and $row_cex['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cex['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cex['estado'] <> 'Cursada.' and $row_cex['estado'] <> 'Eliminada.' and $row_cex['estado'] <> 'Solucionado.' and $row_cex['estado'] <> 'Preingresada.' and $row_cex['estado'] <> 'Reparada.' and $row_cex['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cex['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cex['estado'] <> 'Cursada.' and $row_cex['estado'] <> 'Eliminada.' and $row_cex['estado'] <> 'Pendiente.' and $row_cex['estado'] <> 'Solucionado.' and $row_cex['estado'] <> 'Reparada.' and $row_cex['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cex['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cex['estado'] <> 'Cursada.' and $row_cex['estado'] <> 'Eliminada.' and $row_cex['estado'] <> 'Pendiente.' and $row_cex['estado'] <> 'Solucionado.' and $row_cex['estado'] <> 'Reparada.' and $row_cex['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_cex['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_cex['estado'] <> 'Cursada.' and $row_cex['estado'] <> 'Eliminada.' and $row_cex['estado'] <> 'Pendiente.' and $row_cex['estado'] <> 'Preingresada.' and $row_cex['estado'] <> 'Solucionado.' and $row_cex['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="reparodetcex.php?recordID=<?php echo $row_cex['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="left"><?php echo $row_cex['ejecutivo_cuenta']; ?></td>
    <td align="left"><?php echo $row_cex['ejecutivo_ni']; ?></td>
    <td align="left"><?php echo $row_cex['especialista_ni']; ?></td>
  </tr>
  <?php } while ($row_cex = mysqli_fetch_assoc($cex)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_tbc > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="left" valign="middle" bgcolor="#999999">
    <td colspan="18" align="left" valign="middle"><span class="Estilo10"><span class="Estilo13"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo18">Total Operaciones Enviadas a Curse </span></span></span><span class="tituloverde"><?php echo $totalRows_tbc ?></span><span class="Estilo10"><span class="Estilo13"><span class="Estilo18"> Cr&eacute;ditos IIIB5</span></span></span></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio </td>
    <td align="center" valign="middle" class="titulocolumnas">Enviar a Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador </td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente</td>
    <td align="center" valign="middle" class="titulocolumnas">Solucionar Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo Cuenta</td>
    <td align="center" valign="middle" class="titulocolumnas">Ejecutivo NI</td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista NI</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_tbc['id']; ?></td>
    <td align="center" valign="middle"><?php if ($row_tbc['estado'] <> 'Cursada.' and $row_tbc['estado'] <> 'Eliminada.' and $row_tbc['estado'] <> 'Pendiente.' and $row_tbc['estado'] <> 'Preingresada.' and $row_tbc['estado'] <> 'Reparada.' and $row_tbc['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_tbc['estado'] <> 'Solucionado.' and $row_tbc['estado'] <> 'Eliminada.' and $row_tbc['estado'] <> 'Pendiente.' and $row_tbc['estado'] <> 'Preingresada.' and $row_tbc['estado'] <> 'Reparada.' and $row_tbc['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_tbc['estado'] <> 'Cursada.' and $row_tbc['estado'] <> 'Solucionado.' and $row_tbc['estado'] <> 'Pendiente.' and $row_tbc['estado'] <> 'Preingresada.' and $row_tbc['estado'] <> 'Reparada.' and $row_tbc['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_tbc['estado'] <> 'Cursada.' and $row_tbc['estado'] <> 'Eliminada.' and $row_tbc['estado'] <> 'Solucionado.' and $row_tbc['estado'] <> 'Preingresada.' and $row_tbc['estado'] <> 'Reparada.' and $row_tbc['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_tbc['estado'] <> 'Cursada.' and $row_tbc['estado'] <> 'Eliminada.' and $row_tbc['estado'] <> 'Pendiente.' and $row_tbc['estado'] <> 'Solucionado.' and $row_tbc['estado'] <> 'Reparada.' and $row_tbc['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="envioacursetbc.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_tbc['estado'] <> 'Cursada.' and $row_tbc['estado'] <> 'Eliminada.' and $row_tbc['estado'] <> 'Pendiente.' and $row_tbc['estado'] <> 'Solucionado.' and $row_tbc['estado'] <> 'Reparada.' and $row_tbc['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_tbc['estado'] <> 'Cursada.' and $row_tbc['estado'] <> 'Eliminada.' and $row_tbc['estado'] <> 'Pendiente.' and $row_tbc['estado'] <> 'Preingresada.' and $row_tbc['estado'] <> 'Solucionado.' and $row_tbc['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php echo $row_tbc['date_espe']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_tbc['rut_cliente']; ?> </td>
    <td align="left" valign="middle"><?php echo $row_tbc['nombre_cliente']; ?> </td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_tbc['nro_operacion']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_tbc['evento']; ?> </td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_tbc['moneda_operacion']; ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_tbc['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle"><?php echo $row_tbc['sub_estado']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_tbc['asignador']; ?> </td>
    <td align="center" valign="middle"><?php if ($row_tbc['estado'] <> $row_colores['cursada'] and $row_tbc['estado'] <> $row_colores['pendiente'] and $row_tbc['estado'] <> $row_colores['solucionado'] and $row_tbc['estado'] <> $row_colores['preingresada'] and $row_tbc['estado'] <> $row_colores['eliminada'] and $row_tbc['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_tbc['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_tbc['estado'] <> $row_colores['cursada'] and $row_tbc['estado'] <> $row_colores['pendiente'] and $row_tbc['estado'] <> $row_colores['solucionado'] and $row_tbc['estado'] <> $row_colores['preingresada'] and $row_tbc['estado'] <> $row_colores['eliminada'] and $row_tbc['estado'] <> $row_colores['reparada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_tbc['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_tbc['estado'] <> $row_colores['reparada'] and $row_tbc['estado'] <> $row_colores['pendiente'] and $row_tbc['estado'] <> $row_colores['solucionado'] and $row_tbc['estado'] <> $row_colores['preingresada'] and $row_tbc['estado'] <> $row_colores['eliminada'] and $row_tbc['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_tbc['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_tbc['estado'] <> $row_colores['reparada'] and $row_tbc['estado'] <> $row_colores['cursada'] and $row_tbc['estado'] <> $row_colores['solucionado'] and $row_tbc['estado'] <> $row_colores['preingresada'] and $row_tbc['estado'] <> $row_colores['eliminada'] and $row_tbc['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_tbc['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_tbc['estado'] <> $row_colores['reparada'] and $row_tbc['estado'] <> $row_colores['pendiente'] and $row_tbc['estado'] <> $row_colores['preingresada'] and $row_tbc['estado'] <> $row_colores['cursada'] and $row_tbc['estado'] <> $row_colores['eliminada'] and $row_tbc['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_tbc['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_tbc['estado'] <> $row_colores['reparada'] and $row_tbc['estado'] <> $row_colores['pendiente'] and $row_tbc['estado'] <> $row_colores['solucionado'] and $row_tbc['estado'] <> $row_colores['cursada'] and $row_tbc['estado'] <> $row_colores['eliminada'] and $row_tbc['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_tbc['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_tbc['estado'] <> $row_colores['reparada'] and $row_tbc['estado'] <> $row_colores['pendiente'] and $row_tbc['estado'] <> $row_colores['solucionado'] and $row_tbc['estado'] <> $row_colores['cursada'] and $row_tbc['estado'] <> $row_colores['preingresada'] and $row_tbc['estado'] <> $row_colores['rechazada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_tbc['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_tbc['reparo_obs']; ?></td>
    <td align="center" valign="middle"><?php echo $row_tbc['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_tbc['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_tbc['urgente']; ?> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_tbc['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_tbc['urgente']; ?> </span>
      <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php if ($row_tbc['estado'] <> 'Cursada.' and $row_tbc['estado'] <> 'Eliminada.' and $row_tbc['estado'] <> 'Pendiente.' and $row_tbc['estado'] <> 'Preingresada.' and $row_tbc['estado'] <> 'Reparada.' and $row_tbc['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_tbc['estado'] <> 'Solucionado.' and $row_tbc['estado'] <> 'Eliminada.' and $row_tbc['estado'] <> 'Pendiente.' and $row_tbc['estado'] <> 'Preingresada.' and $row_tbc['estado'] <> 'Reparada.' and $row_tbc['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_tbc['estado'] <> 'Cursada.' and $row_tbc['estado'] <> 'Solucionado.' and $row_tbc['estado'] <> 'Pendiente.' and $row_tbc['estado'] <> 'Preingresada.' and $row_tbc['estado'] <> 'Reparada.' and $row_tbc['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_tbc['estado'] <> 'Cursada.' and $row_tbc['estado'] <> 'Eliminada.' and $row_tbc['estado'] <> 'Solucionado.' and $row_tbc['estado'] <> 'Preingresada.' and $row_tbc['estado'] <> 'Reparada.' and $row_tbc['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_tbc['estado'] <> 'Cursada.' and $row_tbc['estado'] <> 'Eliminada.' and $row_tbc['estado'] <> 'Pendiente.' and $row_tbc['estado'] <> 'Solucionado.' and $row_tbc['estado'] <> 'Reparada.' and $row_tbc['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_tbc['estado'] <> 'Cursada.' and $row_tbc['estado'] <> 'Eliminada.' and $row_tbc['estado'] <> 'Pendiente.' and $row_tbc['estado'] <> 'Solucionado.' and $row_tbc['estado'] <> 'Reparada.' and $row_tbc['estado'] <> 'Preingresada.') { // Show if not first page ?>
        <a href="sinreparo.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/alto.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        <?php if ($row_tbc['estado'] <> 'Cursada.' and $row_tbc['estado'] <> 'Eliminada.' and $row_tbc['estado'] <> 'Pendiente.' and $row_tbc['estado'] <> 'Preingresada.' and $row_tbc['estado'] <> 'Solucionado.' and $row_tbc['estado'] <> 'Rechazada.') { // Show if not first page ?>
        <a href="reparodettbc.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a> </span>   
        <?php } // Show if not first page ?>
        </td>
    <td align="left" valign="middle"><?php echo $row_tbc['ejecutivo_cuenta']; ?></td>
    <td align="left" valign="middle"><?php echo $row_tbc['ejecutivo_ni']; ?></td>
    <td align="left" valign="middle"><?php echo $row_tbc['especialista_ni']; ?></td>
  </tr>
  <?php } while ($row_tbc = mysqli_fetch_assoc($tbc)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_convenio > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="5" align="left" valign="middle" bgcolor="#999999"><span class="titulo_menu"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Convenios WEB Ingresados</span></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombe</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" class="titulocolumnas">OBS Reparo</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_convenio['fecha_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_convenio['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_convenio['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_convenio['estado']; ?></td>
        <td align="left" valign="middle"><?php echo $row_convenio['obs_reparo']; ?></td>
      </tr>
      <?php } while ($row_convenio = mysqli_fetch_assoc($convenio)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($reparos);
mysqli_free_result($colores);
mysqli_free_result($meco);
mysqli_free_result($cbi);
mysqli_free_result($cce);
mysqli_free_result($pre);
mysqli_free_result($cbe);
mysqli_free_result($cdpa);
mysqli_free_result($ste);
mysqli_free_result($tbc);
mysqli_free_result($bga);
mysqli_free_result($convenio);
?>