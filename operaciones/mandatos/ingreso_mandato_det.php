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
$query_DetailRS1 = sprintf("SELECT * FROM cliente nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE cliente SET tipo_mandato=%s, ing_operador=%s, fecha_ingreso=%s, visador=%s, fecha_visacion=%s, estado_mandato=%s, contacto1=%s, contacto2=%s, nombre_e1=%s, email1=%s, nombre_e2=%s, email2=%s, nombre_e3=%s, email3=%s, nombre_e4=%s, email4=%s, nombre_e5=%s, email5=%s WHERE id=%s",
                       GetSQLValueString($_POST['tipo_mandato'], "text"),
                       GetSQLValueString($_POST['ing_operador'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "date"),
                       GetSQLValueString($_POST['visador'], "text"),
                       GetSQLValueString($_POST['fecha_visacion'], "date"),
                       GetSQLValueString($_POST['estado_mandato'], "text"),
                       GetSQLValueString($_POST['contacto1'], "text"),
                       GetSQLValueString($_POST['contacto2'], "text"),
                       GetSQLValueString($_POST['nombre_e1'], "text"),
                       GetSQLValueString($_POST['email1'], "text"),
                       GetSQLValueString($_POST['nombre_e2'], "text"),
                       GetSQLValueString($_POST['email2'], "text"),
                       GetSQLValueString($_POST['nombre_e3'], "text"),
                       GetSQLValueString($_POST['email3'], "text"),
                       GetSQLValueString($_POST['nombre_e4'], "text"),
                       GetSQLValueString($_POST['email4'], "text"),
                       GetSQLValueString($_POST['nombre_e5'], "text"),
                       GetSQLValueString($_POST['email5'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "ingreso_mandato_mae.php";
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
<title>Ingreso Mandato - Detalle</title>
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
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESOS MANDATOS - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">COMERCIO EXTERIOR OPERACIONES</td>
  </tr>
</table>
<br />
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulo_menu">Detalle Ingreso Mandatos</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="16" maxlength="16" readonly="readonly" />
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
      <td align="right" valign="middle">Estado:</td>
      <td align="center" valign="middle">
        <label>
<input name="estado_mandato" type="radio" class="etiqueta12" id="estado_0" value="Mandato OK" checked="checked" />
          Visado</label>
        <label>
          <input name="estado_mandato" type="radio" class="etiqueta12" id="estado_1" value="Reparado" />
          Reparado</label>
        <br />
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="120" maxlength="120" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Especialista NI:</td>
      <td align="center" valign="middle"><input name="especialista" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista']; ?>" size="50" maxlength="50" /></td>
      <td align="right" valign="middle">Tipo Mandato:</td>
      <td align="center" valign="middle">
        <label>
          <input name="tipo_mandato" type="radio" class="etiqueta12" id="tipo_mandato_0" value="N" checked="checked" />
          Formato Nuevo</label>
        <label>
          <input name="tipo_mandato" type="radio" class="etiqueta12" id="tipo_mandato_1" value="A" />
          Formato Antiguo</label>
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Ingresado Por:</td>
      <td align="center" valign="middle"><input name="ing_operador" type="text" class="etiqueta12" value="<?php echo $_SESSION['login']; ?>" size="12" maxlength="10" readonly="readonly" /></td>
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="center" valign="middle"><input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Visador:</td>
      <td align="center" valign="middle"><input name="visador" type="text" class="etiqueta12" value="<?php echo $_SESSION['login']; ?>" size="12" maxlength="10" readonly="readonly" /></td>
      <td align="right" valign="middle">Fecha Visacion:</td>
      <td align="center" valign="middle"><input name="fecha_visacion" type="text" class="etiqueta12" value="<?php echo date("Y-m-d H:i:s"); ?>" size="22" maxlength="50" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Contacto1:</td>
      <td colspan="3" align="left" valign="middle"><input name="contacto1" type="text" class="etiqueta12" id="contacto1" value="<?php echo $row_DetailRS1['contacto1']; ?>" size="100" maxlength="100" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Contacto2:</td>
      <td colspan="3" align="left" valign="middle"><input name="contacto2" type="text" class="etiqueta12" id="contacto2" value="<?php echo $row_DetailRS1['contacto2']; ?>" size="100" maxlength="100" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><span class="titulo_menu">Personas Auotorizadas a enviar instrucciones por E-Mail</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre 1:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_e1" type="text" class="etiqueta12" id="nombre_e1" value="<?php echo $row_DetailRS1['nombre_e1']; ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Email 1:</td>
      <td colspan="3" align="left" valign="middle"><input name="email1" type="text" class="etiqueta12" id="email1" value="<?php echo $row_DetailRS1['email1']; ?>" size="50" maxlength="50" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre 2:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_e2" type="text" class="etiqueta12" id="nombre_e2" value="<?php echo $row_DetailRS1['nombre_e2']; ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Email 2:</td>
      <td colspan="3" align="left" valign="middle"><input name="email2" type="text" class="etiqueta12" id="email2" value="<?php echo $row_DetailRS1['email2']; ?>" size="50" maxlength="50" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre 3:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_e3" type="text" class="etiqueta12" id="nombre_e3" value="<?php echo $row_DetailRS1['nombre_e3']; ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Email 3:</td>
      <td colspan="3" align="left" valign="middle"><input name="email3" type="text" class="etiqueta12" id="email3" value="<?php echo $row_DetailRS1['email3']; ?>" size="50" maxlength="50" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre 4:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_e4" type="text" class="etiqueta12" id="nombre_e4" value="<?php echo $row_DetailRS1['nombre_e4']; ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Emai 4:</td>
      <td colspan="3" align="left" valign="middle"><input name="email4" type="text" class="etiqueta12" id="email4" value="<?php echo $row_DetailRS1['email4']; ?>" size="50" maxlength="50" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre 5:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_e5" type="text" class="etiqueta12" id="nombre_e5" value="<?php echo $row_DetailRS1['nombre_e5']; ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Email 5:</td>
<td colspan="3" align="left" valign="middle"><input name="email5" type="text" class="etiqueta12" id="email5" value="<?php echo $row_DetailRS1['email5']; ?>" size="50" maxlength="50" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle"><input type="submit" class="boton" value="Insertar registro" /></td>
    </tr>
  </table>
  <input name="MM_update" type="hidden" id="MM_update" value="form1" size="32" />
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="ingreso_mandato_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>