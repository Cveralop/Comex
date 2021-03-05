<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,ESP,SUP,GER";
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

//AGREGADO 1 para total de registros
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_altadocdis = 10;
$pageNum_altadocdis = 0;
if (isset($_GET['pageNum_altadocdis'])) {
  $pageNum_altadocdis = $_GET['pageNum_altadocdis'];
}
$startRow_altadocdis = $pageNum_altadocdis * $maxRows_altadocdis;

$colname_altadocdis = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname_altadocdis = $_GET['nro_operacion'];
}
$colname1_altadocdis = "Discrepancia.";
if (isset($_GET['tipo_negociacion'])) {
  $colname1_altadocdis = $_GET['tipo_negociacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_altadocdis = sprintf("SELECT * FROM opcci nolock WHERE nro_operacion = %s and tipo_negociacion = %s ORDER BY id DESC", GetSQLValueString($colname_altadocdis, "text"),GetSQLValueString($colname1_altadocdis, "text"));
$query_limit_altadocdis = sprintf("%s LIMIT %d, %d", $query_altadocdis, $startRow_altadocdis, $maxRows_altadocdis);
$altadocdis = mysqli_query($comercioexterior, $query_limit_altadocdis) or die(mysqli_error($comercioexterior));
$row_altadocdis = mysqli_fetch_assoc($altadocdis);
//$totalRows_altadocdis = mysqli_num_rows($altadocdis);

//AGREGADO 1.2 para total de registros
if (isset($_GET['totalRows_altadocdis'])) {
  $totalRows_altadocdis = $_GET['totalRows_altadocdis'];
} else {
  $all_altadocdis = mysqli_query($comercioexterior, $query_altadocdis);
  $totalRows_altadocdis = mysqli_num_rows($all_altadocdis);
}
$totalPages_altadocdis = ceil($totalRows_altadocdis/$maxRows_altadocdis)-1;

$queryString_altadocdis = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_altadocdis") == false && 
        stristr($param, "totalRows_altadocdis") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_altadocdis = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_altadocdis = sprintf("&totalRows_altadocdis=%d%s", $totalRows_altadocdis, $queryString_altadocdis);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Alta Doctos Embarque - Maestro</title>
<style type="text/css">
<!--
@import url(../../../../estilos/estilo12.css);
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
.Estilo5 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo8 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo10 {color: #00FF00}
-->
</style>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
</head>
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">ALTA DOCTOS CON DISCREPANCIAS - MAESTRO </td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">CARTAS DE CR&Eacute;DITO IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Alta Documentos con Discrepancia</span></td>
    </tr>
    <tr valign="middle">
      <td width="22%" align="right">Nro Operaci&oacute;n:</div></td>
      <td width="78%" align="left">        <input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7">
      <span class="rojopequeno">K000000</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar"></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_altadocdis > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="4" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Rut <span class="Estilo10"><?php echo $row_altadocdis['rut_cliente']; ?></span> Nombre Cliente <span class="Estilo10"><?php echo $row_altadocdis['nombre_cliente']; ?></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td><span class="titulocolumnas">Alzar</span></div></td>
    <td class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td class="titulocolumnas">Nro Operaci&oacute;n</div>      
      </div>
    </td>
    <td class="titulocolumnas">Moneda / Monto Documentos
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="altdocdisdet.php?recordID=<?php echo $row_altadocdis['id']; ?>"> <img src="../../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div></td>
    <td align="center"><?php echo $row_altadocdis['fecha_ingreso']; ?> </div></td>
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_altadocdis['nro_operacion']); ?></span> 
      </div>      
     </div></td>
    <td align="right">
        <span class="Estilo8"><?php echo strtoupper($row_altadocdis['moneda_documentos']); ?></span>&nbsp; <strong><?php echo number_format($row_altadocdis['monto_documentos'], 2, ',', '.'); ?></strong></td>
  </tr>
  <?php } while ($row_altadocdis = mysqli_fetch_assoc($altadocdis)); ?>
</table>
<br>
Registros del <strong><?php echo ($startRow_altadocdis + 1) ?></strong> al <strong><?php echo min($startRow_altadocdis + $maxRows_altadocdis, $totalRows_altadocdis) ?></strong> de un total de <strong><?php echo $totalRows_altadocdis ?></strong>
<?php } // Show if recordset not empty ?> 
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../opcci.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($altadocdis);
?>