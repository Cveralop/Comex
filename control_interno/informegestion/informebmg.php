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

$colname_carteraoperaciones = "bmg";
if (isset($_GET['informe_comercial'])) {
  $colname_carteraoperaciones = $_GET['informe_comercial'];
}
$colname1_carteraoperaciones = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_carteraoperaciones = $_GET['date_ini'];
}
$colname2_carteraoperaciones = "-1";
if (isset($_GET['date_fin'])) {
  $colname2_carteraoperaciones = $_GET['date_fin'];
}
$colname3_carteraoperaciones = "100";
if (isset($_GET['ope'])) {
  $colname3_carteraoperaciones = $_GET['ope'];
}
$colname4_carteraoperaciones = "199";
if (isset($_GET['ope'])) {
  $colname4_carteraoperaciones = $_GET['ope'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_carteraoperaciones = sprintf("SELECT *,sum(monto_operacion)as importe, count(rut_cliente)as cantidad FROM carteraopera nolock WHERE informe_comercial = %s and fecha_otor between %s and %s and ope between %s and %s GROUP BY rut_cliente, moneda_operacion ORDER BY nombre_cliente", GetSQLValueString($colname_carteraoperaciones, "text"),GetSQLValueString($colname1_carteraoperaciones, "date"),GetSQLValueString($colname2_carteraoperaciones, "date"),GetSQLValueString($colname3_carteraoperaciones, "int"),GetSQLValueString($colname4_carteraoperaciones, "int"));
$carteraoperaciones = mysqli_query($comercioexterior, $query_carteraoperaciones) or die(mysqli_error($comercioexterior));
$row_carteraoperaciones = mysqli_fetch_assoc($carteraoperaciones);
$totalRows_carteraoperaciones = mysqli_num_rows($carteraoperaciones);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Informe BMG</title>
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
    <td width="93%" align="left" valign="middle" bgcolor="#FF0000" class="Estilo1">INFORME BMG</td>
    <td width="7%" rowspan="2" align="left" valign="middle" bgcolor="#FF0000"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#FF0000" class="subtitulopaguina">COMERCIO EXTERIOR</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulo_menu">Generar Informe</span></td>
    </tr>
    <tr>
      <td width="22%" align="right" valign="middle">Fecha Otorgamiento:</td>
      <td width="78%" align="left" valign="middle"><span class="rojopequeno">Desde</span>
        <input name="date_ini" type="text" class="etiqueta12" id="date_ini" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10"> 
      <span class="rojopequeno">Hasta</span>        <input name="date_fin" type="text" class="etiqueta12" id="date_fin" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
      <span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><input name="button" type="submit" class="boton" id="button" value="Buscar"></td>
    </tr>
  </table>
</form>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../controlinterno.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0"></a></td>
  </tr>
</table>
<br>
<?php if ($totalRows_carteraoperaciones > 0) { // Show if recordset not empty ?>
  <span class="respuestacolumna_azul"><?php echo $totalRows_carteraoperaciones ?></span> Registros en Total<br>
  <br>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Cantidad Operaciones</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda</td>
      <td align="center" valign="middle" class="titulocolumnas">Capital Original</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_carteraoperaciones['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_carteraoperaciones['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_carteraoperaciones['cantidad']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_carteraoperaciones['moneda_operacion']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format(($row_carteraoperaciones['importe']/100), 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_carteraoperaciones = mysqli_fetch_assoc($carteraoperaciones)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($carteraoperaciones);
?>