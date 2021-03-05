<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "TER,ADM";
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
$colname_opbga = "-1";
if (isset($_GET['nro_folio'])) {
  $colname_opbga = $_GET['nro_folio'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opbga = sprintf("SELECT * FROM opbga WHERE nro_folio = %s", GetSQLValueString($colname_opbga, "int"));
$opbga = mysqli_query($comercioexterior, $query_opbga) or die(mysqli_error());
$row_opbga = mysqli_fetch_assoc($opbga);
$totalRows_opbga = mysqli_num_rows($opbga);
$colname_opcbe = "-1";
if (isset($_GET['nro_folio'])) {
  $colname_opcbe = $_GET['nro_folio'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcbe = sprintf("SELECT * FROM opcbe WHERE nro_folio = %s", GetSQLValueString($colname_opcbe, "int"));
$opcbe = mysqli_query($comercioexterior, $query_opcbe) or die(mysqli_error());
$row_opcbe = mysqli_fetch_assoc($opcbe);
$totalRows_opcbe = mysqli_num_rows($opcbe);
$colname_opcbi = "-1";
if (isset($_GET['nro_folio'])) {
  $colname_opcbi = $_GET['nro_folio'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcbi = sprintf("SELECT * FROM opcbi WHERE nro_folio = %s", GetSQLValueString($colname_opcbi, "int"));
$opcbi = mysqli_query($comercioexterior, $query_opcbi) or die(mysqli_error());
$row_opcbi = mysqli_fetch_assoc($opcbi);
$totalRows_opcbi = mysqli_num_rows($opcbi);
$colname_opcce = "-1";
if (isset($_GET['nro_folio'])) {
  $colname_opcce = $_GET['nro_folio'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcce = sprintf("SELECT * FROM opcce WHERE nro_folio = %s", GetSQLValueString($colname_opcce, "int"));
$opcce = mysqli_query($comercioexterior, $query_opcce) or die(mysqli_error());
$row_opcce = mysqli_fetch_assoc($opcce);
$totalRows_opcce = mysqli_num_rows($opcce);
$colname_opcci = "-1";
if (isset($_GET['nro_folio'])) {
  $colname_opcci = $_GET['nro_folio'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcci = sprintf("SELECT * FROM opcci WHERE nro_folio = %s", GetSQLValueString($colname_opcci, "int"));
$opcci = mysqli_query($comercioexterior, $query_opcci) or die(mysqli_error());
$row_opcci = mysqli_fetch_assoc($opcci);
$totalRows_opcci = mysqli_num_rows($opcci);
$colname_opcdpa = "-1";
if (isset($_GET['nro_folio'])) {
  $colname_opcdpa = $_GET['nro_folio'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcdpa = sprintf("SELECT * FROM opcdpa WHERE nro_folio = %s", GetSQLValueString($colname_opcdpa, "int"));
$opcdpa = mysqli_query($comercioexterior, $query_opcdpa) or die(mysqli_error());
$row_opcdpa = mysqli_fetch_assoc($opcdpa);
$totalRows_opcdpa = mysqli_num_rows($opcdpa);
$colname_opcex = "-1";
if (isset($_GET['nro_folio'])) {
  $colname_opcex = $_GET['nro_folio'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcex = sprintf("SELECT * FROM opcex WHERE nro_folio = %s", GetSQLValueString($colname_opcex, "int"));
$opcex = mysqli_query($comercioexterior, $query_opcex) or die(mysqli_error());
$row_opcex = mysqli_fetch_assoc($opcex);
$totalRows_opcex = mysqli_num_rows($opcex);
$colname_opmec = "-1";
if (isset($_GET['nro_folio'])) {
  $colname_opmec = $_GET['nro_folio'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opmec = sprintf("SELECT * FROM opmec WHERE nro_folio = %s", GetSQLValueString($colname_opmec, "int"));
$opmec = mysqli_query($comercioexterior, $query_opmec) or die(mysqli_error());
$row_opmec = mysqli_fetch_assoc($opmec);
$totalRows_opmec = mysqli_num_rows($opmec);
$colname_oppre = "-1";
if (isset($_GET['nro_folio'])) {
  $colname_oppre = $_GET['nro_folio'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_oppre = sprintf("SELECT * FROM oppre WHERE nro_folio = %s", GetSQLValueString($colname_oppre, "int"));
$oppre = mysqli_query($comercioexterior, $query_oppre) or die(mysqli_error());
$row_oppre = mysqli_fetch_assoc($oppre);
$totalRows_oppre = mysqli_num_rows($oppre);
$colname_opste = "-1";
if (isset($_GET['nro_folio'])) {
  $colname_opste = $_GET['nro_folio'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opste = sprintf("SELECT * FROM opste WHERE nro_folio = %s", GetSQLValueString($colname_opste, "int"));
$opste = mysqli_query($comercioexterior, $query_opste) or die(mysqli_error());
$row_opste = mysqli_fetch_assoc($opste);
$totalRows_opste = mysqli_num_rows($opste);
$colname_opstr = "-1";
if (isset($_GET['nro_folio'])) {
  $colname_opstr = $_GET['nro_folio'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opstr = sprintf("SELECT * FROM opstr WHERE nro_folio = %s", GetSQLValueString($colname_opstr, "int"));
$opstr = mysqli_query($comercioexterior, $query_opstr) or die(mysqli_error());
$row_opstr = mysqli_fetch_assoc($opstr);
$totalRows_opstr = mysqli_num_rows($opstr);
$colname_optbc = "-1";
if (isset($_GET['nro_folio'])) {
  $colname_optbc = $_GET['nro_folio'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_optbc = sprintf("SELECT * FROM optbc WHERE nro_folio = %s", GetSQLValueString($colname_optbc, "int"));
$optbc = mysqli_query($comercioexterior, $query_optbc) or die(mysqli_error());
$row_optbc = mysqli_fetch_assoc($optbc);
$totalRows_optbc = mysqli_num_rows($optbc);
$colname_caratulavsoperaciones = "-1";
if (isset($_GET['nro_folio'])) {
  $colname_caratulavsoperaciones = $_GET['nro_folio'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_caratulavsoperaciones = sprintf("SELECT * FROM opbga WHERE nro_folio = %s", GetSQLValueString($colname_caratulavsoperaciones, "int"));
$caratulavsoperaciones = mysqli_query($comercioexterior, $query_caratulavsoperaciones) or die(mysqli_error($comercioexterior));
$row_opbga = mysqli_fetch_assoc($caratulavsoperaciones);
$totalRows_caratulavsoperaciones = mysqli_num_rows($caratulavsoperaciones);$colname_caratulavsoperaciones = "-1";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Caratula V/S Operaciones</title>
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
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
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
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
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
<script>
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CARATULA V/S OPERACIONES</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">TERRITORIALES</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" />Nro Caratula</td>
    </tr>
    <tr>
      <td width="18%" align="right" valign="middle">Nro Caratula:</td>
      <td width="82%" align="left" valign="middle"><label>
        <input name="nro_folio" type="text" class="etiqueta12" id="nro_folio" size="17" maxlength="15" />
        <span class="respuestacolumna_rojo"><span class="rojopequeno">#</span></span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><label>
        <input name="button" type="submit" class="boton" id="button" value="Enviar" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="acuserecibomae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_opbga > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="14" align="left" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Producto: <?php echo $row_opbga['producto']; ?> // Cantidad de Registros en total <?php echo $totalRows_opbga ?></span></td>
    </tr>
    <tr>
      <td align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Rut Cliente</span></td>
      <td align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Nombre Cliente</span></td>
      <td align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Evento</span></td>
      <td align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Estado</span></td>
      <td align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Fecha Ingreso</span></td>
      <td align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Fecha Curse</span></td>
      <td align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Operador</span></td>
      <td align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Nro Operacion</span></td>
      <td align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Especialista Curse</span></td>
      <td align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Teritorial</span></td>
      <td align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Moneda / Monto Operación</span></td>
      <td align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Reparo OBS</span></td>
      <td align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Fuera Horario</span></td>
      <td align="center" valign="middle" bgcolor="#999999"><span class="titulocolumnas">Nro Folio</span></td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_opbga['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opbga['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opbga['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opbga['estado']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opbga['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opbga['date_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opbga['operador']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opbga['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opbga['especialista_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opbga['territorial']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_opbga['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_opbga['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_opbga['reparo_obs']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opbga['fuera_horario']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opbga['nro_folio']; ?></td>
      </tr>
      <?php } while ($row_opbga = mysqli_fetch_assoc($opbga)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcbe > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="14" align="left" valign="middle" class="titulocolumnas">Producto: <?php echo $row_opcbe['producto']; ?> // Cantidad de Registros en total <?php echo $totalRows_opcbe ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Operador</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
      <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Teritorial</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Reparo OBS</td>
      <td align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_opcbe['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opcbe['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbe['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbe['estado']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbe['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbe['date_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbe['operador']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbe['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbe['especialista_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbe['territorial']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_opcbe['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_opcbe['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_opcbe['reparo_obs']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbe['fuera_horario']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbe['nro_folio']; ?></td>
      </tr>
      <?php } while ($row_opcbe = mysqli_fetch_assoc($opcbe)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcbi > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="14" align="left" valign="middle" class="titulocolumnas">Producto: <?php echo $row_opcbi['producto']; ?> // Cantidad de Registros en total <?php echo $totalRows_opcbi ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Operador</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
      <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Teritorial</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Reparo OBS</td>
      <td align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_opcbi['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opcbi['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbi['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbi['estado']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbi['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbi['date_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbi['operador']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbi['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbi['especialista_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbi['territorial']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_opcbi['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_opcbi['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_opcbi['reparo_obs']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbi['fuera_horario']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcbi['nro_folio']; ?></td>
      </tr>
      <?php } while ($row_opcbi = mysqli_fetch_assoc($opcbi)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcce > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="14" align="left" valign="middle" class="titulocolumnas">Producto: <?php echo $row_opcce['producto']; ?> // Cantidad de Registros en total <?php echo $totalRows_opcce ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Operador</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
      <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Teritorial</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Reparo OBS</td>
      <td align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_opcce['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opcce['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcce['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcce['estado']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcce['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcce['date_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcce['operador']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcce['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcce['especialista_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcce['territorial']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_opcce['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_opcce['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_opcce['reparo_obs']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcce['fuera_horario']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcce['nro_folio']; ?></td>
      </tr>
      <?php } while ($row_opcce = mysqli_fetch_assoc($opcce)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcci > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="14" align="left" valign="middle" class="titulocolumnas">Producto: <?php echo $row_opcci['producto']; ?> // Cantidad de Registros en total <?php echo $totalRows_opcci ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Operador</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
      <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Teritorial</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Reparo OBS</td>
      <td align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_opcci['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opcci['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcci['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcci['estado']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcci['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcci['date_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcci['operador']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcci['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcci['especialista_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcci['territorial']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_opcci['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_opcci['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_opcci['reparo_obs']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcci['fuera_horario']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcci['nro_folio']; ?></td>
      </tr>
      <?php } while ($row_opcci = mysqli_fetch_assoc($opcci)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcex > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="14" align="left" valign="middle" class="titulocolumnas">Producto: <?php echo $row_opcex['producto']; ?> // Cantidad de Registros en total <?php echo $totalRows_opcex ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Operador</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
      <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Teritorial</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Reparo OBS</td>
      <td align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_opcex['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opcex['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcex['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcex['estado']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcex['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcex['date_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcex['operador']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcex['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcex['especialista_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcex['territorial']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_opcex['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_opcex['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_opcex['reparo_obs']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcex['fuera_horario']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opcex['nro_folio']; ?></td>
      </tr>
      <?php } while ($row_opcex = mysqli_fetch_assoc($opcex)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opmec > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="14" align="left" valign="middle" class="titulocolumnas">Producto: <?php echo $row_opmec['producto']; ?> // Cantidad de Registros en total <?php echo $totalRows_opmec ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Operador</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
      <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Teritorial</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Reparo OBS</td>
      <td align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_opmec['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opmec['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opmec['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opmec['estado']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opmec['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opmec['date_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opmec['operador']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opmec['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opmec['especialista_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opmec['territorial']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_opmec['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_opmec['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_opmec['reparo_obs']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opmec['fuera_horario']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opmec['nro_folio']; ?></td>
      </tr>
      <?php } while ($row_opmec = mysqli_fetch_assoc($opmec)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_optbc > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="14" align="left" valign="middle" class="titulocolumnas">Producto: <?php echo $row_optbc['producto']; ?> // Cantidad de Registros en total <?php echo $totalRows_optbc ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Operador</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
      <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Teritorial</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Reparo OBS</td>
      <td align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_optbc['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_optbc['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_optbc['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_optbc['estado']; ?></td>
        <td align="center" valign="middle"><?php echo $row_optbc['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_optbc['date_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_optbc['operador']; ?></td>
        <td align="center" valign="middle"><?php echo $row_optbc['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_optbc['especialista_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_optbc['territorial']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_optbc['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_optbc['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_optbc['reparo_obs']; ?></td>
        <td align="center" valign="middle"><?php echo $row_optbc['fuera_horario']; ?></td>
        <td align="center" valign="middle"><?php echo $row_optbc['nro_folio']; ?></td>
      </tr>
      <?php } while ($row_optbc = mysqli_fetch_assoc($optbc)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_oppre > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="14" align="left" valign="middle" class="titulocolumnas">Producto: <?php echo $row_oppre['producto']; ?> // Cantidad de Registros en total <?php echo $totalRows_oppre ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Operador</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
      <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Teritorial</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Reparo OBS</td>
      <td align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_oppre['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_oppre['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oppre['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oppre['estado']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oppre['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oppre['date_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oppre['operador']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oppre['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oppre['especialista_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oppre['territorial']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_oppre['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_oppre['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_oppre['reparo_obs']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oppre['fuera_horario']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oppre['nro_folio']; ?></td>
      </tr>
      <?php } while ($row_oppre = mysqli_fetch_assoc($oppre)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opste > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="14" align="left" valign="middle" class="titulocolumnas">Producto: <?php echo $row_opste['producto']; ?> // Cantidad de Registros en total <?php echo $totalRows_opste ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Operador</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
      <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Teritorial</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Reparo OBS</td>
      <td align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_opste['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opste['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opste['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opste['estado']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opste['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opste['date_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opste['operador']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opste['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opste['especialista_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opste['territorial']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_opste['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_opste['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_opste['reparo_obs']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opste['fuera_horario']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opste['nro_folio']; ?></td>
      </tr>
      <?php } while ($row_opste = mysqli_fetch_assoc($opste)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opstr > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="14" align="left" valign="middle" class="titulocolumnas">Producto: <?php echo $row_opstr['producto']; ?> // Cantidad de Registros en total <?php echo $totalRows_opstr ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Operador</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
      <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Teritorial</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Reparo OBS</td>
      <td align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_opstr['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opstr['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opstr['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opstr['estado']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opstr['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opstr['date_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opstr['operador']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opstr['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opstr['especialista_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opstr['territorial']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_opstr['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_opstr['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_opstr['reparo_obs']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opstr['fuera_horario']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opstr['nro_folio']; ?></td>
      </tr>
      <?php } while ($row_opstr = mysqli_fetch_assoc($opstr)); ?>
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
mysqli_free_result($opcdpa);
mysqli_free_result($opcex);
mysqli_free_result($opmec);
mysqli_free_result($oppre);
mysqli_free_result($opste);
mysqli_free_result($opstr);
mysqli_free_result($optbc);
mysqli_free_result($caratulavsoperaciones);
?>