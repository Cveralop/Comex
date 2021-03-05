<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=opste_operaciones.xls"); 
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

$colname2_opste = "1";
if (isset($_GET['date_ini'])) {
  $colname2_opste = $_GET['date_ini'];
}
$colname3_opste = "1";
if (isset($_GET['date_fin'])) {
  $colname3_opste = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opste = sprintf("SELECT * FROM opste nolock WHERE date_ingreso between %s and %s", GetSQLValueString($colname2_opste, "date"),GetSQLValueString($colname3_opste, "date"));
$opste = mysqli_query($comercioexterior, $query_opste) or die(mysqli_error());
$row_opste = mysqli_fetch_assoc($opste);
$totalRows_opste = mysqli_num_rows($opste);
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
<table border="1" align="center">
  <tr>
    <td align="center" valign="middle">Nro Folio</td>
    <td align="center" valign="middle">Rut Cliente</td>
    <td align="center" valign="middle">Nombre Cliente</td>
    <td align="center" valign="middle">Fecha Ingreso Usuario</td>
    <td align="center" valign="middle">Fecha Ingreso Sistema</td>
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
      <td align="center" valign="middle"><?php echo $row_opste['id']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['nombre_cliente']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['date_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['evento']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['estado']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['fecha_curse']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['date_curse']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['asignador']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['operador']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['nro_operacion']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['obs']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['especialista_curse']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['moneda_operacion']; ?></td>
      <td align="right" valign="middle"><?php echo number_format($row_opste['monto_operacion'], 2, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['pagare']; ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['beneficiario']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['segmento']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['sub_estado']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['fecha_curse_inicial']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['periodisidad']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['cancelacion_total']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['vcto_operacion']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['iteraciones']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['date_preingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['date_espe']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['date_visa']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['date_asig']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['date_oper']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['date_supe']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['tipo_operacion']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['folio_boleta']; ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['estado_boleta']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['autorizador']); ?></td>
      <td align="left" valign="middle"><?php echo $row_opste['reparo_obs']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['estado_visacion']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['visador']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['excepcion']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['autorizacion_operaciones']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['autorizacion_especialista']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_opste['tipo_excepcion']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['solucion_excepcion']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['estado_excepcion']); ?></td>
      <td align="center" valign="middle"><?php echo $row_opste['solucionado']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['urgente']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_opste['fuera_horario']); ?></td>
    </tr>
    <?php } while ($row_opste = mysqli_fetch_assoc($opste)); ?>
</table>
<?php
mysqli_free_result($opste);
?>