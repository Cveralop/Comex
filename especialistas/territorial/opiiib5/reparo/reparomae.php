<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,TER";
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
$maxRows_reparo = 30;
$pageNum_reparo = 0;
if (isset($_GET['pageNum_reparo'])) {
  $pageNum_reparo = $_GET['pageNum_reparo'];
}
$startRow_reparo = $pageNum_reparo * $maxRows_reparo;
$colname_reparo = "Reparada.";
if (isset($_GET['estado'])) {
  $colname_reparo = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_reparo = sprintf("SELECT * FROM optbc WHERE estado = %s or (estado = 'Rechazada.') ORDER BY id DESC", GetSQLValueString($colname_reparo, "text"));
$query_limit_reparo = sprintf("%s LIMIT %d, %d", $query_reparo, $startRow_reparo, $maxRows_reparo);
$reparo = mysqli_query($comercioexterior, $query_limit_reparo) or die(mysqli_error());
$row_reparo = mysqli_fetch_assoc($reparo);
if (isset($_GET['totalRows_reparo'])) {
  $totalRows_reparo = $_GET['totalRows_reparo'];
} else {
  $all_reparo = mysqli_query($comercioexterior, $query_reparo);
  $totalRows_reparo = mysqli_num_rows($all_reparo);
}
$totalPages_reparo = ceil($totalRows_reparo/$maxRows_reparo)-1;
$queryString_reparo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_reparo") == false && 
        stristr($param, "totalRows_reparo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_reparo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_reparo = sprintf("&totalRows_reparo=%d%s", $totalRows_reparo, $queryString_reparo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reparo - Maestro</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
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

</style>
<script>
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
//-->
</script>
<script>
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>
<body onload="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">REPARO - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CAMBIO - IIIB5</td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../opiiib5.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center">
    <td valign="middle" class="titulocolumnas">Imprimir Reparo</td>
    <td valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td valign="middle" class="titulocolumnas">Nombre Cliente</td>
    <td valign="middle" class="titulocolumnas">Fecha Ingreso</td>
    <td valign="middle" class="titulocolumnas">Nro Operacion</td>
    <td valign="middle" class="titulocolumnas">Moneda / Monto Operación</td>
    <td valign="middle" class="titulocolumnas">Evento</td>
    <td valign="middle" class="titulocolumnas">Estado</td>
    <td valign="middle" class="titulocolumnas">Especialista</td>
    <td valign="middle" class="titulocolumnas">Territorial</td>
    <td valign="middle" class="titulocolumnas">Reparo Obs</td>
  </tr>
  <?php do { ?>
    <tr>
      <td valign="middle"><a href="reparodet.php?recordID=<?php echo $row_reparo['id']; ?>"><img src="../../../../imagenes/ICONOS/impresora_2.jpg" width="27" height="21" border="0" /></a></td>
      <td align="center" valign="middle"><?php echo $row_reparo['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_reparo['nombre_cliente']; ?></td>
      <td align="center" valign="middle"><?php echo $row_reparo['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_reparo['nro_operacion']; ?></td>
      <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_reparo['moneda_operacion']; ?></span>&nbsp; <span class="respuestacolumna_azul"><?php echo number_format($row_reparo['monto_operacion'], 2, ',', '.'); ?></span></td>
      <td align="center" valign="middle"><?php echo $row_reparo['evento']; ?></td>
      <td align="center" valign="middle"><?php echo $row_reparo['estado']; ?></td>
      <td align="left" valign="middle"><?php echo $row_reparo['especialista_curse']; ?></td>
      <td align="left" valign="middle"><?php echo $row_reparo['territorial']; ?></td>
      <td align="left" valign="middle"><?php echo $row_reparo['reparo_obs']; ?></td>
    </tr>
    <?php } while ($row_reparo = mysqli_fetch_assoc($reparo)); ?>
</table>
<br />
<table width="50%" border="0" align="center">
  <tr>
    <td><?php if ($pageNum_reparo > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_reparo=%d%s", $currentPage, 0, $queryString_reparo); ?>">Primero</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_reparo > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_reparo=%d%s", $currentPage, max(0, $pageNum_reparo - 1), $queryString_reparo); ?>">Anterior</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_reparo < $totalPages_reparo) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_reparo=%d%s", $currentPage, min($totalPages_reparo, $pageNum_reparo + 1), $queryString_reparo); ?>">Siguiente</a>
      <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_reparo < $totalPages_reparo) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_reparo=%d%s", $currentPage, $totalPages_reparo, $queryString_reparo); ?>">Último</a>
      <?php } // Show if not last page ?></td>
  </tr>
</table>
<br />
Registros del <span class="respuestacolumna_azul"><?php echo ($startRow_reparo + 1) ?></span> al <span class="respuestacolumna_azul"><?php echo min($startRow_reparo + $maxRows_reparo, $totalRows_reparo) ?></span> de un total de <span class="respuestacolumna_azul"><?php echo $totalRows_reparo ?></span>
</body>
</html>
<?php
mysqli_free_result($reparo);
?>