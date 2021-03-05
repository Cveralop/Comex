<?php require_once('../../Connections/comercioexterior.php'); ?>
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

$colname_modificar = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_modificar = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_modificar = sprintf("SELECT * FROM convenioweb nolock WHERE rut_cliente = %s ORDER BY id DESC", GetSQLValueString($colname_modificar, "text"));
$modificar = mysqli_query($comercioexterior, $query_modificar) or die(mysqli_error());
$row_modificar = mysqli_fetch_assoc($modificar);
$totalRows_modificar = mysqli_num_rows($modificar);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Modificar Convenio WEB - Maestro</title>
<style type="text/css">
<!--
@import url("../../estilos/estilo12.css");
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo5 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 12px;
}
.Estilo8 {color: #FFFFFF; font-weight: bold; }
-->
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="95%" align="left" valign="middle" class="Estilo3">MODIFICAR CONVENIO WEB - MAESTRO</td>
    <td width="5%" rowspan="2" align="right" valign="middle" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">COMERCIO EXTERIOR</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Modificar Convenio WEB</span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Rut Cliente:</td>
      <td width="79%" align="left" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15">
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar"></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_modificar > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" bgcolor="#999999">
    <td valign="middle"><span class="Estilo8"><span class="respuestacolumna"><span class="titulocolumnas">Modificar Pagar&eacute;</span></span></span></td>
    <td valign="middle" class="titulocolumnas">Fecha Ingreso</td>
    <td valign="middle" class="titulocolumnas">Fecha Suscripci&oacute;n Pagar&eacute;</td>
    <td valign="middle" class="titulocolumnas">Fecha Suscripci&oacute;n Convenio</td>
    <td valign="middle" class="titulocolumnas">Fecha Vcto</td>
    <td valign="middle" class="titulocolumnas">Estado</td>
    <td valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td valign="middle" class="titulocolumnas">Nombre Cliente </td>
    <td valign="middle" class="titulocolumnas">Moneda / Monto Pagare</td>
    <td valign="middle" class="titulocolumnas">Moneda / Monto Convenio</td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center" valign="middle"><a href="modpagdet.php?recordID=<?php echo $row_modificar['id']; ?>"> <img src="../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></td>
    <td align="center" valign="middle" class="etiqueta12"><?php echo $row_modificar['fecha_ingreso']; ?></td>
    <td align="center" valign="middle"><?php echo $row_modificar['fecha_suscripcion_pagare']; ?></td>
    <td align="center" valign="middle"><?php echo $row_modificar['fecha_suscripcion_convenio']; ?></td>
    <td align="center" valign="middle" class="nroregistro"><?php echo $row_modificar['fecha_vcto']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_modificar['estado']); ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_modificar['rut_cliente']); ?> </td>
    <td align="left" valign="middle"><?php echo strtoupper($row_modificar['nombre_cliente']); ?> </td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_modificar['moneda_pagare']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_modificar['monto_pagare'], 2, ',', '.'); ?></span></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_modificar['moneda_convenio']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_modificar['monto_convenio'], 2, ',', '.'); ?></span></td>
  </tr>
  <?php } while ($row_modificar = mysqli_fetch_assoc($modificar)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_modificar > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, 0, $queryString_modificar); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_modificar > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, max(0, $pageNum_modificar - 1), $queryString_modificar); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_modificar < $totalPages_modificar) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, min($totalPages_modificar, $pageNum_modificar + 1), $queryString_modificar); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_modificar < $totalPages_modificar) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, $totalPages_modificar, $queryString_modificar); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_modificar + 1) ?></strong> al <strong><?php echo min($startRow_modificar + $maxRows_modificar, $totalRows_modificar) ?></strong> de un total de <strong><?php echo $totalRows_modificar ?></strong>
<?php } // Show if recordset not empty ?>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($modificar);
?>