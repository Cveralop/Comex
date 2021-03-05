<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
  session_start();
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

$colname_cartareparo = "Reparada.";
if (isset($_GET['estado'])) {
  $colname_cartareparo = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cartareparo = sprintf("SELECT * FROM convenioweb nolock WHERE estado = %s ORDER BY id DESC", GetSQLValueString($colname_cartareparo, "text"));
$cartareparo = mysqli_query($comercioexterior, $query_cartareparo) or die(mysqli_error());
$row_cartareparo = mysqli_fetch_assoc($cartareparo);
$totalRows_cartareparo = mysqli_num_rows($cartareparo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Imprimir Carta Reparo Convenio WEB - Maestro</title>
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
var direccion='http://pdpto38:8303/comex/' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">IMPRIMIR CARTA REPARO CONVENIO  WEB- MAESTRO</td>
    <td width="7%" rowspan="2" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr align="left" valign="middle">
    <td class="Estilo4">COMERCIO EXTERIOR</td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="principal.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td class="titulocolumnas">Imprimir Carta</td>
    <td class="titulocolumnas">Fecha Ingreso</td>
    <td class="titulocolumnas">Rut Cliente</td>
    <td class="titulocolumnas">Nombre Cliente</td>
    <td class="titulocolumnas">Documento 1</td>
    <td class="titulocolumnas">Documento 2</td>
    <td class="titulocolumnas">Documento 3</td>
    <td class="titulocolumnas">Documento 4</td>
    <td class="titulocolumnas">Observacion Reparo</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="reparo_conveniowebdet.php?recordID=<?php echo $row_cartareparo['id']; ?>"><img src="../../imagenes/ICONOS/impresora_2.jpg" width="27" height="21" border="0" /></a></td>
      <td align="center" valign="middle"><?php echo $row_cartareparo['date_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_cartareparo['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_cartareparo['nombre_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_cartareparo['doc_1']; ?></td>
      <td align="left" valign="middle"><?php echo $row_cartareparo['doc_2']; ?></td>
      <td align="left" valign="middle"><?php echo $row_cartareparo['doc_3']; ?></td>
      <td align="left" valign="middle"><?php echo $row_cartareparo['doc_6']; ?></td>
      <td align="left" valign="middle"><?php echo $row_cartareparo['obs_reparo']; ?></td>
    </tr>
    <?php } while ($row_cartareparo = mysqli_fetch_assoc($cartareparo)); ?>
</table>
<br />
<table width="50%" border="0" align="center">
  <tr>
    <td><?php if ($pageNum_cartareparo > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_cartareparo=%d%s", $currentPage, 0, $queryString_cartareparo); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_cartareparo > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_cartareparo=%d%s", $currentPage, max(0, $pageNum_cartareparo - 1), $queryString_cartareparo); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_cartareparo < $totalPages_cartareparo) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_cartareparo=%d%s", $currentPage, min($totalPages_cartareparo, $pageNum_cartareparo + 1), $queryString_cartareparo); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_cartareparo < $totalPages_cartareparo) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_cartareparo=%d%s", $currentPage, $totalPages_cartareparo, $queryString_cartareparo); ?>">Último</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
<br />
Registros <?php echo ($startRow_cartareparo + 1) ?> a <?php echo min($startRow_cartareparo + $maxRows_cartareparo, $totalRows_cartareparo) ?> de <?php echo $totalRows_cartareparo ?>
</body>
</html>
<?php
mysqli_free_result($cartareparo);
?>