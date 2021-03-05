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
header("Content-Disposition: attachment;filename=operaciones_ingresadas_historico.xls");
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

$colname2_DetailRS1 = "1";
if (isset($_GET['date_ini'])) {
  $colname2_DetailRS1 = $_GET['date_ini'];
}
$colname3_DetailRS1 = "1";
if (isset($_GET['date_fin'])) {
  $colname3_DetailRS1 = $_GET['date_fin'];
}
mysqli_select_db($historico_goc, $database_historico_goc);
$query_DetailRS1 = sprintf("SELECT * FROM base_operaciones WHERE date_ingreso between %s and %s ORDER BY date_ingreso ASC", GetSQLValueString($colname2_DetailRS1, "date"),GetSQLValueString($colname3_DetailRS1, "date"));
$DetailRS1 = mysqli_query($historico_goc, $query_DetailRS1) or die(mysqli_error($historico_goc));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Op Ingresadas - Detalle</title>
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
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Estado</td>
    <td align="center" valign="middle">Fecha Curse</td>
    <td align="center" valign="middle">Asignador</td>
    <td align="center" valign="middle">Operador</td>
    <td align="center" valign="middle">Producto</td>
    <td align="center" valign="middle">Tipo Operaci&oacute;n</td>
    <td align="center" valign="middle">Operador</td>
    <td align="center" valign="middle">Moneda / Monto Operaci&oacute;n</td>
    <td align="center" valign="middle">Moneda / Monto Documentos</td>
    <td align="center" valign="middle">Moneda / Monto Documentos</td>
    <td align="center" valign="middle">Observaciones</td>
    <td align="center" valign="middle">Reparo Observaciones</td>
    <td align="center" valign="middle">Especialista Curse</td>
    <td align="center" valign="middle">Sub Estado</td>
    <td align="center" valign="middle">Ejecutivo Cuenta</td>
    <td align="center" valign="middle">Ejecutivo NI</td>
    <td align="center" valign="middle">Especialista NI</td>
    <td align="center" valign="middle">Nombre Oficina</td>
    <td align="center" valign="middle">Segmento Comercial</td>
    <td align="center" valign="middle">Zonal</td>
    <td align="center" valign="middle">Territorial</td>
    <td align="center" valign="middle">Fecha Preingreso</td>
    <td align="center" valign="middle">Fecha Ingreso Especialista</td>
    <td align="center" valign="middle">Fecha Visacion</td>
    <td align="center" valign="middle">Fecha Asignacion</td>
    <td align="center" valign="middle">Fecha Operador</td>
    <td align="center" valign="middle">Fecha Supervisor</td>
    <td align="center" valign="middle">Item FIE</td>
    <td align="center" valign="middle">Item FV</td>
    <td align="center" valign="middle">Item FA</td>
    <td align="center" valign="middle">Item FO</td>
    <td align="center" valign="middle">Item FS</td>
    <td align="center" valign="middle">H C Ing Esp V/S Asig</td>
    <td align="center" valign="middle">H C Ing Esp V/S Ope</td>
    <td align="center" valign="middle">H C Ing Esp V/S Sup</td>
    <td align="center" valign="middle">Autorizador</td>
    <td align="center" valign="middle">Estado Visaci&oacute;n</td>
    <td align="center" valign="middle">Visador</td>
    <td align="center" valign="middle">Urgente</td>
    <td align="center" valign="middle">Fuera Horario</td>
    <td align="center" valign="middle">Ingreso igual Curse</td>
    <td align="center" valign="middle">Perfil Especialista Curse</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['nombre_cliente']; ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['date_ingreso']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['evento']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['estado']; ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['date_curse']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['asignador']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['operador']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['producto']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['tipo_operacion']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['nro_operacion']; ?></td>
      <td align="right" valign="middle"><?php echo $row_DetailRS1['moneda_operacion']; ?> <?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></td>
      <td align="right" valign="middle"><?php echo $row_DetailRS1['moneda_documentos']; ?> <?php echo number_format($row_DetailRS1['monto_documentos'], 2, ',', '.'); ?></td>
      <td align="right" valign="middle"><?php echo number_format($row_DetailRS1['monto_usd'], 2, ',', '.'); ?></td>
      <td align="left" valign="middle"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['reparo_obs']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['especialista_curse']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['sub_estado']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['ejecutivo_cuenta']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['ejecutivo_ni']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['especialista_ni']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['nombre_oficina']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['segmento_comercial']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['zonal']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['territorial']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['date_preingreso']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['date_espe']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['date_visa']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['date_asig']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['date_oper']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['date_supe']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['cde']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['cdv']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['cda']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['cdo']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['cds']; ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['difing_difasig']; ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['difing_difope']; ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['difing_difsup']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['autorizador']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['estado_visacion']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['visador']; ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['urgente']; ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['fuera_horario']; ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['ingresoigualcurse']; ?></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['perfil_espe_curse']; ?></td>
    </tr>
    <?php } while ($row_DetailRS1 = mysqli_fetch_assoc($DetailRS1)); ?>
</table>
<br>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>