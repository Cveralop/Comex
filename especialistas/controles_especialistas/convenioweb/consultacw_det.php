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

$colname_DetailRS1 = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_DetailRS1 = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = sprintf("SELECT convenioweb.* FROM convenioweb WHERE id = $recordID", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);$colname_DetailRS1 = "-1";
if (isset($_GET['id'])) {
  $colname_DetailRS1 = $_GET['id'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Modificar Pagar&eacute; Paragua - Detalle</title>
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
	font-size: 16px;
	color: #FF0000;
	font-weight: bold;
}
.Estilo6 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}

</style>
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo51 {font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}

</style>
</head>

<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CONSULTA PAGARE PARAGUA - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">COMERCIO EXTERIOR</td>
  </tr>
</table>
<br>
<form method="post" name="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr align="left" valign="baseline" bgcolor="#999999">
      <td colspan="4" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo6">Detalle Convenio WEB- Pagare Paragua</span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nro Registro: </td>
      <td align="center" valign="middle"><span class="nroregistro"><?php echo $row_DetailRS1['id']; ?></span>        </div></td>
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle"><input name="rut_cliente" type="text" disabled class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15">
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" disabled class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Sucursal Custodia:</td>
      <td align="center" valign="middle"><select name="sucursal2" class="etiqueta12" id="sucursal2">
        <option value="Casa Matriz." selected <?php if (!(strcmp("Casa Matriz.", $row_DetailRS1['sucursal']))) {echo "selected=\"selected\"";} ?>>Casa Matriz</option>
        <option value="Oficina." <?php if (!(strcmp("Oficina.", $row_DetailRS1['sucursal']))) {echo "selected=\"selected\"";} ?>>Oficina</option>
      </select></td>
      <td align="right" valign="middle">Estado:</td>
      <td align="center" valign="middle"><select name="estado2" class="etiqueta12" id="estado2">
        <option value="Vigente." <?php if (!(strcmp("Vigente.", $row_DetailRS1['estado']))) {echo "selected=\"selected\"";} ?>>Vigente</option>
        <option value="Cerrado." <?php if (!(strcmp("Cerrado.", $row_DetailRS1['estado']))) {echo "selected=\"selected\"";} ?>>Cerrado</option>
        <option value="Sin Cupo." <?php if (!(strcmp("Sin Cupo.", $row_DetailRS1['estado']))) {echo "selected=\"selected\"";} ?>>Sin Cupo</option>
        <option value="Eliminado." <?php if (!(strcmp("Eliminado.", $row_DetailRS1['estado']))) {echo "selected=\"selected\"";} ?>>Eliminado</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="center" valign="middle"><span id="sprytextfield2">
      <input name="fecha_suscripcion_pagare2" type="text" class="etiqueta12" id="fecha_suscripcion_pagare2" value="<?php echo $row_DetailRS1['fecha_suscripcion_pagare']; ?>" size="12" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span></span></td>
      <td align="right" valign="middle">Fecha Vcto.:</td>
      <td align="center" valign="middle"><input name="fecha_vcto" type="text" disabled class="etiqueta12" id="fecha_vcto" value="<?php echo $row_DetailRS1['fecha_vcto']; ?>" size="12" maxlength="10"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Fecha Suscripci&oacute;n Pagar&eacute;:</td>
      <td align="center" valign="middle"><span id="sprytextfield3">
      <input name="fecha_suscripcion_pagare" type="text" disabled class="etiqueta12" id="fecha_suscripcion_pagare" value="<?php echo $row_DetailRS1['fecha_suscripcion_pagare']; ?>" size="12" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span><span class="rojopequeno">(aaaa-mm-dd)</span></td>
      <td align="right" valign="middle">Fecha Suscripci&oacute;n Convenio:</td>
      <td align="center" valign="middle"><span id="sprytextfield1">
      <input name="fecha_suscripcion_convenio" type="text" disabled class="etiqueta12" id="fecha_suscripcion_convenio" value="<?php echo $row_DetailRS1['fecha_suscripcion_convenio']; ?>" size="12" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span><span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr align="left" valign="middle" bgcolor="#999999">
      <td align="right" valign="middle" bgcolor="#CCCCCC">Moneda / Monto Pagar&eacute;:</td>
      <td align="center" valign="middle" bgcolor="#CCCCCC"><select name="moneda_pagare" class="etiqueta12" id="moneda_pagare">
        <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>CLP</option>
        <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>DKK</option>
        <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>NOK</option>
        <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>SEK</option>
        <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>USD</option>
        <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>CAD</option>
        <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>AUD</option>
        <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>HKD</option>
        <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>EUR</option>
        <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>CHF</option>
        <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>GBP</option>
        <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
        <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_pagare']))) {echo "selected=\"selected\"";} ?>>JPY</option>
      </select>
        <span class="rojopequeno">/</span>
      <input name="monto_pagare" type="text" disabled class="etiqueta12" id="monto_pagare" value="<?php echo $row_DetailRS1['monto_pagare']; ?>" size="20" maxlength="20"></td>
      <td align="right" valign="middle" bgcolor="#CCCCCC">Moneda / Monto Convenio:</td>
      <td align="center" valign="middle" bgcolor="#CCCCCC"><select name="moneda_convenio" class="etiqueta12" id="moneda_convenio">
        <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>CLP</option>
        <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>DKK</option>
        <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>NOK</option>
        <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>SEK</option>
        <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>USD</option>
        <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>CAD</option>
        <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>AUD</option>
        <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>HKD</option>
        <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>EUR</option>
        <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>CHF</option>
        <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>GBP</option>
        <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
        <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_convenio']))) {echo "selected=\"selected\"";} ?>>JPY</option>
      </select>
        <span class="respuestacolumna_rojo">/</span>
      <input name="monto_convenio" type="text" disabled class="etiqueta12" id="monto_convenio" value="<?php echo $row_DetailRS1['monto_convenio']; ?>" size="20" maxlength="20"></td>
    </tr>
    <tr align="left" valign="middle" bgcolor="#999999">
      <td align="right" valign="middle" bgcolor="#CCCCCC">Parag&eacute; / Convenio:</td>
      <td colspan="3" align="left" valign="middle" bgcolor="#CCCCCC">

      <input name="doc_1" type="checkbox" id="doc_1" value="Pagare." <?php if (!(strcmp($row_DetailRS1['doc_1'],"Pagare."))) {echo "checked=\"checked\"";} ?> <?php //if (!(strcmp($row_DetailRS1['pagare'],"Pagare."))) {echo "checked=\"checked\"";} ?>  
      <label>Pagare</label>

        <input name="doc_2" type="checkbox" id="doc_2" value="Convenio." <?php if (!(strcmp($row_DetailRS1['doc_2'],"Convenio."))) {echo "checked=\"checked\"";} ?>>
        <label>Convenio</label>
        
      <input name="doc_3" type="checkbox" id="doc_3" value="Anexo." <?php if (!(strcmp($row_DetailRS1['doc_3'],"Anexo."))) {echo "checked=\"checked\"";} ?>>
      <label>Anexo Convenio Portal Comex</label>
      
     <input name="doc_6" type="checkbox" id="doc_6" value="Solicitud Portal Comex." <?php if (!(strcmp($row_DetailRS1['doc_5'],"Reconocimiento Deuda."))) {echo "checked=\"checked\"";} ?>>
     <label>Solicitud Portal Comex</label></td>
    </tr>
    <tr align="left" valign="middle" bgcolor="#999999">
      <td align="right" valign="middle" bgcolor="#CCCCCC">Producto:</td>
      <td colspan="3" align="left" valign="middle" bgcolor="#CCCCCC"><input <?php if (!(strcmp($row_DetailRS1['producto_cci'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_cci" id="producto_cci" value="Si">
Carta de Credito Import
  <input <?php if (!(strcmp($row_DetailRS1['producto_cce'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_cce" id="producto_cce" value="Si">
Carta de Credito Export
<input <?php if (!(strcmp($row_DetailRS1['producto_pre'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_pre" id="producto_pre" value="Si">
Prestamos Stand Alone
<input <?php if (!(strcmp($row_DetailRS1['producto_mec'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_mec" id="producto_mec" value="Si">
Meco
<input <?php if (!(strcmp($row_DetailRS1['producto_cbi'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_cbi" id="producto_cbi" value="Si">
Cobranza Import
<input <?php if (!(strcmp($row_DetailRS1['producto_cbe'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_cbe" id="producto_cbe" value="Si">
Cobranza Export <br>
<input <?php if (!(strcmp($row_DetailRS1['producto_ste'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_ste" id="radio" value="Si">
Stand By Emitida
<input <?php if (!(strcmp($row_DetailRS1['producto_str'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_str" id="producto_str" value="Si">
Stand By Recibida
<input <?php if (!(strcmp($row_DetailRS1['producto_bga'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_bga" id="producto_bga" value="Si">
Boleta Garant&iacute;a
<input <?php if (!(strcmp($row_DetailRS1['producto_tbc'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_tbc" id="producto_tbc" value="Si">
IIIB5
<input <?php if (!(strcmp($row_DetailRS1['producto_cex'],"Si"))) {echo "checked=\"checked\"";} ?> type="checkbox" name="producto_cex" id="producto_cex" value="Si">
Creditos Externos</td>
    </tr>
    <tr align="left" valign="middle" bgcolor="#999999">
      <td align="right" valign="middle" bgcolor="#CCCCCC">Observaciones:</td>
      <td colspan="3" align="left" valign="middle" bgcolor="#CCCCCC"><textarea name="observacion" cols="80" rows="4" disabled class="etiqueta12" id="observacion"><?php echo $row_DetailRS1['observacion']; ?></textarea></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21">Avales</td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Aval 1:</td>
      <td colspan="3" align="left" valign="middle"><input name="aval_rut_1" type="text" disabled class="etiqueta12" id="aval_rut_1" value="<?php echo $row_DetailRS1['aval_rut_1']; ?>" size="15" maxlength="18"> 
        / 
          <label>
            <input name="aval_nom_1" type="text" disabled class="etiqueta12" id="aval_nom_1" value="<?php echo $row_DetailRS1['aval_nom_1']; ?>" size="80" maxlength="80">
      </label></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Aval 2:</td>
      <td colspan="3" align="left" valign="middle"><input name="aval_rut_2" type="text" disabled class="etiqueta12" id="aval_rut_2" value="<?php echo $row_DetailRS1['aval_rut_2']; ?>" size="15" maxlength="18"> 
        / 
      <input name="aval_nom_2" type="text" disabled class="etiqueta12" id="aval_nom_2" value="<?php echo $row_DetailRS1['aval_nom_2']; ?>" size="80" maxlength="80"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Aval 3:</td>
      <td colspan="3" align="left" valign="middle"><input name="aval_rut_3" type="text" disabled class="etiqueta12" id="aval_rut_3" value="<?php echo $row_DetailRS1['aval_rut_3']; ?>" size="15" maxlength="18"> 
        / 
      <input name="aval_nom_3" type="text" disabled class="etiqueta12" id="aval_nom_3" value="<?php echo $row_DetailRS1['aval_nom_3']; ?>" size="80" maxlength="80"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Aval 4:</td>
      <td colspan="3" align="left" valign="middle"><input name="aval_rut_4" type="text" disabled class="etiqueta12" id="aval_rut_4" value="<?php echo $row_DetailRS1['aval_rut_4']; ?>" size="15" maxlength="18"> 
        / 
      <input name="aval_nom_4" type="text" disabled class="etiqueta12" id="aval_nom_4" value="<?php echo $row_DetailRS1['aval_nom_4']; ?>" size="80" maxlength="80"></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21">Apoderados</td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Apoderado 1:</td>
      <td colspan="3" align="left" valign="middle"><input name="apo_rut1" type="text" class="etiqueta12" id="apo_rut1" value="<?php echo $row_DetailRS1['apo_rut1']; ?>" size="15" maxlength="18">
/
  <input name="apo_nom1" type="text" class="etiqueta12" id="apo_nom1" value="<?php echo $row_DetailRS1['apo_nom1']; ?>" size="80" maxlength="80"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Apoderado 2:</td>
      <td colspan="3" align="left" valign="middle"><input name="apo_rut2" type="text" class="etiqueta12" id="apo_rut2" value="<?php echo $row_DetailRS1['apo_rut2']; ?>" size="15" maxlength="18">
/
  <input name="apo_nom2" type="text" class="etiqueta12" id="apo_nom2" value="<?php echo $row_DetailRS1['apo_nom2']; ?>" size="80" maxlength="80"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Apoderado 3:</td>
      <td colspan="3" align="left" valign="middle"><input name="apo_rut3" type="text" class="etiqueta12" id="apo_rut3" value="<?php echo $row_DetailRS1['apo_rut3']; ?>" size="15" maxlength="18">
/
  <input name="apo_nom3" type="text" class="etiqueta12" id="apo_nom3" value="<?php echo $row_DetailRS1['apo_nom3']; ?>" size="80" maxlength="80"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Apoderado 4:</td>
      <td colspan="3" align="left" valign="middle"><input name="apo_rut4" type="text" class="etiqueta12" id="apo_rut4" value="<?php echo $row_DetailRS1['apo_rut4']; ?>" size="15" maxlength="18">
/
  <input name="apo_nom4" type="text" class="etiqueta12" id="apo_nom4" value="<?php echo $row_DetailRS1['apo_nom4']; ?>" size="80" maxlength="80"></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><span class="Estilo51"><span class="titulodetalle"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"></span>Operadores y Roles</span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Operador 1:</td>
      <td colspan="3" align="left" valign="middle"><input name="ope_rut1" type="text" class="etiqueta12" id="ope_rut1" value="<?php echo $row_DetailRS1['ope_rut1']; ?>" size="15" maxlength="18">
/
  <input name="ope_nom1" type="text" class="etiqueta12" id="ope_nom1" value="<?php echo $row_DetailRS1['ope_nom1']; ?>" size="80" maxlength="80">
/
<select name="rol1" class="etiqueta12" id="rol1">
  <option value="Sin Dato." selected <?php if (!(strcmp("Sin Dato.", $row_DetailRS1['rol1']))) {echo "selected=\"selected\"";} ?>>N/A</option>
  <option value="Apoderado." <?php if (!(strcmp("Apoderado.", $row_DetailRS1['rol1']))) {echo "selected=\"selected\"";} ?>>Apoderado</option>
  <option value="Usuario." <?php if (!(strcmp("Usuario.", $row_DetailRS1['rol1']))) {echo "selected=\"selected\"";} ?>>Usuario</option>
</select></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Operador 2:</td>
      <td colspan="3" align="left" valign="middle"><input name="ope_rut2" type="text" class="etiqueta12" id="ope_rut2" value="<?php echo $row_DetailRS1['ope_rut2']; ?>" size="15" maxlength="18">
/
  <input name="ope_nom2" type="text" class="etiqueta12" id="ope_nom2" value="<?php echo $row_DetailRS1['ope_nom2']; ?>" size="80" maxlength="80">
/
<select name="rol2" class="etiqueta12" id="rol2">
  <option value="Sin Dato." selected <?php if (!(strcmp("Sin Dato.", $row_DetailRS1['rol2']))) {echo "selected=\"selected\"";} ?>>N/A</option>
  <option value="Apoderado." <?php if (!(strcmp("Apoderado.", $row_DetailRS1['rol2']))) {echo "selected=\"selected\"";} ?>>Apoderado</option>
  <option value="Usuario." <?php if (!(strcmp("Usuario.", $row_DetailRS1['rol2']))) {echo "selected=\"selected\"";} ?>>Usuario</option>
</select></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Operador 3:</td>
      <td colspan="3" align="left" valign="middle"><input name="ope_rut3" type="text" class="etiqueta12" id="ope_rut3" value="<?php echo $row_DetailRS1['ope_rut3']; ?>" size="15" maxlength="18">
/
  <input name="ope_nom3" type="text" class="etiqueta12" id="ope_nom3" value="<?php echo $row_DetailRS1['ope_nom3']; ?>" size="80" maxlength="80">
/
<select name="rol3" class="etiqueta12" id="rol3">
  <option value="Sin Dato." selected <?php if (!(strcmp("Sin Dato.", $row_DetailRS1['rol3']))) {echo "selected=\"selected\"";} ?>>N/A</option>
  <option value="Apoderado." <?php if (!(strcmp("Apoderado.", $row_DetailRS1['rol3']))) {echo "selected=\"selected\"";} ?>>Apoderado</option>
  <option value="Usuario." <?php if (!(strcmp("Usuario.", $row_DetailRS1['rol3']))) {echo "selected=\"selected\"";} ?>>Usuario</option>
</select></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Operador 4:</td>
      <td colspan="3" align="left" valign="middle"><input name="ope_rut4" type="text" class="etiqueta12" id="ope_rut4" value="<?php echo $row_DetailRS1['ope_rut4']; ?>" size="15" maxlength="18">
/
  <input name="ope_nom4" type="text" class="etiqueta12" id="ope_nom4" value="<?php echo $row_DetailRS1['ope_nom4']; ?>" size="80" maxlength="80">
/
<select name="rol4" class="etiqueta12" id="rol4">
  <option value="Sin Dato." selected <?php if (!(strcmp("Sin Dato.", $row_DetailRS1['rol4']))) {echo "selected=\"selected\"";} ?>>N/A</option>
  <option value="Apoderado." <?php if (!(strcmp("Apoderado.", $row_DetailRS1['rol4']))) {echo "selected=\"selected\"";} ?>>Apoderado</option>
  <option value="Usuario." <?php if (!(strcmp("Usuario.", $row_DetailRS1['rol4']))) {echo "selected=\"selected\"";} ?>>Usuario</option>
</select></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Operador 5:</td>
      <td colspan="3" align="left" valign="middle"><input name="ope_rut5" type="text" class="etiqueta12" id="ope_rut5" value="<?php echo $row_DetailRS1['ope_rut5']; ?>" size="15" maxlength="18">
/
  <input name="ope_nom5" type="text" class="etiqueta12" id="ope_nom5" value="<?php echo $row_DetailRS1['ope_nom5']; ?>" size="80" maxlength="80">
/
<select name="rol5" class="etiqueta12" id="rol5">
  <option value="Sin Dato." selected <?php if (!(strcmp("Sin Dato.", $row_DetailRS1['rol5']))) {echo "selected=\"selected\"";} ?>>N/A</option>
  <option value="Apoderado." <?php if (!(strcmp("Apoderado.", $row_DetailRS1['rol5']))) {echo "selected=\"selected\"";} ?>>Apoderado</option>
  <option value="Usuario." <?php if (!(strcmp("Usuario.", $row_DetailRS1['rol5']))) {echo "selected=\"selected\"";} ?>>Usuario</option>
</select></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Operador 6:</td>
      <td colspan="3" align="left" valign="middle"><input name="ope_rut6" type="text" class="etiqueta12" id="ope_rut6" value="<?php echo $row_DetailRS1['ope_rut6']; ?>" size="15" maxlength="18">
/
  <input name="ope_nom6" type="text" class="etiqueta12" id="ope_nom6" value="<?php echo $row_DetailRS1['ope_nom6']; ?>" size="80" maxlength="80">
/
<select name="rol6" class="etiqueta12" id="rol6">
  <option value="Sin Dato." selected <?php if (!(strcmp("Sin Dato.", $row_DetailRS1['rol6']))) {echo "selected=\"selected\"";} ?>>N/A</option>
  <option value="Apoderado." <?php if (!(strcmp("Apoderado.", $row_DetailRS1['rol6']))) {echo "selected=\"selected\"";} ?>>Apoderado</option>
  <option value="Usuario." <?php if (!(strcmp("Usuario.", $row_DetailRS1['rol6']))) {echo "selected=\"selected\"";} ?>>Usuario</option>
</select></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Estado:</td>
      <td align="center" valign="middle"><label>
        <select name="estado" class="etiqueta12" id="estado">
          <option value="Vigente." <?php if (!(strcmp("Vigente.", $row_DetailRS1['estado']))) {echo "selected=\"selected\"";} ?>>Vigente</option>
          <option value="Cerrado." <?php if (!(strcmp("Cerrado.", $row_DetailRS1['estado']))) {echo "selected=\"selected\"";} ?>>Cerrado</option>
          <option value="Sin Cupo." <?php if (!(strcmp("Sin Cupo.", $row_DetailRS1['estado']))) {echo "selected=\"selected\"";} ?>>Sin Cupo</option>
        </select>
      </label></td>
      <td align="right" valign="middle">Producto:</td>
      <td align="center" valign="middle"><select name="producto" class="etiqueta12" id="producto">
        <option value="N/A" <?php if (!(strcmp("N/A", $row_DetailRS1['producto_cci']))) {echo "selected=\"selected\"";} ?>Seleccione Una Opcion </option>
        <option value="Cartas de Credito Import." <?php if (!(strcmp("Cartas de Credito Import.", $row_DetailRS1['producto_cci']))) {echo "selected=\"selected\"";} ?>>Cartas de Credito Import</option>
        <option value="Op Contado." <?php if (!(strcmp("Op Contado.", $row_DetailRS1['producto_cci']))) {echo "selected=\"selected\"";} ?>>Op Contado</option>
        <option value="Prestamo." <?php if (!(strcmp("Prestamo.", $row_DetailRS1['producto_cci']))) {echo "selected=\"selected\"";} ?>>Prestamo</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="center" valign="middle"><input name="fecha_ingreso" type="text" disabled class="etiqueta12" id="fecha_ingreso" value="<?php echo $row_DetailRS1['fecha_ingreso']; ?>" size="12" maxlength="10"></td>

      <td align="right" valign="middle">Sucursal:</td>
      <td align="center" valign="middle"><label>
  <select name="sucursal" class="etiqueta12" id="sucursal">
          <option value="Casa Matriz" <?php if (!(strcmp("Casa Matriz", $row_DetailRS1['sucursal']))) {echo "selected=\"selected\"";} ?>>Casa Matriz</option>
          <option value="Oficina" <?php if (!(strcmp("Oficina", $row_DetailRS1['sucursal']))) {echo "selected=\"selected\"";} ?>>Oficina</option>
        </select>
</label></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="consultacw_mae.php"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image6" width="80" height="25" border="0"></a>      </div></td>
  </tr>
</table>
<br>
<br>
<script type="text/javascript">
/*<!--
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
//-->*/
</script>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>