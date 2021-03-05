<?php require_once('../../../../../Connections/comercioexterior.php'); ?>
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
$MM_restrictGoTo = "../../../erroracceso.php";
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
$query_DetailRS1 = sprintf("SELECT * FROM oppre nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE oppre SET estado=%s, fecha_curse=%s, date_curse=%s, obs=%s, sub_estado=%s, date_oper=%s, date_supe=%s, fecha_pago=%s, moneda_saldo_insoluto=%s, saldo_insoluto=%s, moneda_valor_cuota=%s, valor_cuota=%s, moneda_intereses=%s, intereses=%s, impuestos=%s, moneda_comisiones=%s, comisiones=%s, tipo_cambio=%s, cta_cte_mn=%s, importe_cta_cte_mn=%s, cta_cte_mx=%s, importe_cta_cte_mx=%s, cheque_otro=%s, cheque=%s, importe_cheque=%s, fecha_desde=%s, fecha_hasta=%s, tasa=%s, obs_avisopago=%s WHERE id=%s",
                       GetSQLValueString($_POST['sub_estado'], "text"),
                       GetSQLValueString($_POST['fecha_curse'], "text"),
                       GetSQLValueString($_POST['date_curse'], "date"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['sub_estado'], "text"),
                       GetSQLValueString($_POST['date_oper'], "date"),
                       GetSQLValueString($_POST['date_oper'], "date"),
                       GetSQLValueString($_POST['fecha_pago'], "text"),
                       GetSQLValueString($_POST['moneda_saldo_insoluto'], "text"),
                       GetSQLValueString($_POST['saldo_insoluto'], "double"),
                       GetSQLValueString($_POST['moneda_valor_cuota'], "text"),
                       GetSQLValueString($_POST['valor_cuota'], "double"),
                       GetSQLValueString($_POST['moneda_intereses'], "text"),
                       GetSQLValueString($_POST['intereses'], "double"),
                       GetSQLValueString($_POST['impuestos'], "double"),
                       GetSQLValueString($_POST['moneda_comisiones'], "text"),
					   GetSQLValueString($_POST['comisiones'], "double"),
                       GetSQLValueString($_POST['tipo_cambio'], "double"),
                       GetSQLValueString($_POST['cta_cte_mn'], "text"),
                       GetSQLValueString($_POST['importe_cta_cte_mn'], "double"),
                       GetSQLValueString($_POST['cta_cte_mx'], "text"),
                       GetSQLValueString($_POST['importe_cta_cte_mx'], "double"),
                       GetSQLValueString($_POST['cheque_otro'], "text"),
                       GetSQLValueString($_POST['cheque'], "text"),
                       GetSQLValueString($_POST['importe_cheque'], "double"),
                       GetSQLValueString($_POST['fecha_desde'], "text"),
                       GetSQLValueString($_POST['fecha_hasta'], "text"),
                       GetSQLValueString($_POST['tasa'], "double"),
                       GetSQLValueString($_POST['obs_avisopago'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "avicuomae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Confecci&oacute;n Aviso Cuotas - Detalle</title>
<style type="text/css">
<!--
@import url(../../../../../estilos/estilo12.css);
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../../../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo5 {	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script src="../../../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../../../SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<script src="../../../../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<link href="../../../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../../../../../SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
<link href="../../../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CONFECION AVISO CUOTAS - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" onSubmit="MM_validateForm('nro_operacion','','R','fecha_curse','','R','nro_cuotas','','RinRange1:40');return document.MM_returnValue">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="6" align="left"><span class="Estilo5"><img src="../../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo5"> Detalle Aviso Cuotas</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Operaci&oacute;n:</td>
      <td align="center"><span id="sprytextfield1">
      <input name="nro_operacion" type="text" disabled class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="15" maxlength="7"> 
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">No se cumple el m�nimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span><span class="rojopequeno"> K/L o F000000</span></div></td>
      <td align="right">Rut Cliente:</div></td>
      <td colspan="3" align="center">
          <input name="rut_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15">
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nombre Cliente:</td>
      <td colspan="5" align="left"><input name="nombre_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Fecha Pago:</td>
      <td align="center">
          <input name="fecha_pago" type="text" class="etiqueta12" id="fecha_pago" value="<?php echo $row_DetailRS1['fecha_pago']; ?>" size="12" maxlength="10"> 
      <span class="rojopequeno">(dd-mm-aaaa)</span></div></td>
      <td align="right">Saldo Insoluto:</div></td>
      <td align="center"><label>
        <select name="moneda_saldo_insoluto" class="etiqueta12" id="moneda_saldo_insoluto">
          <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_saldo_insoluto']))) {echo "selected=\"selected\"";} ?>>CLP</option>
          <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_saldo_insoluto']))) {echo "selected=\"selected\"";} ?>>DKK</option>
          <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_saldo_insoluto']))) {echo "selected=\"selected\"";} ?>>NOK</option>
          <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_saldo_insoluto']))) {echo "selected=\"selected\"";} ?>>SEK</option>
          <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_saldo_insoluto']))) {echo "selected=\"selected\"";} ?>>USD</option>
          <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_saldo_insoluto']))) {echo "selected=\"selected\"";} ?>>CAD</option>
          <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_saldo_insoluto']))) {echo "selected=\"selected\"";} ?>>AUD</option>
          <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_saldo_insoluto']))) {echo "selected=\"selected\"";} ?>>HKD</option>
          <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_saldo_insoluto']))) {echo "selected=\"selected\"";} ?>>EUR</option>
          <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_saldo_insoluto']))) {echo "selected=\"selected\"";} ?>>CHF</option>
          <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_saldo_insoluto']))) {echo "selected=\"selected\"";} ?>>GBP</option>
          <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_saldo_insoluto']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
          <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_saldo_insoluto']))) {echo "selected=\"selected\"";} ?>>JPY</option>
        </select>
/
<input name="saldo_insoluto" type="text" class="etiqueta12" id="saldo_insoluto" value="<?php echo $row_DetailRS1['saldo_insoluto']; ?>" size="20" maxlength="20">
      </label>        </div></td>
      <td align="right">Valor Cuota:</td>
      <td align="center"><select name="moneda_valor_cuota" class="etiqueta12" id="moneda_valor_cuota">
        <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_valor_cuota']))) {echo "selected=\"selected\"";} ?>>CLP</option>
        <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_valor_cuota']))) {echo "selected=\"selected\"";} ?>>DKK</option>
        <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_valor_cuota']))) {echo "selected=\"selected\"";} ?>>NOK</option>
        <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_valor_cuota']))) {echo "selected=\"selected\"";} ?>>SEK</option>
        <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_valor_cuota']))) {echo "selected=\"selected\"";} ?>>USD</option>
        <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_valor_cuota']))) {echo "selected=\"selected\"";} ?>>CAD</option>
        <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_valor_cuota']))) {echo "selected=\"selected\"";} ?>>AUD</option>
        <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_valor_cuota']))) {echo "selected=\"selected\"";} ?>>HKD</option>
        <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_valor_cuota']))) {echo "selected=\"selected\"";} ?>>EUR</option>
        <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_valor_cuota']))) {echo "selected=\"selected\"";} ?>>CHF</option>
        <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_valor_cuota']))) {echo "selected=\"selected\"";} ?>>GBP</option>
        <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_valor_cuota']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
        <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_valor_cuota']))) {echo "selected=\"selected\"";} ?>>JPY</option>
      </select> 
      /        <input name="valor_cuota" type="text" class="etiqueta12" id="valor_cuota" value="<?php echo $row_DetailRS1['valor_cuota']; ?>" size="20" maxlength="20"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Intereses:</td>
      <td align="center"><select name="moneda_intereses" class="etiqueta12" id="moneda_intereses">
        <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_intereses']))) {echo "selected=\"selected\"";} ?>>CLP</option>
        <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_intereses']))) {echo "selected=\"selected\"";} ?>>DKK</option>
        <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_intereses']))) {echo "selected=\"selected\"";} ?>>NOK</option>
        <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_intereses']))) {echo "selected=\"selected\"";} ?>>SEK</option>
        <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_intereses']))) {echo "selected=\"selected\"";} ?>>USD</option>
        <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_intereses']))) {echo "selected=\"selected\"";} ?>>CAD</option>
        <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_intereses']))) {echo "selected=\"selected\"";} ?>>AUD</option>
        <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_intereses']))) {echo "selected=\"selected\"";} ?>>HKD</option>
        <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_intereses']))) {echo "selected=\"selected\"";} ?>>EUR</option>
        <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_intereses']))) {echo "selected=\"selected\"";} ?>>CHF</option>
        <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_intereses']))) {echo "selected=\"selected\"";} ?>>GBP</option>
        <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_intereses']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
        <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_intereses']))) {echo "selected=\"selected\"";} ?>>JPY</option>
      </select> 
                 /
      <input name="intereses" type="text" class="etiqueta12" id="intereses" value="<?php echo $row_DetailRS1['intereses']; ?>" size="20" maxlength="20"></td>
      <td align="right">Impuestos: </td>
      <td align="center"><input name="impuestos" type="text" class="etiqueta12" id="impuestos" value="<?php echo $row_DetailRS1['impuestos']; ?>" size="20" maxlength="20"></td>
      <td align="right">Comisiones:</td>
      <td align="center"><select name="moneda_comisiones" class="etiqueta12" id="moneda_comisiones">
        <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_comisiones']))) {echo "selected=\"selected\"";} ?>>CLP</option>
        <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_comisiones']))) {echo "selected=\"selected\"";} ?>>DKK</option>
        <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_comisiones']))) {echo "selected=\"selected\"";} ?>>NOK</option>
        <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_comisiones']))) {echo "selected=\"selected\"";} ?>>SEK</option>
        <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_comisiones']))) {echo "selected=\"selected\"";} ?>>USD</option>
        <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_comisiones']))) {echo "selected=\"selected\"";} ?>>CAD</option>
        <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_comisiones']))) {echo "selected=\"selected\"";} ?>>AUD</option>
        <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_comisiones']))) {echo "selected=\"selected\"";} ?>>HKD</option>
        <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_comisiones']))) {echo "selected=\"selected\"";} ?>>EUR</option>
        <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_comisiones']))) {echo "selected=\"selected\"";} ?>>CHF</option>
        <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_comisiones']))) {echo "selected=\"selected\"";} ?>>GBP</option>
        <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_comisiones']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
        <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_comisiones']))) {echo "selected=\"selected\"";} ?>>JPY</option>
      </select> 
      /         <input name="comisiones" type="text" class="etiqueta12" id="comisiones" value="<?php echo $row_DetailRS1['comisiones']; ?>" size="20" maxlength="20"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Cta Cte M/N:</td>
      <td align="center"></div>
      <input name="cta_cte_mn" type="text" class="etiqueta12" id="cta_cte_mn" value="<?php echo $row_DetailRS1['cta_cte_mn']; ?>" size="20" maxlength="20"></td>
      <td align="right">Importe Cta Cte M/N: </td>
      <td align="center"></div>
      <input name="importe_cta_cte_mn" type="text" class="etiqueta12" id="importe_cta_cte_mn" value="<?php echo $row_DetailRS1['importe_cta_cte_mn']; ?>" size="20" maxlength="20">        </div></td>
      <td align="right">T/C:</td>
      <td align="center"><input name="tipo_cambio" type="text" class="etiqueta12" id="tipo_cambio" value="<?php echo $row_DetailRS1['tipo_cambio']; ?>" size="10" maxlength="10"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Cte Cte M/X:</td>
      <td align="center"><input name="cta_cte_mx" type="text" class="etiqueta12" id="cta_cte_mx" value="<?php echo $row_DetailRS1['cta_cte_mx']; ?>" size="20" maxlength="20">        </div></td>
      <td align="right">Importe Cta Cte M/X:</td>
      <td align="center"><input name="importe_cta_cte_mx" type="text" class="etiqueta12" id="importe_cta_cte_mx" value="<?php echo $row_DetailRS1['importe_cta_cte_mx']; ?>" size="20" maxlength="20"></td>
      <td align="right">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <tr valign="middle">
      <td align="right">Pago Cheque / Otro:</td>
      <td align="center"><label>
        <select name="cheque_otro" class="etiqueta12" id="cheque_otro">
          <option value="Cheque" selected>Cheque</option>
          <option value="Ingreso por Caja">Ingreso por Caja</option>
          <option value="Otra (Ver Obs.)">Otro</option>
        </select>
      </label></td>
      <td align="right">Cheque Nro:</td>
      <td align="center"><input name="cheque" type="text" class="etiqueta12" id="cheque" value="<?php echo $row_DetailRS1['cheque']; ?>" size="20" maxlength="20">
      <span class="rojopequeno">(Opcional)</span></td>
      <td align="right">Importe Cheque u  Otro:</td>
      <td align="center"><label>
        <input name="importe_cheque" type="text" class="etiqueta12" id="importe_cheque" value="<?php echo $row_DetailRS1['importe_cheque']; ?>" size="20" maxlength="20">
      </label></td>
    </tr>
    <tr valign="middle">
      <td align="right">Fecha Desde:</td>
      <td align="center"><input name="fecha_desde" type="text" class="etiqueta12" id="fecha_desde" value="<?php echo $row_DetailRS1['fecha_desde']; ?>" size="12" maxlength="10">
      <span class="rojopequeno">(dd-mm-aaaa)</span></td>
      <td align="right">Fecha Hasta:</td>
      <td align="center"><input name="fecha_hasta" type="text" class="etiqueta12" id="fecha_hasta" value="<?php echo $row_DetailRS1['fecha_hasta']; ?>" size="12" maxlength="10">
      <span class="rojopequeno">(dd-mm-aaaa)</span></td>
      <td align="right">Tasa:</td>
      <td align="center"><input name="tasa" type="text" class="etiqueta12" id="tasa" value="<?php echo $row_DetailRS1['tasa']; ?>" size="10" maxlength="10"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Observaciones:</td>
      <td colspan="5" align="left"><span id="sprytextarea2">
      <label>
        <textarea name="obs_avisopago" cols="84" rows="4" class="etiqueta12" id="obs_avisopago"><?php echo $row_DetailRS1['obs_avisopago']; ?></textarea>
        <span class="rojopequeno"><span id="countsprytextarea2">&nbsp;</span></label>
<span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle">
      <td colspan="6" align="center"><input type="submit" class="boton" value="Guardar Aviso Cuota"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
  <input name="date_oper" type="hidden" id="date_oper" value="<?php echo date("Y-m-d H:i:s"); ?>">
  <input name="fecha_curse" type="hidden" id="fecha_curse" value="<?php echo date("d-m-Y"); ?>">
  <input name="date_curse" type="hidden" id="date_curse" value="<?php echo date("Y-m-d"); ?>">
  <input name="sub_estado" type="hidden" id="sub_estado" value="Cursada.">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="avicuomae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea2", counterType:"chars_remaining"});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>