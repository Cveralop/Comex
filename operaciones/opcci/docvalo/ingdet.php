<?php require_once('../../../Connections/comercioexterior.php'); ?>
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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE opcci SET obs=%s, moneda_operacion=%s, monto_operacion=%s, tipo_negociacion=%s, despacho_doctos=%s, ope_doc_val=%s, referencia=%s, numero_neg=%s, fecha_neg=%s, fecha_endoso=%s, estado_doc=%s, garantia=%s, can1=%s, can2=%s, can3=%s, can4=%s, can5=%s, can6=%s, can7=%s, can8=%s, can9=%s, can10=%s, can11=%s, can12=%s, can13=%s, can14=%s, can15=%s, can16=%s, can17=%s, can18=%s, can19=%s, can20=%s, doc1=%s, doc2=%s, doc3=%s, doc4=%s, doc5=%s, doc6=%s, doc7=%s, doc8=%s, doc9=%s, doc10=%s WHERE id=%s",
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['tipo_negociacion'], "text"),
                       GetSQLValueString($_POST['despacho_doctos'], "text"),
                       GetSQLValueString($_POST['ope_doc_val'], "text"),
                       GetSQLValueString($_POST['referencia'], "text"),
                       GetSQLValueString($_POST['numero_neg'], "int"),
                       GetSQLValueString($_POST['fecha_neg'], "text"),
                       GetSQLValueString($_POST['fecha_endoso'], "text"),
                       GetSQLValueString($_POST['estado_doc'], "text"),
                       GetSQLValueString($_POST['garantia'], "text"),
                       GetSQLValueString($_POST['can1'], "int"),
                       GetSQLValueString($_POST['can2'], "int"),
                       GetSQLValueString($_POST['can3'], "int"),
                       GetSQLValueString($_POST['can4'], "int"),
                       GetSQLValueString($_POST['can5'], "int"),
                       GetSQLValueString($_POST['can6'], "int"),
                       GetSQLValueString($_POST['can7'], "int"),
                       GetSQLValueString($_POST['can8'], "int"),
                       GetSQLValueString($_POST['can9'], "int"),
                       GetSQLValueString($_POST['can10'], "int"),
                       GetSQLValueString($_POST['can11'], "int"),
                       GetSQLValueString($_POST['can12'], "int"),
                       GetSQLValueString($_POST['can13'], "int"),
                       GetSQLValueString($_POST['can14'], "int"),
                       GetSQLValueString($_POST['can15'], "int"),
                       GetSQLValueString($_POST['can16'], "int"),
                       GetSQLValueString($_POST['can17'], "int"),
                       GetSQLValueString($_POST['can18'], "int"),
                       GetSQLValueString($_POST['can19'], "int"),
                       GetSQLValueString($_POST['can20'], "int"),
                       GetSQLValueString($_POST['doc1'], "text"),
                       GetSQLValueString($_POST['doc2'], "text"),
                       GetSQLValueString($_POST['doc3'], "text"),
                       GetSQLValueString($_POST['doc4'], "text"),
                       GetSQLValueString($_POST['doc5'], "text"),
                       GetSQLValueString($_POST['doc6'], "text"),
                       GetSQLValueString($_POST['doc7'], "text"),
                       GetSQLValueString($_POST['doc8'], "text"),
                       GetSQLValueString($_POST['doc9'], "text"),
                       GetSQLValueString($_POST['doc10'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "impdet.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$colname_DetailRS1 = "1";
if (isset($_GET['id'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opcci WHERE id = %s", $colname_DetailRS1);
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = "SELECT opcci.*,(cliente.sucursal)as sucsal FROM opcci INNER JOIN cliente ON cliente.rut_cliente = opcci.rut_cliente WHERE opcci.id = $recordID";
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
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso Documento Valorado - Detalle</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
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
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo8 {
	font-size: 14px;
	font-weight: bold;
	color: #FF0000;
}
-->
</style>
<script src="../../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
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
function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' Debe ser nuemerido.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' es numerico entre '+min+' y '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es requerido.\n'; }
  } if (errors) alert('El(Los) siguiente(s) error(es) ha(n) ocurrido:\n'+errors);
  document.MM_returnValue = (errors == '');
}
</script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
<link href="../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO DOCUMENTO VALORADO - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTAS DE CR&Eacute;DITO DE IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" onSubmit="MM_validateForm('monto_operacion','','R','despacho_doctos','','R','referencia','','R','ope_doc_val','','R','fecha_neg','','R','numero_neg','','RinRange1:100');return document.MM_returnValue">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr align="left" valign="middle" bgcolor="#999999">
      <td colspan="4" align="left"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Detalle Documentos Valorados</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Registro:</td>
      <td align="center"><span class="Estilo8"><?php echo $row_DetailRS1['id']; ?></span></td>
      <td align="right">Rut Cliente:</td>
      <td align="center"><input name="rut_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="15" maxlength="12">
      <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nombre Cliente:</td>
      <td colspan="3" align="left"><input name="nombre_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Moneda / Monto Operaci&oacute;n:</td>
      <td align="center"><select name="moneda_operacion" class="etiqueta12" id="moneda_operacion">
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
        <span class="rojopequeno">/</span><span id="sprytextfield1">
        <input name="monto_operacion" type="text" class="etiqueta12" id="monto_operacion" value="0" size="17" maxlength="15">
        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
      <td align="right">Nro Operaci&oacute;n: </td>
      <td align="center"><input name="nro_operacion" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="15" maxlength="7">
      <span class="rojopequeno">K000000</span> </td>
    </tr>
    <tr valign="middle">
      <td align="right">Moneda Monto <br>
      Documentos:</td>
      <td align="center"><input name="moneda_documentos" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['moneda_documentos']; ?>" size="5" maxlength="3"> 
      <span class="rojopequeno">/</span>        <input name="monto_documentos" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_documentos']; ?>" size="17" maxlength="15"></td>
      <td align="right">Tipo Negociaci&oacute;n: </td>
      <td align="center">        <select name="tipo_negociacion" class="etiqueta12" id="tipo_negociacion">
        <option value="" <?php if (!(strcmp("", $row_DetailRS1['tipo_negociacion']))) {echo "SELECTED";} ?>>Seleccione Opcion</option>
        <option value="Limpia." <?php if (!(strcmp("Limpia.", $row_DetailRS1['tipo_negociacion']))) {echo "SELECTED";} ?>>Limpia</option>
        <option value="Discrepancia." <?php if (!(strcmp("Discrepancia.", $row_DetailRS1['tipo_negociacion']))) {echo "SELECTED";} ?>>Discrepancia</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right">Despacho Documentos: </td>
      <td align="center"><input name="despacho_doctos" type="text" class="etiqueta12" id="despacho_doctos" value="<?php echo $row_DetailRS1['sucsal']; ?>" size="40" maxlength="50"></td>
      <td align="right">Referencia Cliente: </td>
      <td align="center"><input name="referencia" type="text" class="etiqueta12" id="referencia" value="<?php echo $row_DetailRS1['referencia']; ?>" size="40" maxlength="50"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Operador Documento Valorado: </td>
      <td colspan="3" align="left">
        <input name="ope_doc_val" type="text" class="etiqueta12" id="ope_doc_val" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20">
      </div></td>
    </tr>
  </table>
  <br>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr align="left" valign="middle" bgcolor="#999999">
      <td colspan="6" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Detalle</span></td>
    </tr>
    <tr valign="middle">
      <td width="18%" align="right" valign="middle">Observaci&oacute;n / Discrepancia: </td>
      <td colspan="5" align="left" valign="middle"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12"></textarea>
      <span class="rojopequeno" id="countsprytextarea1">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Fecha Negociaci&oacute;n:</td>
      <td width="29%" align="center" valign="middle"><input name="fecha_neg" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_neg']; ?>" size="12" maxlength="10">
      <span class="rojopequeno">(dd-mm-aaaa)</span></td>
      <td width="27%" align="right" valign="middle">Fecha Endoso Anticipado:</td>
      <td width="13%" align="center" valign="middle"><input name="fecha_endoso" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_endoso']; ?>" size="12" maxlength="10">
      <span class="rojopequeno">(dd-mm-aaaa)</span></td>
      <td width="13%" align="right" valign="middle">Numero Negociaci&oacute;n:</td>
      <td width="26%" align="center" valign="middle"><input name="numero_neg" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['numero_neg']; ?>" size="4" maxlength="3">
      <span class="rojopequeno">Nro.</span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Garantia:</td>
      <td colspan="5" align="left" valign="middle"><span id="sprytextarea2">
        <textarea name="garantia" cols="80" rows="4" class="etiqueta12"><?php echo $row_DetailRS1['garantia']; ?></textarea>
      <span class="rojopequeno" id="countsprytextarea2">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle" bgcolor="#999999">
      <td align="center" valign="middle"><span class="Estilo5">Cantidad Doctos </span></td>
      <td colspan="5" align="left" valign="middle"><span class="Estilo5">Documentos de Embarque </span></td>
    </tr>
    <tr valign="middle">
      <td align="center" valign="middle"><input name="can1" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can1']; ?>" size="5" maxlength="3"> 
      <span class="rojopequeno">/</span>      <input name="can11" type="text" class="etiqueta12" id="can11" value="<?php echo $row_DetailRS1['can11']; ?>" size="5" maxlength="3"></td>
      <td colspan="5" align="left" valign="middle"><select name="doc1" class="etiqueta12" id="doc1">
        <option value="" <?php if (!(strcmp("", $row_DetailRS1['doc1']))) {echo "SELECTED";} ?>>Seleccione una Opci&oacute;n</option>
        <option value="Conocimiento de Embarque Maritimo" <?php if (!(strcmp("Conocimiento de Embarque Maritimo", $row_DetailRS1['doc1']))) {echo "SELECTED";} ?>>Embarque Mar&iacute;timo</option>
        <option value="Conocimiento de Embarque Terrestre" <?php if (!(strcmp("Conocimiento de Embarque Terrestre", $row_DetailRS1['doc1']))) {echo "SELECTED";} ?>>Embarque Terrestre</option>
        <option value="Guia Area" <?php if (!(strcmp("Guia Area", $row_DetailRS1['doc1']))) {echo "SELECTED";} ?>>Ar&eacute;ro</option>
        <option value="Simple Recibo" <?php if (!(strcmp("Simple Recibo", $row_DetailRS1['doc1']))) {echo "SELECTED";} ?>>Simple Recibo</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="center" valign="middle"><input name="can2" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can2']; ?>" size="5" maxlength="3"> 
      <span class="rojopequeno">/</span>      <input name="can12" type="text" class="etiqueta12" id="can12" value="<?php echo $row_DetailRS1['can12']; ?>" size="5" maxlength="3"></td>
      <td colspan="5" align="left" valign="middle">        <select name="doc2" class="etiqueta12" id="doc2">
        <option value="" <?php if (!(strcmp("", $row_DetailRS1['doc2']))) {echo "SELECTED";} ?>>Seleccione una Opci&oacute;n</option>
        <option value="Factura Comercial" <?php if (!(strcmp("Factura Comercial", $row_DetailRS1['doc2']))) {echo "SELECTED";} ?>>Factura Comercial</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="center" valign="middle"><input name="can3" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can3']; ?>" size="5" maxlength="3">
      <span class="rojopequeno">/</span>      <input name="can13" type="text" class="etiqueta12" id="can13" value="<?php echo $row_DetailRS1['can13']; ?>" size="5" maxlength="3"></td>
      <td colspan="5" align="left" valign="middle">        <select name="doc3" class="etiqueta12" id="doc3">
        <option value="" <?php if (!(strcmp("", $row_DetailRS1['doc3']))) {echo "SELECTED";} ?>>Seleccione una Opci&oacute;n</option>
        <option value="Lista de Empaque" <?php if (!(strcmp("Lista de Empaque", $row_DetailRS1['doc3']))) {echo "SELECTED";} ?>>Lista de Empaque</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="center" valign="middle"><input name="can4" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can4']; ?>" size="5" maxlength="3">
      <span class="rojopequeno">/</span>      <input name="can14" type="text" class="etiqueta12" id="can14" value="<?php echo $row_DetailRS1['can14']; ?>" size="5" maxlength="3"></td>
      <td colspan="5" align="left" valign="middle"><select name="doc4" class="etiqueta12" id="doc4">
        <option value="" <?php if (!(strcmp("", $row_DetailRS1['doc4']))) {echo "SELECTED";} ?>>Seleccione una Opci&oacute;n</option>
        <option value="Certificado de Origen" <?php if (!(strcmp("Certificado de Origen", $row_DetailRS1['doc4']))) {echo "SELECTED";} ?>>Certificado de Origen</option>
        <option value="Certificado EUR 1" <?php if (!(strcmp("Certificado EUR 1", $row_DetailRS1['doc4']))) {echo "SELECTED";} ?>>Certificado EUR 1</option>
        <option value="Certificado de Peso" <?php if (!(strcmp("Certificado de Peso", $row_DetailRS1['doc4']))) {echo "SELECTED";} ?>>Certificado de Peso</option>
        <option value="Certificado Sanitario" <?php if (!(strcmp("Certificado Sanitario", $row_DetailRS1['doc4']))) {echo "SELECTED";} ?>>Certificado Sanitario</option>
        <option value="Certificado Fitosanitario" <?php if (!(strcmp("Certificado Fitosanitario", $row_DetailRS1['doc4']))) {echo "SELECTED";} ?>>Certificado Fitosanitario</option>
        <option value="Certificado de Analisis" <?php if (!(strcmp("Certificado de Analisis", $row_DetailRS1['doc4']))) {echo "SELECTED";} ?>>Certificado de Analisis</option>
        <option value="Certiticado de Calidad" <?php if (!(strcmp("Certiticado de Calidad", $row_DetailRS1['doc4']))) {echo "SELECTED";} ?>>Certiticado de Calidad</option>
        <option value="Certificado de Inspeccion" <?php if (!(strcmp("Certificado de Inspeccion", $row_DetailRS1['doc4']))) {echo "SELECTED";} ?>>Certificado de Inspeccion</option>
        <option value="Certificado de Fumigacion" <?php if (!(strcmp("Certificado de Fumigacion", $row_DetailRS1['doc4']))) {echo "SELECTED";} ?>>Certificado de Fumigacion</option>
        <option value="Nota de Gastos" <?php if (!(strcmp("Nota de Gastos", $row_DetailRS1['doc4']))) {echo "SELECTED";} ?>>Nota de Gastos</option>
        <option value="Poliza de Seguro" <?php if (!(strcmp("Poliza de Seguro", $row_DetailRS1['doc4']))) {echo "SELECTED";} ?>>Poliza de Seguro</option>
        <option value="Otro Certificado" <?php if (!(strcmp("Otro Certificado", $row_DetailRS1['doc4']))) {echo "SELECTED";} ?>>Otro Certificado</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="center" valign="middle"><input name="can5" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can5']; ?>" size="5" maxlength="3">
      <span class="rojopequeno">/</span>      <input name="can15" type="text" class="etiqueta12" id="can15" value="<?php echo $row_DetailRS1['can15']; ?>" size="5" maxlength="3"></td>
      <td colspan="5" align="left" valign="middle">        <select name="doc5" class="etiqueta12" id="doc5">
        <option value="" <?php if (!(strcmp("", $row_DetailRS1['doc5']))) {echo "SELECTED";} ?>>Seleccione una Opci&oacute;n</option>
        <option value="Certificado de Origen" <?php if (!(strcmp("Certificado de Origen", $row_DetailRS1['doc5']))) {echo "SELECTED";} ?>>Certificado de Origen</option>
        <option value="Certificado EUR 1" <?php if (!(strcmp("Certificado EUR 1", $row_DetailRS1['doc5']))) {echo "SELECTED";} ?>>Certificado EUR 1</option>
        <option value="Certificado de Peso" <?php if (!(strcmp("Certificado de Peso", $row_DetailRS1['doc5']))) {echo "SELECTED";} ?>>Certificado de Peso</option>
        <option value="Certificado Sanitario" <?php if (!(strcmp("Certificado Sanitario", $row_DetailRS1['doc5']))) {echo "SELECTED";} ?>>Certificado Sanitario</option>
        <option value="Certificado Fitosanitario" <?php if (!(strcmp("Certificado Fitosanitario", $row_DetailRS1['doc5']))) {echo "SELECTED";} ?>>Certificado Fitosanitario</option>
        <option value="Certificado de Analisis" <?php if (!(strcmp("Certificado de Analisis", $row_DetailRS1['doc5']))) {echo "SELECTED";} ?>>Certificado de Analisis</option>
        <option value="Certiticado de Calidad" <?php if (!(strcmp("Certiticado de Calidad", $row_DetailRS1['doc5']))) {echo "SELECTED";} ?>>Certiticado de Calidad</option>
        <option value="Certificado de Inspeccion" <?php if (!(strcmp("Certificado de Inspeccion", $row_DetailRS1['doc5']))) {echo "SELECTED";} ?>>Certificado de Inspeccion</option>
        <option value="Certificado de Fumigacion" <?php if (!(strcmp("Certificado de Fumigacion", $row_DetailRS1['doc5']))) {echo "SELECTED";} ?>>Certificado de Fumigacion</option>
        <option value="Nota de Gastos" <?php if (!(strcmp("Nota de Gastos", $row_DetailRS1['doc5']))) {echo "SELECTED";} ?>>Nota de Gastos</option>
        <option value="Poliza de Seguro" <?php if (!(strcmp("Poliza de Seguro", $row_DetailRS1['doc5']))) {echo "SELECTED";} ?>>Poliza de Seguro</option>
        <option value="Otro Certificado" <?php if (!(strcmp("Otro Certificado", $row_DetailRS1['doc5']))) {echo "SELECTED";} ?>>Otro Certificado</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="center" valign="middle"><input name="can6" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can6']; ?>" size="5" maxlength="3">
      <span class="rojopequeno">/</span>      <input name="can16" type="text" class="etiqueta12" id="can16" value="<?php echo $row_DetailRS1['can16']; ?>" size="5" maxlength="3"></td>
      <td colspan="5" align="left" valign="middle"><select name="doc6" class="etiqueta12" id="doc6">
        <option value="" <?php if (!(strcmp("", $row_DetailRS1['doc6']))) {echo "SELECTED";} ?>>Seleccione una Opci&oacute;n</option>
        <option value="Certificado de Origen" <?php if (!(strcmp("Certificado de Origen", $row_DetailRS1['doc6']))) {echo "SELECTED";} ?>>Certificado de Origen</option>
        <option value="Certificado EUR 1" <?php if (!(strcmp("Certificado EUR 1", $row_DetailRS1['doc6']))) {echo "SELECTED";} ?>>Certificado EUR 1</option>
        <option value="Certificado de Peso" <?php if (!(strcmp("Certificado de Peso", $row_DetailRS1['doc6']))) {echo "SELECTED";} ?>>Certificado de Peso</option>
        <option value="Certificado Sanitario" <?php if (!(strcmp("Certificado Sanitario", $row_DetailRS1['doc6']))) {echo "SELECTED";} ?>>Certificado Sanitario</option>
        <option value="Certificado Fitosanitario" <?php if (!(strcmp("Certificado Fitosanitario", $row_DetailRS1['doc6']))) {echo "SELECTED";} ?>>Certificado Fitosanitario</option>
        <option value="Certificado de Analisis" <?php if (!(strcmp("Certificado de Analisis", $row_DetailRS1['doc6']))) {echo "SELECTED";} ?>>Certificado de Analisis</option>
        <option value="Certiticado de Calidad" <?php if (!(strcmp("Certiticado de Calidad", $row_DetailRS1['doc6']))) {echo "SELECTED";} ?>>Certiticado de Calidad</option>
        <option value="Certificado de Inspeccion" <?php if (!(strcmp("Certificado de Inspeccion", $row_DetailRS1['doc6']))) {echo "SELECTED";} ?>>Certificado de Inspeccion</option>
        <option value="Certificado de Fumigacion" <?php if (!(strcmp("Certificado de Fumigacion", $row_DetailRS1['doc6']))) {echo "SELECTED";} ?>>Certificado de Fumigacion</option>
        <option value="Nota de Gastos" <?php if (!(strcmp("Nota de Gastos", $row_DetailRS1['doc6']))) {echo "SELECTED";} ?>>Nota de Gastos</option>
        <option value="Poliza de Seguro" <?php if (!(strcmp("Poliza de Seguro", $row_DetailRS1['doc6']))) {echo "SELECTED";} ?>>Poliza de Seguro</option>
        <option value="Otro Certificado" <?php if (!(strcmp("Otro Certificado", $row_DetailRS1['doc6']))) {echo "SELECTED";} ?>>Otro Certificado</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="center" valign="middle"><input name="can7" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can7']; ?>" size="5" maxlength="3">
      <span class="rojopequeno">/</span>      <input name="can17" type="text" class="etiqueta12" id="can17" value="<?php echo $row_DetailRS1['can17']; ?>" size="5" maxlength="3"></td>
      <td colspan="5" align="left" valign="middle"><select name="doc7" class="etiqueta12" id="doc7">
        <option value="" <?php if (!(strcmp("", $row_DetailRS1['doc7']))) {echo "SELECTED";} ?>>Seleccione una Opci&oacute;n</option>
        <option value="Certificado de Origen" <?php if (!(strcmp("Certificado de Origen", $row_DetailRS1['doc7']))) {echo "SELECTED";} ?>>Certificado de Origen</option>
        <option value="Certificado EUR 1" <?php if (!(strcmp("Certificado EUR 1", $row_DetailRS1['doc7']))) {echo "SELECTED";} ?>>Certificado EUR 1</option>
        <option value="Certificado de Peso" <?php if (!(strcmp("Certificado de Peso", $row_DetailRS1['doc7']))) {echo "SELECTED";} ?>>Certificado de Peso</option>
        <option value="Certificado Sanitario" <?php if (!(strcmp("Certificado Sanitario", $row_DetailRS1['doc7']))) {echo "SELECTED";} ?>>Certificado Sanitario</option>
        <option value="Certificado Fitosanitario" <?php if (!(strcmp("Certificado Fitosanitario", $row_DetailRS1['doc7']))) {echo "SELECTED";} ?>>Certificado Fitosanitario</option>
        <option value="Certificado de Analisis" <?php if (!(strcmp("Certificado de Analisis", $row_DetailRS1['doc7']))) {echo "SELECTED";} ?>>Certificado de Analisis</option>
        <option value="Certiticado de Calidad" <?php if (!(strcmp("Certiticado de Calidad", $row_DetailRS1['doc7']))) {echo "SELECTED";} ?>>Certiticado de Calidad</option>
        <option value="Certificado de Inspeccion" <?php if (!(strcmp("Certificado de Inspeccion", $row_DetailRS1['doc7']))) {echo "SELECTED";} ?>>Certificado de Inspeccion</option>
        <option value="Certificado de Fumigacion" <?php if (!(strcmp("Certificado de Fumigacion", $row_DetailRS1['doc7']))) {echo "SELECTED";} ?>>Certificado de Fumigacion</option>
        <option value="Nota de Gastos" <?php if (!(strcmp("Nota de Gastos", $row_DetailRS1['doc7']))) {echo "SELECTED";} ?>>Nota de Gastos</option>
        <option value="Poliza de Seguro" <?php if (!(strcmp("Poliza de Seguro", $row_DetailRS1['doc7']))) {echo "SELECTED";} ?>>Poliza de Seguro</option>
        <option value="Otro Certificado" <?php if (!(strcmp("Otro Certificado", $row_DetailRS1['doc7']))) {echo "SELECTED";} ?>>Otro Certificado</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="center" valign="middle"><input name="can8" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can8']; ?>" size="5" maxlength="3">
      <span class="rojopequeno">/</span>      <input name="can18" type="text" class="etiqueta12" id="can18" value="<?php echo $row_DetailRS1['can18']; ?>" size="5" maxlength="3"></td>
      <td colspan="5" align="left" valign="middle"><select name="doc8" class="etiqueta12" id="doc8">
        <option value="" <?php if (!(strcmp("", $row_DetailRS1['doc8']))) {echo "SELECTED";} ?>>Seleccione una Opci&oacute;n</option>
        <option value="Certificado de Origen" <?php if (!(strcmp("Certificado de Origen", $row_DetailRS1['doc8']))) {echo "SELECTED";} ?>>Certificado de Origen</option>
        <option value="Certificado EUR 1" <?php if (!(strcmp("Certificado EUR 1", $row_DetailRS1['doc8']))) {echo "SELECTED";} ?>>Certificado EUR 1</option>
        <option value="Certificado de Peso" <?php if (!(strcmp("Certificado de Peso", $row_DetailRS1['doc8']))) {echo "SELECTED";} ?>>Certificado de Peso</option>
        <option value="Certificado Sanitario" <?php if (!(strcmp("Certificado Sanitario", $row_DetailRS1['doc8']))) {echo "SELECTED";} ?>>Certificado Sanitario</option>
        <option value="Certificado Fitosanitario" <?php if (!(strcmp("Certificado Fitosanitario", $row_DetailRS1['doc8']))) {echo "SELECTED";} ?>>Certificado Fitosanitario</option>
        <option value="Certificado de Analisis" <?php if (!(strcmp("Certificado de Analisis", $row_DetailRS1['doc8']))) {echo "SELECTED";} ?>>Certificado de Analisis</option>
        <option value="Certiticado de Calidad" <?php if (!(strcmp("Certiticado de Calidad", $row_DetailRS1['doc8']))) {echo "SELECTED";} ?>>Certiticado de Calidad</option>
        <option value="Certificado de Inspeccion" <?php if (!(strcmp("Certificado de Inspeccion", $row_DetailRS1['doc8']))) {echo "SELECTED";} ?>>Certificado de Inspeccion</option>
        <option value="Certificado de Fumigacion" <?php if (!(strcmp("Certificado de Fumigacion", $row_DetailRS1['doc8']))) {echo "SELECTED";} ?>>Certificado de Fumigacion</option>
        <option value="Nota de Gastos" <?php if (!(strcmp("Nota de Gastos", $row_DetailRS1['doc8']))) {echo "SELECTED";} ?>>Nota de Gastos</option>
        <option value="Poliza de Seguro" <?php if (!(strcmp("Poliza de Seguro", $row_DetailRS1['doc8']))) {echo "SELECTED";} ?>>Poliza de Seguro</option>
        <option value="Otro Certificado" <?php if (!(strcmp("Otro Certificado", $row_DetailRS1['doc8']))) {echo "SELECTED";} ?>>Otro Certificado</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="center" valign="middle"><input name="can9" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can9']; ?>" size="5" maxlength="3">
      <span class="rojopequeno">/</span>      <input name="can19" type="text" class="etiqueta12" id="can19" value="<?php echo $row_DetailRS1['can19']; ?>" size="5" maxlength="3"></td>
      <td colspan="5" align="left" valign="middle"><select name="doc9" class="etiqueta12" id="doc9">
        <option value="" <?php if (!(strcmp("", $row_DetailRS1['doc9']))) {echo "SELECTED";} ?>>Seleccione una Opci&oacute;n</option>
        <option value="Certificado de Origen" <?php if (!(strcmp("Certificado de Origen", $row_DetailRS1['doc9']))) {echo "SELECTED";} ?>>Certificado de Origen</option>
        <option value="Certificado EUR 1" <?php if (!(strcmp("Certificado EUR 1", $row_DetailRS1['doc9']))) {echo "SELECTED";} ?>>Certificado EUR 1</option>
        <option value="Certificado de Peso" <?php if (!(strcmp("Certificado de Peso", $row_DetailRS1['doc9']))) {echo "SELECTED";} ?>>Certificado de Peso</option>
        <option value="Certificado Sanitario" <?php if (!(strcmp("Certificado Sanitario", $row_DetailRS1['doc9']))) {echo "SELECTED";} ?>>Certificado Sanitario</option>
        <option value="Certificado Fitosanitario" <?php if (!(strcmp("Certificado Fitosanitario", $row_DetailRS1['doc9']))) {echo "SELECTED";} ?>>Certificado Fitosanitario</option>
        <option value="Certificado de Analisis" <?php if (!(strcmp("Certificado de Analisis", $row_DetailRS1['doc9']))) {echo "SELECTED";} ?>>Certificado de Analisis</option>
        <option value="Certiticado de Calidad" <?php if (!(strcmp("Certiticado de Calidad", $row_DetailRS1['doc9']))) {echo "SELECTED";} ?>>Certiticado de Calidad</option>
        <option value="Certificado de Inspeccion" <?php if (!(strcmp("Certificado de Inspeccion", $row_DetailRS1['doc9']))) {echo "SELECTED";} ?>>Certificado de Inspeccion</option>
        <option value="Certificado de Fumigacion" <?php if (!(strcmp("Certificado de Fumigacion", $row_DetailRS1['doc9']))) {echo "SELECTED";} ?>>Certificado de Fumigacion</option>
        <option value="Nota de Gastos" <?php if (!(strcmp("Nota de Gastos", $row_DetailRS1['doc9']))) {echo "SELECTED";} ?>>Nota de Gastos</option>
        <option value="Poliza de Seguro" <?php if (!(strcmp("Poliza de Seguro", $row_DetailRS1['doc9']))) {echo "SELECTED";} ?>>Poliza de Seguro</option>
        <option value="Otro Certificado" <?php if (!(strcmp("Otro Certificado", $row_DetailRS1['doc9']))) {echo "SELECTED";} ?>>Otro Certificado</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="center" valign="middle"><input name="can10" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can10']; ?>" size="5" maxlength="3">
      <span class="rojopequeno">/</span>      <input name="can20" type="text" class="etiqueta12" id="can20" value="<?php echo $row_DetailRS1['can20']; ?>" size="5" maxlength="3"></td>
      <td colspan="5" align="left" valign="middle">      <input name="doc10" type="text" class="etiqueta12" id="doc10" value="<?php echo $row_DetailRS1['doc10']; ?>" size="110" maxlength="100"></td>
    </tr>
    <tr align="center" valign="baseline">
      <td colspan="6" align="center" valign="middle"><input name="Enviar" type="submit" class="etiqueta12" value="Ingresar Documento Valorado"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
  <input name="estado_doc" type="hidden" id="estado_doc" value="Pendiente.">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="ingmae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image4" width="80" height="25" border="0"></a></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea2", counterType:"chars_remaining"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "currency", {validateOn:["blur"]});
//-->
</script>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>