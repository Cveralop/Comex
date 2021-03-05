<?php require_once('../../../Connections/comercioexterior.php'); ?>
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
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_stbemi = 10;
$pageNum_stbemi = 0;
if (isset($_GET['pageNum_stbemi'])) {
  $pageNum_stbemi = $_GET['pageNum_stbemi'];
}
$startRow_stbemi = $pageNum_stbemi * $maxRows_stbemi;
$colname_stbemi = "xxx";
if (isset($_GET['rut_cliente'])) {
  $colname_stbemi = $_GET['rut_cliente'];
}
$colname1_stbemi = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname1_stbemi = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_stbemi = sprintf("SELECT * FROM opste WHERE rut_cliente LIKE %s and nro_operacion LIKE %s ORDER BY id DESC", GetSQLValueString($colname_stbemi . "%", "text"),GetSQLValueString($colname1_stbemi . "%", "text"));
$query_limit_stbemi = sprintf("%s LIMIT %d, %d", $query_stbemi, $startRow_stbemi, $maxRows_stbemi);
$stbemi = mysqli_query($comercioexterior, $query_limit_stbemi) or die(mysqli_error());
$row_stbemi = mysqli_fetch_assoc($stbemi);
if (isset($_GET['totalRows_stbemi'])) {
  $totalRows_stbemi = $_GET['totalRows_stbemi'];
} else {
  $all_stbemi = mysqli_query($comercioexterior, $query_stbemi);
  $totalRows_stbemi = mysqli_num_rows($all_stbemi);
}
$totalPages_stbemi = ceil($totalRows_stbemi/$maxRows_stbemi)-1;
$maxRows_stbrec = 10;
$pageNum_stbrec = 0;
if (isset($_GET['pageNum_stbrec'])) {
  $pageNum_stbrec = $_GET['pageNum_stbrec'];
}
$startRow_stbrec = $pageNum_stbrec * $maxRows_stbrec;
$colname_stbrec = "zzz";
if (isset($_GET['rut_cliente'])) {
  $colname_stbrec = $_GET['rut_cliente'];
}
$colname1_stbrec = "xxx";
if (isset($_GET['nro_operacion'])) {
  $colname1_stbrec = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_stbrec = sprintf("SELECT * FROM opstr WHERE rut_cliente LIKE %s and nro_operacion LIKE %s ORDER BY id DESC", GetSQLValueString($colname_stbrec . "%", "text"),GetSQLValueString($colname1_stbrec . "%", "text"));
$query_limit_stbrec = sprintf("%s LIMIT %d, %d", $query_stbrec, $startRow_stbrec, $maxRows_stbrec);
$stbrec = mysqli_query($comercioexterior, $query_limit_stbrec) or die(mysqli_error());
$row_stbrec = mysqli_fetch_assoc($stbrec);
if (isset($_GET['totalRows_stbrec'])) {
  $totalRows_stbrec = $_GET['totalRows_stbrec'];
} else {
  $all_stbrec = mysqli_query($comercioexterior, $query_stbrec);
  $totalRows_stbrec = mysqli_num_rows($all_stbrec);
}
$totalPages_stbrec = ceil($totalRows_stbrec/$maxRows_stbrec)-1;
$maxRows_boleta = 10;
$pageNum_boleta = 0;
if (isset($_GET['pageNum_boleta'])) {
  $pageNum_boleta = $_GET['pageNum_boleta'];
}
$startRow_boleta = $pageNum_boleta * $maxRows_boleta;
$colname_boleta = "xxx";
if (isset($_GET['rut_cliente'])) {
  $colname_boleta = $_GET['rut_cliente'];
}
$colname1_boleta = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname1_boleta = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_boleta = sprintf("SELECT * FROM opbga WHERE rut_cliente LIKE %s and nro_operacion LIKE %s ORDER BY id DESC", GetSQLValueString($colname_boleta . "%", "text"),GetSQLValueString($colname1_boleta . "%", "text"));
$query_limit_boleta = sprintf("%s LIMIT %d, %d", $query_boleta, $startRow_boleta, $maxRows_boleta);
$boleta = mysqli_query($comercioexterior, $query_limit_boleta) or die(mysqli_error());
$row_boleta = mysqli_fetch_assoc($boleta);
if (isset($_GET['totalRows_boleta'])) {
  $totalRows_boleta = $_GET['totalRows_boleta'];
} else {
  $all_boleta = mysqli_query($comercioexterior, $query_boleta);
  $totalRows_boleta = mysqli_num_rows($all_boleta);
}
$totalPages_boleta = ceil($totalRows_boleta/$maxRows_boleta)-1;
$maxRows_cext = 10;
$pageNum_cext = 0;
if (isset($_GET['pageNum_cext'])) {
  $pageNum_cext = $_GET['pageNum_cext'];
}
$startRow_cext = $pageNum_cext * $maxRows_cext;
$colname_cext = "xxx";
if (isset($_GET['rut_cliente'])) {
  $colname_cext = $_GET['rut_cliente'];
}
$colname1_cext = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname1_cext = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cext = sprintf("SELECT * FROM opcex WHERE rut_cliente LIKE %s and nro_operacion LIKE %s ORDER BY id DESC", GetSQLValueString($colname_cext . "%", "text"),GetSQLValueString($colname1_cext . "%", "text"));
$query_limit_cext = sprintf("%s LIMIT %d, %d", $query_cext, $startRow_cext, $maxRows_cext);
$cext = mysqli_query($comercioexterior, $query_limit_cext) or die(mysqli_error());
$row_cext = mysqli_fetch_assoc($cext);
if (isset($_GET['totalRows_cext'])) {
  $totalRows_cext = $_GET['totalRows_cext'];
} else {
  $all_cext = mysqli_query($comercioexterior, $query_cext);
  $totalRows_cext = mysqli_num_rows($all_cext);
}
$totalPages_cext = ceil($totalRows_cext/$maxRows_cext)-1;
$maxRows_tbc = 10;
$pageNum_tbc = 0;
if (isset($_GET['pageNum_tbc'])) {
  $pageNum_tbc = $_GET['pageNum_tbc'];
}
$startRow_tbc = $pageNum_tbc * $maxRows_tbc;
$colname_tbc = "xxx";
if (isset($_GET['rut_cliente'])) {
  $colname_tbc = $_GET['rut_cliente'];
}
$colname1_tbc = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname1_tbc = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_tbc = sprintf("SELECT * FROM optbc WHERE rut_cliente LIKE %s and nro_operacion LIKE %s ORDER BY id DESC", GetSQLValueString($colname_tbc . "%", "text"),GetSQLValueString($colname1_tbc . "%", "text"));
$query_limit_tbc = sprintf("%s LIMIT %d, %d", $query_tbc, $startRow_tbc, $maxRows_tbc);
$tbc = mysqli_query($comercioexterior, $query_limit_tbc) or die(mysqli_error());
$row_tbc = mysqli_fetch_assoc($tbc);
if (isset($_GET['totalRows_tbc'])) {
  $totalRows_tbc = $_GET['totalRows_tbc'];
} else {
  $all_tbc = mysqli_query($comercioexterior, $query_tbc);
  $totalRows_tbc = mysqli_num_rows($all_tbc);
}
$totalPages_tbc = ceil($totalRows_tbc/$maxRows_tbc)-1;
$queryString_stbemi = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_stbemi") == false && 
        stristr($param, "totalRows_stbemi") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_stbemi = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_stbemi = sprintf("&totalRows_stbemi=%d%s", $totalRows_stbemi, $queryString_stbemi);
$queryString_stbrec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_stbrec") == false && 
        stristr($param, "totalRows_stbrec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_stbrec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_stbrec = sprintf("&totalRows_stbrec=%d%s", $totalRows_stbrec, $queryString_stbrec);
$queryString_boleta = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_boleta") == false && 
        stristr($param, "totalRows_boleta") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_boleta = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_boleta = sprintf("&totalRows_boleta=%d%s", $totalRows_boleta, $queryString_boleta);
$queryString_cext = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cext") == false && 
        stristr($param, "totalRows_cext") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cext = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cext = sprintf("&totalRows_cext=%d%s", $totalRows_cext, $queryString_cext);
$queryString_tbc = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_tbc") == false && 
        stristr($param, "totalRows_tbc") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_tbc = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_tbc = sprintf("&totalRows_tbc=%d%s", $totalRows_tbc, $queryString_tbc);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reparo Operaciones de Cambio</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<script type="text/javascript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
</head>
<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3"> REPAROS OPERACIONES DE CAMBIO</td>
    <td width="7%" rowspan="2" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr align="left">
    <td valign="middle" class="Estilo4">OPERACIONES DE CAMBIO</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bgcolor="#cccccc" bordercolor="#666666">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0" /><span class="titulodetalle">Operaciones Reparadas</span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle" bgcolor="#CCCCCC">Rut Cliente:</td>
      <td width="79%" align="left" valign="middle" bgcolor="#CCCCCC"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15" />
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle" bgcolor="#CCCCCC">Nro Operación:</td>
      <td align="left" valign="middle" bgcolor="#CCCCCC"><label>
        <input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="17" maxlength="15" />
      </label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle" bgcolor="#CCCCCC"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar" />
      </label>
        <label>
          <input name="button2" type="submit" class="boton" id="button2" value="Limpiar" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../cambio.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen8','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen8" width="80" height="25" border="0" id="Imagen8" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_stbemi > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bgcolor="#cccccc" bordercolor="#666666">
    <tr class="titulocolumnas">
      <td colspan="7" align="left" valign="middle" bgcolor="#999999" class="titulocolumnas"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0" /><span class="titulodetalle">Stand BY Emitidas</span></td>
    </tr>
    <tr class="titulocolumnas">
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Reparar</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><a href="stbemi.php?recordID=<?php echo $row_stbemi['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" /></a></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC" class="respuestacolumna_rojo"><?php echo $row_stbemi['nro_operacion']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_stbemi['fecha_ingreso']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_stbemi['rut_cliente']; ?></td>
        <td align="left" valign="middle" bgcolor="#CCCCCC"><?php echo $row_stbemi['nombre_cliente']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_stbemi['evento']; ?></td>
        <td align="right" valign="middle" bgcolor="#CCCCCC"><span class="respuestacolumna_rojo"><?php echo $row_stbemi['moneda_operacion']; ?></span>&nbsp; <span class="respuestacolumna_azul"><?php echo number_format($row_stbemi['monto_operacion'], 2, ',', '.'); ?></span></td>
      </tr>
      <?php } while ($row_stbemi = mysqli_fetch_assoc($stbemi)); ?>
  </table>
  <br />
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_stbemi > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_stbemi=%d%s", $currentPage, 0, $queryString_stbemi); ?>">Primero</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_stbemi > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_stbemi=%d%s", $currentPage, max(0, $pageNum_stbemi - 1), $queryString_stbemi); ?>">Anterior</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_stbemi < $totalPages_stbemi) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_stbemi=%d%s", $currentPage, min($totalPages_stbemi, $pageNum_stbemi + 1), $queryString_stbemi); ?>">Siguiente</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_stbemi < $totalPages_stbemi) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_stbemi=%d%s", $currentPage, $totalPages_stbemi, $queryString_stbemi); ?>">Último</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br />
  Registros del <span class="respuestacolumna_azul"><?php echo ($startRow_stbemi + 1) ?></span> al <span class="respuestacolumna_azul"><?php echo min($startRow_stbemi + $maxRows_stbemi, $totalRows_stbemi) ?></span> de un total de <span class="respuestacolumna_azul"><?php echo $totalRows_stbemi ?></span>
  <?php } // Show if recordset not empty ?>
<br />
<br />
<?php if ($totalRows_stbrec > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bgcolor="#cccccc" bordercolor="#666666">
    <tr>
      <td colspan="7" align="left" valign="middle" bgcolor="#999999" class="titulocolumnas"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0" /><span class="titulodetalle">Stand BY Recibidas</span></td>
    </tr>
    <tr>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Reparar</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><a href="stbrec.php?recordID=<?php echo $row_stbrec['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" /></a></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC" class="respuestacolumna_rojo"><?php echo $row_stbrec['nro_operacion']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_stbrec['fecha_ingreso']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_stbrec['rut_cliente']; ?></td>
        <td align="left" valign="middle" bgcolor="#CCCCCC"><?php echo $row_stbrec['nombre_cliente']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_stbrec['evento']; ?></td>
        <td align="right" valign="middle" bgcolor="#CCCCCC"><span class="respuestacolumna_rojo"><?php echo $row_stbrec['moneda_operacion']; ?></span>&nbsp; <span class="respuestacolumna_azul"><?php echo number_format($row_stbrec['monto_operacion'], 2, ',', '.'); ?></span></td>
      </tr>
      <?php } while ($row_stbrec = mysqli_fetch_assoc($stbrec)); ?>
  </table>
  <br />
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_stbrec > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_stbrec=%d%s", $currentPage, 0, $queryString_stbrec); ?>">Primero</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_stbrec > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_stbrec=%d%s", $currentPage, max(0, $pageNum_stbrec - 1), $queryString_stbrec); ?>">Anterior</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_stbrec < $totalPages_stbrec) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_stbrec=%d%s", $currentPage, min($totalPages_stbrec, $pageNum_stbrec + 1), $queryString_stbrec); ?>">Siguiente</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_stbrec < $totalPages_stbrec) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_stbrec=%d%s", $currentPage, $totalPages_stbrec, $queryString_stbrec); ?>">Último</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br />
  Registros del <span class="respuestacolumna_azul"><?php echo ($startRow_stbrec + 1) ?></span> al <span class="respuestacolumna_azul"><?php echo min($startRow_stbrec + $maxRows_stbrec, $totalRows_stbrec) ?></span> de un total de <span class="respuestacolumna_azul"><?php echo $totalRows_stbrec ?></span>
  <?php } // Show if recordset not empty ?>
<br />
<br />
<?php if ($totalRows_boleta > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bgcolor="#cccccc" bordercolor="#666666">
    <tr bgcolor="#999999">
      <td colspan="7" align="left" valign="middle" class="titulocolumnas"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0" /><span class="titulodetalle">Boleta de Garantía</span></td>
    </tr>
    <tr bgcolor="#999999">
      <td align="center" valign="middle" class="titulocolumnas">Reparar</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr bgcolor="#CCCCCC">
        <td align="center" valign="middle"><a href="boleta.php?recordID=<?php echo $row_boleta['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" /></a></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_boleta['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_boleta['fecha_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_boleta['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_boleta['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_boleta['evento']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_boleta['moneda_operacion']; ?></span><span class="respuestacolumna_azul"> <?php echo number_format($row_boleta['monto_operacion'], 2, ',', '.'); ?></span></td>
      </tr>
      <?php } while ($row_boleta = mysqli_fetch_assoc($boleta)); ?>
  </table>
  <br />
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_boleta > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_boleta=%d%s", $currentPage, 0, $queryString_boleta); ?>">Primero</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_boleta > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_boleta=%d%s", $currentPage, max(0, $pageNum_boleta - 1), $queryString_boleta); ?>">Anterior</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_boleta < $totalPages_boleta) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_boleta=%d%s", $currentPage, min($totalPages_boleta, $pageNum_boleta + 1), $queryString_boleta); ?>">Siguiente</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_boleta < $totalPages_boleta) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_boleta=%d%s", $currentPage, $totalPages_boleta, $queryString_boleta); ?>">Último</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br />
  Registros del <span class="respuestacolumna_azul"><?php echo ($startRow_boleta + 1) ?></span> al <span class="respuestacolumna_azul"><?php echo min($startRow_boleta + $maxRows_boleta, $totalRows_boleta) ?></span> de un total de <span class="respuestacolumna_azul"><?php echo $totalRows_boleta ?></span>
  <?php } // Show if recordset not empty ?>
<br />
<br />
<?php if ($totalRows_cext > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bgcolor="#cccccc" bordercolor="#666666">
    <tr bgcolor="#999999">
      <td colspan="7" align="left" valign="middle" class="titulocolumnas"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0" /><span class="titulodetalle">Credito Externo y Otros Productos</span></td>
    </tr>
    <tr bgcolor="#999999">
      <td align="center" valign="middle" class="titulocolumnas">Reparar</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Monbre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr bgcolor="#CCCCCC">
        <td align="center" valign="middle"><a href="cext.php?recordID=<?php echo $row_cext['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" /></a></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_cext['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_cext['fecha_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_cext['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_cext['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_cext['evento']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_cext['moneda_operacion']; ?></span><span class="respuestacolumna_azul"> <?php echo number_format($row_cext['monto_operacion'], 2, ',', '.'); ?></span></td>
      </tr>
      <?php } while ($row_cext = mysqli_fetch_assoc($cext)); ?>
  </table>
  <br />
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_cext > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_cext=%d%s", $currentPage, 0, $queryString_cext); ?>">Primero</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_cext > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_cext=%d%s", $currentPage, max(0, $pageNum_cext - 1), $queryString_cext); ?>">Anterior</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_cext < $totalPages_cext) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_cext=%d%s", $currentPage, min($totalPages_cext, $pageNum_cext + 1), $queryString_cext); ?>">Siguiente</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_cext < $totalPages_cext) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_cext=%d%s", $currentPage, $totalPages_cext, $queryString_cext); ?>">Último</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br />
  Registros del <span class="respuestacolumna_azul"><?php echo ($startRow_cext + 1) ?></span> al <span class="respuestacolumna_azul"><?php echo min($startRow_cext + $maxRows_cext, $totalRows_cext) ?></span> de un total de <span class="respuestacolumna_azul"><?php echo $totalRows_cext ?></span>
  <?php } // Show if recordset not empty ?>
<br />
<br />
<?php if ($totalRows_tbc > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#cccccc">
    <tr bgcolor="#999999">
      <td colspan="7" align="left" valign="middle" class="titulocolumnas"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0" /><span class="titulodetalle">IIIB5</span></td>
    </tr>
    <tr bgcolor="#999999">
      <td align="center" valign="middle" class="titulocolumnas">Reparar</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
    </tr>
    <?php do { ?>
      <tr bgcolor="#CCCCCC">
        <td align="center" valign="middle"><a href="tbc.php?recordID=<?php echo $row_tbc['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" /></a></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_tbc['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_tbc['fecha_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_tbc['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_tbc['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_tbc['evento']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_tbc['moneda_operacion']; ?></span>&nbsp; <span class="respuestacolumna_azul"><?php echo number_format($row_tbc['monto_operacion'], 2, ',', '.'); ?></span></td>
      </tr>
      <?php } while ($row_tbc = mysqli_fetch_assoc($tbc)); ?>
  </table>
  <br />
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_tbc > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_tbc=%d%s", $currentPage, 0, $queryString_tbc); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_tbc > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_tbc=%d%s", $currentPage, max(0, $pageNum_tbc - 1), $queryString_tbc); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_tbc < $totalPages_tbc) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_tbc=%d%s", $currentPage, min($totalPages_tbc, $pageNum_tbc + 1), $queryString_tbc); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_tbc < $totalPages_tbc) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_tbc=%d%s", $currentPage, $totalPages_tbc, $queryString_tbc); ?>">Último</a>
        <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br />
  Registros del <span class="respuestacolumna_azul"><?php echo ($startRow_tbc + 1) ?></span> al <span class="respuestacolumna_azul"><?php echo min($startRow_tbc + $maxRows_tbc, $totalRows_tbc) ?></span> de un total de <span class="respuestacolumna_azul"><?php echo $totalRows_tbc ?></span>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($stbemi);
mysqli_free_result($stbrec);
mysqli_free_result($boleta);
mysqli_free_result($cext);
mysqli_free_result($tbc);
?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  