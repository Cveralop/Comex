<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,SUP,OPE,GER";
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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO opcce (rut_cliente, nombre_cliente, fecha_ingreso, evento, nro_operacion, especialista, moneda_operacion, monto_operacion, pais, banco_destino, referencia, confirmacion, tipo_confirmacion, reparo_espe, reparo_obs) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['especialista'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['pais'], "text"),
                       GetSQLValueString($_POST['banco_destino'], "text"),
                       GetSQLValueString($_POST['referencia'], "text"),
                       GetSQLValueString($_POST['confirmacion'], "text"),
                       GetSQLValueString($_POST['tipo_confirmacion'], "text"),
                       GetSQLValueString($_POST['reparo_espe'], "text"),
                       GetSQLValueString($_POST['reparo_obs'], "text"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
  $insertGoTo = "ingmae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
$colname_DetailRS1 = "1";
if (isset($_GET['id'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opcce WHERE id = %s", $colname_DetailRS1);
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
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
$query_DetailRS1 = sprintf("SELECT * FROM opcce  WHERE id = $recordID", $colname_reparos);
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
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso Carta de Cr&eacute;dito de Exportaciones - Detalle</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
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
.Estilo5 {
	font-size: 14px;
	color: #FF0000;
	font-weight: bold;
}
.Estilo6 {font-size: 12px; font-weight: bold; color: #FFFFFF; }
.Estilo7 {color: #FF0000}

</style>
<script src="../../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
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
        if (isNaN(val)) errors+='- '+nm+' debe ser numerico.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es requerido.\n'; }
  } if (errors) alert('El(los) siguiente(s) error(es) ha(n) ocurrido:\n'+errors);
  document.MM_returnValue = (errors == '');
}
</script>
</style>
<script> 
var segundos=1200
var direccion='../cierre.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<link href="../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO CONFIRMACI&Oacute;N CARTA DE CR&Eacute;DITO DE EXPORTACIONES - DETALLE </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTA DE CR&Eacute;DITO DE EXPORTACI&Oacute;N </td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" onSubmit="MM_validateForm('rut_cliente','','R','nombre_cliente','','R','fecha_ingreso','','R','evento','','R','nro_operacion','','R','especialista','','R','moneda_operacion','','R','monto_operacion','','RisNum','reparo_espe','','R','confirmacion','','R','referencia','','R','reparo_obs','','R');return document.MM_returnValue">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline" bgcolor="#999999">
      <td colspan="6" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="titulodetalle">Detalle Confirmaci&oacute;n Carta de Cr&eacute;dito Exportaciones </div>
      </span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Rut Cliente:</td>
      <td colspan="5" align="left" valign="middle">
          <input name="rut_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15">
          <span class="rojopequeno">Sin puntos ni Guion</span></div>
      </div>      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="5" align="left" valign="middle"><input name="nombre_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td colspan="3" align="center" valign="middle">
        <input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10">
          <span class="rojopequeno">dd-mm-aaaa</span></div></td>
      <td align="right" valign="middle">Evento:</div></td>
      <td align="center" valign="middle">
        <input name="evento" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['evento']; ?>" size="20" maxlength="20">
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nro Operaci&oacute;n:</td>
      <td colspan="3" align="center" valign="middle">
        <input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="15" maxlength="7">        
        <span class="rojopequeno">E000000</span></div></td>
      <td align="right" valign="middle">Especialista:</div></td>
      <td align="center" valign="middle">
        <input name="especialista" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista']; ?>" size="20" maxlength="20">
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Moneda:</td>
      <td colspan="3" align="center" valign="middle">
        <input name="moneda_operacion" type="text" class="etiqueta12" id="moneda_operacion" value="<?php echo $row_DetailRS1['moneda_operacion']; ?>" size="5" maxlength="3">
      </div></td>
      <td align="right" valign="middle">Monto:</div></td>
      <td align="center" valign="middle">
        <input name="monto_operacion" type="text" class="etiqueta12" id="monto_operacion" value="<?php echo $row_DetailRS1['monto_operacion'] + $row_DetailRS1['monto_documento']; ?>" size="17" maxlength="15">
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Solicitud: </td>
      <td colspan="5" align="left" valign="middle"><input name="reparo_espe" type="text" class="etiqueta12" value="Solicitud de Autorizaci&oacute;n Corresponsal" size="100" maxlength="100"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Reparo Observaciones:</td>
      <td colspan="5" align="left" valign="middle"><span id="sprytextarea1">
        <textarea name="reparo_obs" cols="80" rows="10" class="etiqueta12">Fecha de Embarque:
Validez:
Pago:
Importador, Pa&iacute;s:
Mercader&iacute;a:
Cliente:
Reembolso:
Gastos:
Emb. Parciales:</textarea>
      <span class="rojopequeno" id="countsprytextarea1">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Confirmaci&oacute;n:</div></td>
      <td align="center" valign="middle">
        <input name="confirmacion" type="text" class="etiqueta12" id="confirmacion" value="<?php echo $row_DetailRS1['confirmacion']; ?>" size="3" maxlength="3">
      </div></td>
      <td align="right" valign="middle">Tipo Confirmaci&oacute;n:</td>
      <td align="center" valign="middle">
      <select name="tipo_confirmacion" class="etiqueta12" id="tipo_confirmacion">
            <option value="Confirmacion y Pago Anticipado." selected>Confirmacion y Pago Anticipado</option>
            <option value="Confirmacion y Financiamiento.">Confirmacion y Financiamiento</option>
            <option value="Financiamiento.">Financiamiento</option>
            <option value="Cesion de Derechos.">Cesion de Derechos</option>
            <option value="Compromiso de Pago/Cesion de Derecho.">Compromiso de Pago/Cesion de Derecho</option>
        </select>
      </div></td>
      <td align="right" valign="middle">Referencia:</td>
      <td align="center" valign="middle">
        <input name="referencia" type="text" class="etiqueta12" id="referencia" value="<?php echo $row_DetailRS1['referencia']; ?>" size="22" maxlength="20">
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Pa&iacute;s:</td>
      <td colspan="2" align="center" valign="middle">
        <input name="pais" type="text" class="etiqueta12" id="pais" value="<?php echo $row_DetailRS1['pais']; ?>" size="25" maxlength="20">
      </div></td>
      <td align="right" valign="middle">Banco Emisor:</td>
      <td colspan="2" align="center" valign="middle"><input name="banco_destino" type="text" class="etiqueta12" id="banco_destino" value="<?php echo $row_DetailRS1['banco_destino']; ?>" size="55" maxlength="50"></td>
    </tr>
    <tr valign="baseline">
      <td colspan="6" align="center" valign="middle">
        <input type="submit" class="boton" value="Ingresar Carta">
      </div></td>
    </tr>
  </table>
  <input name="rut_cliente" type="hidden" id="rut_cliente" value="<?php echo $row_DetailRS1['rut_cliente']; ?>">
  <input name="nombre_cliente" type="hidden" id="nombre_cliente" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="ingmae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:800, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
//-->
</script>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>