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
$query_oppre = "SELECT *,SUM(opingresadas)as oping, SUM(opnorecibidas)as opnorec, SUM(oprecibidas)as oprec, SUM(cuotas_recibidas)as cuorec, SUM(cuotas_cursadas_ope)as cuocurope, SUM(cuotas_cursadas_sup)as cuocursup, SUM(urgente)as urg, SUM(fuera_horario)as fh FROM cuadro_mando_operaciones nolock WHERE producto = 'Prestamos Stand Alone' GROUP BY evento ORDER BY evento ASC";
$oppre = mysqli_query($comercioexterior, $query_oppre) or die(mysqli_error($comercioexterior));
$row_oppre = mysqli_fetch_assoc($oppre);
$totalRows_oppre = mysqli_num_rows($oppre);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcci = "SELECT *,SUM(opingresadas)as oping, SUM(opnorecibidas)as opnorec, SUM(oprecibidas)as oprec, SUM(cuotas_recibidas)as cuorec, SUM(cuotas_cursadas_ope)as cuocurope, SUM(cuotas_cursadas_sup)as cuocursup, SUM(urgente)as urg, SUM(fuera_horario)as fh FROM cuadro_mando_operaciones nolock WHERE producto = 'Carta de Credito Import' GROUP BY evento ORDER BY evento ASC";
$opcci = mysqli_query($comercioexterior, $query_opcci) or die(mysqli_error($comercioexterior));
$row_opcci = mysqli_fetch_assoc($opcci);
$totalRows_opcci = mysqli_num_rows($opcci);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcce = "SELECT *,SUM(opingresadas)as oping, SUM(opnorecibidas)as opnorec, SUM(oprecibidas)as oprec, SUM(cuotas_recibidas)as cuorec, SUM(cuotas_cursadas_ope)as cuocurope, SUM(cuotas_cursadas_sup)as cuocursup, SUM(urgente)as urg, SUM(fuera_horario)as fh FROM cuadro_mando_operaciones nolock WHERE producto = 'Carta de Credito Export' GROUP BY evento ORDER BY evento ASC";
$opcce = mysqli_query($comercioexterior, $query_opcce) or die(mysqli_error($comercioexterior));
$row_opcce = mysqli_fetch_assoc($opcce);
$totalRows_opcce = mysqli_num_rows($opcce);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcbi = "SELECT *,SUM(opingresadas)as oping, SUM(opnorecibidas)as opnorec, SUM(oprecibidas)as oprec, SUM(cuotas_recibidas)as cuorec, SUM(cuotas_cursadas_ope)as cuocurope, SUM(cuotas_cursadas_sup)as cuocursup, SUM(urgente)as urg, SUM(fuera_horario)as fh FROM cuadro_mando_operaciones nolock WHERE producto = 'Cobranza Extranjera de Import' GROUP BY evento ORDER BY evento ASC";
$opcbi = mysqli_query($comercioexterior, $query_opcbi) or die(mysqli_error($comercioexterior));
$row_opcbi = mysqli_fetch_assoc($opcbi);
$totalRows_opcbi = mysqli_num_rows($opcbi);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcbe = "SELECT *,SUM(opingresadas)as oping, SUM(opnorecibidas)as opnorec, SUM(oprecibidas)as oprec, SUM(cuotas_recibidas)as cuorec, SUM(cuotas_cursadas_ope)as cuocurope, SUM(cuotas_cursadas_sup)as cuocursup, SUM(urgente)as urg, SUM(fuera_horario)as fh FROM cuadro_mando_operaciones nolock WHERE producto = 'Cobranza Extranjera de Export' GROUP BY evento ORDER BY evento ASC";
$opcbe = mysqli_query($comercioexterior, $query_opcbe) or die(mysqli_error($comercioexterior));
$row_opcbe = mysqli_fetch_assoc($opcbe);
$totalRows_opcbe = mysqli_num_rows($opcbe);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opmec = "SELECT *,SUM(opingresadas)as oping, SUM(opnorecibidas)as opnorec, SUM(oprecibidas)as oprec, SUM(cuotas_recibidas)as cuorec, SUM(cuotas_cursadas_ope)as cuocurope, SUM(cuotas_cursadas_sup)as cuocursup, SUM(urgente)as urg, SUM(fuera_horario)as fh FROM cuadro_mando_operaciones nolock WHERE producto = 'Mercado Corredores' GROUP BY evento ORDER BY evento ASC";
$opmec = mysqli_query($comercioexterior, $query_opmec) or die(mysqli_error($comercioexterior));
$row_opmec = mysqli_fetch_assoc($opmec);
$totalRows_opmec = mysqli_num_rows($opmec);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_dl600 = "SELECT *,SUM(opingresadas)as oping, SUM(opnorecibidas)as opnorec, SUM(oprecibidas)as oprec, SUM(cuotas_recibidas)as cuorec, SUM(cuotas_cursadas_ope)as cuocurope, SUM(cuotas_cursadas_sup)as cuocursup, SUM(urgente)as urg, SUM(fuera_horario)as fh FROM cuadro_mando_operaciones nolock WHERE producto = 'DL600-CapXIII-CAPXIV' GROUP BY evento ORDER BY evento ASC";
$dl600 = mysqli_query($comercioexterior, $query_dl600) or die(mysqli_error($comercioexterior));
$row_dl600 = mysqli_fetch_assoc($dl600);
$totalRows_dl600 = mysqli_num_rows($dl600);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opste = "SELECT *,SUM(opingresadas)as oping, SUM(opnorecibidas)as opnorec, SUM(oprecibidas)as oprec, SUM(cuotas_recibidas)as cuorec, SUM(cuotas_cursadas_ope)as cuocurope, SUM(cuotas_cursadas_sup)as cuocursup, SUM(urgente)as urg, SUM(fuera_horario)as fh FROM cuadro_mando_operaciones nolock WHERE producto = 'L/C Stand By Emitida' GROUP BY evento ORDER BY evento ASC";
$opste = mysqli_query($comercioexterior, $query_opste) or die(mysqli_error($comercioexterior));
$row_opste = mysqli_fetch_assoc($opste);
$totalRows_opste = mysqli_num_rows($opste);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cuadro de Mando Operaciones</title>
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
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=60
var direccion='http://pdpto38:8303/comex/cuadromando/cuadromando_operaciones.php' 
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
</style></head>
<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="79%" align="left" valign="middle"><span class="Estilo3"> </span><span class="Estilo3">CUADRO DE MANDO OPERACIONES</span></td>
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
    <td align="right" valign="middle"><a href="cuadromando_postventa.php">VER CUADRO DE MANDO POST VENTA EN LINEA</a></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><a href="caratulas_pend_acu_recibo.php">VER CARATULAS GOC PENDIENTES DE ACUSE DE RECIBO</a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_oppre > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td width="15%" align="center" valign="middle" class="titulocolumnas">Producto</td>
      <td width="15%" align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Operaciones Ingresadas</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. No Recibidas x Operaciones</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. Recibidas x Operaciones</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. Cuotas Recibidas</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Operador</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Supervisor</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Urgente</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_oppre['producto']); ?></td>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_oppre['evento']); ?></td>
        <td align="center" valign="middle" class="Naranja2"><?php echo $row_oppre['oping']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_oppre['opnorec']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_oppre['oprec']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_oppre['cuorec']; ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_oppre['cuocurope']; ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_oppre['cuocursup']; ?></td>
        <td align="center" valign="middle" class="Rojo2"><?php echo $row_oppre['urg']; ?></td>
        <td align="center" valign="middle" class="Amarillo2"><?php echo $row_oppre['fh']; ?></td>
      </tr>
      <?php } while ($row_oppre = mysqli_fetch_assoc($oppre)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opmec > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td width="15%" align="center" valign="middle" class="titulocolumnas">Producto</td>
      <td width="15%" align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Operaciones Ingresadas</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. No Recibidas x Operaciones</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. Recibidas x Operaciones</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Recibidas</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Operador</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Supervisor</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Urgente</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_opmec['producto']); ?></td>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_opmec['evento']); ?></td>
        <td align="center" valign="middle" class="Naranja2"><?php echo $row_opmec['oping']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opmec['opnorec']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opmec['oprec']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opmec['cuorec']; ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_opmec['cuocurope']; ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_opmec['cuocursup']; ?></td>
        <td align="center" valign="middle" class="Rojo2"><?php echo $row_opmec['urg']; ?></td>
        <td align="center" valign="middle" class="Amarillo2"><?php echo $row_opmec['fh']; ?></td>
      </tr>
      <?php } while ($row_opmec = mysqli_fetch_assoc($opmec)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcci > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td width="15%" align="center" valign="middle" class="titulocolumnas">Producto</td>
      <td width="15%" align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Operaciones Ingresadas</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. No Recibidas x Operaciones</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. Recibidas x Operaciones</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Recibidas</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Operador</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Supervisor</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Urgente</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_opcci['producto']); ?></td>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_opcci['evento']); ?></td>
        <td align="center" valign="middle" class="Naranja2"><?php echo $row_opcci['oping']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opcci['opnorec']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opcci['oprec']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcci['cuorec']; ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_opcci['cuocurope']; ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_opcci['cuocursup']; ?></td>
        <td align="center" valign="middle" class="Rojo2"><?php echo $row_opcci['urg']; ?></td>
        <td align="center" valign="middle" class="Amarillo2"><?php echo $row_opcci['fh']; ?></td>
      </tr>
      <?php } while ($row_opcci = mysqli_fetch_assoc($opcci)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcbi > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td width="15%" align="center" valign="middle" class="titulocolumnas">Producto</td>
      <td width="15%" align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Operaciones Ingresadas</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. No Recibidas x Operaciones</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. Recibidas x Operaciones</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. Cuotas Recibidas</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Operador</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Supervisor</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Urgente</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_opcbi['producto']); ?></td>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_opcbi['evento']); ?></td>
        <td align="center" valign="middle" class="Naranja2"><?php echo $row_opcbi['oping']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opcbi['opnorec']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opcbi['oprec']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcbi['cuorec']; ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_opcbi['cuocurope']; ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_opcbi['cuocursup']; ?></td>
        <td align="center" valign="middle" class="Rojo2"><?php echo $row_opcbi['urg']; ?></td>
        <td align="center" valign="middle" class="Amarillo2"><?php echo $row_opcbi['fh']; ?></td>
      </tr>
      <?php } while ($row_opcbi = mysqli_fetch_assoc($opcbi)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcce > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td width="15%" align="center" valign="middle" class="titulocolumnas">Producto</td>
      <td width="15%" align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Operaciones Ingresadas</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. No Recibidas x Operaciones</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. Recibidas x Operaciones</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Recibidas</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Operador</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Supervisor</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Urgente</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_opcce['producto']); ?></td>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_opcce['evento']); ?></td>
        <td align="center" valign="middle" class="Naranja2"><?php echo $row_opcce['oping']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opcce['opnorec']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opcce['oprec']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcce['cuorec']; ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_opcce['cuocurope']; ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_opcce['cuocursup']; ?></td>
        <td align="center" valign="middle" class="Rojo2"><?php echo $row_opcce['urg']; ?></td>
        <td align="center" valign="middle" class="Amarillo2"><?php echo $row_opcce['fh']; ?></td>
      </tr>
      <?php } while ($row_opcce = mysqli_fetch_assoc($opcce)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcbe > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td width="15%" align="center" valign="middle" class="titulocolumnas">Producto</td>
      <td width="15%" align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Operaciones Ingresadas</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. No Recibidas x Operaciones</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. Recibidas x Operaciones</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Recibidas</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Operador</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Supervisor</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Urgente</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_opcbe['producto']); ?></td>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_opcbe['evento']); ?></td>
        <td align="center" valign="middle" class="Naranja2"><?php echo $row_opcbe['oping']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opcbe['opnorec']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opcbe['oprec']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcbe['cuorec']; ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_opcbe['cuocurope']; ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_opcbe['cuocursup']; ?></td>
        <td align="center" valign="middle" class="Rojo2"><?php echo $row_opcbe['urg']; ?></td>
        <td align="center" valign="middle" class="Amarillo2"><?php echo $row_opcbe['fh']; ?></td>
      </tr>
      <?php } while ($row_opcbe = mysqli_fetch_assoc($opcbe)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_dl600 > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td width="15%" align="center" valign="middle" class="titulocolumnas">Producto</td>
    <td width="15%" align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">Operaciones Ingresadas</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. No Recibidas x Operaciones</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. Recibidas x Operaciones</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Recibidas</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Operador</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Supervisor</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">Urgente</td>
    <td width="10%" align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_dl600['producto']); ?></td>
      <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_dl600['evento']); ?></td>
      <td align="center" valign="middle" class="Naranja2"><?php echo $row_dl600['oping']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_dl600['opnorec']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_dl600['oprec']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_dl600['cuorec']; ?></td>
      <td align="center" valign="middle" class="Verde2"><?php echo $row_dl600['cuocurope']; ?></td>
      <td align="center" valign="middle" class="Verde2"><?php echo $row_dl600['cuocursup']; ?></td>
      <td align="center" valign="middle" class="Rojo2"><?php echo $row_dl600['urg']; ?></td>
      <td align="center" valign="middle" class="Amarillo2"><?php echo $row_dl600['fh']; ?></td>
    </tr>
    <?php } while ($row_dl600 = mysqli_fetch_assoc($dl600)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opste > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td width="15%" align="center" valign="middle" class="titulocolumnas">Producto</td>
      <td width="15%" align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Operaciones Ingresadas</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. No Recibidas x Operaciones</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Op. Recibidas x Operaciones</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Recibidas</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Operador</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">No. de Cuotas Cursadas Supervisor</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Urgente</td>
      <td width="10%" align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_opste['producto']); ?></td>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo strtoupper($row_opste['evento']); ?></td>
        <td align="center" valign="middle" class="Naranja2"><?php echo $row_opste['oping']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opste['opnorec']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opste['oprec']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opste['cuorec']; ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_opste['cuocurope']; ?></td>
        <td align="center" valign="middle" class="Verde2"><?php echo $row_opste['cuocursup']; ?></td>
        <td align="center" valign="middle" class="Rojo2"><?php echo $row_opste['urg']; ?></td>
        <td align="center" valign="middle" class="Amarillo2"><?php echo $row_opste['fh']; ?></td>
      </tr>
      <?php } while ($row_opste = mysqli_fetch_assoc($opste)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($oppre);
mysqli_free_result($opcci);
mysqli_free_result($opcce);
mysqli_free_result($opcbi);
mysqli_free_result($opcbe);
mysqli_free_result($opmec);
mysqli_free_result($dl600);
mysqli_free_result($opste);
?>