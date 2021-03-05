<?php require_once('../../../../Connections/comercioexterior.php'); ?>
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
$query_DetailRS1 = sprintf("SELECT * FROM pago_automatico nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pago_automatico SET ctemn=%s, ctemx=%s, nro_operacion=%s, operador_modifi=%s, date_modifi=%s WHERE id=%s",
                       GetSQLValueString($_POST['ctemn'], "text"),
                       GetSQLValueString($_POST['ctemx'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['operador_modifi'], "text"),
                       GetSQLValueString($_POST['date_modifi'], "date"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "mod_pago_auto_mae.php";
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
<title>Modificar Pago Automatico - Detalle</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
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
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body onload="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">MODIFICAR PAGO AUTOMATICO - DETALLE</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">PRESTAMOS</td>
  </tr>
</table>
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" bgcolor="#999999"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulocolumnas">Detalle Modificacion Pago Automatico</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" bgcolor="#CCCCCC">Nro Registro:</td>
      <td colspan="3" align="left" bgcolor="#CCCCCC" class="nroregistro"><?php echo $row_DetailRS1['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td align="right" bgcolor="#CCCCCC">Rut Cliente:</td>
      <td align="center" bgcolor="#CCCCCC"><input name="rut_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['rut_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="16" maxlength="16" />
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
      <td align="right" bgcolor="#CCCCCC">Nro Operación:</td>
      <td align="center" bgcolor="#CCCCCC"><input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['nro_operacion'], ENT_COMPAT, 'utf-8'); ?>" size="10" maxlength="7" />
        <span class="rojopequeno">F000000</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" bgcolor="#CCCCCC">Nombre Cliente:</td>
      <td colspan="3" align="left" bgcolor="#CCCCCC"><input name="nombre_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['nombre_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" bgcolor="#CCCCCC">Cta Cte M/N:</td>
      <td align="center" bgcolor="#CCCCCC"><input name="ctemn" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['ctemn'], ENT_COMPAT, 'utf-8'); ?>" size="25" maxlength="20" /></td>
      <td align="right" bgcolor="#CCCCCC">Cta Cte M/X:</td>
      <td align="center" bgcolor="#CCCCCC"><input name="ctemx" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['ctemx'], ENT_COMPAT, 'utf-8'); ?>" size="25" maxlength="20" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" bgcolor="#CCCCCC">Pago Automatico:</td>
      <td colspan="3" align="left" valign="middle" bgcolor="#CCCCCC"><select name="pago_automatico" class="etiqueta12" id="pago_automatico">
        <option value="Si" <?php if (!(strcmp("Si", $row_DetailRS1['pago_automatico']))) {echo "selected=\"selected\"";} ?>>Habilitado</option>
        <option value="No" <?php if (!(strcmp("No", $row_DetailRS1['pago_automatico']))) {echo "selected=\"selected\"";} ?>>Desabilitado</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" bgcolor="#CCCCCC"><input type="submit" class="boton" value="Actualizar Pago Automatico" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>" />
  <input type="hidden" name="operador_modifi" value="<?php echo $_SESSION['login'];?>" size="32" />
  <input type="hidden" name="date_modifi" value="<?php echo date("Y-m-d H:i:s"); ?>" size="32" />
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="mod_pago_auto_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>