<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=operaciones_pend_caratulagoc.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0");
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM";
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

$colname_Recordset1 = "Enviada a Proceso.";
if (isset($_GET['estado'])) {
  $colname_Recordset1 = $_GET['estado'];
}
$colname1_Recordset1 = "0";
if (isset($_GET['diaspendientes'])) {
  $colname1_Recordset1 = $_GET['diaspendientes'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = sprintf("SELECT * FROM openvpro WHERE estado = %s and diaspendientes <> %s", GetSQLValueString($colname_Recordset1, "text"),GetSQLValueString($colname1_Recordset1, "text"));
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Op Pendientes Caratula - Detalle</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 9px;
	color: #000;
}
-->
</style>


</head>

<body>
<table border="1" align="center">
  <tr>
    <td align="center" valign="middle">Nro Caratula</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Nombre Ejecutivo Cuenta</td>
    <td align="center" valign="middle">Especialista NI</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Sucursal</td>
    <td align="center" valign="middle">Oficina</td>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Dias Pendientes</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_Recordset1['id']; ?></td>
      <td align="center" valign="middle"><?php echo $row_Recordset1['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_Recordset1['nombre_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_Recordset1['territorial']; ?></td>
      <td align="left" valign="middle"><?php echo $row_Recordset1['nombre_ejecutivo']; ?></td>
      <td align="left" valign="middle"><?php echo $row_Recordset1['especialista']; ?></td>
      <td align="left" valign="middle"><?php echo $row_Recordset1['ejecutivo']; ?></td>
      <td align="center" valign="middle"><?php echo $row_Recordset1['sucursal']; ?></td>
      <td align="left" valign="middle"><?php echo $row_Recordset1['oficina']; ?></td>
      <td align="center" valign="middle"><?php echo $row_Recordset1['date_ing']; ?></td>
      <td align="left" valign="middle"><?php echo $row_Recordset1['evento']; ?></td>
      <td align="center" valign="middle"><?php echo $row_Recordset1['diaspendientes']; ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
</table>
<br />
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
