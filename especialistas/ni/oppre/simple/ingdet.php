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

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM cliente nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO oppre (nro_folio, rut_cliente, nombre_cliente, ejecutivo_cuenta, ejecutivo_ni, especialista_ni, nombre_oficina, fecha_ingreso, date_ingreso, evento, obs, especialista_curse, territorial, moneda_operacion, monto_operacion, tasa_seg, aut_tasa_seg, destino_fondos, tipo_tasa, libor_tt, algo_tt, libor_tf, algo_tf, tasa_final, spread, tt, periodisidad, date_preingreso, date_espe, tipo_operacion, estado_visacion, mandato, impedido_operar, urgente, cliente_passport) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
                       GetSQLValueString($_POST['tasa_seg'], "text"),
                       GetSQLValueString($_POST['aut_tasa_seg'], "text"),
                       GetSQLValueString($_POST['destino_fondos'], "text"),
                       GetSQLValueString($_POST['tipo_tasa'], "text"),
                       GetSQLValueString($_POST['libor_tt'], "text"),
                       GetSQLValueString($_POST['algo_tt'], "double"),
                       GetSQLValueString($_POST['libor_tf'], "text"),
                       GetSQLValueString($_POST['algo_tf'], "double"),
                       GetSQLValueString($_POST['tasa_final'], "double"),
                       GetSQLValueString($_POST['spread'], "double"),
                       GetSQLValueString($_POST['tt'], "text"),
                       GetSQLValueString($_POST['periodisidad'], "text"),
                       GetSQLValueString($_POST['date_preingreso'], "date"),
                       GetSQLValueString($_POST['date_espe'], "date"),
                       GetSQLValueString($_POST['tipo_operacion'], "text"),
                       GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['mandato'], "text"),
					   GetSQLValueString($_POST['impedido_operar'], "text"),
                       GetSQLValueString($_POST['urgente'], "text"),
					   GetSQLValueString($_POST['cliente_passport'], "text"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
  $insertGoTo = "impresionsimple.php";
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
<title>Ingreso Simple Instrucci&oacute;n - Detalle</title>
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

</style>
<script src="../../../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../../SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
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
<link href="../../../../SpryAssets/SpryValidationRadio.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="MM_preloadImages('../../../../espcomex/imagenes/Botones/boton_volver_2.jpg','../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">INGRESO  SIMPLE INSTRUCCION - DETALLE</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="4" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="titulodetalle">Ingreso  Simple Instrucci&oacute;n</div>
      </span></td>
    </tr>
    <tr valign="middle">
      <td width="14%" align="right">Nro Folio:</td>
      <td colspan="3" align="left"><span id="sprytextfield">
      <input name="nro_folio" type="text" class="etiqueta12" id="nro_folio" size="15" maxlength="10">
      <span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span><span class="textfieldMinCharsMsg">No se cumple el m&iacute;nimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al m&iacute;nimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al m&aacute;ximo permitido.</span></span><span class="respuestacolumna_rojo">#</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Rut Cliente:</td>
      <td width="34%" align="center">
          <input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15" readonly="readonly">
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
      <td width="11%" align="right">Fecha Ingreso:</div></td>
      <td width="41%" align="center">
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
            <option value="Apertura." selected>Apertura</option>
            <option value="Mandato PAC.">Mandato PAC</option>
          </select>
      </div></td>
      <td align="right">Especilista Curse:</div></td>
      <td align="center"><span id="sprytextfield7">
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
      <td align="right">Tipo Operaci&oacute;n:</td>
      <td align="center"><select name="tipo_operacion" class="etiqueta12" id="tipo_operacion">
        <option value="Confirming.">Confirming</option>
        <option value="Forfaiting.">Forfaiting</option>
        <option value="PAE.">PAE</option>
        <option value="PAE Cobex.">PAE Cobex</option>
        <option value="PAE SGR.">PAE SGR</option>
        <option value="Finan. Contado.">Finan. Contado</option>
        <option value="Finan. Contado COBEX.">Finan. Contado COBEX</option>
        <option value="Finan. Contado SGR.">Finan. Contado SGR</option>
        <option value="Credito Comercial.">Credito Comercial</option>
        <option value="Credito Comercial COBEX.">Credito Comercial COBEX</option>
        <option value="Credito Comercial SGR.">Credito Comercial SGR</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right">Urgente:</td>
      <td align="center"><label>
        <input name="urgente" type="radio" class="etiqueta12" value="Si">
        Si
        <input name="urgente" type="radio" class="etiqueta12" value="No" checked>
No</label></td>
      <td align="right">Destino Fondos:</td>
      <td align="center"><select name="destino_fondos" class="etiqueta12" id="destino_fondos">
        <option value="N/A" selected>No Aplica</option>
        <option value="V.A.">V.A.</option>
        <option value="CTA. CTE.">CTA. CTE.</option>
        <option value="REMESA.">REMESA</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right">Tipo Tasa: </td>
      <td align="center"><span id="spryradio1">
        <label>
          <input type="radio" name="tipo_tasa" value="Fija." id="tipo_tasa_0">
          Fija</label>
        <label>
          <input type="radio" name="tipo_tasa" value="Variable." id="tipo_tasa_1">
          Variable</label>
        <br>
      <span class="radioRequiredMsg">Seleccione Tasa Fija o Variable.</span></span></td>
      <td align="right">Tasa Variable:</td>
      <td align="center"><label>
        <select name="libor_tt" class="etiqueta12" id="libor_tt">
          <option value="N/A" selected>Libor a...</option>
          <option value="30">Libor 30</option>
          <option value="60">Libor 60</option>
          <option value="90">Libor 90</option>
          <option value="120">Libor 120</option>
          <option value="150">Libor 150</option>
          <option value="180">Libor 180</option>
          <option value="210">Libor 210</option>
          <option value="240">Libor 240</option>
          <option value="270">Libor 270</option>
          <option value="300">Libor 300</option>
          <option value="330">Libor 330</option>
          <option value="360">Libor 360</option>
        </select>
        <span class="rojopequeno">+</span>
        <input name="algo_tt" type="text" class="etiqueta12" id="algo_tt" value="0.00" size="10" maxlength="10">
        <span class="rojopequeno">= TT</span> <span class="respuestacolumna_azul">//</span>
<select name="libor_tf" class="etiqueta12" id="libor_tf">
  <option value="N/A" selected>Libor a...</option>
  <option value="30">Libor 30</option>
  <option value="60">Libor 60</option>
  <option value="90">Libor 90</option>
  <option value="120">Libor 120</option>
  <option value="150">Libor 150</option>
  <option value="180">Libor 180</option>
  <option value="210">Libor 210</option>
  <option value="240">Libor 240</option>
  <option value="270">Libor 270</option>
  <option value="300">Libor 300</option>
  <option value="330">Libor 330</option>
  <option value="360">Libor 360</option>
</select>
      <span class="rojopequeno">+</span>
      <input name="algo_tf" type="text" class="etiqueta12" id="algo_tf" value="0.00" size="10" maxlength="10">
      <span class="rojopequeno">= Tasa Final</span></label></td>
    </tr>
    <tr valign="middle">
      <td align="right">Tasa Fija:</td>
      <td align="center"><span id="sprytextfield2"><span class="textfieldInvalidFormatMsg">Formato debe ser 00.000000</span><span class="textfieldRequiredMsg">e necesita un valor.</span></span> <span class="respuestacolumna_azul"><span class="respuestacolumna_rojo"> TT</span></span><span id="sprytextfield3">
      <label>
        <input name="tt" type="text" class="etiqueta12" id="tt" value="0.00" size="10" maxlength="10">
      </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span> <span class="respuestacolumna_rojo">SPREAD</span><span id="sprytextfield6">
      <input name="spread" type="text" class="etiqueta12" id="spread" value="0.00" size="10" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="respuestacolumna_rojo">TASA FINAL</span><span id="sprytextfield5">
      <input name="tasa_final" type="text" class="etiqueta12" id="tasa_final" value="0.00" size="10" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      <td align="right">Periodisidad:</td>
      <td align="center"><span class="rojopequeno">
        <select name="periodisidad" class="etiqueta12" id="periodisidad">
          <option selected>No Aplica</option>
          <option value="30">Mensual</option>
          <option value="60">Bimensual</option>
          <option value="90">Trimestral</option>
          <option value="120">Cuatrimestral</option>
          <option value="180">Semestral</option>
          <option value="360">Anual</option>
        </select>
      </span></td>
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
      <input name="cliente_passport" type="text" class="respuestacolumna_rojo" id="cliente_passport" value="<?php echo $row_DetailRS1['cliente_passport']; ?>" size="3" maxlength="2"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Tasa Segmento:</td>
      <td align="center"><label>
        <select name="tasa_seg" class="etiqueta12" id="tasa_seg">
          <option value="N/A" selected>Seleccione una Opci&oacute;n</option>
          <option value="Empresas RED">Empresas RED</option>
          <option value="BEI">BEI</option>
          <option value="Pyme I">Pyme I</option>
          <option value="Negocio">Negocio</option>
          <option value="Pyme II Carterizado">Pyme II Carterizado</option>
          <option value="Pyme II Estandarizado">Pyme II Estandarizado</option>
        </select>
      </label></td>
      <td align="right">Autorizaci&oacute;n Tasa:</td>
      <td align="center"><label>
        <select name="aut_tasa_seg" class="etiqueta12" id="aut_tasa_seg">
          <option value="N/A" selected>Seleccione una Opcion</option>
          <option value="Tasa Tarifa">Tasa Tarifa</option>
          <option value="Resolucion Tasa Pyme">Resolucion Tasa Pyme</option>
          <option value="Gerente Sucursales">Gerente Sucursales</option>
          <option value="Gerente BEI">Gerente BEI</option>
        </select>
      </label></td>
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
    <td align="right" valign="middle"><a href="ingmae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {hint:"0.00", validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"], hint:"0.00"});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur"], hint:"0.00"});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {validateOn:["blur"], hint:"0.00"});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {validateOn:["blur"]});
var spryradio1 = new Spry.Widget.ValidationRadio("spryradio1", {validateOn:["blur"]});
var sprytextfield = new Spry.Widget.ValidationTextField("sprytextfield", "integer", {minChars:0, maxChars:10, minValue:0, maxValue:9999999999, isRequired:false});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>