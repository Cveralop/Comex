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

$colname_DetailRS1 = "1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opcce nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO opcdpa (id, rut_cliente, nombre_cliente, fecha_ingreso, date_ingreso, evento, asignador, operador, nro_operacion_relacionada, obs, especialista, moneda_operacion, monto_operacion, sucursal, date_asig, tipo_operacion) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['date_ingreso'], "date"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['asignador'], "text"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['especialista'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['sucursal'], "text"),
                       GetSQLValueString($_POST['date_asig'], "date"),
                       GetSQLValueString($_POST['tipo_operacion'], "text"));
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
<title>Ingreso Solicitud - Detalle</title>
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
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO SOLICITUD - DETALLE </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CESI&Oacute;N DE DERECHO Y PAGO ANTICIPADO</td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" onSubmit="MM_validateForm('fecha_ingreso','','R','asignador','','R','monto_operacion','','RisNum');return document.MM_returnValue">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline" bgcolor="#999999">
      <td colspan="4" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Ingreso Solicitud </span></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle">
        <input name="rut_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15"> 
          <span class="rojopequeno">Sin puntos ni Guion</span> </div></td>
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="center" valign="middle">
        <input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10"> 
      <span class="rojopequeno">(dd-mm-aaaa)</span> </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Evento:</td>
      <td align="center" valign="middle">        
          <select name="evento" class="etiqueta12" id="evento">
            <option value="Solicitud.">Solicitud</option>
          </select>
        </div></td>
      <td align="right" valign="middle">Asignador:</div></td>
      <td align="center" valign="middle">
        <input name="asignador" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20">
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Operador:</td>
      <td align="center" valign="middle"><select name="operador" class="etiqueta12" id="operador">
        <option value="CURRUTP">Claudia Urritia Padilla</option>
        <option value="EROBLES">Elizabeth Robles Novoa</option>
        <option value="EVALENZU">Eliza Valenzuela</option>
        <option value="HURIBEC">Hernan Uribe Campos</option>
        <option value="JMALDON">Jaime Maldonado Cerda</option>
        <option value="LCELISD">Luis Celis de MArini</option>
        <option value="PMOSCOA">Pamela Moscoso</option>
        <option value="PGODOY">Patricia Godoy Chavez</option>
        <option value="MTOROB">Veronica Toro</option>
        <option value="MPARRA">Marisel Parra Parra</option>
        <option value="MPALACIO">Manuel Palacios Gutierrez</option>
        <option value="JSANTIBA">Jose Santiba�ez Pe�a</option>        
        <option value="FMABELP">Francisca Mabel Perez</option>
        <option value="XMAGANA">Ximena Maga�a Gonzalez</option>
        <option value="YPARRA">Yanadet Parra Trincado</option>
        <option value="JROMAN">Juan Roman Diaz</option>
        <option value="PCCI1">Practica CCI 1</option>
        <option value="PCCI2">Practica CCI 2</option>
        <option value="PCCI3">Practiva CCI 3</option>
      </select>        </div></td>
      <td align="right" valign="middle">Especialista:</div></td>
      <td align="center" valign="middle">
        <input name="especialista" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista']; ?>" size="20" maxlength="20">
      </div></td>
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
      <td align="center" valign="middle">
          <select name="moneda_operacion" class="etiqueta12" id="moneda_operacion">
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
            <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>CLP</option>
          </select> 
          <span class="rojopequeno">/</span>        
          <input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="17" maxlength="15">
      </div></td>
      <td align="right" valign="middle">Tipo Operaci&oacute;n:</td>
      <td align="center" valign="middle">        
        <select name="tipo_operacion" class="etiqueta12" id="tipo_operacion">
          <option value="Cesion de Derecho." selected>Cesion de Derecho</option>
          </select>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle">
        <input type="submit" class="boton" value="Ingresar Operaci&oacute;n">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="id">
  <input type="hidden" name="MM_insert" value="form1">
  <input type="hidden" name="date_ingreso" value="<?php echo date("Y-m-d"); ?>" size="32">
  <input type="hidden" name="date_asig" value="<?php echo date("Y-m-d H:i:s"); ?>" size="32">
  <input name="rut_cliente" type="hidden" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15">
  <input name="nombre_cliente" type="hidden" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120">
  <input name="asignador" type="hidden" class="etiqueta12" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20">
  <input name="sucursal" type="hidden" id="sucursal" value="<?php echo $row_DetailRS1['sucursal']; ?>">
  <input name="nro_operacion" type="hidden" id="nro_operacion" value="<?php echo $row_DetailRS1['nro_operacion']; ?>">
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
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>