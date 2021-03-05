<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,SUP,OPE";
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

$colname_DetailRS1 = "1";
if (isset($_GET['date_ini'])) {
  $colname_DetailRS1 = $_GET['date_ini'];
}
$colname1_DetailRS1 = "1";
if (isset($_GET['tipo_operacion'])) {
  $colname1_DetailRS1 = $_GET['tipo_operacion'];
}
$colname2_DetailRS1 = "Sucursal.";
if (isset($_GET['pagare'])) {
  $colname2_DetailRS1 = $_GET['pagare'];
}
$colname3_DetailRS1 = "N/A";
if (isset($_GET['pagare'])) {
  $colname3_DetailRS1 = $_GET['pagare'];
}
$colname4_DetailRS1 = "1";
if (isset($_GET['date_fin'])) {
  $colname4_DetailRS1 = $_GET['date_fin'];
}
$colname5_DetailRS1 = "Pagare Convenio.";
if (isset($_GET['pagare'])) {
  $colname5_DetailRS1 = $_GET['pagare'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM oppre nolock WHERE date_curse BETWEEN %s and %s and tipo_operacion = %s and ( pagare <> %s and pagare <> %s and pagare <> %s) ORDER BY nro_operacion ASC", GetSQLValueString($colname_DetailRS1, "date"),GetSQLValueString($colname4_DetailRS1, "date"),GetSQLValueString($colname1_DetailRS1, "text"),GetSQLValueString($colname2_DetailRS1, "text"),GetSQLValueString($colname3_DetailRS1, "text"),GetSQLValueString($colname5_DetailRS1, "text"));
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
.Estilo5 {color: #000000; font-weight: bold; font-size: 12px; }
.Estilo6 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body>
<table width="95%"  border="0" align="center">
  <tr>
    <td width="12%" align="left" valign="middle"><img src="../../../../imagenes/JPEG/logo_carta.JPG" width="219" height="61"></td>
    <td width="88%" align="right" valign="middle"><strong>
        <?php
setlocale(LC_TIME,'sp'); 
echo strftime("Santiago, %d de %B de %Y");?>
    </strong></div></td>
  </tr>
  <tr>
    <td colspan="2" align="right" valign="middle">Folio Nro <?php echo $row_DetailRS1['id']; ?></div></td>
  </tr>
</table>
<br>
<br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td colspan="2" align="center" valign="middle"><strong>NOMINA DE INGRESO PAGARES DOCUMENTOS VALORADOS </strong></div></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="middle"><strong>COMERCIO EXTERIOR - DEPTO PR&Eacute;STAMOS</strong></div></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="middle"><?php echo $row_DetailRS1['tipo_operacion']; ?></div></td>
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
  <tr valign="middle" bgcolor="#999999">
    <td align="center">Rut</div></td>
    <td align="center">Nombre</div></td>
    <td align="center">Nro Operaci&oacute;n </div></td>
    <td align="center">Fecha Emisi&oacute;n</div></td>
    <td align="center">Moneda</div></td>
    <td align="center">Monto</div></td>
    <td align="center" class="Estilo5">Tipo Documento</div></td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><?php echo $row_DetailRS1['rut_cliente']; ?></div></td>
    <td align="left"><span class="Estilo4"><?php echo $row_DetailRS1['nombre_cliente']; ?></span></td>
    <td align="center"><?php echo strtoupper($row_DetailRS1['nro_operacion']); ?></div></td>
    <td align="center" class="Estilo4"><?php echo $row_DetailRS1['fecha_curse']; ?></div></td>
    <td align="center"><?php echo $row_DetailRS1['moneda_operacion']; ?></div></td>
    <td align="right"><?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></td>
    <td align="center"><?php echo $row_DetailRS1['pagare']; ?></div></td>
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