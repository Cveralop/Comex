<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=control_bitacora_operaciones.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0");
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
$maxRows_modificacion = 10;
$pageNum_modificacion = 0;
if (isset($_GET['pageNum_modificacion'])) {
  $pageNum_modificacion = $_GET['pageNum_modificacion'];
}
$startRow_modificacion = $pageNum_modificacion * $maxRows_modificacion;
$colname2_modificacion = "Si";
if (isset($_GET['seguimiento'])) {
  $colname2_modificacion = $_GET['seguimiento'];
}
$colname4_modificacion = "Requerimiento.";
if (isset($_GET['evento'])) {
  $colname4_modificacion = $_GET['evento'];
}
$colname3_modificacion = "MSG-Swift.";
if (isset($_GET['evento'])) {
  $colname3_modificacion = $_GET['evento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_modificacion = sprintf("SELECT opcci.*,(usuarios.nombre)as ope, timestampdiff(day,date_ingreso,current_timestamp)as dias FROM opcci, usuarios WHERE seguimiento = %s  and (evento = %s or evento = %s) and (opcci.operador = usuarios.usuario) ORDER BY id DESC", GetSQLValueString($colname2_modificacion, "text"),GetSQLValueString($colname3_modificacion, "text"),GetSQLValueString($colname4_modificacion, "text"));
$query_limit_modificacion = sprintf("%s LIMIT %d, %d", $query_modificacion, $startRow_modificacion, $maxRows_modificacion);
$modificacion = mysqli_query($comercioexterior, $query_limit_modificacion) or die(mysqli_error());
$row_modificacion = mysqli_fetch_assoc($modificacion);
if (isset($_GET['totalRows_modificacion'])) {
  $totalRows_modificacion = $_GET['totalRows_modificacion'];
} else {
  $all_modificacion = mysqli_query($comercioexterior, $query_modificacion);
  $totalRows_modificacion = mysqli_num_rows($all_modificacion);
}
$totalPages_modificacion = ceil($totalRows_modificacion/$maxRows_modificacion)-1;
$queryString_modificacion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_modificacion") == false && 
        stristr($param, "totalRows_modificacion") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_modificacion = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_modificacion = sprintf("&totalRows_modificacion=%d%s", $totalRows_modificacion, $queryString_modificacion);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Vitacora MSG-Swift y Requerimientos - Maestro</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url();
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
.Estilo6 {color: #FFFFFF; font-weight: bold; }
.Estilo7 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo9 {color: #FFFFFF; font-weight: bold; font-size: 12px; }
-->
</style>
<script language="JavaScript" type="text/JavaScript">
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
</script>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body bgcolor="#FFFFFF">
<?php if ($totalRows_modificacion > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td align="center" valign="middle" bgcolor="#FFFFFF" class="mayuscula">Fecha Ingreso</td>
    <td align="center" valign="middle" bgcolor="#FFFFFF" class="mayuscula">Nro Operaci&oacute;n</td>
    <td align="center" valign="middle" bgcolor="#FFFFFF" class="mayuscula">Rut Cliente</td>
    <td align="center" valign="middle" bgcolor="#FFFFFF" class="mayuscula">Nombre Cliente</td>
    <td align="center" valign="middle" bgcolor="#FFFFFF" class="mayuscula">Evento</td>
    <td align="center" valign="middle" bgcolor="#FFFFFF" class="mayuscula">D&iacute;as</td>
    <td align="center" valign="middle" bgcolor="#FFFFFF" class="mayuscula">Operador</td>
    <td align="center" valign="middle" bgcolor="#FFFFFF" class="mayuscula">Observaciones / Seguimiento</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $row_modificacion['fecha_ingreso']; ?>      </div></td>
    <td align="center" valign="middle" bgcolor="#FFFFFF"><span class="respuestacolumna"><?php echo strtoupper($row_modificacion['nro_operacion']); ?></span> </div></td>
    <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo strtoupper($row_modificacion['rut_cliente']); ?></td>
    <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo strtoupper($row_modificacion['nombre_cliente']); ?></div></td>
    <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $row_modificacion['evento']; ?></td>
    <td align="center" valign="middle" bgcolor="#FFFFFF" class="respuestacolumna"><?php echo $row_modificacion['dias']; ?></td>
    <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo strtoupper($row_modificacion['ope']); ?></td>
    <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $row_modificacion['seg_obs']; ?></td>
  </tr>
  <?php } while ($row_modificacion = mysqli_fetch_assoc($modificacion)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($modificacion);
?>