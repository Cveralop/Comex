<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "BMG,ADM";
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
$maxRows_ingvarios = 10;
$pageNum_ingvarios = 0;
if (isset($_GET['pageNum_ingvarios'])) {
  $pageNum_ingvarios = $_GET['pageNum_ingvarios'];
}
$startRow_ingvarios = $pageNum_ingvarios * $maxRows_ingvarios;
$colname1_ingvarios = "Apertura.";
if (isset($_GET['evento'])) {
  $colname1_ingvarios = $_GET['evento'];
}
$colname2_ingvarios = "zzzxxx";
if (isset($_GET['referencia'])) {
  $colname2_ingvarios = $_GET['referencia'];
}
$colname_ingvarios = "zzzxxx";
if (isset($_GET['nro_operacion'])) {
  $colname_ingvarios = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ingvarios = sprintf("SELECT * FROM opcce WHERE nro_operacion LIKE %s and evento = %s and referencia LIKE %s ORDER BY date_ingreso DESC", GetSQLValueString("%" . $colname_ingvarios . "%", "text"),GetSQLValueString($colname1_ingvarios, "text"),GetSQLValueString("%" . $colname2_ingvarios . "%", "text"));
$query_limit_ingvarios = sprintf("%s LIMIT %d, %d", $query_ingvarios, $startRow_ingvarios, $maxRows_ingvarios);
$ingvarios = mysqli_query($comercioexterior, $query_limit_ingvarios) or die(mysqli_error($comercioexterior));
$row_ingvarios = mysqli_fetch_assoc($ingvarios);
if (isset($_GET['totalRows_ingvarios'])) {
  $totalRows_ingvarios = $_GET['totalRows_ingvarios'];
} else {
  $all_ingvarios = mysqli_query($comercioexterior, $query_ingvarios);
  $totalRows_ingvarios = mysqli_num_rows($all_ingvarios);
}
$totalPages_ingvarios = ceil($totalRows_ingvarios/$maxRows_ingvarios)-1;

$queryString_ingvarios = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ingvarios") == false && 
        stristr($param, "totalRows_ingvarios") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ingvarios = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ingvarios = sprintf("&totalRows_ingvarios=%d%s", $totalRows_ingvarios, $queryString_ingvarios);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Pre-Ingreso Intrucciones - Maestro</title>
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
.Estilo12 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
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
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
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
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
</head>
<body onLoad="MM_preloadImages('../../../../bmg/imagenes/Botones/boton_volver_2.jpg','../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">PRE-INGRESO INSTRUCCIONES - MAESTRO </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTAS DE CR&Eacute;DITO DE EXPORTACI&Oacute;N </td>
  </tr>
</table>
<br>
<form name="form2" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo7">Pre-Ingreso Instrucciones  Carta de Cr&eacute;dito de Exportaci&oacute;n </span></td>
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
<?php if ($totalRows_ingvarios > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Ingresar Instrucci&oacute;n</div></td>
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
    <td align="center" valign="middle"><a href="ingdet2.php?recordID=<?php echo $row_ingvarios['id']; ?>"> <img src="../../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div></td>
    <td align="center" valign="middle"><?php echo $row_ingvarios['rut_cliente']; ?> </div></td>
    <td align="left" valign="middle"><?php echo $row_ingvarios['nombre_cliente']; ?> </td>
    <td align="left" valign="middle"><?php echo $row_ingvarios['fecha_ingreso']; ?></td>
    <td align="left" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_ingvarios['nro_operacion']); ?></span></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_ingvarios['moneda_operacion']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_ingvarios['monto_operacion'], 2, ',', '.'); ?></span></td>
  </tr>
  <?php } while ($row_ingvarios = mysqli_fetch_assoc($ingvarios)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_ingvarios > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingvarios=%d%s", $currentPage, 0, $queryString_ingvarios); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_ingvarios > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingvarios=%d%s", $currentPage, max(0, $pageNum_ingvarios - 1), $queryString_ingvarios); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingvarios < $totalPages_ingvarios) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingvarios=%d%s", $currentPage, min($totalPages_ingvarios, $pageNum_ingvarios + 1), $queryString_ingvarios); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingvarios < $totalPages_ingvarios) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingvarios=%d%s", $currentPage, $totalPages_ingvarios, $queryString_ingvarios); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_ingvarios + 1) ?></strong> al <strong><?php echo min($startRow_ingvarios + $maxRows_ingvarios, $totalRows_ingvarios) ?></strong> de un total de <strong><?php echo $totalRows_ingvarios ?></strong>
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
mysqli_free_result($ingvarios);
?>