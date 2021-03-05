<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "SUP,ADM";
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
$query_DetailRS1 = sprintf("SELECT * FROM excepciones nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE excepciones SET rut_cliente=%s, nombre_cliente=%s, evento=%s, producto=%s, nro_operacion=%s, nro_operacion_relacionada=%s, moneda_operacion=%s, monto_operacion=%s, autorizacion_operaciones=%s, autorizacion_especialista=%s, responsable_excepcion=%s, tipo_excepcion=%s, vcto_excepcion=%s WHERE id=%s",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['producto'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['nro_operacion_relacionada'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['autorizacion_operaciones'], "text"),
                       GetSQLValueString($_POST['autorizacion_especialista'], "text"),
                       GetSQLValueString($_POST['responsable_excepcion'], "text"),
                       GetSQLValueString($_POST['tipo_excepcion'], "text"),
                       GetSQLValueString($_POST['vcto_excepcion'], "date"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "mantencion_excepcion_mae.php";
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
<title>Mantencion Excepciones Administrativas - Maestro</title>
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
-->
</style>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">MANTENCION EXCEPCIONES ADMINISTRATIVAS - DETALLE</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">EXCEPCIONES</td>
  </tr>
</table>
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" />Detalle Mantención Excepciones</td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nro Registro:</td>
      <td align="center" valign="middle" class="nroregistro"><?php echo $row_DetailRS1['id']; ?></td>
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['rut_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="17" maxlength="15" readonly="readonly" />
        <span class="rojopequeno">Sin Puntos ni Guión</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['nombre_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="center" valign="middle"><input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['fecha_ingreso'], ENT_COMPAT, 'utf-8'); ?>" size="12" maxlength="10" />
      <span class="rojopequeno">(dd-mm-aaaa)</span></td>
      <td align="right" valign="middle">Moneda / Monto Operación:</td>
      <td align="center" valign="middle"><select name="moneda_operacion" class="etiqueta12" id="moneda_operacion">
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
<input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['monto_operacion'], ENT_COMPAT, 'utf-8'); ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Evento:</td>
      <td align="center" valign="middle"><select name="evento" class="etiqueta12" id="evento2">
        <option value="Sin Dato." selected="selected" <?php if (!(strcmp("Sin Dato.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Seleccione un Evento</option>
        <option value="Envio OP." <?php if (!(strcmp("Envio OP.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Envio OP</option>
        <option value="Compra." <?php if (!(strcmp("Compra.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Compra</option>
        <option value="Venta." <?php if (!(strcmp("Venta.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Venta</option>
        <option value="Arbitraje." <?php if (!(strcmp("Arbitraje.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Arbitraje</option>
        <option value="Liq Op. Recibida." <?php if (!(strcmp("Liq Op. Recibida.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Liq Op. Recibida</option>
        <option value="Emision Planilla." <?php if (!(strcmp("Emision Planilla.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Emision Planilla</option>
        <option value="Otorgamiento Prestamo." <?php if (!(strcmp("Otorgamiento Prestamo.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Otorgamiento Prestamo</option>
        <option value="Prorroga y Pago Prestamo." <?php if (!(strcmp("Prorroga y Pago Prestamo.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Prorroga y Pago Prestamo</option>
        <option value="Prorroga Prestamo." <?php if (!(strcmp("Prorroga Prestamo.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Prorroga Prestamo</option>
        <option value="Pago Prestamo." <?php if (!(strcmp("Pago Prestamo.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pago Prestamo</option>
        <option value="Apertura Cart. Cred. Import." <?php if (!(strcmp("Apertura Cart. Cred. Import.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Apertura Cart. Cred. Import.</option>
        <option value="Modificacion Cart. Cred. Import." <?php if (!(strcmp("Modificacion Cart. Cred. Import.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Modificacion Cart. Cred. Import.</option>
        <option value="Pago Cart. Cred. Import." <?php if (!(strcmp("Pago Cart. Cred. Import.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pago Cart. Cred. Import.</option>
        <option value="Liq. de Retorno." <?php if (!(strcmp("Liq. de Retorno.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Liq. de Retorno</option>
        <option value="Apertura Cob. Import." <?php if (!(strcmp("Apertura Cob. Import.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Apertura Cob. Import.</option>
        <option value="Modificacion Cob. Import." <?php if (!(strcmp("Modificacion Cob. Import.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Modificacion Cob. Import.</option>
        <option value="Pago Cob. Import." <?php if (!(strcmp("Pago Cob. Import.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pago Cob. Import.</option>
        <option value="Apertura y Pago OPI." <?php if (!(strcmp("Apertura y Pago OPI.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Apertura y Pago OPI</option>
        <option value="Apertura OPI." <?php if (!(strcmp("Apertura OPI.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Apertura OPI</option>
        <option value="Modificacion OPI." <?php if (!(strcmp("Modificacion OPI.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Modificacion OPI</option>
        <option value="Pago OPI." <?php if (!(strcmp("Pago OPI.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pago OPI</option>
        <option value="Boleta de Garantia." <?php if (!(strcmp("Boleta de Garantia.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Boleta de Garantia</option>
<option value="Stand By Emitida." <?php if (!(strcmp("Stand By Emitida.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Stand By Emitida</option>
<option value="Credito IIIB5." <?php if (!(strcmp("Credito IIIB5.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Credito IIIB5</option>
<option value="Otro." <?php if (!(strcmp("Otro.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Otro</option>
      </select></td>
      <td align="right" valign="middle">Producto:</td>
      <td align="center" valign="middle"><select name="producto" class="etiqueta12" id="evento">
        <option value="Sin Dato" selected="selected" <?php if (!(strcmp("Sin Dato", $row_DetailRS1['producto']))) {echo "selected=\"selected\"";} ?>>Seleccione un Produco</option>
        <option value="Boleta de Garantia" <?php if (!(strcmp("Boleta de Garantia", $row_DetailRS1['producto']))) {echo "selected=\"selected\"";} ?>>Boleta de Garantia</option>
<option value="Cobranza Extranjera de Export" <?php if (!(strcmp("Cobranza Extranjera de Export", $row_DetailRS1['producto']))) {echo "selected=\"selected\"";} ?>>Cobranza Extranjera de Export</option>
        <option value="Cobranza Extranjera de Import" <?php if (!(strcmp("Cobranza Extranjera de Import", $row_DetailRS1['producto']))) {echo "selected=\"selected\"";} ?>>Cobranza Extranjera de Import</option>
        <option value="Carta de Credito Export" <?php if (!(strcmp("Carta de Credito Export", $row_DetailRS1['producto']))) {echo "selected=\"selected\"";} ?>>Carta de Credito Export</option>
        <option value="Carta de Credito Import" <?php if (!(strcmp("Carta de Credito Import", $row_DetailRS1['producto']))) {echo "selected=\"selected\"";} ?>>Carta de Credito Import</option>
        <option value="Cecion Derecho/Pago Anti" <?php if (!(strcmp("Cecion Derecho/Pago Anti", $row_DetailRS1['producto']))) {echo "selected=\"selected\"";} ?>>Cecion Derecho/Pago Anti</option>
        <option value="Credito Externo (DL600-CapXIII-CAPXIV)" <?php if (!(strcmp("Credito Externo (DL600-CapXIII-CAPXIV)", $row_DetailRS1['producto']))) {echo "selected=\"selected\"";} ?>>Credito Externo (DL600-CapXIII-CAPXIV)</option>
        <option value="Mercado Corredores" <?php if (!(strcmp("Mercado Corredores", $row_DetailRS1['producto']))) {echo "selected=\"selected\"";} ?>>Mercado Corredores</option>
        <option value="Prestamos Stand Alone" <?php if (!(strcmp("Prestamos Stand Alone", $row_DetailRS1['producto']))) {echo "selected=\"selected\"";} ?>>Prestamos Stand Alone</option>
        <option value="L/C Stand By Emitida" <?php if (!(strcmp("L/C Stand By Emitida", $row_DetailRS1['producto']))) {echo "selected=\"selected\"";} ?>>L/C Stand By Emitida</option>
        <option value="L/C Stand By Recibida" <?php if (!(strcmp("L/C Stand By Recibida", $row_DetailRS1['producto']))) {echo "selected=\"selected\"";} ?>>L/C Stand By Recibida</option>
        <option value="Credito IIIB5" <?php if (!(strcmp("Credito IIIB5", $row_DetailRS1['producto']))) {echo "selected=\"selected\"";} ?>>Credito IIIB5</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nro Operación:</td>
      <td align="center" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['nro_operacion'], ENT_COMPAT, 'utf-8'); ?>" size="10" maxlength="7" />
      <span class="rojopequeno">F, K, L, J o B000000</span></td>
      <td align="right" valign="middle">Nro Operacion Relacionada:</td>
      <td align="center" valign="middle"><input name="nro_operacion_relacionada" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['nro_operacion_relacionada'], ENT_COMPAT, 'utf-8'); ?>" size="10" maxlength="7" />
      <span class="rojopequeno">F, K, L, J o B000000</span></td>
    </tr>
    <tr valign="baseline">
      <td rowspan="4" align="right" valign="middle">Vcto Excepción:</td>
      <td rowspan="4" align="center" valign="middle"><span id="sprytextfield5">
      <input name="vcto_excepcion" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['vcto_excepcion'], ENT_COMPAT, 'utf-8'); ?>" size="12" maxlength="10" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span><span class="rojopequeno">(aaaa-mm-dd)</span></td>
      <td align="right" valign="middle">Tipo Excepción:</td>
      <td align="center" valign="middle"><span id="sprytextfield1">
        <input name="tipo_excepcion" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['tipo_excepcion'], ENT_COMPAT, 'utf-8'); ?>" size="30" maxlength="50" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Autorizacion Operaciones:</td>
      <td align="center" valign="middle"><span id="sprytextfield2">
        <input name="autorizacion_operaciones" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['autorizacion_operaciones'], ENT_COMPAT, 'utf-8'); ?>" size="30" maxlength="50" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Autorizacion Especialista:</td>
      <td align="center" valign="middle"><span id="sprytextfield3">
        <input name="autorizacion_especialista" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['autorizacion_especialista'], ENT_COMPAT, 'utf-8'); ?>" size="30" maxlength="50" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Responsable Excepción:</td>
      <td align="center" valign="middle"><span id="sprytextfield4">
        <input name="responsable_excepcion" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['responsable_excepcion'], ENT_COMPAT, 'utf-8'); ?>" size="30" maxlength="50" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle"><input type="submit" class="boton" value="Actualizar Excepción" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>" />
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="mantencion_excepcion_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "date", {format:"yyyy-mm-dd", validateOn:["blur", "change"]});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>