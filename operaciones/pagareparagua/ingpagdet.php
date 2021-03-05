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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pagareparagua (rut_cliente, nombre_cliente, moneda_pagare, monto_pagare, moneda_convenio, monto_convenio, doc_1, doc_2, doc_3, doc_4, doc_5, fecha_suscripcion_pagare, fecha_suscripcion_convenio, aval_rut_1, aval_nom_1, aval_rut_2, aval_nom_2, aval_rut_3, aval_nom_3, aval_rut_4, aval_nom_4, producto, observacion, estado, fecha_ingreso, registro_ingreso, sucursal, ultimafecha) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['moneda_pagare'], "text"),
                       GetSQLValueString($_POST['monto_pagare'], "double"),
                       GetSQLValueString($_POST['moneda_convenio'], "text"),
                       GetSQLValueString($_POST['monto_convenio'], "double"),
                       GetSQLValueString($_POST['doc_1'], "text"),
                       GetSQLValueString($_POST['doc_2'], "text"),
                       GetSQLValueString($_POST['doc_3'], "text"),
                       GetSQLValueString($_POST['doc_4'], "text"),
                       GetSQLValueString($_POST['doc_5'], "text"),
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
                       GetSQLValueString($_POST['producto'], "text"),
                       GetSQLValueString($_POST['observacion'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "date"),
                       GetSQLValueString($_POST['registro_ingreso'], "text"),
                       GetSQLValueString($_POST['sucursal'], "text"),
                       GetSQLValueString($_POST['ultimafecha'], "date"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
  $insertGoTo = "ingpagmae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
$colname_DetailRS1 = "1";
if (isset($_GET['rut_cliente'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['rut_cliente'] : addslashes($_GET['rut_cliente']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = sprintf("SELECT * FROM cliente  WHERE id = $recordID", $colname_ingreso);
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysqli_query($comercioexterior, $query_limit_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1);
  $totalRows_DetailRS1 = mysqli_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso Pagare - Detalle</title>
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
<!--
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
//-->
</script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO PAGAR&Eacute; PARAGUA  - DETALLE</td>
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
      <td colspan="3" align="left" valign="middle"><span id="sprytextfield3">
      <input name="rut_cliente" type="text" disabled class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15" readonly="readonly">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><label>
          <input name="nombre_cliente2" type="text" disabled class="etiqueta12" id="nombre_cliente" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="120" maxlength="122" readonly="readonly">
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
        Anexo.</label>
        <label>
          <input name="doc_4" type="checkbox" id="doc_4" value="Anexo WEB.">
      Anexo WEB
      <input name="doc_5" type="checkbox" id="doc_5" value="Reconocimiento Deuda.">
      Reconocimiento Deuda</label></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Observaciones:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextarea1">
      <textarea name="observacion" cols="80" rows="4" class="etiqueta12" id="observacion"></textarea>
      <span class="rojopequeno"><span id="countsprytextarea1">&nbsp;</span></span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
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
      <td align="right" valign="middle">Sucursal:</td>
      <td align="center" valign="middle"><label>
        <select name="sucursal" class="etiqueta12" id="sucursal">
          <option value="Casa Matriz." selected>Casa Matriz</option>
          <option value="Oficina.">Oficina</option>
        </select>
      </label></td>
      <td align="right" valign="middle">Producto:</td>
      <td align="center" valign="middle"><label>
        <select name="producto" class="etiqueta12" id="producto">
          <option value="N/A" selected>Seleccione Una Opcion</option>
          <option value="Cartas de Credito Import.">Cartas de Credito Import</option>
          <option value="Op Contado.">Op Contado</option>
          <option value="Prestamo.">Prestamo</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle">
        <input type="submit" class="boton" value="Ingreso Pagar&eacute; Paragua">
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