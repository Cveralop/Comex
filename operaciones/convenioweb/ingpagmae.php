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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_ingreso = 10;
$pageNum_ingreso = 0;
if (isset($_GET['pageNum_ingreso'])) {
  $pageNum_ingreso = $_GET['pageNum_ingreso'];
}
$startRow_ingreso = $pageNum_ingreso * $maxRows_ingreso;

$colname_ingreso = "xxx";
if (isset($_GET['rut_cliente'])) {
  $colname_ingreso = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ingreso = sprintf("SELECT * FROM cliente nolock WHERE rut_cliente = %s ORDER BY id DESC", GetSQLValueString($colname_ingreso, "text"));
$query_limit_ingreso = sprintf("%s LIMIT %d, %d", $query_ingreso, $startRow_ingreso, $maxRows_ingreso);
$ingreso = mysqli_query($comercioexterior, $query_limit_ingreso) or die(mysqli_error());
$row_ingreso = mysqli_fetch_assoc($ingreso);

if (isset($_GET['totalRows_ingreso'])) {
  $totalRows_ingreso = $_GET['totalRows_ingreso'];
} else {
  $all_ingreso = mysqli_query($comercioexterior, $query_ingreso);
  $totalRows_ingreso = mysqli_num_rows($all_ingreso);
}
$totalPages_ingreso = ceil($totalRows_ingreso/$maxRows_ingreso)-1;

$queryString_ingreso = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ingreso") == false && 
        stristr($param, "totalRows_ingreso") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ingreso = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ingreso = sprintf("&totalRows_ingreso=%d%s", $totalRows_ingreso, $queryString_ingreso);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso Convenio WEB - Maestro</title>
<style type="text/css">
<!--
@import url("../../estilos/estilo12.css");
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo6 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo9 {color: #FFFFFF; font-weight: bold; }
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
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO CONVENIO WEB- MAESTRO</td>
    <td width="7%" rowspan="2" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr align="left" valign="middle">
    <td class="Estilo4">COMERCIO EXTERIOR</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo6">Ingreso Convenio</span></td>
    </tr>
    <tr>
      <td width="19%" align="right" valign="middle">Rut Cliente:</td>
      <td width="81%" align="left" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="15" maxlength="12">
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr>
      <td colspan="2" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
     
      <input name="Submit2" type="reset" class="boton" value="Limpiar"></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_ingreso > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td><span class="Estilo9">Ingresar Pagar&eacute;</span></td>
    <td><span class="Estilo9">Rut Cliente</span></td>
    <td><span class="Estilo9">Nombre Cliente</span></td>
    </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="ingpagdet.php?recordID=<?php echo $row_ingreso['id']; ?>"> <img src="../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></td>
    <td align="center"><?php echo strtoupper($row_ingreso['rut_cliente']); ?></td>
    <td align="left"><?php echo strtoupper($row_ingreso['nombre_cliente']); ?></td>
    </tr>
  <?php } while ($row_ingreso = mysqli_fetch_assoc($ingreso)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_ingreso > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingreso=%d%s", $currentPage, 0, $queryString_ingreso); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_ingreso > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingreso=%d%s", $currentPage, max(0, $pageNum_ingreso - 1), $queryString_ingreso); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingreso < $totalPages_ingreso) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingreso=%d%s", $currentPage, min($totalPages_ingreso, $pageNum_ingreso + 1), $queryString_ingreso); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingreso < $totalPages_ingreso) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingreso=%d%s", $currentPage, $totalPages_ingreso, $queryString_ingreso); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_ingreso + 1) ?></strong> al <strong><?php echo min($startRow_ingreso + $maxRows_ingreso, $totalRows_ingreso) ?></strong> de un total de <strong><?php echo $totalRows_ingreso ?></strong>
<?php } // Show if recordset not empty ?> <br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image4" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($ingreso);
?>