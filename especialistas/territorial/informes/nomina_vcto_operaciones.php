<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=vcto_operaciones.xls"); 
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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_devengonro = "SELECT * FROM vctooperaciones ORDER BY fecha_vcto ASC";
$devengonro = mysqli_query($comercioexterior, $query_devengonro) or die(mysqli_error());
$row_devengonro = mysqli_fetch_assoc($devengonro);
$totalRows_devengonro = mysqli_num_rows($devengonro);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vcto Operaciones</title>
<style type="text/css">
<!--
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #000;
}
body {
	background-image: url();
}
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
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
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
    <td bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
    <td bgcolor="#999999" class="titulocolumnas">Sucursal</td>
    <td bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
    <td bgcolor="#999999" class="titulocolumnas">Moneda</td>
    <td bgcolor="#999999" class="titulocolumnas">Saldo Operación</td>
    <td bgcolor="#999999" class="titulocolumnas">Vcto Operación</td>
    <td bgcolor="#999999" class="titulocolumnas">Cuota No.</td>
    <td bgcolor="#999999" class="titulocolumnas">Especilaista</td>
    <td bgcolor="#999999" class="titulocolumnas">Ejecutivo</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="right" valign="middle"><?php echo $row_devengonro['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_devengonro['nombre_cliente']; ?></td>
      <td align="center" valign="middle"><?php echo $row_devengonro['oficina']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_devengonro['nro_operacion']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_devengonro['moneda']; ?></td>
      <td align="right" valign="middle"><?php echo number_format($row_devengonro['saldo_vigente'], 2, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo $row_devengonro['fecha_vcto']; ?></td>
      <td align="center" valign="middle"><?php echo $row_devengonro['secuencia']; ?></td>
      <td align="left" valign="middle"><?php echo $row_devengonro['especialista_ni']; ?></td>
      <td align="left" valign="middle"><?php echo $row_devengonro['ejecutivo_ni']; ?></td>
    </tr>
    <?php } while ($row_devengonro = mysqli_fetch_assoc($devengonro)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($devengonro);
?>