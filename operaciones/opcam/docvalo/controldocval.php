<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,SUP,OPE";
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
$colname_controldocval = "-1";
if (isset($_GET['estado_boleta'])) {
  $colname_controldocval = $_GET['estado_boleta'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_controldocval = sprintf("SELECT * FROM opbga WHERE estado_boleta = %s", GetSQLValueString($colname_controldocval, "text"));
$controldocval = mysqli_query($comercioexterior, $query_controldocval) or die(mysqli_error());
$row_controldocval = mysqli_fetch_assoc($controldocval);
$colname_controldocval = "Emision Boleta Garantia.";
if (isset($_GET['evento'])) {
  $colname_controldocval = $_GET['evento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_controldocval = sprintf("SELECT * FROM opbga WHERE evento = %s", GetSQLValueString($colname_controldocval, "text"));
$controldocval = mysqli_query($comercioexterior, $query_controldocval) or die(mysqli_error());
$row_controldocval = mysqli_fetch_assoc($controldocval);
$colname1_controldocval = "zzzxxx";
if (isset($_GET['rut_cliente'])) {
  $colname1_controldocval = $_GET['rut_cliente'];
}
$colname2_controldocval = "zzzxxx";
if (isset($_GET['folio_boleta'])) {
  $colname2_controldocval = $_GET['folio_boleta'];
}
$colname_controldocval = "Emision Boleta Garantia.";
if (isset($_GET['evento'])) {
  $colname_controldocval = $_GET['evento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_controldocval = sprintf("SELECT * FROM opbga WHERE evento = %s and rut_cliente LIKE %s and folio_boleta  LIKE %s", GetSQLValueString($colname_controldocval, "text"),GetSQLValueString("%" . $colname1_controldocval . "%", "text"),GetSQLValueString("%" . $colname2_controldocval . "%", "text"));
$controldocval = mysqli_query($comercioexterior, $query_controldocval) or die(mysqli_error());
$row_controldocval = mysqli_fetch_assoc($controldocval);
$totalRows_controldocval = mysqli_num_rows($controldocval);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Control Entrega Documentos Valorados</title>
<style type="text/css">
<!--
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
	color: #00F;
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
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
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
</script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">CONTROL ENTREGA DOCUMENTOS VALORADOS - BOLETAS DE GARANTÍA</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">CAMBIO</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><span class="titulodetalle">Control Documentos Valorados</span></td>
    </tr>
    <tr>
      <td width="20%" align="right" valign="middle">Rut Clierte:</td>
      <td width="80%" align="left" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="20" maxlength="15" />
      <span class="rojopequeno">Sin Puntos ni Guión</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Folio:</td>
      <td align="left" valign="middle"><input name="folio_boleta" type="text" class="etiqueta12" id="folio_boleta" size="25" maxlength="20" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><input name="button" type="submit" class="boton" id="button" value="Buscar" /></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="docvalo.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen4','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen4" width="80" height="25" border="0" id="Imagen4" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_controldocval > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Recepción Documento</td>
      <td align="center" valign="middle" class="titulocolumnas">Recibido Por</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Entrado o Rechazo a Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Entregado a</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro de Boleta</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado Boleta</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_controldocval['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_controldocval['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_controldocval['fecha_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_controldocval['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_controldocval['fecha_curse']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_controldocval['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_controldocval['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_controldocval['date_rec_doc_val']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_controldocval['recibido_por']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_controldocval['date_ent_doc_val']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_controldocval['entregado_por']; ?></td>
        <td align="center" valign="middle"><?php echo $row_controldocval['folio_boleta']; ?></td>
        <td align="center" valign="middle"><?php echo $row_controldocval['estado_boleta']; ?></td>
      </tr>
      <?php } while ($row_controldocval = mysqli_fetch_assoc($controldocval)); ?>
  </table>
  <br />
  <span class="respuestacolumna_azul"><?php echo $totalRows_controldocval ?></span> Registros Total
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($controldocval);
?>