<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
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

$colname_DetailRS1 = "1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM cliente nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$colname_enviocv = "Compras.";
if (isset($_GET['evento'])) {
  $colname_enviocv = $_GET['evento'];
}
$colname1_enviocv = "Ventas.";
if (isset($_GET['evento'])) {
  $colname1_enviocv = $_GET['evento'];
}
$colname2_enviocv = "-1";
if (isset($_GET['recordID'])) {
  $colname2_enviocv = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_enviocv = sprintf("SELECT enviocv.* FROM cliente INNER JOIN enviocv ON cliente.rut_cliente = enviocv.rut_cliente WHERE (evento = %s or evento = %s) and cliente.id = %s ORDER BY monto_operacion DESC", GetSQLValueString($colname_enviocv, "text"),GetSQLValueString($colname1_enviocv, "text"),GetSQLValueString($colname2_enviocv, "text"));
$enviocv = mysqli_query($comercioexterior, $query_enviocv) or die(mysqli_error($comercioexterior));
$row_enviocv = mysqli_fetch_assoc($enviocv);
$totalRows_enviocv = mysqli_num_rows($enviocv);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO enviocv (rut_cliente, nombre_cliente, evento, fecha_ingreso, moneda_operacion, monto_operacion) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"));

  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO opmec (nro_folio, rut_cliente, nombre_cliente, ejecutivo_cuenta, ejecutivo_ni, especialista_ni, nombre_oficina, fecha_ingreso, date_ingreso, evento, obs, especialista_curse, territorial, moneda_operacion, monto_operacion, valuta, compraventa, tipocambio, date_preingreso, date_espe, estado_visacion, mandato, impedido_operar, urgente, cliente_passport) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nro_folio'], "text"),
					   GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['ejecutivo_cuenta'], "text"),
                       GetSQLValueString($_POST['ejecutivo_ni'], "text"),
                       GetSQLValueString($_POST['especialista_ni'], "text"),
                       GetSQLValueString($_POST['nombre_oficina'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['date_ingreso'], "date"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['especialista_curse'], "text"),
                       GetSQLValueString($_POST['territorial'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['valuta'], "text"),
                       GetSQLValueString($_POST['compraventa'], "text"),
                       GetSQLValueString($_POST['tipocambio'], "double"),
                       GetSQLValueString($_POST['date_preingreso'], "date"),
                       GetSQLValueString($_POST['date_espe'], "date"),
                       GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['mandato'], "text"),
					   GetSQLValueString($_POST['impedido_operar'], "text"),
                       GetSQLValueString($_POST['urgente'], "text"),
					   GetSQLValueString($_POST['cliente_passport'], "text"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
  $insertGoTo = "ingdet_m.php";
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
<title>Ingreso Multiple Instrucci&oacute;n - Detalle</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo5 {
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
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
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<link href="../../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="MM_preloadImages('../../../../espcomex/imagenes/Botones/boton_volver_2.jpg','../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">INGRESO MULTIPLE INSTRUCCION - DETALLE</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">MERCADO DE CORREDORES</td>
  </tr>
</table>
<br>
<?php if ($totalRows_enviocv > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="7" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Compras y Ventas Enviadas a Curse</td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><a href="untitled.php?recordID=<?php echo $row_enviocv['rut_cliente']; ?>"> <?php echo $row_enviocv['rut_cliente']; ?>&nbsp; </a></td>
        <td align="left" valign="middle"><?php echo $row_enviocv['nombre_cliente']; ?>&nbsp; </td>
        <td align="center" valign="middle"><?php echo $row_enviocv['fecha_ingreso']; ?>&nbsp; </td>
        <td align="center" valign="middle"><?php echo $row_enviocv['fecha_curse']; ?>&nbsp; </td>
        <td align="center" valign="middle"><?php echo $row_enviocv['evento']; ?>&nbsp; </td>
        <td align="center" valign="middle"><?php echo $row_enviocv['estado']; ?>&nbsp; </td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_enviocv['moneda_operacion']; ?></span>&nbsp; <span class="respuestacolumna_azul"><?php echo number_format($row_enviocv['monto_operacion'], 2, ',', '.'); ?></span></td>
      </tr>
      <?php } while ($row_enviocv = mysqli_fetch_assoc($enviocv)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" onSubmit="MM_validateForm('monto_operacion','','RisNum');return document.MM_returnValue">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="4" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="titulodetalle">Ingreso Multiple Instrucci&oacute;n</span></td>
    </tr>
    <tr valign="middle">
      <td width="16%" align="right">Nro Folio:</td>
      <td colspan="3" align="left"><span id="sprytextfield3">
      <input name="nro_folio" type="text" class="etiqueta12" id="nro_folio" size="15" maxlength="10">
      <span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span><span class="textfieldMinCharsMsg">No se cumple el m&iacute;nimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al m&iacute;nimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al m&aacute;ximo permitido.</span></span><span class="respuestacolumna_rojo">#</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Rut Cliente:</td>
      <td width="42%" align="center">
          <input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15" readonly="readonly">
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
      <td width="18%" align="right">Fecha Ingreso:</div></td>
      <td width="24%" align="center">
          <input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10"> 
      <span class="rojopequeno">(dd-mm-aaaa)</span> </div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nombre Cliente:</td>
      <td colspan="3" align="left"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120" readonly="readonly"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Evento:</td>
      <td align="center">        
        <select name="evento" class="etiqueta12" id="evento">
<option value="Ventas." selected>Ventas</option>
          <option value="Compras.">Compras</option>
          <option value="Arbitraje.">Arbitraje</option>
          <option value="Emision Cheque.">Emision Cheque</option>
          <option value="Emision Planilla.">Emision Planilla</option>
          <option value="Soli Abono M/X.">Soli Abono M/X</option>
          <option value="Liq OP Recibidas.">Liq OP Recibidas</option>
          <option value="Abono MT 910.">Abono MT 910</option>
          <option value="LBTR.">LBTR</option>
          <option value="Requerimiento.">Requerimiento</option>
          <option value="Dev Comisiones.">Dev Comisiones</option>
          <option value="Carta Original.">Carta Original</option>
          <option value="Sol. Rep. Ext.">Solucion Reparo Ext.</option>
          <option value="Liq. Forward.">Liquidacion Forward</option>
          <option value="Solicitud OPE WEB.">Solicitud OPE WEB</option>
        </select>
      </div></td>
      <td align="right">Especilista Curse:</div></td>
      <td align="center"><span id="sprytextfield2">
        <input name="especialista_curse" type="text" class="etiqueta12" id="especialista_curse" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20">
      <span class="textfieldRequiredMsg">Si este valor esta en Blanco ingrese nuevamente a la aplicaci&oacute;n.</span></span>        </div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Observaci&oacute;n:</td>
      <td colspan="3" align="left"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
      <span class="rojopequeno" id="countsprytextarea1">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Moneda<br> 
      Monto Operaci&oacute;n:</td>
      <td align="center">
          <select name="moneda_operacion" class="etiqueta12" id="moneda_operacion">
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
          <input name="monto_operacion" type="text" class="etiqueta12" value="0.00" size="20" maxlength="20">
      </div></td>
      <td align="right">Valuta:</td>
      <td align="center">        <p align="center">
        <select name="valuta" class="etiqueta12" id="valuta">
          <option value="NA." selected>No Aplica</option>
          <option value="0.">Valuta 0</option>
          <option value="24.">Valuta 24</option>
          <option value="48.">Valuta 48</option>
          </select>
      </td>
    </tr>
    <tr valign="middle">
      <td align="right">Campra / Venta:</td>
      <td align="center"></div>
        <select name="compraventa" class="etiqueta12" id="compraventa">
          <option value="N/A">No Aplica</option>
          <option value="Compra.">Compra</option>
          <option value="Venta.">Venta</option>
      </select></td>
      <td align="right">Tipo Cambio:</td>
      <td align="center"></div>
        <span id="sprytextfield1">
        <input name="tipocambio" type="text" class="etiqueta12" id="tipocambio" value="0.00" size="10" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Urgente:</td>
      <td align="center"><label>
        <input name="urgente" type="radio" class="etiqueta12" value="Si">
        Si
        <input name="urgente" type="radio" class="etiqueta12" value="No" checked>
No </label></td>
      <td align="right">Campa&ntilde;a Comex:</td>
      <td align="center">
        <label>
          <input name="campana_comex" type="radio" class="mayuscula" id="campana_comex_1" value="Si">
          Si</label>
        <input name="campana_comex" type="radio" class="etiqueta12" id="campana_comex_0" value="No" checked>
No<br>
      </td>
    </tr>
    <tr valign="middle">
      <td align="right">Mandato / Imp. Operar / Passport:</td>
      <td colspan="3" align="left">
        <label>
          <input name="mandato" type="text" class="etiqueta12" id="mandato" value="<?php echo $row_DetailRS1['estado_mandato']; ?>" size="30" maxlength="25" readonly="readonly">
        </label>
         / 
         <input name="impedido_operar" type="text" class="destadado" id="impedido_operar" value="<?php echo $row_DetailRS1['impedido_operar']; ?>" size="10" maxlength="10">         
          / 
          <input name="cliente_passport" type="text" class="respuestacolumna_rojo" id="cliente_passport" value="<?php echo $row_DetailRS1['cliente_passport']; ?>" size="3" maxlength="2">          <br>
      </td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="center">
        <input type="submit" class="boton" value="Ingresar Instrucci&oacute;n">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="id">
  <input type="hidden" name="MM_insert" value="form1">
  <input type="hidden" name="date_ingreso" value="<?php echo date("Y-m-d"); ?>" size="32">
  <input name="date_preingreso" type="hidden" id="date_preingreso" value="<?php echo date("Y-m-d H:i:s"); ?>" size="32">
  <input name="date_espe" type="hidden" id="date_espe" value="<?php echo date("Y-m-d H:i:s"); ?>" size="32">
  <input name="estado_visacion" type="hidden" id="estado_visacion" value="Pendiente.">
  <input name="territorial" type="hidden" class="etiqueta12" id="territorial" value="<?php echo $row_DetailRS1['territorial']; ?>" size="30" maxlength="50" readonly="readonly">
  <input name="ejecutivo_cuenta" type="hidden" id="ejecutivo_cuenta" value="<?php echo $row_DetailRS1['nombre_ejecutivo']; ?>">
  <input name="ejecutivo_ni" type="hidden" id="ejecutivo_ni" value="<?php echo $row_DetailRS1['ejecutivo']; ?>">
  <input name="especialista_ni" type="hidden" id="especialista_ni" value="<?php echo $row_DetailRS1['especialista']; ?>">
  <input name="nombre_oficina" type="hidden" id="nombre_oficina" value="<?php echo $row_DetailRS1['oficina']; ?>">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="ingmae_m.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "currency", {hint:"0.00", validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {minChars:0, maxChars:10, minValue:0, maxValue:9999999999, isRequired:false});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
mysqli_free_result($enviocv);
?>
