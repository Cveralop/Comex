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

$colname_DetailRS1 = "Cursada.";
if (isset($_GET['estado_visacion'])) {
  $colname_DetailRS1 = $_GET['estado_visacion'];
}
$colname1_DetailRS1 = "zzzxxx";
if (isset($_GET['rut_cliente'])) {
  $colname1_DetailRS1 = $_GET['rut_cliente'];
}
$colname2_DetailRS1 = "Apertura.";
if (isset($_GET['evento'])) {
  $colname2_DetailRS1 = $_GET['evento'];
}
$colname5_DetailRS1 = "xxxzzz";
if (isset($_GET['nro_operacion'])) {
  $colname5_DetailRS1 = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM oppre WHERE estado_visacion = %s and rut_cliente LIKE %s and evento = %s and nro_operacion LIKE %s ORDER BY id DESC", GetSQLValueString($colname_DetailRS1, "text"),GetSQLValueString("%" . $colname1_DetailRS1 . "%", "text"),GetSQLValueString($colname2_DetailRS1, "text"),GetSQLValueString($colname5_DetailRS1 . "%", "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores nolock";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Envio OP MECO - Maestro</title>
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
	color: #FF0000;
	font-weight: bold;
}
.Estilo12 {color: #FFFFFF; font-weight: bold; }
.Estilo13 {font-size: 12px}
.Estilo15 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo16 {color: #00FF00}
</style>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
</head>
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">ENVIO OP MECO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">PRESTAMOS</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><span class="Estilo12"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></span><span class="Estilo15">Buscar Operacion</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="left" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15">
      <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Nro Operaci&oacute;n:</td>
      <td width="79%" align="left" valign="middle"><span class="rojopequeno">
        <input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7">
        F000000 - L000000 y/o K000000</span></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar"></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../prestamos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<table width="95%" border="0" align="center">
<tr>  </tr>
</table>
<?php if ($totalRows_DetailRS1 > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="8" align="left" valign="middle"><span class="Estilo12"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"> <span class="Estilo13">Operaciones para Visaci&oacute;n</span></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="Estilo12"><span class="titulocolumnas">Visar</span></td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Visaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Evento </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>
    </td>
    </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><a href="envioopdet.php?recordID=<?php echo $row_DetailRS1['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></td>
    <td align="center" valign="middle" class="rojopequeno"><?php echo $row_DetailRS1['id']; ?></td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_DetailRS1['nro_operacion']; ?></td>
<td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?></td>
    <td align="left" valign="middle">
      <?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['date_visa']; ?>      </div></td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['evento']; ?></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_DetailRS1['moneda_operacion']); ?></span>&nbsp; <strong class="respuestacolumna_azul"><?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    </tr>
  <?php } while ($row_DetailRS1 = mysqli_fetch_assoc($DetailRS1)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
mysqli_free_result($colores);
?>