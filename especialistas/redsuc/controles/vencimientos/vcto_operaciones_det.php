<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=vcto_operaciones_det.xls"); 
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

$colname_vcto_operaciones = "-1";
if (isset($_GET['ejecutivo_ni'])) {
  $colname_vcto_operaciones = $_GET['ejecutivo_ni'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_vcto_operaciones = sprintf("SELECT * FROM vctooperaciones nolock WHERE ejecutivo_ni = %s ORDER BY fecha_vcto ASC", GetSQLValueString($colname_vcto_operaciones, "text"));
$vcto_operaciones = mysql_query($query_vcto_operaciones, $comercioexterior) or die(mysqli_error());
$row_vcto_operaciones = mysqli_fetch_assoc($vcto_operaciones);
$totalRows_vcto_operaciones = mysqli_num_rows($vcto_operaciones);

mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "SELECT * FROM vctooperaciones nolock GROUP BY ejecutivo_ni";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vcto Operaciones</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url();
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php if ($totalRows_vcto_operaciones > 0) { // Show if recordset not empty ?>
  <span class="respuestacolumna_rojo"><?php echo number_format($totalRows_vcto_operaciones, 0, ',', '.') ?></span> <span class="respuestacolumna_azul">Registros Total <br />
  </span><br />
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Cuota</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda</td>
      <td align="center" valign="middle" class="titulocolumnas">Saldo Operacion</td>
      <td align="center" valign="middle" class="titulocolumnas">Tasa Fina Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha de Vcto</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Ejecutivo</td>
      <td align="center" valign="middle" class="titulocolumnas">Ejecutivo NI</td>
      <td align="center" valign="middle" class="titulocolumnas">Sucursal</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_vcto_operaciones['rut_cliente']; ?><a href="untitled.php?recordID=<?php echo $row_vcto_operaciones['sistema']; ?>"></a></td>
        <td align="left" valign="middle"><?php echo $row_vcto_operaciones['nombre_cliente']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_vcto_operaciones['nro_operacion']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_vcto_operaciones['secuencia']; ?></td>
        <td align="center" valign="middle"><?php echo $row_vcto_operaciones['moneda']; ?></td>
        <td align="right" valign="middle"><?php echo number_format($row_vcto_operaciones['saldo_vigente'], 2, ',', '.'); ?></td>
        <td align="center" valign="middle"><?php echo number_format($row_vcto_operaciones['tasa_final_cliente'], 6, ',', '.'); ?></td>
        <td align="center" valign="middle"><?php echo $row_vcto_operaciones['fecha_vcto']; ?></td>
        <td align="left" valign="middle"><?php echo $row_vcto_operaciones['nombre_ejecutivo']; ?></td>
        <td align="left" valign="middle"><?php echo $row_vcto_operaciones['ejecutivo_ni']; ?></td>
        <td align="left" valign="middle"><?php echo $row_vcto_operaciones['sucursal']; ?></td>
      </tr>
      <?php } while ($row_vcto_operaciones = mysqli_fetch_assoc($vcto_operaciones)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($vcto_operaciones);
mysqli_free_result($Recordset1);
?>