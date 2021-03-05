<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,SUP";
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

$colname_cajaseca_sup = "-1";
if (isset($_GET['date_ini'])) {
  $colname_cajaseca_sup = $_GET['date_ini'];
}
$colname1_cajaseca_sup = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_cajaseca_sup = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cajaseca_sup = sprintf("SELECT * FROM caja_seca nolock WHERE date_ingreso between %s and %s", GetSQLValueString($colname_cajaseca_sup, "date"),GetSQLValueString($colname1_cajaseca_sup, "date"));
$cajaseca_sup = mysqli_query($comercioexterior, $query_cajaseca_sup) or die(mysqli_error($comercioexterior));
$row_cajaseca_sup = mysqli_fetch_assoc($cajaseca_sup);
$totalRows_cajaseca_sup = mysqli_num_rows($cajaseca_sup);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Caja Seca Control Supervisor</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo4 {font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">CAJA SECA CONTROL SUPERVISOR</td>
    <td width="7%" align="left" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" />Control Supervisor Fecha Ingreso</td>
    </tr>
    <tr>
      <td width="18%" align="right" valign="middle">Fecha Ingreso:</td>
      <td width="82%" align="left" valign="middle"><label>
        <input name="date_ini" type="text" class="etiqueta12" id="date_ini" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" />
        <span class="rojopequeno">Desde</span>
        <input name="date_fin" type="text" class="etiqueta12" id="date_fin" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" />
        <span class="rojopequeno">Hasta</span></label></td>
    </tr>
    <tr>
      <td colspan="2" valign="middle"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="cajaseca.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<?php if ($row_cajaseca_sup != 0) { // Show if recordset empty ?>

<?php echo $totalRows_cajaseca_sup ?> Registros Total <br />
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Nro Registro</td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso Operador</td>
    <td align="center" valign="middle" class="titulocolumnas">Operador Caja</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse Operador Caja</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_cajaseca_sup['id']; ?></td>
      <td align="center" valign="middle"><?php echo $row_cajaseca_sup['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_cajaseca_sup['nombre_cliente']; ?></td>
      <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_cajaseca_sup['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_cajaseca_sup['monto_operacion'], 2, ',', '.'); ?></span></td>
      <td align="center" valign="middle"><?php echo $row_cajaseca_sup['evento']; ?></td>
      <td align="center" valign="middle"><?php echo $row_cajaseca_sup['operador']; ?></td>
      <td align="center" valign="middle"><?php echo $row_cajaseca_sup['date_operador']; ?></td>
      <td align="center" valign="middle"><?php echo $row_cajaseca_sup['operador_caja']; ?></td>
      <td align="center" valign="middle"><?php echo $row_cajaseca_sup['date_operador_caja']; ?></td>
      <td align="center" valign="middle"><?php echo $row_cajaseca_sup['estado']; ?></td>
    </tr>
    <?php } while ($row_cajaseca_sup = mysqli_fetch_assoc($cajaseca_sup)); ?>
</table>
<?php } // Show if recordset empty ?>
</body>
</html>
<?php
mysqli_free_result($cajaseca_sup);
?>