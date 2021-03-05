<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "TER";
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

$MM_restrictGoTo = "../../territorial/erroracceso.php";
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

$maxRows_consulta = 10;
$pageNum_consulta = 0;
if (isset($_GET['pageNum_consulta'])) {
  $pageNum_consulta = $_GET['pageNum_consulta'];
}
$startRow_consulta = $pageNum_consulta * $maxRows_consulta;

$colname_consulta = "-1";
if (isset($_GET['rut_aval'])) {
  $colname_consulta = $_GET['rut_aval'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_consulta = sprintf("SELECT * FROM certificado_matrimonio WHERE rut_aval = %s", GetSQLValueString($colname_consulta, "int"));
$query_limit_consulta = sprintf("%s LIMIT %d, %d", $query_consulta, $startRow_consulta, $maxRows_consulta);
$consulta = mysqli_query($comercioexterior, $query_limit_consulta) or die(mysqli_error());
$row_consulta = mysqli_fetch_assoc($consulta);

if (isset($_GET['totalRows_consulta'])) {
  $totalRows_consulta = $_GET['totalRows_consulta'];
} else {
  $all_consulta = mysqli_query($comercioexterior, $query_consulta);
  $totalRows_consulta = mysqli_num_rows($all_consulta);
}
$totalPages_consulta = ceil($totalRows_consulta/$maxRows_consulta)-1;

$queryString_consulta = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consulta") == false && 
        stristr($param, "totalRows_consulta") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consulta = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consulta = sprintf("&totalRows_consulta=%d%s", $totalRows_consulta, $queryString_consulta);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consulta Certificado Matrimonio - Maestro</title>
<style type="text/css">
<!--
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
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
</head>

<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CERTIFICADO MATRIMONIO COMERCIO EXTERIOR</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">COMERCIO EXTERIOR</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulo_menu">Consulta Rut Aval</span></td>
    </tr>
    <tr>
      <td width="19%" align="right" valign="middle">Rut Aval:</td>
      <td width="81%" align="left" valign="middle"><input name="rut_aval" type="text" class="etiqueta12" id="rut_aval" size="17" maxlength="15" />
      <span class="rojopequeno">(sin puntos ni guion) </span></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><input name="button" type="submit" class="boton" id="button" value="Buscar Aval" /></td>
    </tr>
  </table>
</form>
<br />
<?php if ($totalRows_consulta > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="5" align="left" valign="middle" class="titulocolumnas"><span class="titulo_menu"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /> Nombre Aval:</span> <span class="tituloverde"><?php echo $row_consulta['nombre_aval']; ?></span> <span class="titulo_menu">Rut Aval:</span> <span class="tituloverde"><?php echo $row_consulta['rut_aval']; ?></span></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Estado Civil</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Suscripcion</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Vcto</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado Documento</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle"> <?php echo $row_consulta['estado_civil']; ?></td>
        <td align="center" valign="middle"><?php echo $row_consulta['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_consulta['date_suscrip']; ?></td>
        <td align="center" valign="middle"><?php echo $row_consulta['date_vcto']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_consulta['estado']; ?></td>
      </tr>
      <?php } while ($row_consulta = mysqli_fetch_assoc($consulta)); ?>
  </table>
  <br />
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_consulta > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_consulta=%d%s", $currentPage, 0, $queryString_consulta); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_consulta > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_consulta=%d%s", $currentPage, max(0, $pageNum_consulta - 1), $queryString_consulta); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_consulta < $totalPages_consulta) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_consulta=%d%s", $currentPage, min($totalPages_consulta, $pageNum_consulta + 1), $queryString_consulta); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_consulta < $totalPages_consulta) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_consulta=%d%s", $currentPage, $totalPages_consulta, $queryString_consulta); ?>">Último</a>
        <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br />
  Registros del <span class="respuestacolumna_azul"><?php echo ($startRow_consulta + 1) ?></span> al <span class="respuestacolumna_azul"><?php echo min($startRow_consulta + $maxRows_consulta, $totalRows_consulta) ?></span> de un total de <span class="respuestacolumna_azul"><?php echo $totalRows_consulta ?></span>
  <?php } // Show if recordset not empty ?>
<br />
</body>
</html>
<?php
mysqli_free_result($consulta);
?>