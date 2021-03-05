<?php require_once('../../../../Connections/comercioexterior.php'); ?>
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
  $updateSQL = sprintf("UPDATE oppre SET nro_operacion=%s, moneda_operacion=%s, monto_operacion=%s, pagare=%s, tipo_operacion=%s WHERE id=%s",
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['pagare'], "text"),
                       GetSQLValueString($_POST['tipo_operacion'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "pagaremantemae.php";
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
<title>Mantencion Pagare Env&iacute;o a Custodia - Detalle</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo8 {
	font-size: 14px;
	color: #FF0000;
	font-weight: bold;
}
.Estilo9 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">MANTENCION PAGARE ENVIO A CUSTODIA - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="4" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo9">Detalle Operaci&oacute;n con Tasa Variable </span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro de Registro: </td>
      <td align="center"><span class="Estilo8"><?php echo $row_DetailRS1['id']; ?></span></div></td>
      <td align="right">Rut Cliente:</div></td>
      <td align="center">
        <input name="rut_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15">
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nombre Cliente:</td>
      <td colspan="3" align="left"><input name="nombre_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Fecha Curse:</td>
      <td align="center">
        <input name="fecha_curse" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_curse']; ?>" size="12" maxlength="10"> 
      <span class="rojopequeno">(dd-mm-aaaa)</span></div></td>
      <td align="right">Nro Operaci&oacute;n:</div></td>
      <td align="center">
        <input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="15" maxlength="7">
      <span class="rojopequeno">F-L 000000</span> </div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Moneda / <br>
      Monto Operaci&oacute;n:</td>
      <td align="center"><select name="moneda_operacion" class="etiqueta12" id="moneda_operacion">
        <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>DKK</option>
        <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>NOK</option>
        <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>SEK</option>
        <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>USD</option>
<option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>CAD</option>
        <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>AUD</option>
        <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>HKD</option>
        <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>EUR</option>
        <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>CHF</option>
        <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>GBP</option>
<option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>ZAR</option>
        <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>JPY</option>
        <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>CLP</option>
      </select>
        <span class="rojopequeno">/</span>        
          <input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="17" maxlength="15">
      </div></td>
      <td align="right">Pagar&eacute;:</td>
      <td align="center"><select name="pagare" class="etiqueta12" id="pagare">
        <option selected value="N/A" <?php if (!(strcmp("N/A", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>No Aplica</option>
        <option value="Anexo." <?php if (!(strcmp("Anexo.", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>Anexo</option>
        <option value="Escritura." <?php if (!(strcmp("Escritura.", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>Escritura</option>
        <option value="Pagare." <?php if (!(strcmp("Pagare.", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>Pagare</option>
        <option value="Pagare Convenio." <?php if (!(strcmp("Pagare Convenio.", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>Pagare Convenio</option>
        <option value="Segun Check List." <?php if (!(strcmp("Segun Check List.", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>Segun Check List</option>
        <option value="Sucursal." <?php if (!(strcmp("Sucursal.", $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>>Sucursal</option>
        <?php
do {  
?>
        <option value="<?php echo $row_DetailRS1['id']?>"<?php if (!(strcmp($row_DetailRS1['id'], $row_DetailRS1['pagare']))) {echo "selected=\"selected\"";} ?>><?php echo $row_DetailRS1['id']?></option>
        <?php
} while ($row_DetailRS1 = mysqli_fetch_assoc($DetailRS1));
  $rows = mysqli_num_rows($DetailRS1);
  if($rows > 0) {
      mysqli_data_seek($DetailRS1, 0);
	  $row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
  }
?>
      </select>        </div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Tipo Operaci&oacute;n:</td>
      <td colspan="3" align="left"><select name="tipo_operacion" class="etiqueta12" id="tipo_operacion">
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
        <option value="Cartera Vencida." <?php if (!(strcmp("Cartera Vencida.", $row_DetailRS1['tipo_operacion']))) {echo "selected=\"selected\"";} ?>>Cartera Vencida</option>
      </select></td>
    </tr>
    <tr align="center" valign="middle">
      <td colspan="4">
        <input type="submit" class="boton" value="Mantenci&oacute;n Pagar&eacute; Custodia">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../tasa_variable/tasavariablemae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>