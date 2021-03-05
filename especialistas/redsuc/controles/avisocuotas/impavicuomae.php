<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,RED";
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
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_avisocuotas = 100;
$pageNum_avisocuotas = 0;
if (isset($_GET['pageNum_opcce'])) {
  $pageNum_avisocuotas = $_GET['pageNum_opcce'];
}
$startRow_avisocuotas = $pageNum_avisocuotas * $maxRows_avisocuotas;

$colname_avisocuotas = "1";
if (isset($_GET['nro_operacion'])) {
  $colname_avisocuotas = $_GET['nro_operacion'];
}
$colname1_avisocuotas = "Aviso Cuotas.";
if (isset($_GET['evento'])) {
  $colname1_avisocuotas = $_GET['evento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_avisocuotas = sprintf("SELECT * FROM oppre nolock WHERE nro_operacion = %s and evento = %s ORDER BY id DESC", GetSQLValueString($colname_avisocuotas, "text"),GetSQLValueString($colname1_avisocuotas, "text"));
$query_limit_avisocuotas = sprintf("%s LIMIT %d, %d", $query_avisocuotas, $startRow_avisocuotas, $maxRows_avisocuotas);
$avisocuotas = mysqli_query($comercioexterior, $query_avisocuotas) or die(mysqli_error($comercioexterior));
$row_avisocuotas = mysqli_fetch_assoc($avisocuotas);
$totalRows_avisocuotas = mysqli_num_rows($avisocuotas);

if (isset($_GET['totalRows_avisocuotas'])) {
  $totalRows_avisocuotas = $_GET['totalRows_avisocuotas'];
} else {
  $all_avisocuotas = mysqli_query($comercioexterior, $query_avisocuotas);
  $totalRows_avisocuotas = mysqli_num_rows($all_avisocuotas);
}
$totalPages_avisocuotas = ceil($totalRows_avisocuotas/$maxRows_avisocuotas)-1;

$queryString_avisocuotas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_opcce") == false && 
        stristr($param, "totalRows_opcce") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_avisocuotas = "&" . htmlentities(implode("&", $newParams));
  }
}

$queryString_avisocuotas = sprintf("&totalRows_opcce=%d%s", $totalRows_avisocuotas, $queryString_avisocuotas);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Carta Reparo - Maestro</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
	color: #00F;
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
.Estilo6 {color: #FFFFFF; font-weight: bold; }
.Estilo8 {
	font-size: 12px;
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
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">IMPRESION AVISO CUOTA - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">TERRITORIALES - RED DE SUCURSALES</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><span class="Estilo8"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"> Impresi&oacute;n Aviso Cuota</span></td>
    </tr>
    <tr valign="middle">
      <td width="22%" align="right">Nro Operaci&oacute;n:</td>
      <td width="78%" align="left"><label>
        <input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7">
      <span class="rojopequeno">F000000</span></label></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<?php if ($totalRows_avisocuotas > 0) { // Show if recordset not empty ?>
  <br>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td align="center" class="titulocolumnas">Imprimir</div></td>
      <td align="center" class="titulocolumnas">Nro Operaci&oacute;n</div></td>
      <td align="center" class="titulocolumnas">Fecha Ingreso</div></td>
      <td align="center" class="titulocolumnas">Rut Cliente</div></td>
      <td align="center" class="titulocolumnas">Nombre Cliente</div></td>
      <td align="center" class="titulocolumnas">Evento</div></td>
    </tr>
    <?php do { ?>

    <tr valign="middle">      
        <td align="center"><a href="impavicuodet.php?recordID=<?php echo $row_avisocuotas['id']; ?>"> <img src="../../../../imagenes/ICONOS/impresora_2.jpg" width="27" height="21" border="0"></a>
          </div></td>
        <td align="center"><span class="respuestacolumna_rojo"><?php echo $row_avisocuotas['nro_operacion']; ?></span>
          </div></td>
        <td align="center"><?php echo $row_avisocuotas['fecha_ingreso']; ?>
          </div></td>
        <td align="center"><?php echo $row_avisocuotas['rut_cliente']; ?>
          </div></td>
        <td align="left"><?php echo $row_avisocuotas['nombre_cliente']; ?></td>
        <td align="center"><?php echo $row_avisocuotas['evento']; ?>
          </div></td>
        <?php } while ($row_avisocuotas = mysqli_fetch_assoc($avisocuotas)); ?>
    </tr>
  </table>
  <br>
  <table border="0" width="50%" align="center">
    <tr>
      <td width="23%" align="center"><?php if ($pageNum_avisocuotas > 0) { // Show if not first page ?>
          Primero<a href="<?php printf("%s?pageNum_avisocuotas=%d%s", $currentPage, 0, $queryString_avisocuotas); ?>">Primero</a>
          <?php } // Show if not first page ?></td>
      <td width="31%" align="center"><?php if ($pageNum_avisocuotas > 0) { // Show if not first page ?>
          Anterior<a href="<?php printf("%s?pageNum_avisocuotas=%d%s", $currentPage, max(0, $pageNum_avisocuotas - 1), $queryString_avisocuotas); ?>">Anterior</a>
          <?php } // Show if not first page ?></td>
      <td width="23%" align="center"><?php if ($pageNum_avisocuotas < $totalPages_avisocuotas) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_avisocuotas=%d%s", $currentPage, min($totalPages_avisocuotas, $pageNum_avisocuotas + 1), $queryString_avisocuotas); ?>">Siguiente</a>
          <?php } // Show if not last page ?></td>
      <td width="23%" align="center"><?php if ($pageNum_avisocuotas < $totalPages_avisocuotas) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_avisocuotas=%d%s", $currentPage, $totalPages_avisocuotas, $queryString_avisocuotas); ?>">Último</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br>
  Registros del <strong><?php echo ($startRow_avisocuotas + 1) ?></strong> al <strong><?php echo min($startRow_avisocuotas + $maxRows_avisocuotas, $totalRows_avisocuotas) ?></strong> de un total de <strong><?php echo $totalRows_avisocuotas ?></strong
>
  <?php } // Show if recordset not empty ?>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../redsuc.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($avisocuotas);
?>