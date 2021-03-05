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

$currentPage = $_SERVER["PHP_SELF"];


$maxRows_excepciones = 10;
$pageNum_excepciones = 0;
if (isset($_GET['pageNum_excepciones'])) {
  $pageNum_excepciones = $_GET['pageNum_excepciones'];
}
$startRow_excepciones = $pageNum_excepciones * $maxRows_excepciones;

$colname_excepciones = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_excepciones = $_GET['rut_cliente'];
}
$colname1_excepciones = "-1";
if (isset($_GET['estado_excepcion'])) {
  $colname1_excepciones = $_GET['estado_excepcion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_excepciones = sprintf("SELECT * FROM excepciones WHERE rut_cliente = %s and estado_excepcion = %s", GetSQLValueString($colname_excepciones, "text"),GetSQLValueString($colname1_excepciones, "text"));
$query_limit_excepciones = sprintf("%s LIMIT %d, %d", $query_excepciones, $startRow_excepciones, $maxRows_excepciones);
$excepciones = mysqli_query($comercioexterior, $query_limit_excepciones) or die(mysqli_error());
$row_excepciones = mysqli_fetch_assoc($excepciones);

if (isset($_GET['totalRows_excepciones'])) {
  $totalRows_excepciones = $_GET['totalRows_excepciones'];
} else {
  $all_excepciones = mysqli_query($comercioexterior, $query_excepciones);
  $totalRows_excepciones = mysqli_num_rows($all_excepciones);
}
$totalPages_excepciones = ceil($totalRows_excepciones/$maxRows_excepciones)-1;

$queryString_excepciones = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_excepciones") == false && 
        stristr($param, "totalRows_excepciones") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_excepciones = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_excepciones = sprintf("&totalRows_excepciones=%d%s", $totalRows_excepciones, $queryString_excepciones);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mantencion Excepciones Administrativas - Maestro</title>
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
  <tr valign="middle">
    <td align="left" class="Estilo3">MANTENCION EXCEPCIONES ADMINISTRATIVAS - MAESTRO </td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">EXCEPCIONES</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" />Mantención Excepciones</td>
    </tr>
    <tr>
      <td width="18%" align="right" valign="middle">Rut Cliente:</td>
      <td width="82%" align="left" valign="middle"><label>
        <input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15" />
      <span class="rojopequeno">Sin Puntos ni Guion</span></label></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Excepción:</td>
      <td align="left" valign="middle"><label>
        <select name="estado_excepcion" class="etiqueta12" id="estado_excepcion">
          <option value="Pendiente." selected="selected">Pendiente</option>
          <option value="Solucionado.">Solucionado</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="excepciones.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen4','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen4" width="80" height="25" border="0" id="Imagen4" /></a></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td class="titulocolumnas">Mantención Excepción</td>
    <td class="titulocolumnas">Rut Cliente</td>
    <td class="titulocolumnas">Nombre Cliente</td>
    <td class="titulocolumnas">Fecha Ingreso</td>
    <td class="titulocolumnas">Evento</td>
    <td class="titulocolumnas">Fecha Solucion</td>
    <td class="titulocolumnas">Producto</td>
    <td class="titulocolumnas">Nro Operacion</td>
    <td class="titulocolumnas">Moneda / Monto Operación</td>
    <td class="titulocolumnas">Tipo Excepcion</td>
    <td class="titulocolumnas">Vcto Excepcion</td>
    <td class="titulocolumnas">Estado Excepcion</td>
  </tr>
  <?php do { ?>
    <tr>
      <td valign="middle"><a href="mantencion_excepcion_det.php?recordID=<?php echo $row_excepciones['id']; ?>"><img src="../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" align="middle" /></a></td>
      <td valign="middle"><?php echo $row_excepciones['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_excepciones['nombre_cliente']; ?></td>
      <td valign="middle"><?php echo $row_excepciones['fecha_ingreso']; ?></td>
      <td align="left" valign="middle"><?php echo $row_excepciones['evento']; ?></td>
      <td valign="middle"><?php echo $row_excepciones['fecha_solucion']; ?></td>
      <td align="left" valign="middle"><?php echo $row_excepciones['producto']; ?></td>
      <td valign="middle"><?php echo $row_excepciones['nro_operacion']; ?></td>
      <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_excepciones['moneda_operacion']; ?></span>&nbsp; <span class="respuestacolumna_azul"><?php echo number_format($row_excepciones['monto_operacion'], 2, ',', '.'); ?></span></td>
      <td align="left" valign="middle"><?php echo $row_excepciones['tipo_excepcion']; ?></td>
      <td valign="middle"><?php echo $row_excepciones['vcto_excepcion']; ?></td>
      <td valign="middle"><?php echo $row_excepciones['estado_excepcion']; ?></td>
    </tr>
    <?php } while ($row_excepciones = mysqli_fetch_assoc($excepciones)); ?>
</table>
<br />
<table width="50%" border="0" align="center">
  <tr>
    <td><?php if ($pageNum_excepciones > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_excepciones=%d%s", $currentPage, 0, $queryString_excepciones); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_excepciones > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_excepciones=%d%s", $currentPage, max(0, $pageNum_excepciones - 1), $queryString_excepciones); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_excepciones < $totalPages_excepciones) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_excepciones=%d%s", $currentPage, min($totalPages_excepciones, $pageNum_excepciones + 1), $queryString_excepciones); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_excepciones < $totalPages_excepciones) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_excepciones=%d%s", $currentPage, $totalPages_excepciones, $queryString_excepciones); ?>">Último</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
<br />
Registros del<span class="respuestacolumna_azul"><?php echo ($startRow_excepciones + 1) ?></span> al <span class="respuestacolumna_azul"><?php echo min($startRow_excepciones + $maxRows_excepciones, $totalRows_excepciones) ?></span> de un total de <span class="respuestacolumna_azul"><?php echo $totalRows_excepciones ?></span>
</body>
</html>
<?php
mysqli_free_result($excepciones);
?>