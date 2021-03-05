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
  $insertSQL = sprintf("INSERT INTO opmec (rut_cliente, nombre_cliente, fecha_ingreso, date_ingreso, evento, estado, asignador, operador, obs, moneda_operacion, monto_operacion, cantidad, sub_estado, date_visa, date_asig, reparo_obs, estado_visacion, visador, mandato, excepcion, autorizacion_operaciones, autorizacion_especialista, responsable_excepcion, tipo_excepcion, solucion_excepcion, urgente, fuera_horario) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['date_ingreso'], "date"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['asignador'], "text"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['cantidad'], "int"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['reparo_obs'], "text"),
                       GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['asignador'], "text"),
                       GetSQLValueString($_POST['mandato'], "text"),
                       GetSQLValueString($_POST['excepcion'], "text"),
                       GetSQLValueString($_POST['autorizacion_operaciones'], "text"),
                       GetSQLValueString($_POST['autorizacion_especilista'], "text"),
                       GetSQLValueString($_POST['responsable_excepcion'], "text"),
                       GetSQLValueString($_POST['tipo_excepcion'], "text"),
                       GetSQLValueString($_POST['solucion_excepcion'], "date"),
                       GetSQLValueString($_POST['urgente'], "text"),
                       GetSQLValueString($_POST['fuera_horario'], "text"));
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
if (isset($_GET['rut_cliente'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['rut_cliente'] : addslashes($_GET['rut_cliente']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opmec WHERE rut_cliente = '%s'", $colname_DetailRS1);
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
$query_DetailRS1 = sprintf("SELECT * FROM cliente  WHERE id = $recordID", $colname_ingape);
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
<title>Ingreso Visaci&oacute;n - Detalle</title>
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
	color: #FFFFFF;
	font-size: 12px;
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
  } if (errors) alert('El(los) siguiente(s) error(es) ha(n) occurrido:\n'+errors);
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
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO VISACI&Oacute;N - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">MERCADO DE CORREDORES</td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" onSubmit="MM_validateForm('monto_operacion','','RisNum');return document.MM_returnValue">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline" bgcolor="#999999">
      <td colspan="4" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="titulodetalle">Ingreso Visaci&oacute;n</div>
      </span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle">
          <input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15" readonly="readonly">
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
      <td align="right" valign="middle">Fecha Ingreso:</div></td>
      <td align="center" valign="middle">
          <input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10" readonly="readonly"> 
      <span class="rojopequeno">(dd-mm-aaaa)</span></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120" readonly="readonly"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Evento:</td>
      <td align="center" valign="middle">        
        <select name="evento" class="etiqueta12" id="evento">
          <option value="Enviar OP.">Enviar OP</option>
          <option value="Op Recibida Limp.">Op Recibida Limpia</option>
          <option value="Op Recibida Con Inc.">Op Recibida Con Inc</option>
          <option value="OPI.">OPI</option>
          <option value="Op Recibida WEB.">Op Recibida WEB</option>
          <option value="Ventas.">Ventas</option>
          <option value="Compras.">Compras</option>
          <option value="Arbitraje.">Arbitraje</option>
          <option value="Emision Cheque.">Emision Cheque</option>
          <option value="Cheque Camara.">Cheque Camara</option>
          <option value="Emision Planilla.">Emision Planilla</option>
          <option value="Soli Abono M/X.">Soli Abono M/X</option>
          <option value="Liq OP Recibidas.">Liq OP Recibidas</option>
          <option value="Abono MT 910.">Abono MT 910</option>
          <option value="LBTR.">LBTR</option>
          <option value="Requerimiento.">Requerimiento</option>
          <option value="Solucion Excepcion.">Solucion Excepcion</option>
          <option value="Dev Comisiones.">Dev Comisiones</option>
          <option value="Gastos Our.">Gastos Our</option>
          <option value="Sol. Rep. Ext.">Solucion Reparo Ext.</option>
          <option value="Liq. Fordward.">Liquidacion Forward</option>
          <option value="Solicitud OPE WEB.">Solicitud OPE WEB</option>
        </select>
      </div></td>
      <td align="right" valign="middle">Operador:</td>
      <td align="center" valign="middle"><select name="operador" class="etiqueta12" id="operador">
        <option value="TATA">TATA</option>
        <option value="TATA BCO">TATA BCO</option>
        <option value="JWEERHEI">Jeffrey Weerheim</option>        
        <option value="MNICOLAS">Matias Nicolas</option>
	<option value="RMISSEN">Romina Missen Hernandez</option>
        <option value="NMORAT">Natalia Mora Toledo</option>
        <option value="JAGURTO">Jaquelin Agurto Lillo</option>
        <option value="CZAMBRAN">Cynthia Zambrano Leiva</option>
        <option value="NPINTO">Natalia Pinto</option>
	<option value="PSANCHEZ">Paulina Sanchez Ossandon</option>
	<option value="TANTEQUE">Tomas Antequera Tocigl</option>
	<option value="CVIDAL">Catherine Vidal Gonzalez</option>
	<option value="ACORVALA">Alvaro Corvalan</option>
	<option value="ACONCHA">Alejandra Concha</option>
	<option value="FVASQUEZ">Fabian Vasquez</option>
        <option value="PMECO1">PMECO1</option>
        <option value="PMECO2">PMECO2</option>
        <option value="PMECO3">PMECO3</option>
      </select>        </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Cantidad:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextfield3">
        <label>
          <input name="cantidad" type="text" class="etiqueta12" id="cantidad" value="1" size="5" maxlength="3">
        </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Min 1 Max 999</span><span class="textfieldMinValueMsg">El valor introducido es inferior al m&iacute;nimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al m&aacute;ximo permitido.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Observaci&oacute;n:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12"></textarea>
      <span class="rojopequeno"><span id="countsprytextarea1">&nbsp;</span></span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Moneda / <br>
Monto Operaci&oacute;n:</td>
      <td align="center" valign="middle"><select name="moneda_operacion" class="etiqueta12" id="moneda_operacion">
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
      <input name="monto_operacion" type="text" class="etiqueta12" value="0.00" size="20" maxlength="20"></td>
      <td align="right" valign="middle">Mandato:</td>
      <td align="center" valign="middle"><input name="mandato" type="text" class="etiqueta12" id="mandato" value="<?php echo $row_DetailRS1['estado_mandato']; ?>" size="30" maxlength="25" readonly="readonly"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Valuta:</td>
      <td align="center" valign="middle"><select name="valuta" class="etiqueta12" id="valuta">
        <option value="NA." selected>No Aplica</option>
        <option value="0.">Valuta 0</option>
        <option value="24.">Valuta 24</option>
        <option value="48.">Valuta 48</option>
      </select></td>
      <td align="right" valign="middle">Urgente:</td>
      <td align="center" valign="middle"><label>
        <input name="urgente" type="radio" class="etiqueta12" value="Si">
        Si</label>
        <label>
          <input name="urgente" type="radio" class="etiqueta12" value="No" checked>
      No</label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Fuera Horario:</td>
      <td colspan="3" align="left" valign="middle"><label>
        <input type="radio" name="fuera_horario" value="Si">
        Si</label>
        <label>
          <input name="fuera_horario" type="radio" value="No" checked>
      No</label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="titulodetalle">Excepci&oacute;n Operaci&oacute;n
          <label></label>
      </span></td>
    </tr>
    <tr valign="baseline">
      <td rowspan="3" align="right" valign="middle">Excepci&oacute;n: </td>
      <td rowspan="3" align="center" valign="middle"><label>
        <input type="radio" name="excepcion" value="Si">
        Si</label>
        <label>
          <input name="excepcion" type="radio" value="No" checked>
      No</label></td>
      <td align="right" valign="middle">Auto. Opera.:</td>
      <td align="center" valign="middle"><input name="autorizacion_operaciones" type="text" class="etiqueta12" id="autorizacion_operaciones" size="30" maxlength="50"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Auto. Espe.:</td>
      <td align="center" valign="middle">
        <label>          </label>
        <input name="autorizacion_especilista" type="text" class="etiqueta12" id="autorizacion_especilista" size="30" maxlength="50">
        <br>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Resp. Excepci&oacute;n:</td>
      <td align="center" valign="middle"><input name="responsable_excepcion" type="text" class="etiqueta12" id="responsable_excepcion" size="30" maxlength="50">        </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Tipo Excepci&oacute;n:</td>
      <td align="center" valign="middle"><span id="sprytextfield4">
        <label>
          <input name="tipo_excepcion" type="text" class="etiqueta12" id="tipo_excepcion" value="N/A" size="50" maxlength="50">
        </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      <td align="right" valign="middle">Soluci&oacute;n Excepci&oacute;n:</td>
      <td align="center" valign="middle"><span id="sprytextfield1">
      <input name="solucion_excepcion" type="text" class="etiqueta12" id="solucion_excepcion" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span><span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"><span class="titulodetalle">Reparo</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Estado Visaci&oacute;n:</div></td>
      <td colspan="3" align="left" valign="middle"><label>
        <input name="estado" type="radio" id="estado_0" value="Pendiente." checked>
        Enviada a Curse</label>
        <label>
          <input name="estado" type="radio" class="respuestacolumna_rojo" id="estado_1" value="Reparada.">
      <span class="respuestacolumna_rojo">Reparada</span></label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Observaci&oacute;n Reparo:</div></td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextarea2">
        <textarea name="reparo_obs" cols="80" rows="6" class="etiqueta12" id="reparo_obs"></textarea>
      <span class="rojopequeno"><span id="countsprytextarea2">&nbsp;</span></span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></div></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle">
        <input type="submit" class="boton" value="Ingresar Visaci&oacute;n">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="id">
  <input type="hidden" name="MM_insert" value="form1">
  <input type="hidden" name="date_ingreso" value="<?php echo date("Y-m-d"); ?>" size="32">
  <input name="date_visa" type="hidden" id="date_visa" value="<?php echo date("Y-m-d H:i:s"); ?>" size="32">
  <input name="estado_visacion" type="hidden" id="estado_visacion" value="Cursada.">
  <input name="asignador" type="hidden" class="etiqueta12" id="asignador" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20">
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
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false, minChars:0, maxChars:450, validateOn:["blur"], counterId:"countsprytextarea2", counterType:"chars_remaining"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"yyyy-mm-dd"});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["blur"], minValue:1, maxValue:999, hint:"1"});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>