<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php require_once('../../Connections/historico_goc.php'); ?>
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

$colname_consulta_excepciones = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_consulta_excepciones = $_GET['rut_cliente'];
}
mysqli_select_db($historico_goc, $database_historico_goc);
$query_consulta_excepciones = sprintf("SELECT * FROM excepciones nolock WHERE rut_cliente = %s ORDER BY id DESC", GetSQLValueString($colname_consulta_excepciones, "text"));
$consulta_excepciones = mysql_query($query_consulta_excepciones, $historico_goc) or die(mysqli_error());
$row_consulta_excepciones = mysqli_fetch_assoc($consulta_excepciones);
$totalRows_consulta_excepciones = mysqli_num_rows($consulta_excepciones);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consulta Excepciones - Maestro</title>
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
  <tr valign="middle">
    <td align="left" class="Estilo3">CONSULTA EXCEPCIONES  HISTORICAS - MAESTRO</td>
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
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Buscar Excepción por Rut Cliente</td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Rut Cliente:</td>
      <td width="79%" align="left" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="15" maxlength="17" />
        <span class="rojopequeno">(Sin puntos ni guión)</span></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><input name="button" type="submit" class="boton" id="button" value="Buscar" /></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="excepciones.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen5','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen5" width="80" height="25" border="0" id="Imagen5" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_consulta_excepciones > 0) { // Show if recordset not empty ?>
  <table border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="13" align="left" bgcolor="#999999" class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" />Rut Cliente <span class="titulocolumnas"><span class="tituloverde"><?php echo $row_consulta_excepciones['rut_cliente']; ?> </span></span>Nombre Cliente <span class="tituloverde"><?php echo $row_consulta_excepciones['nombre_cliente']; ?></span></td>
    </tr>
    <tr>
      <td class="titulocolumnas">Ver Excepción</td>
      <td class="titulocolumnas">Ejecutivo Ni</td>
      <td class="titulocolumnas">Especialista NI</td>
      <td class="titulocolumnas">Post Venta</td>
      <td class="titulocolumnas">Fecha Ingreso</td>
      <td class="titulocolumnas">Eento</td>
      <td class="titulocolumnas">Fecha Solución</td>
      <td class="titulocolumnas">Producto</td>
      <td class="titulocolumnas">Nro Operación / Nro OP. Relacionada</td>
      <td class="titulocolumnas">Observaciones</td>
      <td class="titulocolumnas">Moneda / Monto Excepción</td>
      <td class="titulocolumnas">Vcto Excepción</td>
      <td class="titulocolumnas">Estado Excepciones</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><a href="consulta_excepcionhistorica_det.php?recordID=<?php echo $row_consulta_excepciones['id']; ?>"><img src="../../imagenes/ICONOS/ver_registro_2.jpg" width="22" height="19" border="0" /></a></td>
        <td align="left" valign="middle"><?php echo $row_consulta_excepciones['ejecutivo_ni']; ?></td>
        <td align="left" valign="middle"><?php echo $row_consulta_excepciones['especialista_ni']; ?></td>
        <td align="left" valign="middle"><?php echo $row_consulta_excepciones['especialista_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_consulta_excepciones['fecha_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_consulta_excepciones['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_consulta_excepciones['fecha_solucion']; ?></td>
        <td align="left" valign="middle"><?php echo $row_consulta_excepciones['producto']; ?></td>
        <td align="center" valign="middle"><?php echo $row_consulta_excepciones['nro_operacion']; ?>&nbsp; / <?php echo $row_consulta_excepciones['nro_operacion_relacionada']; ?></td>
        <td align="left" valign="middle"><?php echo $row_consulta_excepciones['obs']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_consulta_excepciones['moneda_operacion']; ?></span>&nbsp; <span class="respuestacolumna_azul"><?php echo number_format($row_consulta_excepciones['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_consulta_excepciones['vcto_excepcion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_consulta_excepciones['estado_excepcion']; ?></td>
      </tr>
      <?php } while ($row_consulta_excepciones = mysqli_fetch_assoc($consulta_excepciones)); ?>
  </table>
  <br />
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_consulta_excepciones > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_consulta_excepciones=%d%s", $currentPage, 0, $queryString_consulta_excepciones); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_consulta_excepciones > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_consulta_excepciones=%d%s", $currentPage, max(0, $pageNum_consulta_excepciones - 1), $queryString_consulta_excepciones); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_consulta_excepciones < $totalPages_consulta_excepciones) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_consulta_excepciones=%d%s", $currentPage, min($totalPages_consulta_excepciones, $pageNum_consulta_excepciones + 1), $queryString_consulta_excepciones); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_consulta_excepciones < $totalPages_consulta_excepciones) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_consulta_excepciones=%d%s", $currentPage, $totalPages_consulta_excepciones, $queryString_consulta_excepciones); ?>">Último</a>
        <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br />
  Registros <span class="respuestacolumna_azul"><?php echo ($startRow_consulta_excepciones + 1) ?></span> a <span class="respuestacolumna_azul"><?php echo min($startRow_consulta_excepciones + $maxRows_consulta_excepciones, $totalRows_consulta_excepciones) ?></span> de <span class="respuestacolumna_azul"><?php echo $totalRows_consulta_excepciones ?></span><br />
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($consulta_excepciones);
?>