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
$query_DetailRS1 = sprintf("SELECT * FROM oppre nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE oppre SET evento=%s, operador=%s, nro_operacion=%s, nro_operacion_relacionada=%s, obs=%s, moneda_operacion=%s, monto_operacion=%s, nro_cuotas=%s, tipo_operacion=%s, urgente=%s, fuera_horario=%s WHERE id=%s",
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['nro_operacion_relacionada'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['nro_cuotas'], "int"),
                       GetSQLValueString($_POST['tipo_operacion'], "text"),
                       GetSQLValueString($_POST['urgente'], "text"),
                       GetSQLValueString($_POST['fuera_horario'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "modmae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Modificar Prestamos - Detalle</title>
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
.Estilo6 {
	font-size: 16px;
	color: #FF0000;
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
  <tr valign="middle">
    <td align="left" class="Estilo3">MODIFICAR PR&Eacute;STAMOS  - DETALLE</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" onSubmit="MM_validateForm('monto_operacion','','RisNum');return document.MM_returnValue">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="4" align="left"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Modificar Pr&eacute;stamo</span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Registro:</td>
      <td align="center"><span class="nroregistro"><?php echo $row_DetailRS1['id']; ?></span>        </div></td>
      <td align="right">Rut Cliente:</td>
      <td align="center">
        <input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15" readonly>
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nombre Cliente:</td>
      <td colspan="3" align="left"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120" readonly></td>
    </tr>
    <tr valign="middle">
      <td align="right">Fecha Ingreso:</td>
      <td align="center"><input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_ingreso']; ?>" size="12" maxlength="10" readonly>
      <span class="rojopequeno">(dd-mm-aaaa)</span> </td>
      <td align="right">Fecha Curse:</td>
      <td align="center">
          <input name="fecha_curse" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_curse']; ?>" size="12" maxlength="10" readonly>
      <span class="rojopequeno">(dd-mm-aaaa)</span> </div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Evento:</td>
      <td align="center"><select name="evento" class="etiqueta12" id="evento">
        <option value="Apertura." <?php if (!(strcmp("Apertura.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Apertura</option>
        <option value="Prorroga." <?php if (!(strcmp("Prorroga.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Prorroga</option>
        <option value="Prorroga y Pago." <?php if (!(strcmp("Prorroga y Pago.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Prorroga y Pago</option>
        <option value="Cambio Tasa." <?php if (!(strcmp("Cambio Tasa.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Cambio Tasa</option>
        <option value="Pago." <?php if (!(strcmp("Pago.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pago</option>
        <option value="Visacion." <?php if (!(strcmp("Visacion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Visacion (DI)</option>
        <option value="Cartera Vencida." <?php if (!(strcmp("Cartera Vencida.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Cartera Vencida</option>
        <option value="Carta Original." <?php if (!(strcmp("Carta Original.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Carta Original</option>
        <option value="Requerimiento." <?php if (!(strcmp("Requerimiento.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Requerimiento</option>
        <option value="Solucion Excepcion." <?php if (!(strcmp("Solucion Excepcion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Solucion Excepcion</option>
        <option value="Dev Comisiones." <?php if (!(strcmp("Dev Comisiones.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Dev Comisiones</option>
        <option value="Aviso Cuotas." <?php if (!(strcmp("Aviso Cuotas.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Aviso Cuotas</option>
        <option value="Tecnica." <?php if (!(strcmp("Tecnica.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Tecnica</option>
        <option value="Mandato PAC." <?php if (!(strcmp("Mandato PAC.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Mandato PAC</option>
        <option value="Restructuracion." <?php if (!(strcmp("Restructuracion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Restructuracion</option>
        <option value="Redenominacion." <?php if (!(strcmp("Redenominacion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Redenominacion</option>
        <option value="Aviso Cuota Aper." <?php if (!(strcmp("Aviso Cuota Aper.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Aviso Aper. Cuotas</option>
      </select>        </div></td>
      <td align="right">Estado:</div></td>
      <td align="center">
        <input name="estado" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['estado']; ?>" size="20" maxlength="20" readonly>
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Asignador:</td>
      <td align="center">
        <input name="asignador" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['asignador']; ?>" size="20" maxlength="20" readonly>
      </div></td>
      <td align="right">Operador:</div></td>
      <td align="center"></div>
        <select name="operador" class="etiqueta12" id="operador">
          <option value="0" selected <?php if (!(strcmp(0, $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Seleccion un Operador</option>
          <option value="MTOROB" <?php if (!(strcmp("MTOROB", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Veronica Toro</option>
          <option value="SCHAVEZ" <?php if (!(strcmp("SCHAVEZ", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Sebastian Chavez Vasquez</option>
          <option value="FFARINAS" <?php if (!(strcmp("FFARINAS", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Francisco Farinas</option>
          <option value="CLEYTON" <?php if (!(strcmp("CLEYTON", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Carlos Leyton Gatica</option>
          <option value="FMUNOZ" <?php if (!(strcmp("FMUNOZ", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Felipe Munoz Perez</option>
          <option value="KAGUIRRE" <?php if (!(strcmp("KAGUIRRE", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Katherine Aguirre</option>
          <option value="CZAMBRAN" <?php if (!(strcmp("CZAMBRAN", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Cynthia Zambrano Leiva</option>
          <option value="JCASTILL" <?php if (!(strcmp("JCASTILL", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Javiera Castillo Mena</option>
          <option value="IVARGAS" <?php if (!(strcmp("IVARGAS", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Ives Vargas Perez</option>
          <option value="IIBACET" <?php if (!(strcmp("IIBACET", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Ingrid Ibaceta Vidal</option>
          <option value="PPRE1" <?php if (!(strcmp("PPRE1", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Practica PRE 1</option>
          <option value="PPRE2" <?php if (!(strcmp("PPRE2", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Practica PRE 2</option>
          <option value="PPRE3" <?php if (!(strcmp("PPRE3", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Practica PRE 3</option>
          <option value="ROBOT1" <?php if (!(strcmp("ROBOT1", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Robot 1</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Operaci&oacute;n:</td>
      <td align="center"><input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="17" maxlength="7"> 
      <span class="rojopequeno">F &oacute; K000000 </span><span class="etiqueta12">/
<input name="nro_operacion_relacionada" type="text" class="etiqueta12" id="nro_operacion_relacionada" value="<?php echo $row_DetailRS1['nro_operacion_relacionada']; ?>" size="17" maxlength="7">
      </span><span class="rojopequeno">      L000000</span></td>
      <td align="right">Espacialista:</div></td>
      <td align="center"><input name="especialista" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista_curse']; ?>" size="32" readonly></td>
    </tr>
    <tr valign="middle">
      <td align="right">Observaci&oacute;n:</td>
      <td colspan="3" align="left"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
      <span class="rojopequeno"><span id="countsprytextarea1">&nbsp;</span></span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Moneda / <br>
      Monto Operaci&oacute;n:</td>
      <td align="center">
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
      <td align="right">Tipo Operacin:</div></td>
      <td align="center"><select name="tipo_operacion" class="etiqueta12" id="tipo_operacion">
        <option value="Confirming." <?php if (!(strcmp("Confirming.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Confirming</option>
        <option value="Forfaiting." <?php if (!(strcmp("Forfaiting.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Forfaiting</option>
        <option value="PAE." <?php if (!(strcmp("PAE.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>PAE</option>
        <option value="PAE Cobex." <?php if (!(strcmp("PAE Cobex.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>PAE Cobex</option>
        <option value="PAE SGR." <?php if (!(strcmp("PAE SGR.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>PAE SGR</option>
        <option value="Finan. Contado." <?php if (!(strcmp("Finan. Contado.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Finan. Contado</option>
        <option value="Finan. Contado COBEX." <?php if (!(strcmp("Finan. Contado COBEX.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Finan. Contado COBEX</option>
        <option value="Finan. Contado SGR." <?php if (!(strcmp("Finan. Contado SGR.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Finan. Contado SGR</option>
        <option value="Credito Comercial." <?php if (!(strcmp("Credito Comercial.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Credito Comercial</option>
        <option value="Credito Comercial COBEX." <?php if (!(strcmp("Credito Comercial COBEX.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Credito Comercial COBEX</option>
        <option value="Credito Comercial SGR." <?php if (!(strcmp("Credito Comercial SGR.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Credito Comercial SGR</option>
        <option value="Prestamo LCI." <?php if (!(strcmp("Prestamo LCI.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Prestamo LCI</option>
      </select>        &nbsp;</td>
    </tr>
    <tr valign="middle">
      <td align="right">Fuera de Horario:</td>
      <td align="center"><select name="fuera_horario" class="etiqueta12" id="fuera_horario">
        <option value="Si" <?php if (!(strcmp("Si", $row_DetailRS1['fuera_horario']))) {echo "selected=\"selected\"";} ?>>Si</option>
        <option value="No" <?php if (!(strcmp("No", $row_DetailRS1['fuera_horario']))) {echo "selected=\"selected\"";} ?>>No</option>
      </select></td>
      <td align="right">Urgente:</td>
      <td align="center"></div>
        <select name="urgente" class="etiqueta12" id="urgente">
          <option value="Si" <?php if (!(strcmp("Si", $row_DetailRS1['urgente']))) {echo "selected=\"selected\"";} ?>>Si</option>
          <option value="No" <?php if (!(strcmp("No", $row_DetailRS1['urgente']))) {echo "selected=\"selected\"";} ?>>No</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Cuotas:</td>
      <td colspan="3" align="left">
        <input name="nro_cuotas" type="text" class="etiqueta12" id="nro_cuotas" value="<?php echo $row_DetailRS1['nro_cuotas']; ?>" size="5" maxlength="3">
      </td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="center">
        <input type="submit" class="boton" value="Actualizar Operaci&oacute;n">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../prestamos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
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