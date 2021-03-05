<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
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

$colname_bei = "-1";
if (isset($_GET['date_ingreso'])) {
  $colname_bei = $_GET['date_ingreso'];
}
$colname2_bei = "ESP";
if (isset($_GET['perfil'])) {
  $colname2_bei = $_GET['perfil'];
}
$colname3_bei = "TER";
if (isset($_GET['perfil'])) {
  $colname3_bei = $_GET['perfil'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_bei = sprintf("SELECT *,sum(cantidad_ingresadas)as oping, sum(cantidad_pendientes)as oppen, sum(cantidad_reparadas_esp)as opesp, sum(cantidad_reparadas_ope)as opope, sum(cantidad_cursadas)as opcur, sum(cantidad_urgentes)as opurg, sum(cantidad_fuerahora)as opfho FROM estadistica_postventa nolock WHERE date_ingreso = %s and (perfil = %s or perfil = %s) GROUP BY especialista_curse ORDER BY sum(cantidad_ingresadas) DESC", GetSQLValueString($colname_bei, "date"),GetSQLValueString($colname2_bei, "text"),GetSQLValueString($colname3_bei, "text"));
$bei = mysqli_query($comercioexterior, $query_bei) or die(mysqli_error());
$row_bei = mysqli_fetch_assoc($bei);
$totalRows_bei = mysqli_num_rows($bei);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Operaciones Post Venta - Detalle</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #000;
	font-weight: bold;
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
<style type="text/css">
<!--
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
}
-->
</style>
</head>
<body onload="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="operaciones_postventa_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen4','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen4" width="80" height="25" border="0" id="Imagen4" /></a></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td colspan="2" align="center" valign="middle" bgcolor="#FF0000" class="titulopaguina"> OPERACIONES ENVIADAS POR POST VENTA</td>
  </tr>
  <tr>
    <td width="16%" align="right" valign="middle">Fecha Informe:</td>
    <td width="84%" align="left" valign="middle"><?php echo $row_bei['date_ingreso']; ?></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="9" align="left" bgcolor="#999999" class="titulocolumnas"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulo_menu">Post Venta (BEI - TER)</span></td>
  </tr>
  <tr>
    <td width="20%" align="center" bgcolor="#999999" class="titulocolumnas">Especialista</td>
    <td width="10%" align="center" bgcolor="#999999" class="titulocolumnas">Perfil</td>
    <td width="10%" align="center" bgcolor="#999999" class="titulocolumnas">Operaciones Ingresadas</td>
    <td width="10%" align="center" bgcolor="#999999" class="titulocolumnas">Operaciones Pendientes</td>
    <td width="10%" align="center" bgcolor="#999999" class="titulocolumnas">Reparos x Post Venta</td>
    <td width="10%" align="center" bgcolor="#999999" class="titulocolumnas">Reparos x Operaciones</td>
    <td width="10%" align="center" bgcolor="#999999" class="titulocolumnas">Operaciones Cursadas</td>
    <td width="10%" align="center" bgcolor="#999999" class="titulocolumnas">Urgentes</td>
    <td width="10%" align="center" bgcolor="#999999" class="titulocolumnas">Fuera de Hora</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle" bgcolor="#CCCCCC"><?php echo strtoupper($row_bei['especialista_curse']); ?></td>
      <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_bei['perfil']; ?></td>
      <td align="center" valign="middle" bgcolor="#CCCCCC" class="Naranja2"><?php echo number_format($row_bei['oping'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo number_format($row_bei['oppen'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo number_format($row_bei['opesp'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo number_format($row_bei['opope'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle" bgcolor="#CCCCCC" class="Verde2"><?php echo number_format($row_bei['opcur'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle" bgcolor="#FF0000" class="Rojo2"><?php echo number_format($row_bei['opurg'], 0, ',', '.'); ?></td>
      <td align="center" valign="middle" bgcolor="#FFFF00" class="Amarillo2"><?php echo number_format($row_bei['opfho'], 0, ',', '.'); ?></td>
    </tr>
    <?php } while ($row_bei = mysqli_fetch_assoc($bei)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($bei);
?>