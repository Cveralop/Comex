<?php require_once('../../../../Connections/comercioexterior.php'); ?>
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

$colname_ingresotv = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname_ingresotv = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ingresotv = sprintf("SELECT * FROM oppre nolock WHERE nro_operacion = %s", GetSQLValueString($colname_ingresotv, "text"));
$ingresotv = mysql_query($query_ingresotv, $comercioexterior) or die(mysqli_error());
$row_ingresotv = mysqli_fetch_assoc($ingresotv);
$totalRows_ingresotv = mysqli_num_rows($ingresotv);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingreso Tasa Variable - Maestro</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
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
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO TASA VARIABLE  - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CONTROL PRESTAMOS STAND ALONE</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="subtitulopaguina"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" />Ingreso por Nro Operación</span></td>
    </tr>
    <tr>
      <td width="20%" align="right" valign="middle">Nro Operación:</td>
      <td width="80%" align="left" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="12" maxlength="7" />
        <span class="respuestacolumna_rojo">F000000</span></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><input name="button" type="submit" class="etiqueta12" id="button" value="Buscar Nro Operación " /></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td valign="middle" class="titulocolumnas">Ingreso Tasa Variable</td>
    <td valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td valign="middle" class="titulocolumnas">Nombre Cliente</td>
    <td valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td valign="middle" class="titulocolumnas">Nro Operacion</td>
    <td valign="middle" class="titulocolumnas">Evento</td>
    <td valign="middle" class="titulocolumnas">Moneda Operación / Monto Operación</td>
  </tr>
  <?php do { ?>
    <tr>
      <td valign="middle"><a href="ingresotvdet.php?recordID=<?php echo $row_ingresotv['id']; ?>"><img src="../../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0" align="middle" /></a></td>
      <td valign="middle"><?php echo $row_ingresotv['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_ingresotv['nombre_cliente']; ?></td>
      <td valign="middle"><?php echo $row_ingresotv['date_curse']; ?></td>
      <td valign="middle"><?php echo $row_ingresotv['nro_operacion']; ?></td>
      <td align="center" valign="middle"><?php echo $row_ingresotv['evento']; ?></td>
      <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_ingresotv['moneda_operacion']; ?></span>&nbsp; <span class="respuestacolumna_azul"><?php echo number_format($row_ingresotv['monto_operacion'], 2, ',', '.'); ?></span></td>
    </tr>
    <?php } while ($row_ingresotv = mysqli_fetch_assoc($ingresotv)); ?>
</table>
<br />
<table width="50%" border="0" align="center">
  <tr>
    <td><?php if ($pageNum_ingresotv > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingresotv=%d%s", $currentPage, 0, $queryString_ingresotv); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_ingresotv > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingresotv=%d%s", $currentPage, max(0, $pageNum_ingresotv - 1), $queryString_ingresotv); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_ingresotv < $totalPages_ingresotv) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingresotv=%d%s", $currentPage, min($totalPages_ingresotv, $pageNum_ingresotv + 1), $queryString_ingresotv); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_ingresotv < $totalPages_ingresotv) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingresotv=%d%s", $currentPage, $totalPages_ingresotv, $queryString_ingresotv); ?>">Último</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
<br />
Registros del <span class="respuestacolumna_azul"><?php echo ($startRow_ingresotv + 1) ?></span> al <span class="respuestacolumna_azul"><?php echo min($startRow_ingresotv + $maxRows_ingresotv, $totalRows_ingresotv) ?></span> de un total de <span class="respuestacolumna_azul"><?php echo $totalRows_ingresotv ?></span>
</body>
</html>
<?php
mysqli_free_result($ingresotv);
?>