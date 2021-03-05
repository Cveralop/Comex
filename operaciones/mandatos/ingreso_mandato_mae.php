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

$colname_ingmand = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_ingmand = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ingmand = sprintf("SELECT * FROM cliente nolock WHERE rut_cliente = %s", GetSQLValueString($colname_ingmand, "text"));
$ingmand = mysql_query($query_ingmand, $comercioexterior) or die(mysqli_error());
$row_ingmand = mysqli_fetch_assoc($ingmand);
$totalRows_ingmand = mysqli_num_rows($ingmand);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingreso Mandatos - Maestro</title>
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
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO MANDATOS - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">COMERCIO EXTERIOR OPERACIONES</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulodetalle">Ingreso Mandato Operaciones</span></td>
    </tr>
    <tr>
      <td width="23%" align="right" valign="middle">Rut Cliente:</td>
      <td width="77%" align="left" valign="middle"><label>
        <input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="16" maxlength="12" />
        <span class="rojopequeno">Sin puntos ni Guion</span>
      </label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar Cliente" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<?php if ($totalRows_ingmand > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Ingresar Mandato</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Especialista</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Ejecutivo</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Oficina</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Codigo Sucursal</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><a href="ingreso_mandato_det.php?recordID=<?php echo $row_ingmand['id']; ?>"><img src="../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0" /></a></td>
        <td align="center" valign="middle"><?php echo $row_ingmand['rut_cliente']; ?>&nbsp; </td>
        <td align="left" valign="middle"><?php echo $row_ingmand['nombre_cliente']; ?>&nbsp; </td>
        <td align="left" valign="middle"><?php echo $row_ingmand['especialista']; ?>&nbsp; </td>
        <td align="left" valign="middle"><?php echo $row_ingmand['ejecutivo']; ?>&nbsp; </td>
        <td align="left" valign="middle"><?php echo $row_ingmand['oficina']; ?>&nbsp; </td>
        <td align="center" valign="middle"><?php echo $row_ingmand['sucursal']; ?>&nbsp; </td>
      </tr>
      <?php } while ($row_ingmand = mysqli_fetch_assoc($ingmand)); ?>
  </table>
  <br />
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_ingmand > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingmand=%d%s", $currentPage, 0, $queryString_ingmand); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_ingmand > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingmand=%d%s", $currentPage, max(0, $pageNum_ingmand - 1), $queryString_ingmand); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_ingmand < $totalPages_ingmand) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingmand=%d%s", $currentPage, min($totalPages_ingmand, $pageNum_ingmand + 1), $queryString_ingmand); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_ingmand < $totalPages_ingmand) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingmand=%d%s", $currentPage, $totalPages_ingmand, $queryString_ingmand); ?>">Último</a>
        <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="mandatos.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen4','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen4" width="80" height="25" border="0" id="Imagen4" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($ingmand);
?>