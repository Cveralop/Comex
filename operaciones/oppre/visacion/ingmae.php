<?php require_once('../../../Connections/comercioexterior.php'); ?>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_ingape = 10;
$pageNum_ingape = 0;
if (isset($_GET['pageNum_ingape'])) {
  $pageNum_ingape = $_GET['pageNum_ingape'];
}
$startRow_ingape = $pageNum_ingape * $maxRows_ingape;

$colname_ingape = "zzzxxx";
if (isset($_GET['rut_cliente'])) {
  $colname_ingape = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ingape = sprintf("SELECT * FROM cliente nolock WHERE rut_cliente = %s ORDER BY rut_cliente ASC", GetSQLValueString($colname_ingape, "text"));
$query_limit_ingape = sprintf("%s LIMIT %d, %d", $query_ingape, $startRow_ingape, $maxRows_ingape);
$ingape = mysqli_query($comercioexterior, $query_limit_ingape) or die(mysqli_error($comercioexterior));
$row_ingape = mysqli_fetch_assoc($ingape);

if (isset($_GET['totalRows_ingape'])) {
  $totalRows_ingape = $_GET['totalRows_ingape'];
} else {
  $all_ingape = mysqli_query($comercioexterior, $query_ingape);
  $totalRows_ingape = mysqli_num_rows($all_ingape);
}
$totalPages_ingape = ceil($totalRows_ingape/$maxRows_ingape)-1;

$colname_ingvarios = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname_ingvarios = $_GET['nro_operacion'];
}
$colname1_ingvarios = "Apertura.";
if (isset($_GET['evento'])) {
  $colname1_ingvarios = $_GET['evento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ingvarios = sprintf("SELECT * FROM oppre nolock WHERE nro_operacion = %s and evento = %s", GetSQLValueString($colname_ingvarios, "text"),GetSQLValueString($colname1_ingvarios, "text"));
$ingvarios = mysqli_query($comercioexterior, $query_ingvarios) or die(mysqli_error($comercioexterior));
$row_ingvarios = mysqli_fetch_assoc($ingvarios);
$totalRows_ingvarios = mysqli_num_rows($ingvarios);

$maxRows_cci = 10;
$pageNum_cci = 0;
if (isset($_GET['pageNum_cci'])) {
  $pageNum_cci = $_GET['pageNum_cci'];
}
$startRow_cci = $pageNum_cci * $maxRows_cci;

$colname2_cci = "Negociacion.";
if (isset($_GET['evento'])) {
  $colname2_cci = $_GET['evento'];
}
$colname_cci = "1";
if (isset($_GET['nro_operacion'])) {
  $colname_cci = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cci = sprintf("SELECT * FROM opcci nolock WHERE nro_operacion = %s and evento = %s ORDER BY id DESC", GetSQLValueString($colname_cci, "text"),GetSQLValueString($colname2_cci, "text"));
$query_limit_cci = sprintf("%s LIMIT %d, %d", $query_cci, $startRow_cci, $maxRows_cci);
$cci = mysqli_query($comercioexterior, $query_limit_cci) or die(mysqli_error($comercioexterior));
$row_cci = mysqli_fetch_assoc($cci);

if (isset($_GET['totalRows_cci'])) {
  $totalRows_cci = $_GET['totalRows_cci'];
} else {
  $all_cci = mysqli_query($comercioexterior, $query_cci);
  $totalRows_cci = mysqli_num_rows($all_cci);
}
$totalPages_cci = ceil($totalRows_cci/$maxRows_cci)-1;

mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opasignadas = "SELECT evento,operador,count(operador)as cantidad,(usuarios.nombre)as nombre FROM oppre, usuarios WHERE date_asig >= curdate() and (oppre.operador = usuarios.usuario) GROUP BY evento,operador ORDER BY operador ASC";
$opasignadas = mysqli_query($comercioexterior, $query_opasignadas) or die(mysqli_error($comercioexterior));
$row_opasignadas = mysqli_fetch_assoc($opasignadas);
$totalRows_opasignadas = mysqli_num_rows($opasignadas);

$queryString_ingape = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ingape") == false && 
        stristr($param, "totalRows_ingape") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ingape = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ingape = sprintf("&totalRows_ingape=%d%s", $totalRows_ingape, $queryString_ingape);

$queryString_cci = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cci") == false && 
        stristr($param, "totalRows_cci") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cci = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cci = sprintf("&totalRows_cci=%d%s", $totalRows_cci, $queryString_cci);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso Visaci&oacute;n - Maestro</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo7 {
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo11 {color: #FFFFFF; font-weight: bold; }
.Estilo12 {
	color: #FF0000;
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
<style type="text/css">
<!--
.Estilo121 {color: #FFFFFF; font-weight: bold; }
-->
</style>
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">INGRESO VISACI&Oacute;N - MAESTRO </td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo7">Ingreso Visaci&oacute;n por Rut Cliente</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right">Rut Cliente:</td>
      <td width="79%" align="left"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="12">
      <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
          <input name="Submit" type="submit" class="boton" value="Buscar">
          <input name="Submit" type="reset" class="boton" value="Limpiar"></td>
    </tr>
  </table>
</form>
<br>
<form name="form2" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo7">Ingreso Visaci&oacute;n por Nro Operacion</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right">Nro Operaci&oacute;n:</td>
      <td width="79%" align="left"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7">
      <span class="rojopequeno">F &oacute; L000000</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
          <input name="Submit" type="submit" class="boton" value="Buscar">
          <input name="Submit" type="reset" class="boton" value="Limpiar"></td>
    </tr>
  </table>
</form>
<br>
<form name="form3" method="get" action="">
<table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo7">Ingreso Visaci&oacute;n por Nro Operaci&oacute;n CCI</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right">Nro Operaci&oacute;n:</div></td>
      <td width="79%" align="left"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7">
      <span class="rojopequeno">K000000</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
          <input name="Submit" type="submit" class="boton" value="Buscar">
          <input name="Submit" type="reset" class="boton" value="Limpiar"></td>
    </tr>
  </table>
</form>
<table width="95%" border="0" align="center">
<tr>  </tr>
</table>
<br>
<table width="95%" border="0" align="center">
<br>
<tr>
  <td align="left" valign="middle"><?php if ($totalRows_ingape > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td class="titulocolumnas">Ingresar Apertura </div></td>
    <td class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td><a href="ingdet.php?recordID=<?php echo $row_ingape['id']; ?>"> <img src="../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div></td>
    <td><?php echo $row_ingape['rut_cliente']; ?> </div></td>
    <td align="left"><?php echo strtoupper($row_ingape['nombre_cliente']); ?> </td>
  </tr>
  <?php } while ($row_ingape = mysqli_fetch_assoc($ingape)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_ingape > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingape=%d%s", $currentPage, 0, $queryString_ingape); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_ingape > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingape=%d%s", $currentPage, max(0, $pageNum_ingape - 1), $queryString_ingape); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingape < $totalPages_ingape) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingape=%d%s", $currentPage, min($totalPages_ingape, $pageNum_ingape + 1), $queryString_ingape); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingape < $totalPages_ingape) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingape=%d%s", $currentPage, $totalPages_ingape, $queryString_ingape); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_ingape + 1) ?></strong> al <strong><?php echo min($startRow_ingape + $maxRows_ingape, $totalRows_ingape) ?></strong> de un total de <strong><?php echo $totalRows_ingape ?></strong>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_ingvarios > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td class="titulocolumnas">Ingresar Instrucci&oacute;n</div></td>
    <td class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td class="titulocolumnas">
      Nombre Cliente 
        </div>
    </div>
    </td>
    <td class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td><a href="ingdet2.php?recordID=<?php echo $row_ingvarios['id']; ?>"> <img src="../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div></td>
    <td><span class="respuestacolumna_rojo"><?php echo strtoupper($row_ingvarios['nro_operacion']); ?></span>      </div></td>
    <td><?php echo $row_ingvarios['rut_cliente']; ?> </div></td>
    <td align="left"><?php echo strtoupper($row_ingvarios['nombre_cliente']); ?> </td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_ingvarios['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_ingvarios['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
  </tr>
  <?php } while ($row_ingvarios = mysqli_fetch_assoc($ingvarios)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_ingvarios > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingvarios=%d%s", $currentPage, 0, $queryString_ingvarios); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_ingvarios > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingvarios=%d%s", $currentPage, max(0, $pageNum_ingvarios - 1), $queryString_ingvarios); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingvarios < $totalPages_ingvarios) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingvarios=%d%s", $currentPage, min($totalPages_ingvarios, $pageNum_ingvarios + 1), $queryString_ingvarios); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingvarios < $totalPages_ingvarios) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingvarios=%d%s", $currentPage, $totalPages_ingvarios, $queryString_ingvarios); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_ingvarios + 1) ?></strong> al <strong><?php echo min($startRow_ingvarios + $maxRows_ingvarios, $totalRows_ingvarios) ?></strong> de un total de <strong><?php echo $totalRows_ingvarios ?></strong>
<?php } // Show if recordset not empty ?> <br>
<br>
<?php if ($totalRows_cci > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td class="titulocolumnas">Ingresar Instrucci&oacute;n</div></td>
    <td class="titulocolumnas">Nro Operaci&oacute;n</div>
    </td>
    <td class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td class="titulocolumnas">Moneda / Monto Documentos 
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td><a href="ingdet3.php?recordID=<?php echo $row_cci['id']; ?>"> <img src="../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div></td>
    <td><?php echo strtoupper($row_cci['nro_operacion']); ?> </div></td>
    <td><?php echo strtoupper($row_cci['rut_cliente']); ?> </div></td>
    <td align="left"><?php echo strtoupper($row_cci['nombre_cliente']); ?> </td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_cci['moneda_documentos']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_cci['monto_documentos'], 2, ',', '.'); ?></strong></div></td>
  </tr>
  <?php } while ($row_cci = mysqli_fetch_assoc($cci)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_cci > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_cci=%d%s", $currentPage, 0, $queryString_cci); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_cci > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_cci=%d%s", $currentPage, max(0, $pageNum_cci - 1), $queryString_cci); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_cci < $totalPages_cci) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_cci=%d%s", $currentPage, min($totalPages_cci, $pageNum_cci + 1), $queryString_cci); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_cci < $totalPages_cci) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_cci=%d%s", $currentPage, $totalPages_cci, $queryString_cci); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_cci + 1) ?></strong> al <strong><?php echo min($startRow_cci + $maxRows_cci, $totalRows_cci) ?></strong> de un total de <strong><?php echo $totalRows_cci ?></strong>
<?php } // Show if recordset not empty ?>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image6" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($ingape);
mysqli_free_result($ingvarios);
mysqli_free_result($cci);
mysqli_free_result($opasignadas);
?>