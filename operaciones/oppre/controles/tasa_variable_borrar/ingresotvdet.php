<?php require_once('../../../../Connections/comercioexterior.php'); ?><?php
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
$query_DetailRS1 = sprintf("SELECT * FROM oppre nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tasa_variable (rut_cliente, nombre_cliente, nro_operacion, nombre_producto, ope, date_otorgamiento, date_vcto, moneda_operacion, monto_origen, saldo_operacion, indicador_tasa, detalle_tasa, tasa_base, spread, tasa_final, ultima_date_reprecio, date_reprecio, tipo_control) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['nombre_producto'], "text"),
                       GetSQLValueString($_POST['ope'], "int"),
                       GetSQLValueString($_POST['date_otorgamiento'], "date"),
                       GetSQLValueString($_POST['date_vcto'], "date"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_origen'], "double"),
                       GetSQLValueString($_POST['saldo_operacion'], "double"),
                       GetSQLValueString($_POST['indicador_tasa'], "text"),
                       GetSQLValueString($_POST['detalle_tasa'], "text"),
                       GetSQLValueString($_POST['tasa_base'], "double"),
                       GetSQLValueString($_POST['spread'], "double"),
                       GetSQLValueString($_POST['tasa_final'], "double"),
                       GetSQLValueString($_POST['ultima_date_reprecio'], "date"),
                       GetSQLValueString($_POST['date_reprecio'], "date"),
                       GetSQLValueString($_POST['tipo_control'], "text"));

  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));

  $insertGoTo = "ingresotvmae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingreso Tasa Variable - Detalle</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
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
<body onload="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO TASA VARIABLE  - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CONTROL PRESTAMOS STAND ALONE</td>
  </tr>
</table>
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" />Ingreso Detalle Tasa Variable</td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="12" /></td>
      <td align="right" valign="middle">Nro Operación:</td>
      <td align="center" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="15" maxlength="7" />
        <span class="respuestacolumna_rojo">F000000</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Producto:</td>
      <td align="center" valign="middle"><input name="nombre_producto" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['tipo_operacion']; ?>" size="32" /></td>
      <td align="right" valign="middle">Codigo Operación:</td>
      <td align="center" valign="middle"><input name="ope" type="text" class="etiqueta12" value="" size="5" maxlength="3" /> 
        Ej: 35</td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Fecha Otorgamiento:</td>
      <td align="center" valign="middle"><input name="date_otorgamiento" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['date_curse']; ?>" size="12" maxlength="10" /> 
        <span class="respuestacolumna_rojo">(aaaa-mm-dd)</span></td>
      <td align="right" valign="middle">Fecha Vcto:</td>
      <td align="center" valign="middle"><input name="date_vcto" type="text" class="etiqueta12" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" />
      <span class="respuestacolumna_rojo">(aaaa-mm-dd)</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Moneda / Monto Operacion:</td>
      <td align="center" valign="middle"><input name="moneda_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['moneda_operacion']; ?>" size="5" maxlength="3" /> 
        <span class="respuestacolumna_rojo">/</span>        <input name="monto_origen" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="20" maxlength="20" /></td>
      <td align="right" valign="middle">Saldo Operacion:</td>
      <td align="center" valign="middle"><input name="saldo_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Indicador Tasa:</td>
      <td align="center" valign="middle"><select name="indicador_tasa" class="etiqueta12" id="indicador_tasa">
        <option value="Variable.">Variable</option>
      </select></td>
      <td align="right" valign="middle">Detalle Tasa:</td>
      <td align="center" valign="middle"><input name="detalle_tasa" type="text" class="etiqueta12" value="" size="50" maxlength="50" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Tasa Base:</td>
      <td align="center" valign="middle"><input name="tasa_base" type="text" class="etiqueta12" value="" size="15" maxlength="10" /></td>
      <td align="right" valign="middle">Spread:</td>
      <td align="center" valign="middle"><input name="spread" type="text" class="etiqueta12" value="" size="15" maxlength="10" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Tasa Final:</td>
      <td align="center" valign="middle"><input name="tasa_final" type="text" class="etiqueta12" size="15" maxlength="10" /></td>
      <td align="right" valign="middle">Tipo Control:</td>
      <td align="center" valign="middle"><select name="tipo_control" class="etiqueta12" id="tipo_control">
        <option value="Manual." selected="selected">Manual</option>
        <option value="Automatico.">Automatico</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Ultima Fecha Reprecio:</td>
      <td align="center" valign="middle"><input name="ultima_date_reprecio" type="text" class="etiqueta12" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" />
      <span class="respuestacolumna_rojo">(aaaa-mm-dd)</span></td>
      <td align="right" valign="middle">Fecha Reprecio:</td>
      <td align="center" valign="middle"><input name="date_reprecio" type="text" class="etiqueta12" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" />
      <span class="respuestacolumna_rojo">(aaaa-mm-dd)</span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle"><input type="submit" class="boton" value="Insertar Tasa Variable" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="ingresotvmae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>