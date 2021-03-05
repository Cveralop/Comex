<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,SUP,OPE,GER";
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
$colname1_DetailRS1 = "Aceptacion.";
if (isset($_GET['evento'])) {
  $colname1_DetailRS1 = $_GET['evento'];
}
$colname4_DetailRS1 = "Carta Compromiso.";
if (isset($_GET['evento'])) {
  $colname4_DetailRS1 = $_GET['evento'];
}
$colname2_DetailRS1 = "1";
if (isset($_GET['date_ini'])) {
  $colname2_DetailRS1 = $_GET['date_ini'];
}
$colname3_DetailRS1 = "1";
if (isset($_GET['date_fin'])) {
  $colname3_DetailRS1 = $_GET['date_fin'];
}
$colname_DetailRS1 = "Cursada.";
if (isset($_GET['estado'])) {
  $colname_DetailRS1 = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT *, (cliente.sucursal)as suc,(cliente.oficina)as ofi FROM opcbi LEFT JOIN cliente ON opcbi.rut_cliente =  cliente.rut_cliente WHERE estado = %s  and (evento = %s or evento = %s) and date_curse between %s and %s ORDER BY date_curse ASC", GetSQLValueString($colname_DetailRS1, "text"),GetSQLValueString($colname1_DetailRS1, "text"),GetSQLValueString($colname4_DetailRS1, "text"),GetSQLValueString($colname2_DetailRS1, "date"),GetSQLValueString($colname3_DetailRS1, "date"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Nomina Letras a Custodia</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #000000;
}
-->
</style>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="left" valign="middle"></div>
    <img src="../../../../imagenes/JPEG/logo_carta.JPG" width="219" height="61"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong>
      <?php
setlocale(LC_TIME,'sp'); 
echo strftime("Santiago, %d de %B de %Y");?>
    </strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Folio Nro <?php echo $row_DetailRS1['id']; ?></td>
  </tr>
</table>
<br>
<br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td colspan="2" align="center" valign="middle"><strong>NOMINA DE INGRESO DOCUMENTOS VALORADOS </strong></div></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="middle"><strong>COMERCIO EXTERIOR - COBRANZA EXTRANJERA DE IMPORTACI&Oacute;N</strong></div></td>
  </tr>
</table>
<br>
<br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="left" valign="middle"><strong>Se&ntilde;ores</strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Departamento Custodia</strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong>Presente</strong></td>
  </tr>
</table>
<br>
<br>
<br>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td align="center" valign="middle">Rut</div></td>
    <td align="center" valign="middle">Nombre</div></td>
    <td align="center" valign="middle">Nro Operaci&oacute;n </div></td>
    <td align="center" valign="middle">Moneda</div>
/      Monto
    </div> Operaci&oacute;n</td>
    <td align="center" valign="middle">Fecha Aceptacion</td>
    <td align="center" valign="middle">Nro Sucursal</td>
    <td align="center" valign="middle">Nombre Sucursal</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $row_DetailRS1['rut_cliente']; ?></div></td>
    <td align="left" valign="middle" bgcolor="#FFFFFF"><span class="Estilo4"><?php echo $row_DetailRS1['nombre_cliente']; ?></span></td>
    <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo strtoupper($row_DetailRS1['nro_operacion']); ?></td>
    <td align="right" valign="middle" bgcolor="#FFFFFF"><?php echo $row_DetailRS1['moneda_operacion']; ?> <?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></td>
    <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $row_DetailRS1['date_curse']; ?></td>
    <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $row_DetailRS1['suc']; ?></td>
    <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $row_DetailRS1['ofi']; ?></td>
    </tr>
  <?php } while ($row_DetailRS1 = mysqli_fetch_assoc($DetailRS1)); ?>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="left" valign="middle">Se adjunta un total de <strong><?php echo $totalRows_DetailRS1 ?></strong> Documentos Valorados </td>
  </tr>
</table>
<br>
<br>
<br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="center" valign="middle">Firma Encargado Comex</div></td>
    <td align="center" valign="middle">Firma Encargado Custodia</div></td>
  </tr>
</table>
<br>
<br>
<br>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>