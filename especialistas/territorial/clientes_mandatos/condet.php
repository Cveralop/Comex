<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
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
$query_DetailRS1 = sprintf("SELECT * FROM cliente  WHERE id = $recordID", $colname_consulta);
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
<title>Consulta Cliente - Detalle</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
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
.Estilo5 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {
	font-size: 14px;
	font-weight: bold;
	color: #FF0000;
}

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
//-->
</script>
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='../cierre.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
</head>
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">CONSULTA  CLIENTES COMERCIO EXTERIOR - DETALLE </td>
    <td rowspan="2" align="right" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">NEGOCIO INTERNACIONAL</td>
  </tr>
</table>
<br>
<br>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="4" align="left"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Consulta Clientes </span></td>
  </tr>
  <tr valign="middle">
    <td align="right">Nro Registro:</div></td>
    <td><span class="nroregistro"><?php echo $row_DetailRS1['id']; ?></span>      </div></td>
    <td align="right">Rut Cliente:</div></td>
    <td><?php echo $row_DetailRS1['rut_cliente']; ?> <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
  </tr>
  <tr valign="middle">
    <td align="right">Nombre Cliente:</div></td>
    <td colspan="3" align="left"><?php echo $row_DetailRS1['nombre_cliente']; ?> </td>
  </tr>
  <tr valign="middle">
    <td align="right">Especialista</div>:</td>
    <td align="center"><?php echo $row_DetailRS1['especialista']; ?> </td>
    <td align="right">Ejecutivo:</td>
    <td align="center"><?php echo $row_DetailRS1['ejecutivo']; ?></td>
  </tr>
  <tr valign="middle">
    <td align="right">Oficina:</td>
    <td align="center"><?php echo $row_DetailRS1['oficina']; ?></td>
    <td align="right">Despcho Documentos:</td>
    <td align="center"><?php echo $row_DetailRS1['despacho_doctos']; ?></td>
  </tr>
  <tr valign="middle">
    <td align="right">Segmento:</td>
    <td align="center"><?php echo $row_DetailRS1['segmento']; ?></td>
    <td align="right">Sucursal:</td>
    <td align="center"><?php echo $row_DetailRS1['sucursal']; ?></td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="conmae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>