<?php require_once('../../../Connections/historico_goc.php'); ?>
<?php
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

$MM_restrictGoTo = "../../../consulta_operaciones/gestiondeinformes/erroracceso.php";
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
  global $historico_goc;

  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($historico_goc, $theValue) : mysqli_escape_string($historico_goc, $theValue);

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

$colname_Recordset1 = "-1";
if (isset($_GET['date_ini'])) {
  $colname_Recordset1 = $_GET['date_ini'];
}
$colname1_Recordset1 = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_Recordset1 = $_GET['date_fin'];
}
mysqli_select_db($historico_goc, $database_historico_goc);
$query_Recordset1 = sprintf("SELECT *,SUM(cantidad)as cant, MAX(date_ingreso)as date_max, MIN(date_ingreso)as date_min FROM estadistica_resumen WHERE date_ingreso between %s and %s GROUP BY producto, evento", GetSQLValueString($colname_Recordset1, "date"),GetSQLValueString($colname1_Recordset1, "date"));
$Recordset1 = mysqli_query($historico_goc, $query_Recordset1) or die(mysqli_error($historico_goc));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Resumen Producto v/s Evento - Detalle</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	color: #000;
	font-weight: bold;
}
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="95%" border="0" align="center">
  <tr>
    <td colspan="2" align="center" valign="middle" bgcolor="#000000" class="titulopaguina">Resumen Curse Operaciones por Producto v/s Evento</td>
  </tr>
  <tr>
    <td width="16%" align="right" valign="middle">Fecha Desde:</td>
    <td width="84%" align="left" valign="middle"><?php echo $row_Recordset1['date_min']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Fecha Hasta:</td>
    <td align="left" valign="middle"><?php echo $row_Recordset1['date_max']; ?></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center">
  <tr>
    <td align="center">Producto</td>
    <td align="center">Evento</td>
    <td align="center">Cantidad</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo $row_Recordset1['producto']; ?></td>
      <td align="left" valign="middle"><?php echo $row_Recordset1['evento']; ?></td>
      <td align="right" valign="middle"><?php echo number_format($row_Recordset1['cant'], 0, ',', '.'); ?></td>
    </tr>
    <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
</table>
<br />
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>