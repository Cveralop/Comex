<?php require_once('../../../Connections/comercioexterior.php'); ?>
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
$maxRows_DetailRS1 = 100;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM openvpro  WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysqli_query($comercioexterior, $query_limit_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1);
  $totalRows_DetailRS1 = mysqli_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
$colname_fuerahorario = "redsuc";
if (isset($_GET['depto'])) {
  $colname_fuerahorario = $_GET['depto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_fuerahorario = sprintf("SELECT * FROM fuerahorario_redsuc WHERE depto = %s", GetSQLValueString($colname_fuerahorario, "text"));
$fuerahorario = mysqli_query($comercioexterior, $query_fuerahorario) or die(mysqli_error($comercioexterior));
$row_fuerahorario = mysqli_fetch_assoc($fuerahorario);
$totalRows_fuerahorario = mysqli_num_rows($fuerahorario);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Re-Impresion Caratula - Detalle</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	color: #000;
}
.Estilo9 {font-size: 24px; font-weight: bold; }
-->
</style>
<script> 
window.print(); 
</script>
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
<table width="95%"  border="0" align="center">
  <tr valign="middle">
    <td><img src="../../../imagenes/JPEG/logo_carta.JPG" alt="" width="190" height="65" align="left" />
      </div>
      </div></td>
  </tr>
  <tr valign="middle">
    <td align="right"><strong>
      <?php
setlocale(LC_TIME,'spanish'); 
echo strftime("Santiago, %d de %B de %Y");?>
    </strong></td>
  </tr>
</table>
<br />
<table width="95%"  border="0" align="center">
  <tr>
    <td align="center" valign="middle"><span class="Estilo9"> <strong><?php echo strtoupper($row_DetailRS1['tipo']); ?></strong> - OPERACIONES DE COMERCIO EXTERIOR</span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><?php if ($row_DetailRS1['especialista'] > $row_fuerahorario['fuera_horario']) { // Show if not first page ?>
      <span class="FueraHorario"><span class="Estilo13" >Operaci&oacute;n Ingresada FUERA DE HORARIO </span></span>
      <?php } // Show if not first page ?></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="impresionmae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr valign="middle">
    <td colspan="4" align="left"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><strong>Comprobante de Ingreso Instrucci&oacute;n Cliente</strong></td>
  </tr>
  <tr valign="middle">
    <td align="right">No. Folio:</td>
    <td align="center"><strong><?php echo strtoupper($row_DetailRS1['id']); ?></strong></td>
    <td align="right">Fecha Ingreso:</td>
    <td align="center"><strong><?php echo $row_DetailRS1['date_ing']; ?></strong></td>
  </tr>
  <tr valign="middle">
    <td width="20%" align="right">Rut Cliente:
      </div></td>
    <td colspan="3" align="left"><strong><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?></strong></td>
  </tr>
  <tr valign="middle">
    <td align="right">Nombre Cliente:
      </div></td>
    <td colspan="3" align="left"><strong><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></strong></td>
  </tr>
  <tr valign="middle">
    <td align="right">Evento:</td>
    <td colspan="3" align="left"><strong><?php echo $row_DetailRS1['evento']; ?></strong></td>
  </tr>
  <tr valign="middle">
    <td align="right">Especialista: </td>
    <td colspan="3" align="left"><strong><?php echo strtoupper($row_DetailRS1['territorial']); ?></strong></td>
  </tr>
  <tr valign="middle">
    <td align="right">Obsevaciones: </td>
    <td colspan="3" align="left"><strong><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></strong></td>
  </tr>
  <tr valign="middle">
    <td colspan="3" align="right">Pagare en original sin enmendaduras, corrector ni perforaciones, en custodia temporal de la sucursal: </td>
    <td align="center"><strong><?php echo $row_DetailRS1['pagare_original']; ?></strong></td>
  </tr>
  <tr valign="middle">
    <td colspan="3" align="right">Tiene la Firma del Cliente: </td>
    <td align="center" class="NegrillaCartaReparo"><strong><?php echo $row_DetailRS1['firma_cliente']; ?></strong></td>
  </tr>
  <tr valign="middle">
    <td colspan="3" align="right">Esta el V° B° y Timbre del Ejecutivo:</td>
    <td align="center" class="NegrillaCartaReparo"><strong><?php echo $row_DetailRS1['vb_ejecutivo']; ?></strong></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#000000">
  <tr>
    <td width="25%" align="right" valign="middle" bgcolor="#FFFFFF">Nombre Ejecutivo:</td>
    <td width="75%" align="left" valign="middle" bgcolor="#FFFFFF"><strong><?php echo $row_DetailRS1['nombre_ejecutivo']; ?></strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle" bgcolor="#FFFFFF">Especialista NI:</td>
    <td align="left" valign="middle" bgcolor="#FFFFFF"><strong><?php echo $row_DetailRS1['especialista']; ?></strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle" bgcolor="#FFFFFF">Ejecutivo NI:</td>
    <td align="left" valign="middle" bgcolor="#FFFFFF"><strong><?php echo $row_DetailRS1['ejecutivo']; ?></strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle" bgcolor="#FFFFFF">Territorial:</td>
    <td align="left" valign="middle" bgcolor="#FFFFFF"><strong><?php echo $row_DetailRS1['territorial']; ?></strong></td>
  </tr>
</table>
<br />
<br />
<br />
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="center" valign="middle">_______________________________________</td>
    <td align="center" valign="middle">_______________________________________</td>
  </tr>
  <tr>
    <td align="center" valign="middle">Firma y Timbre Administrativo Servicio al Cliente</td>
    <td align="center" valign="middle">Firma y Timbre Ejecutivo</td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
mysqli_free_result($fuerahorario);
?>