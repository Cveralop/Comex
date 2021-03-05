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

$colname_opingresadas = "1";
if (isset($_GET['date_fin'])) {
  $colname_opingresadas = $_GET['date_fin'];
}
$colname1_opingresadas = "1";
if (isset($_GET['date_fin'])) {
  $colname1_opingresadas = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opingresadas = sprintf("SELECT * FROM opcci nolock WHERE date_ingreso between %s and %s", GetSQLValueString($colname_opingresadas, "date"),GetSQLValueString($colname1_opingresadas, "date"));
$opingresadas = mysql_query($query_opingresadas, $comercioexterior) or die(mysqli_error());
$row_opingresadas = mysqli_fetch_assoc($opingresadas);
$totalRows_opingresadas = mysqli_num_rows($opingresadas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operaciones Ingresadas Segun Segmento</title>
<script src="../../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
}
.Estilo1 {font-size: 18px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<link href="../../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body onload="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" bgcolor="#FF0000"><span class="Estilo1">OPERACIONES  INGRESADAS SEGUN SEGMENTO</span></td>
    <td width="7%" rowspan="2" align="left" valign="middle" bgcolor="#FF0000"><img src="../../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#FF0000" class="subtitulopaguina">TERRITORIALES</td>
  </tr>
</table>
<br />
<form id="form3" name="form3" method="get" action="opsegmento.php">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0" /><span class="titulodetalle">Informe Operaciones Segun Segmento</span></td>
    </tr>
    <tr>
      <td width="18%" align="right" valign="middle">Fecha de Ingreso:</td>
      <td width="82%" align="left" valign="middle"><label>
        <span class="rojopequeno">Desde</span>
        <input name="date_ini" type="text" class="etiqueta12" id="date_ini" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" />
        <span class="rojopequeno">Hasta</span>
        <input name="date_fin" type="text" class="etiqueta12" id="date_fin" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" />
        <span class="rojopequeno">(aaaa-mm-dd)</span></label></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Segmento:</td>
      <td align="left" valign="middle"><select name="segmento" class="etiqueta12" id="segmento">
<option value="Territorial">Territoriales</option>
</select></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><label>
        <input name="button3" type="submit" class="boton" id="button3" value="Buscar" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../../especialista.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen1','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen1" width="80" height="25" border="0" id="Imagen1" /></a></td>
  </tr>
</table>
<script type="text/javascript">
<!--
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($opingresadas);
?>