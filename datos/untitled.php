<?php require_once('../Connections/comercioexterior.php'); ?><?php
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

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opcci  WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table border="1" align="center">
  <tr>
    <td>id</td>
    <td><?php echo $row_DetailRS1['id']; ?></td>
  </tr>
  <tr>
    <td>rut_cliente</td>
    <td><?php echo $row_DetailRS1['rut_cliente']; ?></td>
  </tr>
  <tr>
    <td>nombre_cliente</td>
    <td><?php echo $row_DetailRS1['nombre_cliente']; ?></td>
  </tr>
  <tr>
    <td>fecha_ingreso</td>
    <td><?php echo $row_DetailRS1['fecha_ingreso']; ?></td>
  </tr>
  <tr>
    <td>date_ingreso</td>
    <td><?php echo $row_DetailRS1['date_ingreso']; ?></td>
  </tr>
  <tr>
    <td>evento</td>
    <td><?php echo $row_DetailRS1['evento']; ?></td>
  </tr>
  <tr>
    <td>estado</td>
    <td><?php echo $row_DetailRS1['estado']; ?></td>
  </tr>
  <tr>
    <td>fecha_curse</td>
    <td><?php echo $row_DetailRS1['fecha_curse']; ?></td>
  </tr>
  <tr>
    <td>date_curse</td>
    <td><?php echo $row_DetailRS1['date_curse']; ?></td>
  </tr>
  <tr>
    <td>asignador</td>
    <td><?php echo $row_DetailRS1['asignador']; ?></td>
  </tr>
  <tr>
    <td>operador</td>
    <td><?php echo $row_DetailRS1['operador']; ?></td>
  </tr>
  <tr>
    <td>producto</td>
    <td><?php echo $row_DetailRS1['producto']; ?></td>
  </tr>
  <tr>
    <td>nro_operacion</td>
    <td><?php echo $row_DetailRS1['nro_operacion']; ?></td>
  </tr>
  <tr>
    <td>nro_operacion_relacionada</td>
    <td><?php echo $row_DetailRS1['nro_operacion_relacionada']; ?></td>
  </tr>
  <tr>
    <td>obs</td>
    <td><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></td>
  </tr>
  <tr>
    <td>especialista</td>
    <td><?php echo $row_DetailRS1['especialista']; ?></td>
  </tr>
  <tr>
    <td>especialista_curse</td>
    <td><?php echo $row_DetailRS1['especialista_curse']; ?></td>
  </tr>
  <tr>
    <td>ejecutivo</td>
    <td><?php echo $row_DetailRS1['ejecutivo']; ?></td>
  </tr>
  <tr>
    <td>moneda_operacion</td>
    <td><?php echo $row_DetailRS1['moneda_operacion']; ?></td>
  </tr>
  <tr>
    <td>monto_operacion</td>
    <td><?php echo $row_DetailRS1['monto_operacion']; ?></td>
  </tr>
  <tr>
    <td>pais</td>
    <td><?php echo $row_DetailRS1['pais']; ?></td>
  </tr>
  <tr>
    <td>banco_destino</td>
    <td><?php echo $row_DetailRS1['banco_destino']; ?></td>
  </tr>
  <tr>
    <td>folio</td>
    <td><?php echo $row_DetailRS1['folio']; ?></td>
  </tr>
  <tr>
    <td>currier</td>
    <td><?php echo $row_DetailRS1['currier']; ?></td>
  </tr>
  <tr>
    <td>moneda_documentos</td>
    <td><?php echo $row_DetailRS1['moneda_documentos']; ?></td>
  </tr>
  <tr>
    <td>monto_documentos</td>
    <td><?php echo $row_DetailRS1['monto_documentos']; ?></td>
  </tr>
  <tr>
    <td>convenio</td>
    <td><?php echo $row_DetailRS1['convenio']; ?></td>
  </tr>
  <tr>
    <td>tipo_negociacion</td>
    <td><?php echo $row_DetailRS1['tipo_negociacion']; ?></td>
  </tr>
  <tr>
    <td>fecha_valija</td>
    <td><?php echo $row_DetailRS1['fecha_valija']; ?></td>
  </tr>
  <tr>
    <td>nro_sobre</td>
    <td><?php echo $row_DetailRS1['nro_sobre']; ?></td>
  </tr>
  <tr>
    <td>despacho_doctos</td>
    <td><?php echo $row_DetailRS1['despacho_doctos']; ?></td>
  </tr>
  <tr>
    <td>sucursal</td>
    <td><?php echo $row_DetailRS1['sucursal']; ?></td>
  </tr>
  <tr>
    <td>encargado_sucursal</td>
    <td><?php echo $row_DetailRS1['encargado_sucursal']; ?></td>
  </tr>
  <tr>
    <td>receptor</td>
    <td><?php echo $row_DetailRS1['receptor']; ?></td>
  </tr>
  <tr>
    <td>acuse_recibo</td>
    <td><?php echo $row_DetailRS1['acuse_recibo']; ?></td>
  </tr>
  <tr>
    <td>segmento</td>
    <td><?php echo $row_DetailRS1['segmento']; ?></td>
  </tr>
  <tr>
    <td>sub_estado</td>
    <td><?php echo $row_DetailRS1['sub_estado']; ?></td>
  </tr>
  <tr>
    <td>vi</td>
    <td><?php echo $row_DetailRS1['vi']; ?></td>
  </tr>
  <tr>
    <td>iteraciones</td>
    <td><?php echo $row_DetailRS1['iteraciones']; ?></td>
  </tr>
  <tr>
    <td>date_preingreso</td>
    <td><?php echo $row_DetailRS1['date_preingreso']; ?></td>
  </tr>
  <tr>
    <td>date_espe</td>
    <td><?php echo $row_DetailRS1['date_espe']; ?></td>
  </tr>
  <tr>
    <td>date_visa</td>
    <td><?php echo $row_DetailRS1['date_visa']; ?></td>
  </tr>
  <tr>
    <td>date_asig</td>
    <td><?php echo $row_DetailRS1['date_asig']; ?></td>
  </tr>
  <tr>
    <td>date_oper</td>
    <td><?php echo $row_DetailRS1['date_oper']; ?></td>
  </tr>
  <tr>
    <td>date_supe</td>
    <td><?php echo $row_DetailRS1['date_supe']; ?></td>
  </tr>
  <tr>
    <td>date_rec_doc_val</td>
    <td><?php echo $row_DetailRS1['date_rec_doc_val']; ?></td>
  </tr>
  <tr>
    <td>date_ent_doc_val</td>
    <td><?php echo $row_DetailRS1['date_ent_doc_val']; ?></td>
  </tr>
  <tr>
    <td>forward</td>
    <td><?php echo $row_DetailRS1['forward']; ?></td>
  </tr>
  <tr>
    <td>autorizador</td>
    <td><?php echo $row_DetailRS1['autorizador']; ?></td>
  </tr>
  <tr>
    <td>estado_reparo</td>
    <td><?php echo $row_DetailRS1['estado_reparo']; ?></td>
  </tr>
  <tr>
    <td>reparo_espe</td>
    <td><?php echo $row_DetailRS1['reparo_espe']; ?></td>
  </tr>
  <tr>
    <td>reparo_obs</td>
    <td><?php echo $row_DetailRS1['reparo_obs']; ?></td>
  </tr>
  <tr>
    <td>moneda_reparo</td>
    <td><?php echo $row_DetailRS1['moneda_reparo']; ?></td>
  </tr>
  <tr>
    <td>monto_reparo</td>
    <td><?php echo $row_DetailRS1['monto_reparo']; ?></td>
  </tr>
  <tr>
    <td>estado_visacion</td>
    <td><?php echo $row_DetailRS1['estado_visacion']; ?></td>
  </tr>
  <tr>
    <td>visador</td>
    <td><?php echo $row_DetailRS1['visador']; ?></td>
  </tr>
  <tr>
    <td>excepcion</td>
    <td><?php echo $row_DetailRS1['excepcion']; ?></td>
  </tr>
  <tr>
    <td>autorizacion_operaciones</td>
    <td><?php echo $row_DetailRS1['autorizacion_operaciones']; ?></td>
  </tr>
  <tr>
    <td>autorizacion_especialista</td>
    <td><?php echo $row_DetailRS1['autorizacion_especialista']; ?></td>
  </tr>
  <tr>
    <td>tipo_excepcion</td>
    <td><?php echo $row_DetailRS1['tipo_excepcion']; ?></td>
  </tr>
  <tr>
    <td>solucion_excepcion</td>
    <td><?php echo $row_DetailRS1['solucion_excepcion']; ?></td>
  </tr>
  <tr>
    <td>estado_excepcion</td>
    <td><?php echo $row_DetailRS1['estado_excepcion']; ?></td>
  </tr>
  <tr>
    <td>solucionado</td>
    <td><?php echo $row_DetailRS1['solucionado']; ?></td>
  </tr>
  <tr>
    <td>urgente</td>
    <td><?php echo $row_DetailRS1['urgente']; ?></td>
  </tr>
  <tr>
    <td>fuera_horario</td>
    <td><?php echo $row_DetailRS1['fuera_horario']; ?></td>
  </tr>
  <tr>
    <td>via_web</td>
    <td><?php echo $row_DetailRS1['via_web']; ?></td>
  </tr>
  <tr>
    <td>ope_doc_val</td>
    <td><?php echo $row_DetailRS1['ope_doc_val']; ?></td>
  </tr>
  <tr>
    <td>referencia</td>
    <td><?php echo $row_DetailRS1['referencia']; ?></td>
  </tr>
  <tr>
    <td>numero_neg</td>
    <td><?php echo $row_DetailRS1['numero_neg']; ?></td>
  </tr>
  <tr>
    <td>fecha_neg</td>
    <td><?php echo $row_DetailRS1['fecha_neg']; ?></td>
  </tr>
  <tr>
    <td>fecha_endoso</td>
    <td><?php echo $row_DetailRS1['fecha_endoso']; ?></td>
  </tr>
  <tr>
    <td>estado_doc</td>
    <td><?php echo $row_DetailRS1['estado_doc']; ?></td>
  </tr>
  <tr>
    <td>garantia</td>
    <td><?php echo $row_DetailRS1['garantia']; ?></td>
  </tr>
  <tr>
    <td>can1</td>
    <td><?php echo $row_DetailRS1['can1']; ?></td>
  </tr>
  <tr>
    <td>can2</td>
    <td><?php echo $row_DetailRS1['can2']; ?></td>
  </tr>
  <tr>
    <td>can3</td>
    <td><?php echo $row_DetailRS1['can3']; ?></td>
  </tr>
  <tr>
    <td>can4</td>
    <td><?php echo $row_DetailRS1['can4']; ?></td>
  </tr>
  <tr>
    <td>can5</td>
    <td><?php echo $row_DetailRS1['can5']; ?></td>
  </tr>
  <tr>
    <td>can6</td>
    <td><?php echo $row_DetailRS1['can6']; ?></td>
  </tr>
  <tr>
    <td>can7</td>
    <td><?php echo $row_DetailRS1['can7']; ?></td>
  </tr>
  <tr>
    <td>can8</td>
    <td><?php echo $row_DetailRS1['can8']; ?></td>
  </tr>
  <tr>
    <td>can9</td>
    <td><?php echo $row_DetailRS1['can9']; ?></td>
  </tr>
  <tr>
    <td>can10</td>
    <td><?php echo $row_DetailRS1['can10']; ?></td>
  </tr>
  <tr>
    <td>can11</td>
    <td><?php echo $row_DetailRS1['can11']; ?></td>
  </tr>
  <tr>
    <td>can12</td>
    <td><?php echo $row_DetailRS1['can12']; ?></td>
  </tr>
  <tr>
    <td>can13</td>
    <td><?php echo $row_DetailRS1['can13']; ?></td>
  </tr>
  <tr>
    <td>can14</td>
    <td><?php echo $row_DetailRS1['can14']; ?></td>
  </tr>
  <tr>
    <td>can15</td>
    <td><?php echo $row_DetailRS1['can15']; ?></td>
  </tr>
  <tr>
    <td>can16</td>
    <td><?php echo $row_DetailRS1['can16']; ?></td>
  </tr>
  <tr>
    <td>can17</td>
    <td><?php echo $row_DetailRS1['can17']; ?></td>
  </tr>
  <tr>
    <td>can18</td>
    <td><?php echo $row_DetailRS1['can18']; ?></td>
  </tr>
  <tr>
    <td>can19</td>
    <td><?php echo $row_DetailRS1['can19']; ?></td>
  </tr>
  <tr>
    <td>can20</td>
    <td><?php echo $row_DetailRS1['can20']; ?></td>
  </tr>
  <tr>
    <td>doc1</td>
    <td><?php echo $row_DetailRS1['doc1']; ?></td>
  </tr>
  <tr>
    <td>doc2</td>
    <td><?php echo $row_DetailRS1['doc2']; ?></td>
  </tr>
  <tr>
    <td>doc3</td>
    <td><?php echo $row_DetailRS1['doc3']; ?></td>
  </tr>
  <tr>
    <td>doc4</td>
    <td><?php echo $row_DetailRS1['doc4']; ?></td>
  </tr>
  <tr>
    <td>doc5</td>
    <td><?php echo $row_DetailRS1['doc5']; ?></td>
  </tr>
  <tr>
    <td>doc6</td>
    <td><?php echo $row_DetailRS1['doc6']; ?></td>
  </tr>
  <tr>
    <td>doc7</td>
    <td><?php echo $row_DetailRS1['doc7']; ?></td>
  </tr>
  <tr>
    <td>doc8</td>
    <td><?php echo $row_DetailRS1['doc8']; ?></td>
  </tr>
  <tr>
    <td>doc9</td>
    <td><?php echo $row_DetailRS1['doc9']; ?></td>
  </tr>
  <tr>
    <td>doc10</td>
    <td><?php echo $row_DetailRS1['doc10']; ?></td>
  </tr>
  <tr>
    <td>recibido_por</td>
    <td><?php echo $row_DetailRS1['recibido_por']; ?></td>
  </tr>
  <tr>
    <td>entregado_por</td>
    <td><?php echo $row_DetailRS1['entregado_por']; ?></td>
  </tr>
</table>

</body>
</html><?php
mysqli_free_result($DetailRS1);
?>