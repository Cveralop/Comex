<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=opbga_operaciones.xls"); 
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

$colname3_opbga = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opbga = $_GET['date_fin'];
}
$colname2_opbga = "1";
if (isset($_GET['date_fin'])) {
  $colname2_opbga = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opbga = sprintf("SELECT * FROM opbga nolock WHERE date_ingreso between %s and %s", GetSQLValueString($colname2_opbga, "date"),GetSQLValueString($colname3_opbga, "date"));
$opbga = mysqli_query($comercioexterior, $query_opbga) or die(mysqli_error());
$row_opbga = mysqli_fetch_assoc($opbga);
$totalRows_opbga = mysqli_num_rows($opbga);
?>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 9px;
	color: #000;
}
-->
</style>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<table border="1" align="center">
  <tr>
    <td align="center" valign="middle">Nro Folio</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Fecha Ingreso Usuario</td>
    <td align="center" valign="middle">Facha Ingreso Sistema</td>
    <td align="center" valign="middle">Evento</td>
    <td align="center" valign="middle">Estado Supervisor</td>
    <td align="center" valign="middle">Fecha Curse Usuario</td>
    <td align="center" valign="middle">Fecha Curse Sistema</td>
    <td align="center" valign="middle">Asignador</td>
    <td align="center" valign="middle">Operador</td>
    <td align="center" valign="middle">Nro Operaci&oacute;n</td>
    <td align="center" valign="middle">Observaciones</td>
    <td align="center" valign="middle">Especialista</td>
    <td align="center" valign="middle">Moneda Operaci&oacute;n</td>
    <td align="center" valign="middle">Monto Operaci&oacute;n</td>
    <td align="center" valign="middle">Pagar&eacute;</td>
    <td align="center" valign="middle">Benficiario</td>
    <td align="center" valign="middle">Segmento</td>
    <td align="center" valign="middle">Estado Operador</td>
    <td align="center" valign="middle">Fecha Inicio Periodo</td>
    <td align="center" valign="middle">Periodisidad</td>
    <td align="center" valign="middle">Cancelacion Total</td>
    <td align="center" valign="middle">Vcto Operaci&oacute;n</td>
    <td align="center" valign="middle">Cantidad de Iteraciones</td>
    <td align="center" valign="middle">Fecha Preingreso Especialista</td>
    <td align="center" valign="middle">Fecha Especialista</td>
    <td align="center" valign="middle">Fecha Visaci&oacute;n</td>
    <td align="center" valign="middle">Facha Asignaci&oacute;n</td>
    <td align="center" valign="middle">Facha Operador</td>
    <td align="center" valign="middle">Fecha  Supervisor</td>
    <td align="center" valign="middle">Tipo Operaci&oacute;n</td>
    <td align="center" valign="middle">Folio Boleta</td>
    <td align="center" valign="middle">Estado Boleta</td>
    <td align="center" valign="middle">Autorizador</td>
    <td align="center" valign="middle">Observaci&oacute;n Reparo</td>
    <td align="center" valign="middle">Espado Visador</td>
    <td align="center" valign="middle">Visador</td>
    <td align="center" valign="middle">Excepci&oacute;n</td>
    <td align="center" valign="middle">Autoriza Operaciones</td>
    <td align="center" valign="middle">Autoriza Negocio Internacional</td>
    <td align="center" valign="middle">Tipo de Excepci&oacute;n</td>
    <td align="center" valign="middle">Fecha Compromiso Soluci&oacute;n Excepci&oacute;n</td>
    <td align="center" valign="middle">Estado Excepci&oacute;n</td>
    <td align="center" valign="middle">Fecha Soluci&oacute;n Excepci&oacute;n</td>
    <td align="center" valign="middle">Urgente</td>
    <td align="center" valign="middle">Fuera Horario</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_opbga['id']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['nombre_cliente']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['date_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['evento']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['estado']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['fecha_curse']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['date_curse']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['asignador']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['operador']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['nro_operacion']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['obs']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['especialista_curse']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['moneda_operacion']; ?></td>
      <td align="right" valign="middle"><?php echo number_format($row_opbga['monto_operacion'], 2, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['pagare']; ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['beneficiario']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['segmento']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['sub_estado']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['fecha_curse_inicial']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['periodisidad']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['cancelacion_total']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['vcto_operacion']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['iteraciones']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['date_preingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['date_espe']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['date_visa']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['date_asig']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['date_oper']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['date_supe']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['tipo_operacion']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['folio_boleta']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['estado_boleta']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['autorizador']); ?></td>
      <td align="left" valign="middle"><?php echo $row_opbga['reparo_obs']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['estado_visacion']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['visador']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['excepcion']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['autorizacion_operaciones']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['autorizacion_especialista']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opbga['tipo_excepcion']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['solucion_excepcion']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['estado_excepcion']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opbga['solucionado']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['urgente']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opbga['fuera_horario']); ?></td>
    </tr>
    <?php } while ($row_opbga = mysqli_fetch_assoc($opbga)); ?>
</table>
<?php
mysqli_free_result($opbga);
?>