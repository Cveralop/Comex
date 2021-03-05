<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=op_pendientes.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0");
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
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_pendientes = 5000;
$pageNum_pendientes = 0;
if (isset($_GET['pageNum_pendientes'])) {
  $pageNum_pendientes = $_GET['pageNum_pendientes'];
}
$startRow_pendientes = $pageNum_pendientes * $maxRows_pendientes;
$colname1_pendientes = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname1_pendientes = $_GET['estado'];
}
$colname_pendientes = ".";
if (isset($_GET['evento'])) {
  $colname_pendientes = $_GET['evento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_pendientes = sprintf("SELECT * FROM opcci WHERE evento LIKE %s and estado = %s ORDER BY id ASC", GetSQLValueString("%" . $colname_pendientes . "%", "text"),GetSQLValueString($colname1_pendientes, "text"));
$query_limit_pendientes = sprintf("%s LIMIT %d, %d", $query_pendientes, $startRow_pendientes, $maxRows_pendientes);
$pendientes = mysqli_query($comercioexterior, $query_limit_pendientes) or die(mysqli_error($comercioexterior));
$row_pendientes = mysqli_fetch_assoc($pendientes);
if (isset($_GET['totalRows_pendientes'])) {
  $totalRows_pendientes = $_GET['totalRows_pendientes'];
} else {
  $all_pendientes = mysqli_query($comercioexterior, $query_pendientes);
  $totalRows_pendientes = mysqli_num_rows($all_pendientes);
}
$totalPages_pendientes = ceil($totalRows_pendientes/$maxRows_pendientes)-1;
$queryString_pendientes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_pendientes") == false && 
        stristr($param, "totalRows_pendientes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_pendientes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_pendientes = sprintf("&totalRows_pendientes=%d%s", $totalRows_pendientes, $queryString_pendientes);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Control Operaciones Pendientes</title>
<style type="text/css">
<!--
@import url(../../../../estilos/estilo12.css);
.Estilo3 {	font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {	font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #0000FF;
}
body {
	background-image: url();
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
.Estilo6 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo8 {
	color: #000;
	font-weight: bold;
}
.Estilo9 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo16 {color: #00FF00}
.letras_negras {
	color: #000;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
</script>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
</head>
<meta http-equiv="refresh" content="60" />
<body>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="9" align="left" bgcolor="#FFFFFF" class="Estilo6"><span class="letras_negras">Total de Operaciones Pendientes</span> <span class="Estilo16"><?php echo $totalRows_pendientes ?></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td bgcolor="#FFFFFF">Fecha Ingreso </div></td>
    <td bgcolor="#FFFFFF">Nro Operaci&oacute;n </div></td>
    <td bgcolor="#FFFFFF">Evento</div></td>
    <td bgcolor="#FFFFFF">Nombre Cliente </div></td>
    <td bgcolor="#FFFFFF"><span class="Estilo8">Operador</span></div></td>
    <td bgcolor="#FFFFFF">Moneda / Monto Operaci&oacute;n</div>
    </td>
    <td bgcolor="#FFFFFF">Moneda / Monto Documentos</div></td>
    <td bgcolor="#FFFFFF" class="Estilo8">Convenio</div></td>
    <td bgcolor="#FFFFFF" class="Estilo8">Forward</div></td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td bgcolor="#FFFFFF"><?php echo $row_pendientes['fecha_ingreso']; ?> </div></td>
    <td bgcolor="#FFFFFF"> <?php echo strtoupper($row_pendientes['nro_operacion']); ?> </div></td>
    <td bgcolor="#FFFFFF"><?php echo $row_pendientes['evento']; ?></div></td>
    <td align="left" bgcolor="#FFFFFF"><?php echo strtoupper($row_pendientes['nombre_cliente']); ?> </td>
    <td bgcolor="#FFFFFF"><?php echo strtoupper($row_pendientes['operador']); ?></div></td>
    <td bgcolor="#FFFFFF"><span class="Estilo9"><?php echo strtoupper($row_pendientes['moneda_operacion']); ?></span> <strong><?php echo number_format($row_pendientes['monto_operacion'], 2, ',', '.'); ?></strong>&nbsp; </div></td>
    <td bgcolor="#FFFFFF"><span class="Estilo9"><?php echo strtoupper($row_pendientes['moneda_documentos']); ?></span> &nbsp;<strong><?php echo number_format($row_pendientes['monto_documentos'], 2, ',', '.'); ?></strong></div></td>
    <td bgcolor="#FFFFFF"><?php echo $row_cursada['convenio']; ?></div></td>
    <td bgcolor="#FFFFFF"><?php echo $row_cursada['forward']; ?></div></td>
  </tr>
  <?php } while ($row_pendientes = mysqli_fetch_assoc($pendientes)); ?>
</table>
<?php
mysqli_free_result($pendientes);
?>