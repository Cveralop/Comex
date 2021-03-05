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

$colname_nominamandatos = "-1";
if (isset($_GET['fecha_ingreso'])) {
  $colname_nominamandatos = $_GET['fecha_ingreso'];
}
$colname1_nominamandatos = "Ingresado no Visado";
if (isset($_GET['estado_mandato'])) {
  $colname1_nominamandatos = $_GET['estado_mandato'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_nominamandatos = sprintf("SELECT *,(usuarios.nombre)as espe FROM cliente, usuarios WHERE fecha_ingreso = %s and (cliente.ing_operador = usuarios.usuario) and estado_mandato = %s", GetSQLValueString($colname_nominamandatos, "date"),GetSQLValueString($colname1_nominamandatos, "text"));
$nominamandatos = mysqli_query($comercioexterior, $query_nominamandatos) or die(mysqli_error());
$row_nominamandatos = mysqli_fetch_assoc($nominamandatos);
$totalRows_nominamandatos = mysqli_num_rows($nominamandatos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Momina Mandatos - Detalle</title>
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
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="95%" border="0" align="center">
  <tr>
    <td align="center" valign="middle" class="NegrillaCartaReparo">Nomina de Mandatos para operarar por Fax e Email</td>
  </tr>
</table>
<br />
<table width="41%" border="0">
  <tr>
    <td align="left" valign="middle">Tipo Mandato (N = Nuevo / A = Antiguo)</td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#000000">
  <tr>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Post Venta</td>
    <td align="center" valign="middle">Tipo Mandato</td>
    <td align="center" valign="middle">Ingresado Por</td>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Estado Mandato</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_nominamandatos['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_nominamandatos['nombre_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_nominamandatos['especialista']; ?></td>
      <td align="center" valign="middle"><?php echo $row_nominamandatos['tipo_mandato']; ?></td>
      <td align="left" valign="middle"><?php echo $row_nominamandatos['espe']; ?></td>
      <td align="center" valign="middle"><?php echo $row_nominamandatos['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_nominamandatos['estado_mandato']; ?></td>
    </tr>
    <?php } while ($row_nominamandatos = mysqli_fetch_assoc($nominamandatos)); ?>
</table>
<p><br />
  <br />
</p>
<p>&nbsp;</p>
<table width="95%" border="0" align="center">
  <tr>
    <td width="50%">----------------------------------------------------------------</td>
    <td width="50%">----------------------------------------------------------------</td>
  </tr>
  <tr>
    <td>Confeccionado Por</td>
    <td><p>Recibido Por</p></td>
  </tr>
</table>
</body>
</html><?php
mysqli_free_result($nominamandatos);
?>