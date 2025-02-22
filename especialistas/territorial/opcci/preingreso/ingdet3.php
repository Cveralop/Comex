<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,TER";
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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO opcci (rut_cliente, nombre_cliente, ejecutivo_cuenta, ejecutivo_ni, especialista_ni, nombre_oficina, fecha_ingreso, date_ingreso, evento, estado, nro_operacion, nro_operacion_relacionada, obs, especialista_curse, territorial, moneda_operacion, monto_operacion, origen_fondos, tipo_operacion, date_preingreso, reparo_obs, estado_visacion, mandato, excepcion, autorizacion_operaciones, responsable_excepcion, tipo_excepcion, solucion_excepcion, urgente, fuera_horario, nro_folio, cliente_passport) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['ejecutivo_cuenta'], "text"),
                       GetSQLValueString($_POST['ejecutivo_ni'], "text"),
                       GetSQLValueString($_POST['especialista_ni'], "text"),
                       GetSQLValueString($_POST['nombre_oficina'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['date_ingreso'], "date"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['nro_operacion_relacionada'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['especialista_curse'], "text"),
                       GetSQLValueString($_POST['territorial'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['origen_fondos'], "text"),
                       GetSQLValueString($_POST['tipo_operacion'], "text"),
                       GetSQLValueString($_POST['date_preingreso'], "date"),
                       GetSQLValueString($_POST['reparo_obs'], "text"),
                       GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['mandato'], "text"),
                       GetSQLValueString($_POST['excepcion'], "text"),
                       GetSQLValueString($_POST['autorizacion_operaciones'], "text"),
                       GetSQLValueString($_POST['responsable_excepcion'], "text"),
                       GetSQLValueString($_POST['tipo_excepcion'], "text"),
                       GetSQLValueString($_POST['solucion_excepcion'], "date"),
                       GetSQLValueString($_POST['urgente'], "text"),
                       GetSQLValueString($_POST['fuera_horario'], "text"),
                       GetSQLValueString($_POST['nro_folio'], "int"),
					   GetSQLValueString($_POST['cliente_passport'], "text"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
  $insertGoTo = "ingmae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = "SELECT * FROM carteraopera";
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS2 = "SELECT cliente.* FROM carteraopera INNER JOIN cliente ON carteraopera.rut_cliente=cliente.rut_cliente WHERE carteraopera.id = $recordID";
$DetailRS2 = mysqli_query($comercioexterior, $query_DetailRS2) or die(mysqli_error($comercioexterior));
$row_DetailRS2 = mysqli_fetch_assoc($DetailRS2);
$totalRows_DetailRS2 = mysqli_num_rows($DetailRS2);
?>
<?php
$colname1_DetailRS1 = "xxx";
if (isset($_GET['nro_operacion_relacionada'])) {
  $colname1_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['nro_operacion_relacionada'] : addslashes($_GET['nro_operacion_relacionada']);
}
$colname2_DetailRS1 = "Negociacion.";
if (isset($_GET['evento'])) {
  $colname2_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['evento'] : addslashes($_GET['evento']);
}
$colname_DetailRS1 = "1";
if (isset($_GET['nro_operacion'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['nro_operacion'] : addslashes($_GET['nro_operacion']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = sprintf("SELECT * FROM carteraopera  WHERE id = $recordID",$colname_DetailRS1,$colname1_DetailRS1,$colname2_DetailRS1); //$colname_opcci,$colname1_opcci,$colname2_opcci
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pre-Ingreso Instrucci&oacute;n Multiple - Detalle</title>
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
.Estilo5 {font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}

</style>
<script src="../../../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<script>
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
<link href="../../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">PRE-INGRESO INSTRUCCIONES - DETALLE</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">CARTAS DE CR&Eacute;DITO DE IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" name="form1" method="POST">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="4" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="titulodetalle">Ingresar Simple Instrucci&oacute;n</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Folio:</td>
      <td colspan="3" align="left"><span id="sprytextfield2">
      <input name="nro_folio" type="text" class="etiqueta12" id="nro_folio" size="15" maxlength="10">
      <span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span><span class="textfieldMinCharsMsg">No se cumple el m&iacute;nimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al m&iacute;nimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al m&aacute;ximo permitido.</span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="respuestacolumna_rojo">#</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Rut Cliente:</td>
      <td align="center">
          <input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15" readonly="readonly">
          <span class="rojopequeno">Sin punto ni Guion</span>          </div></td>
      <td align="right">Fecha Ingreso:</div></td>
      <td align="center">
          <input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10">
      <span class="rojopequeno">(dd-mm-aaaa) </span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nombre Cliente:</td>
      <td colspan="3" align="left"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120" readonly="readonly"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Evento:</td>
      <td align="center"><select name="evento" class="etiqueta12" id="evento">
        <option value="Pago.">Pago</option>
        <option value="Prorroga.">Prorroga</option>
        <option value="Prorroga y Pago.">Prorroga y Pago</option>
        <option value="Cambio Tasa.">Cambio Tasa</option>
        <option value="Visacion.">Visacion (DI)</option>
        <option value="Cartera Vencida.">Cartera Vencida</option>
        <option value="Requerimiento.">Requerimiento</option>
        <option value="Carta Original.">Carta Original</option>
        <option value="Restructuracion.">Restructuracion</option>
        <option value="Redenominacion.">Redenominacion</option>
      </select>        </div></td>
      <td align="right">Especialista Curse / Territorial:</td>
      <td align="center"><span id="sprytextfield1">
      <input name="especialista_curse" type="text" class="etiqueta12" id="especialista_curse" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20">
      <span class="textfieldRequiredMsg">Si este valor esta en Blanco ingrese nuevamente a la aplicaci&oacute;n.</span></span> <span class="rojopequeno">/ </span>
      <input name="territorial" type="text" class="etiqueta12" id="territorial" value="<?php echo $row_DetailRS2['territorial']; ?>" size="30" maxlength="50" readonly="readonly"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Observaci&oacute;n:</td>
      <td colspan="3" align="left"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
      <span class="rojopequeno" id="countsprytextarea1">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Operaci&oacute;n:</td>
      <td align="center"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" value="<?php echo $row_DetailRS1['nro_operacion_relacionada_car']; ?>" size="15" maxlength="7" readonly="readonly">
      <span class="rojopequeno">K000000 <span class="etiqueta12">/
      <input name="nro_operacion_relacionada" type="text" class="etiqueta12" id="nro_operacion_relacionada" value="<?php echo $row_DetailRS1['nro_operacion_car']; ?>" size="15" maxlength="7">
      </span></span><span class="etiqueta12"><span class="respuestacolumna_rojo">L000000</span></span></td>
      <td align="right">Mandato / Passport:</td>
      <td align="center"><input name="mandato" type="text" class="etiqueta12" id="mandato" value="<?php echo $row_DetailRS2['estado_mandato']; ?>" size="30" maxlength="25" readonly="readonly"> 
      / 
      <input name="cliente_passport" type="text" class="respuestacolumna_rojo" id="cliente_passport" value="<?php echo $row_DetailRS2['cliente_passport']; ?>" size="3" maxlength="2"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Moneda / <br>
      Monto Operaci&oacute;n:</td>
      <td align="center">
          <select name="moneda_operacion" class="etiqueta12" id="moneda_operacion">
            <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>CLP</option>
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
          </select>
          <span class="rojopequeno">/</span>
          <input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['saldo_operacion']; ?>" size="20" maxlength="20">
      </div></td>
      <td align="right">Urgente:</div></td>
      <td align="center">
          <label>
          <input type="radio" name="urgente" value="Si">
          Si</label>
          <label>
          <input name="urgente" type="radio" value="No" checked>
          No</label>
          <br>
      </td>
    </tr>
    <tr valign="middle">
      <td align="right"></div>
Fuera Horario:</td>
      <td align="center"><label>
        <input name="fuera_horario" type="radio" class="etiqueta12" id="campana_comex_1" value="Si">
        Si</label>
        <input name="fuera_horario" type="radio" class="etiqueta12" id="campana_comex_0" value="No" checked>
No</div></td>
      <td align="right">Origen Fondos:</td>
      <td align="center"><select name="origen_fondos" class="etiqueta12" id="origen_fondos">
        <option value="N/A">Seleccione una Opcion</option>
        <option value="CTA. CTE.">CTA. CTE.</option>
        <option value="V.A.">V.A.</option>
        <option value="MT910.">MT910</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="left" bgcolor="#999999"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"><span class="titulodetalle">Excepci&oacute;n</span><br>      </td>
    </tr>
    <tr valign="middle">
      <td rowspan="3" align="right">Excepci&oacute;n:</td>
      <td rowspan="3" align="center"><label>
        <input type="radio" name="excepcion" value="Si">
        Si</label>
        <label>
          <input name="excepcion" type="radio" value="No" checked>
      No</label></td>
      <td align="right">Auto. Opera.:</td>
      <td align="center"><input name="autorizacion_operaciones" type="text" class="etiqueta12" id="autorizacion_operaciones" value="" size="30" maxlength="50"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Auto. Espe.:</td>
      <td align="center"><input name="autorizacion_especilista" type="text" class="etiqueta12" id="autorizacion_especilista" size="30" maxlength="50"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Resp. Excepci&oacute;n:</td>
      <td align="center"><input name="responsable_excepcion" type="text" class="etiqueta12" id="responsable_excepcion" size="30" maxlength="50"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Tipo Excepci&oacute;n:</td>
      <td align="left"><input name="tipo_excepcion" type="text" class="etiqueta12" id="tipo_excepcion" value="N/A" size="30" maxlength="50">
      <span class="rojopequeno">Max 50 Caracteres</span></td>
      <td align="right">Soluci&oacute;n Excepci&oacute;n:</td>
      <td align="center"><span id="sprytextfield3">
      <input name="solucion_excepcion" type="text" class="etiqueta12" id="solucion_excepcion" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span></span><span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="left" bgcolor="#999999"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"><span class="titulodetalle">Reparo</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Estado Operaci&oacute;n:</td>
      <td colspan="3" align="left"><label>
        <input name="estado" type="radio" id="estado_0" value="Preingresada." checked>
        Preingresada </label>
        <label>
          <input name="estado" type="radio" class="respuestacolumna_rojo" id="estado_1" value="Reparada.">
      <span class="respuestacolumna_rojo">Reparada</span></label></td>
    </tr>
    <tr valign="middle">
      <td align="right">Observaci&oacute;n Reparo:</td>
      <td colspan="3" align="left"><span id="sprytextarea2">
      <textarea name="reparo_obs" cols="80" rows="6" class="etiqueta12" id="reparo_obs"></textarea>
      <span class="rojopequeno"><span id="countsprytextarea2">&nbsp;</span></span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="center">
          <input type="submit" class="boton" value="Ingresar Instrucci&oacute;n">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
  <input type="hidden" name="date_ingreso" value="<?php echo date("Y-m-d"); ?>" size="32">
  <input name="date_preingreso" type="hidden" id="date_preingreso" value="<?php echo date("Y-m-d H:i:s"); ?>" size="32">
  <input name="tipo_operacion" type="hidden" id="tipo_operacion" value="Prestamo LCI.">
  <input name="estado_visacion" type="hidden" id="estado_visacion" value="Cursada.">
  <input name="ejecutivo_cuenta" type="hidden" id="ejecutivo_cuenta" value="<?php echo $row_DetailRS2['nombre_ejecutivo']; ?>">
  <input name="ejecutivo_ni" type="hidden" id="ejecutivo_ni" value="<?php echo $row_DetailRS2['ejecutivo']; ?>">
  <input name="especialista_ni" type="hidden" id="especialista_ni" value="<?php echo $row_DetailRS2['especialista']; ?>">
  <input name="nombre_oficina" type="hidden" id="nombre_oficina" value="<?php echo $row_DetailRS2['oficina']; ?>">
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {minChars:0, maxChars:450, counterId:"countsprytextarea2", counterType:"chars_remaining", isRequired:false});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {validateOn:["blur"], minChars:0, maxChars:10, minValue:0, maxValue:9999999999});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
mysqli_free_result($DetailRS2);
?>