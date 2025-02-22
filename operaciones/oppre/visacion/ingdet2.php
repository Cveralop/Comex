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

$colname_DetailRS1 = "1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM oppre nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS2 = "SELECT cliente.* FROM oppre INNER JOIN cliente ON oppre.rut_cliente=cliente.rut_cliente WHERE oppre.id = $recordID";
$DetailRS2 = mysqli_query($comercioexterior, $query_DetailRS2) or die(mysqli_error($comercioexterior));
$row_DetailRS2 = mysqli_fetch_assoc($DetailRS2);
$totalRows_DetailRS2 = mysqli_num_rows($DetailRS2);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO oppre (rut_cliente, nombre_cliente, fecha_ingreso, date_ingreso, evento, estado, asignador, operador, nro_operacion, obs, moneda_operacion, monto_operacion, nro_cuotas, sub_estado, date_visa, date_asig, tipo_operacion, reparo_obs, estado_visacion, visador, excepcion, autorizacion_operaciones, autorizacion_especialista, responsable_excepcion, tipo_excepcion, solucion_excepcion, urgente, fuera_horario) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['date_ingreso'], "date"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['visador'], "text"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['nro_cuotas'], "int"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['tipo_operacion'], "text"),
                       GetSQLValueString($_POST['reparo_obs'], "text"),
                       GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['visador'], "text"),
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
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}

</style>
<script src="../../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">INGRESO VISACI&Oacute;N - DETALLE </td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="../../certificado_matrimonio/consulta_certifi_matri.php" target="_blank"><img src="../../../imagenes/Botones/ver_avales.jpg" alt="" width="80" height="25" border="0" align="middle"></a></td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="4" align="left"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="titulodetalle">Ingresar Visaci&oacute;n</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Rut Cliente:</td>
      <td align="center">
        <input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15" readonly>
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
      <td align="right">Fecha Ingreso:</div></td>
      <td align="center">
        <input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10" readonly> 
      <span class="rojopequeno">(dd-mm-aaaa) </span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nombre Cliente:</td>
      <td colspan="3" align="left"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120" readonly></td>
    </tr>
    <tr valign="middle">
      <td align="right">Evento:</td>
      <td align="center">        <select name="evento" class="etiqueta12" id="evento">
        <option value="Aviso Cuotas.">Aviso Cuotas</option>
        <option value="Prorroga.">Prorroga</option>
        <option value="Prorroga y Pago.">Prorroga y Pago</option>
        <option value="Cambio Tasa.">Cambio Tasa</option>
        <option value="Pago.">Pago</option>
        <option value="Visacion.">Visacion (DI)</option>
        <option value="Cartera Vencida.">Cartera Vencida</option>
        <option value="Carta Original.">Carta Original</option>
        <option value="Requerimiento.">Requerimiento</option>
        <option value="Solucion Excepcion.">Solucion Excepcion</option>
        <option value="Dev Comisiones.">Dev Comisiones</option>
        <option value="Mandato PAC.">Mandato PAC</option>
        <option value="Restructuracion.">Restructuracion</option>
        <option value="Redenominacion.">Redenominacion</option>
      </select>
      </div></td>
      <td align="right">Operador:</td>
      <td align="center"><select name="operador" class="etiqueta12" id="operador">
        <option value="0" selected>Seleccion un Operador</option>
        <option value="MTOROB">Veronica Toro</option>
        <option value="SCHAVEZ">Sebastian Chavez Vasquez</option>
        <option value="FFARINAS">Francisco Farinas</option>
        <option value="CLEYTON">Carlos Leyton Gatica</option>
        <option value="FMUNOZ">Felipe Munoz Perez </option>
        <option value="KAGUIRRE">Katherine Aguirre</option>
        <option value="CZAMBRAN">Cynthia Zambrano Leiva</option>
        <option value="JCASTILL">Javiera Castillo Mena</option>
        <option value="IVARGAS">Ives Vargas Perez</option>
        <option value="IIBACET">Ingrid Ibaceta Vidal</option>
        <option value="PPRE1">Practica PRE 1</option>
        <option value="PPRE2">Practica PRE 2</option>
        <option value="PPRE3">Practica PRE 3</option>
        <option value="ROBOT1">Robot 1</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right">Observaci&oacute;n:</td>
      <td colspan="3" align="left"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12"></textarea>
      <span class="rojopequeno"><span id="countsprytextarea1">&nbsp;</span></span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Operaci&oacute;n:</td>
      <td align="center"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="15" maxlength="7" readonly>
      <span class="rojopequeno">F &oacute; L000000</span></td>
      <td align="right">Mandato:</td>
      <td align="center"><input name="mandato" type="text" class="etiqueta12" id="mandato" value="<?php echo $row_DetailRS2['estado_mandato']; ?>" size="30" maxlength="25" readonly></td>
    </tr>
    <tr valign="middle">
      <td align="right">Moneda /<br> 
      Monto Operaci&oacute;n:</td>
      <td align="center">
              <select name="moneda_operacion" class="etiqueta12" id="moneda_operacion">
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
            <input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="20" maxlength="20">
      </div></td>
      <td align="right">Tipo Operaci&oacute;n:</td>
      <td align="center"><select name="tipo_operacion2" class="etiqueta12" id="tipo_operacion2">
        <option value="Confirming.">Confirming</option>
        <option value="Forfaiting.">Forfaiting</option>
        <option value="PAE.">PAE</option>
        <option value="PAE Cobex.">PAE Cobex</option>
        <option value="PAE SGR.">PAE SGR</option>
        <option value="Finan. Contado.">Finan. Contado</option>
        <option value="Finan. Contado COBEX.">Finan. Contado COBEX</option>
        <option value="Finan. Contado SGR.">Finan. Contado SGR</option>
        <option value="Credito Comercial.">Credito Comercial</option>
        <option value="Credito Comercial COBEX.">Credito Comercial COBEX</option>
        <option value="Credito Comercial SGR.">Credito Comercial SGR</option>
      </select>
      </div>        </div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Urgente:</td>
      <td align="center" valign="middle">
        <label>
          <input type="radio" name="urgente" value="Si">
  Si</label>
        <label>
<input name="urgente" type="radio" value="No" checked>
No</label></td>
      <td align="right" valign="middle">Fuera Horario: </td>
      <td align="center" valign="middle"><label>
        <input type="radio" name="fuera_horario" value="Si">
Si</label>
        <label>
        <input name="fuera_horario" type="radio" value="No" checked>
No</label></td>
    </tr>
    <tr valign="middle">
      <td align="right" bgcolor="#999999">Nro Cuotas:</td>
      <td colspan="3" align="left" bgcolor="#999999"><span id="sprytextfield3">
        <label>
          <input name="nro_cuotas" type="text" class="etiqueta12" id="nro_cuotas" value="<?php echo $row_DetailRS1['nro_cuotas']; ?>" size="6" maxlength="3">
        </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span><span class="textfieldMinCharsMsg">No se cumple el m&iacute;nimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al m&aacute;ximo permitido.</span><span class="textfieldMinValueMsg"><span class="rojopequeno">El valor introducido es inferior al m&iacute;nimo permitido.</span></span></span></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="left" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="titulodetalle">Excepci&oacute;n Operaci&oacute;n</span></td>
    </tr>
    <tr valign="middle">
      <td rowspan="3" align="right">Excepci&oacute;n:</td>
      <td rowspan="3" align="center" valign="middle"><label>
        <input type="radio" name="excepcion" value="Si">
        Si</label>
        <label>
          <input name="excepcion" type="radio" value="No" checked>
      No</label></td>
      <td align="right" valign="middle">Auto. Opera.: </td>
      <td align="center" valign="middle"><input name="autorizacion_operaciones" type="text" class="etiqueta12" id="autorizacion_operaciones" size="30" maxlength="50"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Auto. Espe.:</td>
      <td align="center" valign="middle"><input name="autorizacion_especilista" type="text" class="etiqueta12" id="autorizacion_especilista" size="30" maxlength="50"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Resp. Excepci&oacute;n:</td>
      <td align="center" valign="middle"><input name="responsable_excepcion" type="text" class="etiqueta12" id="responsable_excepcion" size="30" maxlength="50"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Tipo Excepci&oacute;n: </td>
      <td align="center" valign="middle"><select name="tipo_excepcion" class="etiqueta12" id="tipo_excepcion">
        <option value="N/A." selected>N/A</option>
        <option value="Sin Mandato.">Sin Mandato</option>
        <option value="Sin DI.">Sin DI</option>
        <option value="Sin Declaracion Jurada.">Sin Declaraci&oacute;n Jurada</option>
        <option value="Declaracion Jurada es Copia.">Declaracion Jurada es Copia</option>
        <option value="Articulo 85 Vencido.">Articulo 85 Vencido</option>
        <option value="Linea Sobregirada.">Linea Sobregirada</option>
        <option value="Pagare.">Pagare</option>
        <option value="Carta Solicitud en Fotocopia.">Carta Solicitud en Fotocopia</option>
      </select></td>
      <td align="right" valign="middle">Soluci&oacute;n Excepci&oacute;n:</div></td>
      <td align="center" valign="middle">
      <label>          </label>
      <span id="sprytextfield1">
      <input name="solucion_excepcion" type="text" class="etiqueta12" id="solucion_excepcion" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span><span class="rojopequeno">(aaaa-mm-dd)</span><br>
      </div></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="left" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"><span class="titulodetalle">Reparo</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Estado Visaci&oacute;n:</td>
      <td colspan="3" align="left" valign="middle"><label>
        <input name="estado" type="radio" id="estado_0" value="Pendiente." checked>
        Enviada a Curse</label>
        <label>
          <input name="estado" type="radio" class="respuestacolumna_rojo" id="estado_1" value="Reparada.">
      <span class="respuestacolumna_rojo">Reparada</span></label></td>
    </tr>
    <tr valign="middle">
      <td align="right">Observaci&oacute;n Reparo: </td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextarea2">
        <textarea name="reparo_obs" cols="80" rows="6" class="etiqueta12" id="reparo_obs"></textarea>
        <span class="rojopequeno"><span id="countsprytextarea2">&nbsp;</span></span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></div>
      </td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="center">
        <input type="submit" class="boton" value="Ingresar Instrucci&oacute;n">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="id">
  <input type="hidden" name="MM_insert" value="form1">
  <input type="hidden" name="date_ingreso" value="<?php echo date("Y-m-d"); ?>" size="32">
  <input name="date_visa" type="hidden" id="date_visa" value="<?php echo date("Y-m-d H:i:s"); ?>" size="32">
  <input name="visador" type="hidden" class="etiqueta12" id="visador" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20">
  <input name="estado_visacion" type="hidden" id="estado_visacion" value="Cursada.">
  <input name="tipo_operacion" type="hidden" id="tipo_operacion" value="<?php echo $row_DetailRS1['tipo_operacion']; ?>">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="ingmae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false, minChars:0, maxChars:450, validateOn:["blur"], counterId:"countsprytextarea2", counterType:"chars_remaining"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["blur"], minChars:1, maxChars:3, maxValue:999, minValue:1});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
mysqli_free_result($DetailRS2);
?>