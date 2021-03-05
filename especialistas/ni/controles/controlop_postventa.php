<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,ESP";
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

$colname_reparos = "BMG";
if (isset($_GET['perfil'])) {
  $colname_reparos = $_GET['perfil'];
}
$colname1_reparos = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_reparos = $_GET['date_ini'];
}
$colname2_reparos = "N/A";
if (isset($_GET['especialista_curse'])) {
  $colname2_reparos = $_GET['especialista_curse'];
}
$colname3_reparos = "-1";
if (isset($_GET['date_fin'])) {
  $colname3_reparos = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_reparos = sprintf("SELECT opcci.* FROM opcci, usuarios WHERE opcci.especialista_curse = usuarios.usuario and usuarios.perfil <> %s and date_ingreso between %s and %s and especialista_curse <> %s ORDER BY date_espe ASC", GetSQLValueString($colname_reparos, "text"),GetSQLValueString($colname1_reparos, "text"),GetSQLValueString($colname3_reparos, "date"),GetSQLValueString($colname2_reparos, "text"));
$reparos = mysqli_query($comercioexterior, $query_reparos) or die(mysqli_error($comercioexterior));
$row_reparos = mysqli_fetch_assoc($reparos);
$totalRows_reparos = mysqli_num_rows($reparos);

mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores nolock";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);

$colname_meco = "BMG";
if (isset($_GET['perfil'])) {
  $colname_meco = $_GET['perfil'];
}
$colname1_meco = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_meco = $_GET['date_ini'];
}
$colname2_meco = "N/A";
if (isset($_GET['especialista_curse'])) {
  $colname2_meco = $_GET['especialista_curse'];
}
$colname3_meco = "-1";
if (isset($_GET['date_fin'])) {
  $colname3_meco = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_meco = sprintf("SELECT opmec.* FROM opmec, usuarios WHERE opmec.especialista_curse = usuarios.usuario and usuarios.perfil <> %s and date_ingreso between %s and %s and especialista_curse <> %s ORDER BY date_espe ASC", GetSQLValueString($colname_meco, "text"),GetSQLValueString($colname1_meco, "date"),GetSQLValueString($colname3_meco, "date"),GetSQLValueString($colname2_meco, "text"));
$meco = mysqli_query($comercioexterior, $query_meco) or die(mysqli_error($comercioexterior));
$row_meco = mysqli_fetch_assoc($meco);
$totalRows_meco = mysqli_num_rows($meco);

$colname_cbi = "BMG";
if (isset($_GET['perfil'])) {
  $colname_cbi= $_GET['perfil'];
}
$colname1_cbi = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_cbi = $_GET['date_ini'];
}
$colname2_cbi = "N/A";
if (isset($_GET['especialista_curse'])) {
  $colname2_cbi = $_GET['especialista_curse'];
}
$colname3_cbi = "-1";
if (isset($_GET['date_fin'])) {
  $colname3_cbi = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cbi = sprintf("SELECT opcbi.* FROM opcbi, usuarios WHERE opcbi.especialista_curse = usuarios.usuario and usuarios.perfil <> %s and date_ingreso between %s and %s and especialista_curse <> %s ORDER BY date_espe ASC", GetSQLValueString($colname_cbi, "text"),GetSQLValueString($colname1_cbi, "date"),GetSQLValueString($colname3_cbi, "date"),GetSQLValueString($colname2_cbi, "text"));
$cbi = mysqli_query($comercioexterior, $query_cbi) or die(mysqli_error($comercioexterior));
$row_cbi = mysqli_fetch_assoc($cbi);
$totalRows_cbi = mysqli_num_rows($cbi);

$colname_cce = "BMG";
if (isset($_GET['perfil'])) {
  $colname_cce= $_GET['perfil'];
}
$colname1_cce = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_cce = $_GET['date_ini'];
}
$colname2_cce = "N/A";
if (isset($_GET['especialista_curse'])) {
  $colname2_cce = $_GET['especialista_curse'];
}
$colname3_cce = "-1";
if (isset($_GET['date_fin'])) {
  $colname3_cce = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cce = sprintf("SELECT opcce.* FROM opcce, usuarios WHERE opcce.especialista_curse = usuarios.usuario and usuarios.perfil <> %s and date_ingreso between %s and %s and especialista_curse <> %s ORDER BY date_espe ASC", GetSQLValueString($colname_cce, "text"),GetSQLValueString($colname1_cce, "date"),GetSQLValueString($colname3_cce, "date"),GetSQLValueString($colname2_cce, "text"));
$cce = mysqli_query($comercioexterior, $query_cce) or die(mysqli_error($comercioexterior));
$row_cce = mysqli_fetch_assoc($cce);
$totalRows_cce = mysqli_num_rows($cce);

$colname_pre = "BMG";
if (isset($_GET['perfil'])) {
  $colname_pre= $_GET['perfil'];
}
$colname1_pre = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_pre = $_GET['date_ini'];
}
$colname2_pre = "N/A";
if (isset($_GET['especialista_curse'])) {
  $colname2_pre = $_GET['especialista_curse'];
}
$colname3_pre = "-1";
if (isset($_GET['date_fin'])) {
  $colname3_pre = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_pre = sprintf("SELECT oppre.* FROM oppre, usuarios WHERE oppre.especialista_curse = usuarios.usuario and usuarios.perfil <> %s and date_ingreso between %s and %s and especialista_curse <> %s ORDER BY date_espe ASC", GetSQLValueString($colname_pre, "text"),GetSQLValueString($colname1_pre, "date"),GetSQLValueString($colname3_pre, "date"),GetSQLValueString($colname2_pre, "text"));
$pre = mysqli_query($comercioexterior, $query_pre) or die(mysqli_error($comercioexterior));
$row_pre = mysqli_fetch_assoc($pre);
$totalRows_pre = mysqli_num_rows($pre);

$colname_cbe = "BMG";
if (isset($_GET['perfil'])) {
  $colname_cbe= $_GET['perfil'];
}
$colname1_cbe = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_cbe = $_GET['date_ini'];
}
$colname2_cbe = "N/A";
if (isset($_GET['especialista_curse'])) {
  $colname2_cbe = $_GET['especialista_curse'];
}
$colname3_cbe = "-1";
if (isset($_GET['date_fin'])) {
  $colname3_cbe = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cbe = sprintf("SELECT opcbe.* FROM opcbe, usuarios WHERE opcbe.especialista_curse = usuarios.usuario and usuarios.perfil <> %s and date_ingreso between %s and %s and especialista_curse <> %s ORDER BY date_espe ASC", GetSQLValueString($colname_cbe, "text"),GetSQLValueString($colname1_cbe, "date"),GetSQLValueString($colname3_cbe, "date"),GetSQLValueString($colname2_cbe, "text"));
$cbe = mysqli_query($comercioexterior, $query_cbe) or die(mysqli_error($comercioexterior));
$row_cbe = mysqli_fetch_assoc($cbe);
$totalRows_cbe = mysqli_num_rows($cbe);

$colname_cdpa = "BMG";
if (isset($_GET['perfil'])) {
  $colname_cdpa= $_GET['perfil'];
}
$colname1_cdpa = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_cdpa = $_GET['date_ini'];
}
$colname2_cdpa = "N/A";
if (isset($_GET['especialista_curse'])) {
  $colname2_cdpa = $_GET['especialista_curse'];
}
$colname3_cdpa = "-1";
if (isset($_GET['date_fin'])) {
  $colname3_cdpa = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cdpa = sprintf("SELECT opcdpa.* FROM opcdpa, usuarios WHERE opcdpa.especialista_curse = usuarios.usuario and usuarios.perfil <> %s and date_ingreso between %s and %s and especialista_curse <> %s ORDER BY date_espe ASC", GetSQLValueString($colname_cdpa, "text"),GetSQLValueString($colname1_cdpa, "date"),GetSQLValueString($colname3_cdpa, "date"),GetSQLValueString($colname2_cdpa, "text"));
$cdpa = mysqli_query($comercioexterior, $query_cdpa) or die(mysqli_error($comercioexterior));
$row_cdpa = mysqli_fetch_assoc($cdpa);
$totalRows_cdpa = mysqli_num_rows($cdpa);

$colname_ste = "BMG";
if (isset($_GET['perfil'])) {
  $colname_ste= $_GET['perfil'];
}
$colname1_ste = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_ste = $_GET['date_ini'];
}
$colname2_ste = "N/A";
if (isset($_GET['especialista_curse'])) {
  $colname2_ste = $_GET['especialista_curse'];
}
$colname3_ste = "-1";
if (isset($_GET['date_fin'])) {
  $colname3_ste = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ste = sprintf("SELECT opste.* FROM opste, usuarios WHERE opste.especialista_curse = usuarios.usuario and usuarios.perfil <> %s and date_ingreso between %s and %s and especialista_curse <> %s ORDER BY date_espe ASC", GetSQLValueString($colname_ste, "text"),GetSQLValueString($colname1_ste, "date"),GetSQLValueString($colname3_ste, "date"),GetSQLValueString($colname2_ste, "text"));
$ste = mysqli_query($comercioexterior, $query_ste) or die(mysqli_error($comercioexterior));
$row_ste = mysqli_fetch_assoc($ste);
$totalRows_ste = mysqli_num_rows($ste);

$colname_cex = "BMG";
if (isset($_GET['perfil'])) {
  $colname_cex= $_GET['perfil'];
}
$colname1_cex = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_cex = $_GET['date_ini'];
}
$colname2_cex = "N/A";
if (isset($_GET['especialista_curse'])) {
  $colname2_cex = $_GET['especialista_curse'];
}
$colname3_cex = "-1";
if (isset($_GET['date_fin'])) {
  $colname3_cex = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cex = sprintf("SELECT opcex.* FROM opcex, usuarios WHERE opcex.especialista_curse = usuarios.usuario and usuarios.perfil <> %s and date_ingreso between %s and %s and especialista_curse <> %s ORDER BY date_espe ASC", GetSQLValueString($colname_cex, "text"),GetSQLValueString($colname1_cex, "date"),GetSQLValueString($colname3_cex, "date"),GetSQLValueString($colname2_cex, "text"));
$cex = mysqli_query($comercioexterior, $query_cex) or die(mysqli_error($comercioexterior));
$row_cex = mysqli_fetch_assoc($cex);
$totalRows_cex = mysqli_num_rows($cex);

$colname_tbc = "BMG";
if (isset($_GET['perfil'])) {
  $colname_tbc= $_GET['perfil'];
}
$colname1_tbc = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_tbc = $_GET['date_ini'];
}
$colname2_tbc = "N/A";
if (isset($_GET['especialista_curse'])) {
  $colname2_tbc = $_GET['especialista_curse'];
}
$colname3_tbc = "-1";
if (isset($_GET['date_fin'])) {
  $colname3_tbc = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_tbc = sprintf("SELECT optbc.* FROM optbc, usuarios WHERE optbc.especialista_curse = usuarios.usuario and usuarios.perfil <> %s and date_ingreso between %s and %s and especialista_curse <> %s ORDER BY date_espe ASC", GetSQLValueString($colname_tbc, "text"),GetSQLValueString($colname1_tbc, "date"),GetSQLValueString($colname3_tbc, "date"),GetSQLValueString($colname2_tbc, "text"));
$tbc = mysqli_query($comercioexterior, $query_tbc) or die(mysqli_error($comercioexterior));
$row_tbc = mysqli_fetch_assoc($tbc);
$totalRows_tbc = mysqli_num_rows($tbc);

$colname_bga = "BMG";
if (isset($_GET['perfil'])) {
  $colname_bga= $_GET['perfil'];
}
$colname1_bga = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_bga = $_GET['date_ini'];
}
$colname2_bga = "N/A";
if (isset($_GET['especialista_curse'])) {
  $colname2_bga = $_GET['especialista_curse'];
}
$colname3_bga = "-1";
if (isset($_GET['date_fin'])) {
  $colname3_bga = $_GET['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_bga = sprintf("SELECT opbga.* FROM opbga, usuarios WHERE opbga.especialista_curse = usuarios.usuario and usuarios.perfil <> %s and date_ingreso between %s and %s and especialista_curse <> %s ORDER BY date_espe ASC", GetSQLValueString($colname_bga, "text"),GetSQLValueString($colname1_bga, "date"),GetSQLValueString($colname3_bga, "text"),GetSQLValueString($colname2_bga, "text"));
$bga = mysqli_query($comercioexterior, $query_bga) or die(mysqli_error($comercioexterior));
$row_bga = mysqli_fetch_assoc($bga);
$totalRows_bga = mysqli_num_rows($bga);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Control OP Enviadas a Proceso por Post Venta - Maestro</title>
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo5 {
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.Estilo8 {color: #00FF00}
.Estilo10 {color: #FFFFFF; font-weight: bold; }
.Estilo11 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo12 {font-size: 14px}
.Estilo13 {color: #FFFFFF}
.Estilo15 {
	color: #00FF00;
	font-size: 12px;
	font-weight: bold;
}
.Estilo18 {font-size: 12px}
-->
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">OPERACIONES ENVIADAS A PROCESO POR POST VENTA- MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">ESPECIALISTAS COMEX</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulodetalle">Control de Operaciones Enviadas a Proceso</span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Fecha Ingreso:</div></td>
      <td width="79%" align="left" valign="middle"><span class="respuestacolumna_rojo">Desde</span>
        <input name="date_ini" type="text" class="etiqueta12" id="date_ini" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
      <span class="rojopequeno">Hasta
      <input name="date_fin" type="text" class="etiqueta12" id="date_fin" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
      </span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Estado Ope.:</div></td>
      <td align="left" valign="middle"><select name="estado" class="etiqueta12" id="estado">
        <option value="." selected>Todas</option>
        <option value="Pendiente.">Pendiente</option>
        <option value="Cursada.">Cursada</option>
        <option value="Reparada.">Reparada</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="operacionesmesa.php">&lt;&lt;Operaciones Mesa Dinero&gt;&gt;</a> //<a href="../ni.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../../imagenes/Botones/boton_volver_2.jpg',1)"> <img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a>      </div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_reparos > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="16" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Total Operaciones Enviadas a Curse </span><span class="tituloverde"><?php echo $totalRows_reparos ?></span><span class="Estilo5"><span class="Estilo8"> <span class="Estilo13">Cartas de Cr&eacute;dito Importaci&oacute;n</span></span></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle"><span class="titulocolumnas">Nro Folio</span></div>    </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Negociaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Operador
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor</td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
    </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_reparos['id']; ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_reparos['date_espe']; ?></div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_reparos['rut_cliente']); ?></div></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_reparos['nombre_cliente']); ?></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_reparos['nro_operacion']); ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_reparos['evento']; ?></div></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_reparos['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_reparos['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_reparos['moneda_documentos']); ?></span><strong class="respuestacolumna_azul"><?php echo number_format($row_reparos['monto_documentos'], 2, ',', '.'); ?></strong>
      </div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_reparos['especialista_curse']); ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_reparos['operador']); ?></td>
    <td align="center" valign="middle"><?php echo $row_reparos['sub_estado']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_reparos['asignador']); ?></td>
    <td align="center" valign="middle"><?php if ($row_reparos['estado'] <> $row_colores['cursada'] and $row_reparos['estado'] <> $row_colores['pendiente'] and $row_reparos['estado'] <> $row_colores['solucionado'] and $row_reparos['estado'] <> $row_colores['preingresada'] and $row_reparos['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_reparos['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_reparos['estado'] <> $row_colores['reparada'] and $row_reparos['estado'] <> $row_colores['pendiente'] and $row_reparos['estado'] <> $row_colores['solucionado'] and $row_reparos['estado'] <> $row_colores['preingresada'] and $row_reparos['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_reparos['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_reparos['estado'] <> $row_colores['reparada'] and $row_reparos['estado'] <> $row_colores['cursada'] and $row_reparos['estado'] <> $row_colores['solucionado'] and $row_reparos['estado'] <> $row_colores['preingresada'] and $row_reparos['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_reparos['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_reparos['estado'] <> $row_colores['reparada'] and $row_reparos['estado'] <> $row_colores['pendiente'] and $row_reparos['estado'] <> $row_colores['preingresada'] and $row_reparos['estado'] <> $row_colores['cursada'] and $row_reparos['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_reparos['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_reparos['estado'] <> $row_colores['reparada'] and $row_reparos['estado'] <> $row_colores['pendiente'] and $row_reparos['estado'] <> $row_colores['solucionado'] and $row_reparos['estado'] <> $row_colores['cursada'] and $row_reparos['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_reparos['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_reparos['estado'] <> $row_colores['reparada'] and $row_reparos['estado'] <> $row_colores['pendiente'] and $row_reparos['estado'] <> $row_colores['solucionado'] and $row_reparos['estado'] <> $row_colores['cursada'] and $row_reparos['estado'] <> $row_colores['preingresada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_reparos['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_reparos['reparo_obs']); ?></td>
    <td align="center" valign="middle"><?php echo $row_reparos['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_reparos['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_reparos['urgente']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_reparos['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_reparos['urgente']; ?> </span></span>
      <?php } // Show if not first page ?>
      </div></td>
    </tr>
  <?php } while ($row_reparos = mysqli_fetch_assoc($reparos)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_cbi > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td colspan="16" align="left"><span class="Estilo10"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></span><span class="Estilo5">Total Operaciones Enviadas a Curse&nbsp;<span class="tituloverde"><?php echo $totalRows_cbi ?></span> Cobranza Extranjera de Importaci&oacute;n y OPI </span></div></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Nro Folio </td>
    <td align="center" class="titulocolumnas">Fecha Ingreso </td>
    <td align="center" class="titulocolumnas">Rut Cliente </td>
    <td align="center" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </td>
    <td align="center" class="titulocolumnas">Evento</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </td>
    <td align="center" class="titulocolumnas">Especialista Curse</td>
    <td align="center" class="titulocolumnas">Operador</td>
    <td align="center" class="titulocolumnas">Estado Operador </td>
    <td align="center" class="titulocolumnas">Supervisor</td>
    <td align="center" class="titulocolumnas">Estado Supervisor </td>
    <td align="center" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" class="titulocolumnas">Fecha Curse</td>
    <td align="center" class="titulocolumnas">Tipo Operaci&oacute;n </td>
    <td align="center" class="titulocolumnas">Urgente</td>
    </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><span class="respuestacolumna_rojo"><?php echo $row_cbi['id']; ?></span>      </div></td>
    <td align="center"><?php echo $row_cbi['date_espe']; ?> </td>
    <td align="center"><?php echo strtoupper($row_cbi['rut_cliente']); ?></td>
    <td align="left"><?php echo strtoupper($row_cbi['nombre_cliente']); ?> </div></td>
    <td align="center" class="respuestacolumna_rojo"><?php echo strtoupper($row_cbi['nro_operacion']); ?></td>
    <td align="center"><?php echo $row_cbi['evento']; ?> </td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo $row_cbi['moneda_operacion']; ?></span>&nbsp; <strong class="respuestacolumna_azul"><?php echo number_format($row_cbi['monto_operacion'], 2, ',', '.'); ?></strong> </td>
    <td align="center"><?php echo strtoupper($row_cbi['especialista_curse']); ?></td>
    <td align="center"><?php echo strtoupper($row_cbi['operador']); ?> </td>
    <td align="center"><?php echo $row_cbi['sub_estado']; ?> </td>
    <td align="center"><?php echo strtoupper($row_cbi['asignador']); ?> </td>
    <td align="center"><?php if ($row_cbi['estado'] <> $row_colores['cursada'] and $row_cbi['estado'] <> $row_colores['pendiente'] and $row_cbi['estado'] <> $row_colores['solucionado'] and $row_cbi['estado'] <> $row_colores['preingresada'] and $row_cbi['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cbi['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cbi['estado'] <> $row_colores['reparada'] and $row_cbi['estado'] <> $row_colores['pendiente'] and $row_cbi['estado'] <> $row_colores['solucionado'] and $row_cbi['estado'] <> $row_colores['preingresada'] and $row_cbi['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cbi['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cbi['estado'] <> $row_colores['reparada'] and $row_cbi['estado'] <> $row_colores['cursada'] and $row_cbi['estado'] <> $row_colores['solucionado'] and $row_cbi['estado'] <> $row_colores['preingresada'] and $row_cbi['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_cbi['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cbi['estado'] <> $row_colores['reparada'] and $row_cbi['estado'] <> $row_colores['pendiente'] and $row_cbi['estado'] <> $row_colores['preingresada'] and $row_cbi['estado'] <> $row_colores['cursada'] and $row_cbi['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_cbi['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cbi['estado'] <> $row_colores['reparada'] and $row_cbi['estado'] <> $row_colores['pendiente'] and $row_cbi['estado'] <> $row_colores['solucionado'] and $row_cbi['estado'] <> $row_colores['cursada'] and $row_cbi['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      </span>
      <span class="Naranja2"><?php echo $row_cbi['estado']; ?></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_cbi['estado'] <> $row_colores['reparada'] and $row_cbi['estado'] <> $row_colores['pendiente'] and $row_cbi['estado'] <> $row_colores['solucionado'] and $row_cbi['estado'] <> $row_colores['cursada'] and $row_cbi['estado'] <> $row_colores['preingresada']) { // Show if not first page ?>
      </span>
      <span class="Gris2"><?php echo $row_cbi['estado']; ?></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" class="respuestacolumna_rojo"><?php echo strtoupper($row_cbi['reparo_obs']); ?></td>
    <td align="center"><?php echo $row_cbi['date_supe']; ?></td>
    <td align="center"><?php echo $row_cbi['tipo_operacion']; ?> </td>
    <td align="center"><?php if ($row_cbi['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cbi['urgente']; ?></span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cbi['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cbi['urgente']; ?></span></span>
      <?php } // Show if not first page ?>      </div></td>
    </tr>
  <?php } while ($row_cbi = mysqli_fetch_assoc($cbi)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_meco > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="left" bgcolor="#999999">
    <td colspan="14" align="left" valign="middle"><span class="Estilo10"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></span><span class="Estilo5">Total Operaciones Enviadas a Curse&nbsp;<span class="tituloverde"><?php echo $totalRows_meco ?></span> Mercado de Corredores </span></td>
  </tr>
  <tr align="center" bgcolor="#999999">
    <td align="center" valign="middle"><span class="titulocolumnas">Nro Folio</span></td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador </td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor       
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente</td>
    </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_meco['id']; ?></td>
      <td align="center" valign="middle"><?php echo $row_meco['date_espe']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_meco['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_meco['nombre_cliente']); ?> </td>
      <td align="center" valign="middle"><?php echo $row_meco['evento']; ?></td>
      <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_meco['moneda_operacion']); ?></span><br>
        <strong class="respuestacolumna_azul"><?php echo number_format($row_meco['monto_operacion'], 2, ',', '.'); ?></strong></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_meco['especialista_curse']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_meco['operador']); ?></td>
      <td align="center" valign="middle"><?php echo $row_meco['sub_estado']; ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_meco['asignador']); ?></td>
      <td align="center" valign="middle"><?php if ($row_meco['estado'] <> $row_colores['cursada'] and $row_meco['estado'] <> $row_colores['pendiente'] and $row_meco['estado'] <> $row_colores['solucionado'] and $row_meco['estado'] <> $row_colores['preingresada'] and $row_meco['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_meco['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_meco['estado'] <> $row_colores['reparada'] and $row_meco['estado'] <> $row_colores['pendiente'] and $row_meco['estado'] <> $row_colores['solucionado'] and $row_meco['estado'] <> $row_colores['preingresada'] and $row_meco['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_meco['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_meco['estado'] <> $row_colores['reparada'] and $row_meco['estado'] <> $row_colores['cursada'] and $row_meco['estado'] <> $row_colores['solucionado'] and $row_meco['estado'] <> $row_colores['preingresada'] and $row_meco['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_meco['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_meco['estado'] <> $row_colores['reparada'] and $row_meco['estado'] <> $row_colores['pendiente'] and $row_meco['estado'] <> $row_colores['preingresada'] and $row_meco['estado'] <> $row_colores['cursada'] and $row_meco['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_meco['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_meco['estado'] <> $row_colores['reparada'] and $row_meco['estado'] <> $row_colores['pendiente'] and $row_meco['estado'] <> $row_colores['solucionado'] and $row_meco['estado'] <> $row_colores['cursada'] and $row_meco['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_meco['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_meco['estado'] <> $row_colores['reparada'] and $row_meco['estado'] <> $row_colores['pendiente'] and $row_meco['estado'] <> $row_colores['solucionado'] and $row_meco['estado'] <> $row_colores['cursada'] and $row_meco['estado'] <> $row_colores['preingresada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_meco['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
      <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_meco['reparo_obs']); ?></td>
      <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_meco['date_supe']; ?></td>
      <td align="center" valign="middle"><?php if ($row_meco['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_meco['urgente']; ?> </span></span>        
        <?php } // Show if not first page ?>
        <?php if ($row_meco['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_meco['urgente']; ?> </span></span>
        <?php } // Show if not first page ?> </td>
      </tr>
    <?php } while ($row_meco = mysqli_fetch_assoc($meco)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_cce > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="15" align="left" valign="middle"><span class="Estilo10"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></span><span class="Estilo5">Total Operaciones Enviadas a Curse </span><span class="tituloverde"><?php echo $totalRows_cce ?> </span><span class="Estilo5">Carta de Cr&eacute;dito Exportaci&oacute;n</span></div></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Operador
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
    </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_cce['id']; ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_cce['date_espe']; ?></div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cce['rut_cliente']); ?></div></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_cce['nombre_cliente']); ?> </td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_cce['nro_operacion']); ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_cce['evento']; ?> </div></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_cce['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_cce['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cce['especialista_curse']); ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cce['operador']); ?></div></td>
    <td align="center" valign="middle"><?php echo $row_cce['sub_estado']; ?> </div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cce['asignador']); ?> </div></td>
    <td align="center" valign="middle"><?php if ($row_cce['estado'] <> $row_colores['cursada'] and $row_cce['estado'] <> $row_colores['pendiente'] and $row_cce['estado'] <> $row_colores['solucionado'] and $row_cce['estado'] <> $row_colores['preingresada'] and $row_cce['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cce['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cce['estado'] <> $row_colores['reparada'] and $row_cce['estado'] <> $row_colores['pendiente'] and $row_cce['estado'] <> $row_colores['solucionado'] and $row_cce['estado'] <> $row_colores['preingresada'] and $row_cce['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cce['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cce['estado'] <> $row_colores['reparada'] and $row_cce['estado'] <> $row_colores['cursada'] and $row_cce['estado'] <> $row_colores['solucionado'] and $row_cce['estado'] <> $row_colores['preingresada'] and $row_cce['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_cce['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cce['estado'] <> $row_colores['reparada'] and $row_cce['estado'] <> $row_colores['pendiente'] and $row_cce['estado'] <> $row_colores['preingresada'] and $row_cce['estado'] <> $row_colores['cursada'] and $row_cce['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_cce['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cce['estado'] <> $row_colores['reparada'] and $row_cce['estado'] <> $row_colores['pendiente'] and $row_cce['estado'] <> $row_colores['solucionado'] and $row_cce['estado'] <> $row_colores['cursada'] and $row_cce['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_cce['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_cce['estado'] <> $row_colores['reparada'] and $row_cce['estado'] <> $row_colores['pendiente'] and $row_cce['estado'] <> $row_colores['solucionado'] and $row_cce['estado'] <> $row_colores['cursada'] and $row_cce['estado'] <> $row_colores['preingresada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_cce['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_cce['reparo_obs']); ?></td>
    <td align="center" valign="middle"><?php echo $row_cce['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_cce['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cce['urgente']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cce['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cce['urgente']; ?> </span></span>
      <?php } // Show if not first page ?> 
      </div>      </div></td>
    </tr>
  <?php } while ($row_cce = mysqli_fetch_assoc($cce)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_pre > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="15" align="left" valign="middle"><span class="Estilo13 Estilo10"><strong><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></strong></span><span class="Estilo13 Estilo5"><strong>Total Operaciones Enviadas a Curse </strong></span><span class="Estilo13 Estilo15"><strong><span class="tituloverde"><?php echo $totalRows_pre ?> </span></strong></span><span class="Estilo13 Estilo5"><strong>Pr&eacute;stamos</strong></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Operador
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
    </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><?php echo $row_pre['id']; ?></td>
    <td align="center" valign="middle"><?php echo $row_pre['date_espe']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_pre['rut_cliente']); ?> </td>
    <td align="left" valign="middle"><?php echo strtoupper($row_pre['nombre_cliente']); ?> </td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_pre['nro_operacion']); ?> </td>
    <td align="center" valign="middle"><?php echo $row_pre['evento']; ?> </td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_pre['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_pre['monto_operacion'], 2, ',', '.'); ?></strong></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_pre['especialista_curse']); ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_pre['operador']); ?></td>
    <td align="center" valign="middle"><?php echo $row_pre['sub_estado']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_pre['asignador']); ?></td>
    <td align="center" valign="middle"><?php if ($row_pre['estado'] <> $row_colores['cursada'] and $row_pre['estado'] <> $row_colores['pendiente'] and $row_pre['estado'] <> $row_colores['solucionado'] and $row_pre['estado'] <> $row_colores['preingresada'] and $row_pre['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_pre['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_pre['estado'] <> $row_colores['reparada'] and $row_pre['estado'] <> $row_colores['pendiente'] and $row_pre['estado'] <> $row_colores['solucionado'] and $row_pre['estado'] <> $row_colores['preingresada'] and $row_pre['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_pre['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_pre['estado'] <> $row_colores['reparada'] and $row_pre['estado'] <> $row_colores['cursada'] and $row_pre['estado'] <> $row_colores['solucionado'] and $row_pre['estado'] <> $row_colores['preingresada'] and $row_pre['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_pre['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_pre['estado'] <> $row_colores['reparada'] and $row_pre['estado'] <> $row_colores['pendiente'] and $row_pre['estado'] <> $row_colores['preingresada'] and $row_pre['estado'] <> $row_colores['cursada'] and $row_pre['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_pre['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_pre['estado'] <> $row_colores['reparada'] and $row_pre['estado'] <> $row_colores['pendiente'] and $row_pre['estado'] <> $row_colores['solucionado'] and $row_pre['estado'] <> $row_colores['cursada'] and $row_pre['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_pre['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_pre['estado'] <> $row_colores['reparada'] and $row_pre['estado'] <> $row_colores['pendiente'] and $row_pre['estado'] <> $row_colores['solucionado'] and $row_pre['estado'] <> $row_colores['cursada'] and $row_pre['estado'] <> $row_colores['preingresada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_pre['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_pre['reparo_obs']); ?></td>
    <td align="center" valign="middle"><?php echo $row_pre['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_pre['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_pre['urgente']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_pre['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_pre['urgente']; ?> </span></span>
      <?php } // Show if not first page ?>  </div></td>
    </tr>
  <?php } while ($row_pre = mysqli_fetch_assoc($pre)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_cbe > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="15" align="left" valign="middle"><span class="Estilo13 Estilo10"><strong><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></strong></span><span class="Estilo13 Estilo5"><strong>Total Operaciones Enviadas a Curse </strong></span><span class="Estilo13 Estilo15"><strong><span class="tituloverde"><?php echo $totalRows_cbe ?> </span></strong></span><span class="Estilo13 Estilo5"><strong>Cobranza Extranjera de Exportaci&oacute;n </strong></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulodetalle"><span class="titulocolumnas">Nro Folio </span></td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Operador
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
    </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_cbe['id']; ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_cbe['date_espe']; ?> </td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cbe['rut_cliente']); ?> </td>
    <td align="left" valign="middle"><?php echo strtoupper($row_cbe['nombre_cliente']); ?> </td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_cbe['nro_operacion']); ?></td>
    <td align="center" valign="middle"><?php echo $row_cbe['evento']; ?></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_cbe['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_cbe['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cbe['especialista_curse']); ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cbe['operador']); ?> </td>
    <td align="center" valign="middle"><?php echo $row_cbe['sub_estado']; ?> </td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cbe['asignador']); ?> </td>
    <td align="center" valign="middle"><?php if ($row_cbe['estado'] <> $row_colores['cursada'] and $row_cbe['estado'] <> $row_colores['pendiente'] and $row_cbe['estado'] <> $row_colores['solucionado'] and $row_cbe['estado'] <> $row_colores['preingresada'] and $row_cbe['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cbe['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cbe['estado'] <> $row_colores['reparada'] and $row_cbe['estado'] <> $row_colores['pendiente'] and $row_cbe['estado'] <> $row_colores['solucionado'] and $row_cbe['estado'] <> $row_colores['preingresada'] and $row_cbe['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cbe['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cbe['estado'] <> $row_colores['reparada'] and $row_cbe['estado'] <> $row_colores['cursada'] and $row_cbe['estado'] <> $row_colores['solucionado'] and $row_cbe['estado'] <> $row_colores['preingresada'] and $row_cbe['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_cbe['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cbe['estado'] <> $row_colores['reparada'] and $row_cbe['estado'] <> $row_colores['pendiente'] and $row_cbe['estado'] <> $row_colores['preingresada'] and $row_cbe['estado'] <> $row_colores['cursada'] and $row_cbe['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_cbe['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cbe['estado'] <> $row_colores['reparada'] and $row_cbe['estado'] <> $row_colores['pendiente'] and $row_cbe['estado'] <> $row_colores['solucionado'] and $row_cbe['estado'] <> $row_colores['cursada'] and $row_cbe['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_cbe['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_cbe['estado'] <> $row_colores['reparada'] and $row_cbe['estado'] <> $row_colores['pendiente'] and $row_cbe['estado'] <> $row_colores['solucionado'] and $row_cbe['estado'] <> $row_colores['cursada'] and $row_cbe['estado'] <> $row_colores['preingresada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_cbe['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div> </td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_cbe['reparo_obs']); ?></td>
    <td align="center" valign="middle"><?php echo $row_cbe['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_cbe['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cbe['urgente']; ?> </span>   
      <?php } // Show if not first page ?>
      <?php if ($row_cbe['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cbe['urgente']; ?> </span>
      <?php } // Show if not first page ?></td>
    </tr>
  <?php } while ($row_cbe = mysqli_fetch_assoc($cbe)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_cdpa > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td colspan="15" align="left" valign="middle"><span class="Estilo13 Estilo10"><strong><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></strong></span><span class="Estilo13 Estilo5"><strong>Total Operaciones Enviadas a Curse </strong></span><span class="Estilo13 Estilo15"><strong><span class="tituloverde"><?php echo $totalRows_cdpa ?> </span></strong></span><span class="Estilo13 Estilo5"><strong>Cesi&oacute;n de Derecho o Pago Anticipado </strong></span></div></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center" valign="middle"><span class="titulocolumnas">Nro Folio </span></td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda /<br> 
      Monto Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Operador
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
    </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_cdpa['id']; ?></span></td>
    <td align="center" valign="middle"><?php echo $row_cdpa['date_espe']; ?> </td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cdpa['rut_cliente']); ?> </td>
    <td align="left" valign="middle"><?php echo strtoupper($row_cdpa['nombre_cliente']); ?> </td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_cdpa['nro_operacion']); ?> </td>
    <td align="center" valign="middle"><?php echo $row_cdpa['evento']; ?> </td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_cdpa['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_cdpa['monto_operacion'], 2, ',', '.'); ?></strong></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cdpa['especialista_curse']); ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cdpa['operador']); ?> </td>
    <td align="center" valign="middle"><?php echo $row_cdpa['sub_estado']; ?> </td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cdpa['asignador']); ?> </td>
    <td align="center" valign="middle"><?php if ($row_cdpa['estado'] <> $row_colores['cursada'] and $row_cdpa['estado'] <> $row_colores['pendiente'] and $row_cdpa['estado'] <> $row_colores['solucionado'] and $row_cdpa['estado'] <> $row_colores['preingresada'] and $row_cdpa['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cdpa['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cdpa['estado'] <> $row_colores['reparada'] and $row_cdpa['estado'] <> $row_colores['pendiente'] and $row_cdpa['estado'] <> $row_colores['solucionado'] and $row_cdpa['estado'] <> $row_colores['preingresada'] and $row_cdpa['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cdpa['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cdpa['estado'] <> $row_colores['reparada'] and $row_cdpa['estado'] <> $row_colores['cursada'] and $row_cdpa['estado'] <> $row_colores['solucionado'] and $row_cdpa['estado'] <> $row_colores['preingresada'] and $row_cdpa['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_cdpa['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cdpa['estado'] <> $row_colores['reparada'] and $row_cdpa['estado'] <> $row_colores['pendiente'] and $row_cdpa['estado'] <> $row_colores['preingresada'] and $row_cdpa['estado'] <> $row_colores['cursada'] and $row_cdpa['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_cdpa['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cdpa['estado'] <> $row_colores['reparada'] and $row_cdpa['estado'] <> $row_colores['pendiente'] and $row_cdpa['estado'] <> $row_colores['solucionado'] and $row_cdpa['estado'] <> $row_colores['cursada'] and $row_cdpa['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_cdpa['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_cdpa['estado'] <> $row_colores['reparada'] and $row_cdpa['estado'] <> $row_colores['pendiente'] and $row_cdpa['estado'] <> $row_colores['solucionado'] and $row_cdpa['estado'] <> $row_colores['cursada'] and $row_cdpa['estado'] <> $row_colores['preingresada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_cdpa['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_cdpa['reparo_obs']); ?></td>
    <td align="center" valign="middle"><?php echo $row_cdpa['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_cdpa['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cdpa['urgente']; ?> </span>   
      <?php } // Show if not first page ?>
      <?php if ($row_cdpa['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cdpa['urgente']; ?> </span>
      <?php } // Show if not first page ?>      </div></td>
    </tr>
  <?php } while ($row_cdpa = mysqli_fetch_assoc($cdpa)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_ste > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="15" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" class="Estilo13"><span class="Estilo13 Estilo5"><strong>Total Operaciones Enviadas a Curse <span class="tituloverde"><?php echo $totalRows_ste ?></span> Stand By Emitidas </strong></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio
      </div></td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Operador
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
    </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_ste['id']; ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_ste['date_espe']; ?></div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_ste['rut_cliente']); ?></div></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_ste['nombre_cliente']); ?></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_ste['nro_operacion']); ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_ste['evento']; ?></div></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_ste['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_ste['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_ste['especialista_curse']); ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_ste['operador']); ?></div></td>
    <td align="center" valign="middle"><?php echo $row_ste['sub_estado']; ?> </div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_ste['asignador']); ?> </div></td>
    <td align="center" valign="middle"><?php if ($row_ste['estado'] <> $row_colores['cursada'] and $row_ste['estado'] <> $row_colores['pendiente'] and $row_ste['estado'] <> $row_colores['solucionado'] and $row_ste['estado'] <> $row_colores['preingresada'] and $row_ste['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_ste['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_ste['estado'] <> $row_colores['reparada'] and $row_ste['estado'] <> $row_colores['pendiente'] and $row_ste['estado'] <> $row_colores['solucionado'] and $row_ste['estado'] <> $row_colores['preingresada'] and $row_ste['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_ste['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_ste['estado'] <> $row_colores['reparada'] and $row_ste['estado'] <> $row_colores['cursada'] and $row_ste['estado'] <> $row_colores['solucionado'] and $row_ste['estado'] <> $row_colores['preingresada'] and $row_ste['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_ste['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_ste['estado'] <> $row_colores['reparada'] and $row_ste['estado'] <> $row_colores['pendiente'] and $row_ste['estado'] <> $row_colores['preingresada'] and $row_ste['estado'] <> $row_colores['cursada'] and $row_ste['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_ste['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_ste['estado'] <> $row_colores['reparada'] and $row_ste['estado'] <> $row_colores['pendiente'] and $row_ste['estado'] <> $row_colores['solucionado'] and $row_ste['estado'] <> $row_colores['cursada'] and $row_ste['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_ste['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_ste['estado'] <> $row_colores['reparada'] and $row_ste['estado'] <> $row_colores['pendiente'] and $row_ste['estado'] <> $row_colores['solucionado'] and $row_ste['estado'] <> $row_colores['cursada'] and $row_ste['estado'] <> $row_colores['preingresada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_ste['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_ste['reparo_obs']); ?></td>
    <td align="center" valign="middle"><?php echo $row_ste['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_ste['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_ste['urgente']; ?> </span>   
      <?php } // Show if not first page ?>
      <?php if ($row_ste['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_ste['urgente']; ?> </span>
      <?php } // Show if not first page ?> </div>      </div></td>
    </tr>
  <?php } while ($row_ste = mysqli_fetch_assoc($ste)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_bga > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="15" align="left" valign="middle"><span class="Estilo10"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo18">Total Operaciones Enviadas a Curse <span class="tituloverde"><?php echo $totalRows_bga ?></span> Boletas de Garant&iacute;a</span></span></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center" valign="middle"><span class="titulocolumnas">Nro Folio </span></td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador</td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente</td>
    </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_bga['id']; ?></td>
    <td align="center" valign="middle"><?php echo $row_bga['date_espe']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_bga['rut_cliente']); ?></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_bga['nombre_cliente']); ?></td>
    <td align="center" valign="middle" class="rojopequeno"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_bga['nro_operacion']); ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_bga['evento']; ?></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_bga['moneda_operacion']); ?></span><br>
        <strong class="respuestacolumna_azul"><?php echo number_format($row_bga['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_bga['especialista_curse']); ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_bga['operador']); ?></td>
    <td align="center" valign="middle"><?php echo $row_bga['sub_estado']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_bga['asignador']); ?></td>
    <td align="center" valign="middle"><?php if ($row_bga['estado'] <> $row_colores['cursada'] and $row_bga['estado'] <> $row_colores['pendiente'] and $row_bga['estado'] <> $row_colores['solucionado'] and $row_bga['estado'] <> $row_colores['preingresada'] and $row_bga['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_bga['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_bga['estado'] <> $row_colores['reparada'] and $row_bga['estado'] <> $row_colores['pendiente'] and $row_bga['estado'] <> $row_colores['solucionado'] and $row_bga['estado'] <> $row_colores['preingresada'] and $row_bga['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_bga['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_bga['estado'] <> $row_colores['reparada'] and $row_bga['estado'] <> $row_colores['cursada'] and $row_bga['estado'] <> $row_colores['solucionado'] and $row_bga['estado'] <> $row_colores['preingresada'] and $row_bga['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_bga['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_bga['estado'] <> $row_colores['reparada'] and $row_bga['estado'] <> $row_colores['pendiente'] and $row_bga['estado'] <> $row_colores['preingresada'] and $row_bga['estado'] <> $row_colores['cursada'] and $row_bga['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_bga['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_bga['estado'] <> $row_colores['reparada'] and $row_bga['estado'] <> $row_colores['pendiente'] and $row_bga['estado'] <> $row_colores['solucionado'] and $row_bga['estado'] <> $row_colores['cursada'] and $row_bga['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_bga['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_bga['estado'] <> $row_colores['reparada'] and $row_bga['estado'] <> $row_colores['pendiente'] and $row_bga['estado'] <> $row_colores['solucionado'] and $row_bga['estado'] <> $row_colores['cursada'] and $row_bga['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_bga['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_bga['reparo_obs']); ?></td>
    <td align="center" valign="middle"><?php echo $row_bga['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_bga['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_bga['urgente']; ?> </span>   
      <?php } // Show if not first page ?>
      <?php if ($row_bga['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_bga['urgente']; ?> </span>
      <?php } // Show if not first page ?></td>
    </tr>
  <?php } while ($row_bga = mysqli_fetch_assoc($bga)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_cex > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td colspan="16" align="left"><span class="Estilo13"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="titulodetalle">Total Operaciones Enviadas a Curse </span><span class="tituloverde"><?php echo $totalRows_cex ?></span><span class="titulodetalle"> Otros Productos de Cambio 
        </div>
      </span></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center"><span class="titulocolumnas">Nro Folio </span></td>
    <td align="center" class="titulocolumnas">Fecha Ingreso </td>
    <td align="center" class="titulocolumnas">Tipo Operaci&oacute;n </td>
    <td align="center" class="titulocolumnas">Rut Cliente </td>
    <td align="center" class="titulocolumnas">Nombre Cliente </td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </td>
    <td align="center" class="titulocolumnas">Evento</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </td>
    <td align="center" class="titulocolumnas">Especialista Curse</td>
    <td align="center" class="titulocolumnas">Operador</td>
    <td align="center" class="titulocolumnas">Estado Operador </td>
    <td align="center" class="titulocolumnas">Supervisor</td>
    <td align="center" class="titulocolumnas">Estado Supervisor </td>
    <td align="center" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" class="titulocolumnas">Fecha Curse</td>
    <td align="center" class="titulocolumnas">Urgente</td>
    </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center" class="respuestacolumna_rojo"><?php echo $row_cex['id']; ?></td>
    <td align="center"><?php echo $row_cex['date_espe']; ?> </td>
    <td align="center"><?php echo $row_cex['tipo_operacion']; ?> </td>
    <td align="center"><?php echo strtoupper($row_cex['rut_cliente']); ?> </td>
    <td align="left"><?php echo strtoupper($row_cex['nombre_cliente']); ?> </td>
    <td align="center" class="respuestacolumna_rojo"><?php echo strtoupper($row_cex['nro_operacion']); ?> </td>
    <td align="center"><?php echo $row_cex['evento']; ?> </td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_cex['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_cex['monto_operacion'], 2, ',', '.'); ?></strong> </td>
    <td align="center"><?php echo strtoupper($row_cex['especialista_curse']); ?></td>
    <td align="center"><?php echo strtoupper($row_cex['operador']); ?> </td>
    <td align="center"><?php echo $row_cex['sub_estado']; ?> </td>
    <td align="center"><?php echo strtoupper($row_cex['asignador']); ?></td>
    <td align="center"><?php if ($row_cex['estado'] <> $row_colores['cursada'] and $row_cex['estado'] <> $row_colores['pendiente'] and $row_cex['estado'] <> $row_colores['solucionado'] and $row_cex['estado'] <> $row_colores['preingresada'] and $row_cex['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cex['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_cex['estado'] <> $row_colores['reparada'] and $row_cex['estado'] <> $row_colores['pendiente'] and $row_cex['estado'] <> $row_colores['solucionado'] and $row_cex['estado'] <> $row_colores['preingresada'] and $row_cex['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cex['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cex['estado'] <> $row_colores['reparada'] and $row_cex['estado'] <> $row_colores['cursada'] and $row_cex['estado'] <> $row_colores['solucionado'] and $row_cex['estado'] <> $row_colores['preingresada'] and $row_cex['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_cex['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cex['estado'] <> $row_colores['reparada'] and $row_cex['estado'] <> $row_colores['pendiente'] and $row_cex['estado'] <> $row_colores['preingresada'] and $row_cex['estado'] <> $row_colores['cursada'] and $row_cex['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_cex['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_cex['estado'] <> $row_colores['reparada'] and $row_cex['estado'] <> $row_colores['pendiente'] and $row_cex['estado'] <> $row_colores['solucionado'] and $row_cex['estado'] <> $row_colores['cursada'] and $row_cex['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_cex['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_cex['estado'] <> $row_colores['reparada'] and $row_cex['estado'] <> $row_colores['pendiente'] and $row_cex['estado'] <> $row_colores['solucionado'] and $row_cex['estado'] <> $row_colores['cursada'] and $row_cex['estado'] <> $row_colores['preingresada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_cex['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" class="respuestacolumna_rojo"><?php echo strtoupper($row_cex['reparo_obs']); ?></td>
    <td align="center"><?php echo $row_cex['date_supe']; ?></td>
    <td align="center"><?php if ($row_cex['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_cex['urgente']; ?> </span>   
      <?php } // Show if not first page ?>
      <?php if ($row_cex['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_cex['urgente']; ?> </span>
      <?php } // Show if not first page ?></td>
    </tr>
  <?php } while ($row_cex = mysqli_fetch_assoc($cex)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_tbc > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="left" valign="middle" bgcolor="#999999">
    <td colspan="15" align="left" valign="middle"><span class="Estilo10"><span class="Estilo13"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo18">Total Operaciones Enviadas a Curse </span></span></span><span class="tituloverde"><?php echo $totalRows_tbc ?></span><span class="Estilo10"><span class="Estilo13"><span class="Estilo18"> Cr&eacute;ditos IIIB5</span></span></span></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center" valign="middle"><span class="titulocolumnas">Nro Folio </span></td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Operador </td>
    <td align="center" valign="middle" class="titulocolumnas">Supervisor</td>
    <td align="center" valign="middle" class="titulocolumnas">Estado Supervisor </td>
    <td align="center" valign="middle" class="titulocolumnas">Motivo Reparo</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente</td>
    </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_tbc['id']; ?></td>
    <td align="center" valign="middle"><?php echo $row_tbc['date_espe']; ?> </td>
    <td align="center" valign="middle"><?php echo strtoupper($row_tbc['rut_cliente']); ?> </td>
    <td align="left" valign="middle"><?php echo strtoupper($row_tbc['nombre_cliente']); ?> </td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_tbc['nro_operacion']); ?> </td>
    <td align="center" valign="middle"><?php echo $row_tbc['evento']; ?> </td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_tbc['moneda_operacion']; ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_tbc['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_tbc['especialista_curse']); ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_tbc['operador']); ?> </td>
    <td align="center" valign="middle"><?php echo $row_tbc['sub_estado']; ?> </td>
    <td align="center" valign="middle"><?php echo strtoupper($row_tbc['asignador']); ?> </td>
    <td align="center" valign="middle"><?php if ($row_tbc['estado'] <> $row_colores['cursada'] and $row_tbc['estado'] <> $row_colores['pendiente'] and $row_tbc['estado'] <> $row_colores['solucionado'] and $row_tbc['estado'] <> $row_colores['preingresada'] and $row_tbc['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_tbc['estado']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_tbc['estado'] <> $row_colores['reparada'] and $row_tbc['estado'] <> $row_colores['pendiente'] and $row_tbc['estado'] <> $row_colores['solucionado'] and $row_tbc['estado'] <> $row_colores['preingresada'] and $row_tbc['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_tbc['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_tbc['estado'] <> $row_colores['reparada'] and $row_tbc['estado'] <> $row_colores['cursada'] and $row_tbc['estado'] <> $row_colores['solucionado'] and $row_tbc['estado'] <> $row_colores['preingresada'] and $row_tbc['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Amarillo2"><?php echo $row_tbc['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_tbc['estado'] <> $row_colores['reparada'] and $row_tbc['estado'] <> $row_colores['pendiente'] and $row_tbc['estado'] <> $row_colores['preingresada'] and $row_tbc['estado'] <> $row_colores['cursada'] and $row_tbc['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Azul2"><?php echo $row_tbc['estado']; ?> </span></span>
      <?php } // Show if not first page ?>
      <?php if ($row_tbc['estado'] <> $row_colores['reparada'] and $row_tbc['estado'] <> $row_colores['pendiente'] and $row_tbc['estado'] <> $row_colores['solucionado'] and $row_tbc['estado'] <> $row_colores['cursada'] and $row_tbc['estado'] <> $row_colores['eliminada']) { // Show if not first page ?>
      <span class="Naranja2"><?php echo $row_tbc['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      
      <?php if ($row_tbc['estado'] <> $row_colores['reparada'] and $row_tbc['estado'] <> $row_colores['pendiente'] and $row_tbc['estado'] <> $row_colores['solucionado'] and $row_tbc['estado'] <> $row_colores['cursada'] and $row_tbc['estado'] <> $row_colores['preingresada']) { // Show if not first page ?>
      <span class="Gris2"><?php echo $row_tbc['estado']; ?> </span></span>
      <?php } // Show if not first page ?>      </div></td>
    <td align="left" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_tbc['reparo_obs']); ?></td>
    <td align="center" valign="middle"><?php echo $row_tbc['date_supe']; ?></td>
    <td align="center" valign="middle"><?php if ($row_tbc['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_tbc['urgente']; ?> </span>   
      <?php } // Show if not first page ?>
      <?php if ($row_tbc['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_tbc['urgente']; ?> </span>
      <?php } // Show if not first page ?></td>
    </tr>
  <?php } while ($row_tbc = mysqli_fetch_assoc($tbc)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
</body>
</html>
<?php
mysqli_free_result($reparos);
mysqli_free_result($colores);
mysqli_free_result($meco);
mysqli_free_result($cbi);
mysqli_free_result($cce);
mysqli_free_result($pre);
mysqli_free_result($cbe);
mysqli_free_result($cdpa);
mysqli_free_result($ste);
mysqli_free_result($cex);
mysqli_free_result($tbc);
mysqli_free_result($bga);
?>