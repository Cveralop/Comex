<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ESP,ADM";
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

$colname_Recordset1 = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_Recordset1 = $_GET['rut_cliente'];
}
$colname1_Recordset1 = "zzzxxx";
if (isset($_GET['nro_operacion'])) {
  $colname1_Recordset1 = $_GET['nro_operacion'];
}
$colname2_Recordset1 = "zzzxxx";
if (isset($_GET['nro_operacion_relacionada'])) {
  $colname2_Recordset1 = $_GET['nro_operacion_relacionada'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = sprintf("SELECT * FROM carteraopera nolock WHERE rut_cliente LIKE %s and nro_operacion LIKE %s and nro_operacion_relacionada LIKE %s ORDER BY fecha_vcto ASC", GetSQLValueString("%" . $colname_Recordset1 . "%", "text"),GetSQLValueString("%" . $colname1_Recordset1 . "%", "text"),GetSQLValueString("%" . $colname2_Recordset1 . "%", "text"));
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysqli_query($comercioexterior, $query_limit_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cartera Operaciones</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo1 {font-size: 18px;
	color: #FFFFFF;
	font-weight: bold;
}

</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" bgcolor="#FF0000" class="Estilo1">CARTERA OPERACIONES IMPORT - EXPORT (SOLO BKT)</td>
    <td width="7%" rowspan="2" align="left" valign="middle" bgcolor="#FF0000"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#FF0000" class="subtitulopaguina">COMERCIO EXTERIOR</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" />Cartera de Operaciones</td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Rut Cliente</td>
      <td width="79%" align="left" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15" />
      <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Nro Operacion:</td>
      <td align="left" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7" />
        <span class="respuestacolumna_rojo"><span class="rojopequeno">(TIPO F - L - B - J - K(contingente))</span></span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Nro Operacion Relacionada:</td>
      <td align="left" valign="middle"><input name="nro_operacion_relacionada" type="text" class="etiqueta12" id="nro_operacion_relacionada" size="15" maxlength="7" />
        <span class="respuestacolumna_rojo"><span class="rojopequeno">K(negociadas)</span></span></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><input name="button" type="submit" class="boton" id="button" value="Enviar" />
      <input name="button2" type="reset" class="boton" id="button2" value="Limpiar" /></td>
    </tr>
  </table>
</form>
<br />
<?php if ($totalRows_Recordset1 > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Ref Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Secuencia </td>
      <td align="center" valign="middle" class="titulocolumnas">Operación (K) Negociada</td>
      <td align="center" valign="middle" class="titulocolumnas">Producto</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Orto.</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Vcto.</td>
      <td align="center" valign="middle" class="titulocolumnas">Sucursal</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Monto Origen</td>
      <td align="center" valign="middle" class="titulocolumnas">Saldo Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_Recordset1['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_Recordset1['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_Recordset1['ref_cliente']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_Recordset1['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_Recordset1['secuencia']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_Recordset1['nro_operacion_relacionada']; ?></td>
        <td align="left" valign="middle"><?php echo $row_Recordset1['producto']; ?></td>
        <td align="center" valign="middle"><?php echo $row_Recordset1['fecha_otor']; ?></td>
        <td align="center" valign="middle"><?php echo $row_Recordset1['fecha_vcto']; ?></td>
        <td align="center" valign="middle"><?php echo $row_Recordset1['sucursal']; ?></td>
        <td align="center" valign="middle"><?php echo $row_Recordset1['moneda_operacion']; ?></td>
        <td align="right" valign="middle"><?php echo number_format(($row_Recordset1['monto_operacion'] / 100), 2, ',', '.'); ?></td>
        <td align="right" valign="middle"><?php echo number_format(($row_Recordset1['saldo_operacion'] / 100), 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
  </table>
  <br />
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">Primero</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Anterior</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Siguiente</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">Último</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br />
  Registros del <span class="respuestacolumna_azul"><?php echo ($startRow_Recordset1 + 1) ?></span> al <span class="respuestacolumna_azul"><?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?></span> de un total de <span class="respuestacolumna_azul"><?php echo $totalRows_Recordset1 ?></span> <br />
  <?php } // Show if recordset not empty ?>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../ni.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>