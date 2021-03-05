<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,ESP";
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
header("Content-Disposition: attachment;filename=vcto_operaciones.xls"); 
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

$colname_devengonro = "-1";
if (isset($_GET['fecha_desde'])) {
  $colname_devengonro = $_GET['fecha_desde'];
}
$colname1_devengonro = "-1";
if (isset($_GET['fecha_hasta'])) {
  $colname1_devengonro = $_GET['fecha_hasta'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_devengonro = sprintf("SELECT * FROM vctooperaciones nolock WHERE fecha_vcto BETWEEN %s and %s ORDER BY fecha_vcto ASC", GetSQLValueString($colname_devengonro, "date"),GetSQLValueString($colname1_devengonro, "date"));
$devengonro = mysqli_query($comercioexterior, $query_devengonro) or die(mysqli_error());
$row_devengonro = mysqli_fetch_assoc($devengonro);
$totalRows_devengonro = mysqli_num_rows($devengonro);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vcto Operaciones</title>
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
	color: #000;
}
body {
	background-image: url();
}
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
    <td bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
    <td bgcolor="#999999" class="titulocolumnas">Sucursal</td>
    <td bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
    <td bgcolor="#999999" class="titulocolumnas">Moneda</td>
    <td bgcolor="#999999" class="titulocolumnas">Saldo Operación</td>
    <td bgcolor="#999999" class="titulocolumnas">Vcto Operación</td>
    <td bgcolor="#999999" class="titulocolumnas">Cuota No.</td>
    <td bgcolor="#999999" class="titulocolumnas">Ejecutivo Cuentas</td>
    <td bgcolor="#999999" class="titulocolumnas">Especilaista NI</td>
    <td bgcolor="#999999" class="titulocolumnas">Ejecutivo NI</td>
    <td bgcolor="#999999" class="titulocolumnas">Ultima Linea</td>
    <td bgcolor="#999999" class="titulocolumnas">Banca</td>
    <td bgcolor="#999999" class="titulocolumnas">Segmento</td>
    <td bgcolor="#999999" class="titulocolumnas">Sub Segmento</td>
    <td bgcolor="#999999" class="titulocolumnas">Territorial</td>
    <td bgcolor="#999999" class="titulocolumnas">Zonal</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="right" valign="middle" bgcolor="#FFFFFF"><?php echo $row_devengonro['rut_cliente']; ?></td>
      <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $row_devengonro['nombre_cliente']; ?></td>
      <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $row_devengonro['sucursal']; ?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="respuestacolumna_rojo"><?php echo $row_devengonro['nro_operacion']; ?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="respuestacolumna_rojo"><?php echo $row_devengonro['moneda']; ?></td>
      <td align="right" valign="middle" bgcolor="#FFFFFF"><?php echo number_format($row_devengonro['saldo_vigente'], 2, ',', '.'); ?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $row_devengonro['fecha_vcto']; ?></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $row_devengonro['secuencia']; ?></td>
      <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $row_devengonro['nombre_ejecutivo']; ?></td>
      <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $row_devengonro['especialista_ni']; ?></td>
      <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $row_devengonro['ejecutivo_ni']; ?></td>
      <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $row_devengonro['ultima_linea']; ?></td>
      <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $row_devengonro['banca']; ?></td>
      <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $row_devengonro['segmento']; ?></td>
      <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $row_devengonro['sub_segmento']; ?></td>
      <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $row_devengonro['territorial']; ?></td>
      <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $row_devengonro['zonal']; ?></td>
    </tr>
    <?php } while ($row_devengonro = mysqli_fetch_assoc($devengonro)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($devengonro);
?>