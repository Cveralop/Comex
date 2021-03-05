<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
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
$MM_restrictGoTo = "../../estadistica/erroracceso.php";
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

$colname1_iteraciones = "Cursada.";
if (isset($_GET['estado'])) {
  $colname1_iteraciones = $_GET['estado'];
}
$colname2_iteraciones = "1";
if (isset($_GET['date_ini'])) {
  $colname2_iteraciones = $_GET['date_ini'];
}
$colname3_iteraciones = "1";
if (isset($_GET['date_fin'])) {
  $colname3_iteraciones = $_GET['date_fin'];
}
$colname4_iteraciones = "1";
if (isset($_GET['iteraciones'])) {
  $colname4_iteraciones = $_GET['iteraciones'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_iteraciones = sprintf("SELECT tipo_operacion,evento,operador,iteraciones,sum(iteraciones)as total,(usuarios.nombre)as nombre FROM opstr, usuarios WHERE date_curse between %s and %s and estado = %s and (opstr.operador = usuarios.usuario) and iteraciones > %s GROUP BY operador,tipo_operacion,evento ORDER BY total desc", GetSQLValueString($colname2_iteraciones, "date"),GetSQLValueString($colname3_iteraciones, "date"),GetSQLValueString($colname1_iteraciones, "text"),GetSQLValueString($colname4_iteraciones, "int"));
$iteraciones = mysqli_query($comercioexterior, $query_iteraciones) or die(mysqli_error());
$row_iteraciones = mysqli_fetch_assoc($iteraciones);
$totalRows_iteraciones = mysqli_num_rows($iteraciones);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Iteraciones por Operador y Evento</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo2 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo3 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo11 {font-size: 14px; font-weight: bold; }
.Estilo12 {
	color: #FF0000;
	font-weight: bold;
	font-size: 12px;
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
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" bgcolor="#FF0000"><span class="Estilo1">ITERACIONES POR OPERADOR Y EVENTO </span></td>
    <td width="7%" rowspan="2" align="left" valign="middle" bgcolor="#FF0000"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#FF0000" class="subtitulopaguina">STAND BY RECIBIDAS</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo3">Iteraciones por Operador </span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Fecha Curse:</div></td>
      <td width="79%" align="left" valign="middle"><span class="respuestacolumna_rojo">Desde
        </span>
        <input name="date_ini" type="text" class="etiqueta12" id="date_ini" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10"> 
        <span class="respuestacolumna_rojo">Hasta</span><label>
          <input name="date_fin" type="text" class="mayuscula" id="date_fin" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
          <span class="respuestacolumna_rojo">(aaaa-mm-dd)</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar"></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../estadistica/estadistica.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_iteraciones > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Operador</div></td>
    <td align="center" valign="middle" class="titulocolumnas">Tipo Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Cantidad OP. Iteradas</td>
    </tr>
  <?php do { ?>
  <tr>
    <td align="left" valign="middle"> <span class="respuestacolumna"><?php echo strtoupper($row_iteraciones['nombre']); ?></span>      </div></td>
    <td valign="middle">STAND BY RECIBIDA <?php echo strtoupper($row_iteraciones['tipo_operacion']); ?></td>
    <td valign="middle"><span class="respuestacolumna"><?php echo strtoupper($row_iteraciones['evento']); ?></span>      </div></td>
    <td valign="middle"><strong class="respuestacolumna"><?php echo $row_iteraciones['total']; ?></strong></div></td>
    </tr>
  <?php } while ($row_iteraciones = mysqli_fetch_assoc($iteraciones)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($iteraciones);
?>