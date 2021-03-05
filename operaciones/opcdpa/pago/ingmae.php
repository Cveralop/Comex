<?php require_once('../../../Connections/comercioexterior.php'); ?>
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

$colname_ingpre = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname_ingpre = $_GET['nro_operacion'];
}
$colname1_ingpre = "Otorgamiento.";
if (isset($_GET['evento'])) {
  $colname1_ingpre = $_GET['evento'];
}
$colname2_ingpre = "zzz";
if (isset($_GET['nro_operacion_relacionada'])) {
  $colname2_ingpre = $_GET['nro_operacion_relacionada'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ingpre = sprintf("SELECT * FROM opcdpa nolock WHERE nro_operacion LIKE %s and evento = %s and nro_operacion_relacionada LIKE %s ORDER BY id DESC", GetSQLValueString($colname_ingpre . "%", "text"),GetSQLValueString($colname1_ingpre, "text"),GetSQLValueString($colname2_ingpre . "%", "text"));
$ingpre = mysqli_query($comercioexterior, $query_ingpre) or die(mysqli_error());
$row_ingpre = mysqli_fetch_assoc($ingpre);
$totalRows_ingpre = mysqli_num_rows($ingpre);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso Pago Cesi&oacute;n de Derecho o Pago Anticipado - Maestro</title>
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
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo10 {color: #00FF00}
.Estilo11 {
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
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO PAGO CESI&Oacute;N DE DERECHO O PAGO ANTICIPADO  - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CESI&Oacute;N DE DERECHO Y/O PAGO ANTICIPADO </td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Busqueda Operaci&oacute;n Cesi&oacute;n y/o Pago Anticipado</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Operaci&oacute;n Relacionada: </td>
      <td align="left"><input name="nro_operacion_relacionada" type="text" class="etiqueta12" id="nro_operacion_relacionada" size="15" maxlength="7">
        <span class="rojopequeno">E000000</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right">Nro Operaci&oacute;n:</div></td>
      <td width="79%" align="left"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7">
        <span class="rojopequeno">F000000</span></td>
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
<?php if ($totalRows_ingpre > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="5" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Numero Operaci&oacute;n <span class="Estilo10"><?php echo strtoupper($row_ingpre['nro_operacion']); ?> <span class="Estilo5">Operaci&oacute;n Relacionada</span><span class="Estilo8"><span class="Estilo11"><span class="Estilo10"> <?php echo strtoupper($row_ingpre['nro_operacion_relacionada']); ?></span></span></span> </span></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Ingresar</div></td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Tipo Operaci&oacute;n</div>
    </td>
  </tr>
  <?php do { ?>
  <tr bgcolor="#CCCCCC">
    <td align="center" valign="middle"><a href="ingdet.php?recordID=<?php echo $row_ingpre['id']; ?>"> <img src="../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div></td>
    <td align="center" valign="middle"><?php echo $row_ingpre['rut_cliente']; ?> </div></td>
    <td align="left" valign="middle"><?php echo $row_ingpre['nombre_cliente']; ?> </td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_ingpre['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_ingpre['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle"><?php echo $row_ingpre['tipo_operacion']; ?></div></td>
  </tr>
  <?php } while ($row_ingpre = mysqli_fetch_assoc($ingpre)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_ingpre > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingpre=%d%s", $currentPage, 0, $queryString_ingpre); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_ingpre > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingpre=%d%s", $currentPage, max(0, $pageNum_ingpre - 1), $queryString_ingpre); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingpre < $totalPages_ingpre) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingpre=%d%s", $currentPage, min($totalPages_ingpre, $pageNum_ingpre + 1), $queryString_ingpre); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingpre < $totalPages_ingpre) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingpre=%d%s", $currentPage, $totalPages_ingpre, $queryString_ingpre); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_ingpre + 1) ?></strong> al <strong><?php echo min($startRow_ingpre + $maxRows_ingpre, $totalRows_ingpre) ?></strong> de un total de <strong><?php echo $totalRows_ingpre ?></strong>
<?php } // Show if recordset not empty ?> <br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../cedeypaant.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($ingpre);
?>