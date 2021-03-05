<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE opste SET estado=%s, fecha_curse=%s, date_curse=%s, nro_operacion=%s, obs=%s, banco=%s, rut_banco=%s, pais=%s, referencia=%s, tipo_operacion=%s, estado_comision=%s, vcto_operacion=%s, otros_ben=%s, ordenante=%s, plazo=%s, gastos=%s, vcto_boleta=%s, moneda_contra=%s, monto_contra=%s, periodisidad=%s, inicio_periodo=%s, sub_estado=%s, vi=%s, iteraciones=%s, date_supe=%s, pagare=%s, autorizador=%s, visador=%s, mandato=%s, excepcion_comision=%s, fuera_horario=%s WHERE id=%s",
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['fecha_curse'], "text"),
                       GetSQLValueString($_POST['date_curse'], "date"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['banco'], "text"),
                       GetSQLValueString($_POST['rut_banco'], "text"),
                       GetSQLValueString($_POST['pais'], "text"),
                       GetSQLValueString($_POST['referencia'], "text"),
                       GetSQLValueString($_POST['tipo_operacion'], "text"),
                       GetSQLValueString($_POST['estado_comision'], "text"),
                       GetSQLValueString($_POST['vcto_operacion'], "date"),
                       GetSQLValueString($_POST['otros_ben'], "text"),
                       GetSQLValueString($_POST['ordenante'], "text"),
                       GetSQLValueString($_POST['plazo'], "text"),
                       GetSQLValueString($_POST['gastos'], "text"),
                       GetSQLValueString($_POST['vcto_boleta'], "date"),
                       GetSQLValueString($_POST['moneda_contra'], "text"),
                       GetSQLValueString($_POST['monto_contra'], "double"),
                       GetSQLValueString($_POST['periodisidad'], "text"),
                       GetSQLValueString($_POST['date_curse'], "date"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['vi'], "text"),
                       GetSQLValueString($_POST['iteraciones'], "int"),
                       GetSQLValueString($_POST['date_supe'], "date"),
                       GetSQLValueString($_POST['pagare'], "text"),
                       GetSQLValueString($_POST['autorizador'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['mandato'], "text"),
                       GetSQLValueString($_POST['excepcion_comision'], "text"),
                       GetSQLValueString($_POST['fuera_horario'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "altamae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$colname_DetailRS1 = "-1";
if (isset($_GET['id'])) {
  $colname_DetailRS1 = $_GET['id'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opste WHERE id = %s ORDER BY evento ASC", GetSQLValueString($colname_DetailRS1, "int"));
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
if (isset($_GET['estado'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['estado'] : addslashes($_GET['estado']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = sprintf("SELECT * FROM opste  WHERE id = $recordID", $colname_DetailRS1);
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
<title>Alta Operaciones - Detalle</title>
<style type="text/css">
<!--
@import url(../../../../estilos/estilo12.css);
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
.Estilo5 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {
	font-size: 14px;
	font-weight: bold;
	color: #FF0000;
}
.Estilo14 {font-size: 12px}
.Estilo8 {color: #FFFFFF; font-weight: bold; }
-->
</style>
<script src="../../../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
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
function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es requerido.\n'; }
  } if (errors) alert('El(los) siguiente(s) error(es) ha(n) ocurrido:\n'+errors);
  document.MM_returnValue = (errors == '');
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
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
<link href="../../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<br>
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">ALTA OPERACIONES SUPERVISOR - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">OPERACIONES DE CAMBIO</td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" onSubmit="MM_validateForm('nro_operacion','','R','fecha_curse','','R','nro_cuotas','','RinRange1:40');return document.MM_returnValue">
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="6" align="left"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="titulodetalle">Alta Operaciones Supervisor Stand By Emitidas        
        </div>
      </span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Operaci&oacute;n:</td>
      <td align="center"><span id="sprytextfield1">
      <input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="17" maxlength="17">
      <span class="textfieldRequiredMsg"><span class="rojopequeno">Se necesita un valor.</span></span><span class="textfieldMinCharsMsg">No se cumple el m�nimo de caracteres requerido.</span></span>        </div></td>
      <td align="right">Rut Cliente:</div></td>
      <td colspan="3" align="center">
        <input name="rut_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15">
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nombre Cliente:</td>
      <td colspan="5" align="left"><input name="nombre_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Estado:</td>
      <td align="center">        
        <select name="estado" class="etiqueta12" id="estado">
          <option value="Cursada." selected>Cursada</option>
          <option value="Reparada.">Reparada</option>
          <option value="Pendiente.">Devuelta</option>
          </select>
      </div>        
        </div>      
      </div></td>
      <td align="right">Fecha Curse:</div></td>
      <td align="center">
      <input name="fecha_curse" type="text" disabled="disabled" class="etiqueta12" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10">
            <span class="rojopequeno">(dd-mm-aaaa)</span><br>
      </div></td>
      <td align="right">Vcto Operaci&oacute;n:</div></td>
      <td align="center"><input name="vcto_operacion" type="text" class="etiqueta12" id="vcto_operacion" value="<?php echo $row_DetailRS1['vcto_operacion']; ?>" size="12" maxlength="10">
        <span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Tipo Operaci&oacute;n: </td>
      <td align="center">
        <label>
        <select name="tipo_operacion" class="etiqueta12" id="tipo_operacion">
          <option value="Avisaje." <?php if (!(strcmp("Avisaje.", $row_DetailRS1['tipo_operacion']))) {echo "SELECTED";} ?>>Avisaje</option>
          <option value="Confirmada." <?php if (!(strcmp("Confirmada.", $row_DetailRS1['tipo_operacion']))) {echo "SELECTED";} ?>>Confirmada</option>
          <option value="Facilidad Crediticia." <?php if (!(strcmp("Facilidad Crediticia.", $row_DetailRS1['tipo_operacion']))) {echo "SELECTED";} ?>>Facilidad Crediticia</option>
          <option value="Boleta Garantia." <?php if (!(strcmp("Boleta Garantia.", $row_DetailRS1['tipo_operacion']))) {echo "SELECTED";} ?>>Boleta Garantia</option>
          <option value="Enterada en Efectivo." <?php if (!(strcmp("Enterada en Efectivo.", $row_DetailRS1['tipo_operacion']))) {echo "SELECTED";} ?>>Enterada en Efectivo</option>
        </select>
</label>
      </div>
      </td>
      <td align="right">Periodisidad:</td>
      <td align="center"></div>
        <label></label><label><span class="rojopequeno">
        <select name="periodisidad" class="etiqueta12" id="periodisidad">
          <option value="0" <?php if (!(strcmp(0, $row_DetailRS1['periodisidad']))) {echo "SELECTED";} ?>>No Aplica</option>
          <option value="30" <?php if (!(strcmp(30, $row_DetailRS1['periodisidad']))) {echo "SELECTED";} ?>>Mensual</option>
          <option value="60" <?php if (!(strcmp(60, $row_DetailRS1['periodisidad']))) {echo "SELECTED";} ?>>Bimensual</option>
          <option value="90" <?php if (!(strcmp(90, $row_DetailRS1['periodisidad']))) {echo "SELECTED";} ?>>Trimestral</option>
          <option value="120" <?php if (!(strcmp(120, $row_DetailRS1['periodisidad']))) {echo "SELECTED";} ?>>Cuatrimestral</option>
          <option value="180" <?php if (!(strcmp(180, $row_DetailRS1['periodisidad']))) {echo "SELECTED";} ?>>Semestral</option>
          <option value="360" <?php if (!(strcmp(360, $row_DetailRS1['periodisidad']))) {echo "SELECTED";} ?>>Anual</option>
        </select>
        </span>
      </label></td>
      <td align="right"></div>        Vcto Boleta:</div>        </td>
      <td align="center"><span class="rojopequeno">
        <input name="vcto_boleta" type="text" class="etiqueta12" id="vcto_boleta" value="<?php echo $row_DetailRS1['vcto_boleta']; ?>" size="12" maxlength="10">
(aaaa-mm-dd)</span></td>
    </tr>
    <tr valign="middle">
      <td align="right"><p>Estado Comisi&oacute;n:</p>
      </td>
      <td align="center">
      <span class="rojopequeno">
      <select name="estado_comision" class="etiqueta12" id="estado_comision">
        <option value="Pagada." <?php if (!(strcmp("Pagada.", $row_DetailRS1['estado_comision']))) {echo "SELECTED";} ?>>Pagada</option>
        <option value="Pendiente." <?php if (!(strcmp("Pendiente.", $row_DetailRS1['estado_comision']))) {echo "SELECTED";} ?>>Pendiente</option>
      </select>
</span></div></td>
      <td align="right">Pagar&eacute;:</div></td>
      <td align="center">
        <select name="pagare" class="etiqueta12" id="pagare">
          <option value="N/A" <?php if (!(strcmp("N/A", $row_DetailRS1['pagare']))) {echo "SELECTED";} ?>>No</option>
          <option value="Si" <?php if (!(strcmp("Si", $row_DetailRS1['pagare']))) {echo "SELECTED";} ?>>Si</option>
        </select>
      </div></td>
    <td align="right">Contravalor / <br>
          Monto Operaci&oacute;n:</div></td>
      <td align="center">
      <select name="moneda_contra" class="etiqueta12" id="moneda_contra">
            <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>CLP</option>
            <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>DKK</option>
            <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>NOK</option>
            <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>SEK</option>
            <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>USD</option>
            <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>CAD</option>
            <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>AUD</option>
            <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>HKD</option>
            <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>EUR</option>
            <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>CHF</option>
            <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>GBP</option>
            <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>ZAR</option>
            <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>JPY</option>
            <option value="FRS" <?php if (!(strcmp("FRS", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>FRS</option>
	    <option value="UF" <?php if (!(strcmp("UF", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>UF</option>
        </select>
          <span class="rojopequeno">/</span>
          <input name="monto_contra" type="text" class="etiqueta12" id="monto_contra" value="<?php echo $row_DetailRS1['monto_contra']; ?>" size="17" maxlength="15">
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Mandato:</td>
      <td align="center">
        <input name="mandato" type="text" class="etiqueta12" id="mandato" value="<?php echo $row_DetailRS1['mandato']; ?>" size="30" maxlength="25" readonly="readonly">
        <br>
      </td>
      <td align="right">Excepci&oacute;n Comisi&oacute;n:</td>
      <td align="center">
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['excepcion_comision'],"Si"))) {echo "checked=\"checked\"";} ?> type="radio" name="excepcion_comision" value="Si" id="excepcion_comision_0">
          Si</label>
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['excepcion_comision'],"No"))) {echo "checked=\"checked\"";} ?> type="radio" name="excepcion_comision" value="No" id="excepcion_comision_1">
          No</label>
        <br>
      </td>
      <td align="right">Fuera Horario:</td>
      <td align="center"><label>
        <input <?php if (!(strcmp($row_DetailRS1['fuera_horario'],"Si"))) {echo "checked=\"checked\"";} ?> type="radio" name="fuera_horario" value="Si">
        Si</label>
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['fuera_horario'],"No"))) {echo "checked=\"checked\"";} ?> name="fuera_horario" type="radio" value="No">
      No</label></td>
    </tr>
    <tr valign="middle">
      <td align="right">Observaci&oacute;n:</td>
      <td colspan="5" align="left"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12" id="obs"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
      <span class="rojopequeno" id="countsprytextarea1">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Codigo Swift : </td>
      <td colspan="2" align="center"><input name="rut_banco" type="text" class="etiqueta12" id="rut_banco" value="<?php echo $row_DetailRS1['rut_banco']; ?>" size="15" maxlength="12">
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
      <td colspan="2" align="right">Referencia:</td>
      <td align="center"><input name="referencia" type="text" class="etiqueta12" id="referencia" value="<?php echo $row_DetailRS1['referencia']; ?>" size="50" maxlength="50"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nombre Banco:</td>
      <td colspan="5" align="left"><input name="banco" type="text" class="etiqueta12" id="banco" value="<?php echo $row_DetailRS1['banco']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Pais</td>
      <td colspan="2" align="center"><input name="pais" type="text" class="etiqueta12" id="pais" value="<?php echo $row_DetailRS1['pais']; ?>" size="20" maxlength="20"></td>
      <td colspan="2" align="right">Responsabilidad:</div></td>
      <td align="center"><label>
        <input <?php if (!(strcmp($row_DetailRS1['responsabilidad'],"Si."))) {echo "CHECKED";} ?> type="radio" name="responsabilidad" value="Si.">
Si</label>
        <label>
        <input <?php if (!(strcmp($row_DetailRS1['responsabilidad'],"No."))) {echo "CHECKED";} ?> type="radio" name="responsabilidad" value="No.">
No</label></td>
    </tr>
    <tr valign="middle">
      <td align="right">Beneficiario(s):</div></td>
      <td colspan="5" align="left"><span id="sprytextarea2">
        <textarea name="otros_ben" cols="80" rows="4" class="etiqueta12" id="otros_ben"><?php echo $row_DetailRS1['otros_ben']; ?></textarea>
      <span class="rojopequeno" id="countsprytextarea2">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n�mero m�ximo de caracteres.</span></span></div></td>
    </tr>
    <tr align="center" valign="middle">
      <td align="right">Otro Ordenante:</td>
      <td colspan="5" align="left"><input name="ordenante" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['ordenante']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr align="center" valign="middle">
      <td align="right">Plazo:</td>
      <td colspan="2" align="center"><label>
        <input <?php if (!(strcmp($row_DetailRS1['plazo'],"(+1)"))) {echo "CHECKED";} ?> name="plazo" type="radio" class="etiqueta12" value="(+1)">
+ 1 a&ntilde;o</label>
        <label>
        <input <?php if (!(strcmp($row_DetailRS1['plazo'],"(-1)"))) {echo "CHECKED";} ?> name="plazo" type="radio" class="etiqueta12" value="(-1)">
-1 a&ntilde;o</label></td>
      <td colspan="2" align="right">Gastos:</td>
      <td align="center"><label>
        <input <?php if (!(strcmp($row_DetailRS1['gastos'],"BEN"))) {echo "CHECKED";} ?> name="gastos" type="radio" class="etiqueta12" value="BEN">
Beneficiario</label>
        <label>
        <input <?php if (!(strcmp($row_DetailRS1['gastos'],"OUR"))) {echo "CHECKED";} ?> name="gastos" type="radio" class="etiqueta12" value="OUR">
Nuestros</label></td>
    </tr>
    <tr align="center" valign="middle">
      <td colspan="6" align="center">
        <input type="submit" class="boton" value="Alta Supervisor">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input name="vi" type="hidden" id="vi" value="<?php echo $row_DetailRS1['vi']; ?>">
  <input name="iteraciones" type="hidden" id="iteraciones" value="<?php echo ($row_DetailRS1['iteraciones'] + $row_DetailRS1['vi']); ?>">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
  <input name="sub_estado" type="hidden" id="sub_estado" value="<?php echo $row_DetailRS1['estado']; ?>">
  <input name="date_supe" type="hidden" id="date_supe" value="<?php echo date("Y-m-d H:i:s"); ?>">
  <input name="autorizador" type="hidden" id="autorizador" value="<?php echo $_SESSION['login'];?>">
  <input name="fecha_curse" type="hidden" id="fecha_curse" value="<?php echo date("d-m-Y"); ?>">
  <input name="date_curse" type="hidden" id="date_curse" value="<?php echo date("Y-m-d"); ?>">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="altamae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {minChars:0, maxChars:255, isRequired:false, validateOn:["blur"], counterId:"countsprytextarea2", counterType:"chars_remaining"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"], minChars:1});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         