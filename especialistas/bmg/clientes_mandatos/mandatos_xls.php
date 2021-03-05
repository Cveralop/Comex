<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,BMG";
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
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=Nomina_Mandatos.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0");
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
$colname_mandatos_xls = "Sin Mandato";
if (isset($_GET['estado_mandato'])) {
  $colname_mandatos_xls = $_GET['estado_mandato'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_mandatos_xls = sprintf("SELECT * FROM cliente WHERE estado_mandato <> %s ORDER BY fecha_ingreso ASC", GetSQLValueString($colname_mandatos_xls, "text"));
$mandatos_xls = mysqli_query($comercioexterior, $query_mandatos_xls) or die(mysqli_error($comercioexterior));
$row_mandatos_xls = mysqli_fetch_assoc($mandatos_xls);
$totalRows_mandatos_xls = mysqli_num_rows($mandatos_xls);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nomina Mandatos Excel</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #000;
}
-->
</style>
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
</head>
<body>
<table border="1" align="center">
  <tr>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Especilista NI</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Oficina</td>
    <td align="center" valign="middle">Codigo Sucursal</td>
    <td align="center" valign="middle">Tipo Mandato</td>
    <td align="center" valign="middle">Ingresado por</td>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Visado por</td>
    <td align="center" valign="middle">Fecha Visacion</td>
    <td align="center" valign="middle">Estado Mandato</td>
    <td align="center" valign="middle">Contacto 1</td>
    <td align="center" valign="middle">Contacto 2</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_mandatos_xls['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_mandatos_xls['nombre_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_mandatos_xls['especialista']; ?></td>
      <td align="left" valign="middle"><?php echo $row_mandatos_xls['ejecutivo']; ?></td>
      <td align="left" valign="middle"><?php echo $row_mandatos_xls['oficina']; ?></td>
      <td align="center" valign="middle"><?php echo $row_mandatos_xls['sucursal']; ?></td>
      <td align="center" valign="middle"><?php echo $row_mandatos_xls['tipo_mandato']; ?></td>
      <td align="center" valign="middle"><?php echo $row_mandatos_xls['ing_operador']; ?></td>
      <td align="center" valign="middle"><?php echo $row_mandatos_xls['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_mandatos_xls['visador']; ?></td>
      <td align="center" valign="middle"><?php echo $row_mandatos_xls['fecha_visacion']; ?></td>
      <td align="center" valign="middle"><?php echo $row_mandatos_xls['estado_mandato']; ?></td>
      <td align="left" valign="middle"><?php echo $row_mandatos_xls['contacto1']; ?></td>
      <td align="left" valign="middle"><?php echo $row_mandatos_xls['contacto2']; ?></td>
    </tr>
    <?php } while ($row_mandatos_xls = mysqli_fetch_assoc($mandatos_xls)); ?>
</table>
<br />
<?php echo $totalRows_mandatos_xls ?> Registros Total
</body>
</html>
<?php
mysqli_free_result($mandatos_xls);
?>