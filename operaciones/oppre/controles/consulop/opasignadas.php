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

$colname1_compraventa = "Pendiente.";
if (isset($_GET['sub_estado'])) {
  $colname1_compraventa = $_GET['sub_estado'];
}
$colname_compraventa = "zzzxxx";
if (isset($_GET['fecha_ingreso'])) {
  $colname_compraventa = $_GET['fecha_ingreso'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_compraventa = sprintf("SELECT operador,evento,tipo_operacion,count(id)as cantidad FROM oppre nolock WHERE fecha_ingreso LIKE %s and sub_estado = %s GROUP BY operador,evento ", GetSQLValueString("%" . $colname_compraventa . "%", "text"),GetSQLValueString($colname1_compraventa, "text"));
$compraventa = mysql_query($query_compraventa, $comercioexterior) or die(mysqli_error());
$row_compraventa = mysqli_fetch_assoc($compraventa);
$totalRows_compraventa = mysqli_num_rows($compraventa);

$colname1_total = "Pendiente.";
if (isset($_GET['sub_estado'])) {
  $colname1_total = $_GET['sub_estado'];
}
$colname_total = "zzzxxx";
if (isset($_GET['fecha_ingreso'])) {
  $colname_total = $_GET['fecha_ingreso'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_total = sprintf("SELECT *,count(id)as total FROM oppre nolock WHERE fecha_ingreso LIKE '%%%s%%' and sub_estado = '%s' GROUP BY sub_estado", $colname_total,$colname1_total);
$total = mysql_query($query_total, $comercioexterior) or die(mysqli_error());
$row_total = mysqli_fetch_assoc($total);
$totalRows_total = mysqli_num_rows($total);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Compra Venta</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000000;
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
.Estilo7 {
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.Estilo8 {color: #0000FF}
.Estilo10 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo11 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo12 {color: #CCCCCC}
.Estilo14 {
	font-size: 12px;
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
    <td width="93%" align="left" class="Estilo3">OPERACIONES ASIGNADAS</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43"></td>
  </tr>
  <tr>
    <td align="left" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo7">Operaciones Asignadas</span></td>
    </tr>
    <tr valign="middle">
      <td width="19%" align="right" class="respuestacolumna">Fecha Ingreso:</div></td>
      <td width="81%" align="left"><span class="Estilo8">
        <input name="fecha_ingreso" type="text" class="etiqueta12" id="fecha_ingreso" value="<?php echo date("Y"); ?>" size="12" maxlength="10"> 
      </span><span class="rojopequeno">(dd-mm-aaaa) </span></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td align="center">Operador</div></td>
    <td align="center">Evento</div></td>
    <td align="center">Cantidad</div></td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><?php echo $row_compraventa['operador']; ?></div></td>
    <td align="center"><?php echo strtoupper($row_compraventa['evento']); ?></div></td>
    <td align="center"><?php echo $row_compraventa['cantidad']; ?></div></td>
  </tr>
  <?php } while ($row_compraventa = mysqli_fetch_assoc($compraventa)); ?>
  <tr valign="middle">
    <td align="center">Total Operaciones:</div></td>
    <td align="center"><span class="Estilo12">.</span></td>
    <td align="center" bgcolor="#FF0000"><?php echo $row_total['total']; ?> </div></td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../prestamos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($compraventa);
mysqli_free_result($total);
?>