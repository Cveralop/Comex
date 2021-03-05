<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "SUP,OPE,ADM";
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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE opcci SET rut_cliente=%s, nombre_cliente=%s, nro_operacion=%s, nro_operacion_relacionada=%s, moneda_documentos=%s, monto_documentos=%s, origen_fondos=%s, tipocambio=%s, paridad=%s, tipo_tasa=%s, tasa_final=%s, vcto_operacion=%s, numero_neg=%s, iniplapro=%s, finplapro=%s, moneda_gtocorr=%s, monto_gtocorr=%s, tasa_pla_pro=%s, inifinbco=%s, moneda_negociacion=%s, monto_negociacion=%s, monto_inte=%s, gto_corr=%s, con_disc=%s WHERE id=%s",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['nro_operacion_relacionada'], "text"),
                       GetSQLValueString($_POST['moneda_documentos'], "text"),
                       GetSQLValueString($_POST['monto_documentos'], "double"),
                       GetSQLValueString($_POST['origen_fondos'], "text"),
                       GetSQLValueString($_POST['tipocambio'], "double"),
                       GetSQLValueString($_POST['paridad'], "double"),
                       GetSQLValueString($_POST['tipo_tasa'], "text"),
                       GetSQLValueString($_POST['tasa_final'], "double"),
                       GetSQLValueString($_POST['vcto_operacion'], "date"),
                       GetSQLValueString($_POST['numero_neg'], "int"),
                       GetSQLValueString($_POST['iniplapro'], "date"),
                       GetSQLValueString($_POST['finplapro'], "date"),
                       GetSQLValueString($_POST['moneda_gtocorr'], "text"),
                       GetSQLValueString($_POST['monto_gtocorr'], "double"),
                       GetSQLValueString($_POST['tasa_pla_pro'], "double"),
                       GetSQLValueString($_POST['inifinbco'], "date"),
                       GetSQLValueString($_POST['moneda_negociacion'], "text"),
                       GetSQLValueString($_POST['monto_negociacion'], "double"),
                       GetSQLValueString($_POST['monto_inte'], "int"),
                       GetSQLValueString($_POST['gto_corr'], "int"),
                       GetSQLValueString($_POST['com_disc'], "int"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "ingavisoplazo_mae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opcci WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingreso Aviso Plazo Proveedor - Detalle</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO AVISO PLAZO PROVEEDOR - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTAS DE CR&Eacute;DITO DE IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0" /><span class="titulo_menu">Ingreso Detalle Aviso Plazo Proveedor</span></td>
    </tr>
    <tr valign="baseline">
      <td width="18%" align="right" valign="middle">Nro Registro:</td>
      <td width="20%" align="center" valign="middle" class="nroregistro"><?php echo $row_DetailRS1['id']; ?></td>
      <td width="33%" align="right" valign="middle">Rut Cliente:</td>
      <td width="29%" align="center" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['rut_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="17" maxlength="15" />
      <span class="rojopequeno">Sin Puntos ni Guión</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['nombre_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nro Operacion:</td>
      <td align="center" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['nro_operacion'], ENT_COMPAT, 'utf-8'); ?>" size="10" maxlength="7" />
      <span class="rojopequeno">K00000</span></td>
<td align="right" valign="middle">Nro Operacion Relacionada:</td>
      <td align="center" valign="middle"><input name="nro_operacion_relacionada" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['nro_operacion_relacionada'], ENT_COMPAT, 'utf-8'); ?>" size="10" maxlength="7" />
        <span class="rojopequeno">L000000</span></td>
    </tr>
  </table>
  <br />
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /><span class="titulo_menu">Datos Plazo Proveedor</span></td>
    </tr>
    <tr valign="baseline">
      <td width="18%" align="right" valign="middle">Moneda / Monto Documentos:</td>
      <td width="39%" align="center" valign="middle"><select name="moneda_documentos" class="etiqueta12" id="moneda_documentos">
        <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_documentos']))) {echo "selected=\"selected\"";} ?>>CLP</option>
        <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_documentos']))) {echo "selected=\"selected\"";} ?>>DKK</option>
        <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_documentos']))) {echo "selected=\"selected\"";} ?>>NOK</option>
        <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_documentos']))) {echo "selected=\"selected\"";} ?>>SEK</option>
        <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_documentos']))) {echo "selected=\"selected\"";} ?>>USD</option>
        <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_documentos']))) {echo "selected=\"selected\"";} ?>>CAD</option>
        <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_documentos']))) {echo "selected=\"selected\"";} ?>>AUD</option>
        <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_documentos']))) {echo "selected=\"selected\"";} ?>>HKD</option>
        <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_documentos']))) {echo "selected=\"selected\"";} ?>>EUR</option>
        <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_documentos']))) {echo "selected=\"selected\"";} ?>>CHF</option>
        <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_documentos']))) {echo "selected=\"selected\"";} ?>>GBP</option>
        <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_documentos']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
        <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_documentos']))) {echo "selected=\"selected\"";} ?>>JPY</option>
        <option value="CNY" <?php if (!(strcmp("CNY", $row_DetailRS1['moneda_documentos']))) {echo "selected=\"selected\"";} ?>>CNY</option>
      </select>
        /
      <input name="monto_documentos" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['monto_documentos'], ENT_COMPAT, 'utf-8'); ?>" size="20" maxlength="20" /></td>
      <td width="20%" align="right" valign="middle">Inicio Plazo Proveedor:</td>
      <td width="23%" align="center" valign="middle"><span id="sprytextfield1">
      <input name="iniplapro" type="text" class="etiqueta12" id="iniplapro" value="<?php echo $row_DetailRS1['iniplapro']; ?>" size="12" maxlength="10" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span><span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Moneda / Monto Gastos Corresponsal:</td>
      <td align="center" valign="middle"><label>
        <select name="moneda_gtocorr" class="etiqueta12" id="moneda_gtocorr">
          <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_gtocorr']))) {echo "selected=\"selected\"";} ?>>CLP</option>
          <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_gtocorr']))) {echo "selected=\"selected\"";} ?>>DKK</option>
          <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_gtocorr']))) {echo "selected=\"selected\"";} ?>>NOK</option>
          <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_gtocorr']))) {echo "selected=\"selected\"";} ?>>SEK</option>
          <option value="USD" selected="selected" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_gtocorr']))) {echo "selected=\"selected\"";} ?>>USD</option>
          <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_gtocorr']))) {echo "selected=\"selected\"";} ?>>CAD</option>
          <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_gtocorr']))) {echo "selected=\"selected\"";} ?>>AUD</option>
          <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_gtocorr']))) {echo "selected=\"selected\"";} ?>>HKD</option>
          <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_gtocorr']))) {echo "selected=\"selected\"";} ?>>EUR</option>
          <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_gtocorr']))) {echo "selected=\"selected\"";} ?>>CHF</option>
          <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_gtocorr']))) {echo "selected=\"selected\"";} ?>>GBP</option>
          <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_gtocorr']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
<option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_gtocorr']))) {echo "selected=\"selected\"";} ?>>JPY</option>
        </select>
/
<input name="monto_gtocorr" type="text" class="etiqueta12" id="monto_gtocorr" value="<?php echo $row_DetailRS1['monto_gtocorr']; ?>" size="20" maxlength="20" />
      </label></td>
      <td align="right" valign="middle">Fin Plazo Proveedor:</td>
      <td align="center" valign="middle"><span id="sprytextfield2">
      <label>
        <input name="finplapro" type="text" class="etiqueta12" id="finplapro" value="<?php echo $row_DetailRS1['finplapro']; ?>" size="12" maxlength="10" />
      </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span><span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Tasa Plazo Proveedor:</td>
      <td align="center" valign="middle"><label>
        <input name="tasa_pla_pro" type="text" class="etiqueta12" id="tasa_pla_pro" value="<?php echo $row_DetailRS1['tasa_pla_pro']; ?>" size="10" maxlength="10" />
        <span class="rojopequeno">0.000000</span></label></td>
      <td align="right" valign="middle">Tipo Cambio</td>
      <td align="center" valign="middle"><label>
        <input name="tipocambio" type="text" class="etiqueta12" id="tipocambio" value="<?php echo $row_DetailRS1['tipocambio']; ?>" size="10" maxlength="10" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Tipo Tasa:</td>
      <td align="center" valign="middle"><label>
        <input <?php if (!(strcmp($row_DetailRS1['tipo_tasa'],"Fija."))) {echo "checked=\"checked\"";} ?> type="radio" name="tipo_tasa" value="Fija." id="tipo_tasa_0" />
        Fija</label>
        <label>
<input <?php if (!(strcmp($row_DetailRS1['tipo_tasa'],"Variable."))) {echo "checked=\"checked\"";} ?> type="radio" name="tipo_tasa" value="Variable." id="tipo_tasa_1" />
      Variable</label></td>
      <td align="right" valign="middle">Paridad:</td>
      <td align="center" valign="middle"><label>
        <input name="paridad" type="text" class="etiqueta12" id="paridad" value="<?php echo $row_DetailRS1['paridad']; ?>" size="10" maxlength="10" />
        <span class="rojopequeno">0.000000</span></label></td>
    </tr>
  </table>
  <br />
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="4" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" />Datos Financiamiento Banco</td>
    </tr>
    <tr>
      <td width="18%" align="right" valign="middle">Inicio Pago Intereses:</td>
      <td width="40%" align="center" valign="middle"><span id="sprytextfield3">
      <label>
        <input name="inifinbco" type="text" class="etiqueta12" id="inifinbco" value="<?php echo $row_DetailRS1['inifinbco']; ?>" size="12" maxlength="10" />
      </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span><span class="rojopequeno">(aaaa-mm-dd)</span></td>
      <td width="16%" align="right" valign="middle">Vcto Operación:</td>
      <td width="26%" align="center" valign="middle"><span id="sprytextfield4">
      <label>
        <input name="vcto_operacion" type="text" class="etiqueta12" id="vcto_operacion" value="<?php echo $row_DetailRS1['vcto_operacion']; ?>" size="12" maxlength="10" />
      </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span><span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Moneda / Monto Negociación:</td>
      <td align="center" valign="middle"><span id="sprytextfield9">
        <label>
          <select name="moneda_negociacion" class="etiqueta12" id="moneda_negociacion">
            <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_negociacion']))) {echo "selected=\"selected\"";} ?>>CLP</option>
            <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_negociacion']))) {echo "selected=\"selected\"";} ?>>DKK</option>
            <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_negociacion']))) {echo "selected=\"selected\"";} ?>>NOK</option>
            <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_negociacion']))) {echo "selected=\"selected\"";} ?>>SEK</option>
            <option value="USD" selected="selected" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_negociacion']))) {echo "selected=\"selected\"";} ?>>USD</option>
            <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_negociacion']))) {echo "selected=\"selected\"";} ?>>CAD</option>
            <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_negociacion']))) {echo "selected=\"selected\"";} ?>>AUD</option>
            <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_negociacion']))) {echo "selected=\"selected\"";} ?>>HKD</option>
            <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_negociacion']))) {echo "selected=\"selected\"";} ?>>EUR</option>
            <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_negociacion']))) {echo "selected=\"selected\"";} ?>>CHF</option>
            <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_negociacion']))) {echo "selected=\"selected\"";} ?>>GBP</option>
            <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_negociacion']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
            <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_negociacion']))) {echo "selected=\"selected\"";} ?>>JPY</option>
          </select>
          /
  <input name="monto_negociacion" type="text" class="etiqueta12" id="monto_negociacion" value="<?php echo $row_DetailRS1['monto_negociacion']; ?>" size="20" maxlength="20" />
        </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      <td align="right" valign="middle">Tasa Final</td>
      <td align="center" valign="middle"><label>
        <input name="tasa_final" type="text" class="etiqueta12" id="tasa_final" value="<?php echo $row_DetailRS1['tasa_final']; ?>" size="10" maxlength="10" />
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Nro Negociación:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextfield8">
      <label>
        <input name="numero_neg" type="text" class="etiqueta12" id="numero_neg" value="<?php echo $row_DetailRS1['numero_neg']; ?>" size="10" maxlength="5" />
        <span class="rojopequeno">0000</span></label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span></td>
    </tr>
    <tr>
      <td colspan="4" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" />Detalle Gastos</td>
    </tr>
    <tr>
      <td align="right" valign="middle">Monto Intereses:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextfield5">
      <label>
        <input name="monto_inte" type="text" class="etiqueta12" id="monto_inte" value="<?php echo $row_DetailRS1['monto_inte']; ?>" size="20" maxlength="20" />
      </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Gastos Corresponsal:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextfield6">
      <label>
        <input name="gto_corr" type="text" class="etiqueta12" id="gto_corr" value="<?php echo $row_DetailRS1['gto_corr']; ?>" size="20" maxlength="20" />
      </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Comision de Discrepancia:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextfield7">
      <label>
        <input name="com_disc" type="text" class="etiqueta12" id="com_disc" value="<?php echo $row_DetailRS1['con_disc']; ?>" size="20" maxlength="20" />
      </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Cta Cte Nro:</td>
      <td colspan="3" align="left" valign="middle"><label>
        <input name="origen_fondos" type="text" class="etiqueta12" id="origen_fondos" value="<?php echo $row_DetailRS1['origen_fondos']; ?>" size="20" maxlength="20" />
      </label></td>
    </tr>
    <tr>
      <td colspan="4" align="center" valign="middle"><input type="submit" class="boton" value="Ingresar Aviso Plazo Proveedor" /></td>
    </tr>
  </table>
  <br />
<input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>" />
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="ingavisoplazo_mae.php"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen6" width="80" height="25" border="0" id="Imagen6" /></a></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"yyyy-mm-dd", validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"yyyy-mm-dd", validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "date", {format:"yyyy-mm-dd", validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "date", {format:"yyyy-mm-dd", validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "integer", {validateOn:["blur", "change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "integer", {validateOn:["blur", "change"]});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "integer", {validateOn:["blur", "change"]});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "integer", {validateOn:["blur", "change"], minChars:1, maxChars:5, minValue:1, maxValue:999});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "none", {validateOn:["blur", "change"]});
//-->
</script>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>