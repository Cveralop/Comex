<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,RED,SUP,TER,OPE,ESP,BMG";
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

$MM_restrictGoTo = "../../../../consulta_operaciones/historico/erroracceso.php";
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
<?php require_once('../../../../Connections/historico_goc.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=negcondisc.xls"); 
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

$colname_negcondisc = "Negociacion.";
if (isset($_GET['evento'])) {
  $colname_negcondisc = $_GET['evento'];
}
$colname1_negcondisc = "Discrepancia.";
if (isset($_GET['tipo_negociacion'])) {
  $colname1_negcondisc = $_GET['tipo_negociacion'];
}
mysqli_select_db($historico_goc, $database_historico_goc);
$query_negcondisc = sprintf("SELECT * FROM opcci WHERE evento = %s and tipo_negociacion = %s", GetSQLValueString($colname_negcondisc, "text"),GetSQLValueString($colname1_negcondisc, "text"));
$negcondisc = mysql_query($query_negcondisc, $historico_goc) or die(mysqli_error());
$row_negcondisc = mysqli_fetch_assoc($negcondisc);
$totalRows_negcondisc = mysqli_num_rows($negcondisc);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Negociacion Con Discrepancia</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 9px;
}
-->
</style></head>

<body>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Nro Registro</td>
    <td align="center" valign="middle">Nro Operación</td>
    <td align="center" valign="middle">Fecha Curse</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Estado Operación</td>
    <td align="center" valign="middle">Moneda Documentos</td>
    <td align="center" valign="middle">Monto Documentos</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_negcondisc['id']; ?>&nbsp; </td>
      <td align="center" valign="middle"><?php echo strtoupper($row_negcondisc['nro_operacion']); ?>&nbsp; </td>
      <td align="center" valign="middle"><?php echo $row_negcondisc['fecha_curse']; ?>&nbsp; </td>
      <td align="center" valign="middle"><?php echo strtoupper($row_negcondisc['rut_cliente']); ?>&nbsp; </td>
      <td align="left" valign="middle"><?php echo strtoupper($row_negcondisc['nombre_cliente']); ?>&nbsp; </td>
      <td align="center" valign="middle"><?php echo $row_negcondisc['estado']; ?>&nbsp; </td>
      <td align="center" valign="middle"><?php echo strtoupper($row_negcondisc['moneda_documentos']); ?>&nbsp; </td>
      <td align="right" valign="middle"><?php echo number_format($row_negcondisc['monto_documentos'], 2, ',', '.'); ?>&nbsp; </td>
    </tr>
    <?php } while ($row_negcondisc = mysqli_fetch_assoc($negcondisc)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($negcondisc);
?>
