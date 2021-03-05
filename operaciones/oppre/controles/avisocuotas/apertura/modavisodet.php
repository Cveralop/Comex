<?php require_once('../../../../../Connections/comercioexterior.php'); ?>
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
  $updateSQL = sprintf("UPDATE oppre SET nro_cuotas=%s, impuestos=%s, comisiones=%s, notario=%s, moneda_cargo=%s, cta_cte_cargo=%s, importe_cargo=%s, moneda_abono=%s, cta_cte_abono=%s, importe_abono=%s, otro_abono=%s, obs_avisopago=%s WHERE id=%s",
                       GetSQLValueString($_POST['nro_cuotas'], "int"),
                       GetSQLValueString($_POST['impuestos'], "double"),
                       GetSQLValueString($_POST['comisiones'], "double"),
                       GetSQLValueString($_POST['notario'], "double"),
                       GetSQLValueString($_POST['moneda_cargo'], "text"),
                       GetSQLValueString($_POST['cta_cte_cargo'], "text"),
                       GetSQLValueString($_POST['importe_cargo'], "double"),
                       GetSQLValueString($_POST['moneda_abono'], "text"),
                       GetSQLValueString($_POST['cta_cte_abono'], "text"),
                       GetSQLValueString($_POST['importe_abono'], "double"),
                       GetSQLValueString($_POST['otro_abono'], "text"),
                       GetSQLValueString($_POST['obs_avisopago'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "modavisomae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modificar Aviso Cuota Apertura - Detalle</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../../../imagenes/JPEG/edificio_corporativo.jpg);
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
<link href="../../../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body onload="MM_preloadImages('../../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">INGRESO AVISO CUOTA APERTURA - DETALLE</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../../../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="subtitulopaguina">Modificación de Aviso Cuota</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap">Nro Registro:</td>
      <td align="center" valign="middle" class="nroregistro"><?php echo $row_DetailRS1['id']; ?></td>
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle"><input name="rut_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['rut_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="17" maxlength="15" />
        <span class="rojopequeno">Sin Puntos ni Guión</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['nombre_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="122" maxlength="120" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap">Nro Operación:</td>
      <td align="center" valign="middle"><input name="nro_operacion" type="text" disabled="disabled" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['nro_operacion'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="7" />
        <span class="rojopequeno">F000000</span></td>
      <td align="right" valign="middle">Moneda / Monto Operación:</td>
      <td align="center" valign="middle"><input name="moneda_operacion" type="text" disabled="disabled" class="etiqueta12" id="moneda_operacion" value="<?php echo $row_DetailRS1['moneda_operacion']; ?>" size="5" maxlength="3" /> 
        / 
        <input name="monto_operacion" type="text" disabled="disabled" class="etiqueta12" id="monto_operacion" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><span class="subtitulopaguina">Gastos y Nro de Cuotas</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Impuestos:</td>
      <td align="center" valign="middle"><input name="impuestos" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['impuestos'], ENT_COMPAT, 'utf-8'); ?>" size="20" maxlength="20" /></td>
      <td align="right" valign="middle">Comisiones:</td>
      <td align="center" valign="middle"><input name="comisiones" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['comisiones'], ENT_COMPAT, 'utf-8'); ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Notario:</td>
      <td align="center" valign="middle"><input name="notario" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['notario'], ENT_COMPAT, 'utf-8'); ?>" size="20" maxlength="20" /></td>
      <td align="right" valign="middle">Nro Cuotas:</td>
      <td align="center" valign="middle"><input name="nro_cuotas" type="text" class="etiqueta12" id="nro_cuotas" value="<?php echo $row_DetailRS1['nro_cuotas']; ?>" size="6" maxlength="3" />
        <span class="rojopequeno">000</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Tipo Operación:</td>
      <td align="center" valign="middle"><select name="tipo_operacion" class="etiqueta12" id="tipo_operacion">
        <option value="Confirming." <?php if (!(strcmp("Confirming.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Confirming</option>
        <option value="Forfaiting." <?php if (!(strcmp("Forfaiting.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Forfaiting</option>
        <option value="PAE." <?php if (!(strcmp("PAE.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>PAE</option>
        <option value="PAE Cobex." <?php if (!(strcmp("PAE Cobex.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>PAE Cobex</option>
        <option value="PAE SGR." <?php if (!(strcmp("PAE SGR.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>PAE SGR</option>
        <option value="Finan. Contado." <?php if (!(strcmp("Finan. Contado.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Finan. Contado</option>
        <option value="Finan. Contado COBEX." <?php if (!(strcmp("Finan. Contado COBEX.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Finan. Contado COBEX</option>
        <option value="Finan. Contado SGR." <?php if (!(strcmp("Finan. Contado SGR.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Finan. Contado SGR</option>
        <option value="Credito Comercial." <?php if (!(strcmp("Credito Comercial.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Credito Comercial</option>
        <option value="Credito Comercial COBEX." <?php if (!(strcmp("Credito Comercial COBEX.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Credito Comercial COBEX</option>
        <option value="Credito Comercial SGR." <?php if (!(strcmp("Credito Comercial SGR.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Credito Comercial SGR</option>
        <option value="Prestamo LCI." <?php if (!(strcmp("Prestamo LCI.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Prestamo LCI</option>
        <option value="Cartera Vencida." <?php if (!(strcmp("Cartera Vencida.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Cartera Vencida</option>
      </select></td>
      <td align="right" valign="middle">Tipo Tasa / Periodisidad:</td>
      <td align="center" valign="middle"><select name="tipo_tasa" class="etiqueta12" id="tipo_tasa">
        <option value="Fija." <?php if (!(strcmp("Fija.", $row_DetailRS1['tipo_tasa']))) {echo "selected=\"selected\"";} ?>>Fija</option>
<option value="Variable." <?php if (!(strcmp("Variable.", $row_DetailRS1['tipo_tasa']))) {echo "selected=\"selected\"";} ?>>Variable</option>
      </select> 
        / <span class="rojopequeno">
        <select name="periodisidad" class="etiqueta12" id="periodisidad">
          <option value="0" <?php if (!(strcmp(0, $row_DetailRS1['periodisidad']))) {echo "selected=\"selected\"";} ?>>No Aplica</option>
          <option value="30" <?php if (!(strcmp(30, $row_DetailRS1['periodisidad']))) {echo "selected=\"selected\"";} ?>>Mensual</option>
          <option value="60" <?php if (!(strcmp(60, $row_DetailRS1['periodisidad']))) {echo "selected=\"selected\"";} ?>>Bimensual</option>
          <option value="90" <?php if (!(strcmp(90, $row_DetailRS1['periodisidad']))) {echo "selected=\"selected\"";} ?>>Trimestral</option>
          <option value="120" <?php if (!(strcmp(120, $row_DetailRS1['periodisidad']))) {echo "selected=\"selected\"";} ?>>Cuatrimestral</option>
          <option value="180" <?php if (!(strcmp(180, $row_DetailRS1['periodisidad']))) {echo "selected=\"selected\"";} ?>>Semestral</option>
          <option value="360" <?php if (!(strcmp(360, $row_DetailRS1['periodisidad']))) {echo "selected=\"selected\"";} ?>>Anual</option>
        </select>
        </span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><span class="subtitulopaguina">Origen de los Gastos y Destinos de los Fondos</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Moneda de Cargo:</td>
      <td align="center" valign="middle"><select name="moneda_cargo" class="etiqueta12" id="moneda_cargo">
          <option value="$" <?php if (!(strcmp("$", $row_DetailRS1['moneda_cargo']))) {echo "selected=\"selected\"";} ?>>$</option>
          <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_cargo']))) {echo "selected=\"selected\"";} ?>>DKK</option>
          <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_cargo']))) {echo "selected=\"selected\"";} ?>>NOK</option>
<option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_cargo']))) {echo "selected=\"selected\"";} ?>>SEK</option>
<option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_cargo']))) {echo "selected=\"selected\"";} ?>>USD</option>
<option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_cargo']))) {echo "selected=\"selected\"";} ?>>CAD</option>
          <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_cargo']))) {echo "selected=\"selected\"";} ?>>AUD</option>
          <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_cargo']))) {echo "selected=\"selected\"";} ?>>HKD</option>
          <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_cargo']))) {echo "selected=\"selected\"";} ?>>EUR</option>
<option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_cargo']))) {echo "selected=\"selected\"";} ?>>CHF</option>
<option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_cargo']))) {echo "selected=\"selected\"";} ?>>GBP</option>
<option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_cargo']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
<option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_cargo']))) {echo "selected=\"selected\"";} ?>>JPY</option>
      </select></td>
      <td align="right" valign="middle">Moneda de Abono:</td>
      <td align="center" valign="middle"><select name="moneda_abono" class="etiqueta12" id="moneda_abono">
        <option value="$" <?php if (!(strcmp("$", $row_DetailRS1['moneda_abono']))) {echo "selected=\"selected\"";} ?>>$</option>
        <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_abono']))) {echo "selected=\"selected\"";} ?>>DKK</option>
        <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_abono']))) {echo "selected=\"selected\"";} ?>>NOK</option>
        <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_abono']))) {echo "selected=\"selected\"";} ?>>SEK</option>
        <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_abono']))) {echo "selected=\"selected\"";} ?>>USD</option>
        <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_abono']))) {echo "selected=\"selected\"";} ?>>CAD</option>
        <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_abono']))) {echo "selected=\"selected\"";} ?>>AUD</option>
        <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_abono']))) {echo "selected=\"selected\"";} ?>>HKD</option>
        <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_abono']))) {echo "selected=\"selected\"";} ?>>EUR</option>
        <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_abono']))) {echo "selected=\"selected\"";} ?>>CHF</option>
        <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_abono']))) {echo "selected=\"selected\"";} ?>>GBP</option>
        <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_abono']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
<option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_abono']))) {echo "selected=\"selected\"";} ?>>JPY</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Cta Cte de Cargo:</td>
      <td align="center" valign="middle"><input name="cta_cte_cargo" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['cta_cte_cargo'], ENT_COMPAT, 'utf-8'); ?>" size="20" maxlength="20" /></td>
      <td align="right" valign="middle">Cta Cte de Abono:</td>
      <td align="center" valign="middle"><input name="cta_cte_abono" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['cta_cte_abono'], ENT_COMPAT, 'utf-8'); ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Importe de Cargo:</td>
      <td align="center" valign="middle"><input name="importe_cargo" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['importe_cargo'], ENT_COMPAT, 'utf-8'); ?>" size="20" maxlength="20" />
        <span class="rojopequeno">0.00</span></td>
      <td align="right" valign="middle">Importe de Abono:</td>
      <td align="center" valign="middle"><input name="importe_abono" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['importe_abono'], ENT_COMPAT, 'utf-8'); ?>" size="20" maxlength="20" />
        <span class="rojopequeno">0.00</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Subir Aviso:</td>
      <td align="center" valign="middle"><a href="../../../../../archivos/carpeta_virtual/prestamo/aviso_cuota.php" target="_blank">Ir a Subir Aviso</a></td>
      <td align="right" valign="middle">Otro Forma de Salida:</td>
      <td align="center" valign="middle"><select name="otro_abono" class="etiqueta12" id="otro_abono">
        <option value="." selected="selected" <?php if (!(strcmp(".", $row_DetailRS1['otro_abono']))) {echo "selected=\"selected\"";} ?>>No Aplica</option>
        <option value="Envio de Orden de Pago." <?php if (!(strcmp("Envio de Orden de Pago.", $row_DetailRS1['otro_abono']))) {echo "selected=\"selected\"";} ?>>Envio de Orden de Pago</option>
        <option value="Abono a Sucursal." <?php if (!(strcmp("Abono a Sucursal.", $row_DetailRS1['otro_abono']))) {echo "selected=\"selected\"";} ?>>Abono a Sucursal</option>
<option value="Emision de Cheque." <?php if (!(strcmp("Emision de Cheque.", $row_DetailRS1['otro_abono']))) {echo "selected=\"selected\"";} ?>>Emision de Cheque</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Observación Aviso:</td>
      <td colspan="3" align="left" valign="middle"><textarea name="obs_avisopago" cols="85" rows="3" class="etiqueta12">Sirvase encontrar cuadro de pago en anexo adjunto.</textarea></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle"><input type="submit" class="etiqueta12" value="Actualizar Aviso Cuota Apertura" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>" />
</form>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="modavisomae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen4','','../../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen4" width="80" height="25" border="0" id="Imagen4" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>