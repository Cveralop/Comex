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
  $updateSQL = sprintf("UPDATE opcex SET evento=%s, fecha_curse=%s, date_curse=%s, asignador=%s, operador=%s, nro_operacion=%s, nro_inscripcion=%s, obs=%s, especialista=%s, moneda_operacion=%s, monto_operacion=%s, beneficiario=%s, tipo_plazo=%s, tipo_tasa=%s, tipo_salida=%s, detalle_salida=%s, detalle_salida_otro=%s, tipo_operacion=%s, nro_planillas=%s, sub_estado=%s, date_visa=%s, date_asig=%s, date_oper=%s, reparo_obs=%s, estado_visacion=%s, visador=%s, mandato=%s, excepcion=%s, excepcion_comision=%s, autorizacion_operaciones=%s, autorizacion_especialista=%s, responsable_excepcion=%s, tipo_excepcion=%s, solucion_excepcion=%s, urgente=%s, fuera_horario=%s, cantidad=%s WHERE id=%s",
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['fecha_curse'], "text"),
                       GetSQLValueString($_POST['date_curse'], "date"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['nro_inscripcion'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['especialista'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['beneficiario'], "text"),
                       GetSQLValueString($_POST['tipo_plazo'], "text"),
                       GetSQLValueString($_POST['tipo_tasa'], "text"),
                       GetSQLValueString($_POST['tipo_salida'], "text"),
                       GetSQLValueString($_POST['detalle_salida'], "text"),
                       GetSQLValueString($_POST['detalle_salida_otro'], "text"),
                       GetSQLValueString($_POST['tipo_operacion'], "text"),
                       GetSQLValueString($_POST['nro_planillas'], "int"),
                       GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['reparo_obs'], "text"),
                       GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['visador'], "text"),
                       GetSQLValueString($_POST['mandato'], "text"),
                       GetSQLValueString($_POST['excepcion'], "text"),
                       GetSQLValueString($_POST['excepcion_comision'], "text"),
                       GetSQLValueString($_POST['autorizacion_operaciones'], "text"),
                       GetSQLValueString($_POST['autorizacion_especialista'], "text"),
                       GetSQLValueString($_POST['responsable_excepcion'], "text"),
                       GetSQLValueString($_POST['tipo_excepcion'], "text"),
                       GetSQLValueString($_POST['solucion_excepcion'], "date"),
                       GetSQLValueString($_POST['urgente'], "text"),
                       GetSQLValueString($_POST['fuera_horario'], "text"),
                       GetSQLValueString($_POST['cantidad'], "int"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "visamae.php";
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
$query_DetailRS1 = sprintf("SELECT * FROM opcex WHERE id = %s", $colname_DetailRS1);
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = "SELECT * FROM opcex WHERE id = $recordID";
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Visaci&oacute;n -  Detalle</title>
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
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {
	font-size: 16px;
	color: #FF0000;
	font-weight: bold;
}
.Estilo7 {font-size: 14px}
.Estilo8 {font-size: 14px}
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
    <td width="93%" align="left" valign="middle" class="Estilo3">VISACI&Oacute;N - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CREDITOS EXTERNOS</td>
  </tr>
</table>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="../../certificado_matrimonio/consulta_certifi_matri.php" target="_blank"><img src="../../../imagenes/Botones/ver_avales.jpg" alt="" width="80" height="25" border="0" align="middle"></a></td>
  </tr>
</table>
<br>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline" bgcolor="#999999">
      <td colspan="7" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulodetalle">Visaci&oacute;n Operaci&oacute;n</div>
      </span></td>
    </tr>
    <tr valign="baseline">
      <td width="19%" align="right" valign="middle">Nro Registro:</td>
      <td width="33%" align="center" valign="middle"><span class="nroregistro"><?php echo $row_DetailRS1['id']; ?></span>        </div></td>
      <td width="12%" align="right" valign="middle">Rut Cliente:</div></td>
      <td colspan="4" align="center" valign="middle">
        <input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="12" readonly="readonly">
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="6" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120" readonly="readonly"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="center" valign="middle">
        <input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_ingreso']; ?>" size="12" maxlength="10" readonly="readonly">
        <span class="rojopequeno">(dd-mm-aaaa)</span></div></td>
      <td align="right" valign="middle">Evento:</div></td>
      <td colspan="4" align="center" valign="middle">        <select name="evento" class="etiqueta12" id="evento">
        <option value="Remesa." <?php if (!(strcmp("Remesa.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Remesa</option>
        <option value="Liquidacion." <?php if (!(strcmp("Liquidacion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Liquidacion</option>
        <option value="Abono." <?php if (!(strcmp("Abono.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Abono</option>
        <option value="Planilla." <?php if (!(strcmp("Planilla.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Planilla</option>
        <option value="Inscripcion." <?php if (!(strcmp("Inscripcion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Inscripcion</option>
        <option value="Actua. Planilla." <?php if (!(strcmp("Actua. Planilla.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Actua. Planilla</option>
        <option value="Compra." <?php if (!(strcmp("Compra.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Compra</option>
        <option value="Venta." <?php if (!(strcmp("Venta.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Venta</option>
<option value="Arbitraje." <?php if (!(strcmp("Arbitraje.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Arbitraje</option>
        <option value="Carta Original." <?php if (!(strcmp("Carta Original.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Carta Original</option>
        <option value="Requerimiento." <?php if (!(strcmp("Requerimiento.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Requerimiento</option>
        <option value="Solucion Excepcion." <?php if (!(strcmp("Solucion Excepcion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Solucion Excepcion</option>
        <option value="Dev Comisiones." <?php if (!(strcmp("Dev Comisiones.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Dev Comisiones</option>
        <option value="LBTR." <?php if (!(strcmp("LBTR.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>LBTR</option>
      </select>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nro Operaci&oacute;n:</td>
      <td align="center" valign="middle"><span id="sprytextfield3">
      <input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="20" maxlength="20">
      <span class="textfieldRequiredMsg"><span class="rojopequeno">Se necesita un valor.</span></span><span class="textfieldMinCharsMsg">No se cumple el m�nimo de caracteres requerido.</span></span>        </div></td>
      <td align="right" valign="middle">Especialista:</div></td>
      <td align="center" valign="middle">
        <input name="especialista" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista_curse']; ?>" size="20" maxlength="50">
      </div></td>
      <td align="right" valign="middle">Tipo Operaci&oacute;n:</div></td>
      <td colspan="2" align="center" valign="middle">
        <select name="tipo_operacion" class="etiqueta12" id="tipo_operacion">
          <option value="Credito Externo." <?php if (!(strcmp("Credito Externo.", $row_DetailRS1['tipo_operacion']))) {echo "SELECTED";} ?>>Credito Externo</option>
          <option value="Capitulo XII." <?php if (!(strcmp("Capitulo XII.", $row_DetailRS1['tipo_operacion']))) {echo "SELECTED";} ?>>Capitulo XII</option>
          <option value="Capitulo XIV." <?php if (!(strcmp("Capitulo XIV.", $row_DetailRS1['tipo_operacion']))) {echo "SELECTED";} ?>>Capilulo XIV</option>
          <option value="DL600." <?php if (!(strcmp("DL600.", $row_DetailRS1['tipo_operacion']))) {echo "SELECTED";} ?>>DL600</option>
        </select>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Observaci&oacute;n:</div></td>
      <td colspan="6" align="left" valign="middle"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
      <span class="rojopequeno" id="countsprytextarea1">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Moneda / <br>
      Monto Operaci&oacute;n:</td>
      <td align="center" valign="middle">
          <select name="moneda_operacion" class="etiqueta12" id="moneda_operacion">
            <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>CLP</option>
            <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>DKK</option>
            <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>NOK</option>
            <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>SEK</option>
            <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>USD</option>
            <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>CAD</option>
            <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>AUD</option>
            <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>HKD</option>
            <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>EUR</option>
            <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>CHF</option>
            <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>GBP</option>
            <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>ZAR</option>
            <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>JPY</option>
	    <option value="UF" <?php if (!(strcmp("UF", $row_DetailRS1['moneda_contra']))) {echo "SELECTED";} ?>>UF</option>
          </select> 
          <span class="rojopequeno">/</span>        
          <input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="17" maxlength="15">
      </div></td>
      <td rowspan="2" align="right" valign="middle">Visador:</div></td>
      <td colspan="2" rowspan="2" align="center" valign="middle">
          <input name="visador" type="text" class="etiqueta12" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20">
        </div></td>
      <td rowspan="2" align="center" valign="middle">Cantidad:</td>
      <td rowspan="2" align="center" valign="middle"><span id="sprytextfield4">
      <label>
        <input name="cantidad" type="text" class="etiqueta12" id="cantidad" value="1" size="5" maxlength="3">
      </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Urgente:</td>
      <td align="center" valign="middle"><label>
        <input <?php if (!(strcmp($row_DetailRS1['urgente'],"Si"))) {echo "checked=\"checked\"";} ?> type="radio" name="urgente" value="Si">
        Si</label>
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['urgente'],"No"))) {echo "checked=\"checked\"";} ?> name="urgente" type="radio" value="No">
          No</label>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td colspan="7" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="titulodetalle">Excepci&oacute;n Operaci&oacute;n</span></td>
    </tr>
    <tr valign="baseline">
      <td rowspan="3" align="right" valign="middle">Excepci&oacute;n:</td>
      <td rowspan="3" align="center" valign="middle"><label>
        <input type="radio" name="excepcion" value="Si">
        Si</label>
        <label>
          <input name="excepcion" type="radio" value="No" checked>
      No</label></td>
      <td align="right" valign="middle">Auto. Opera.:</div></td>
      <td colspan="4" align="center" valign="middle">
        <input name="autorizacion_operaciones" type="text" class="etiqueta12" size="30" maxlength="50">
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Auto. Espe.:</td>
      <td colspan="4" align="center" valign="middle"><input name="autorizacion_especialista" type="text" class="etiqueta12" size="30" maxlength="50"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Resp. Excepci&oacute;n:</td>
      <td colspan="4" align="center" valign="middle"><label for="responsable_excepcion"></label>
      <input name="responsable_excepcion" type="text" class="etiqueta12" id="responsable_excepcion" size="30" maxlength="50"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Tipo Excepci&oacute;n:</td>
      <td colspan="6" align="left" valign="middle">
      <select name="tipo_excepcion" class="etiqueta12" id="tipo_excepcion">
        <option value="N/A." selected>N/A</option>
            <option value="Art 85 Vencido.">Art 85 Vencido</option>
            <option value="Linea de Credito sobregirada.">Linea de Credito sobregirada</option>
            <option value="Falta Autorizacion de Riesgos.">Falta Autorizacion de Riesgos</option>
            <option value="Aprobaci&oacute;o puntual de Riesgos no incluye tolerancia.">Aprobacion puntual de Riesgos no incluye tolerancia</option>
            <option value="Falta minuta de Credito.">Falta minuta de Credito</option>
            <option value="Firma disconforme.">Firma disconforme</option>
            <option value="Falta VB&ordm; poderes y firmas.">Falta VB&ordm; poderes y firmas</option>
            <option value="Falta mail Sucursal por pagare en custodia.">Falta mail Sucursal por pagare en custodia</option>
            <option value="Pagare sin llenar.">Pagare sin llenar</option>
            <option value="Pagare no corresponde.">Pagare no corresponde</option>
            <option value="Pagare version antigua.">Pagare version antigua</option>
            <option value="Falta pagare para aumento de valor de operacion.">Falta pagare para aumento de valor de operacion</option>
            <option value="Falta informe de fiscalia para avales sociedad anonima.">Falta informe de fiscalia para avales sociedad anonima</option>
            <option value="Avales no corresponde en pagare seg&uacute;n lo solicitado por riesgo.">Avales no corresponde en pagare seg&uacute;n lo solicitado por riesgo</option>
            <option value="Certificado de matrimonio avales vencidos o no se encuentra en nuestros archivos.">Certificado de matrimonio avales vencidos o no se encuentra en nuestros archivos</option>
            <option value="Falta constitucion de garantias.">Falta constitucion de garantias</option>
            <option value="Sin Mandato.">Sin Mandato</option>
      </select>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Solucion Excepcion:</td>
      <td align="center" valign="middle"><span id="sprytextfield2">
      <input name="solucion_excepcion" type="text" class="etiqueta12" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
      <td align="right" valign="middle">Mandato:</td>
      <td align="center" valign="middle"><input name="mandato" type="text" class="etiqueta12" id="mandato" value="<?php echo $row_DetailRS1['mandato']; ?>" size="30" maxlength="25" readonly="readonly"></td>
      <td align="right" valign="middle">Excepci&oacute;n Comsiones:</td>
      <td colspan="2" align="center" valign="middle"><label>
        <input type="radio" name="excepcion_comision" value="Si" id="excepcion_comision_0">
        Si</label>
        <label>
          <input name="excepcion_comision" type="radio" id="excepcion_comision_1" value="No" checked>
      No</label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Estado Visaci&oacute;n:</div></td>
      <td align="center" valign="middle">
      <span class="Estilo8">
      <select name="estado" class="etiqueta12" id="estado">
        <option value="Cursada." selected>Cursada</option>
        <option value="Reparada.">Reparada</option>
      </select>
</span></td>
      <td align="right" valign="middle">Fuera Horario: </div></td>
      <td colspan="4" align="center" valign="middle">        
          <label>
          <input <?php if (!(strcmp($row_DetailRS1['fuera_horario'],"Si"))) {echo "checked=\"checked\"";} ?> type="radio" name="fuera_horario" value="Si">
  Si</label>
          <label>
          <input <?php if (!(strcmp($row_DetailRS1['fuera_horario'],"No"))) {echo "checked=\"checked\"";} ?> name="fuera_horario" type="radio" value="No">
No</label>
          <br>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Observaci&oacute;n Reparo:</td>
      <td colspan="6" align="left" valign="middle"><span id="sprytextarea2">
        <textarea name="reparo_obs" cols="80" rows="6" class="etiqueta12" id="reparo_obs"></textarea>
      <span class="rojopequeno" id="countsprytextarea2">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></div></td>
    </tr>
    <tr valign="baseline">
      <td colspan="7" align="left" valign="middle"><span class="Estilo5"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21">Cursar Operaci&oacute;n</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nro. Planilla:</td>
      <td align="center" valign="middle"><span id="sprytextfield1">
      <input name="nro_planillas" type="text" class="etiqueta12" id="nro_planillas" value="1" size="6" maxlength="6">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span><span class="textfieldMinCharsMsg">No se cumple el m�nimo de caracteres requerido.</span><span class="rojopequeno">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
      <td align="right" valign="middle">Nro Inscripci&oacute;n:</td>
      <td align="center" valign="middle"><input name="nro_inscripcion" type="text" class="etiqueta12" id="nro_inscripcion" size="10" maxlength="10"></td>
      <td align="right" valign="middle">Tipo Plazo:</td>
      <td colspan="2" align="center" valign="middle"><select name="tipo_plazo" class="etiqueta12" id="tipo_plazo">
        <option selected>N/A</option>
        <option value="Vista.">Vista</option>
        <option value="Plazo.">Plazo.</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Tipo Tasa:</td>
      <td align="center" valign="middle"><select name="tipo_tasa" class="etiqueta12" id="tipo_tasa">
        <option value="N/A" selected>N/A</option>
        <option value="Fija.">Fija</option>
        <option value="Variable.">Variable</option>
      </select></td>
      <td align="right" valign="middle">Tipo Salida:</td>
      <td align="center" valign="middle"><select name="tipo_salida" class="etiqueta12" id="tipo_salida">
        <option selected>N/A</option>
        <option value="Ingreso.">Ingreso</option>
        <option value="Egreso.">Egreso</option>
      </select></td>
      <td align="right" valign="middle">Detalle Salida:</td>
      <td colspan="2" align="center" valign="middle"><select name="detalle_salida" class="etiqueta12" id="detalle_salida">
        <option selected>N/A</option>
        <option value="Amortizacion.">Amortizacion</option>
        <option value="Retornos.">Retornos</option>
        <option value="Aporte Capital.">Aporte Capital</option>
        <option value="Inv. del Exterior.">Inv. del Exterior</option>
        <option value="Pago.">Pago</option>
        <option value="Venta.">Venta</option>
        <option value="Inv al Exterior.">Inv. al Exterior</option>
        <option value="Credito al Exterior.">Credito al Exterior</option>
        <option value="Comisiones.">Comisiones</option>
        <option value="Otro.">Otro</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Detalle Salida Otro:</td>
      <td colspan="6" align="left" valign="middle"><input name="detalle_salida_otro" type="text" class="etiqueta12" id="detalle_salida_otro" size="122" maxlength="120"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Beneficiario:</td>
      <td colspan="6" align="left" valign="middle"><input name="beneficiario" type="text" class="etiqueta12" id="beneficiario" size="122" maxlength="120"></td>
    </tr>
    <tr valign="baseline">
      <td colspan="7" align="center" valign="middle"><input type="submit" class="boton" value="Visar / Cursar Operaci&oacute;n"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
  <input name="date_visa" type="hidden" id="date_visa" value="<?php echo date("Y-m-d H:i:s"); ?>">
  <input name="estado_visacion" type="hidden" id="estado_visacion" value="Cursada.">
  <input name="operador" type="hidden" id="operador" value="<?php echo $_SESSION['login'];?>">
  <input name="date_curse" type="hidden" id="date_curse" value="<?php echo date("Y-m-d"); ?>">
  <input name="fecha_curse" type="hidden" id="fecha_curse" value="<?php echo date("d-m-Y"); ?>">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="visamae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false, minChars:0, maxChars:450, validateOn:["blur"], counterId:"countsprytextarea2", counterType:"chars_remaining"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["blur"], minChars:1, maxChars:999});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"], minChars:1});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {validateOn:["blur", "change"], hint:"1"});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
mysqli_free_result($colores);
?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   