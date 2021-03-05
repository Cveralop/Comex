<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
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
$query_DetailRS1 = sprintf("SELECT * FROM oppre nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE oppre SET evento=%s, estado=%s, fecha_curse=%s, date_curse=%s, operador=%s, nro_operacion=%s, nro_operacion_relacionada=%s, obs=%s, moneda_operacion=%s, monto_operacion=%s, nro_cuotas=%s, pagare=%s, sub_estado=%s, fecha_curse_inicial=%s, tasa_variable=%s, cuota_int=%s, periodisidad=%s, cancelacion_total=%s, dus=%s, vcto_operacion=%s, vi=%s, iteraciones=%s, date_supe=%s, tipo_operacion=%s, autorizador=%s, reparo_obs=%s, urgente=%s, fuera_horario=%s, pago_automatico=%s WHERE id=%s",
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['fecha_curse'], "text"),
                       GetSQLValueString($_POST['date_curse'], "date"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['nro_operacion_relacionada'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['nro_cuotas'], "int"),
                       GetSQLValueString($_POST['pagare'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['date_curse'], "date"),
                       GetSQLValueString(isset($_POST['tasa_variable']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['cuota_int']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['periodisidad'], "text"),
                       GetSQLValueString(isset($_POST['cancelacion_total']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['dus']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['vcto_operacion'], "date"),
                       GetSQLValueString($_POST['vi'], "text"),
                       GetSQLValueString($_POST['iteraciones'], "int"),
                       GetSQLValueString($_POST['date_supe'], "date"),
                       GetSQLValueString($_POST['tipo_operacion'], "text"),
                       GetSQLValueString($_POST['autorizador'], "text"),
                       GetSQLValueString($_POST['reparo_obs'], "text"),
                       GetSQLValueString($_POST['urgente'], "text"),
                       GetSQLValueString($_POST['fuera_horario'], "text"),
                       GetSQLValueString($_POST['pago_automatico'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "altamae.php";
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
<title>Alta Operaciones - Detalle</title>
<style type="text/css">
<!--
@import url(../../../../estilos/estilo12.css);
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
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo5 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {
	font-size: 14px;
	font-weight: bold;
	color: #FF0000;
}
-->
</style>
<script src="../../../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
<link href="../../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<br>
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">ALTA OPERACIONES SUPERVISOR - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" onSubmit="MM_validateForm('nro_operacion','','R','fecha_curse','','R','nro_cuotas','','RinRange1:40');return document.MM_returnValue">
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="8" align="left"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo5">Alta Operaciones Supervisor</span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Operaci&oacute;n:</td>
      <td align="center"><span id="sprytextfield2">
      <input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="15" maxlength="7">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMinCharsMsg">No se cumple el m�nimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span><span class="rojopequeno">F &oacute; K000000</span><span class="etiqueta12"> /</span><span class="rojopequeno">
<input name="nro_operacion_relacionada" type="text" class="etiqueta12" id="nro_operacion_relacionada" value="<?php echo $row_DetailRS1['nro_operacion_relacionada']; ?>" size="15" maxlength="7">
      </span>
      </div> <span class="respuestacolumna_rojo">L000000</span></td>
      <td align="right">Rut Cliente:</td>
      <td colspan="5" align="center">
        <input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15" readonly>
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nombre Cliente:</td>
      <td colspan="7" align="left"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120" readonly></td>
    </tr>
    <tr valign="middle">
      <td align="right">Estado:</td>
      <td align="center">        
        <select name="estado" class="etiqueta12" id="estado">
          <option value="Cursada." selected>Cursada</option>
          <option value="Reparada.">Reparada</option>
          <option value="Pendiente.">Devuelta</option>
        </select>
      </div>        
        </div>      
      </div></td>
      <td align="right">Fecha Curse:</div></td>
      <td align="center">
          <input name="fecha_curse" type="text" class="etiqueta12" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10" readonly>
            <span class="rojopequeno">(dd-mm-aaaa)</span><br>
      </div></td>
      <td align="right">Pago Automatico:</td>
      <td align="center"><select name="pago_automatico" class="rojopequeno" id="pago_automatico">
        <option value="Si" <?php if (!(strcmp("Si", $row_DetailRS1['pago_automatico']))) {echo "selected=\"selected\"";} ?>>Si</option>
        <option value="No" <?php if (!(strcmp("No", $row_DetailRS1['pago_automatico']))) {echo "selected=\"selected\"";} ?>>No</option>
      </select></td>
      <td align="right">Vcto Operaci&oacute;n:</td>
      <td align="center"><span id="sprytextfield3">
      <input name="vcto_operacion" type="text" class="etiqueta12" id="vcto_operacion" value="<?php echo $row_DetailRS1['vcto_operacion']; ?>" size="12" maxlength="10">
      <span class="textfieldInvalidFormatMsg">Formato no v�lido.</span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Tipo Operaci&oacute;n: </td>
      <td align="center"></div>
        <select name="tipo_operacion" class="etiqueta12" id="tipo_operacion">
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
      <td align="right">Nro Cuotas: </td>
      <td align="center"></div>
        <label></label>
        <span id="sprytextfield1">
        <label>
          <input name="nro_cuotas" type="text" class="etiqueta12" id="nro_cuotas" value="<?php echo $row_DetailRS1['nro_cuotas']; ?>" size="5" maxlength="3">
  &nbsp; <span class="rojopequeno">max.  999</span></label>
        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al m�nimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al m�ximo permitido.</span></span></td>
      <td align="center">Cuota Int.:</div></td>
      <td align="center">
        <input name="cuota_int" type="checkbox" class="etiqueta12" id="cuota_int" value="Y" <?php if (!(strcmp($row_DetailRS1['cuota_int'],"Y"))) {echo "checked";} ?>>
      <span class="rojopequeno">(Si)</span></div></td>
      <td align="right">Pagar&eacute;:</div></td>
      <td align="center"><select name="pagare" class="etiqueta12" id="pagare">
        <option value="N/A" selected <?php if (!(strcmp("N/A", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>No Aplica</option>
        <option value="Anexo." <?php if (!(strcmp("Anexo.", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>Anexo</option>
        <option value="Escritura." <?php if (!(strcmp("Escritura.", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>Escritura</option>
        <option value="Pagare." <?php if (!(strcmp("Pagare.", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>Pagare</option>
        <option value="Pagare Paragua." <?php if (!(strcmp("Pagare Paragua.", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>Pagare Paragua</option>
        <option value="Pagare Cobex." <?php if (!(strcmp("Pagare Cobex.", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>Pagare Cobex</option>
        <option value="Pagare SGR." <?php if (!(strcmp("Pagare SGR.", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>Pagare SGR</option>
        <option value="Sol. Pagare Paragua." <?php if (!(strcmp("Sol. Pagare Paragua.", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>Sol. Pagare Paragua</option>
        <option value="Sucursal." <?php if (!(strcmp("Sucursal.", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>Sucursal</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right"><p>Tasa Variable:</p>
      </td>
      <td align="center">
        <input <?php if (!(strcmp($row_DetailRS1['tasa_variable'],"Y"))) {echo "checked";} ?> name="tasa_variable" type="checkbox" class="etiqueta12" id="tasa_variable" value="Y">
      <span class="rojopequeno">(Si)
      <select name="periodisidad" class="etiqueta12" id="periodisidad">
        <option value="0" <?php if (!(strcmp(0, $row_DetailRS1['periodisidad']))) {echo "selected=\"selected\"";} ?>>No Aplica</option>
        <option value="30" <?php if (!(strcmp(30, $row_DetailRS1['periodisidad']))) {echo "selected=\"selected\"";} ?>>Mensual</option>
        <option value="60" <?php if (!(strcmp(60, $row_DetailRS1['periodisidad']))) {echo "selected=\"selected\"";} ?>>Bimensual</option>
        <option value="90" <?php if (!(strcmp(90, $row_DetailRS1['periodisidad']))) {echo "selected=\"selected\"";} ?>>Trimestral</option>
        <option value="120" <?php if (!(strcmp(120, $row_DetailRS1['periodisidad']))) {echo "selected=\"selected\"";} ?>>Cuatrimestral</option>
        <option value="180" <?php if (!(strcmp(180, $row_DetailRS1['periodisidad']))) {echo "selected=\"selected\"";} ?>>Semestral</option>
        <option value="360" <?php if (!(strcmp(360, $row_DetailRS1['periodisidad']))) {echo "selected=\"selected\"";} ?>>Anual</option>
      </select>
      </span></div></td>
      <td align="right">Cancelaci&oacute;n Total: </td>
      <td align="center">
        <input <?php if (!(strcmp($row_DetailRS1['cancelacion_total'],"Y"))) {echo "checked";} ?> name="cancelacion_total" type="checkbox" class="etiqueta12" id="cancelacion_total" value="Y">
      <span class="rojopequeno">(Si)</span></div></td>
      <td colspan="3" align="right">Declaraci&oacute;n de Exportaci&oacute;n:</td>
      <td align="center">
        <input <?php if (!(strcmp($row_DetailRS1['dus'],"Y"))) {echo "checked";} ?> name="dus" type="checkbox" class="etiqueta12" id="dus" value="Y">
      <span class="rojopequeno">(Si)</span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Autorizador:</td>
      <td align="center"><span id="sprytextfield4">
        <label>
          <input name="autorizador" type="text" class="etiqueta12" id="autorizador" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20">
        </label>
      <span class="textfieldRequiredMsg">Si este valor esta en Blanco ingrese nuevamente a la aplicaci&oacute;n.</span></span></td>
      <td align="right">Operador:</td>
      <td align="center"><input name="operador" type="text" class="etiqueta12" id="operador" value="<?php echo $row_DetailRS1['operador']; ?>" size="20" maxlength="20"></td>
      <td colspan="3" align="right">Moneda <span class="rojopequeno">/</span> Monto Operaci&oacute;n:</td>
      <td align="center"><select name="moneda_operacion" class="etiqueta12" id="moneda_operacion">
        <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>DKK</option>
        <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>NOK</option>
        <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>SEK</option>
        <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>USD</option>
<option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>CAD</option>
        <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>AUD</option>
        <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>HKD</option>
        <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>EUR</option>
        <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>CHF</option>
        <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>GBP</option>
<option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
        <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>JPY</option>
        <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>CLP</option>
      </select> 
        <span class="rojopequeno">/</span>        <input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="17" maxlength="15"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Evento:</td>
      <td align="center"><select name="evento" class="etiqueta12" id="evento">
        <option value="Apertura." <?php if (!(strcmp("Apertura.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Apertura</option>
        <option value="Prorroga." <?php if (!(strcmp("Prorroga.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Prorroga</option>
<option value="Cambio Tasa." <?php if (!(strcmp("Cambio Tasa.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Cambio Tasa</option>
        <option value="Visacion." <?php if (!(strcmp("Visacion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Visacion (DI)</option>
        <option value="Swift." <?php if (!(strcmp("Swift.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Swift</option>
        <option value="Pago." <?php if (!(strcmp("Pago.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pago</option>
        <option value="LBTR." <?php if (!(strcmp("LBTR.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>LBTR</option>
        <option value="DUS." <?php if (!(strcmp("DUS.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>DUS</option>
        <option value="Carta Original." <?php if (!(strcmp("Carta Original.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Carta Original</option>
        <option value="Requerimiento." <?php if (!(strcmp("Requerimiento.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Requerimiento</option>
        <option value="Solucion Excepcion." <?php if (!(strcmp("Solucion Excepcion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Solucion Excepcion</option>
        <option value="Dev Comisiones." <?php if (!(strcmp("Dev Comisiones.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Dev Comisiones</option>
        <option value="Aviso Cuotas." <?php if (!(strcmp("Aviso Cuotas.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Aviso Cuotas</option>
        <option value="Tecnica." <?php if (!(strcmp("Tecnica.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Tecnica</option>
        <option value="Prorroga y Pago." <?php if (!(strcmp("Prorroga y Pago.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Prorroga y Pago</option>
        <option value="Mandato PAC." <?php if (!(strcmp("Mandato PAC.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Mandato PAC</option>
        <option value="Restructuracion." <?php if (!(strcmp("Restructuracion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Restructuracion</option>
        <option value="Redenominacion." <?php if (!(strcmp("Redenominacion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Redenominacion</option>
      </select></td>
      <td align="right">Urgente:</td>
      <td align="center"><label>
        <select name="urgente" class="etiqueta12" id="urgente">
          <option value="Si" <?php if (!(strcmp("Si", $row_DetailRS1['urgente']))) {echo "selected=\"selected\"";} ?>>Si</option>
          <option value="No" <?php if (!(strcmp("No", $row_DetailRS1['urgente']))) {echo "selected=\"selected\"";} ?>>No</option>
        </select>
      </label></td>
      <td colspan="3" align="right">Fuera Horario:</td>
      <td align="center"><label>
        <select name="fuera_horario" class="etiqueta12" id="fuera_horario">
          <option value="Si" <?php if (!(strcmp("Si", $row_DetailRS1['fuera_horario']))) {echo "selected=\"selected\"";} ?>>Si</option>
          <option value="No" <?php if (!(strcmp("No", $row_DetailRS1['fuera_horario']))) {echo "selected=\"selected\"";} ?>>No</option>
        </select>
      </label></td>
    </tr>
    <tr valign="middle">
      <td align="right">Observaci&oacute;n:</div></td>
      <td colspan="7" align="left"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12" id="obs"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
      <span class="rojopequeno"><span id="countsprytextarea1">&nbsp;</span></span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></div></td>
    </tr>
    <tr align="center" valign="middle">
      <td colspan="8" align="left" bgcolor="#999999"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"></span><span class="Estilo5">Reparo</span></td>
    </tr>
    <tr align="center" valign="middle">
      <td align="right">Observaci&oacute;n Reparo:</td>
      <td colspan="7" align="left"><span id="sprytextarea2">
        <textarea name="reparo_obs" cols="80" rows="6" class="etiqueta12" id="reparo_obs"><?php echo $row_DetailRS1['reparo_obs']; ?></textarea>
      <span class="rojopequeno"><span id="countsprytextarea2">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span><span class="rojopequeno"></span></span></td>
    </tr>
    <tr align="center" valign="middle">
      <td colspan="8" align="center"><input type="submit" class="boton" value="Alta Supervisor"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input name="vi" type="hidden" id="vi" value="<?php echo $row_DetailRS1['vi']; ?>">
  <input name="iteraciones" type="hidden" id="iteraciones" value="<?php echo ($row_DetailRS1['iteraciones'] + $row_DetailRS1['vi']); ?>">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
  <input name="sub_estado" type="hidden" id="sub_estado" value="<?php echo $row_DetailRS1['estado']; ?>">
  <input name="date_supe" type="hidden" id="date_supe" value="<?php echo date("Y-m-d H:i:s"); ?>">
  <input name="fecha_curse" type="hidden" id="fecha_curse" value="<?php echo date("d-m-Y"); ?>">
  <input name="date_curse" type="hidden" id="date_curse" value="<?php echo date("Y-m-d"); ?>">
  <input name="fecha_curse_inicial" type="hidden" id="fecha_curse_inicial" value="<?php echo $row_DetailRS1['fecha_curse']; ?>">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="altamae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false, minChars:0, maxChars:450, validateOn:["blur"], counterId:"countsprytextarea2", counterType:"chars_remaining"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {minValue:1, maxValue:999, validateOn:["blur", "change"], hint:"1", useCharacterMasking:true});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {minChars:1, maxChars:7, hint:"0", validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "date", {format:"yyyy-mm-dd", validateOn:["blur", "change"], hint:"0000-00-00"});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>