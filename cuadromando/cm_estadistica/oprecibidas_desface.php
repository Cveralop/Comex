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

$colname_oprecibidas_desfase = "1";
if (isset($_GET['difing_difasig'])) {
  $colname_oprecibidas_desfase = $_GET['difing_difasig'];
}
$colname1_oprecibidas_desfase = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_oprecibidas_desfase = $_GET['date_ini'];
}
$colname2_oprecibidas_desfase = "-1";
if (isset($_GET['date_fin'])) {
  $colname2_oprecibidas_desfase = $_GET['date_fin'];
}
$colname3_oprecibidas_desfase = "N/A";
if (isset($_GET['especialista_curse'])) {
  $colname3_oprecibidas_desfase = $_GET['especialista_curse'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_oprecibidas_desfase = sprintf("SELECT *,MIN(date_curse)as fini, MAX(date_curse)as ffin FROM base_operaciones WHERE date_curse BETWEEN %s AND %s AND difing_difasig >= %s AND especialista_curse <> %s AND (evento = 'Apertura.' or evento = 'Prorroga.' or evento = 'Pago.' or evento = 'Prorroga y Pago.' or evento = 'Reestructuracion.' or evento = 'Redenominacion.' or evento = 'Modificacion.'  or evento = 'Alzamiento.' or evento = 'Confirmacion.' or evento = 'EMI.PLA.' or evento = 'LBTR.' or evento = 'LIQ.RET.' or evento = 'Enviar OP.' or evento = 'Op Recibida.' or evento = 'Compras.' or evento = 'Ventas.' or evento = 'Emision Cheque.' or evento = 'Arbitraje.' or evento = 'Liquidacion.' or evento = 'Planilla.' or evento = 'Remesa.') GROUP BY id ORDER BY difing_difasig DESC", GetSQLValueString($colname1_oprecibidas_desfase, "date"),GetSQLValueString($colname2_oprecibidas_desfase, "date"),GetSQLValueString($colname_oprecibidas_desfase, "int"),GetSQLValueString($colname3_oprecibidas_desfase, "text"));
$oprecibidas_desfase = mysql_query($query_oprecibidas_desfase, $comercioexterior) or die(mysqli_error());
$row_oprecibidas_desfase = mysqli_fetch_assoc($oprecibidas_desfase);
$totalRows_oprecibidas_desfase = mysqli_num_rows($oprecibidas_desfase);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>instrucciones Recibidas con Desfase</title>
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
-->
</style>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="79%" align="left" valign="middle"><span class="Estilo3"> </span><span class="Estilo3">INSTRUCCIONES RECIBIDAS CON DESFASE POR OPERACIONES</span></td>
    <td width="21%" align="right" valign="middle"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60">
      <param name="movie" value="../../imagenes/SWF/reloj_3.swf" />
      <param name="quality" value="high" />
      <embed src="../../imagenes/SWF/reloj_3.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="250" height="60"></embed>
    </object>
      </div></td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" />Instrucciones Recibidas con Desfase</td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Fecha Curse:</td>
      <td width="79%" align="left" valign="middle"><span class="respuestacolumna_rojo">Desde</span>
        <input name="date_ini" type="text" class="respuestacolumna" id="date_ini" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" /> 
      <span class="respuestacolumna_rojo">Hasta</span>        <input name="date_fin" type="text" class="etiqueta12" id="date_fin" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><input name="button" type="submit" class="boton" id="button" value="Buscar" /></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../estadistica_operaciones.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_oprecibidas_desfase > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="15" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" />Existen <span class="tituloverde"><?php echo $totalRows_oprecibidas_desfase ?></span> Operaciones Desde <span class="tituloverde"><?php echo $row_oprecibidas_desfase['fini']; ?></span> Hasta <span class="tituloverde"><?php echo $row_oprecibidas_desfase['ffin']; ?> </span></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Producto</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso Especialista</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Asignación Operaciones</td>
      <td align="center" valign="middle" class="titulocolumnas">Hrs Desfase</td>
      <td align="center" valign="middle" class="titulocolumnas">Urgente</td>
      <td align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo strtoupper($row_oprecibidas_desfase['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_oprecibidas_desfase['nombre_cliente']); ?></td>
        <td align="center" valign="middle"><?php echo $row_oprecibidas_desfase['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oprecibidas_desfase['date_curse']; ?></td>
        <td align="left" valign="middle"><?php echo $row_oprecibidas_desfase['evento']; ?></td>
        <td align="left" valign="middle"><?php echo $row_oprecibidas_desfase['estado']; ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_oprecibidas_desfase['especialista_curse']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_oprecibidas_desfase['producto']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_oprecibidas_desfase['nro_operacion']); ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_oprecibidas_desfase['moneda_operacion']; ?></span><span class="respuestacolumna_azul"> <?php echo number_format($row_oprecibidas_desfase['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_oprecibidas_desfase['date_espe']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oprecibidas_desfase['date_asig']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oprecibidas_desfase['difing_difasig']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oprecibidas_desfase['urgente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_oprecibidas_desfase['fuera_horario']; ?></td>
      </tr>
      <?php } while ($row_oprecibidas_desfase = mysqli_fetch_assoc($oprecibidas_desfase)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($oprecibidas_desfase);
?>