<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
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
$maxRows_ingape = 10;
$pageNum_ingape = 0;
if (isset($_GET['pageNum_ingape'])) {
  $pageNum_ingape = $_GET['pageNum_ingape'];
}
$startRow_ingape = $pageNum_ingape * $maxRows_ingape;

$colname_ingape = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_ingape = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ingape = sprintf("SELECT * FROM cliente nolock WHERE rut_cliente = %s", GetSQLValueString($colname_ingape, "text"));
$query_limit_ingape = sprintf("%s LIMIT %d, %d", $query_ingape, $startRow_ingape, $maxRows_ingape);
$ingape = mysqli_query($comercioexterior, $query_limit_ingape) or die(mysqli_error($comercioexterior));
$row_ingape = mysqli_fetch_assoc($ingape);
$totalRows_ingape = mysqli_num_rows($ingape);

if (isset($_GET['totalRows_modificacion'])) {
  $totalRows_ingape = $_GET['totalRows_modificacion'];
} else {
  $all_ingape = mysqli_query($comercioexterior, $query_ingape);
  $totalRows_ingape = mysqli_num_rows($all_ingape);
}
$totalPages_ingape = ceil($totalRows_ingape/$maxRows_ingape)-1;

$queryString_ingape = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ingape") == false && 
        stristr($param, "totalRows_ingape") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ingape = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ingape = sprintf("&totalRows_ingape=%d%s", $totalRows_ingape, $queryString_ingape);

//Segundo Dato
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_ingsbte = 10;
$pageNum_ingsbte = 0;
if (isset($_GET['pageNum_ingsbte'])) {
  $pageNum_ingsbte = $_GET['pageNum_ingsbte'];
}
$startRow_ingsbte = $pageNum_ingsbte * $maxRows_ingsbte;

$colname_ingsbte = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname_ingsbte = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ingsbte = sprintf("SELECT * FROM opste nolock WHERE nro_operacion = %s ORDER BY id DESC", GetSQLValueString($colname_ingsbte, "text"));
$query_limit_ingsbte = sprintf("%s LIMIT %d, %d", $query_ingsbte, $startRow_ingsbte, $maxRows_ingsbte);
$ingsbte = mysqli_query($comercioexterior, $query_limit_ingsbte) or die(mysqli_error($comercioexterior));
$row_ingsbte = mysqli_fetch_assoc($ingsbte);
$totalRows_ingsbte = mysqli_num_rows($ingsbte);

if (isset($_GET['totalRows_modificacion'])) {
  $totalRows_ingsbte = $_GET['totalRows_modificacion'];
} else {
  $all_ingsbte = mysqli_query($comercioexterior, $query_ingsbte);
  $totalRows_ingsbte = mysqli_num_rows($all_ingsbte);
}
$totalPages_ingsbte = ceil($totalRows_ingsbte/$maxRows_ingsbte)-1;

$queryString_ingsbte = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ingsbte") == false && 
        stristr($param, "totalRows_ingsbte") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ingsbte = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ingsbte = sprintf("&totalRows_ingsbte=%d%s", $totalRows_ingsbte, $queryString_ingsbte);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso Simple Intrucciones - Maestro</title>
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
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO SIMPLE INSTRUCCIONES - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CAMBIO - STAND BY EMITIDAS</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo7">Ingreso Simple Instrucci&oacute;n Stand By Emitida</span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Rut Cliente:</td>
      <td width="79%" align="left" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="12">
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
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
<form name="form2" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo7">Ingreso Simple Instrucci&oacute;n Stand By Emitida</span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Nro Operaci&oacute;n:</div></td>
      <td width="79%" align="left" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="20" maxlength="20"></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="etiqueta12" value="Buscar">
        <input name="Submit" type="submit" class="etiqueta12" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_ingape > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Ingresar Stand By</div></td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Impedido de Operar / Passport</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><a href="ingdet.php?recordID=<?php echo $row_ingape['id']; ?>"> <img src="../../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_ingape['rut_cliente']); ?> </div></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_ingape['nombre_cliente']); ?> </td>
    <td align="center" valign="middle"><?php echo strtoupper($row_ingape['impedido_operar']); ?> / <span class="respuestacolumna_rojo"><?php echo strtoupper($row_ingape['cliente_passport']); ?></span></td>
  </tr>
  <?php } while ($row_ingape = mysqli_fetch_assoc($ingape)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_ingape > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_ingape=%d%s", $currentPage, 0, $queryString_ingape); ?>">Primero</a>
            <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_ingape > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_ingape=%d%s", $currentPage, max(0, $pageNum_ingape - 1), $queryString_ingape); ?>">Anterior</a>
            <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingape < $totalPages_ingape) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_ingape=%d%s", $currentPage, min($totalPages_ingsbte, $pageNum_ingape + 1), $queryString_ingape); ?>">Siguiente</a>
            <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingape < $totalPages_ingape) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_ingape=%d%s", $currentPage, $totalPages_ingape, $queryString_ingape); ?>">&Uacute;ltimo</a>
            <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_ingape + 1) ?></strong> al <strong><?php echo min($startRow_ingape + $maxRows_ingape, $totalRows_ingape) ?></strong> de un total de <strong><?php echo $totalRows_ingape ?></strong>
<?php } // Show if recordset not empty ?>
<br>
<br>
<?php if ($totalRows_ingsbte > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td align="center" valign="middle"><span class="titulocolumnas">Ingresar Stand By</span>      </div></td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Tipo Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>
    </td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><a href="ingdet_2.php?recordID=<?php echo $row_ingsbte['id']; ?>"> <img src="../../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_ingsbte['nro_operacion']; ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_ingsbte['rut_cliente']); ?> </div></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_ingsbte['nombre_cliente']); ?> </td>
    <td align="center" valign="middle"><?php echo $row_ingsbte['fecha_ingreso']; ?> </div></td>
    <td align="center" valign="middle"><?php echo $row_ingsbte['tipo_operacion']; ?> </div></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_ingsbte['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_ingsbte['monto_operacion'], 2, ',', '.'); ?></strong> </div></td>
  </tr>
  <?php } while ($row_ingsbte = mysqli_fetch_assoc($ingsbte)); ?>
</table>
<br>

<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_ingsbte > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_ingsbte=%d%s", $currentPage, 0, $queryString_ingsbte); ?>">Primero</a>
            <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_ingsbte > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_ingsbte=%d%s", $currentPage, max(0, $pageNum_ingsbte - 1), $queryString_ingsbte); ?>">Anterior</a>
            <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingsbte < $totalPages_ingsbte) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_ingsbte=%d%s", $currentPage, min($totalPages_ingsbte, $pageNum_ingsbte + 1), $queryString_ingsbte); ?>">Siguiente</a>
            <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingsbte < $totalPages_ingsbte) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_ingsbte=%d%s", $currentPage, $totalPages_ingsbte, $queryString_ingsbte); ?>">&Uacute;ltimo</a>
            <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_ingsbte + 1) ?></strong> al <strong><?php echo min($startRow_ingsbte + $maxRows_ingsbte, $totalRows_ingsbte) ?></strong> de un total de <strong><?php echo $totalRows_ingsbte ?></strong>
<?php } // Show if recordset not empty ?> <br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../opste.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image6" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($ingape);
mysqli_free_result($ingsbte);
?>