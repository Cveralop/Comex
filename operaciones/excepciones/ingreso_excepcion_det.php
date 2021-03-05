<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "SUP,ADM";
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

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT *,date_add(curdate(), interval 7 day)as fecha_vcto FROM cliente nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO excepciones (id, rut_cliente, nombre_cliente, ejecutivo_cuenta, ejecutivo_ni, especialista_ni, nombre_oficina, subgerente, segmento_comercial, zonal, territorial, fecha_ingreso, evento, producto, nro_operacion, nro_operacion_relacionada, obs, moneda_operacion, monto_operacion, visador, autorizacion_operaciones, autorizacion_especialista, responsable_excepcion, tipo_excepcion, vcto_excepcion, estado_excepcion) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['ejecutivo_cuenta'], "text"),
                       GetSQLValueString($_POST['ejecutivo_ni'], "text"),
                       GetSQLValueString($_POST['especialista_ni'], "text"),
                       GetSQLValueString($_POST['nombre_oficina'], "text"),
                       GetSQLValueString($_POST['subgerente'], "text"),
                       GetSQLValueString($_POST['segmento_comercial'], "text"),
                       GetSQLValueString($_POST['zonal'], "text"),
                       GetSQLValueString($_POST['territorial'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['producto'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['nro_operacion_relacionada'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['visador'], "text"),
                       GetSQLValueString($_POST['autorizacion_operaciones'], "text"),
                       GetSQLValueString($_POST['autorizacion_especialista'], "text"),
                       GetSQLValueString($_POST['responsable_excepcion'], "text"),
                       GetSQLValueString($_POST['tipo_excepcion'], "text"),
                       GetSQLValueString($_POST['vcto_excepcion'], "date"),
                       GetSQLValueString($_POST['estado_excepcion'], "text"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
  $insertGoTo = "ingreso_excepcion_mae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingreso Excepciones Admistrativas - Detalle</title>
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
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
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
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">INGRESO EXCEPCIONES ADMINISTRATIVAS - DETALLE</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">EXCEPCIONES</td>
  </tr>
</table>
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" />Detalle Ingreso Excepcion</td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15" readonly="readonly" />
        <span class="rojopequeno">Sin Puntos ni Guion</span></td>
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="center" valign="middle"><input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10" readonly="readonly" />
      <span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="80" maxlength="80" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Ejecutivo Cuenta:</td>
      <td align="center" valign="middle"><input name="ejecutivo_cuenta" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_ejecutivo']; ?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td align="right" valign="middle">Ejecutivo NI:</td>
      <td align="center" valign="middle"><input name="ejecutivo_ni" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['ejecutivo']; ?>" size="30" maxlength="50" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Especialista NI:</td>
      <td align="center" valign="middle"><input name="especialista_ni" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista']; ?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td align="right" valign="middle">Nombre Oficina:</td>
      <td align="center" valign="middle"><input name="nombre_oficina" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['oficina']; ?>" size="30" maxlength="50" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Subgerente:</td>
      <td align="center" valign="middle"><input name="subgerente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['subgerente']; ?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td align="right" valign="middle">Segmento Comercial:</td>
      <td align="center" valign="middle"><input name="segmento_comercial" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['segmento']; ?>" size="30" maxlength="50" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Zonal:</td>
      <td align="center" valign="middle"><input name="zonal" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['zonal']; ?>" size="30" maxlength="50" readonly="readonly" /></td>
      <td align="right" valign="middle">Territorial:</td>
      <td align="center" valign="middle"><input name="territorial" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['territorial']; ?>" size="30" maxlength="50" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Datos de la Excepción</td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Evento:</td>
      <td align="center" valign="middle"><select name="evento" class="etiqueta12" id="evento2">
        <option value="Sin Dato." selected="selected">Seleccione un Evento</option>
        <option value="Envio OP.">Envio OP</option>
        <option value="Compra.">Compra</option>
        <option value="Venta.">Venta</option>
        <option value="Arbitraje.">Arbitraje</option>
        <option value="Liq Op. Recibida.">Liq Op. Recibida</option>
        <option value="Emision Planilla.">Emision Planilla</option>
        <option value="Otorgamiento Prestamo.">Otorgamiento Prestamo</option>
        <option value="Prorroga y Pago Prestamo.">Prorroga y Pago Prestamo</option>
        <option value="Prorroga Prestamo.">Prorroga Prestamo</option>
        <option value="Pago Prestamo.">Pago Prestamo</option>
        <option value="Apertura Cart. Cred. Import.">Apertura Cart. Cred. Import.</option>
        <option value="Modificacion Cart. Cred. Import.">Modificacion Cart. Cred. Import.</option>
        <option value="Pago Cart. Cred. Import.">Pago Cart. Cred. Import.</option>
        <option value="Liq. de Retorno.">Liq. de Retorno</option>
        <option value="Apertura Cob. Import.">Apertura Cob. Import.</option>
        <option value="Modificacion Cob. Import.">Modificacion Cob. Import.</option>
        <option value="Pago Cob. Import.">Pago Cob. Import.</option>
        <option value="Apertura y Pago OPI.">Apertura y Pago OPI</option>
        <option value="Apertura OPI.">Apertura OPI</option>
        <option value="Modificacion OPI.">Modificacion OPI</option>
        <option value="Pago OPI.">Pago OPI</option>
        <option value="Boleta de Garantia.">Boleta de Garantia</option>
        <option value="Stand By Emitida.">Stand By Emitida</option>
        <option value="Credito IIIB5.">Credito IIIB5</option>
        <option value="Otro.">Otro</option>
      </select></td>
      <td align="right" valign="middle">Producto:</td>
      <td align="center" valign="middle"><select name="producto" class="etiqueta12" id="evento">
        <option value="Sin Dato" selected="selected">Seleccione un Produco</option>
          <option value="Boleta de Garantia">Boleta de Garantia</option>
          <option value="Cobranza Extranjera de Export">Cobranza Extranjera de Export</option>
          <option value="Cobranza Extranjera de Import">Cobranza Extranjera de Import</option>
          <option value="Carta de Credito Export">Carta de Credito Export</option>
          <option value="Carta de Credito Import">Carta de Credito Import</option>
          <option value="Cecion Derecho/Pago Anti">Cecion Derecho/Pago Anti</option>
          <option value="Credito Externo (DL600-CapXIII-CAPXIV)">Credito Externo (DL600-CapXIII-CAPXIV)</option>
          <option value="Mercado Corredores">Mercado Corredores</option>
          <option value="Prestamos Stand Alone">Prestamos Stand Alone</option>
          <option value="L/C Stand By Emitida">L/C Stand By Emitida</option>
          <option value="L/C Stand By Recibida">L/C Stand By Recibida</option>
          <option value="Credito IIIB5">Credito IIIB5</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nro Operación:</td>
      <td align="center" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" value="" size="10" maxlength="7" />
      <span class="rojopequeno">F, K, L, J o B000000</span></td>
      <td align="right" valign="middle">Nro Operacion Relacionada:</td>
      <td align="center" valign="middle"><input name="nro_operacion_relacionada" type="text" class="etiqueta12" value="" size="10" maxlength="7" />
      <span class="rojopequeno">F, K, L, J o B000000</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Obs:</td>
      <td colspan="3" align="left" valign="middle"><textarea name="obs" cols="80" rows="4" class="etiqueta12"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Moneda / Monto Operación:</td>
      <td align="center" valign="middle" bordercolor="#666666" bgcolor="#CCCCCC"><select name="moneda_operacion" class="etiqueta12" id="moneda_operacion">
        <option value="CLP">CLP</option>
        <option value="DKK">DKK</option>
        <option value="NOK">NOK</option>
        <option value="SEK">SEK</option>
        <option value="USD" selected="selected">USD</option>
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
        <input name="monto_operacion" type="text" class="etiqueta12" value="0.00" size="20" maxlength="20" />
        </div></td>
      <td align="right" valign="middle">Tipo Excepción:</td>
      <td align="center" valign="middle"><select name="tipo_excepcion" class="etiqueta12" id="tipo_excepcion">
        <option value="Sin Dato" selected="selected">Seleccione Una Opción</option>
        <option value="Art 85 Vencido.">Art 85 Vencido</option>
        <option value="Linea de Credito sobregirada.">Linea de Credito sobregirada</option>
        <option value="Falta Autorizacion de Riesgos.">Falta Autorizacion de Riesgos</option>
        <option value="Aprobacióo puntual de Riesgos no incluye tolerancia.">Aprobacion puntual de Riesgos no incluye tolerancia</option>
        <option value="Falta minuta de Credito.">Falta minuta de Credito</option>
        <option value="Firma disconforme.">Firma disconforme</option>
        <option value="Falta VBº poderes y firmas.">Falta VB&ordm; poderes y firmas</option>
        <option value="Falta mail Sucursal por pagare en custodia.">Falta mail Sucursal por pagare en custodia</option>
        <option value="Pagare sin llenar.">Pagare sin llenar</option>
        <option value="Pagare no corresponde.">Pagare no corresponde</option>
        <option value="Pagare version antigua.">Pagare version antigua</option>
        <option value="Falta pagare para aumento de valor de operacion.">Falta pagare para aumento de valor de operacion</option>
        <option value="Falta informe de fiscalia para avales sociedad anonima.">Falta informe de fiscalia para avales sociedad anonima</option>
        <option value="Avales no corresponde en pagare según lo solicitado por riesgo.">Avales no corresponde en pagare seg&uacute;n lo solicitado por riesgo</option>
        <option value="Certificado de matrimonio avales vencidos o no se encuentra en nuestros archivos.">Certificado de matrimonio avales vencidos o no se encuentra en nuestros archivos</option>
        <option value="Falta constitucion de garantias.">Falta constitucion de garantias</option>
        <option value="Solicitud de Credito en Copia.">Solicitud de Credito en Copia</option>
        <option value="Falta Firma Aval.">Falta Firma Aval</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td rowspan="3" align="right" valign="middle">Vcto Excepción:</td>
      <td rowspan="3" align="center" valign="middle"><input name="vcto_excepcion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_vcto']; ?>" size="12" maxlength="10" />
        (aaaa-mm-dd)</td>
      <td align="right" valign="middle">Autorizacion Operaciones:</td>
      <td align="center" valign="middle"><span id="sprytextfield2">
        <input name="autorizacion_operaciones" type="text" class="etiqueta12" value="" size="30" maxlength="50" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Autorizacion Especialista:</td>
      <td align="center" valign="middle"><span id="sprytextfield3">
        <input name="autorizacion_especialista" type="text" class="etiqueta12" value="" size="30" maxlength="50" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Responsable Excepción:</td>
      <td align="center" valign="middle"><span id="sprytextfield4">
        <input name="responsable_excepcion" type="text" class="etiqueta12" value="" size="30" maxlength="50" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle"><input type="submit" class="boton" value="Ingresar Excepción" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2" />
  <input type="hidden" name="id" value="" size="32" />
  <input type="hidden" name="estado_excepcion" value="Pendiente." size="32" />
  <input name="visador" type="hidden" class="etiqueta12" value="<?php echo $_SESSION['login'];?>" size="15" maxlength="15" />
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="bottom"><a href="excepciones.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen4','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen4" width="80" height="25" border="0" id="Imagen4" /></a></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"]});
//-->
  </script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>