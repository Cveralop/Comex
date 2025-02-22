<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
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

$colname_cobexporevento = "COBEX";
if (isset($_GET['tipo_operacion'])) {
  $colname_cobexporevento = $_GET['tipo_operacion'];
}
$colname2_cobexporevento = "Cursada.";
if (isset($_GET['estado'])) {
  $colname2_cobexporevento = $_GET['estado'];
}
$colname3_cobexporevento = "1";
if (isset($_GET['date_ini'])) {
  $colname3_cobexporevento = $_GET['date_ini'];
}
$colname4_cobexporevento = "1";
if (isset($_GET['date_fin'])) {
  $colname4_cobexporevento = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cobexporevento = sprintf("SELECT * FROM oppre nolock WHERE tipo_operacion LIKE %s and estado = %s and date_curse BETWEEN %s and %s ORDER BY evento ASC", GetSQLValueString("%" . $colname_cobexporevento . "%", "text"),GetSQLValueString($colname2_cobexporevento, "text"),GetSQLValueString($colname3_cobexporevento, "date"),GetSQLValueString($colname4_cobexporevento, "date"));
$cobexporevento = mysql_query($query_cobexporevento, $comercioexterior) or die(mysqli_error());
$row_cobexporevento = mysqli_fetch_assoc($cobexporevento);
$totalRows_cobexporevento = mysqli_num_rows($cobexporevento);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Prestamos con Gtia Corfo Vigentes</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo9 {color: #FFFFFF; font-weight: bold; font-size: 12px; }
.Estilo10 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo13 {color: #00FF00}

</style>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">PRESTAMOS CON GARANTIA CORFO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%" border="1" bordercolor="#666666" bgcolor="#CCCCCC" align="center">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"><span class="subtitulopaguina">Busqueda de Cobex Cursados</span></td>
    </tr>
    <tr>
      <td width="16%" align="right" valign="middle" bgcolor="#CCCCCC">Fecha de Curse:</td>
      <td width="84%" align="left" valign="middle" bgcolor="#CCCCCC"><label for="date_ini4" class="rojopequeno">Desde </label>
        <input name="date_ini" type="text" class="etiqueta12" id="date_ini4" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
        <span class="rojopequeno">        Hasta</span>
<input name="date_fin" type="text" class="etiqueta12" id="date_fin" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10"></td>
    </tr>
    <tr>
      <td colspan="2" valign="middle" bgcolor="#CCCCCC"><input name="button" type="submit" class="boton" id="button" value="Buscar">
      <input name="button2" type="reset" class="boton" id="button2" value="Limpiar"></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../prestamos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image4" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_cobexporevento > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="7" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo9">Total de Operaciones <span class="Estilo13"> <?php echo $totalRows_cobexporevento ?></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n</td>
    <td align="center" class="titulocolumnas">Rut Cliente</td>
    <td align="center" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
    <td align="center" class="titulocolumnas">Evento</td>
    <td align="center" class="titulocolumnas">Fecha Curse</td>
    <td align="center" class="titulocolumnas">Tipo Operaci&oacute;n</td>
    </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center">
      <span class="respuestacolumna_rojo"><?php echo strtoupper($row_cobexporevento['nro_operacion']); ?></span>      </td>
    <td align="center"><?php echo $row_cobexporevento['rut_cliente']; ?> </td>
    <td align="left"><?php echo strtoupper($row_cobexporevento['nombre_cliente']); ?></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_cobexporevento['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_cobexporevento['monto_operacion'], 2, ',', '.'); ?></strong> </td>
    <td align="center"><?php echo $row_cobexporevento['evento']; ?></td>
    <td align="center"><?php echo $row_cobexporevento['date_curse']; ?> </td>
    <td align="center"><?php echo $row_cobexporevento['tipo_operacion']; ?></td>
    </tr>
  <?php } while ($row_cobexporevento = mysqli_fetch_assoc($cobexporevento)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($cobexporevento);
?>