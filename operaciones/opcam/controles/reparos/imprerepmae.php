<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
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
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_cartareparoopbga = 10;
$pageNum_cartareparoopbga = 0;
if (isset($_GET['pageNum_cartareparoopbga'])) {
  $pageNum_cartareparoopbga = $_GET['pageNum_cartareparoopbga'];
}
$startRow_cartareparoopbga = $pageNum_cartareparoopbga * $maxRows_cartareparoopbga;
$colname1_cartareparoopbga = "1";
if (isset($_GET['rut_cliente'])) {
  $colname1_cartareparoopbga = $_GET['rut_cliente'];
}
$colname_cartareparoopbga = "Reparada.";
if (isset($_GET['sub_estado'])) {
  $colname_cartareparoopbga = $_GET['sub_estado'];
}
$colname2_cartareparoopbga = "xxx";
if (isset($_GET['nro_operacion'])) {
  $colname2_cartareparoopbga = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cartareparoopbga = sprintf("SELECT * FROM opbga WHERE sub_estado = %s and rut_cliente LIKE %s and nro_operacion LIKE %s ORDER BY id DESC", GetSQLValueString($colname_cartareparoopbga, "text"),GetSQLValueString("%" . $colname1_cartareparoopbga . "%", "text"),GetSQLValueString("%" . $colname2_cartareparoopbga . "%", "text"));
$query_limit_cartareparoopbga = sprintf("%s LIMIT %d, %d", $query_cartareparoopbga, $startRow_cartareparoopbga, $maxRows_cartareparoopbga);
$cartareparoopbga = mysqli_query($comercioexterior, $query_limit_cartareparoopbga) or die(mysqli_error());
$row_cartareparoopbga = mysqli_fetch_assoc($cartareparoopbga);
if (isset($_GET['totalRows_cartareparoopbga'])) {
  $totalRows_cartareparoopbga = $_GET['totalRows_cartareparoopbga'];
} else {
  $all_cartareparoopbga = mysqli_query($comercioexterior, $query_cartareparoopbga);
  $totalRows_cartareparoopbga = mysqli_num_rows($all_cartareparoopbga);
}
$totalPages_cartareparoopbga = ceil($totalRows_cartareparoopbga/$maxRows_cartareparoopbga)-1;
$maxRows_cartareparoopste = 10;
$pageNum_cartareparoopste = 0;
if (isset($_GET['pageNum_cartareparoopste'])) {
  $pageNum_cartareparoopste = $_GET['pageNum_cartareparoopste'];
}
$startRow_cartareparoopste = $pageNum_cartareparoopste * $maxRows_cartareparoopste;
$colname_cartareparoopste = "Reparada.";
if (isset($_GET['sub_estado'])) {
  $colname_cartareparoopste = $_GET['sub_estado'];
}
$colname1_cartareparoopste = "1";
if (isset($_GET['rut_cliente'])) {
  $colname1_cartareparoopste = $_GET['rut_cliente'];
}
$colname2_cartareparoopste = "1";
if (isset($_GET['nro_operacion'])) {
  $colname2_cartareparoopste = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cartareparoopste = sprintf("SELECT * FROM opste WHERE sub_estado = %s and rut_cliente LIKE %s and nro_operacion LIKE %s ORDER BY id DESC", GetSQLValueString($colname_cartareparoopste, "text"),GetSQLValueString("%" . $colname1_cartareparoopste . "%", "text"),GetSQLValueString("%" . $colname2_cartareparoopste . "%", "text"));
$query_limit_cartareparoopste = sprintf("%s LIMIT %d, %d", $query_cartareparoopste, $startRow_cartareparoopste, $maxRows_cartareparoopste);
$cartareparoopste = mysqli_query($comercioexterior,$query_limit_cartareparoopste) or die(mysqli_error());
$row_cartareparoopste = mysqli_fetch_assoc($cartareparoopste);
if (isset($_GET['totalRows_cartareparoopste'])) {
  $totalRows_cartareparoopste = $_GET['totalRows_cartareparoopste'];
} else {
  $all_cartareparoopste = mysqli_query($comercioexterior, $query_cartareparoopste);
  $totalRows_cartareparoopste = mysqli_num_rows($all_cartareparoopste);
}
$totalPages_cartareparoopste = ceil($totalRows_cartareparoopste/$maxRows_cartareparoopste)-1;
$maxRows_cartareparoopstr = 10;
$pageNum_cartareparoopstr = 0;
if (isset($_GET['pageNum_cartareparoopstr'])) {
  $pageNum_cartareparoopstr = $_GET['pageNum_cartareparoopstr'];
}
$startRow_cartareparoopstr = $pageNum_cartareparoopstr * $maxRows_cartareparoopstr;
$colname_cartareparoopstr = "Reparada.";
if (isset($_GET['sub_estado'])) {
  $colname_cartareparoopstr = $_GET['sub_estado'];
}
$colname1_cartareparoopstr = "1";
if (isset($_GET['rut_cliente'])) {
  $colname1_cartareparoopstr = $_GET['rut_cliente'];
}
$colname2_cartareparoopstr = "1";
if (isset($_GET['nro_operacion'])) {
  $colname2_cartareparoopstr = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cartareparoopstr = sprintf("SELECT * FROM opstr WHERE sub_estado = %s and rut_cliente LIKE %s and nro_operacion LIKE %s ORDER BY id DESC", GetSQLValueString($colname_cartareparoopstr, "text"),GetSQLValueString("%" . $colname1_cartareparoopstr . "%", "text"),GetSQLValueString("%" . $colname2_cartareparoopstr . "%", "text"));
$query_limit_cartareparoopstr = sprintf("%s LIMIT %d, %d", $query_cartareparoopstr, $startRow_cartareparoopstr, $maxRows_cartareparoopstr);
$cartareparoopstr = mysqli_query(v, $query_limit_cartareparoopstr) or die(mysqli_error());
$row_cartareparoopstr = mysqli_fetch_assoc($cartareparoopstr);
if (isset($_GET['totalRows_cartareparoopstr'])) {
  $totalRows_cartareparoopstr = $_GET['totalRows_cartareparoopstr'];
} else {
  $all_cartareparoopstr = mysqli_query($comercioexterior, $query_cartareparoopstr);
  $totalRows_cartareparoopstr = mysqli_num_rows($all_cartareparoopstr);
}
$totalPages_cartareparoopstr = ceil($totalRows_cartareparoopstr/$maxRows_cartareparoopstr)-1;
$maxRows_cartareparooptbc = 10;
$pageNum_cartareparooptbc = 0;
if (isset($_GET['pageNum_cartareparooptbc'])) {
  $pageNum_cartareparooptbc = $_GET['pageNum_cartareparooptbc'];
}
$startRow_cartareparooptbc = $pageNum_cartareparooptbc * $maxRows_cartareparooptbc;
$colname_cartareparooptbc = "Reparada.";
if (isset($_GET['sub_estado'])) {
  $colname_cartareparooptbc = $_GET['sub_estado'];
}
$colname1_cartareparooptbc = "1";
if (isset($_GET['rut_cliente'])) {
  $colname1_cartareparooptbc = $_GET['rut_cliente'];
}
$colname2_cartareparooptbc = "1";
if (isset($_GET['nro_operacion'])) {
  $colname2_cartareparooptbc = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cartareparooptbc = sprintf("SELECT * FROM optbc WHERE sub_estado = %s and rut_cliente LIKE %s and nro_operacion LIKE %s ORDER BY id DESC", GetSQLValueString($colname_cartareparooptbc, "text"),GetSQLValueString("%" . $colname1_cartareparooptbc . "%", "text"),GetSQLValueString("%" . $colname2_cartareparooptbc . "%", "text"));
$query_limit_cartareparooptbc = sprintf("%s LIMIT %d, %d", $query_cartareparooptbc, $startRow_cartareparooptbc, $maxRows_cartareparooptbc);
$cartareparooptbc = mysqli_query($comercioexterior, $query_limit_cartareparooptbc) or die(mysqli_error());
$row_cartareparooptbc = mysqli_fetch_assoc($cartareparooptbc);
if (isset($_GET['totalRows_cartareparooptbc'])) {
  $totalRows_cartareparooptbc = $_GET['totalRows_cartareparooptbc'];
} else {
  $all_cartareparooptbc = mysqli_query($comercioexterior, $query_cartareparooptbc);
  $totalRows_cartareparooptbc = mysqli_num_rows($all_cartareparooptbc);
}
$totalPages_cartareparooptbc = ceil($totalRows_cartareparooptbc/$maxRows_cartareparooptbc)-1;
$maxRows_cartareparoopcex = 10;
$pageNum_cartareparoopcex = 0;
if (isset($_GET['pageNum_cartareparoopcex'])) {
  $pageNum_cartareparoopcex = $_GET['pageNum_cartareparoopcex'];
}
$startRow_cartareparoopcex = $pageNum_cartareparoopcex * $maxRows_cartareparoopcex;
$colname_cartareparoopcex = "Reparada.";
if (isset($_GET['sub_estado'])) {
  $colname_cartareparoopcex = $_GET['sub_estado'];
}
$colname1_cartareparoopcex = "1";
if (isset($_GET['rut_cliente'])) {
  $colname1_cartareparoopcex = $_GET['rut_cliente'];
}
$colname2_cartareparoopcex = "1";
if (isset($_GET['nro_operacion'])) {
  $colname2_cartareparoopcex = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cartareparoopcex = sprintf("SELECT * FROM opcex WHERE sub_estado = %s and rut_cliente LIKE %s and nro_operacion LIKE %s ORDER BY id DESC", GetSQLValueString($colname_cartareparoopcex, "text"),GetSQLValueString("%" . $colname1_cartareparoopcex . "%", "text"),GetSQLValueString("%" . $colname2_cartareparoopcex . "%", "text"));
$query_limit_cartareparoopcex = sprintf("%s LIMIT %d, %d", $query_cartareparoopcex, $startRow_cartareparoopcex, $maxRows_cartareparoopcex);
$cartareparoopcex = mysqli_query($comercioexterior, $query_limit_cartareparoopcex) or die(mysqli_error());
$row_cartareparoopcex = mysqli_fetch_assoc($cartareparoopcex);
if (isset($_GET['totalRows_cartareparoopcex'])) {
  $totalRows_cartareparoopcex = $_GET['totalRows_cartareparoopcex'];
} else {
  $all_cartareparoopcex = mysqli_query($comercioexterior, $query_cartareparoopcex);
  $totalRows_cartareparoopcex = mysqli_num_rows($all_cartareparoopcex);
}
$totalPages_cartareparoopcex = ceil($totalRows_cartareparoopcex/$maxRows_cartareparoopcex)-1;
$queryString_cartareparoopbga = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cartareparoopbga") == false && 
        stristr($param, "totalRows_cartareparoopbga") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cartareparoopbga = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cartareparoopbga = sprintf("&totalRows_cartareparoopbga=%d%s", $totalRows_cartareparoopbga, $queryString_cartareparoopbga);
$queryString_cartareparoopste = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cartareparoopste") == false && 
        stristr($param, "totalRows_cartareparoopste") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cartareparoopste = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cartareparoopste = sprintf("&totalRows_cartareparoopste=%d%s", $totalRows_cartareparoopste, $queryString_cartareparoopste);
$queryString_cartareparoopstr = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cartareparoopstr") == false && 
        stristr($param, "totalRows_cartareparoopstr") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cartareparoopstr = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cartareparoopstr = sprintf("&totalRows_cartareparoopstr=%d%s", $totalRows_cartareparoopstr, $queryString_cartareparoopstr);
$queryString_cartareparooptbc = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cartareparooptbc") == false && 
        stristr($param, "totalRows_cartareparooptbc") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cartareparooptbc = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cartareparooptbc = sprintf("&totalRows_cartareparooptbc=%d%s", $totalRows_cartareparooptbc, $queryString_cartareparooptbc);
$queryString_cartareparoopcex = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cartareparoopcex") == false && 
        stristr($param, "totalRows_cartareparoopcex") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cartareparoopcex = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cartareparoopcex = sprintf("&totalRows_cartareparoopcex=%d%s", $totalRows_cartareparoopcex, $queryString_cartareparoopcex);
$queryString_cartareparoopbga = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cartareparoopbga") == false && 
        stristr($param, "totalRows_cartareparoopbga") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cartareparoopbga = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cartareparoopbga = sprintf("&totalRows_cartareparoopbga=%d%s", $totalRows_cartareparoopbga, $queryString_cartareparoopbga);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Carta Reparo - Maestro</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
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
.Estilo6 {color: #FFFFFF; font-weight: bold; }
.Estilo8 {
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
#barra {
	font-size: 12px;
	font-weight: bold;
	color: #FFF;
}
#kk {
	color: #FFF;
}
#kk td {
	color: #FFF;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
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
</script>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
</head>
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CARTA  REPARO - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CAMBIO</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><span class="Estilo8"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21">Carta Reparo Impresi&oacute;n</span></td>
    </tr>
    <tr>
      <td width="22%" align="right" valign="middle">Rut Cliente:</div></td>
      <td width="78%" align="left" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15">
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Nro Operaci&oacute;n:</div></td>
      <td align="left" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="17" maxlength="15"></td>
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
    <td align="right" valign="middle"><a href="../../cambio.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_cartareparoopbga > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="8" align="left" valign="middle"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulodetalle" id="barra">Operaciones reparadas Boletas de Garant&iacute;a</span></td>
    </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle"><span class="titulocolumnas">Imprimir</span>      </div></td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><a href="impdetopbga.php?recordID=<?php echo $row_cartareparoopbga['id']; ?>"> <img src="../../../../imagenes/ICONOS/impresora_2.jpg" width="27" height="21" border="0"></a></div></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_cartareparoopbga['nro_operacion']; ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_cartareparoopbga['fecha_ingreso']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_cartareparoopbga['rut_cliente']; ?></div></td>
    <td align="left" valign="middle"><?php echo $row_cartareparoopbga['nombre_cliente']; ?></td>
    <td align="center" valign="middle"><?php echo $row_cartareparoopbga['evento']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_cartareparoopbga['especialista']; ?></div></td>
    <td align="right" valign="middle" bgcolor="#CCCCCC"><span class="respuestacolumna_rojo"><strong><?php echo $row_cartareparoopbga['moneda_operacion']; ?>  </strong></span><strong class="respuestacolumna_azul"><?php echo number_format($row_cartareparoopbga['monto_operacion'], 2, ',', '.'); ?></strong></td>
  </tr>
<?php } while ($row_cartareparoopbga = mysqli_fetch_assoc($cartareparoopbga)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_cartareparoopbga > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_cartareparoopbga=%d%s", $currentPage, 0, $queryString_cartareparoopbga); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_cartareparoopbga > 0) { // Show if not first page ?>
<a href="<?php printf("%s?pageNum_cartareparoopbga=%d%s", $currentPage, max(0, $pageNum_cartareparoopbga - 1), $queryString_cartareparoopbga); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_cartareparoopbga < $totalPages_cartareparoopbga) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_cartareparoopbga=%d%s", $currentPage, min($totalPages_cartareparoopbga, $pageNum_cartareparoopbga + 1), $queryString_cartareparoopbga); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_cartareparoopbga < $totalPages_cartareparoopbga) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_cartareparoopbga=%d%s", $currentPage, $totalPages_cartareparoopbga, $queryString_cartareparoopbga); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_cartareparoopbga + 1) ?></strong> al <strong><?php echo min($startRow_cartareparoopbga + $maxRows_cartareparoopbga, $totalRows_cartareparoopbga) ?></strong> de un total de <strong><?php echo $totalRows_cartareparoopbga ?></strong>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_cartareparoopste > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="8" align="left" valign="middle" bordercolor="#666666" bgcolor="#999999"><span class="tabla">
      <img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"></span><span class="titulo"><span class="titulodetalle">Operaciones reparadas Stand BY Emitidas</span></span></td>
    </tr>
    <tr class="Estilo6" id="kk">
      <td align="center" valign="middle" bgcolor="#999999"><span class="tabla"><span class="Estilo6"><span class="titulodetalle"><span class="titulocolumnas">Imprimir</span></span></span></span></td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operaci&oacute;n</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Especialista </td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><a href="impdetopste.php?recordID=<?php echo $row_cartareparoopste['id']; ?>"><img src="../../../../imagenes/ICONOS/impresora_2.jpg" width="27" height="21" border="0"></a></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC" class="respuestacolumna_rojo"><?php echo $row_cartareparoopste['nro_operacion']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopste['fecha_ingreso']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopste['rut_cliente']; ?></td>
        <td align="left" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopste['nombre_cliente']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopste['evento']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopste['especialista_curse']; ?></td>
        <td align="right" valign="middle" bgcolor="#CCCCCC"><span class="respuestacolumna_rojo"><?php echo $row_cartareparoopste['moneda_operacion']; ?> </span><strong class="respuestacolumna_azul"><?php echo number_format($row_cartareparoopste['monto_operacion'], 2, ',', '.'); ?></strong></span></td>
      </tr>
      <?php } while ($row_cartareparoopste = mysqli_fetch_assoc($cartareparoopste)); ?>
  </table>
  <br>
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_cartareparoopste > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_cartareparoopste=%d%s", $currentPage, 0, $queryString_cartareparoopste); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_cartareparoopste > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_cartareparoopste=%d%s", $currentPage, max(0, $pageNum_cartareparoopste - 1), $queryString_cartareparoopste); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_cartareparoopste < $totalPages_cartareparoopste) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_cartareparoopste=%d%s", $currentPage, min($totalPages_cartareparoopste, $pageNum_cartareparoopste + 1), $queryString_cartareparoopste); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_cartareparoopste < $totalPages_cartareparoopste) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_cartareparoopste=%d%s", $currentPage, $totalPages_cartareparoopste, $queryString_cartareparoopste); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br>
  Registros del<strong><?php echo ($startRow_cartareparoopste + 1) ?></strong> al <strong><?php echo min($startRow_cartareparoopste + $maxRows_cartareparoopste, $totalRows_cartareparoopste) ?></strong> de un total de <strong><?php echo $totalRows_cartareparoopste ?></strong>
  <?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_cartareparoopstr > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="8" align="left" valign="middle" bgcolor="#999999"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="titulo"><span class="titulodetalle">Operaciones reparadas Stand BY Recibidas</span></span></td>
    </tr>
    <tr class="Estilo6">
      <td align="center" valign="middle" bgcolor="#999999" class="Estilo6"><span class="titulodetalle"><span class="titulocolumnas">Imprimir</span></span></td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operaci&oacute;n</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Especialista</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><a href="impdetopstr.php?recordID=<?php echo $row_cartareparoopstr['id']; ?>"><img src="../../../../imagenes/ICONOS/impresora_2.jpg" width="27" height="21" border="0"></a></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC" class="respuestacolumna_rojo"><?php echo $row_cartareparoopstr['nro_operacion']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopstr['fecha_ingreso']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopstr['rut_cliente']; ?></td>
        <td align="left" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopstr['nombre_cliente']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopstr['evento']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopstr['especialista']; ?></td>
        <td align="right" valign="middle" bgcolor="#CCCCCC"><span class="respuestacolumna_rojo"><?php echo $row_cartareparoopstr['moneda_operacion']; ?> </span><strong class="respuestacolumna_azul"><?php echo number_format($row_cartareparoopstr['monto_operacion'], 2, ',', '.'); ?></strong></td>
      </tr>
      <?php } while ($row_cartareparoopstr = mysqli_fetch_assoc($cartareparoopstr)); ?>
  </table>
  <br>
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_cartareparoopstr > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_cartareparoopstr=%d%s", $currentPage, 0, $queryString_cartareparoopstr); ?>">Primero</a>
      <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_cartareparoopstr > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_cartareparoopstr=%d%s", $currentPage, max(0, $pageNum_cartareparoopstr - 1), $queryString_cartareparoopstr); ?>">Anterior</a>
      <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_cartareparoopstr < $totalPages_cartareparoopstr) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_cartareparoopstr=%d%s", $currentPage, min($totalPages_cartareparoopstr, $pageNum_cartareparoopstr + 1), $queryString_cartareparoopstr); ?>">Siguiente</a>
      <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_cartareparoopstr < $totalPages_cartareparoopstr) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_cartareparoopstr=%d%s", $currentPage, $totalPages_cartareparoopstr, $queryString_cartareparoopstr); ?>">&Uacute;ltimo</a>
      <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br>
  Registros del<strong><?php echo ($startRow_cartareparoopstr + 1) ?></strong> al <strong><?php echo min($startRow_cartareparoopstr + $maxRows_cartareparoopstr, $totalRows_cartareparoopstr) ?></strong> de <strong><?php echo $totalRows_cartareparoopstr ?></strong>
  <?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_cartareparooptbc > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" bordercolor="#666666" bgcolor="#CCCCCC" align="center">
    <tr>
      <td colspan="8" align="left" valign="middle" bgcolor="#999999"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="titulo"><span class="titulodetalle">Operaciones reparadas IIIB5</span></span></td>
    </tr>
    <tr>
      <td align="center" valign="middle" bgcolor="#999999" class="Estilo6"><span class="titulocolumnas">Imprimir</span></td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operaci&oacute;n</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Especialista</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><a href="impdetoptbc.php?recordID=<?php echo $row_cartareparooptbc['id']; ?>"><img src="../../../../imagenes/ICONOS/impresora_2.jpg" width="27" height="21" border="0"></a></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC" class="respuestacolumna_rojo"><?php echo $row_cartareparooptbc['nro_operacion']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparooptbc['fecha_ingreso']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparooptbc['rut_cliente']; ?></td>
        <td align="left" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparooptbc['nombre_cliente']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparooptbc['evento']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparooptbc['especialista']; ?></td>
        <td align="right" valign="middle" bgcolor="#CCCCCC"><span class="respuestacolumna_rojo"><?php echo $row_cartareparooptbc['moneda_operacion']; ?> </span><strong class="respuestacolumna_azul"><?php echo number_format($row_cartareparooptbc['monto_operacion'], 2, ',', '.'); ?></strong></td>
      </tr>
      <?php } while ($row_cartareparooptbc = mysqli_fetch_assoc($cartareparooptbc)); ?>
  </table>
  <br>
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_cartareparooptbc > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_cartareparooptbc=%d%s", $currentPage, 0, $queryString_cartareparooptbc); ?>">Primero</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_cartareparooptbc > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_cartareparooptbc=%d%s", $currentPage, max(0, $pageNum_cartareparooptbc - 1), $queryString_cartareparooptbc); ?>">Anterior</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_cartareparooptbc < $totalPages_cartareparooptbc) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_cartareparooptbc=%d%s", $currentPage, min($totalPages_cartareparooptbc, $pageNum_cartareparooptbc + 1), $queryString_cartareparooptbc); ?>">Siguiente</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_cartareparooptbc < $totalPages_cartareparooptbc) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_cartareparooptbc=%d%s", $currentPage, $totalPages_cartareparooptbc, $queryString_cartareparooptbc); ?>">&Uacute;ltimo</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br>
  Registros del<strong><?php echo ($startRow_cartareparooptbc + 1) ?></strong> al <strong><?php echo min($startRow_cartareparooptbc + $maxRows_cartareparooptbc, $totalRows_cartareparooptbc) ?></strong> de un total de <strong><?php echo $totalRows_cartareparooptbc ?></strong>
  <?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_cartareparoopcex > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" bordercolor="#666666" bgcolor="#CCCCCC" align="center">
    <tr>
      <td colspan="8" align="left" valign="middle" bgcolor="#999999"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="titulo"><span class="titulodetalle">Operaciones reparadas Credito Externos y Otros</span></span></td>
    </tr>
    <tr>
      <td align="center" valign="middle" bgcolor="#999999" class="Estilo6"><span class="titulocolumnas">Imprimir</span></td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operaci&oacute;n</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Especialista</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><a href="impdetopcex.php?recordID=<?php echo $row_cartareparoopcex['id']; ?>"><img src="../../../../imagenes/ICONOS/impresora_2.jpg" width="27" height="21" border="0"></a></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC" class="respuestacolumna_rojo"><?php echo $row_cartareparoopcex['nro_operacion']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopcex['fecha_ingreso']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopcex['rut_cliente']; ?></td>
        <td align="left" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopcex['nombre_cliente']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopcex['evento']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_cartareparoopcex['especialista']; ?></td>
        <td align="right" valign="middle" bgcolor="#CCCCCC"><span class="respuestacolumna_rojo"><?php echo $row_cartareparoopcex['moneda_operacion']; ?> </span><strong class="respuestacolumna_azul"><?php echo number_format($row_cartareparoopcex['monto_operacion'], 2, ',', '.'); ?></strong></td>
      </tr>
      <?php } while ($row_cartareparoopcex = mysqli_fetch_assoc($cartareparoopcex)); ?>
  </table>
  <br>
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_cartareparoopcex > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_cartareparoopcex=%d%s", $currentPage, 0, $queryString_cartareparoopcex); ?>">Primero</a>
      <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_cartareparoopcex > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_cartareparoopcex=%d%s", $currentPage, max(0, $pageNum_cartareparoopcex - 1), $queryString_cartareparoopcex); ?>">Anterior</a>
      <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_cartareparoopcex < $totalPages_cartareparoopcex) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_cartareparoopcex=%d%s", $currentPage, min($totalPages_cartareparoopcex, $pageNum_cartareparoopcex + 1), $queryString_cartareparoopcex); ?>">Siguiente</a>
      <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_cartareparoopcex < $totalPages_cartareparoopcex) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_cartareparoopcex=%d%s", $currentPage, $totalPages_cartareparoopcex, $queryString_cartareparoopcex); ?>">�ltimo</a>
      <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br>
  Registros del <strong><?php echo ($startRow_cartareparoopcex + 1) ?></strong> al <strong><?php echo min($startRow_cartareparoopcex + $maxRows_cartareparoopcex, $totalRows_cartareparoopcex) ?></strong> de un total de <strong><?php echo $totalRows_cartareparoopcex ?></strong>
  <?php } // Show if recordset not empty ?>
<br>
</body>
</html>
<?php
mysqli_free_result($cartareparoopbga);
mysqli_free_result($cartareparoopste);
mysqli_free_result($cartareparoopstr);
mysqli_free_result($cartareparooptbc);
mysqli_free_result($cartareparoopcex);
?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          