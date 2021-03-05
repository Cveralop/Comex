<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,RED";
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
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_pagareparagua = 10;
$pageNum_opcce = 0;
if (isset($_GET['pageNum_pagareparagua'])) {
  $pageNum_opcce = $_GET['pageNum_pagareparagua'];
}
$startRow_pagareparagua = $pageNum_opcce * $maxRows_pagareparagua;

$colname_pagareparagua = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_pagareparagua = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_pagareparagua = sprintf("SELECT * FROM convenioweb nolock WHERE rut_cliente = %s ORDER BY id DESC", GetSQLValueString($colname_pagareparagua, "text"));
$query_limit_opcce = sprintf("%s LIMIT %d, %d", $query_pagareparagua, $startRow_pagareparagua, $maxRows_pagareparagua);
$pagareparagua = mysqli_query($comercioexterior, $query_pagareparagua) or die(mysqli_error($comercioexterior));
$row_pagareparagua = mysqli_fetch_assoc($pagareparagua);
$totalRows_pagareparagua = mysqli_num_rows($pagareparagua);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Consulta Conevnio WEB - Maestro</title>
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
	color: #FFFFFF;
	font-weight: bold;
	font-size: 12px;
}
.Estilo8 {color: #FFFFFF; font-weight: bold; }
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="95%" align="left" valign="middle" class="Estilo3">CONSULTA CONVENIO WEB - MAESTRO</td>
    <td width="5%" rowspan="2" align="right" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">COMERCIO EXTERIOR</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Consulta Por RUT</span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Rut Cliente:</td>
      <td width="79%" align="left" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15">
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar"></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_pagareparagua > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" bgcolor="#999999">
    <td valign="middle"><span class="Estilo8"><span class="respuestacolumna"><span class="titulocolumnas">Pagare Paragua</span></span></span></td>
    <td valign="middle" class="titulocolumnas">Fecha Ingreso</td>
    <td valign="middle" class="titulocolumnas">Fecha Suscripci&oacute;n Pagar&eacute;</td>
    <td valign="middle" class="titulocolumnas">Fecha Suscripci&oacute;n Convenio</td>
    <td valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td valign="middle" class="titulocolumnas">Nombre Cliente </td>
    <td valign="middle" class="titulocolumnas">Moneda / Monto Pagare</td>
    <td valign="middle" class="titulocolumnas">Moneda / Monto Convenio</td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center" valign="middle"><a href="pagareparagua_det.php?recordID=<?php echo $row_pagareparagua['id']; ?>"> <img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></td>
    <td align="center" valign="middle" class="rojopequeno"><?php echo $row_pagareparagua['fecha_ingreso']; ?></td>
    <td align="center" valign="middle"><?php echo $row_pagareparagua['fecha_suscripcion_pagare']; ?></td>
    <td align="center" valign="middle"><?php echo $row_pagareparagua['fecha_suscripcion_convenio']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_pagareparagua['rut_cliente']); ?> </td>
    <td align="left" valign="middle"><?php echo strtoupper($row_pagareparagua['nombre_cliente']); ?> </td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_pagareparagua['moneda_pagare']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_pagareparagua['monto_pagare'], 2, ',', '.'); ?></span></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_pagareparagua['moneda_convenio']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_pagareparagua['monto_convenio'], 2, ',', '.'); ?></span></td>
  </tr>
  <?php } while ($row_pagareparagua = mysqli_fetch_assoc($pagareparagua)); ?>
</table>
<br>
<br>
Registros del <strong><?php echo ($startRow_pagareparagua + 1) ?></strong> al <strong><?php echo min($startRow_pagareparagua + $maxRows_pagareparagua, $totalRows_pagareparagua) ?></strong> de un total de <strong><?php echo $totalRows_pagareparagua ?></strong>
<?php } // Show if recordset not empty ?>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../redsuc/redsuc.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen4','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen4" width="80" height="25" border="0"></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($pagareparagua);
//mysqli_free_result($pagareconvenio);
?>
