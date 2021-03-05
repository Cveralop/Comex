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

$colname_control_excepcion = "Pendiente.";
if (isset($_GET['estado_excepcion'])) {
  $colname_control_excepcion = $_GET['estado_excepcion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_control_excepcion = sprintf("SELECT * FROM excepciones nolock WHERE estado_excepcion = %s ", GetSQLValueString($colname_control_excepcion, "text"));
$control_excepcion = mysql_query($query_control_excepcion, $comercioexterior) or die(mysqli_error());
$row_control_excepcion = mysqli_fetch_assoc($control_excepcion);
$totalRows_control_excepcion = mysqli_num_rows($control_excepcion);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Control Excepciones</title>
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
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">CONTROL EXCEPCIONES  - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">EXCEPCIONES</td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="excepciones.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen2','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen2" width="80" height="25" border="0" id="Imagen2" /></a></td>
  </tr>
</table>
<br />
<span class="respuestacolumna_azul"><?php echo $totalRows_control_excepcion ?></span> Registros Total <br />
<br />
<table border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Territorial</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha ingreso</td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Producto</td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
    <td align="center" valign="middle" class="titulocolumnas">Visador</td>
    <td align="center" valign="middle" class="titulocolumnas">Autorizacion Operaciones</td>
    <td align="center" valign="middle" class="titulocolumnas">Autorizacion Especialista</td>
    <td align="center" valign="middle" class="titulocolumnas">Esponsable Excepcion</td>
    <td align="center" valign="middle" class="titulocolumnas">Tipo Excepcion</td>
    <td align="center" valign="middle" class="titulocolumnas">Vcto Excepcion</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_control_excepcion['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_control_excepcion['nombre_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_control_excepcion['territorial']; ?></td>
      <td align="center" valign="middle"><?php echo $row_control_excepcion['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_control_excepcion['evento']; ?></td>
      <td align="left" valign="middle"><?php echo $row_control_excepcion['producto']; ?></td>
      <td align="center" valign="middle"><?php echo $row_control_excepcion['nro_operacion']; ?></td>
      <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_control_excepcion['moneda_operacion']; ?></span>&nbsp; <span class="respuestacolumna_azul"><?php echo number_format($row_control_excepcion['monto_operacion'], 2, ',', '.'); ?></span></td>
      <td align="center" valign="middle"><?php echo $row_control_excepcion['visador']; ?></td>
      <td align="left" valign="middle"><?php echo $row_control_excepcion['autorizacion_operaciones']; ?></td>
      <td align="left" valign="middle"><?php echo $row_control_excepcion['autorizacion_especialista']; ?></td>
      <td align="left" valign="middle"><?php echo $row_control_excepcion['responsable_excepcion']; ?></td>
      <td align="left" valign="middle"><?php echo $row_control_excepcion['tipo_excepcion']; ?></td>
      <td align="center" valign="middle"><?php echo $row_control_excepcion['vcto_excepcion']; ?></td>
    </tr>
    <?php } while ($row_control_excepcion = mysqli_fetch_assoc($control_excepcion)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($control_excepcion);
?>