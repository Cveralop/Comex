<?php require_once('../../../Connections/historico_goc.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM";
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

$MM_restrictGoTo = "../../../consulta_operaciones/gestiondeinformes/erroracceso.php";
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
  global $historico_goc;

  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($historico_goc, $theValue) : mysqli_escape_string($historico_goc, $theValue);

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

$maxRows_logstareas = 1000;
$pageNum_logstareas = 0;
if (isset($_GET['pageNum_logstareas'])) {
  $pageNum_logstareas = $_GET['pageNum_logstareas'];
}
$startRow_logstareas = $pageNum_logstareas * $maxRows_logstareas;

mysqli_select_db($historico_goc, $database_historico_goc);
$query_logstareas = "SELECT *,timestampdiff(minute,fecha_hora_inicio,fecha_hora_termino)as tiempo FROM logs_tareas_automaticas WHERE 1 ORDER BY fecha_hora_inicio DESC";
$query_limit_logstareas = sprintf("%s LIMIT %d, %d", $query_logstareas, $startRow_logstareas, $maxRows_logstareas);
$logstareas = mysqli_query($historico_goc, $query_limit_logstareas) or die(mysqli_error($historico_goc));
$row_logstareas = mysqli_fetch_assoc($logstareas);

if (isset($_GET['totalRows_logstareas'])) {
  $totalRows_logstareas = $_GET['totalRows_logstareas'];
} else {
  $all_logstareas = mysqli_query($historico_goc, $query_logstareas);
  $totalRows_logstareas = mysqli_num_rows($all_logstareas);
}
$totalPages_logstareas = ceil($totalRows_logstareas/$maxRows_logstareas)-1;

$queryString_logstareas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_logstareas") == false && 
        stristr($param, "totalRows_logstareas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_logstareas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_logstareas = sprintf("&totalRows_logstareas=%d%s", $totalRows_logstareas, $queryString_logstareas);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Tareas Automaticas</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
.Estilo2 {font-size: 9px; color: #0000FF; }
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

</style>
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='../cierre.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<script type="text/javascript">
/*<!--
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
//-->*/
</script>
<script> 
//Script original de KarlanKas para forosdelweb.com 


var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 


milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
</head>
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" bgcolor="#FF0000" class="Estilo1">LOG REGISTRO TAREAS AUTOMATICAS</td>
    <td width="7%" rowspan="2" align="left" valign="middle" bgcolor="#FF0000"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#FF0000" class="subtitulopaguina">COMERCIO EXTERIOR</td>
  </tr>
</table>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../historico.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('999','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0"></a></td>
  </tr>
</table>
<br>
<table width="50%" border="0" align="center">
  <tr>
    <td><?php if ($pageNum_logstareas > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_logstareas=%d%s", $currentPage, 0, $queryString_logstareas); ?>">Primero</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_logstareas > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_logstareas=%d%s", $currentPage, max(0, $pageNum_logstareas - 1), $queryString_logstareas); ?>">Anterior</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_logstareas < $totalPages_logstareas) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_logstareas=%d%s", $currentPage, min($totalPages_logstareas, $pageNum_logstareas + 1), $queryString_logstareas); ?>">Siguiente</a>
      <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_logstareas < $totalPages_logstareas) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_logstareas=%d%s", $currentPage, $totalPages_logstareas, $queryString_logstareas); ?>">&Uacute;ltimo</a>
      <?php } // Show if not last page ?></td>
  </tr>
</table>
<br>
Registros del <span class="respuestacolumna_azul"><?php echo ($startRow_logstareas + 1) ?></span> al <span class="respuestacolumna_azul"><?php echo min($startRow_logstareas + $maxRows_logstareas, $totalRows_logstareas) ?></span> de un total de <span class="respuestacolumna_azul"><?php echo $totalRows_logstareas ?></span><br>
<br>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Tarea</td>
    <td align="center" valign="middle" class="titulocolumnas">Descripcion Tarea</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha y Hora Inicio</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha y Hora Termino</td>
    <td align="center" valign="middle" class="titulocolumnas">Tiempo de Proceso</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo $row_logstareas['tarea']; ?></td>
      <td align="left" valign="middle"><?php echo $row_logstareas['descripcion_tarea']; ?></td>
      <td align="center" valign="middle"><?php echo $row_logstareas['fecha_hora_inicio']; ?></td>
      <td align="center" valign="middle"><?php echo $row_logstareas['fecha_hora_termino']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_logstareas['tiempo']; ?></td>
    </tr>
    <?php } while ($row_logstareas = mysqli_fetch_assoc($logstareas)); ?>
</table>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../historico.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0"></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($logstareas);
?>
