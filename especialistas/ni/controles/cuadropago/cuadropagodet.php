<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ESP,ADM";
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
$MM_restrictGoTo = "../../erroracceso.php";
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

$colname_DetailRS1 = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname_DetailRS1 = $_GET['nro_operacion'];
}
$colname1_DetailRS1 = "-1";
if (isset($_GET['intereses_al'])) {
  $colname1_DetailRS1 = $_GET['intereses_al'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM cuadropago nolock WHERE nro_operacion LIKE %s and intereses_al = %s", GetSQLValueString("%" . $colname_DetailRS1 . "%", "text"),GetSQLValueString($colname1_DetailRS1, "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$colname_valorcredito = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname_valorcredito = $_GET['nro_operacion'];
}
$colname1_valorcredito = "-1";
if (isset($_GET['intereses_al'])) {
  $colname1_valorcredito = $_GET['intereses_al'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_valorcredito = sprintf("SELECT *, sum(capital_original)as valor_credito FROM cuadropago nlock WHERE nro_operacion LIKE %s and intereses_al = %s GROUP BY nro_operacion", GetSQLValueString("%" . $colname_valorcredito . "%", "text"),GetSQLValueString($colname1_valorcredito, "text"));
$valorcredito = mysql_query($query_valorcredito, $comercioexterior) or die(mysqli_error());
$row_valorcredito = mysqli_fetch_assoc($valorcredito);
$totalRows_valorcredito = mysqli_num_rows($valorcredito);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cuadro Pago Detalle</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	color: #000;
}
body {
	background-image: url();
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #F00;
}
a:link {
	text-decoration: none;
	color: #666;
}
a:visited {
	text-decoration: none;
	color: #666;
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
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="cuadropagomae.php">&lt;&lt;VOLVER&gt;&gt;</a></td>
  </tr>
  <tr>
    <td align="left"><img src="../../../../imagenes/JPEG/logo_carta.JPG" width="219" height="61" /></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="center" class="subtitulopaguina"><span class="titulopaguina"><span class="titulopaguina">Anexo</span></span></td>
  </tr>
  <tr>
    <td align="center" class="titulopaguina">Cuadro de Pago</td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td width="16%" align="left">Nombre Cliente:</td>
    <td width="1%" align="center">:</td>
    <td width="83%" colspan="5" align="left"><strong><?php echo $row_DetailRS1['nombre_cliente']; ?></strong></td>
  </tr>
  <tr>
    <td align="left">Rut Cliente:</td>
    <td align="center">:</td>
    <td colspan="5" align="left"><strong><?php echo $row_DetailRS1['rut_cliente']; ?></strong></td>
  </tr>
  <tr>
    <td align="left">Fecha Inicio:</td>
    <td align="center">:</td>
    <td align="left"><strong><?php echo $row_DetailRS1['fecha_desde']; ?></strong></td>
    <td align="left">Moneda:</td>
    <td align="center"><strong><?php echo $row_DetailRS1['moneda']; ?></strong></td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">Nro Operación:</td>
    <td align="center">:</td>
    <td align="left"><strong><?php echo $row_DetailRS1['nro_operacion']; ?></strong></td>
    <td align="left">Tasa:</td>
    <td align="center"><strong><?php echo $row_DetailRS1['tasa_final_cliente']; ?> </strong></td>
    <td align="left">Valor Crédito:</td>
    <td align="center"><strong><?php echo $row_DetailRS1['moneda']; ?></strong> / <strong><?php echo number_format($row_valorcredito['valor_credito'], 2, ',', '.'); ?> </strong></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center">
  <tr>
    <td bgcolor="#999999" class="titulocolumnas">Secuencia</td>
    <td bgcolor="#999999" class="titulocolumnas">Importe Capital / Cuota</td>
    <td bgcolor="#999999" class="titulocolumnas">Fecha de Vcto</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" bgcolor="#CCCCCC"><strong><?php echo $row_DetailRS1['secuencia']; ?></strong></td>
      <td align="right" bgcolor="#CCCCCC"><strong><?php echo number_format($row_DetailRS1['capital_original'], 2, ',', '.'); ?></strong></td>
      <td align="center" bgcolor="#CCCCCC"><strong><?php echo $row_DetailRS1['fecha_vcto']; ?></strong></td>
    </tr>
    <?php } while ($row_DetailRS1 = mysqli_fetch_assoc($DetailRS1)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
mysqli_free_result($valorcredito);
?>