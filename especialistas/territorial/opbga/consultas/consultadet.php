<?php require_once('../../../../Connections/comercioexterior.php'); ?>
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
$MM_restrictGoTo = "../../erroracceso.php";
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
$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
$colname_DetailRS1 = "1";
if (isset($_GET['rut_cliente'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['rut_cliente'] : addslashes($_GET['rut_cliente']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = sprintf("SELECT * FROM opbga  WHERE id = $recordID", $colname_conrut);
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysqli_query($comercioexterior, $query_limit_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1);
  $totalRows_DetailRS1 = mysqli_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Consulta Operaciones CAMBIO - Detalle</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
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
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo9 {
	font-size: 14px;
	color: #FF0000;
	font-weight: bold;
}
.Estilo12 {color: #00FF00; font-weight: bold; }
.Estilo14 {color: #009999; font-weight: bold; }
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
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
</head>
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td align="left" valign="middle" class="Estilo3">CONSULTAS - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CAMBIO - BOLETA DE GARANT&Iacute;A</td>
  </tr>
</table>
<br>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="4" align="left" valign="middle"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5"><span class="titulodetalle">Detalle Operaci&oacute;n</span></span></td>
  </tr>
  <tr valign="middle">
    <td width="22%" align="right" valign="middle">Nro Registro: </td>
    <td width="34%" align="center" valign="middle"><span class="nroregistro"><?php echo $row_DetailRS1['id']; ?> </span></td>
    <td width="19%" align="right" valign="middle">Rut Cliente:</div></td>
    <td width="25%" align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Nombre Cliente: </td>
    <td colspan="3" align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?> </td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Feche Cliente: </td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['fecha_ingreso']; ?> </td>
    <td align="right" valign="middle">Evento:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['evento']; ?></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Estado:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['estado']; ?> </td>
    <td align="right" valign="middle">Fecha Curse: </td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['fecha_curse']; ?></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Asignador:</td>
    <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['asignador']); ?> </td>
    <td align="right" valign="middle">Operador:</td>
    <td align="center" valign="middle">Sin Dato.</td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Nro Operaci&oacute;n:</td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_DetailRS1['nro_operacion']; ?> </td>
    <td align="right" valign="middle">Especialista:</td>
    <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['especialista_curse']); ?></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Observaciones:</td>
    <td colspan="3" align="left" valign="middle"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?> </td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Moneda / Monto Operaci&oacute;n:</td>
    <td colspan="3" align="left" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_DetailRS1['moneda_operacion']); ?></span> <span class="rojopequeno">/</span> <strong class="respuestacolumna_azul"><?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Estado Operador: </td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['sub_estado']; ?> </td>
    <td align="right" valign="middle">Autorizador:</td>
    <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['autorizador']); ?></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Fecha Pre Ingreso: </td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['date_preingreso']; ?></td>
    <td align="right" valign="middle">Fecha Ingreso Especialista: </td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['date_espe']; ?></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Fecha Visaci&oacute;n:</td>
    <td align="center" valign="middle"><span class="etiqueta12"><?php echo $row_DetailRS1['date_visa']; ?> </span></td>
    <td align="right" valign="middle">Fecha  Asignaci&oacute;n: </td>
    <td align="center" valign="middle"><span class="etiqueta12"><?php echo $row_DetailRS1['date_asig']; ?></span></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Fecha  Curse Operador:</td>
    <td align="center" valign="middle"><span class="etiqueta12"><?php echo $row_DetailRS1['date_oper']; ?> </span></td>
    <td align="right" valign="middle">Fecha Curse  Supervisor: </td>
    <td align="center" valign="middle"><span class="etiqueta12"><?php echo $row_DetailRS1['date_supe']; ?></span></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Motivo Reparo: </td>
    <td colspan="3" align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['reparo_obs']); ?> </td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="consulta.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>