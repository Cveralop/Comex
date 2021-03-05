<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,MOX";
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
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE opcce SET rut_cliente=%s, nombre_cliente=%s, fecha_ingreso=%s, evento=%s, estado=%s, fecha_curse=%s, asignador=%s, operador=%s, nro_operacion=%s, obs=%s, especialista=%s, moneda_operacion=%s, monto_operacion=%s, pais=%s, banco_destino=%s, referencia=%s, currier=%s, moneda_documentos=%s, monto_documentos=%s, confirmacion=%s, tipo_confirmacion=%s, tipo_negociacion=%s, segmento=%s, sub_estado=%s, vi=%s, iteraciones=%s, date_espe=%s, date_asig=%s, date_oper=%s, date_supe=%s, folio=%s, autorizador=%s, reparo_espe=%s, reparo_obs=%s, convenio=%s WHERE id=%s",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['fecha_curse'], "text"),
                       GetSQLValueString($_POST['asignador'], "text"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['especialista'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['pais'], "text"),
                       GetSQLValueString($_POST['banco_destino'], "text"),
                       GetSQLValueString($_POST['referencia'], "text"),
                       GetSQLValueString($_POST['currier'], "text"),
                       GetSQLValueString($_POST['moneda_documentos'], "text"),
                       GetSQLValueString($_POST['monto_documentos'], "double"),
                       GetSQLValueString($_POST['confirmacion'], "text"),
                       GetSQLValueString($_POST['tipo_confirmacion'], "text"),
                       GetSQLValueString($_POST['tipo_negociacion'], "text"),
                       GetSQLValueString($_POST['segmento'], "text"),
                       GetSQLValueString($_POST['sub_estado'], "text"),
                       GetSQLValueString($_POST['vi'], "text"),
                       GetSQLValueString($_POST['iteraciones'], "int"),
                       GetSQLValueString($_POST['date_espe'], "text"),
                       GetSQLValueString($_POST['date_asig'], "text"),
                       GetSQLValueString($_POST['date_oper'], "text"),
                       GetSQLValueString($_POST['date_supe'], "text"),
                       GetSQLValueString($_POST['folio'], "text"),
                       GetSQLValueString($_POST['autorizador'], "text"),
                       GetSQLValueString($_POST['reparo_espe'], "text"),
                       GetSQLValueString($_POST['reparo_obs'], "text"),
                       GetSQLValueString($_POST['convenio'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error(comercioexterior));

  $updateGoTo = "opccemae.php";
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
if (isset($_GET['nro_operacion'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['nro_operacion'] : addslashes($_GET['nro_operacion']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = sprintf("SELECT * FROM opcce  WHERE id = $recordID", $colname_opcce);
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
<title>OPCCE - DETALLE</title>
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
.Estilo7 {	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.Estilo10 {
	font-size: 16px;
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
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
</head>

<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" class="Estilo3">OPCCE - DETALLE</td>
    <td width="7%" rowspan="2" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43"></td>
  </tr>
  <tr>
    <td class="Estilo4">COMERCIO EXTERIOR CARTAS DE CR&Eacute;DITO IMPORTACIONES </td>
  </tr>
</table>
<br>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline" bgcolor="#999999">
      <td colspan="4" align="right" valign="middle" nowrap><div align="left"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo7">Modificaci&oacute;n Operaci&oacute;n</span></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Nro Registro: </td>
      <td><div align="center"><span class="Estilo10"><?php echo $row_DetailRS1['id']; ?></span></div></td>
      <td align="right" valign="middle">Rut Cliente: </td>
      <td align="center" valign="middle"><div align="center">
        <input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="15" maxlength="12">
      <span class="rojopequeno">xxx.xxx.xxx-x</span></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Nombre Cliente:</td>
      <td colspan="3"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Fecha Ingreso:</td>
      <td align="center" valign="middle"><input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_ingreso']; ?>" size="12" maxlength="10"> 
        <span class="rojopequeno">dd-mm-aaaa</span> </td>
      <td align="right" valign="middle">Evento:</td>
      <td align="center" valign="middle"><div align="center">
        <select name="evento" class="etiqueta12" id="evento">
          <option value="Apertura." selected <?php if (!(strcmp("Apertura.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Apertura</option>
          <option value="Confirmacion." <?php if (!(strcmp("Confirmacion.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Confirmacion</option>
          <option value="Modificacion." <?php if (!(strcmp("Modificacion.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Modificacion</option>
          <option value="Anulacion." <?php if (!(strcmp("Anulacion.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Anulacion</option>
          <option value="MSG-Swift." <?php if (!(strcmp("MSG-Swift.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>MSG-Swift</option>
          <option value="Negociacion." <?php if (!(strcmp("Negociacion.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Negociacion</option>
          <option value="Alzamiento." <?php if (!(strcmp("Alzamiento.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Alzamiento</option>
          <option value="Pago." <?php if (!(strcmp("Pago.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Pago</option>
          <option value="Liquidacion." <?php if (!(strcmp("Liquidacion.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Liquidacion</option>
          </select>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Estado:</td>
      <td align="center" valign="middle"><select name="estado" class="etiqueta12" id="estado">
        <option value="Pendiente." <?php if (!(strcmp("Pendiente.", $row_DetailRS1['estado']))) {echo "SELECTED";} ?>>Pendiente</option>
        <option value="Cursada." <?php if (!(strcmp("Cursada.", $row_DetailRS1['estado']))) {echo "SELECTED";} ?>>Cursada</option>
        <option value="Reparada." <?php if (!(strcmp("Reparada.", $row_DetailRS1['estado']))) {echo "SELECTED";} ?>>Reparada</option>
      </select></td>
      <td align="right" valign="middle">Fecha Curse: </td>
      <td align="center" valign="middle"><input name="fecha_curse" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_curse']; ?>" size="12" maxlength="10">
      <span class="rojopequeno">dd-mm-aaaa</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Asignado:</td>
      <td align="center" valign="middle"><input name="asignador" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['asignador']; ?>" size="25" maxlength="20"></td>
      <td align="right" valign="middle">Operador:</td>
      <td align="center" valign="middle"><select name="operador" class="etiqueta12" id="operador">
        <option value="CURRUTP" <?php if (!(strcmp("CURRUTP", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Claudia Urritia Padilla</option>
        <option value="DDELCAM" <?php if (!(strcmp("DDELCAM", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Daniela del Campo Vergara</option>
        <option value="EROBLES" <?php if (!(strcmp("EROBLES", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Elizabeth Robles Novoa</option>
        <option value="FOLEAOR" <?php if (!(strcmp("FOLEAOR", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Fabiola Olea Ortega</option>
        <option value="FLOPEC" <?php if (!(strcmp("FLOPEC", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Fernando Lopez</option>
        <option value="HRAMIRZ" <?php if (!(strcmp("HRAMIRZ", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Hernan Ramirez Ramirez</option>
        <option value="HURIBEC" <?php if (!(strcmp("HURIBEC", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Hernan Uribe Campos</option>
        <option value="JMALDON" <?php if (!(strcmp("JMALDON", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Jaime Maldonado Cerda</option>
        <option value="JCONCHF" <?php if (!(strcmp("JCONCHF", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Jorge Concha Farina</option>
        <option value="JMARTOS" <?php if (!(strcmp("JMARTOS", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Jorge Martinez</option>
        <option value="LCELISD" <?php if (!(strcmp("LCELISD", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Luis Celis de Marini</option>
        <option value="MSALAMA" <?php if (!(strcmp("MSALAMA", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Marco Salamanca Sanchez</option>
        <option value="MNAVECH" <?php if (!(strcmp("MNAVECH", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Mauricio Nevech</option>
        <option value="PMOSCOA" <?php if (!(strcmp("PMOSCOA", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Pamela Moscoso</option>
        <option value="PESPINH" <?php if (!(strcmp("PESPINH", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Pascuala Espinoza Huerta</option>
        <option value="PGODOY" <?php if (!(strcmp("PGODOY", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Patricia Godoy Chavez</option>
        <option value="XGUAJAR" <?php if (!(strcmp("XGUAJAR", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Ximena Guajardo</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Nro Operaci&oacute;n:</td>
      <td colspan="3" align="center" valign="middle"><div align="left">
        <input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="10" maxlength="7">
        <span class="rojopequeno">E000000</span></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Observaci&oacute;n:</td>
      <td colspan="3" align="center" valign="middle"><div align="left">
        <textarea name="obs" cols="85" rows="3" class="etiqueta12"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
        <span class="rojopequeno">(255 caracteres m&aacute;ximo)</span></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Especialista:</td>
      <td align="center" valign="middle"><input name="especialista" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista']; ?>" size="25" maxlength="20"></td>
      <td align="right" valign="middle">Moneda / Monto Operaci&oacute;n: </td>
      <td align="center" valign="middle"><input name="moneda_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['moneda_operacion']; ?>" size="5" maxlength="3"> 
        <span class="rojopequeno">/</span>        <input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="20" maxlength="18"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Pa&iacute;s:</td>
      <td align="center" valign="middle"><input name="pais" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['pais']; ?>" size="25" maxlength="20"></td>
      <td align="right" valign="middle">Banco Destino: </td>
      <td align="center" valign="middle"><input name="banco_destino" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['banco_destino']; ?>" size="55" maxlength="50"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Referencia:</td>
      <td align="center" valign="middle"><input name="referencia" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['referencia']; ?>" size="25" maxlength="20"></td>
      <td align="right" valign="middle">Currier:</td>
      <td align="center" valign="middle"><input name="currier" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['currier']; ?>" size="25" maxlength="20"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Moneda / Monto Documentos:</td>
      <td align="center" valign="middle"><input name="moneda_documentos" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['moneda_documentos']; ?>" size="5" maxlength="3"> 
        <span class="rojopequeno">/</span>        <input name="monto_documentos" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_documentos']; ?>" size="20" maxlength="18"></td>
      <td align="right" valign="middle">Confirmaci&oacute;n:</td>
      <td align="center" valign="middle"><label>
        </label>
        <label>
        <input <?php if (!(strcmp($row_DetailRS1['confirmacion'],"No"))) {echo "CHECKED";} ?> name="confirmacion" type="radio" value="No">
Sin Confirmar</label>
        <label>
        <input <?php if (!(strcmp($row_DetailRS1['confirmacion'],"Si"))) {echo "CHECKED";} ?> type="radio" name="confirmacion" value="Si">
Confirmada</label>
      <label></label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Tipo Confirmaci&oacute;n:</td>
      <td align="center" valign="middle"><select name="tipo_confirmacion" class="etiqueta12" id="tipo_confirmacion">
        <option value="Confirmacion y Pago Anticipado." selected>Confirmacion y Pago Anticipado</option>
        <option value="Confirmacion y Financiamiento.">Confirmacion y Financiamiento</option>
        <option value="Financiamiento.">Financiamiento</option>
        <option value="Cesion de Derechos.">Cesion de Derechos</option>
        <option value="Compromiso de Pago/Cesion de Derecho.">Compromiso de Pago/Cesion de Derecho</option>
      </select></td>
      <td align="right" valign="middle">Tipo Negociaci&oacute;n:</td>
      <td align="center" valign="middle"><span class="etiqueta12">
        <label>
        <input <?php if (!(strcmp($row_DetailRS1['tipo_negociacion'],"Limpia."))) {echo "CHECKED";} ?> type="radio" name="tipo_negociacion" value="Limpia.">
Limpia</label>
        <label>
        <input <?php if (!(strcmp($row_DetailRS1['tipo_negociacion'],"Discrepancia."))) {echo "CHECKED";} ?> type="radio" name="tipo_negociacion" value="Discrepancia.">
Discrepancia</label>
      </span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Segmento:</td>
      <td align="center" valign="middle"><input name="segmento" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['segmento']; ?>" size="25" maxlength="20"></td>
      <td align="right" valign="middle">Sub Estado:</td>
      <td align="center" valign="middle"><label>
        <input <?php if (!(strcmp($row_DetailRS1['sub_estado'],"Pendiente."))) {echo "CHECKED";} ?> name="sub_estado" type="radio" class="etiqueta12" value="Pendiente.">
Pendiente</label>
        <label>
        <input <?php if (!(strcmp($row_DetailRS1['sub_estado'],"Cursada."))) {echo "CHECKED";} ?> name="sub_estado" type="radio" class="etiqueta12" value="Cursada.">
Cursada</label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Valor Iteraci&oacute;n: </td>
      <td align="center" valign="middle"><input name="vi" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['vi']; ?>" size="5" maxlength="2"></td>
      <td align="right" valign="middle">Cantidad Iteraciones:</td>
      <td align="center" valign="middle"><input name="iteraciones" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['iteraciones']; ?>" size="5" maxlength="3"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Fecha Ingreso Especialista:</td>
      <td align="center" valign="middle"><input name="date_espe" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['date_espe']; ?>" size="25" maxlength="20"></td>
      <td align="right" valign="middle">Fecha Ingreso Asignado: </td>
      <td align="center" valign="middle"><input name="date_asig" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['date_asig']; ?>" size="25" maxlength="20"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Fecha Ingreso Operador: </td>
      <td align="center" valign="middle"><input name="date_oper" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['date_oper']; ?>" size="25" maxlength="20"></td>
      <td align="right" valign="middle">Fecha Ingreso Supervisor: </td>
      <td align="center" valign="middle"><input name="date_supe" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['date_supe']; ?>" size="25" maxlength="20"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Folio:</td>
      <td align="center" valign="middle"><input name="folio" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['folio']; ?>" size="25" maxlength="20"></td>
      <td align="right" valign="middle">Autorizador:</td>
      <td align="center" valign="middle"><input name="autorizador" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['autorizador']; ?>" size="25" maxlength="20"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Reparo Especialista:</td>
      <td colspan="3" align="center" valign="middle"><div align="left">
        <input name="reparo_espe" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['reparo_espe']; ?>" size="100" maxlength="100">
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Reparo Observaci&oacute;n:</td>
      <td colspan="3" align="center" valign="middle"><div align="left">
        <textarea name="reparo_obs" cols="80" rows="10" class="etiqueta12"><?php echo $row_DetailRS1['reparo_obs']; ?></textarea>
        <span class="rojopequeno">(M&aacute;ximo 800 caracteres) </span></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap>Convenio:</td>
      <td colspan="3" align="center" valign="middle"><div align="left">
        <input <?php if (!(strcmp($row_DetailRS1['convenio'],"Si"))) {echo "checked";} ?> name="convenio" type="checkbox" id="convenio" value="Si">
      </div></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="right" valign="middle" nowrap><div align="center">
        <input type="submit" class="boton" value="Modificar Operaci&oacute;n">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
</form>
<table width="95%"  border="0" align="center">
  <tr>
    <td><div align="right"><a href="opccemae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>
