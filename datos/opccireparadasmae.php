<?php require_once('../Connections/comercioexterior.php'); ?>
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

$colname_opcci = "-1";
if (isset($_GET['fecha_ingreso'])) {
  $colname_opcci = $_GET['fecha_ingreso'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcci = sprintf("SELECT * FROM opcci WHERE fecha_ingreso = %s", GetSQLValueString($colname_opcci, "text"));
$opcci = mysqli_query($comercioexterior, $query_opcci) or die(mysqli_error($comercioexterior));
$row_opcci = mysqli_fetch_assoc($opcci);
$totalRows_opcci = mysqli_num_rows($opcci);

$colname_opcce = "-1";
if (isset($_GET['fecha_ingreso'])) {
  $colname_opcce = $_GET['fecha_ingreso'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcce = sprintf("SELECT * FROM opcce WHERE fecha_ingreso = %s", GetSQLValueString($colname_opcce, "text"));
$opcce = mysqli_query($comercioexterior, $query_opcce) or die(mysqli_error($comercioexterior));
$row_opcce = mysqli_fetch_assoc($opcce);
$totalRows_opcce = mysqli_num_rows($opcce);

$colname_opmec = "-1";
if (isset($_GET['fecha_ingreso'])) {
  $colname_opmec = $_GET['fecha_ingreso'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opmec = sprintf("SELECT * FROM opmec WHERE fecha_ingreso = %s", GetSQLValueString($colname_opmec, "text"));
$opmec = mysqli_query($comercioexterior, $query_opmec) or die(mysqli_error($comercioexterior));
$row_opmec = mysqli_fetch_assoc($opmec);
$totalRows_opmec = mysqli_num_rows($opmec);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 9px;
	color: #000;
}
-->
</style></head>

<body>
<form id="form1" name="form1" method="get" action="opccireparadasdet.php">
  <table width="95%" border="1" align="center">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#CCCCCC">Operaciones Reparadas (OPCCI)</td>
    </tr>
    <tr>
      <td width="18%" align="right" valign="middle">Fecha Ingreso:</td>
      <td width="82%" align="left" valign="middle"><label>
        <input name="fecha_ingreso" type="text" class="etiqueta12" id="fecha_ingreso" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10" />
      (dd-mm-aaaa)</label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<form id="form2" name="form2" method="get" action="opccereparadasdet.php">
  <table width="95%" border="1" align="center">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#CCCCCC">Operaciones Reparadas (OPCCE)</td>
    </tr>
    <tr>
      <td width="18%" align="right" valign="middle">Fecha Ingreso:</td>
      <td width="82%" align="left" valign="middle"><input name="fecha_ingreso2" type="text" class="etiqueta12" id="fecha_ingreso2" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10" />
(dd-mm-aaaa)</td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><input name="button2" type="submit" class="boton" id="button2" value="Buscar" /></td>
    </tr>
  </table>
</form>
<br />
<form id="form3" name="form3" method="get" action="opmecreparadasdet.php">
  <table width="95%" border="1" align="center">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#CCCCCC">Operaciones Reparadas (OPMEC)</td>
    </tr>
    <tr>
      <td width="18%" align="right" valign="middle">Fecha Ingreso:</td>
      <td width="82%" align="left" valign="middle"><input name="fecha_ingreso3" type="text" class="etiqueta12" id="fecha_ingreso3" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10" />
      (dd-mm-aaaa)</td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><input name="button3" type="submit" class="boton" id="button3" value="Buscar" /></td>
    </tr>
  </table>
</form>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</body>
</html>
<?php
mysqli_free_result($opcci);

mysqli_free_result($opcce);

mysqli_free_result($opmec);
?>
