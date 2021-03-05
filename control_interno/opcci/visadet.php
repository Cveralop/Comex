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
$query_DetailRS1 = sprintf("SELECT * FROM opcci nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores nolock";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);

$colname_DetailRS2 = "Vigente.";
if (isset($_GET['estado'])) {
  $colname_DetailRS2 = $_GET['estado'];
}
$colname1_DetailRS2 = "-1";
if (isset($_GET['recordID'])) {
  $colname1_DetailRS2 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS2 = sprintf("SELECT pagareparagua.* FROM opcci INNER JOIN pagareparagua ON opcci.rut_cliente=pagareparagua.rut_cliente WHERE pagareparagua.estado = %s and opcci.id = %s", GetSQLValueString($colname_DetailRS2, "text"),GetSQLValueString($colname1_DetailRS2, "int"));
$DetailRS2 = mysqli_query($comercioexterior, $query_DetailRS2) or die(mysqli_error($comercioexterior));
$row_DetailRS2 = mysqli_fetch_assoc($DetailRS2);
$totalRows_DetailRS2 = mysqli_num_rows($DetailRS2);

$colname_convenioweb = "Vigente.";
if (isset($_GET['estado'])) {
  $colname_convenioweb = $_GET['estado'];
}
$colname1_convenioweb = "-1";
if (isset($_GET['recordID'])) {
  $colname1_convenioweb = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_convenioweb = sprintf("SELECT convenioweb.* FROM opcci INNER JOIN convenioweb ON opcci.rut_cliente=convenioweb.rut_cliente WHERE convenioweb.estado = %s and opcci.id = %s", GetSQLValueString($colname_convenioweb, "text"),GetSQLValueString($colname1_convenioweb, "int"));
$convenioweb = mysqli_query($comercioexterior, $query_convenioweb) or die(mysqli_error($comercioexterior));
$row_convenioweb = mysqli_fetch_assoc($convenioweb);
$totalRows_convenioweb = mysqli_num_rows($convenioweb);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE opcci SET evento=%s, estado=%s, nro_operacion=%s, nro_operacion_relacionada=%s, obs=%s, moneda_operacion=%s, monto_operacion=%s, pais=%s, banco_destino=%s, sub_estado=%s, date_visa=%s, forward=%s, reparo_obs=%s, estado_visacion=%s, visador=%s, mandato=%s, excepcion=%s, autorizacion_operaciones=%s, autorizacion_especialista=%s, responsable_excepcion=%s, tipo_excepcion=%s, solucion_excepcion=%s, urgente=%s, fuera_horario=%s WHERE id=%s",
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['nro_operacion_relacionada'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['pais'], "text"),
                       GetSQLValueString($_POST['banco_destino'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['forward'], "text"),
                       GetSQLValueString($_POST['reparo_obs'], "text"),
                       GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['visador'], "text"),
                       GetSQLValueString($_POST['mandato'], "text"),
                       GetSQLValueString($_POST['excepcion'], "text"),
                       GetSQLValueString($_POST['autorizacion_operaciones'], "text"),
                       GetSQLValueString($_POST['autorizacion_especialista'], "text"),
                       GetSQLValueString($_POST['responsable_excepcion'], "text"),
                       GetSQLValueString($_POST['tipo_excepcion'], "text"),
                       GetSQLValueString($_POST['solucion_excepcion'], "date"),
                       GetSQLValueString($_POST['urgente'], "text"),
                       GetSQLValueString($_POST['fuera_horario'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));

  $updateGoTo = "visamae.php";
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
<title>Visaci&oacute;n -  Detalle</title>
<style type="text/css">
<!--
@import url("../../estilos/estilo12.css");
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
.Estilo5 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {
	font-size: 16px;
	color: #FF0000;
	font-weight: bold;
}
.Estilo7 {font-size: 14px}
.Estilo8 {font-size: 14px}
-->
</style>
<script src="../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
<link href="../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../imagenes/barraweb/animated_favicon1.gif">


<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">VISACI&Oacute;N - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTAS DE CR&Eacute;DITO DE IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form name="form2" method="post" action="">
  <?php if ($totalRows_DetailRS2 > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="9" align="left" valign="middle" bgcolor="#999999"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="titulo_menu">Pagare Paragua - Visaci&oacute;n</span></td>
    </tr>
    <tr>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tipo Documentos</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Pagar&eacute;</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Convenio</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Aval 1</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Aval 2</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Aval 3</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Aval 4</td>
    </tr>
    <?php do { ?>
      <tr valign="middle">
        <td align="center" valign="middle"><?php echo $row_DetailRS2['estado']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><span class="rojopequeno"><?php echo $row_DetailRS2['doc1']; ?></span> / <span class="rojopequeno"><?php echo $row_DetailRS2['doc2']; ?></span> / <span class="rojopequeno"><?php echo $row_DetailRS2['doc3']; ?></span> / <span class="rojopequeno"><?php echo $row_DetailRS2['doc4']; ?></span> / <span class="rojopequeno"><?php echo $row_DetailRS2['doc5']; ?></span></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_DetailRS2['rut_cliente']); ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_DetailRS2['moneda_pagare']; ?></span></span> <span class="respuestacolumna_azul"><?php echo number_format($row_DetailRS2['monto_pagare'], 2, ',', '.'); ?></span></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_DetailRS2['moneda_convenio']; ?></span></span> <span class="respuestacolumna_azul"><?php echo number_format($row_DetailRS2['monto_convenio'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS2['aval_rut_1']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS2['aval_rut_2']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS2['aval_rut_3']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS2['aval_rut_4']); ?></td>
        <?php } while ($row_DetailRS2 = mysqli_fetch_assoc($DetailRS2)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</form>
<br>
<form name="form3" method="post" action="">
  <?php if ($totalRows_convenioweb > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td height="27" colspan="9" align="left" valign="middle" bgcolor="#999999"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="titulo_menu">Convenio WEB</span></td>
    </tr>
    <tr>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tipo Documentos</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Pagar&eacute;</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Convenio</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Aval 1</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Aval 2</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Aval 3</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Aval 4</td>
    </tr>
    <?php do { ?>
    <tr valign="middle">
      <td align="center" valign="middle"><?php echo $row_convenioweb['estado']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><span class="rojopequeno"><?php echo $row_convenioweb['doc_1']; ?></span> / <span class="rojopequeno"><?php echo $row_convenioweb['doc_2']; ?></span> / <span class="rojopequeno"><?php echo $row_convenioweb['doc_3']; ?></span> / <span class="rojopequeno"><?php echo $row_convenioweb['doc_6']; ?></span></td>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_convenioweb['rut_cliente']); ?></td>
      <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_convenioweb['moneda_pagare']; ?></span></span> <span class="respuestacolumna_azul"><?php echo number_format($row_convenioweb['monto_pagare'], 2, ',', '.'); ?></span></td>
      <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_convenioweb['moneda_convenio']; ?></span></span> <span class="respuestacolumna_azul"><?php echo number_format($row_convenioweb['monto_convenio'], 2, ',', '.'); ?></span></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_convenioweb['aval_rut_1']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_convenioweb['aval_rut_2']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_convenioweb['aval_rut_3']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_convenioweb['aval_rut_4']); ?></td>
      <?php } while ($row_convenioweb = mysqli_fetch_assoc($convenioweb)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</form>
<br>
<br>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="4" align="left" valign="middle"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulodetalle">Visaci&oacute;n Operaci&oacute;n</span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nro Registro:</td>
      <td align="center" valign="middle"><span class="nroregistro"><?php echo $row_DetailRS1['id']; ?></span>        </div></td>
      <td align="right" valign="middle">Rut Cliente:</div></td>
      <td align="center" valign="middle">
        <input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="12" readonly="readonly">
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120" readonly="readonly"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="center" valign="middle">
        <input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_ingreso']; ?>" size="12" maxlength="10" readonly="readonly">
      <span class="rojopequeno">(dd-mm-aaaa)</span></div></td>
      <td align="right" valign="middle">Evento:</div></td>
      <td align="center" valign="middle">        <select name="evento" class="etiqueta12" id="evento">
        <option value="Apertura." <?php if (!(strcmp("Apertura.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Apertura</option>
        <option value="Modificacion." <?php if (!(strcmp("Modificacion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Modificacion</option>
        <option value="Endoso Anticipado." <?php if (!(strcmp("Endoso Anticipado.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Endoso Anticipado</option>
        <option value="Alzamiento." <?php if (!(strcmp("Alzamiento.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Alzamiento</option>
        <option value="Anulacion." <?php if (!(strcmp("Anulacion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Anulacion</option>
        <option value="Alzamiento Anticipado." <?php if (!(strcmp("Alzamiento Anticipado.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Alzamiento Anticipado</option>
        <option value="Carta Original." <?php if (!(strcmp("Carta Original.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Carta Original</option>
        <option value="Requerimiento." <?php if (!(strcmp("Requerimiento.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Requerimiento</option>
        <option value="Solucion Excepcion." <?php if (!(strcmp("Solucion Excepcion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Solucion Excepcion</option>
        <option value="Dev Comisiones." <?php if (!(strcmp("Dev Comisiones.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Dev Comisiones</option>
        <option value="Pagare Paragua." <?php if (!(strcmp("Pagare Paragua.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pagare Paragua</option>
        <option value="Pre Swift." <?php if (!(strcmp("Pre Swift.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pre Swift</option>
        <option value="Prorroga." <?php if (!(strcmp("Prorroga.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Prorroga</option>
        <option value="Pago." <?php if (!(strcmp("Pago.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pago</option>
        <option value="Prorroga y Pago." <?php if (!(strcmp("Prorroga y Pago.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Prorroga y Pago</option>
        <option value="Cambio Tasa." <?php if (!(strcmp("Cambio Tasa.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Cambio Tasa</option>
        <option value="Visacion." <?php if (!(strcmp("Visacion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Visacion (DI)</option>
        <option value="Cartera Vencida." <?php if (!(strcmp("Cartera Vencida.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Cartera Vencida</option>
        <option value="Restructuracion." <?php if (!(strcmp("Restructuracion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Restructuracion</option>
        <option value="Redenominacion." <?php if (!(strcmp("Redenominacion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Redenominacion</option>
      </select>
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Observaci&oacute;n:</div></td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
      <span class="rojopequeno" id="countsprytextarea1">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nro Operaci&oacute;n:</td>
      <td align="center" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="15" maxlength="7">
      <span class="rojopequeno">K000000 /
      <label>
        <input name="nro_operacion_relacionada" type="text" class="etiqueta12" id="nro_operacion_relacionada" value="<?php echo $row_DetailRS1['nro_operacion_relacionada']; ?>" size="15" maxlength="7">
      </label>
      L000000</span></td>
      <td align="right" valign="middle">Mandato:</td>
      <td align="center" valign="middle"><input name="mandato" type="text" class="etiqueta12" id="mandato" value="<?php echo $row_DetailRS1['mandato']; ?>"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Moneda / <br>
      Monto Operaci&oacute;n:</td>
      <td align="center" valign="middle">
          <select name="moneda_operacion" class="etiqueta12" id="moneda_operacion">
            <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>CLP</option>
            <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>DKK</option>
            <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>NOK</option>
            <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>SEK</option>
            <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>USD</option>
            <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>CAD</option>
            <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>AUD</option>
            <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>HKD</option>
            <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>EUR</option>
            <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>CHF</option>
            <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>GBP</option>
            <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>ZAR</option>
            <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>JPY</option>
            <option value="N/A" <?php if (!(strcmp("N/A", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>></option>
          </select> 
          <span class="rojopequeno">/</span>        
          <input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="17" maxlength="15">
      </div></td>
      <td align="right" valign="middle">Forward:</div></td>
      <td align="center" valign="middle">
        <input name="forward" type="text" class="destadado" size="20" maxlength="20">
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Urgente:</td>
      <td align="center" valign="middle"><label>
        <input <?php if (!(strcmp($row_DetailRS1['urgente'],"Si"))) {echo "checked=\"checked\"";} ?> type="radio" name="urgente" value="Si">
        Si</label>
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['urgente'],"No"))) {echo "checked=\"checked\"";} ?> name="urgente" type="radio" value="No">
          No</label>
      </div></td>
      <td align="right" valign="middle">Fuera Horario:</td>
      <td align="center" valign="middle"></div>
        <label>
          <input type="radio" name="fuera_horario" value="Si">
          Si</label>
        <label>
          <input name="fuera_horario" type="radio" value="No" checked>
      No</label></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle" bgcolor="#CCCCCC">Pais:</td>
      <td align="center" valign="middle" bgcolor="#CCCCCC"><input name="pais" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['pais']; ?>" size="25" maxlength="20"></td>
      <td align="right" valign="middle" bgcolor="#CCCCCC">Banco Destino:</td>
      <td align="center" valign="middle" bgcolor="#CCCCCC"><input name="banco_destino" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['banco_destino']; ?>" size="55" maxlength="50"></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="titulodetalle">Excepci&oacute;n Operaci&oacute;n</span></td>
    </tr>
    <tr valign="middle">
      <td rowspan="3" align="right" valign="middle">Excepci&oacute;n:</td>
      <td rowspan="3" align="center" valign="middle"><label>
        <input type="radio" name="excepcion" value="Si">
        Si</label>
        <label>
          <input name="excepcion" type="radio" value="No" checked>
      No</label></td>
      <td align="right" valign="middle">Auto. Opera.:</div></td>
      <td align="center" valign="middle">
        <input name="autorizacion_operaciones" type="text" class="etiqueta12" value="Miguel Aguero Aldana" size="30" maxlength="50">
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Auto. Espe.:</td>
      <td align="center" valign="middle"><input name="autorizacion_especialista" type="text" class="etiqueta12" size="30" maxlength="50"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Resp. Excepci&oacute;n:</div></td>
      <td align="center" valign="middle"><label for="responsable_excepcion"></label>
      <input name="responsable_excepcion" type="text" class="etiqueta12" id="responsable_excepcion" size="30" maxlength="50">        </div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Tipo Excepci&oacute;n:</td>
      <td colspan="3" align="left" valign="middle">
      <select name="tipo_excepcion" class="etiqueta12" id="tipo_excepcion">
        <option value="N/A." selected>N/A</option>
            <option value="Art 85 Vencido.">Art 85 Vencido</option>
            <option value="Linea de Credito sobregirada.">Linea de Credito sobregirada</option>
            <option value="Falta Autorizacion de Riesgos.">Falta Autorizacion de Riesgos</option>
            <option value="Aprobaci&oacute;o puntual de Riesgos no incluye tolerancia.">Aprobacion puntual de Riesgos no incluye tolerancia</option>
            <option value="Falta minuta de Credito.">Falta minuta de Credito</option>
            <option value="Firma disconforme.">Firma disconforme</option>
            <option value="Falta VB&ordm; poderes y firmas.">Falta VB&ordm; poderes y firmas</option>
            <option value="Falta mail Sucursal por pagare en custodia.">Falta mail Sucursal por pagare en custodia</option>
            <option value="Pagare sin llenar.">Pagare sin llenar</option>
            <option value="Pagare no corresponde.">Pagare no corresponde</option>
            <option value="Pagare version antigua.">Pagare version antigua</option>
            <option value="Falta pagare para aumento de valor de operacion.">Falta pagare para aumento de valor de operacion</option>
            <option value="Falta informe de fiscalia para avales sociedad anonima.">Falta informe de fiscalia para avales sociedad anonima</option>
            <option value="Avales no corresponde en pagare seg&uacute;n lo solicitado por riesgo.">Avales no corresponde en pagare seg&uacute;n lo solicitado por riesgo</option>
            <option value="Certificado de matrimonio avales vencidos o no se encuentra en nuestros archivos.">Certificado de matrimonio avales vencidos o no se encuentra en nuestros archivos</option>
            <option value="Falta constitucion de garantias.">Falta constitucion de garantias</option>
	    <option value="Carta solicitud en fotocopia.">Carta solicitud en fotocopia</option>
</select>
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Solucion Excepcion:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextfield1">
      <input name="solucion_excepcion" type="text" class="etiqueta12" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span>        </div>
      <span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"><span class="titulodetalle">Reparo</span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Estado Visaci&oacute;n:</div></td>
      <td colspan="3" align="left" valign="middle"><label>
        <input name="estado" type="radio" id="estado_0" value="Pendiente." checked>
        Enviada a Curse</label>
        <label>
          <input name="estado" type="radio" class="respuestacolumna_rojo" id="estado_1" value="Reparada.">
          <span class="respuestacolumna_rojo">Reparada</span></label>
        <br>
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Observaci&oacute;n Reparo:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextarea2">
        <textarea name="reparo_obs" cols="80" rows="6" class="etiqueta12" id="reparo_obs"></textarea>
      <span class="rojopequeno" id="countsprytextarea2">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></div></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="center" valign="middle">
          <input type="submit" class="boton" value="Visar Operaci&oacute;n">
      </div>        </div>        </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
  <input name="date_visa" type="hidden" id="date_visa" value="<?php echo date("Y-m-d H:i:s"); ?>">
  <input name="estado_visacion" type="hidden" id="estado_visacion" value="Cursada.">
  <input name="visador" type="hidden" class="etiqueta12" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="visamae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false, minChars:0, maxChars:450, validateOn:["blur"], counterId:"countsprytextarea2", counterType:"chars_remaining"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
mysqli_free_result($colores);
mysqli_free_result($DetailRS2);
mysqli_free_result($convenioweb);
?>