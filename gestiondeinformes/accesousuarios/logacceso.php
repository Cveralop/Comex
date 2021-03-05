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

mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_accesouser = "SELECT controlacceso.*, count(controlacceso.id)as cantidad, max(fecha_acceso)as fecha_hora, (usuarios.nombre)as user FROM controlacceso INNER JOIN usuarios ON controlacceso.usuario=usuarios.usuario GROUP BY usuarios.nombre ORDER BY cantidad desc ";
$accesouser = mysqli_query($comercioexterior, $query_accesouser) or die(mysqli_error($comercioexterior));
$row_accesouser = mysqli_fetch_assoc($accesouser);
$totalRows_accesouser = mysqli_num_rows($accesouser);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Registro Acceso Usuarios</title>
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
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo10 {font-size: 12px}
.Estilo11 {color: #00FF00}
.Estilo13 {
	font-size: 12px;
	color: #FFFFFF;
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
<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">REGISTRO ACCESO USUARIOS</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">GESTI&Oacute;N DE MEDIOS</td>
  </tr>
</table>
<br>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Usuario</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Ultimo Acceso</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Cantidad</td>
  </tr>
  <?php do { ?>
    <tr class="respuestacolumna">
      <td align="left" valign="middle" bgcolor="#CCCCCC"><?php echo strtoupper($row_accesouser['user']); ?></td>
      <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo strtoupper($row_accesouser['fecha_hora']); ?></td>
      <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo number_format($row_accesouser['cantidad'], 0, ',', '.'); ?></td>
    </tr>
    <?php } while ($row_accesouser = mysqli_fetch_assoc($accesouser)); ?>
</table>
<br>
<?php echo $totalRows_accesouser ?> Registros Total

<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../gestiondeinformes.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image4" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($accesouser);
?>