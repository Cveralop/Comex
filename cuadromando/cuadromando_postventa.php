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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opres = "SELECT *,SUM(opingresadas)as oping, SUM(oprecibidas)as oprec, SUM(opnorecibidas)as opnorec, SUM(opcursadas)as opcur, SUM(opreparadaspv)as opreppv, SUM(opreparadasop)as oprepop, SUM(urgente)as urg, SUM(fuera_horario)as fh, AVG(pct_contesta)as pro FROM cuadro_mando_postventa nolock GROUP BY especialista_curse ORDER BY SUM(opingresadas) DESC";
$opres = mysqli_query($comercioexterior, $query_opres) or die(mysqli_error($comercioexterior));
$row_opres = mysqli_fetch_assoc($opres);
$totalRows_opres = mysqli_num_rows($opres);

mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_prom = "SELECT AVG(pct_contesta)as pro FROM contestabilidad nolock WHERE pct_contesta > '0.01'";
$prom = mysqli_query($comercioexterior, $query_prom, ) or die(mysqli_error($comercioexterior));
$row_prom = mysqli_fetch_assoc($prom);
$totalRows_prom = mysqli_num_rows($prom);

$colname_opnorecibidas = "No";
if (isset($_GET['fuera_horario'])) {
  $colname_opnorecibidas = $_GET['fuera_horario'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opnorecibidas = sprintf("SELECT * FROM opnorecibidas nolock WHERE fuera_horario = %s ORDER BY tiempo DESC", GetSQLValueString($colname_opnorecibidas, "text"));
$opnorecibidas = mysqli_query($comercioexterior, $query_opnorecibidas) or die(mysqli_error($comercioexterior));
$row_opnorecibidas = mysqli_fetch_assoc($opnorecibidas);
$totalRows_opnorecibidas = mysqli_num_rows($opnorecibidas);

$colname_opnorecibidasfh = "Si";
if (isset($_GET['fuera_horario'])) {
  $colname_opnorecibidasfh = $_GET['fuera_horario'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opnorecibidasfh = sprintf("SELECT * FROM opnorecibidas nolock WHERE fuera_horario = %s ORDER BY tiempo DESC", GetSQLValueString($colname_opnorecibidasfh, "text"));
$opnorecibidasfh = mysqli_query($comercioexterior, $query_opnorecibidasfh) or die(mysqli_error($comercioexterior));
$row_opnorecibidasfh = mysqli_fetch_assoc($opnorecibidasfh);
$totalRows_opnorecibidasfh = mysqli_num_rows($opnorecibidasfh);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cuadro de Mando Post Venta</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../imagenes/JPEG/edificio_corporativo.jpg);
}
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
.titulo_menu_rojo {	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	color: #FFF;
	background-color: #F00;
	font-weight: bold;
}
-->
</style>
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=60
var direccion='http://pdpto38:8303/comex/cuadromando/cuadromando_postventa.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<link href="../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
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
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="79%" align="left" valign="middle"><span class="Estilo3"> </span><span class="Estilo3">CUADRO DE MANDO POST VENTA</span></td>
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
    <td align="right" valign="top"><a href="cuadromando_operaciones.php"> VER CUADRO DE MANDO OPERACIONES EN LINEA</a></td>
  </tr>
  <tr>
    <td align="right" valign="top"><a href="caratulas_pend_acu_recibo.php">VER CARATULAS GOC PENDIENTES DE ACUSE DE RECIBO</a><a href="cm_estadistica/estadistica_postventa_mae.php"></a></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td width="20%" align="center" valign="middle" class="titulocolumnas">Especialista</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. Ingresadas al GOC</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas"> Op. No Recibidas x Fabrica</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. Recibidas x Fabrica</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. Cursadas x Fabrica</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. Reparadas x Post Venta</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. Reparadas x Operaciones</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">OP. Urgente</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. Fuera Horario</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">% Contestabilidad</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_opres['especialista_curse']); ?></td>
    <td align="center" valign="middle" class="Azul2"><?php echo $row_opres['oping']; ?></td>
    <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opres['opnorec']; ?></td>
    <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opres['oprec']; ?></td>
    <td align="center" valign="middle" class="Verde2"><?php echo $row_opres['opcur']; ?></td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opres['opreppv']; ?></td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opres['oprepop']; ?></td>
    <td align="center" valign="middle" class="Rojo2"><?php echo $row_opres['urg']; ?></td>
    <td align="center" valign="middle" class="Amarillo2"><?php echo $row_opres['fh']; ?></td>
    <td align="center" valign="middle" class="Naranja2"><?php echo $row_opres['pct_contesta']; ?> %</td>
  </tr>
  <?php } while ($row_opres = mysqli_fetch_assoc($opres)); ?>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td height="17" align="right" valign="middle"><span class="respuestacolumna_azul">Contestabilidad Promedio:</span><span class="NegrillaCartaReparo"> <?php echo number_format($row_prom['pro'], 2, ',', '.'); ?></span></td>
  </tr>
</table>
<br />
<div id="CollapsiblePanel1" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0">Operaciones Recibidas con Desfase Dentro de Hora</div>
  <div class="CollapsiblePanelContent"><br />
    <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
      <tr>
        <td colspan="8" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Operaciones No Recibidas por Operaciones (<span class="tituloverde"><?php echo $totalRows_opnorecibidas ?></span>)</td>
      </tr>
      <tr>
        <td align="center" valign="middle" class="titulocolumnas">Nro Registro Origen</td>
        <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso Especialista</td>
        <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
        <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
        <td align="center" valign="middle" class="titulocolumnas">Evento</td>
        <td align="center" valign="middle" class="titulocolumnas">Especialista</td>
        <td align="center" valign="middle" class="titulocolumnas">Producto</td>
        <td align="center" valign="middle" class="titulocolumnas">Tiempo Transcurrido</td>
      </tr>
      <?php do { ?>
      <tr>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opnorecibidas['nro_registro']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opnorecibidas['date_espe']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opnorecibidas['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opnorecibidas['nombre_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opnorecibidas['evento']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opnorecibidas['especialista_curse']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opnorecibidas['producto']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opnorecibidas['tiempo']; ?></td>
      </tr>
      <?php } while ($row_opnorecibidas = mysqli_fetch_assoc($opnorecibidas)); ?>
    </table>
    <br />
  </div>
</div>
<br />
<br />
<div id="CollapsiblePanel2" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0">Operaciones Recibidas con Desfase Fuera de Hora</div>
  <div class="CollapsiblePanelContent"><br />
    <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
      <tr>
        <td colspan="8" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Operaciones No Recibidas por Operaciones (<span class="tituloverde"><?php echo $totalRows_opnorecibidasfh ?></span>)</td>
      </tr>
      <tr>
        <td align="center" valign="middle" class="titulocolumnas">Nro Registro Origen</td>
        <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso Especialista</td>
        <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
        <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
        <td align="center" valign="middle" class="titulocolumnas">Evento</td>
        <td align="center" valign="middle" class="titulocolumnas">Especialista</td>
        <td align="center" valign="middle" class="titulocolumnas">Producto</td>
        <td align="center" valign="middle" class="titulocolumnas">Tiempo Transcurrido</td>
      </tr>
      <?php do { ?>
      <tr>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opnorecibidasfh['nro_registro']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opnorecibidasfh['date_espe']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opnorecibidasfh['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opnorecibidasfh['nombre_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opnorecibidasfh['evento']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opnorecibidasfh['especialista_curse']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opnorecibidasfh['producto']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opnorecibidasfh['tiempo']; ?></td>
      </tr>
      <?php } while ($row_opnorecibidasfh = mysqli_fetch_assoc($opnorecibidasfh)); ?>
    </table>
    <br />
  </div>
</div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<script type="text/javascript">
<!--
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2", {contentIsOpen:false});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($opres);
mysqli_free_result($prom);
mysqli_free_result($opnorecibidas);
mysqli_free_result($opnorecibidasfh);
?>