<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,BMG";
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
$maxRows_nro_factura = 20;
$pageNum_nro_factura = 0;
if (isset($_GET['pageNum_nro_factura'])) {
  $pageNum_nro_factura = $_GET['pageNum_nro_factura'];
}
$startRow_nro_factura = $pageNum_nro_factura * $maxRows_nro_factura;

$colname_nro_factura = "-1";
if (isset($_GET['date_ini'])) {
  $colname_nro_factura = $_GET['date_ini'];
}
$colname5_nro_factura = "Si";
if (isset($_GET['informe_operaciones'])) {
  $colname5_nro_factura = $_GET['informe_operaciones'];
}
$colname1_nro_factura = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_nro_factura = $_GET['date_fin'];
}
$colname2_nro_factura = "Cursada.";
if (isset($_GET['estado'])) {
  $colname2_nro_factura = $_GET['estado'];
}
$colname4_nro_factura = "Alzamiento.";
if (isset($_GET['evento'])) {
  $colname4_nro_factura = $_GET['evento'];
}
$colname3_nro_factura = "Negociacion.";
if (isset($_GET['evento'])) {
  $colname3_nro_factura = $_GET['evento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_nro_factura = sprintf("SELECT * FROM opcci WHERE date_curse between %s and %s and estado = %s and evento = (%s and %s) and informe_operaciones = %s ORDER BY date_curse DESC", GetSQLValueString($colname_nro_factura, "date"),GetSQLValueString($colname1_nro_factura, "date"),GetSQLValueString($colname2_nro_factura, "text"),GetSQLValueString($colname3_nro_factura, "text"),GetSQLValueString($colname4_nro_factura, "text"),GetSQLValueString($colname5_nro_factura, "text"));
$query_limit_nro_factura = sprintf("%s LIMIT %d, %d", $query_nro_factura, $startRow_nro_factura, $maxRows_nro_factura);
$nro_factura = mysqli_query($comercioexterior, $query_limit_nro_factura) or die(mysqli_error($comercioexterior));
$row_nro_factura = mysqli_fetch_assoc($nro_factura);
$totalRows_nro_factura = mysqli_num_rows($nro_factura);

if (isset($_GET['totalRows_nro_factura'])) {
  $totalRows_nro_factura = $_GET['totalRows_nro_factura'];
} else {
  $all_nro_factura = mysqli_query($comercioexterior, $query_nro_factura);
  $totalRows_nro_factura = mysqli_num_rows($all_nro_factura);
}
$totalPages_nro_factura = ceil($totalRows_nro_factura/$maxRows_nro_factura)-1;
$queryString_nro_factura = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_nro_factura") == false && 
        stristr($param, "totalRows_nro_factura") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_nro_factura = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_nro_factura = sprintf("&totalRows_nro_factura=%d%s", $totalRows_nro_factura, $queryString_nro_factura);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consulta Operaciones Nro de Factura - Maestro</title>
<style type="text/css">
<!--
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
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
-->
</style>
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
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
</head>
<body onload="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">CONSULTA OPERACIONES NRO DE FACTURA - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">CARTAS DE CR&Eacute;DITO DE IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" bgcolor="#999999" class="titulo_menu"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" />Consulta Operaciones Por rango de Fecha</td>
    </tr>
    <tr>
      <td align="right">Fecha Curse:</td>
      <td align="left"><span class="rojopequeno">Desde</span>
        <input name="date_ini" type="text" class="etiqueta12" id="date_ini" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" />
        <span class="rojopequeno">Hasta</span>
        <input name="date_fin" type="text" class="etiqueta12" id="date_fin" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" />
        <span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input name="button" type="submit" class="boton" id="button" value="Buscar" />
      <input name="button2" type="reset" class="boton" id="button2" value="Limpiar" /></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../../bmg/opcci/opcci.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen5','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen5" width="80" height="25" border="0" id="Imagen5" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_nro_factura > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="11" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><span class="titulo_menu"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /></span>Son <span class="tituloverde"><?php echo $totalRows_nro_factura ?></span> Operaciones </td>
    </tr>
    <tr>
      <td class="titulocolumnas">Ingresar Nro Factura</td>
      <td class="titulocolumnas">Rut Cliente</td>
      <td class="titulocolumnas">Nombre Cliente</td>
      <td class="titulocolumnas">Evento</td>
      <td class="titulocolumnas">Estado</td>
      <td class="titulocolumnas">Fecha Curse</td>
      <td class="titulocolumnas">Nro Operación</td>
      <td class="titulocolumnas">Nro Operación Relacionada</td>
      <td class="titulocolumnas">Ref Cliente</td>
      <td class="titulocolumnas">Moneda / Monto Documentos</td>
      <td class="titulocolumnas">Nro Factura</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><a href="consulfactura_det.php?recordID=<?php echo $row_nro_factura['id']; ?>"><img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" align="middle" /></a></td>
        <td align="center" valign="middle"><?php echo $row_nro_factura['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_nro_factura['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_nro_factura['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_nro_factura['estado']; ?></td>
        <td align="center" valign="middle"><?php echo $row_nro_factura['date_curse']; ?></td>
        <td align="center" valign="middle"><?php echo $row_nro_factura['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_nro_factura['nro_operacion_relacionada']; ?></td>
        <td align="left" valign="middle"><?php echo $row_nro_factura['ref_cliente']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_nro_factura['moneda_documentos']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_nro_factura['monto_documentos'], 2, ',', '.'); ?></span></td>
        <td align="left" valign="middle"><?php echo $row_nro_factura['nro_factura']; ?></td>
      </tr>
      <?php } while ($row_nro_factura = mysqli_fetch_assoc($nro_factura)); ?>
  </table>
  <br>
  <table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_nro_factura > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_nro_factura=%d%s", $currentPage, 0, $queryString_nro_factura); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_nro_factura > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_nro_factura=%d%s", $currentPage, max(0, $pageNum_nro_factura - 1), $queryString_nro_factura); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_nro_factura < $totalPages_nro_factura) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_nro_factura=%d%s", $currentPage, min($totalPages_nro_factura, $pageNum_nro_factura + 1), $queryString_nro_factura); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_nro_factura < $totalPages_nro_factura) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_nro_factura=%d%s", $currentPage, $totalPages_nro_factura, $queryString_nro_factura); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Registros del <strong><?php echo ($startRow_nro_factura + 1) ?></strong> al <strong><?php echo min($startRow_nro_factura + $maxRows_nro_factura, $totalRows_nro_factura) ?></strong> de un total de <strong><?php echo $totalRows_nro_factura ?></strong>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($nro_factura);
?>