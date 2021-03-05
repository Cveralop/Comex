<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,ESP";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO oppre (id, rut_cliente, nombre_cliente, fecha_ingreso, date_ingreso, evento, nro_operacion, obs, especialista_curse, moneda_operacion, monto_operacion, despacho_doctos, sucursal, segmento, date_espe, tipo_operacion, estado_visacion, urgente) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['date_ingreso'], "date"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['especialista_curse'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['despacho_doctos'], "text"),
                       GetSQLValueString($_POST['sucursal'], "int"),
                       GetSQLValueString($_POST['segmento'], "text"),
                       GetSQLValueString($_POST['date_espe'], "date"),
                       GetSQLValueString($_POST['tipo_operacion'], "text"),
                       GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['urgente'], "text"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
  $insertGoTo = "impredet2pre.php";
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
<title>Reparo - Detalle</title>
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
<script src="../../../SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
<link href="../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../../../SpryAssets/SpryValidationRadio.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">REPARO - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline" bgcolor="#999999">
      <td colspan="4" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulodetalle">Reingreso Operaci&oacute;n </div>
      </span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle">
        <input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="15" maxlength="12" readonly="readonly">
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
      <td align="right" valign="middle">Fecha Ingreso:</div></td>
      <td align="center" valign="middle">
        <input name="fecha_ingreso" type="text" class="etiqueta12" id="fecha_ingreso" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10"> 
      <span class="rojopequeno">(dd-mm-aaaa) </span></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120" readonly="readonly"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nro Operaci&oacute;n:</td>
      <td align="center" valign="middle">
        <input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="15" maxlength="7" readonly="readonly">
      <span class="rojopequeno">F &oacute; L000000</span></div></td>
      <td align="right" valign="middle">Especialista Curse:</td>
      <td align="center" valign="middle"></div>
      <input name="especialista_curse" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista_curse']; ?>" size="20" maxlength="20"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Observaci&oacute;n:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
      <span class="rojopequeno" id="countsprytextarea1">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Evento:</td>
      <td align="center" valign="middle"><input name="evento" type="text" class="etiqueta12" id="evento" value="<?php echo $row_DetailRS1['evento']; ?>" size="20" maxlength="20" readonly="readonly"></td>
      <td align="right" valign="middle">Tipo Operaci&oacute;n:</td>
      <td align="center" valign="middle"><input name="tipo_operacion" type="text" class="etiqueta12" id="tipo_operacion" value="<?php echo $row_DetailRS1['tipo_operacion']; ?>" size="25" maxlength="25" readonly="readonly"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Moneda / Monto Operaci&oacute;n:</td>
      <td align="center" valign="middle"><input name="moneda_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['moneda_operacion']; ?>" size="5" maxlength="3">
        <span class="rojopequeno">/</span>
      <input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="17" maxlength="15"></td>
      <td align="right" valign="middle">Tipo Tasa:</td>
      <td align="center" valign="middle"><p><span id="spryradio1">
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['tipo_tasa'],"Fija."))) {echo "checked=\"checked\"";} ?> type="radio" name="tipo_tasa" value="Fija." id="tipo_tasa_0">
          Fija</label>
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['tipo_tasa'],"Variable."))) {echo "checked=\"checked\"";} ?> type="radio" name="tipo_tasa" value="Variable." id="tipo_tasa_1">
          Variable</label>
        <br>
        <span class="radioRequiredMsg">Realice una selecci�n.</span></span><br>
      </p></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Tasa Viariable:</td>
      <td colspan="3" align="left" valign="middle"><select name="libor_tt" class="etiqueta12" id="libor_tt">
        <option value="N/A" selected <?php if (!(strcmp("N/A", $row_DetailRS1['libor_tt']))) {echo "selected=\"selected\"";} ?>>Libor a...</option>
        <option value="30" <?php if (!(strcmp(30, $row_DetailRS1['libor_tt']))) {echo "selected=\"selected\"";} ?>>Libor 30</option>
        <option value="60" <?php if (!(strcmp(60, $row_DetailRS1['libor_tt']))) {echo "selected=\"selected\"";} ?>>Libor 60</option>
        <option value="90" <?php if (!(strcmp(90, $row_DetailRS1['libor_tt']))) {echo "selected=\"selected\"";} ?>>Libor 90</option>
        <option value="120" <?php if (!(strcmp(120, $row_DetailRS1['libor_tt']))) {echo "selected=\"selected\"";} ?>>Libor 120</option>
        <option value="150" <?php if (!(strcmp(150, $row_DetailRS1['libor_tt']))) {echo "selected=\"selected\"";} ?>>Libor 150</option>
        <option value="180" <?php if (!(strcmp(180, $row_DetailRS1['libor_tt']))) {echo "selected=\"selected\"";} ?>>Libor 180</option>
        <option value="210" <?php if (!(strcmp(210, $row_DetailRS1['libor_tt']))) {echo "selected=\"selected\"";} ?>>Libor 210</option>
        <option value="240" <?php if (!(strcmp(240, $row_DetailRS1['libor_tt']))) {echo "selected=\"selected\"";} ?>>Libor 240</option>
        <option value="270" <?php if (!(strcmp(270, $row_DetailRS1['libor_tt']))) {echo "selected=\"selected\"";} ?>>Libor 270</option>
        <option value="300" <?php if (!(strcmp(300, $row_DetailRS1['libor_tt']))) {echo "selected=\"selected\"";} ?>>Libor 300</option>
        <option value="330" <?php if (!(strcmp(330, $row_DetailRS1['libor_tt']))) {echo "selected=\"selected\"";} ?>>Libor 330</option>
        <option value="360" <?php if (!(strcmp(360, $row_DetailRS1['libor_tt']))) {echo "selected=\"selected\"";} ?>>Libor 360</option>
        </select>
        <span class="rojopequeno">+</span>
        <input name="algo_tt" type="text" class="etiqueta12" id="algo_tt" value="<?php echo $row_DetailRS1['algo_tt']; ?>" size="10" maxlength="10">
        <span class="rojopequeno">= TT</span> <span class="respuestacolumna_azul">//</span>
        <select name="libor_tf" class="etiqueta12" id="libor_tf">
          <option value="N/A" selected <?php if (!(strcmp("N/A", $row_DetailRS1['libor_tf']))) {echo "selected=\"selected\"";} ?>>Libor a...</option>
          <option value="30" <?php if (!(strcmp(30, $row_DetailRS1['libor_tf']))) {echo "selected=\"selected\"";} ?>>Libor 30</option>
          <option value="60" <?php if (!(strcmp(60, $row_DetailRS1['libor_tf']))) {echo "selected=\"selected\"";} ?>>Libor 60</option>
          <option value="90" <?php if (!(strcmp(90, $row_DetailRS1['libor_tf']))) {echo "selected=\"selected\"";} ?>>Libor 90</option>
          <option value="120" <?php if (!(strcmp(120, $row_DetailRS1['libor_tf']))) {echo "selected=\"selected\"";} ?>>Libor 120</option>
          <option value="150" <?php if (!(strcmp(150, $row_DetailRS1['libor_tf']))) {echo "selected=\"selected\"";} ?>>Libor 150</option>
          <option value="180" <?php if (!(strcmp(180, $row_DetailRS1['libor_tf']))) {echo "selected=\"selected\"";} ?>>Libor 180</option>
          <option value="210" <?php if (!(strcmp(210, $row_DetailRS1['libor_tf']))) {echo "selected=\"selected\"";} ?>>Libor 210</option>
          <option value="240" <?php if (!(strcmp(240, $row_DetailRS1['libor_tf']))) {echo "selected=\"selected\"";} ?>>Libor 240</option>
          <option value="270" <?php if (!(strcmp(270, $row_DetailRS1['libor_tf']))) {echo "selected=\"selected\"";} ?>>Libor 270</option>
          <option value="300" <?php if (!(strcmp(300, $row_DetailRS1['libor_tf']))) {echo "selected=\"selected\"";} ?>>Libor 300</option>
          <option value="330" <?php if (!(strcmp(330, $row_DetailRS1['libor_tf']))) {echo "selected=\"selected\"";} ?>>Libor 330</option>
          <option value="360" <?php if (!(strcmp(360, $row_DetailRS1['libor_tf']))) {echo "selected=\"selected\"";} ?>>Libor 360</option>
        </select>
        <span class="rojopequeno">+</span>
        <input name="algo_tf" type="text" class="etiqueta12" id="algo_tf" value="<?php echo $row_DetailRS1['algo_tf']; ?>" size="10" maxlength="10">
      <span class="rojopequeno">= Tasa Final</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Tasa Fija:</td>
      <td colspan="3" align="left" valign="middle"></div>
        <span class="respuestacolumna_azul"><span class="respuestacolumna_rojo">TT</span></span><span id="sprytextfield3">
        <label>
          <input name="tt" type="text" class="etiqueta12" id="tt" value="<?php echo $row_DetailRS1['tt']; ?>" size="10" maxlength="10">
        </label>
        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span> <span class="respuestacolumna_rojo">SPREAD</span><span id="sprytextfield6">
        <input name="spread" type="text" class="etiqueta12" id="spread" value="<?php echo $row_DetailRS1['spread']; ?>" size="10" maxlength="10">
        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="respuestacolumna_rojo">TASA FINAL</span><span id="sprytextfield5">
        <input name="tasa_final" type="text" class="etiqueta12" id="tasa_final" value="<?php echo $row_DetailRS1['tasa_final']; ?>" size="10" maxlength="10">
        </span>        </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Urgente:</td>
      <td colspan="3" align="left" valign="middle">
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['urgente'],"Si"))) {echo "CHECKED";} ?> type="radio" name="urgente" value="Si">
          Si</label>
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['urgente'],"No"))) {echo "CHECKED";} ?> type="radio" name="urgente" value="No">
          No</label>
      </td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle">
        <input type="submit" class="boton" value="Reingresar Operaci&oacute;n">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="id">
  <input type="hidden" name="MM_insert" value="form1">
  <input type="hidden" name="date_espe" value="<?php echo date("Y-m-d H:i:s"); ?>" size="32">
  <input type="hidden" name="date_ingreso" value="<?php echo date("Y-m-d"); ?>" size="32">
  <input name="despacho_doctos" type="hidden" id="despacho_doctos" value="<?php echo $row_DetailRS1['despacho_doctos']; ?>">
  <input name="sucursal" type="hidden" id="sucursal" value="<?php echo $row_DetailRS1['sucursal']; ?>">
  <input name="segmento" type="hidden" id="segmento" value="<?php echo $row_DetailRS1['segmento']; ?>"> 
  <input name="estado_visacion" type="hidden" id="estado_visacion" value="Pendiente.">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="controlop.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
var spryradio1 = new Spry.Widget.ValidationRadio("spryradio1");
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>