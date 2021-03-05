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
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=operaciones_reparadas.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0");
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

$colname_opcci = "Reparada.";
if (isset($_GET['estado'])) {
  $colname_opcci = $_GET['estado'];
}
$colname1_opcci = "Solucionado.";
if (isset($_GET['estado'])) {
  $colname1_opcci = $_GET['estado'];
}
mysqli_select_db($historico_goc, $database_historico_goc);
$query_opcci = sprintf("SELECT * FROM base_operaciones WHERE estado = %s or estado = %s ORDER BY date_espe ASC", GetSQLValueString($colname_opcci, "text"),GetSQLValueString($colname1_opcci, "text"));
$opcci = mysqli_query($historico_goc, $query_opcci, ) or die(mysqli_error($historico_goc));
$row_opcci = mysqli_fetch_assoc($opcci);
$totalRows_opcci = mysqli_num_rows($opcci);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Op Reparadas - Detalle</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
.Estilo2 {font-size: 9px; color: #0000FF; }
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #000;
}
body {
	background-image: url();
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
-->
</style>
</head>

<body>
<table width="95%" border="1" align="center">
  <tr>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Fecha Ingreso</td>
    <td align="center" valign="middle">Fecha Curse</td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Operador</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Estado</td>
    <td align="center" valign="middle">Motivo Reparo</td>
    <td align="center" valign="middle">Nro Operaci&oacute;n</td>
    <td align="center" valign="middle">Moneda Operaci&oacute;n</td>
    <td align="center" valign="middle">Monto Operaci&oacute;n</td>
    <td align="center" valign="middle">Urgente</td>
    <td align="center" valign="middle">Fuera Horario</td>
    <td align="center" valign="middle">Perfil</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['nombre_cliente']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['date_ingreso']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['date_curse']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['especialista_curse']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['territorial']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['operador']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['producto']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['evento']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['estado']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opcci['reparo_obs']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['nro_operacion']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['moneda_operacion'])?></td>
      <td align="right" valign="middle"><?php echo number_format($row_opcci['monto_operacion'], 2, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['urgente']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['fuera_horario']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opcci['perfil_espe_curse']); ?></td>
    </tr>
    <?php } while ($row_opcci = mysqli_fetch_assoc($opcci)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($opcci);
?>