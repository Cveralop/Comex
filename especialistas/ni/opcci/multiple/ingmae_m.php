<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
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
//AGREGADO 1 para total de registros
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_ingape = 10;
$pageNum_ingape = 0;
if (isset($_GET['pageNum_ingape'])) {
  $pageNum_ingape = $_GET['pageNum_ingape'];
}
$startRow_ingape = $pageNum_ingape * $maxRows_ingape;

$colname_ingape = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_ingape = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ingape = sprintf("SELECT * FROM cliente WHERE rut_cliente = %s", GetSQLValueString($colname_ingape, "text"));
$ingape = mysqli_query($comercioexterior, $query_ingape) or die(mysqli_error($comercioexterior));
$row_ingape = mysqli_fetch_assoc($ingape);
$totalRows_ingape = mysqli_num_rows($ingape);

//AGREGADO 1.2 para total de registros
if (isset($_GET['totalRows_ingape'])) {
  $totalRows_ingape = $_GET['totalRows_ingape'];
} else {
  $all_ingape = mysqli_query($comercioexterior, $query_ingape);
  $totalRows_ingape = mysqli_num_rows($all_ingape);
}
$totalPages_ingape = ceil($totalRows_ingape/$maxRows_ingape)-1;

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
$queryString_ingape = sprintf("&totalRows_opcci=%d%s", $totalRows_ingape, $queryString_ingape);

//AGREGADO 2 para total de registros
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_nrooperacion = 10;
$pageNum_nrooperacion = 0;
if (isset($_GET['pageNum_nrooperacion'])) {
  $pageNum_nrooperacion = $_GET['pageNum_nrooperacion'];
}
$startRow_nrooperacion = $pageNum_nrooperacion * $maxRows_nrooperacion;

$colname_nrooperacion = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname_nrooperacion = $_GET['nro_operacion'];
}
$colname1_nrooperacion = "Apertura.";
if (isset($_GET['colname1'])) {
  $colname1_nrooperacion = $_GET['colname1'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_nrooperacion = sprintf("SELECT * FROM opcci nolock WHERE nro_operacion = %s and evento = %s", GetSQLValueString($colname_nrooperacion, "text"),GetSQLValueString($colname1_nrooperacion, "text"));
$nrooperacion = mysqli_query($comercioexterior, $query_nrooperacion) or die(mysqli_error($comercioexterior));
$row_nrooperacion = mysqli_fetch_assoc($nrooperacion);
$totalRows_nrooperacion = mysqli_num_rows($nrooperacion);

//AGREGADO 2.2 para total de registros
if (isset($_GET['totalRows_nrooperacion'])) {
  $totalRows_nrooperacion = $_GET['totalRows_nrooperacion'];
} else {
  $all_nrooperacion = mysqli_query($comercioexterior, $query_nrooperacion);
  $totalRows_nrooperacion = mysqli_num_rows($all_nrooperacion);
}
$totalPages_nrooperacion = ceil($totalRows_nrooperacion/$maxRows_nrooperacion)-1;

$queryString_nrooperacion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_nrooperacion") == false && 
        stristr($param, "totalRows_nrooperacion") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_nrooperacion = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_nrooperacion = sprintf("&totalRows_opcci=%d%s", $totalRows_nrooperacion, $queryString_nrooperacion);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso Multiple Intrucciones - Maestro</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
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
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo11 {color: #FFFFFF; font-weight: bold; }

</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<style type="text/css">
<!--
.Estilo13 {
	color: #FF0000;
	font-weight: bold;
}

</style>
</head>
<body onLoad="MM_preloadImages('../../../../espcomex/imagenes/Botones/boton_volver_2.jpg','../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">INGRESO MULTIPLE INSTRUCCIONES - MAESTRO </td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">CARTAS DE CR&Eacute;DITO DE IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo7">Ingreso Multiple Instrucci&oacute;n  Apertura Carta de Cr&eacute;dito de Importaci&oacute;n</span></td>
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
      <td colspan="2" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo7">Ingreso Multiple Instrucciones Carta de Cr&eacute;dito de Importaci&oacute;n</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right">Nro Operaci&oacute;n:</td>
      <td width="79%" align="left"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="17" maxlength="7">
      <span class="rojopequeno">K000000</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
          <input name="Submit" type="submit" class="boton" value="Buscar">
          <input name="Submit" type="reset" class="boton" value="Limpiar"></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_ingape > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Ingresar Apertura </div></td>
    <td align="center" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre Cliente
    </td>
    <td align="center" class="titulocolumnas">Impedido de Operar / Passport</td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="ingdet_m.php?recordID=<?php echo $row_ingape['id']; ?>"> <img src="../../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div></td>
    <td align="center"><?php echo strtoupper($row_ingape['rut_cliente']); ?> </div></td>
    <td align="left"><?php echo strtoupper($row_ingape['nombre_cliente']); ?> </td>
    <td align="center"><?php echo strtoupper($row_ingape['impedido_operar']); ?> / <span class="respuestacolumna_rojo"><?php echo strtoupper($row_ingape['cliente_passport']); ?></span></td>
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
<br>
<?php if ($totalRows_nrooperacion > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Ingreso Operaciones </div></td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </div></td>
    <td align="center" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre Cliente</div></td>
  </tr>  
  <?php do { ?>
    <tr valign="middle">
      <td align="center"><a href="ingdet2.php?recordID=<?php echo $row_nrooperacion['id']; ?>"> <img src="../../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div></td>
      <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_nrooperacion['nro_operacion']); ?></span>        </div></td>
      <td align="center"><?php echo strtoupper($row_nrooperacion['rut_cliente']); ?> </div></td>
      <td align="left"><?php echo strtoupper($row_nrooperacion['nombre_cliente']); ?> </td>
    </tr>
    <?php } while ($row_nrooperacion = mysqli_fetch_assoc($nrooperacion)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_nrooperacion > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_nrooperacion=%d%s", $currentPage, 0, $queryString_nrooperacion); ?>">Primero</a>
            <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_nrooperacion > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_nrooperacion=%d%s", $currentPage, max(0, $pageNum_nrooperacion - 1), $queryString_nrooperacion); ?>">Anterior</a>
            <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_nrooperacion < $totalPages_nrooperacion) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_nrooperacion=%d%s", $currentPage, min($totalPages_nrooperacion, $pageNum_nrooperacion + 1), $queryString_nrooperacion); ?>">Siguiente</a>
            <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_nrooperacion < $totalPages_nrooperacion) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_nrooperacion=%d%s", $currentPage, $totalPages_nrooperacion, $queryString_nrooperacion); ?>">&Uacute;ltimo</a>
            <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_nrooperacion + 1) ?></strong> al <strong><?php echo min($startRow_nrooperacion + $maxRows_nrooperacion, $totalRows_nrooperacion) ?></strong> de un total de <strong><?php echo $totalRows_nrooperacion ?></strong>
<?php } // Show if recordset not empty ?> <br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../opcci.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image6" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>

<?php
mysqli_free_result($ingape);
mysqli_free_result($nrooperacion);
?>