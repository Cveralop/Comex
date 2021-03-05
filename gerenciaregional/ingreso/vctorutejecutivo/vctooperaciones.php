<?php require_once('../../../Connections/comercioexterior.php'); ?>
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
$colname_vcto_operaciones = "-1";
if (isset($_GET['rut_ejecutivo'])) {
  $colname_vcto_operaciones = $_GET['rut_ejecutivo'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_vcto_operaciones = sprintf("SELECT * FROM vctooperaciones WHERE rut_ejecutivo = %s ORDER BY fecha_vcto ASC", GetSQLValueString($colname_vcto_operaciones, "text"));
$vcto_operaciones = mysql_query($query_vcto_operaciones, $comercioexterior) or die(mysqli_error());
$row_vcto_operaciones = mysqli_fetch_assoc($vcto_operaciones);
$totalRows_vcto_operaciones = mysqli_num_rows($vcto_operaciones);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vcto por Rut Ejecutivo</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #F00;
	font-weight: bold;
}
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {color: #FFFFFF;
	font-weight: bold;
}
.Estilo16 {	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo31 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
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
<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="73%" align="left" valign="middle" class="Estilo3">VENCIMIENTO POR RUT EJECUTIVO</td>
    <td width="27%" align="left" valign="middle"><span class="Estilo31"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></span>      </div></td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulodetalle">Vcto Operaciones</span></td>
    </tr>
    <tr>
      <td width="22%" align="right" valign="middle" bgcolor="#CCCCCC">Rut Ejecutivo:</td>
      <td width="78%" align="left" valign="middle" bgcolor="#CCCCCC"><label>
        <input name="rut_ejecutivo" type="text" class="etiqueta12" id="rut_ejecutivo" size="17" maxlength="15" />
        <span class="rojopequeno">(Sin Puntos ni Guión)</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle" bgcolor="#CCCCCC"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar Operaciones" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td width="93%" align="left" valign="middle" class="respuestacolumna_rojo">(Todas las dudas y/o consultas debe dirigirlas a su Post - Venta)</td>
    <td width="7%" align="right" valign="middle"><a href="../../gerenciaregional.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen14','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen14" width="80" height="25" border="0" id="Imagen14" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_vcto_operaciones > 0) { // Show if recordset not empty ?>
  <span class="respuestacolumna_azul"><?php echo $totalRows_vcto_operaciones ?></span> Registros Total<br />
  <br />
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operación</td>
      <td align="center" valign="middle" class="titulocolumnas"> Nro Cuota</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Saldo Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Vcto</td>
      <td align="center" valign="middle" class="titulocolumnas">Ejecutivo NI</td>
      <td align="center" valign="middle" class="titulocolumnas">Post Venta</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_vcto_operaciones['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_vcto_operaciones['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_vcto_operaciones['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_vcto_operaciones['secuencia']; ?></td>
        <td align="center" valign="middle"><?php echo $row_vcto_operaciones['moneda']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_vcto_operaciones['saldo_vigente'], 2, ',', '.'); ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_vcto_operaciones['fecha_vcto']; ?></td>
        <td align="left" valign="middle"><?php echo $row_vcto_operaciones['ejecutivo_ni']; ?></td>
        <td align="left" valign="middle"><?php echo $row_vcto_operaciones['especialista_ni']; ?></td>
      </tr>
      <?php } while ($row_vcto_operaciones = mysqli_fetch_assoc($vcto_operaciones)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($vcto_operaciones);
?>