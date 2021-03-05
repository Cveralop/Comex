<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,TER";
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
if (isset($_SESSION['login'])) {
  $colname_DetailRS1 = $_SESSION['login'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT opcex.*,(usuarios.nombre)as ne, time(date_espe)as esp FROM opcex, usuarios WHERE especialista_curse = %s and (opcex.especialista_curse = usuarios.usuario) ORDER BY opcex.id DESC", GetSQLValueString($colname_DetailRS1, "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
$colname_fuerahorario = "opcex";
if (isset($_GET['depto'])) {
  $colname_fuerahorario = $_GET['depto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_fuerahorario = sprintf("SELECT * FROM fuerahorario_territorial WHERE depto = %s", GetSQLValueString($colname_fuerahorario, "text"));
$fuerahorario = mysqli_query($comercioexterior, $query_fuerahorario) or die(mysqli_error($comercioexterior));
$row_fuerahorario = mysqli_fetch_assoc($fuerahorario);
$totalRows_fuerahorario = mysqli_num_rows($fuerahorario);
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1);
  $totalRows_DetailRS1 = mysqli_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
$queryString_DetailRS1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_DetailRS1") == false && 
        stristr($param, "totalRows_DetailRS1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_DetailRS1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_DetailRS1 = sprintf("&totalRows_DetailRS1=%d%s", $totalRows_DetailRS1, $queryString_DetailRS1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<script>
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<script> 
window.print(); 
</script>
<html>
<style type="text/css">
<!--
.Estilo13 {
	font-size: 18px;
	font-weight: bold;
}
-->
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Impresi&oacute;n Instrucci&oacute;n</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #000000;
}
.Estilo9 {font-size: 24px; font-weight: bold; }
.Estilo10 {
	font-size: 16px;
	font-weight: bold;
}
.Estilo12 {font-size: 14px; font-weight: bold; }
-->
</style>
</head>
<body>
<table width="95%"  border="0" align="center">
  <tr>
    <td valign="middle"><img src="../../../../imagenes/JPEG/logo_carta.JPG" width="219" height="61" align="left"></div></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong>
      <?php
setlocale(LC_TIME,'sp'); 
echo strftime("Santiago, %d de %B de %Y");?>
    </strong></td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td colspan="2" align="center" valign="middle"><span class="Estilo9">CAMBIOS</span></td>
  </tr>
</table>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="center" valign="middle" class="FueraHorario"><?php if ($row_DetailRS1['especialista'] > $row_fuerahorario['fuera_horario']) { // Show if not first page ?>
<span class="Estilo13" >Operaci�n Ingresada FUERA DE HORARIO </span>
            <?php } // Show if not first page ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="FueraHorario"><span class="Estilo9">Regularizaci&oacute;n Carta Mandato - Operaci&oacute;n ya Curzada</span></td>
  </tr>
</table>
<br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="altdocdismae.php"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr valign="middle">
    <td colspan="2" align="left" valign="middle"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"><strong>Comprobante de Ingreso Carta Original</strong></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">No. Folio:</div></td>
    <td align="left" valign="middle"><strong><?php echo $row_DetailRS1['id']; ?></strong></td>
  </tr>
  <tr valign="middle">
    <td width="20%" align="right" valign="middle">Rut Cliente:</div></td>
    <td align="left" valign="middle"><strong><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?></strong></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Nombre Cliente:</div></td>
    <td align="left" valign="middle"><strong><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></strong></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Fecha Ingreso:</div></td>
    <td align="left" valign="middle"><strong><?php echo $row_DetailRS1['date_espe']; ?></strong></div></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Nro Operaci&oacute;n:</div></td>
    <td align="left" valign="middle"><strong><?php echo strtoupper($row_DetailRS1['nro_operacion']); ?></strong></div>      <div align="center" class="Estilo10"></div></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Evento:</div></td>
    <td align="left" valign="middle"><strong><?php echo $row_DetailRS1['evento']; ?></strong></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Especialista:</div></td>
    <td align="left" valign="middle"><span class="Estilo12"><?php echo strtoupper($row_DetailRS1['ne']); ?></span></td>
  </tr>
  <tr valign="middle">
    <td align="right" valign="middle">Obsevaciones:</div></td>
    <td align="left" valign="middle"><strong><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></strong></td>
  </tr>
</table>
<br>
<p align="center"><br>
  <br>
  <br>
  <br>
  <br>
  <br>
_____________________________________<br> 
<strong>FIRMA ESPECIALISTA</strong><br>
</p>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
mysqli_free_result($fuerahorario);
?>