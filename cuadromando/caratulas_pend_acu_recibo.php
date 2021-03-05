<?php require_once('../Connections/comercioexterior.php'); ?>
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

$colname_caratulas_pend = "Enviada a Proceso.";
if (isset($_GET['estado'])) {
  $colname_caratulas_pend = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_caratulas_pend = sprintf("SELECT * FROM openvpro WHERE estado = %s ORDER BY date_ing ASC", GetSQLValueString($colname_caratulas_pend, "text"));
$caratulas_pend = mysqli_query($comercioexterior, $query_caratulas_pend) or die(mysqli_error($comercioexterior));
$row_caratulas_pend = mysqli_fetch_assoc($caratulas_pend);
$totalRows_caratulas_pend = mysqli_num_rows($caratulas_pend);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Caratulas Pendientes de Acuse Recibo</title>
<style type="text/css">
<!--
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../imagenes/JPEG/edificio_corporativo.jpg);
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
<link href="../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="79%" align="left" valign="middle"><span class="Estilo3"> </span><span class="Estilo3">CARATULAS PENDIENTES DE ACUSE RECIBO</span></td>
    <td width="21%" align="right" valign="middle"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60">
      <param name="movie" value="../imagenes/SWF/reloj_3.swf" />
      <param name="quality" value="high" />
      <embed src="../imagenes/SWF/reloj_3.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="250" height="60"></embed>
    </object>
      </div></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="top"><a href="cuadromando_postventa.php">VER CUADRO DE MANDO POST VENTA EN LINEA</a><a href="cuadromando_operaciones.php"></a></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="11" align="left" valign="middle" bgcolor="#999999"><img src="../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulodetalle">Son </span><span class="tituloverde"><?php echo $totalRows_caratulas_pend ?></span><span class="titulodetalle"> Caratulas Pendientes de Acuse Recibo</span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Caratula</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Territorial</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Ejecutivo Cuenta</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Post Venta</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Ejecutivo NI</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Cod Suc</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Oficina</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_caratulas_pend['id']; ?></td>
      <td align="center" valign="middle"><?php echo $row_caratulas_pend['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_caratulas_pend['nombre_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_caratulas_pend['territorial']; ?></td>
      <td align="left" valign="middle"><?php echo $row_caratulas_pend['nombre_ejecutivo']; ?></td>
      <td align="left" valign="middle"><?php echo $row_caratulas_pend['especialista']; ?></td>
      <td align="left" valign="middle"><?php echo $row_caratulas_pend['ejecutivo']; ?></td>
      <td align="center" valign="middle"><?php echo $row_caratulas_pend['sucursal']; ?></td>
      <td align="left" valign="middle"><?php echo $row_caratulas_pend['oficina']; ?></td>
      <td align="center" valign="middle"><?php echo $row_caratulas_pend['date_ing']; ?></td>
      <td align="left" valign="middle"><?php echo $row_caratulas_pend['evento']; ?></td>
    </tr>
    <?php } while ($row_caratulas_pend = mysqli_fetch_assoc($caratulas_pend)); ?>
</table>
<br />
<br />
<br />
<br />
<br />
</body>
</html>
<?php
mysqli_free_result($caratulas_pend);
?>
