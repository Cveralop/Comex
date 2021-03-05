<?php require_once('../../../Connections/basecomercial.php'); ?><?php
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
mysqli_select_db($basecomercial, $database_basecomercial);
$query_DetailRS1 = sprintf("SELECT * FROM negativefile  WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($basecomercial, $query_DetailRS1) or die(mysqli_error());
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
    <td>cod_negative_file</td>
    <td><?php echo $row_DetailRS1['cod_negative_file']; ?></td>
  </tr>
  <tr>
    <td>descripcion</td>
    <td><?php echo $row_DetailRS1['descripcion']; ?></td>
  </tr>
  <tr>
    <td>date_vigencia</td>
    <td><?php echo $row_DetailRS1['date_vigencia']; ?></td>
  </tr>
  <tr>
    <td>considerar</td>
    <td><?php echo $row_DetailRS1['considerar']; ?></td>
  </tr>
</table>

</body>
</html><?php
mysqli_free_result($DetailRS1);
?>