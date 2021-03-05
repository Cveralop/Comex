<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
session_start();
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
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_opcci = 100;
$pageNum_opcci = 0;
if (isset($_GET['pageNum_opcci'])) {
  $pageNum_opcci = $_GET['pageNum_opcci'];
}
$startRow_opcci = $pageNum_opcci * $maxRows_opcci;

$colname1_opcci = "zzz";
if (isset($_GET['rut_cliente'])) {
  $colname1_opcci = (get_magic_quotes_gpc()) ? $_GET['rut_cliente'] : addslashes($_GET['rut_cliente']);
}
$colname_opcci = "xxx";
if (isset($_GET['nro_operacion'])) {
  $colname_opcci = (get_magic_quotes_gpc()) ? $_GET['nro_operacion'] : addslashes($_GET['nro_operacion']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcci = sprintf("SELECT * FROM opcci WHERE nro_operacion = '%s' and rut_cliente LIKE '%%%s%%' ORDER BY id DESC", $colname_opcci,$colname1_opcci);
$query_limit_opcci = sprintf("%s LIMIT %d, %d", $query_opcci, $startRow_opcci, $maxRows_opcci);
$opcci = mysqli_query($comercioexterior, $query_limit_opcci) or die(mysqli_error());
$row_opcci = mysqli_fetch_assoc($opcci);

if (isset($_GET['totalRows_opcci'])) {
  $totalRows_opcci = $_GET['totalRows_opcci'];
} else {
  $all_opcci = mysqli_query($comercioexterior, $query_opcci);
  $totalRows_opcci = mysqli_num_rows($all_opcci);
}
$totalPages_opcci = ceil($totalRows_opcci/$maxRows_opcci)-1;

$queryString_opcci = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_opcci") == false && 
        stristr($param, "totalRows_opcci") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_opcci = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_opcci = sprintf("&totalRows_opcci=%d%s", $totalRows_opcci, $queryString_opcci);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>OPCCI - Maestro</title>
<style type="text/css">
<!--
@import url("../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
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
	color: #FF0000;
	font-weight: bold;
}
.Estilo8 {
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo10 {color: #FFFFFF; font-weight: bold; }
.Estilo12 {color: #00FF00; font-weight: bold; font-size: 12px; }
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<script>
<!--
//Script original de KarlanKas para forosdelweb.com 


var segundos=1800
var direccion='http://pdpto38:8303/comex/' 


milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
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
</head>
<link rel="shortcut icon" href="../../../comex/imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../comex/imagenes/barraweb/animated_favicon1.gif">
</head>

<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" class="Estilo3">OPCCI - MAESTRO
    </td>
    <td width="7%" rowspan="2" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43"></td>
  </tr>
  <tr valign="middle">
    <td class="Estilo4">COMERCIO EXTERIOR CARTAS DE CR&Eacute;DITO IMPORTACIONES </td>
  </tr>
</table>
<br>
<form action="" method="get" name="form1">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo8">Administraci&oacute;n de Operaciones Carta de Cr&eacute;dito Importaciones</span></td>
    </tr>
    <tr valign="middle">
      <td><div align="right">Rut Cliente:</div></td>
      <td><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15">
        <span class="rojopequeno">xxx.xxx.xxx-x</span></td>
    </tr>
    <tr valign="middle">
      <td width="22%"><div align="right">Nro Operaci&oacute;n:</div></td>
      <td width="78%">      <input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7"> 
      <span class="rojopequeno">K000000</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="2"><div align="center">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<table width="95%"  border="0" align="center">
  <tr>
    <td><div align="right"><a href="../principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_opcci > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td><div align="center" class="Estilo10">Actualizar</div></td>
    <td><div align="center" class="Estilo10">Rut Cliente </div></td>
    <td><div align="center" class="Estilo10">Nombre Cliente </div></td>
    <td><div align="center" class="Estilo10">Evento</div></td>
    <td><div align="center" class="Estilo10">Fecha Ingreso </div>      <div align="center" class="Estilo10"></div></td>
    <td><div align="center" class="Estilo10">Moneda / Monto Operaci&oacute;n </div></td>
    <td><div align="center" class="Estilo10">Moneda / Monto Documentos</div></td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td><div align="center"><a href="opccidet.php?recordID=<?php echo $row_opcci['id']; ?>"> <img src="../../imagenes/ICONOS/ver_registro_2.jpg" width="22" height="19" border="0"></a></div></td>
    <td><div align="center"><?php echo $row_opcci['rut_cliente']; ?> </div></td>
    <td><?php echo $row_opcci['nombre_cliente']; ?> </td>
    <td><div align="center"><?php echo $row_opcci['evento']; ?></div></td>
    <td><div align="center"><?php echo $row_opcci['fecha_ingreso']; ?> </div>      <div align="center" class="Estilo5"> </div></td>
    <td><div align="right"><span class="Estilo5"><?php echo $row_opcci['moneda_operacion']; ?></span> <strong><?php echo number_format($row_opcci['monto_operacion'], 2, ',', '.'); ?></strong> </div></td>
    <td><div align="right"><span class="Estilo5"><?php echo $row_opcci['moneda_documentos']; ?></span>&nbsp; <strong><?php echo number_format($row_opcci['monto_documentos'], 2, ',', '.'); ?></strong> </div></td>
  </tr>
  <?php } while ($row_opcci = mysqli_fetch_assoc($opcci)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_opcci > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_opcci=%d%s", $currentPage, 0, $queryString_opcci); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_opcci > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_opcci=%d%s", $currentPage, max(0, $pageNum_opcci - 1), $queryString_opcci); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_opcci < $totalPages_opcci) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_opcci=%d%s", $currentPage, min($totalPages_opcci, $pageNum_opcci + 1), $queryString_opcci); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_opcci < $totalPages_opcci) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_opcci=%d%s", $currentPage, $totalPages_opcci, $queryString_opcci); ?>">Último</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_opcci + 1) ?></strong> al <strong><?php echo min($startRow_opcci + $maxRows_opcci, $totalRows_opcci) ?></strong> de un total de <strong><?php echo $totalRows_opcci ?></strong>
<?php } // Show if recordset not empty ?> <br>
</body>
</html>
<?php
mysqli_free_result($opcci);
?>
