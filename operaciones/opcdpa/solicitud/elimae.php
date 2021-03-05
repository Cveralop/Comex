<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,SUP";
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

$colname1_eliminar = "Solicitud.";
if (isset($_GET['evento'])) {
  $colname1_eliminar = $_GET['evento'];
}
$colname_eliminar = "1";
if (isset($_GET['nro_operacion_relacionada'])) {
  $colname_eliminar = $_GET['nro_operacion_relacionada'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_eliminar = sprintf("SELECT * FROM opcdpa nolock WHERE nro_operacion_relacionada = %s and evento = %s", GetSQLValueString($colname_eliminar, "text"),GetSQLValueString($colname1_eliminar, "text"));
$eliminar = mysqli_query($comercioexterior, $query_eliminar) or die(mysqli_error());
$row_eliminar = mysqli_fetch_assoc($eliminar);
$totalRows_eliminar = mysqli_num_rows($eliminar);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Eliminar Solicitud - Maestro</title>
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
.Estilo5 {
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.Estilo6 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo9 {color: #FFFFFF; font-weight: bold; }
-->
</style>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">ELIMINAR SOLICITUD - MAESTRO </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CESI&Oacute;N DE DERECHO Y PAGO ANTICIPADO</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Emilinar Solicitud </span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Nro Operaci&oacute;n Relacionada: </div></td>
      <td width="79%" align="left" valign="middle"><input name="nro_operacion_relacionada" type="text" class="etiqueta12" id="nro_operacion_relacionada" size="15" maxlength="7">
        <span class="rojopequeno">E000000</span></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_eliminar > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center"><span class="Estilo9"><span class="titulocolumnas">Eliminar</span></span></td>
    <td align="center" class="titulocolumnas">Fecha Ingreso </td>
    <td align="center" class="titulocolumnas">Rut Cliente </td>
    <td align="center" class="titulocolumnas">Nombre Cliente </td>
    <td align="center" class="titulocolumnas">Estado</td>
    <td align="center" class="titulocolumnas">Operador</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
    <td align="center" class="titulocolumnas">Tipo Operaci&oacute;n </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td height="26" align="center"><a href="elidet.php?recordID=<?php echo $row_eliminar['id']; ?>"> <img src="../../../imagenes/ICONOS/papelero.jpg" width="20" height="21" border="0"></a></td>
    <td align="center"><?php echo $row_eliminar['fecha_ingreso']; ?></td>
    <td align="center"><?php echo $row_eliminar['rut_cliente']; ?> </td>
<td align="left"><?php echo $row_eliminar['nombre_cliente']; ?> </td>
    <td align="center"><?php echo $row_eliminar['estado']; ?> </td>
    <td align="center"><?php echo $row_eliminar['operador']; ?> </td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_eliminar['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_eliminar['monto_operacion'], 2, ',', '.'); ?></strong> </div></td>
    <td align="center"><?php echo $row_eliminar['tipo_operacion']; ?> </td>
  </tr>
  <?php } while ($row_eliminar = mysqli_fetch_assoc($eliminar)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_eliminar > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_eliminar=%d%s", $currentPage, 0, $queryString_eliminar); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_eliminar > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_eliminar=%d%s", $currentPage, max(0, $pageNum_eliminar - 1), $queryString_eliminar); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_eliminar < $totalPages_eliminar) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_eliminar=%d%s", $currentPage, min($totalPages_eliminar, $pageNum_eliminar + 1), $queryString_eliminar); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_eliminar < $totalPages_eliminar) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_eliminar=%d%s", $currentPage, $totalPages_eliminar, $queryString_eliminar); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_eliminar + 1) ?></strong> al <strong><?php echo min($startRow_eliminar + $maxRows_eliminar, $totalRows_eliminar) ?></strong> de un total de <strong><?php echo $totalRows_eliminar ?></strong>
<?php } // Show if recordset not empty ?> <br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td><a href="../cedeypaant.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($eliminar);
?>