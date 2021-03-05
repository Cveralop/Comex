<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ESP,ADM";
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

$colname_mandatospendientes = "N/A";
if (isset($_GET['visador'])) {
  $colname_mandatospendientes = $_GET['visador'];
}
$colname1_mandatospendientes = "Ingresado no Visado";
if (isset($_GET['estado_mandato'])) {
  $colname1_mandatospendientes = $_GET['estado_mandato'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_mandatospendientes = sprintf("SELECT *,(usuarios.nombre)as espe FROM cliente, usuarios WHERE visador = %s and (cliente.ing_operador = usuarios.usuario) and estado_mandato = %s", GetSQLValueString($colname_mandatospendientes, "text"),GetSQLValueString($colname1_mandatospendientes, "text"));
$mandatospendientes = mysqli_query($comercioexterior, $query_mandatospendientes) or die(mysqli_error());
$row_mandatospendientes = mysqli_fetch_assoc($mandatospendientes);
$totalRows_mandatospendientes = mysqli_num_rows($mandatospendientes);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mandatos Pendientes</title>
<style type="text/css">
<!--
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script> 
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
</head>
<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">MANDATOS PENDIENTES</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">NEGOCIO INTERNACIONAL</td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="clientes_mandatos.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen2','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen2" width="80" height="25" border="0" id="Imagen2" /></a></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Especialista</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Ingresado Por</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso Sistema</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_mandatospendientes['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_mandatospendientes['nombre_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_mandatospendientes['especialista']; ?></td>
      <td align="left" valign="middle"><?php echo $row_mandatospendientes['espe']; ?></td>
      <td align="center" valign="middle"><?php echo $row_mandatospendientes['date_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_mandatospendientes['estado_mandato']; ?></td>
    </tr>
    <?php } while ($row_mandatospendientes = mysqli_fetch_assoc($mandatospendientes)); ?>
</table>
<br />
<?php echo $totalRows_mandatospendientes ?> Registros en Total <br />
<br />
</body>
</html>
<?php
mysqli_free_result($mandatospendientes);
?>