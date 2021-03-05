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

$colname_contesta_acumu = "-1";
if (isset($_GET['fecha_medicion'])) {
  $colname_contesta_acumu = $_GET['fecha_medicion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_contesta_acumu = sprintf("SELECT * FROM contestabilidad_acumulada WHERE fecha_medicion LIKE %s ORDER BY especialista_curse, fecha_medicion DESC", GetSQLValueString("%" . $colname_contesta_acumu . "%", "date"));
$contesta_acumu = mysqli_query($comercioexterior ,$query_contesta_acumu) or die(mysqli_error($comercioexterior));
$row_contesta_acumu = mysqli_fetch_assoc($contesta_acumu);
$totalRows_contesta_acumu = mysqli_num_rows($contesta_acumu);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contestabilidad Telefonica  Post Venta</title>
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
    <td width="79%" align="left" valign="middle"><span class="Estilo3"> </span><span class="Estilo3">CONTESTABILIDAD TELEFONICA POST VENTA</span></td>
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
      <td colspan="2" align="left" bgcolor="#999999" class="titulo_menu"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" />Contestabilidad Mensual</td>
    </tr>
    <tr>
      <td width="20%" align="right">Periodo Medicion:</td>
      <td width="80%" align="left"><select name="fecha_medicion" class="etiqueta12" id="fecha_medicion">
<option value=".">Seleccione un Periodo</option>
<option value="2015">2015</option>
<option value="2016">2016</option>
<option value="2017">2017</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input name="button" type="submit" class="boton" id="button" value="Buscar" /></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="../estadistica_operaciones.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_contesta_acumu > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="5" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Detalle Contestabilidad Meta 90%</td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Anexo</td>
      <td align="center" valign="middle" class="titulocolumnas">LLamadas Recibidas</td>
      <td align="center" valign="middle" class="titulocolumnas">% de Contestabilidad</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Medicion</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"><?php echo $row_contesta_acumu['especialista_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_contesta_acumu['anexo']; ?></td>
        <td align="center" valign="middle"><?php echo $row_contesta_acumu['ll_recibida']; ?>&nbsp; </td>
        <td align="right" valign="middle"><?php echo $row_contesta_acumu['pct_contesta']; ?> %</td>
        <td align="center" valign="middle"><?php echo $row_contesta_acumu['fecha_medicion']; ?>&nbsp; </td>
      </tr>
      <?php } while ($row_contesta_acumu = mysqli_fetch_assoc($contesta_acumu)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($contesta_acumu);
?>