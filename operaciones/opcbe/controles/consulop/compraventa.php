<?php require_once('../../../../Connections/comercioexterior.php'); ?>
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
$colname1_compraventa = "1";
if (isset($_GET['compraventa'])) {
  $colname1_compraventa = $_GET['compraventa'];
}
$colname2_compraventa = "0";
if (isset($_GET['tipocambio'])) {
  $colname2_compraventa = $_GET['tipocambio'];
}
$colname_compraventa = "1";
if (isset($_GET['fecha_ingreso'])) {
  $colname_compraventa = $_GET['fecha_ingreso'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_compraventa = sprintf("SELECT *,sum(tipocambio)as maximo FROM opcbe WHERE fecha_ingreso = %s and compraventa = %s and tipocambio <> %s GROUP BY tipocambio", GetSQLValueString($colname_compraventa, "text"),GetSQLValueString($colname1_compraventa, "text"),GetSQLValueString($colname2_compraventa, "int"));
$compraventa = mysql_query($query_compraventa, $comercioexterior) or die(mysqli_error());
$row_compraventa = mysqli_fetch_assoc($compraventa);
$totalRows_compraventa = mysqli_num_rows($compraventa);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Compra Venta</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
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
	font-size: 14px;
	color: #000000;
	font-weight: bold;
}
.Estilo6 {
	font-size: 12;
	color: #000000;
	font-weight: bold;
}
.Estilo7 {
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.Estilo8 {color: #0000FF}
.Estilo9 {font-size: 14px}
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
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">COMPRA VENTA</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">COBRANZA EXTRANJERA DE EXPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo7">Compra Venta de Divisas</span></td>
    </tr>
    <tr>
      <td width="26%" align="right" valign="middle">Fecha Ingreso:</div></td>
      <td width="74%" align="left" valign="middle"><span class="Estilo8">
        <input name="fecha_ingreso" type="text" class="etiqueta12" id="fecha_ingreso" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10"> 
      </span><span class="rojopequeno">(dd-mm-aaaa) </span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Compra Venta:</td>
      <td align="left" valign="middle"><select name="compraventa" class="etiqueta12 Estilo8" id="compraventa">
        <option selected>Seleccione una Opci&oacute;n</option>
        <option value="Compra.">Compra</option>
        <option value="Venta.">Venta</option>
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
<?php if ($totalRows_compraventa > 0) { // Show if recordset not empty ?>
<table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="4" align="right" valign="middle"><span class="Estilo5"><?php
setlocale(LC_TIME,'sp'); 
echo strftime("Santiago, %d de %B de %Y");?>
      </span></td>
  </tr>
  <tr>
    <td colspan="4" align="left" valign="middle">
        Tipo: <?php echo $row_compraventa['compraventa']; ?></div>
    </div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><strong>Nombre Cliente </strong></div></td>
    <td align="center" valign="middle"><strong>Moneda / Monto Operaci&oacute;n </strong></div></td>
    <td align="center" valign="middle"><strong>T/C</strong></div></td>
    <td align="center" valign="middle"><strong>Valor en Pesos </strong></div></td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="left" valign="middle"><?php echo $row_compraventa['nombre_cliente']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_compraventa['moneda_operacion']); ?> <?php echo number_format($row_compraventa['monto_operacion'], 2, ',', '.'); ?></td>
    <td align="center" valign="middle"><?php echo number_format($row_compraventa['tipocambio'], 2, ',', '.'); ?></td>
    <td align="center" valign="middle"><?php echo number_format(($row_compraventa['monto_operacion'] * $row_compraventa['tipocambio']), 0, ',', '.') ; ?> </td>
  </tr>
  <?php } while ($row_compraventa = mysqli_fetch_assoc($compraventa)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../cobexport.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($compraventa);
?>