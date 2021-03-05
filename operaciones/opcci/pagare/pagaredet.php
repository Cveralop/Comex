<?php require_once('../../../Connections/comercioexterior.php'); ?>
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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE opcci SET obs=%s, especialista=%s, autorizacion_operaciones=%s, autorizacion_especialista=%s, tipo_excepcion=%s, solucion_excepcion=%s, estado_excepcion=%s, solucionado=%s WHERE id=%s",
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['especialista'], "text"),
                       GetSQLValueString($_POST['autorizacion_operaciones'], "text"),
                       GetSQLValueString($_POST['autorizacion_especialista'], "text"),
                       GetSQLValueString($_POST['tipo_excepcion'], "text"),
                       GetSQLValueString($_POST['solucion_excepcion'], "date"),
                       GetSQLValueString($_POST['estado_excepcion'], "text"),
                       GetSQLValueString($_POST['solucionado'], "date"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "mantenciomae.php";
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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = "SELECT * FROM opcci WHERE id = $recordID";
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Mantenci&oacute;n Excepciones - Detalle</title>
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
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {
	font-size: 14px;
	color: #FF0000;
	font-weight: bold;
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
    <td width="93%" align="left" valign="middle" class="Estilo3">MANTENCI&Oacute;N EXCEPCIONES - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTAS DE CR&Eacute;DITO DE IMPORTACI&Oacute;N </td>
  </tr>
</table>
<br>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="4" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Mantenci&oacute;n Excepci&oacute;n Administrativa</span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nro Registro: </td>
      <td align="center" valign="middle"><span class="nroregistro"><?php echo $row_DetailRS1['id']; ?></span>        </div></td>
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle">
        <input name="rut_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="15" maxlength="12">
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="center" valign="middle">
        <input name="fecha_ingreso" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_ingreso']; ?>" size="12" maxlength="10"> 
      <span class="rojopequeno">(dd-mm-aaaa)</span></div></td>
      <td align="right" valign="middle">Evento:</div></td>
      <td align="center" valign="middle">
        <input name="evento" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['evento']; ?>" size="20" maxlength="20">
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Fecha Curse:</td>
      <td align="center" valign="middle">
        <input name="fecha_curse" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_curse']; ?>" size="12" maxlength="10">
      <span class="rojopequeno">(dd-mm-aaaa)</span></div></td>
      <td align="right" valign="middle">Estado:</div></td>
      <td align="center" valign="middle">
        <input name="estado" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['estado']; ?>" size="20" maxlength="20">
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nro Operaci&oacute;n:</td>
      <td align="center" valign="middle"><input name="nro_operacion" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="15" maxlength="7">
      <span class="rojopequeno">K000000</span></td>
      <td align="right" valign="middle">Visador:</td>
      <td align="center" valign="middle"><input name="visador" type="text" disabled="disabled" class="etiqueta12" id="visador" value="<?php echo $row_DetailRS1['visador']; ?>" size="20" maxlength="20"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Observaci&oacute;n:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
      <span id="countsprytextarea1">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Especialista:</td>
      <td align="center" valign="middle"><input name="especialista" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista']; ?>" size="30" maxlength="50"></td>
      <td align="right" valign="middle">Especialista Curse: </div></td>
      <td align="center" valign="middle"><input name="especialista_curse" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista_curse']; ?>" size="20" maxlength="20"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Moneda / <br>
      Monto Operaci&oacute;n:</td>
      <td align="center" valign="middle"><input name="moneda_operacion" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['moneda_operacion']; ?>" size="5" maxlength="3"> 
      <span class="rojopequeno">/</span>        <input name="monto_operacion" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="17" maxlength="15"></td>
      <td align="right" valign="middle">Moneda / Monto Negociaci&oacute;n:</td>
      <td align="center" valign="middle"><input name="moneda_documentos" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['moneda_documentos']; ?>" size="5" maxlength="3"> 
      <span class="rojopequeno">/</span>        <input name="monto_documentos" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_documentos']; ?>" size="17" maxlength="15"></td>
    </tr>
    <tr valign="middle">
      <td rowspan="2" align="right" valign="middle">Excepci&oacute;n:</td>
      <td rowspan="2" align="center" valign="middle"><input name="excepcion" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['excepcion']; ?>" size="5" maxlength="3"></td>
      <td align="right" valign="middle">Auto. Operac.:</td>
      <td align="center" valign="middle"><input name="autorizacion_operaciones" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['autorizacion_operaciones']; ?>" size="30" maxlength="50"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Auto Espe.: </td>
      <td align="center" valign="middle"><input name="autorizacion_especialista" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['autorizacion_especialista']; ?>" size="30" maxlength="50"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Tipo Excepci&oacute;n:</td>
      <td colspan="3" align="left" valign="middle">
        <select name="tipo_excepcion" class="etiqueta12" id="tipo_excepcion">
          <option value=""  <?php if (!(strcmp("", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>N/A</option>
          <option value="Art 85 Vencido." <?php if (!(strcmp("Art 85 Vencido.", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>Art 85 Vencido</option>
          <option value="Linea de Credito sobregirada." <?php if (!(strcmp("Linea de Credito sobregirada.", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>Linea de Credito sobregirada</option>
          <option value="Falta Autorizacion de Riesgos." <?php if (!(strcmp("Falta Autorizacion de Riesgos.", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>Falta Autorizacion de Riesgos</option>
          <option value="Falta minuta de Credito." <?php if (!(strcmp("Falta minuta de Credito.", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>Falta minuta de Credito</option>
          <option value="Firma disconforme." <?php if (!(strcmp("Firma disconforme.", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>Firma disconforme</option>
          <option value="Falta mail Sucursal por pagare en custodia." <?php if (!(strcmp("Falta mail Sucursal por pagare en custodia.", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>Falta mail Sucursal por pagare en custodia</option>
          <option value="Pagare sin llenar." <?php if (!(strcmp("Pagare sin llenar.", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>Pagare sin llenar</option>
          <option value="Pagare no corresponde." <?php if (!(strcmp("Pagare no corresponde.", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>Pagare no corresponde</option>
          <option value="Pagare version antigua." <?php if (!(strcmp("Pagare version antigua.", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>Pagare version antigua</option>
          <option value="Falta pagare para aumento de valor de operacion." <?php if (!(strcmp("Falta pagare para aumento de valor de operacion.", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>Falta pagare para aumento de valor de operacion</option>
          <option value="Falta informe de fiscalia para avales sociedad anonima." <?php if (!(strcmp("Falta informe de fiscalia para avales sociedad anonima.", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>Falta informe de fiscalia para avales sociedad anonima</option>
          <option value="Certificado de matrimonio avales vencidos o no se encuentra en nuestros archivos." <?php if (!(strcmp("Certificado de matrimonio avales vencidos o no se encuentra en nuestros archivos.", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>Certificado de matrimonio avales vencidos o no se encuentra en nuestros archivos</option>
          <option value="Falta constitucion de garantias." <?php if (!(strcmp("Falta constitucion de garantias.", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>Falta constitucion de garantias</option>
          <option value="Otro." <?php if (!(strcmp("Otro.", $row_DetailRS1['tipo_excepcion']))) {echo "SELECTED";} ?>>Otro</option>
        </select>
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Fecha Soluci&oacute;n Excepci&oacute;n: </td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextfield2">
      <input name="solucion_excepcion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['solucion_excepcion']; ?>" size="12" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Estado Excepci&oacute;n:</td>
      <td align="center" valign="middle">        
        <label>
        <input name="estado_excepcion" type="radio" class="etiqueta12" value="Pendiente."  <?php if (!(strcmp($row_DetailRS1['estado_excepcion'],"Pendiente."))) {echo "CHECKED";} ?>>
  Pendiente</label>
        <label>
        <input name="estado_excepcion" type="radio" class="etiqueta12" value="Solucionado."  <?php if (!(strcmp($row_DetailRS1['estado_excepcion'],"Solucionado."))) {echo "CHECKED";} ?>>
  Solucionado</label>
        <br>
      </td>
      <td align="right" valign="middle">Solucionado el:</td>
      <td align="center" valign="middle"><span id="sprytextfield1">
      <input name="solucionado" type="text" class="etiqueta12" id="solucionado" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="center" valign="middle"><input type="submit" class="boton" value="Actualizar o Cerrar Excepci&oacute;n"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="mantenciomae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
//-->
</script>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>