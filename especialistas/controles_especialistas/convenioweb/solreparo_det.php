<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,ESP,BMG,TER";
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

$MM_restrictGoTo = "../../../erroracceso.php";
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
  $updateSQL = sprintf("UPDATE convenioweb SET especialista_curse=%s, date_ingreso=%s, rut_cliente=%s, nombre_cliente=%s, moneda_pagare=%s, monto_pagare=%s, moneda_convenio=%s, monto_convenio=%s, doc_1=%s, doc_2=%s, doc_3=%s, doc_6=%s, aval_rut_1=%s, aval_nom_1=%s, aval_rut_2=%s, aval_nom_2=%s, aval_rut_3=%s, aval_nom_3=%s, aval_rut_4=%s, aval_nom_4=%s, apo_rut1=%s, apo_nom1=%s, apo_rut2=%s, apo_nom2=%s, apo_rut3=%s, apo_nom3=%s, apo_rut4=%s, apo_nom4=%s, ope_rut1=%s, ope_nom1=%s, ope_rut2=%s, ope_nom2=%s, ope_rut3=%s, ope_nom3=%s, ope_rut4=%s, ope_nom4=%s, ope_rut5=%s, ope_nom5=%s, ope_rut6=%s, ope_nom6=%s, rol1=%s, rol2=%s, rol3=%s, rol4=%s, rol5=%s, rol6=%s, producto_cci=%s, producto_cce=%s, producto_pre=%s, producto_mec=%s, producto_cbi=%s, producto_cbe=%s, producto_ste=%s, producto_str=%s, producto_bga=%s, producto_tbc=%s, producto_cex=%s, observacion=%s, obs_reparo=%s, estado=%s, fecha_ingreso=%s, registro_ingreso=%s WHERE id=%s",
                       GetSQLValueString($_POST['especialista_curse'], "text"),
                       GetSQLValueString($_POST['date_ingreso'], "date"),
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['moneda_pagare'], "text"),
                       GetSQLValueString($_POST['monto_pagare'], "double"),
                       GetSQLValueString($_POST['moneda_convenio'], "text"),
                       GetSQLValueString($_POST['monto_convenio'], "double"),
                       GetSQLValueString($_POST['doc_1'], "text"),
                       GetSQLValueString($_POST['doc_2'], "text"),
                       GetSQLValueString($_POST['doc_3'], "text"),
                       GetSQLValueString($_POST['doc_6'], "text"),
                       GetSQLValueString($_POST['aval_rut_1'], "text"),
                       GetSQLValueString($_POST['aval_nom_1'], "text"),
                       GetSQLValueString($_POST['aval_rut_2'], "text"),
                       GetSQLValueString($_POST['aval_nom_2'], "text"),
                       GetSQLValueString($_POST['aval_rut_3'], "text"),
                       GetSQLValueString($_POST['aval_nom_3'], "text"),
                       GetSQLValueString($_POST['aval_rut_4'], "text"),
                       GetSQLValueString($_POST['aval_nom_4'], "text"),
                       GetSQLValueString($_POST['apo_rut1'], "text"),
                       GetSQLValueString($_POST['apo_nom1'], "text"),
                       GetSQLValueString($_POST['apo_rut2'], "text"),
                       GetSQLValueString($_POST['apo_nom2'], "text"),
                       GetSQLValueString($_POST['apo_rut3'], "text"),
                       GetSQLValueString($_POST['apo_nom3'], "text"),
                       GetSQLValueString($_POST['apo_rut4'], "text"),
                       GetSQLValueString($_POST['apo_nom4'], "text"),
                       GetSQLValueString($_POST['ope_rut1'], "text"),
                       GetSQLValueString($_POST['ope_nom1'], "text"),
                       GetSQLValueString($_POST['ope_rut2'], "text"),
                       GetSQLValueString($_POST['ope_nom2'], "text"),
                       GetSQLValueString($_POST['ope_rut3'], "text"),
                       GetSQLValueString($_POST['ope_nom3'], "text"),
                       GetSQLValueString($_POST['ope_rut4'], "text"),
                       GetSQLValueString($_POST['ope_nom4'], "text"),
                       GetSQLValueString($_POST['ope_rut5'], "text"),
                       GetSQLValueString($_POST['ope_nom5'], "text"),
                       GetSQLValueString($_POST['ope_rut6'], "text"),
                       GetSQLValueString($_POST['ope_nom6'], "text"),
                       GetSQLValueString($_POST['rol1'], "text"),
                       GetSQLValueString($_POST['rol2'], "text"),
                       GetSQLValueString($_POST['rol3'], "text"),
                       GetSQLValueString($_POST['rol4'], "text"),
                       GetSQLValueString($_POST['rol5'], "text"),
                       GetSQLValueString($_POST['rol6'], "text"),
                       GetSQLValueString($_POST['producto_cci'], "text"),
                       GetSQLValueString($_POST['producto_cce'], "text"),
                       GetSQLValueString($_POST['producto_pre'], "text"),
                       GetSQLValueString($_POST['producto_mec'], "text"),
                       GetSQLValueString($_POST['producto_cbi'], "text"),
                       GetSQLValueString($_POST['producto_cbe'], "text"),
                       GetSQLValueString($_POST['producto_ste'], "text"),
                       GetSQLValueString($_POST['producto_str'], "text"),
                       GetSQLValueString($_POST['producto_bga'], "text"),
                       GetSQLValueString($_POST['producto_tbc'], "text"),
                       GetSQLValueString($_POST['producto_cex'], "text"),
                       GetSQLValueString($_POST['observacion'], "text"),
                       GetSQLValueString($_POST['obs_reparo'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "date"),
                       GetSQLValueString($_POST['registro_ingreso'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));

  $updateGoTo = "impsol_conweb.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_DetailRS1 = 50;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM convenioweb  WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Solución Reparo Convenio WEB - Detalle</title>
<style type="text/css">
<!--
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #F00;
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
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo5 {	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script type="text/javascript">

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
</head>

<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="95%" align="left" valign="middle" class="Estilo3">SOLUCION REPARO  CONVENIO WEB - DETALLE</td>
    <td width="5%" rowspan="2" align="right" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">COMERCIO EXTERIOR</td>
  </tr>
</table>
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><span class="Estilo5">Ingreso Pagar&eacute;</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Nro Registro</td>
      <td class="nroregistro"><?php echo $row_DetailRS1['id']; ?></td>
      <td align="right">Especialista Curse:</td>
      <td><input name="especialista_curse" type="text" class="etiqueta12" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Fecha Ingreso:</td>
      <td><input name="date_ingreso" type="text" class="etiqueta12" value="<?php echo date("Y-m-d H:i:s"); ?>" size="18" maxlength="18" />
      <span class="rojopequeno">(aaaa-mm-dd hh:mm:ss)</span></td>
      <td align="right">Rut Cliente:</td>
      <td><input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['rut_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="17" maxlength="15" />
      <span id="sprytextfield3"><span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Nombre_cliente:</td>
      <td colspan="3" align="left"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['nombre_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="120" maxlength="122" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Moneda / Monto Pagare:</td>
      <td><select name="moneda_pagare" class="etiqueta12" id="moneda_pagare">
        <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>CLP</option>
        <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>DKK</option>
        <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>NOK</option>
        <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>SEK</option>
        <option value="USD" selected="selected" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>USD</option>
        <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>CAD</option>
        <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>AUD</option>
        <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>HKD</option>
        <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>EUR</option>
        <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>CHF</option>
        <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>GBP</option>
        <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
<option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>JPY</option>
      </select> 
        / 
      <input name="monto_pagare" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['monto_pagare'], ENT_COMPAT, 'utf-8'); ?>" size="20" maxlength="20" /></td>
      <td align="right">Moneda / Monto Convenio:</td>
      <td><select name="moneda_convenio" class="etiqueta12" id="moneda_convenio">
        <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>CLP</option>
        <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>DKK</option>
        <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>NOK</option>
        <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>SEK</option>
        <option value="USD" selected="selected" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>USD</option>
        <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>CAD</option>
        <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>AUD</option>
        <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>HKD</option>
        <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>EUR</option>
        <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>CHF</option>
        <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>GBP</option>
        <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
<option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>JPY</option>
      </select> 
        / 
      <input name="monto_convenio" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['monto_convenio'], ENT_COMPAT, 'utf-8'); ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Parag&eacute; / Convenio:</td>
      <td colspan="3" align="left"><input <?php if (!(strcmp($row_DetailRS1['doc_1'],"Pagare."))) {echo "checked=\"checked\"";} ?> type="checkbox" name="doc_1" value="Pagare." size="32" />
        Pagare
        <input <?php if (!(strcmp($row_DetailRS1['doc_2'],"Convenio."))) {echo "checked=\"checked\"";} ?> type="checkbox" name="doc_2" value="Convenio." size="32" />
        Convenio 
        <input <?php if (!(strcmp($row_DetailRS1['doc_3'],"Anexo."))) {echo "checked=\"checked\"";} ?> type="checkbox" name="doc_3" value="Anexo." size="32" />
        Anexo Convenio Portal Comex
        <input <?php if (!(strcmp($row_DetailRS1['doc_6'],"Solicitud Portal Comex."))) {echo "checked=\"checked\"";} ?> type="checkbox" name="doc_6" value="Solicitud Portal Comex." size="32" />
Solicitud Portal Comex</td>
    </tr>
    <tr valign="baseline">
      <td align="right">Producto:</td>
      <td colspan="3" align="left"><input <?php if (!(strcmp($row_DetailRS1['producto_cci'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_cci" id="producto_cci" value="Si" />
Carta de Credito Import
  <input <?php if (!(strcmp($row_DetailRS1['producto_cce'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_cce" id="producto_cce" value="Si" />
Carta de Credito Export
<input <?php if (!(strcmp($row_DetailRS1['producto_pre'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_pre" id="producto_pre" value="Si" />
Prestamos Stand Alone
<input <?php if (!(strcmp($row_DetailRS1['producto_mec'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_mec" id="producto_mec" value="Si" />
Meco
<input <?php if (!(strcmp($row_DetailRS1['producto_cbi'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_cbi" id="producto_cbi" value="Si" />
Cobranza Import
<input <?php if (!(strcmp($row_DetailRS1['producto_cbe'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_cbe" id="producto_cbe" value="Si" />
Cobranza Export <br />
<input <?php if (!(strcmp($row_DetailRS1['producto_ste'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_ste" id="radio" value="Si" />
Stand By Emitida
<input <?php if (!(strcmp($row_DetailRS1['producto_str'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_str" id="producto_str" value="Si" />
Stand By Recibida
<input <?php if (!(strcmp($row_DetailRS1['producto_bga'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_bga" id="producto_bga" value="Si" />
Boleta Garant&iacute;a
<input <?php if (!(strcmp($row_DetailRS1['producto_tbc'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_tbc" id="producto_tbc" value="Si" />
IIIB5
<input <?php if (!(strcmp($row_DetailRS1['producto_cex'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_cex" id="producto_cex" value="Si" />
Creditos Externos</td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" bordercolor="#666666" bgcolor="#CCCCCC">Observaciones:</td>
      <td colspan="3" align="left"><textarea name="observacion" cols="80" rows="4" class="etiqueta12" id="observacion"><?php echo $row_DetailRS1['observacion']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" bordercolor="#666666" bgcolor="#CCCCCC">Estado:</td>
      <td colspan="3" align="left"><select name="estado" class="NegrillaCartaReparo" id="estado">
        <option value="Pendiente." selected="selected">Ingresada</option>
</select></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="left" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><span class="Estilo5">Ingreso Avales</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Aval 1:</td>
      <td colspan="3" align="left"><input name="aval_rut_1" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['aval_rut_1'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="18" /> 
        / 
      <input name="aval_nom_1" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['aval_nom_1'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Aval 2:</td>
      <td colspan="3" align="left"><input name="aval_rut_2" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['aval_rut_2'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="18" /> 
        / 
      <input name="aval_nom_2" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['aval_nom_2'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Aval 3:</td>
      <td colspan="3" align="left"><input name="aval_rut_3" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['aval_rut_3'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="18" /> 
        / 
      <input name="aval_nom_3" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['aval_nom_3'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Aval 4:</td>
      <td colspan="3" align="left"><input name="aval_rut_4" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['aval_rut_4'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="18" /> 
        / 
      <input name="aval_nom_4" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['aval_nom_4'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="left" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><span class="Estilo5">Ingreso Apoderados</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Apoderado 1:</td>
      <td colspan="3" align="left"><input name="apo_rut1" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['apo_rut1'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="18" /> 
        / 
      <input name="apo_nom1" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['apo_nom1'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Apoderado 2:</td>
      <td colspan="3" align="left"><input name="apo_rut2" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['apo_rut2'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="18" /> 
        / 
      <input name="apo_nom2" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['apo_nom2'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Apoderado 3:</td>
      <td colspan="3" align="left"><input name="apo_rut3" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['apo_rut3'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="18" /> 
        / 
      <input name="apo_nom3" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['apo_nom3'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Apoderado 4:</td>
      <td colspan="3" align="left"><input name="apo_rut4" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['apo_rut4'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="18" /> 
        / 
      <input name="apo_nom4" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['apo_nom4'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="left" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><span class="Estilo5">Ingreso Operadores y Roles</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Operador 1:</td>
      <td colspan="3" align="left"><input name="ope_rut1" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['ope_rut1'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="18" /> 
        /
        <input name="ope_nom1" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['ope_nom1'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /> 
        / 
        <select name="rol1" class="etiqueta12" id="rol1">
          <option value="Sin Dato." selected="selected" <?php if (!(strcmp("Sin Dato.", $row_DetailRS1['rol1']))) {echo "selected=\"selected\"";} ?>>N/A</option>
          <option value="Apoderado." <?php if (!(strcmp("Apoderado.", $row_DetailRS1['rol1']))) {echo "selected=\"selected\"";} ?>>Apoderado</option>
<option value="Usuario." <?php if (!(strcmp("Usuario.", $row_DetailRS1['rol1']))) {echo "selected=\"selected\"";} ?>>Usuario</option>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Operador 2:</td>
      <td colspan="3" align="left"><input name="ope_rut2" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['ope_rut2'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="18" /> 
        / 
      <input name="ope_nom2" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['ope_nom2'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /> 
          /
          <select name="rol2" class="etiqueta12" id="rol2">
            <option value="Sin Dato." selected="selected" <?php if (!(strcmp("Sin Dato.", $row_DetailRS1['rol2']))) {echo "selected=\"selected\"";} ?>>N/A</option>
            <option value="Apoderado." <?php if (!(strcmp("Apoderado.", $row_DetailRS1['rol2']))) {echo "selected=\"selected\"";} ?>>Apoderado</option>
<option value="Usuario." <?php if (!(strcmp("Usuario.", $row_DetailRS1['rol2']))) {echo "selected=\"selected\"";} ?>>Usuario</option>
          </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Operador 3:</td>
      <td colspan="3" align="left"><input name="ope_rut3" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['ope_rut3'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="18" /> 
        / 
      <input name="ope_nom3" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['ope_nom3'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /> 
          /
          <select name="rol3" class="etiqueta12" id="rol3">
            <option value="Sin Dato." selected="selected" <?php if (!(strcmp("Sin Dato.", $row_DetailRS1['rol3']))) {echo "selected=\"selected\"";} ?>>N/A</option>
            <option value="Apoderado." <?php if (!(strcmp("Apoderado.", $row_DetailRS1['rol3']))) {echo "selected=\"selected\"";} ?>>Apoderado</option>
<option value="Usuario." <?php if (!(strcmp("Usuario.", $row_DetailRS1['rol3']))) {echo "selected=\"selected\"";} ?>>Usuario</option>
          </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Operador 4:</td>
      <td colspan="3" align="left"><input name="ope_rut4" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['ope_rut4'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="18" /> 
        / 
        <input name="ope_nom4" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['ope_nom4'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /> 
        /
        <select name="rol4" class="etiqueta12" id="rol4">
          <option value="Sin Dato." selected="selected" <?php if (!(strcmp("Sin Dato.", $row_DetailRS1['rol4']))) {echo "selected=\"selected\"";} ?>>N/A</option>
          <option value="Apoderado." <?php if (!(strcmp("Apoderado.", $row_DetailRS1['rol4']))) {echo "selected=\"selected\"";} ?>>Apoderado</option>
<option value="Usuario." <?php if (!(strcmp("Usuario.", $row_DetailRS1['rol4']))) {echo "selected=\"selected\"";} ?>>Usuario</option>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Operador 5:</td>
      <td colspan="3" align="left"><input name="ope_rut5" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['ope_rut5'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="18" /> 
        / 
        <input name="ope_nom5" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['ope_nom5'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /> 
        /
        <select name="rol5" class="etiqueta12" id="rol5">
          <option value="Sin Dato." selected="selected" <?php if (!(strcmp("Sin Dato.", $row_DetailRS1['rol5']))) {echo "selected=\"selected\"";} ?>>N/A</option>
          <option value="Apoderado." <?php if (!(strcmp("Apoderado.", $row_DetailRS1['rol6']))) {echo "selected=\"selected\"";} ?>>Apoderado</option>
<option value="Usuario." <?php if (!(strcmp("Usuario.", $row_DetailRS1['rol5']))) {echo "selected=\"selected\"";} ?>>Usuario</option>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right">Operador 6:</td>
      <td colspan="3" align="left"><input name="ope_rut6" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['ope_rut6'], ENT_COMPAT, 'utf-8'); ?>" size="15" maxlength="18" /> 
        / 
        <input name="ope_nom6" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['ope_nom6'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /> 
        / 
        <select name="rol6" class="etiqueta12" id="rol6">
          <option value="Sin Dato." selected="selected" <?php if (!(strcmp("Sin Dato.", $row_DetailRS1['rol6']))) {echo "selected=\"selected\"";} ?>>N/A</option>
          <option value="Apoderado." <?php if (!(strcmp("Apoderado.", $row_DetailRS1['rol6']))) {echo "selected=\"selected\"";} ?>>Apoderado</option>
<option value="Usuario." <?php if (!(strcmp("Usuario.", $row_DetailRS1['rol6']))) {echo "selected=\"selected\"";} ?>>Usuario</option>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center"><input type="submit" class="boton" value="Ingresar Convenio" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>" />
  <input type="hidden" name="obs_reparo" size="32" />
  <input type="hidden" name="fecha_ingreso" value="<?php echo date("Y-m-d"); ?>" size="32" />
  <input type="hidden" name="registro_ingreso" value="<?php echo $_SESSION['login'];?>" size="32" />
  <input type="hidden" name="fecha_actualizacion" value="<?php echo htmlentities($row_DetailRS1['fecha_actualizacion'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
  <input type="hidden" name="fecha_vcto" value="<?php echo htmlentities($row_DetailRS1['fecha_vcto'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
  <input type="hidden" name="sucursal" value="<?php echo htmlentities($row_DetailRS1['sucursal'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
  <input type="hidden" name="ultimafecha" value="<?php echo htmlentities($row_DetailRS1['ultimafecha'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="solreparo_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen6','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen6" width="80" height="25" border="0" id="Imagen6" /></a></td>
  </tr>
</table>
<br />
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>