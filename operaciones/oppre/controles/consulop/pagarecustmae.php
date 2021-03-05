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

$colname_letcus = "1";
if (isset($_GET['tipo_operacion'])) {
  $colname_letcus = $_GET['tipo_operacion'];
}
$colname1_letcus = "1";
if (isset($_GET['date_ini'])) {
  $colname1_letcus = $_GET['date_ini'];
}
$colname2_letcus = "1";
if (isset($_GET['date_fin'])) {
  $colname2_letcus = $_GET['date_fin'];
}
$colname3_letcus = "Sucursal.";
if (isset($_GET['pagare'])) {
  $colname3_letcus = $_GET['pagare'];
}
$colname4_letcus = "Cursada.";
if (isset($_GET['estado'])) {
  $colname4_letcus = $_GET['estado'];
}
$colname5_letcus = "Pagare Convenio.";
if (isset($_GET['pagare'])) {
  $colname5_letcus = $_GET['pagare'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_letcus = sprintf("SELECT * FROM oppre nolock WHERE tipo_operacion = %s and date_curse BETWEEN %s and %s and (pagare <> %s or pagare <> %s) and estado = %s", GetSQLValueString($colname_letcus, "text"),GetSQLValueString($colname1_letcus, "date"),GetSQLValueString($colname2_letcus, "date"),GetSQLValueString($colname3_letcus, "text"),GetSQLValueString($colname5_letcus, "text"),GetSQLValueString($colname4_letcus, "text"));
$letcus = mysqli_query($comercioexterior, $query_letcus) or die(mysqli_error());
$row_letcus = mysqli_fetch_assoc($letcus);
$totalRows_letcus = mysqli_num_rows($letcus);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Documentos Valorados</title>
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
-->
</style>
<script> 
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
    <td width="93%" align="left" valign="middle" class="Estilo3">DOCUMENTOS VALORADOS A  CUSTODIA</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="pagarecustdet.php">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><p><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Documentos Valorados a</span><span class="Estilo5"> Custodia</span></p>
      </td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right">Fecha Curse:</div></td>
      <td width="79%" align="left"><span class="rojopequeno">Desde</span>        <input name="date_ini" type="text" class="etiqueta12" id="date_ini" size="12" maxlength="10"> 
        <span class="rojopequeno">Hasta</span>        <input name="date_fin" type="text" class="etiqueta12" id="date_fin" size="12" maxlength="10"> 
      <span class="rojopequeno">(aaaa-mm-dd)</span> </td>
    </tr>
    <tr valign="middle">
      <td align="right">Tipo Operaci&oacute;n: </div></td>
      <td align="left"><select name="tipo_operacion" class="etiqueta12" id="tipo_operacion">
        <option value="Confirming.">Confirming</option>
        <option value="Credito Comercial.">Credito Comercial</option>
        <option value="Finan. Contado.">Finan. Contado</option>
        <option value="Forfaiting.">Forfaiting</option>
        <option value="PAE.">PAE</option>
        <option value="PAE Cobex.">PAE Cobex</option>
        <option value="Finan. Contado COBEX.">Finan. Contado COBEX</option>
        <option value="Credito Comercial COBEX.">Credito Comercial COBEX</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../prestamos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($letcus);
?>