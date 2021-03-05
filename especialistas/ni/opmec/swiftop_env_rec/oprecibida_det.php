<?php require_once('../../../../Connections/comercioexterior.php'); ?>
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

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM swift_oprecibida nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SWIFT Op Recibida - Detalle</title>
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
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">SWIFT OP RECIBIDA - DETALLE</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">MERCADO DE CORREDORES</td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="4" align="left" valign="middle" bgcolor="#999999"><span class="titulo_menu"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Detalle OP Recibida</span></td>
  </tr>
  <tr>
    <td width="23%" height="16" align="right" valign="middle">Nro Registro:</td>
    <td width="37%" align="center" valign="middle" class="nroregistro"><?php echo $row_DetailRS1['id']; ?></td>
    <td width="17%" align="right" valign="middle">Fecha Ingreso:</td>
    <td width="23%" align="center" valign="middle"><?php echo $row_DetailRS1['date_ingreso']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Moneda / Monto Operación:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['moneda_operacion']; ?> / <?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></td>
    <td align="right" valign="middle">Contravalor en USD:</td>
    <td align="center" valign="middle"><?php echo number_format($row_DetailRS1['monto_operacion_usd'], 2, ',', '.'); ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nro. Operación / Nro. Operación Relacionada:</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['nro_operacion']; ?>/ <?php echo $row_DetailRS1['nro_operacion_relacionada']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Codigo Banco Corresponsal:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['cod_bco_corresponsal']; ?></td>
    <td align="right" valign="middle">Nombre Banco Corresponsal:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['nombre_banco_corresponsal']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Codigo Banco Ordenante:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['cod_bco_ordenante']; ?></td>
    <td align="right" valign="middle">Nombre Banco Ordenante:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['nombre_banco_ordenante']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nombre Beneficiario:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['nombre_beneficiario']; ?></td>
    <td align="right" valign="middle">Cuenta Beneficiario:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['cta_beneficiario']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Rut Beneficiario:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['rut_beneficiario']; ?></td>
    <td align="right" valign="middle">Nombre Ordenante:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['nombre_ordenante']; ?></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="oprecibida_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>