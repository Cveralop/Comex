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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO opcci (rut_cliente, nombre_cliente, fecha_ingreso, date_ingreso, evento, estado, asignador, operador, nro_operacion, obs, especialista, moneda_documentos, monto_documentos, despacho_doctos, sucursal, sub_estado, date_asig, forward) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['date_ingreso'], "date"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['asignador'], "text"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['especialista'], "text"),
                       GetSQLValueString($_POST['moneda_documentos'], "text"),
                       GetSQLValueString($_POST['monto_documentos'], "double"),
                       GetSQLValueString($_POST['despacho_doctos'], "text"),
                       GetSQLValueString($_POST['sucursal'], "int"),
                       GetSQLValueString($_POST['sub_estado'], "text"),
                       GetSQLValueString($_POST['date_asig'], "date"),
                       GetSQLValueString($_POST['forward'], "text"));
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
$colname_DetailRS1 = "1";
if (isset($_GET['nro_operacion'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['nro_operacion'] : addslashes($_GET['nro_operacion']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = sprintf("SELECT * FROM opcci  WHERE id = $recordID"); //, $colname_vctoplapro (dentro del parentesis arroja Error)
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
<title>Registro Vcto Plazo Proveedor - Detalle</title>
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
.Estilo5 {	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo6 {	font-size: 14px;
	color: #FF0000;
	font-weight: bold;
}
-->
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
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
<link href="../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">REGISTRO VCTO PLAZO PROVEEDOR - DETALLE </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTAS DE CR&Eacute;DITO IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" onSubmit="MM_validateForm('fecha_ingreso','','R','rut_cliente','','R','nombre_cliente','','R','asignador','','R','especialista','','R','nro_operacion','','R','moneda_documentos','','R','monto_documentos','','RisNum');return document.MM_returnValue">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="4" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Asignar Vcto Plazo Proveedor </span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="center" valign="middle">
        <input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10">
      <span class="rojopequeno">(dd-mm-aaaa)</span></div></td>
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle">
          <input name="rut_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15">
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Evento:</td>
      <td align="center" valign="middle">
        <select name="evento" class="etiqueta12" id="evento">
          <option value="Vcto Pzo Proveedor." selected>Vcto Pzo Proveedor</option>
        </select>
      </div></td>
      <td align="right" valign="middle">Operador:</div></td>
      <td align="center" valign="middle"><select name="operador" class="etiqueta12" id="operador">
        <option value="AVENEGC" <?php if (!(strcmp("AVENEGC", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Ana M. Venegas Casta&ntilde;eda</option>
        <option value="HRAMIRZ" <?php if (!(strcmp("HRAMIRZ", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Hernan Ramirez Ramirez</option>
        <option value="JAVELLO" <?php if (!(strcmp("JAVELLO", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Juan Avello Poblete</option>
        <option value="EVALENZU" <?php if (!(strcmp("EVALENZU", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Eliza Valenzuela</option>
        <option value="CURRUTP" <?php if (!(strcmp("CURRUTP", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Claudia Urrutia</option>
        <option value="EROBLES" <?php if (!(strcmp("EROBLES", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Elizabeth Robles</option>
        <option value="HURIBEC" <?php if (!(strcmp("HURIBEC", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Hernan Uribe</option>
        <option value="JMALDON" <?php if (!(strcmp("JMALDON", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Jaime Maldonado</option>
        <option value="LCELISD" <?php if (!(strcmp("LCELISD", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Luis Celis</option>
        <option value="PGODOY" <?php if (!(strcmp("PGODOY", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Patricia Godoy</option>
        <option value="PMOSCOA" <?php if (!(strcmp("PMOSCOA", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Pamela Moscoso</option>
        <option value="BSALGADO" <?php if (!(strcmp("BSALGADO", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Bastian Salgado Menares</option>
        <option value="MTOROB" <?php if (!(strcmp("MTOROB", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Veronica Toro</option>
	<option value="RTOBARC" <?php if (!(strcmp("RTOBARC", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Romuald Tobar Caro</option>
        <option value="FESPINOZ" <?php if (!(strcmp("FESPINOZ", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Franco Espinoza</option>
        <option value="MPALACIO" <?php if (!(strcmp("MPALACIO", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Manuel Palacios Gutierrez</option>
        <option value="JSANTIBA" <?php if (!(strcmp("JSANTIBA", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Jose Santiba�ez Pe�a</option>
        <option value="FMABELP" <?php if (!(strcmp("FMABELP", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Francisca Mabel Perez</option>
        <option value="XMAGANA" <?php if (!(strcmp("XMAGANA", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Ximena Maga�a Gonzalez</option>
        <option value="YPARRA" <?php if (!(strcmp("YPARRA", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Yanadet Parra Trincado</option>
        <option value="JROMAN" <?php if (!(strcmp("JROMAN", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Juan Roman Diaz</option>
        <option value="PCCI1" <?php if (!(strcmp("PCCI1", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Practica CCI 1</option>
        <option value="PCCI2" <?php if (!(strcmp("PCCI2", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Practica CCI 2</option>
        <option value="PCCI3" <?php if (!(strcmp("PCCI3", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Practica CCI 3</option>
      </select>        </div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Asignado:</td>
      <td align="center" valign="middle">
          <input name="asignador" type="text" class="etiqueta12" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20">
      </div></td>
      <td align="right" valign="middle">Especialista:</div></td>
      <td align="center" valign="middle">
        <input name="especialista" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista']; ?>" size="20" maxlength="20">
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nro Operaci&oacute;n:</td>
      <td colspan="3" align="left" valign="middle">
        <input name="nro_operacion" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="15" maxlength="7">
          <span class="rojopequeno">K000000</span>
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Observaci&oacute;n:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
      <span class="rojopequeno" id="countsprytextarea1">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Forward:</td>
      <td align="center" valign="middle">
        <input name="forward" type="text" class="destadado" id="forward" value="<?php echo $row_DetailRS1['forward']; ?>" size="20" maxlength="20">
      </div></td>
      <td align="right" valign="middle">Moneda / Monto Documentos:</div></td>
      <td align="center" valign="middle">
          <select name="moneda_documentos" class="etiqueta12" id="moneda_documentos">
            <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_documentos']))) {echo "SELECTED";} ?>>CLP</option>
            <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_documentos']))) {echo "SELECTED";} ?>>DKK</option>
            <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_documentos']))) {echo "SELECTED";} ?>>NOK</option>
            <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_documentos']))) {echo "SELECTED";} ?>>SEK</option>
            <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_documentos']))) {echo "SELECTED";} ?>>USD</option>
            <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_documentos']))) {echo "SELECTED";} ?>>CAD</option>
            <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_documentos']))) {echo "SELECTED";} ?>>AUD</option>
            <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_documentos']))) {echo "SELECTED";} ?>>HKD</option>
            <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_documentos']))) {echo "SELECTED";} ?>>EUR</option>
            <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_documentos']))) {echo "SELECTED";} ?>>CHF</option>
            <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_documentos']))) {echo "SELECTED";} ?>>GBP</option>
            <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_documentos']))) {echo "SELECTED";} ?>>ZAR</option>
            <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_documentos']))) {echo "SELECTED";} ?>>JPY</option>
            <?php
do {  
?>
            <option value="<?php echo $row_DetailRS1['moneda_documentos']?>"<?php if (!(strcmp($row_DetailRS1['moneda_documentos'], $row_DetailRS1['moneda_documentos']))) {echo "SELECTED";} ?>><?php echo $row_DetailRS1['moneda_documentos']?></option>
            <?php
} while ($row_DetailRS1 = mysqli_fetch_assoc($DetailRS1));
  $rows = mysqli_num_rows($DetailRS1);
  if($rows > 0) {
      mysqli_data_seek($DetailRS1, 0);
	  $row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
  }
?>
          </select>
          <span class="rojopequeno">/</span>        
          <input name="monto_documentos" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_documentos']; ?>" size="20" maxlength="20">
      </div></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle">
          <input type="submit" class="boton" value="Ingresar Operaci&oacute;n">
      </div></td>
    </tr>
  </table>
  <input name="estado" type="hidden" id="estado" value="Pendiente.">
  <input name="sub_estado" type="hidden" id="sub_estado" value="Pendiente.">
  <input name="rut_cliente" type="hidden" id="rut_cliente" value="<?php echo $row_DetailRS1['rut_cliente']; ?>">
  <input name="nombre_cliente" type="hidden" id="nombre_cliente" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>">
  <input name="nro_operacion" type="hidden" id="nro_operacion" value="<?php echo $row_DetailRS1['nro_operacion']; ?>">
  <input name="date_asig" type="hidden" id="date_asig" value="<?php echo date("Y-m-d H:i:s"); ?>">
  <input type="hidden" name="MM_insert" value="form1">
  <input name="date_ingreso" type="hidden" id="date_ingreso" value="<?php echo date("Y-m-d"); ?>">
  <input name="despacho_doctos" type="hidden" class="etiqueta12" id="despacho_doctos" value="<?php echo $row_DetailRS1['despacho_doctos']; ?>" size="25" maxlength="120">
  <input name="sucursal" type="hidden" id="sucursal" value="<?php echo $row_DetailRS1['sucursal']; ?>">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="ingmae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
//-->
</script>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>