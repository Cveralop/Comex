<?php require_once('../../../../Connections/comercioexterior.php'); ?>
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
$maxRows_nrooperacion = 20;
$pageNum_nrooperacion = 0;
if (isset($_GET['pageNum_nrooperacion'])) {
  $pageNum_nrooperacion = $_GET['pageNum_nrooperacion'];
}
$startRow_nrooperacion = $pageNum_nrooperacion * $maxRows_nrooperacion;

$colname_nrooperacion = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname_nrooperacion = $_GET['nro_operacion'];
}
$colname1_nrooperacion = "Apertura.";
if (isset($_GET['colname1'])) {
  $colname1_nrooperacion = $_GET['colname1'];
}
$colname2_nrooperacion = "-1";
if (isset($_GET['referencia'])) {
  $colname2_nrooperacion = $_GET['referencia'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_nrooperacion = sprintf("SELECT * FROM opcce nolock WHERE nro_operacion LIKE %s and evento = %s and referencia LIKE %s ORDER BY date_ingreso DESC", GetSQLValueString("%" . $colname_nrooperacion . "%", "text"),GetSQLValueString($colname1_nrooperacion, "text"),GetSQLValueString("%" . $colname2_nrooperacion . "%", "text"));
$query_limit_nrooperacion = sprintf("%s LIMIT %d, %d", $query_nrooperacion, $startRow_nrooperacion, $maxRows_nrooperacion);
$nrooperacion = mysqli_query($comercioexterior, $query_limit_nrooperacion) or die(mysqli_error($comercioexterior));
$row_nrooperacion = mysqli_fetch_assoc($nrooperacion);
$totalRows_nrooperacion = mysqli_num_rows($nrooperacion);

if (isset($_GET['totalRows_nrooperacion'])) {
  $totalRows_nrooperacion = $_GET['totalRows_nrooperacion'];
} else {
  $all_nrooperacion = mysqli_query($comercioexterior, $query_nrooperacion);
  $totalRows_nrooperacion = mysqli_num_rows($all_nrooperacion);
}
$totalPages_nrooperacion = ceil($totalRows_nrooperacion/$maxRows_nrooperacion)-1;

$queryString_nrooperacion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_nrooperacion") == false && 
        stristr($param, "totalRows_nrooperacion") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_nrooperacion = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_nrooperacion = sprintf("&totalRows_nrooperacion=%d%s", $totalRows_nrooperacion, $queryString_nrooperacion);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso Multiple Intrucciones - Maestro</title>
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
.Estilo7 {
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo11 {color: #FFFFFF; font-weight: bold; }

</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<style type="text/css">
<!--
.Estilo13 {
	color: #FF0000;
	font-weight: bold;
}

</style>
</head>
<body onLoad="MM_preloadImages('../../../../espcomex/imagenes/Botones/boton_volver_2.jpg','../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO MULTIPLE INSTRUCCIONES - MAESTRO </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTAS DE CR&Eacute;DITO DE EXPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form name="form2" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo7">Ingreso Multiple Instrucciones Carta de Cr&eacute;dito de Exportaci&oacute;n </span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Nro Operaci&oacute;n:</td>
<td width="79%" align="left" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="17" maxlength="7">
          <span class="rojopequeno">E000000</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Referencia Exterior:</td>
      <td align="left" valign="middle"><input name="referencia" type="text" class="etiqueta12" id="referencia" size="50" maxlength="50"></td>
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
<?php if ($totalRows_nrooperacion > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Ingreso Operaciones </div></td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><a href="ingdet2.php?recordID=<?php echo $row_nrooperacion['id']; ?>"> <img src="../../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_nrooperacion['rut_cliente']); ?> </div></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_nrooperacion['nombre_cliente']); ?> </td>
      <td align="left" valign="middle"><?php echo $row_nrooperacion['fecha_ingreso']; ?></td>
      <td align="left" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_nrooperacion['nro_operacion']); ?></span></td>
      <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_nrooperacion['moneda_operacion']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_nrooperacion['monto_operacion'], 2, ',', '.'); ?></span></td>
    </tr>
    <?php } while ($row_nrooperacion = mysqli_fetch_assoc($nrooperacion)); ?>
</table>
<br>

<table border="0" width="50%" align="center">
        <tr>
            <td width="23%" align="center"><?php if ($pageNum_nrooperacion > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_nrooperacion=%d%s", $currentPage, 0, $queryString_nrooperacion); ?>">Primero</a>
                <?php } // Show if not first page ?>
            </td>
            <td width="31%" align="center"><?php if ($pageNum_nrooperacion > 0) { // Show if not first page ?>
                <a
                    href="<?php printf("%s?pageNum_nrooperacion=%d%s", $currentPage, max(0, $pageNum_nrooperacion - 1), $queryString_nrooperacion); ?>">Anterior</a>
                <?php } // Show if not first page ?>
            </td>
            <td width="23%" align="center"><?php if ($pageNum_nrooperacion < $totalPages_nrooperacion) { // Show if not last page ?>
                <a
                    href="<?php printf("%s?pageNum_nrooperacion=%d%s", $currentPage, min($totalPages_nrooperacion, $pageNum_nrooperacion + 1), $queryString_nrooperacion); ?>">Siguiente</a>
                <?php } // Show if not last page ?>
            </td>
            <td width="23%" align="center"><?php if ($pageNum_nrooperacion < $totalPages_nrooperacion) { // Show if not last page ?>
                <a
                    href="<?php printf("%s?pageNum_nrooperacion=%d%s", $currentPage, $totalPages_nrooperacion, $queryString_nrooperacion); ?>">&Uacute;ltimo</a>
                <?php } // Show if not last page ?>
            </td>
        </tr>
    </table>

Registros del <strong><?php echo ($startRow_nrooperacion + 1) ?></strong> al <strong><?php echo min($startRow_nrooperacion + $maxRows_nrooperacion, $totalRows_nrooperacion) ?></strong> de un total de <strong><?php echo $totalRows_nrooperacion ?></strong>
<?php } // Show if recordset not empty ?> <br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../opcce.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image6" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($nrooperacion);
?>