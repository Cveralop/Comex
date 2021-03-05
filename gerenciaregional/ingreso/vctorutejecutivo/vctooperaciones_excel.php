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
$colname_Recordset1 = "-1";
if (isset($_GET['rut_ejecutivo'])) {
  $colname_Recordset1 = $_GET['rut_ejecutivo'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = sprintf("SELECT * FROM vctooperaciones WHERE rut_ejecutivo = %s ORDER BY fecha_vcto ASC", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vcto por Rut Ejecutivo - Archivo Excel</title>
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
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
</head>
<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="96%" align="left" valign="middle" class="Estilo3">VENCIMIENTO POR RUT EJECUTIVO - ARCHIVO EXCEL</td>
    <td width="4%" align="left" valign="middle"><span class="Estilo31"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></span></td>
  </tr>
</table>
<br />
<form action="detalle_vcto.php" method="get" name="form1" id="form1">
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
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td width="92%" align="left" valign="middle" class="respuestacolumna_rojo">(Las dudas y/o consultas debe dirigirlas a su Post - Venta)</td>
    <td width="8%" align="right" valign="middle"><a href="../../gerenciaregional.php"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen14" width="80" height="25" border="0" id="Imagen14" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>