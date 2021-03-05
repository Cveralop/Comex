<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
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

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM cliente nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO caja_seca (rut_cliente, nombre_cliente, moneda_operacion, monto_operacion, evento, fecha_ingreso, date_ingreso, operador, date_operador) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['date_ingreso'], "date"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['date_operador'], "date"));

  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));

  $insertGoTo = "cajaseca_ing_mae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingreso Instrucciones Caja Seca - Detalle</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo4 {font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">INGRESO INSTRUCCIONES CAJA SECA - DETALLE</td>
    <td width="7%" align="left" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
</table>
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" nowrap="nowrap" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /></span><span class="titulo_menu">Ingreso Instrucciones Detalle</span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Rut Cliente:</td>
      <td><input name="rut_cliente" type="text" class="respuestacolumna" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15" />
      <span class="rojopequeno">Sin puntos ni Guion</span></td>
      <td align="right">Fecha Ingreso:</td>
      <td><input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10" />
      <span class="rojopequeno">(dd-mm-aaaa)</span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nombre Cliente:</td>
      <td colspan="3" align="left"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Moneda Operación:</td>
      <td align="center"><select name="moneda_operacion" class="etiqueta12" id="moneda_operacion">
        <option value="CLP">CLP</option>
        <option value="DKK">DKK</option>
        <option value="NOK">NOK</option>
        <option value="SEK">SEK</option>
        <option value="USD" selected="selected">USD</option>
        <option value="CAD">CAD</option>
        <option value="AUD">AUD</option>
        <option value="HKD">HKD</option>
        <option value="EUR">EUR</option>
        <option value="CHF">CHF</option>
        <option value="GBP">GBP</option>
        <option value="ZAR">ZAR</option>
        <option value="JPY">JPY</option>
      </select> 
        /
        <input name="monto_operacion" type="text" class="etiqueta12" value="0.00" size="20" maxlength="20" /></td>
      <td align="right">Tipo:</td>
      <td><label>
        <select name="evento" class="etiqueta12" id="evento">
<option value="Abono en Cta Cte." selected="selected">Abono en Cta Cte</option>
<option value="Cargo en Cta Cte.">Cargo en Cta Cte</option>
          <option value="LBTR.">LBTR</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" nowrap="nowrap"><input type="submit" class="boton" value="Enviar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="date_ingreso" value="<?php echo date("Y-m-d"); ?>" size="32" />
  <input type="hidden" name="date_operador" value="<?php echo date("Y-m-d H:i:s"); ?>" size="32" />
  <input type="hidden" name="operador" value="<?php echo $_SESSION['login'];?>" size="32" />
  <input type="hidden" name="MM_insert2" value="form1" />
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="cajaseca_ing_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>