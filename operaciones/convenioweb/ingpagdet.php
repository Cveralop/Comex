<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,SUP";
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
$query_DetailRS1 = sprintf("SELECT *,date_add(curdate(), interval 720 day)as fecha_vcto FROM cliente nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO convenioweb (rut_cliente, nombre_cliente, moneda_pagare, monto_pagare, moneda_convenio, monto_convenio, doc_1, doc_2, doc_3, doc_6,  fecha_suscripcion_pagare, fecha_suscripcion_convenio, aval_rut_1, aval_nom_1, aval_rut_2, aval_nom_2, aval_rut_3, aval_nom_3, aval_rut_4, aval_nom_4, observacion, estado, fecha_ingreso, registro_ingreso, sucursal, ultimafecha, producto_cci, producto_cce, producto_pre, producto_mec, producto_cbi, producto_cbe, producto_ste, producto_str, producto_bga, producto_tbc, producto_cex, apo_rut1, apo_rut2, apo_rut3, apo_rut4, apo_nom1, apo_nom2, apo_nom3, apo_nom4, ope_rut1, ope_rut2, ope_rut3, ope_rut4, ope_rut5, ope_rut6, ope_nom1, ope_nom2, ope_nom3, ope_nom4, ope_nom5, ope_nom6, rol1, rol2, rol3, rol4, rol5, rol6, fecha_vcto) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['moneda_pagare'], "text"),
                       GetSQLValueString($_POST['monto_pagare'], "double"),
                       GetSQLValueString($_POST['moneda_convenio'], "text"),
                       GetSQLValueString($_POST['monto_convenio'], "double"),
                       GetSQLValueString($_POST['doc_1'], "text"),
                       GetSQLValueString($_POST['doc_2'], "text"),
                       GetSQLValueString($_POST['doc_3'], "text"),
                       GetSQLValueString($_POST['doc_6'], "text"),
                       GetSQLValueString($_POST['fecha_suscripcion_pagare'], "date"),
                       GetSQLValueString($_POST['fecha_suscripcion_convenio'], "date"),
                       GetSQLValueString($_POST['aval_rut_1'], "text"),
                       GetSQLValueString($_POST['aval_nom_1'], "text"),
                       GetSQLValueString($_POST['aval_rut_2'], "text"),
                       GetSQLValueString($_POST['aval_nom_2'], "text"),
                       GetSQLValueString($_POST['aval_rut_3'], "text"),
                       GetSQLValueString($_POST['aval_nom_3'], "text"),
                       GetSQLValueString($_POST['aval_rut_4'], "text"),
                       GetSQLValueString($_POST['aval_nom_4'], "text"),
                       GetSQLValueString($_POST['observacion'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "date"),
                       GetSQLValueString($_POST['registro_ingreso'], "text"),
                       GetSQLValueString($_POST['sucursal'], "text"),
                       GetSQLValueString($_POST['ultimafecha'], "date"),
  					   GetSQLValueString($_POST['producto_cci'], "text"),
					   GetSQLValueString($_POST['producto_cce'], "text"),
					   GetSQLValueString($_POST['producto_pre'], "text"),
					   GetSQLValueString($_POST['producto_mec'], "text"),
					   GetSQLValueString($_POST['producto_cbi'], "text"),
					   GetSQLValueString($_POST['producto_cbe'], "text"),
					   GetSQLValueString($_POST['producto_ste'], "text"),
					   GetSQLValueString($_POST['producto_str'], "text"),
					   GetSQLValueString($_POST['producto_bga'], "text"),
					   GetSQLValueString($_POST['producto_tbc'], "text"),
					   GetSQLValueString($_POST['producto_cex'], "text"),
					   GetSQLValueString($_POST['apo_rut1'], "text"),
					   GetSQLValueString($_POST['apo_rut2'], "text"),
					   GetSQLValueString($_POST['apo_rut3'], "text"),
					   GetSQLValueString($_POST['apo_rut4'], "text"),
					   GetSQLValueString($_POST['apo_nom1'], "text"),
					   GetSQLValueString($_POST['apo_nom2'], "text"),
					   GetSQLValueString($_POST['apo_nom3'], "text"),
					   GetSQLValueString($_POST['apo_nom4'], "text"),
					   GetSQLValueString($_POST['ope_rut1'], "text"),
					   GetSQLValueString($_POST['ope_rut2'], "text"),
					   GetSQLValueString($_POST['ope_rut3'], "text"),
					   GetSQLValueString($_POST['ope_rut4'], "text"),
					   GetSQLValueString($_POST['ope_rut5'], "text"),
					   GetSQLValueString($_POST['ope_rut6'], "text"),
					   GetSQLValueString($_POST['ope_nom1'], "text"),
					   GetSQLValueString($_POST['ope_nom2'], "text"),
					   GetSQLValueString($_POST['ope_nom3'], "text"),
					   GetSQLValueString($_POST['ope_nom4'], "text"),
					   GetSQLValueString($_POST['ope_nom5'], "text"),
					   GetSQLValueString($_POST['ope_nom6'], "text"),
					   GetSQLValueString($_POST['rol1'], "text"),
					   GetSQLValueString($_POST['rol2'], "text"),
					   GetSQLValueString($_POST['rol3'], "text"),
					   GetSQLValueString($_POST['rol4'], "text"),
					   GetSQLValueString($_POST['rol5'], "text"),
					   GetSQLValueString($_POST['rol6'], "text"),
					   GetSQLValueString($_POST['fecha_vcto'], "date"));
mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
  $insertGoTo = "ingpagmae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso Convenio WEB - Detalle</title>
<style type="text/css">
<!--
@import url("../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo5 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
#sprytextfield2 label {
	font-size: 10px;
}
-->
</style>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO CONVENIO WEB - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">COMERCIO EXTERIOR</td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr align="left" valign="baseline" bgcolor="#999999">
      <td colspan="4" valign="middle" nowrap><img src="../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Ingreso Pagar&eacute;</span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Fecha Suscripci&oacute;n Pagare:</td>
      <td align="center" valign="middle"><span id="sprytextfield1">
      <input name="fecha_suscripcion_pagare" type="text" class="etiqueta12" id="fecha_suscripcion_pagare" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span><span class="rojopequeno">(aaaa-mm-dd)</span></td>
      <td align="right" valign="middle">Fecha Suscripci&oacute;n Convenio:</td>
      <td align="center" valign="middle" class="rojopequeno"><span id="sprytextfield2">
        <label>
          <input name="fecha_suscripcion_convenio" type="text" class="etiqueta12" id="fecha_suscripcion_convenio" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
        </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span>(aaaa-mm-dd)</td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Rut Cliente: </td>
      <td align="left" valign="middle"><span id="sprytextfield3">
      <input name="rut_cliente" type="text" disabled class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15" readonly>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="rojopequeno">Sin puntos ni Guion</span></td>
      <td align="right" valign="middle">Sucursal Custodia:</td>
      <td align="center" valign="middle"><select name="sucursal" class="etiqueta12" id="sucursal">
        <option value="Casa Matriz." selected>Casa Matriz</option>
        <option value="Oficina.">Oficina</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><label>
          <input name="nombre_cliente2" type="text" disabled class="etiqueta12" id="nombre_cliente" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="120" maxlength="122" readonly>
      </label></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Moneda / Monto Pagare:</td>
      <td align="center" valign="middle"><select name="moneda_pagare" class="etiqueta12" id="moneda_pagare">
        <option value="CLP">CLP</option>
        <option value="DKK">DKK</option>
        <option value="NOK">NOK</option>
        <option value="SEK">SEK</option>
        <option value="USD" selected>USD</option>
        <option value="CAD">CAD</option>
        <option value="AUD">AUD</option>
        <option value="HKD">HKD</option>
        <option value="EUR">EUR</option>
        <option value="CHF">CHF</option>
        <option value="GBP">GBP</option>
        <option value="ZAR">ZAR</option>
        <option value="JPY">JPY</option>
      </select>
        <span class="rojopequeno">/</span>
        <input name="monto_pagare" type="text" class="etiqueta12" id="monto_pagare" value="0.00" size="20" maxlength="20">
      </div></td>
      <td align="right" valign="middle">Moneda / Monto Convenio:</td>
      <td align="center" valign="middle">
        <select name="moneda_convenio" class="etiqueta12" id="moneda_convenio">
          <option value="CLP">CLP</option>
          <option value="DKK">DKK</option>
          <option value="NOK">NOK</option>
          <option value="SEK">SEK</option>
          <option value="USD" selected>USD</option>
          <option value="CAD">CAD</option>
          <option value="AUD">AUD</option>
          <option value="HKD">HKD</option>
          <option value="EUR">EUR</option>
          <option value="CHF">CHF</option>
          <option value="GBP">GBP</option>
          <option value="ZAR">ZAR</option>
          <option value="JPY">JPY</option>
        </select>
        <span class="rojopequeno">/</span>
        <input name="monto_convenio" type="text" class="etiqueta12" id="monto_convenio" value="0.00" size="20" maxlength="20">
      </td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Parag&eacute; / Convenio: </td>
      <td colspan="3" align="left" valign="middle"><label>
        <input name="doc_1" type="checkbox" id="doc_1" value="Pagare.">
        Pagar�</label>
        <label>
          <input name="doc_2" type="checkbox" id="doc_2" value="Convenio.">
          Convenio 
          <input name="doc_3" type="checkbox" id="doc_3" value="Anexo.">
        Anexo Convenio Portal Comex</label>
        <label>
          <input name="doc_6" type="checkbox" id="doc_6" value="Solicitud Portal Comex.">
      Solicitud Portal Comex</label></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Producto:</td>
      <td colspan="3" align="left" valign="middle"><input type="checkbox" name="producto_cci" id="producto_cci" value="Si">
        Carta de Credito Import 
        <input type="checkbox" name="producto_cce" id="producto_cce" value="Si">
        Carta de Credito Export 
        <input type="checkbox" name="producto_pre" id="producto_pre" value="Si">
        Prestamos Stand Alone 
        <input type="checkbox" name="producto_mec" id="producto_mec" value="Si">
        Meco 
        <input type="checkbox" name="producto_cbi" id="producto_cbi" value="Si">
        Cobranza Import 
        <input type="checkbox" name="producto_cbe" id="producto_cbe" value="Si">
        Cobranza Export 
        <br>
        <input type="checkbox" name="producto_ste" id="radio" value="Si"> 
        Stand By Emitida 
        <input type="checkbox" name="producto_str" id="producto_str" value="Si">
        Stand By Recibida 
        
        <input type="checkbox" name="producto_bga" id="producto_bga" value="Si">
        Boleta Garant&iacute;a 
        <input type="checkbox" name="producto_tbc" id="producto_tbc" value="Si">
        IIIB5 
        <input type="checkbox" name="producto_cex" id="producto_cex" value="Si">
        Creditos Externos</td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Observaciones:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextarea1">
      <textarea name="observacion" cols="80" rows="4" class="etiqueta12" id="observacion"></textarea>
      <span class="rojopequeno"><span id="countsprytextarea1">&nbsp;</span></span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="Estilo5">Ingreso Avales</span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Aval 1:</td>
      <td colspan="3" align="left" valign="middle"><label>
        <input name="aval_rut_1" type="text" class="etiqueta12" id="aval_rut_1" size="15" maxlength="18">
      / 
      <input name="aval_nom_1" type="text" class="etiqueta12" id="aval_nom_1" size="80" maxlength="80">
      </label></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Aval 2:</td>
      <td colspan="3" align="left" valign="middle"><input name="aval_rut_2" type="text" class="etiqueta12" id="aval_rut_2" size="15" maxlength="18"> 
        / 
        <input name="aval_nom_2" type="text" class="etiqueta12" id="aval_nom_2" size="80" maxlength="80"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Aval 3:</td>
      <td colspan="3" align="left" valign="middle"><label>
        <input name="aval_rut_3" type="text" class="etiqueta12" id="aval_rut_3" size="15" maxlength="18">
      / 
      <input name="aval_nom_3" type="text" class="etiqueta12" id="aval_nom_3" size="80" maxlength="80">
      </label></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Aval 4:</td>
<td colspan="3" align="left" valign="middle"><label>
        <input name="aval_rut_4" type="text" class="etiqueta12" id="aval_rut_4" size="15" maxlength="18">
      / 
      <input name="aval_nom_4" type="text" class="etiqueta12" id="aval_nom_4" size="80" maxlength="80">
</label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="Estilo5">Ingreso Apoderados</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Apoderado 1:</td>
      <td colspan="3" align="left" valign="middle"><input name="apo_rut1" type="text" class="etiqueta12" id="apo_rut1" size="15" maxlength="18">
/
  <input name="apo_nom1" type="text" class="etiqueta12" id="apo_nom1" size="80" maxlength="80"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Apoderado 2:</td>
      <td colspan="3" align="left" valign="middle"><input name="apo_rut2" type="text" class="etiqueta12" id="apo_rut2" size="15" maxlength="18">
/
  <input name="apo_nom2" type="text" class="etiqueta12" id="apo_nom2" size="80" maxlength="80"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Apoderado 3:</td>
      <td colspan="3" align="left" valign="middle"><input name="apo_rut3" type="text" class="etiqueta12" id="apo_rut3" size="15" maxlength="18">
/
  <input name="apo_nom3" type="text" class="etiqueta12" id="apo_nom3" size="80" maxlength="80"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Apoderado 4:</td>
      <td colspan="3" align="left" valign="middle"><input name="apo_rut4" type="text" class="etiqueta12" id="apo_rut4" size="15" maxlength="18">
/
  <input name="apo_nom4" type="text" class="etiqueta12" id="apo_nom4" size="80" maxlength="80"></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="Estilo5">Ingreso Operadores y Roles</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Operador 1:</td>
      <td colspan="3" align="left" valign="middle"><input name="ope_rut1" type="text" class="etiqueta12" id="ope_rut1" size="15" maxlength="18">
/
  <input name="ope_nom1" type="text" class="etiqueta12" id="ope_nom1" size="80" maxlength="80"> 
  / 
  <select name="rol1" class="etiqueta12" id="rol1">
    <option value="Sin Dato." selected>N/A</option>
    <option value="Apoderado.">Apoderado</option>
    <option value="Usuario.">Usuario</option>
  </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Operador 2:</td>
      <td colspan="3" align="left" valign="middle"><input name="ope_rut2" type="text" class="etiqueta12" id="ope_rut2" size="15" maxlength="18">
/
  <input name="ope_nom2" type="text" class="etiqueta12" id="ope_nom2" size="80" maxlength="80"> 
  /  
  <select name="rol2" class="etiqueta12" id="rol2">
    <option value="Sin Dato." selected>N/A</option>
    <option value="Apoderado.">Apoderado</option>
    <option value="Usuario.">Usuario</option>
  </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Operador 3:</td>
      <td colspan="3" align="left" valign="middle"><input name="ope_rut3" type="text" class="etiqueta12" id="ope_rut3" size="15" maxlength="18">
/
  <input name="ope_nom3" type="text" class="etiqueta12" id="ope_nom3" size="80" maxlength="80"> 
  / 
  <select name="rol3" class="etiqueta12" id="rol3">
    <option value="Sin Dato." selected>N/A</option>
    <option value="Apoderado.">Apoderado</option>
    <option value="Usuario.">Usuario</option>
  </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Operador 4:</td>
      <td colspan="3" align="left" valign="middle"><input name="ope_rut4" type="text" class="etiqueta12" id="ope_rut4" size="15" maxlength="18">
/
  <input name="ope_nom4" type="text" class="etiqueta12" id="ope_nom4" size="80" maxlength="80"> 
  / 
  <select name="rol4" class="etiqueta12" id="rol4">
    <option value="Sin Dato." selected>N/A</option>
    <option value="Apoderado.">Apoderado</option>
    <option value="Usuario.">Usuario</option>
  </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Operador 5:</td>
      <td colspan="3" align="left" valign="middle"><input name="ope_rut5" type="text" class="etiqueta12" id="ope_rut5" size="15" maxlength="18">
/
  <input name="ope_nom5" type="text" class="etiqueta12" id="ope_nom5" size="80" maxlength="80"> 
  / 
  <select name="rol5" class="etiqueta12" id="rol5">
    <option value="Sin Dato." selected>N/A</option>
    <option value="Apoderado.">Apoderado</option>
    <option value="Usuario.">Usuario</option>
  </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Operador 6:</td>
      <td colspan="3" align="left" valign="middle"><input name="ope_rut6" type="text" class="etiqueta12" id="ope_rut6" size="15" maxlength="18">
/
  <input name="ope_nom6" type="text" class="etiqueta12" id="ope_nom6" size="80" maxlength="80"> 
  / 
  <select name="rol6" class="etiqueta12" id="rol6">
    <option value="Sin Dato." selected>N/A</option>
    <option value="Apoderado.">Apoderado</option>
    <option value="Usuario.">Usuario</option>
  </select></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle">
        <input type="submit" class="boton" value="Ingreso Convenio WEB">
      </div></td>
    </tr>
  </table>
  <input name="estado" type="hidden" id="estado" value="Vigente.">
  <input name="fecha_ingreso" type="hidden" id="fecha_ingreso" value="<?php echo date("Y-m-d"); ?>">
  <input name="registro_ingreso" type="hidden" id="registro_ingreso" value="<?php echo $_SESSION['login'];?>">
  <input name="rut_cliente" type="hidden" id="rut_cliente" value="<?php echo $row_DetailRS1['rut_cliente']; ?>">
  <input name="nombre_cliente" type="hidden" id="nombre_cliente" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>">
  <input type="hidden" name="MM_insert" value="form1">
  <input name="ultimafecha" type="hidden" id="ultimafecha" value="<?php echo date("Y-m-d H:i:s"); ?>">
  <input name="fecha_vcto" type="hidden" id="fecha_vcto" value="<?php echo $row_DetailRS1['fecha_vcto']; ?>">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image6" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {maxChars:255, counterId:"countsprytextarea1", counterType:"chars_remaining", isRequired:false});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>