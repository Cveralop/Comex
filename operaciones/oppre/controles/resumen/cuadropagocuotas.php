<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "SUP,OPE,ADM";
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

$colname_pagocuota = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname_pagocuota = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_pagocuota = sprintf("SELECT *,SUM(importe_com)as intereses FROM devengo nolock WHERE nro_operacion = %s GROUP BY secuencia ORDER BY secuencia ASC", GetSQLValueString($colname_pagocuota, "text"));
$pagocuota = mysql_query($query_pagocuota, $comercioexterior) or die(mysqli_error());
$row_pagocuota = mysqli_fetch_assoc($pagocuota);
$totalRows_pagocuota = mysqli_num_rows($pagocuota);

$colname_interesespagocuota = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname_interesespagocuota = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_interesespagocuota = sprintf("SELECT *,SUM(importe_com)as total_intereses FROM devengo nolock WHERE nro_operacion = %s GROUP BY nro_operacion ORDER BY secuencia DESC", GetSQLValueString($colname_interesespagocuota, "text"));
$interesespagocuota = mysql_query($query_interesespagocuota, $comercioexterior) or die(mysqli_error());
$row_interesespagocuota = mysqli_fetch_assoc($interesespagocuota);
$totalRows_interesespagocuota = mysqli_num_rows($interesespagocuota);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cuadro Pago de Cuotas</title>
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
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
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
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body onload="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CUADRO PAGTO DE CUOTAS</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" />Nro Operacion</td>
    </tr>
    <tr>
      <td width="18%" align="right" valign="middle">Nro Operacion</td>
      <td width="82%" align="left" valign="middle"><label>
        <input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="10" maxlength="7" />
      <span class="rojopequeno">F000000</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../prestamos.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_pagocuota > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Oficina</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Intereses Al</td>
      <td align="center" valign="middle" class="titulocolumnas">Importe Capital</td>
      <td align="center" valign="middle" class="titulocolumnas">Total Intereses</td>
      <td align="center" valign="middle" class="titulocolumnas">Importe Total a Pagar</td>
    </tr>
    <tr>
      <td align="center" valign="middle"><?php echo $row_interesespagocuota['oficina']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_interesespagocuota['nro_operacion']; ?></td>
      <td align="center" valign="middle"><?php echo $row_interesespagocuota['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_interesespagocuota['nombre_cliente']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_interesespagocuota['intereses_al']; ?></td>
      <td align="right" valign="middle"><?php echo number_format($row_interesespagocuota['saldo_vigente'], 2, ',', '.'); ?></td>
      <td align="right" valign="middle"><?php echo number_format($row_interesespagocuota['total_intereses'], 2, ',', '.'); ?></td>
      <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_interesespagocuota['saldo_vigente'] + $row_interesespagocuota['total_intereses'], 2, ',', '.'); ?></td>
    </tr>
  </table>
  <br />
  <span class="respuestacolumna_azul"><?php echo $totalRows_pagocuota ?></span> Cuotas En total<br />
  <br />
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Secuencia</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda</td>
      <td align="center" valign="middle" class="titulocolumnas">Saldo Vigente</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Vcto</td>
      <td align="center" valign="middle" class="titulocolumnas">Importe Intereses</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_pagocuota['secuencia']; ?></td>
        <td align="center" valign="middle"><?php echo $row_pagocuota['moneda']; ?></td>
        <td align="right" valign="middle"><?php echo number_format($row_pagocuota['saldo_vigente'], 2, ',', '.'); ?></td>
        <td align="center" valign="middle"><?php echo $row_pagocuota['fecha_vcto']; ?></td>
        <td align="right" valign="middle"><?php echo number_format($row_pagocuota['intereses'], 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_pagocuota = mysqli_fetch_assoc($pagocuota)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
</body>
</html>
<?php
mysqli_free_result($pagocuota);
mysqli_free_result($interesespagocuota);
?>