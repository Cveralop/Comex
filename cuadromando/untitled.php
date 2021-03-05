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
$query_DetailRS1 = sprintf("SELECT * FROM trasabilidad WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$colname_DetailRS2 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS2 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS2 = sprintf("SELECT * FROM trasabilidad WHERE id = %s", GetSQLValueString($colname_DetailRS2, "int"));
$DetailRS2 = mysqli_query($comercioexterior, $query_DetailRS2) or die(mysqli_error($comercioexterior));
$row_DetailRS2 = mysqli_fetch_assoc($DetailRS2);
$totalRows_DetailRS2 = mysqli_num_rows($DetailRS2);

$colname_DetailRS2 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS2 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS2 = sprintf("SELECT * FROM trasabilidad WHERE id = %s", GetSQLValueString($colname_DetailRS2, "int"));
$DetailRS2 = mysqli_query($comercioexterior, $query_DetailRS2) or die(mysqli_error($comercioexterior));
$row_DetailRS2 = mysqli_fetch_assoc($DetailRS2);
$totalRows_DetailRS2 = mysqli_num_rows($DetailRS2);

$colname_DetailRS3 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS3 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS3 = sprintf("SELECT * FROM trasabilidad WHERE id = %s", GetSQLValueString($colname_DetailRS3, "int"));
$DetailRS3 = mysqli_query($comercioexterior, $query_DetailRS3) or die(mysqli_error($comercioexterior));
$row_DetailRS3 = mysqli_fetch_assoc($DetailRS3);
$totalRows_DetailRS3 = mysqli_num_rows($DetailRS3);

$colname_DetailRS3 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS3 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS3 = sprintf("SELECT * FROM trasabilidad WHERE id = %s", GetSQLValueString($colname_DetailRS3, "int"));
$DetailRS3 = mysqli_query($comercioexterior, $query_DetailRS3) or die(mysqli_error($comercioexterior));
$row_DetailRS3 = mysqli_fetch_assoc($DetailRS3);
$totalRows_DetailRS3 = mysqli_num_rows($DetailRS3);

$colname_DetailRS4 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS4 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS4 = sprintf("SELECT * FROM trasabilidad WHERE id = %s", GetSQLValueString($colname_DetailRS4, "int"));
$DetailRS4 = mysqli_query($comercioexterior, $query_DetailRS4) or die(mysqli_error($comercioexterior));
$row_DetailRS4 = mysqli_fetch_assoc($DetailRS4);
$totalRows_DetailRS4 = mysqli_num_rows($DetailRS4);

$colname_DetailRS5 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS5 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS5 = sprintf("SELECT * FROM openvpro  WHERE id = %s", GetSQLValueString($colname_DetailRS5, "int"));
$DetailRS5 = mysqli_query($comercioexterior, $query_DetailRS5) or die(mysqli_error($comercioexterior));
$row_DetailRS5 = mysqli_fetch_assoc($DetailRS5);
$totalRows_DetailRS5 = mysqli_num_rows($DetailRS5);
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
    <td>producto</td>
    <td><?php echo $row_DetailRS1['producto']; ?></td>
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
    <td>date_ing</td>
    <td><?php echo $row_DetailRS1['date_ing']; ?></td>
  </tr>
  <tr>
    <td>date_espe</td>
    <td><?php echo $row_DetailRS1['date_espe']; ?></td>
  </tr>
  <tr>
    <td>minimo</td>
    <td><?php echo $row_DetailRS1['minimo']; ?></td>
  </tr>
  <tr>
    <td>maximo</td>
    <td><?php echo $row_DetailRS1['maximo']; ?></td>
  </tr>
  <tr>
    <td>promedio</td>
    <td><?php echo $row_DetailRS1['promedio']; ?></td>
  </tr>
</table>
<table border="1" align="center">
  <tr>
    <td>id</td>
    <td><?php echo $row_DetailRS2['id']; ?></td>
  </tr>
  <tr>
    <td>producto</td>
    <td><?php echo $row_DetailRS2['producto']; ?></td>
  </tr>
  <tr>
    <td>evento</td>
    <td><?php echo $row_DetailRS2['evento']; ?></td>
  </tr>
  <tr>
    <td>estado</td>
    <td><?php echo $row_DetailRS2['estado']; ?></td>
  </tr>
  <tr>
    <td>date_ing</td>
    <td><?php echo $row_DetailRS2['date_ing']; ?></td>
  </tr>
  <tr>
    <td>date_espe</td>
    <td><?php echo $row_DetailRS2['date_espe']; ?></td>
  </tr>
  <tr>
    <td>minimo</td>
    <td><?php echo $row_DetailRS2['minimo']; ?></td>
  </tr>
  <tr>
    <td>maximo</td>
    <td><?php echo $row_DetailRS2['maximo']; ?></td>
  </tr>
  <tr>
    <td>promedio</td>
    <td><?php echo $row_DetailRS2['promedio']; ?></td>
  </tr>
</table>
<table border="1" align="center">
  <tr>
    <td>id</td>
    <td><?php echo $row_DetailRS2['id']; ?></td>
  </tr>
  <tr>
    <td>producto</td>
    <td><?php echo $row_DetailRS2['producto']; ?></td>
  </tr>
  <tr>
    <td>evento</td>
    <td><?php echo $row_DetailRS2['evento']; ?></td>
  </tr>
  <tr>
    <td>estado</td>
    <td><?php echo $row_DetailRS2['estado']; ?></td>
  </tr>
  <tr>
    <td>date_ing</td>
    <td><?php echo $row_DetailRS2['date_ing']; ?></td>
  </tr>
  <tr>
    <td>date_espe</td>
    <td><?php echo $row_DetailRS2['date_espe']; ?></td>
  </tr>
  <tr>
    <td>minimo</td>
    <td><?php echo $row_DetailRS2['minimo']; ?></td>
  </tr>
  <tr>
    <td>maximo</td>
    <td><?php echo $row_DetailRS2['maximo']; ?></td>
  </tr>
  <tr>
    <td>promedio</td>
    <td><?php echo $row_DetailRS2['promedio']; ?></td>
  </tr>
</table>
<table border="1" align="center">
  <tr>
    <td>id</td>
    <td><?php echo $row_DetailRS3['id']; ?></td>
  </tr>
  <tr>
    <td>producto</td>
    <td><?php echo $row_DetailRS3['producto']; ?></td>
  </tr>
  <tr>
    <td>evento</td>
    <td><?php echo $row_DetailRS3['evento']; ?></td>
  </tr>
  <tr>
    <td>estado</td>
    <td><?php echo $row_DetailRS3['estado']; ?></td>
  </tr>
  <tr>
    <td>date_ing</td>
    <td><?php echo $row_DetailRS3['date_ing']; ?></td>
  </tr>
  <tr>
    <td>date_espe</td>
    <td><?php echo $row_DetailRS3['date_espe']; ?></td>
  </tr>
  <tr>
    <td>minimo</td>
    <td><?php echo $row_DetailRS3['minimo']; ?></td>
  </tr>
  <tr>
    <td>maximo</td>
    <td><?php echo $row_DetailRS3['maximo']; ?></td>
  </tr>
  <tr>
    <td>promedio</td>
    <td><?php echo $row_DetailRS3['promedio']; ?></td>
  </tr>
</table>
<table border="1" align="center">
  <tr>
    <td>id</td>
    <td><?php echo $row_DetailRS3['id']; ?></td>
  </tr>
  <tr>
    <td>producto</td>
    <td><?php echo $row_DetailRS3['producto']; ?></td>
  </tr>
  <tr>
    <td>evento</td>
    <td><?php echo $row_DetailRS3['evento']; ?></td>
  </tr>
  <tr>
    <td>estado</td>
    <td><?php echo $row_DetailRS3['estado']; ?></td>
  </tr>
  <tr>
    <td>date_ing</td>
    <td><?php echo $row_DetailRS3['date_ing']; ?></td>
  </tr>
  <tr>
    <td>date_espe</td>
    <td><?php echo $row_DetailRS3['date_espe']; ?></td>
  </tr>
  <tr>
    <td>minimo</td>
    <td><?php echo $row_DetailRS3['minimo']; ?></td>
  </tr>
  <tr>
    <td>maximo</td>
    <td><?php echo $row_DetailRS3['maximo']; ?></td>
  </tr>
  <tr>
    <td>promedio</td>
    <td><?php echo $row_DetailRS3['promedio']; ?></td>
  </tr>
</table>
<table border="1" align="center">
  <tr>
    <td>id</td>
    <td><?php echo $row_DetailRS4['id']; ?></td>
  </tr>
  <tr>
    <td>producto</td>
    <td><?php echo $row_DetailRS4['producto']; ?></td>
  </tr>
  <tr>
    <td>evento</td>
    <td><?php echo $row_DetailRS4['evento']; ?></td>
  </tr>
  <tr>
    <td>estado</td>
    <td><?php echo $row_DetailRS4['estado']; ?></td>
  </tr>
  <tr>
    <td>date_ing</td>
    <td><?php echo $row_DetailRS4['date_ing']; ?></td>
  </tr>
  <tr>
    <td>date_espe</td>
    <td><?php echo $row_DetailRS4['date_espe']; ?></td>
  </tr>
  <tr>
    <td>minimo</td>
    <td><?php echo $row_DetailRS4['minimo']; ?></td>
  </tr>
  <tr>
    <td>maximo</td>
    <td><?php echo $row_DetailRS4['maximo']; ?></td>
  </tr>
  <tr>
    <td>promedio</td>
    <td><?php echo $row_DetailRS4['promedio']; ?></td>
  </tr>
</table>
<table border="1" align="center">
  <tr>
    <td>id</td>
    <td><?php echo $row_DetailRS5['id']; ?></td>
  </tr>
  <tr>
    <td>rut_cliente</td>
    <td><?php echo $row_DetailRS5['rut_cliente']; ?></td>
  </tr>
  <tr>
    <td>nombre_cliente</td>
    <td><?php echo $row_DetailRS5['nombre_cliente']; ?></td>
  </tr>
  <tr>
    <td>territorial</td>
    <td><?php echo $row_DetailRS5['territorial']; ?></td>
  </tr>
  <tr>
    <td>nombre_ejecutivo</td>
    <td><?php echo $row_DetailRS5['nombre_ejecutivo']; ?></td>
  </tr>
  <tr>
    <td>especialista</td>
    <td><?php echo $row_DetailRS5['especialista']; ?></td>
  </tr>
  <tr>
    <td>ejecutivo</td>
    <td><?php echo $row_DetailRS5['ejecutivo']; ?></td>
  </tr>
  <tr>
    <td>sucursal</td>
    <td><?php echo $row_DetailRS5['sucursal']; ?></td>
  </tr>
  <tr>
    <td>oficina</td>
    <td><?php echo $row_DetailRS5['oficina']; ?></td>
  </tr>
  <tr>
    <td>oficina_ingreso</td>
    <td><?php echo $row_DetailRS5['oficina_ingreso']; ?></td>
  </tr>
  <tr>
    <td>date_ingreso</td>
    <td><?php echo $row_DetailRS5['date_ingreso']; ?></td>
  </tr>
  <tr>
    <td>date_ing</td>
    <td><?php echo $row_DetailRS5['date_ing']; ?></td>
  </tr>
  <tr>
    <td>tipo</td>
    <td><?php echo $row_DetailRS5['tipo']; ?></td>
  </tr>
  <tr>
    <td>evento</td>
    <td><?php echo $row_DetailRS5['evento']; ?></td>
  </tr>
  <tr>
    <td>estado</td>
    <td><?php echo $row_DetailRS5['estado']; ?></td>
  </tr>
  <tr>
    <td>obs</td>
    <td><?php echo $row_DetailRS5['obs']; ?></td>
  </tr>
  <tr>
    <td>date_recibo</td>
    <td><?php echo $row_DetailRS5['date_recibo']; ?></td>
  </tr>
  <tr>
    <td>date_rec</td>
    <td><?php echo $row_DetailRS5['date_rec']; ?></td>
  </tr>
  <tr>
    <td>pagare_original</td>
    <td><?php echo $row_DetailRS5['pagare_original']; ?></td>
  </tr>
  <tr>
    <td>firma_cliente</td>
    <td><?php echo $row_DetailRS5['firma_cliente']; ?></td>
  </tr>
  <tr>
    <td>vb_ejecutivo</td>
    <td><?php echo $row_DetailRS5['vb_ejecutivo']; ?></td>
  </tr>
  <tr>
    <td>fuera_horario</td>
    <td><?php echo $row_DetailRS5['fuera_horario']; ?></td>
  </tr>
  <tr>
    <td>estado_operaciones</td>
    <td><?php echo $row_DetailRS5['estado_operaciones']; ?></td>
  </tr>
  <tr>
    <td>reparo_obs</td>
    <td><?php echo $row_DetailRS5['reparo_obs']; ?></td>
  </tr>
  <tr>
    <td>dias</td>
    <td><?php echo $row_DetailRS5['dias']; ?></td>
  </tr>
  <tr>
    <td>tiempo_acuse_recibo</td>
    <td><?php echo $row_DetailRS5['tiempo_acuse_recibo']; ?></td>
  </tr>
  <tr>
    <td>hic</td>
    <td><?php echo $row_DetailRS5['hic']; ?></td>
  </tr>
  <tr>
    <td>hrc</td>
    <td><?php echo $row_DetailRS5['hrc']; ?></td>
  </tr>
  <tr>
    <td>diaspendientes</td>
    <td><?php echo $row_DetailRS5['diaspendientes']; ?></td>
  </tr>
  <tr>
    <td>especialista_curse</td>
    <td><?php echo $row_DetailRS5['especialista_curse']; ?></td>
  </tr>
  <tr>
    <td>dif_ing_rec</td>
    <td><?php echo $row_DetailRS5['dif_ing_rec']; ?></td>
  </tr>
</table>







</body>
</html><?php
mysqli_free_result($DetailRS1);

mysqli_free_result($DetailRS2);

mysqli_free_result($DetailRS3);

mysqli_free_result($DetailRS4);

mysqli_free_result($DetailRS5);
?>