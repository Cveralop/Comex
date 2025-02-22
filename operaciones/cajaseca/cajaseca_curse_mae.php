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

$colname_altacajaseca = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname_altacajaseca = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_altacajaseca = sprintf("SELECT * FROM caja_seca nolock WHERE estado = %s", GetSQLValueString($colname_altacajaseca, "text"));
$altacajaseca = mysqli_query($comercioexterior, $query_altacajaseca) or die(mysqli_error());
$row_altacajaseca = mysqli_fetch_assoc($altacajaseca);
$totalRows_altacajaseca = mysqli_num_rows($altacajaseca);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Curse Instruccion Caja Seca - Maestro</title>
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

</style>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo41 {font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}

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
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="8" align="left" valign="middle" class="titulocolumnas"><span class="Estilo41"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" />Hay </span><span class="tituloverde"><?php echo $totalRows_altacajaseca ?></span><span class="Estilo41"> pendientes para cursar</span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Nro de Registro</td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso Operador</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><a href="cajaseca_curse_det.php?recordID=<?php echo $row_altacajaseca['id']; ?>"><img src="../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" /></a></td>
      <td align="center" valign="middle"><?php echo $row_altacajaseca['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_altacajaseca['nombre_cliente']; ?></td>
      <td align="right" valign="middle"><span class="rojopequeno"><?php echo $row_altacajaseca['moneda_operacion']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_altacajaseca['monto_operacion'], 2, ',', '.'); ?></span></td>
      <td align="center" valign="middle"><?php echo $row_altacajaseca['evento']; ?></td>
      <td align="center" valign="middle"><?php echo $row_altacajaseca['operador']; ?></td>
      <td align="center" valign="middle"><?php echo $row_altacajaseca['date_operador']; ?></td>
      <td align="center" valign="middle" class="Amarillo2"><?php echo $row_altacajaseca['estado']; ?></td>
    </tr>
    <?php } while ($row_altacajaseca = mysqli_fetch_assoc($altacajaseca)); ?>
</table>
<br />
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="cajaseca.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen4','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen4" width="80" height="25" border="0" id="Imagen4" /></a></td>
  </tr>
</table>
<br />
<br />
<br />
</body>
</html>
<?php
mysqli_free_result($altacajaseca);
?>
