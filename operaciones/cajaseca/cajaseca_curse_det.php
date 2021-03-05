<?php require_once('../../Connections/comercioexterior.php'); ?>
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
$query_DetailRS1 = sprintf("SELECT * FROM caja_seca nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE caja_seca SET moneda_operacion=%s, monto_operacion=%s, evento=%s, operador_caja=%s, date_operador_caja=%s, estado=%s WHERE id=%s",
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['operador_caja'], "text"),
                       GetSQLValueString($_POST['date_operador_caja'], "date"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));

  $updateGoTo = "cajaseca_curse_mae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Curse Instruccion Caja Seca - Detalle</title>
<style type="text/css">
<!--
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo41 {font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">CURSAR INSTRUCCIONES CAJA SECA - MAESTRO</td>
    <td width="7%" align="left" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
</table>
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><span class="Estilo41"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" />Curse Instrucción Detalle</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nro Registro:</td>
      <td align="center" valign="middle" class="nroregistro"><?php echo $row_DetailRS1['id']; ?></td>
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['rut_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="17" maxlength="15" />
        <span class="rojopequeno">Sin punto ni guión</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['nombre_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Moneda / Monto Operación:</td>
      <td align="center" valign="middle"><input name="moneda_operacion" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['moneda_operacion'], ENT_COMPAT, 'utf-8'); ?>" size="5" maxlength="3" /> 
        / 
        <input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['monto_operacion'], ENT_COMPAT, 'utf-8'); ?>" size="20" maxlength="20" /></td>
<td align="right" valign="middle">Evento:</td>
      <td align="center" valign="middle"><select name="evento" class="etiqueta12" id="evento">
        <option value="Abono en Cta Cte." selected="selected" <?php if (!(strcmp("Abono en Cta Cte.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Abono en Cta Cte</option>
        <option value="Cargo en Cta Cte." <?php if (!(strcmp("Cargo en Cta Cte.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Cargo en Cta Cte</option>
<option value="LBTR." <?php if (!(strcmp("LBTR.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>LBTR</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Operador:</td>
      <td align="center" valign="middle"><input name="operador" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['operador'], ENT_COMPAT, 'utf-8'); ?>" size="20" maxlength="20" /></td>
      <td align="right" valign="middle">Fecha y Hora Ingreso Operador:</td>
      <td align="center" valign="middle"><input name="date_operador" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['date_operador'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Operador Caja:</td>
      <td align="center" valign="middle"><input name="operador_caja" type="text" class="etiqueta12" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20" /></td>
      <td align="right" valign="middle">Estado:</td>
      <td align="center" valign="middle"><label>
        <select name="estado" class="etiqueta12" id="estado">
          <option value="Cursada." selected="selected">Cursada</option>
          <option value="Eliminada.">Eliminada</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle"><input type="submit" class="boton" value="Cambiar Estado" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>" />
  <input type="hidden" name="date_operador_caja" value="<?php echo date("Y-m-d H:i:s"); ?>" size="32" />
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="cajaseca_curse_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>