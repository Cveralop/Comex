<?php require_once('../../Connections/comercioexterior.php'); ?>
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

$colname_carteravencida = "80";
if (isset($_GET['dias_cv'])) {
  $colname_carteravencida = $_GET['dias_cv'];
}
$colname1_carteravencida = "360000";
if (isset($_GET['tipo_operacion'])) {
  $colname1_carteravencida = $_GET['tipo_operacion'];
}
$colname2_carteravencida = "368999";
if (isset($_GET['tipo_operacion'])) {
  $colname2_carteravencida = $_GET['tipo_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_carteravencida = sprintf("SELECT * FROM devengo nolock WHERE dias_cv > %s and tipo_operacion between %s and %s  GROUP BY nro_operacion ORDER BY fecha_vcto ASC", GetSQLValueString($colname_carteravencida, "int"),GetSQLValueString($colname1_carteravencida, "int"),GetSQLValueString($colname2_carteravencida, "int"));
$carteravencida = mysqli_query($comercioexterior, $query_carteravencida) or die(mysqli_error($comercioexterior));
$row_carteravencida = mysqli_fetch_assoc($carteravencida);
$totalRows_carteravencida = mysqli_num_rows($carteravencida);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Operaciones Cartera Vencida</title>
<style type="text/css">
<!--
@import url("../../estilos/estilo12.css");
.Estilo2 {font-size: 9px; color: #0000FF; }
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FF0000;
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
.Estilo1 {font-size: 18px;
	color: #FFFFFF;
	font-weight: bold;
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
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" bgcolor="#FF0000" class="Estilo1">OPERACIONES CARTERA VENCIDA</td>
    <td width="7%" rowspan="2" align="left" valign="middle" bgcolor="#FF0000"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#FF0000" class="subtitulopaguina">COMERCIO EXTERIOR</td>
  </tr>
</table>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../controlinterno.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0"></a></td>
  </tr>
</table>
<br>
<span class="respuestacolumna_azul"><?php echo $totalRows_carteravencida ?></span> Registros en Total<br>
<br>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Oficina</td>
    <td align="center" valign="middle" class="titulocolumnas">Tipo Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Secuencia</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda</td>
    <td align="center" valign="middle" class="titulocolumnas">Capital Original</td>
    <td align="center" valign="middle" class="titulocolumnas">Saldo Vigente</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Vcto</td>
    <td class="titulocolumnas">Dias de CV</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_carteravencida['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_carteravencida['nombre_cliente']; ?></td>
      <td align="center" valign="middle"><?php echo $row_carteravencida['oficina']; ?></td>
      <td align="center" valign="middle"><?php echo $row_carteravencida['tipo_operacion']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_carteravencida['nro_operacion']; ?></td>
      <td align="center" valign="middle"><?php echo $row_carteravencida['secuencia']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_carteravencida['moneda']; ?></td>
      <td align="right" valign="middle"><?php echo number_format($row_carteravencida['capital_original'], 2, ',', '.'); ?></td>
      <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_carteravencida['saldo_vigente'], 2, ',', '.'); ?></td>
      <td align="center" valign="middle"><?php echo $row_carteravencida['fecha_vcto']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_carteravencida['dias_cv']; ?></td>
    </tr>
    <?php } while ($row_carteravencida = mysqli_fetch_assoc($carteravencida)); ?>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
</body>
</html>
<?php
mysqli_free_result($carteravencida);
?>
