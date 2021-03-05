<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=opcce_excepciones.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0");
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
$maxRows_excepciones = 5000;
$pageNum_excepciones = 0;
if (isset($_GET['pageNum_excepciones'])) {
  $pageNum_excepciones = $_GET['pageNum_excepciones'];
}
$startRow_excepciones = $pageNum_excepciones * $maxRows_excepciones;
$colname2_excepciones = "Cursada.";
if (isset($_GET['estado'])) {
  $colname2_excepciones = $_GET['estado'];
}
$colname_excepciones = "Pendiente.";
if (isset($_GET['estado_excepcion'])) {
  $colname_excepciones = $_GET['estado_excepcion'];
}
$colname1_excepciones = "Si";
if (isset($_GET['excepcion'])) {
  $colname1_excepciones = $_GET['excepcion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_excepciones = sprintf("SELECT opcce.*,(usuarios.nombre)as ne ,timestampdiff(day,solucion_excepcion,current_timestamp)as dias FROM opcce, usuarios WHERE estado_excepcion = %s and excepcion = %s and estado = %s and (opcce.especialista_curse = usuarios.usuario) ORDER BY solucionado ASC", GetSQLValueString($colname_excepciones, "text"),GetSQLValueString($colname1_excepciones, "text"),GetSQLValueString($colname2_excepciones, "text"));
$query_limit_excepciones = sprintf("%s LIMIT %d, %d", $query_excepciones, $startRow_excepciones, $maxRows_excepciones);
$excepciones = mysqli_query($comercioexterior, $query_limit_excepciones) or die(mysqli_error());
$row_excepciones = mysqli_fetch_assoc($excepciones);
if (isset($_GET['totalRows_excepciones'])) {
  $totalRows_excepciones = $_GET['totalRows_excepciones'];
} else {
  $all_excepciones = mysqli_query($comercioexterior, $query_excepciones);
  $totalRows_excepciones = mysqli_num_rows($all_excepciones);
}
$totalPages_excepciones = ceil($totalRows_excepciones/$maxRows_excepciones)-1;
$queryString_excepciones = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_excepciones") == false && 
        stristr($param, "totalRows_excepciones") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_excepciones = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_excepciones = sprintf("&totalRows_excepciones=%d%s", $totalRows_excepciones, $queryString_excepciones);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Listado Excepciones</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000;
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo10 {font-size: 12px}
.Estilo11 {color: #00FF00}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
</script>
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="95%" border="1" align="center">
  <tr valign="middle">
    <td align="center" valign="middle">Especialista </td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Tipo Compromiso</td>
    <td align="center" valign="middle">Fecha Curse</td>
    <td align="center" valign="middle">Fecha Compromiso</td>
    <td align="center" valign="middle">Plazo</td>
    <td align="center" valign="middle">Depto.</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Nro Operaci&oacute;n</div>    </td>
    <td align="center" valign="middle">Observaci&oacute;n</td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="left" valign="middle"><?php echo strtoupper($row_excepciones['ne']); ?></td>
    <td align="left" valign="middle"><?php echo $row_excepciones['nombre_cliente']; ?></td>
    <td align="center" valign="middle"><?php echo $row_excepciones['rut_cliente']; ?></td>
    <td align="left" valign="middle"><?php echo $row_excepciones['tipo_excepcion']; ?></td>
    <td align="center" valign="middle"><?php echo $row_excepciones['date_curse']; ?></td>
    <td align="center" valign="middle"><?php echo $row_excepciones['solucion_excepcion']; ?></td>
    <td align="center" valign="middle"><?php echo $row_excepciones['dias']; ?></td>
    <td align="center" valign="middle">Cartas de Cr&eacute;dito Exporaci&oacute;n</td>
    <td align="center" valign="middle"><?php echo $row_excepciones['evento']; ?></td>
    <td align="center" valign="middle"><?php echo $row_excepciones['nro_operacion']; ?>      </div></td>
    <td align="left" valign="middle"><?php echo $row_excepciones['obs']; ?></td>
    </tr>
  <?php } while ($row_excepciones = mysqli_fetch_assoc($excepciones)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($excepciones);
?>