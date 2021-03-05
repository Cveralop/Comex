<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,SUP,OPE";
$MM_donotCheckaccess = "false";
// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 
  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}
$MM_restrictGoTo = "../erroracceso.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
$maxRows_DetailRS1 = 50;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opbga  WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysqli_query($comercioexterior, $query_limit_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1);
  $totalRows_DetailRS1 = mysqli_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<script> 
window.print(); 
</script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Imprimir Comprobante</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	color: #000;
}
.Estilo3 {font-size: 12px; font-weight: bold; }
.Estilo8 {color: #666666}
.Estilo6 {font-size: 9px}
.Estilo7 {	font-size: 9px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<table width="95%"  border="0" align="center">
  <tr>
    <td><span class="Estilo3"><img src="../../../imagenes/JPEG/logo_carta.JPG" alt="" width="219" height="61" /><br />
    </span></td>
    <td width="11%" align="right" valign="top"><a href="impdocvalo_mae.php" class="Estilo8">&lt;&lt;Volver&gt;&gt;</a></td>
  </tr>
</table>
<br />
<table width="95%"  border="0" align="center">
  <tr>
    <td align="center"><strong>DOCUMENTOS VALORADOS DEPTO. CAMBIOS</strong></td>
  </tr>
</table>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><strong>
      <?php
setlocale(LC_TIME,'sp'); 
echo strftime("Santiago, %d de %B de %Y");?>
    </strong></td>
  </tr>
</table>
<br />
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr align="center" valign="middle">
    <td colspan="4"><strong>DETALLE ENTREGA DOCUMENTO</strong></td>
  </tr>
  <tr valign="middle">
    <td width="18%" align="left">Oficina</td>
    <td align="left"><strong><?php echo strtoupper($row_DetailRS1['cod_suc']); ?></strong> <strong><?php echo strtoupper($row_DetailRS1['nombre_oficina']); ?></strong>
      </div></td>
    <td width="19" align="left">Nro Operación</td>
    <td align="center"><strong><?php echo $row_DetailRS1['nro_operacion']; ?></strong></td>
  </tr>
  <tr valign="middle">
    <td align="left">Cliente</td>
    <td colspan="3" align="left"><strong><?php echo $row_DetailRS1['rut_cliente']; ?></strong> <strong><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></strong></td>
  </tr>
  <tr valign="middle">
    <td align="left">Moneda Monto / Operaci&oacute;n</td>
    <td align="left"><strong><?php echo strtoupper($row_DetailRS1['moneda_operacion']); ?></strong> <strong><?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></strong></td>
    <td align="left">Fecha Ingreso</td>
    <td align="center"><strong><?php echo strtoupper($row_DetailRS1['fecha_curse']); ?></strong></td>
  </tr>
  <tr valign="middle">
    <td align="left">Especilaista NI</td>
    <td align="left"><strong><?php echo $row_DetailRS1['otros_datos']; ?></strong></td>
    <td align="left">Folio</td>
    <td align="center"><strong><?php echo strtoupper($row_DetailRS1['folio_boleta']); ?></strong></td>
  </tr>
</table>
<br />
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr>
    <td align="left" valign="middle"><strong><img src="../../../imagenes/GIF/check.gif" alt="" width="13" height="12" />Situaci&oacute;n del Documento</strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Observación <strong><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong><img src="../../../imagenes/GIF/check.gif" alt="" width="13" height="12" />Beneficiario</strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong><?php echo $row_DetailRS1['beneficiario']; ?></strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><strong><img src="../../../imagenes/GIF/check.gif" alt="" width="13" height="12" />Datos Entrega Documento</strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Nombre Contacto <strong><?php echo $row_DetailRS1['nombre']; ?></strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Rut, DI o Nro Pasaporte <strong><?php echo $row_DetailRS1['rut']; ?></strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Fono <strong><?php echo $row_DetailRS1['fono']; ?></strong></td>
  </tr>
</table>
<br />
<table width="95%"  border="0" align="center">
  <tr>
    <td><strong>NOTA: Este acuse de recibo deber&aacute; ser firmado por el cliente en se&ntilde;al de retiro del documento adjunto. Este documento debe quedar en custodia de la oficina correspondiente hasta su entrega.</strong></td>
  </tr>
</table>
<br />
<hr />
<table width="95%"  border="0" align="center">
  <tr valign="middle">
    <td width="17%" rowspan="9" valign="top"><span class="Estilo6">Retiro Conforme</span></td>
    <td colspan="2" align="center"><strong>ACUSE DE RECIBO </strong></td>
  </tr>
  <tr valign="middle">
    <td width="9%" rowspan="2" align="right">Firma&nbsp;&nbsp;&nbsp; </td>
    <td width="74%">&nbsp;</td>
  </tr>
  <tr valign="middle">
    <td>:<strong>..............................................................................................................................</strong></td>
  </tr>
  <tr valign="middle">
    <td rowspan="2" align="right">Nombre</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="middle">
    <td>:<strong>..............................................................................................................................</strong></td>
  </tr>
  <tr valign="middle">
    <td rowspan="2" align="right">R.U.T.&nbsp;&nbsp; </td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="middle">
    <td>:<strong>..............................................................................................................................</strong></td>
  </tr>
  <tr valign="middle">
    <td rowspan="2" align="right">Fecha&nbsp;&nbsp; </td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="middle">
    <td>:<strong>..............................................................................................................................</strong></td>
  </tr>
</table>
<br />
<table width="95%"  border="0" align="center">
  <tr>
    <td><span class="Estilo7">Operador: <?php echo $row_DetailRS1['operador']; ?> // Nro Operaci&oacute;n: <strong><?php echo strtoupper($row_DetailRS1['nro_operacion']); ?> // <?php echo strtoupper($row_DetailRS1['moneda_operacion']); ?> <?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></strong></span></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>