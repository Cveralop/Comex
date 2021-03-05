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
$maxRows_asignar = 10;
$pageNum_asignar = 0;
if (isset($_GET['pageNum_asignar'])) {
  $pageNum_asignar = $_GET['pageNum_asignar'];
}
$startRow_asignar = $pageNum_asignar * $maxRows_asignar;
$colname1_asignar = "Apertura.";
if (isset($_GET['evento'])) {
  $colname1_asignar = $_GET['evento'];
}
$colname_asignar = "1";
if (isset($_GET['nro_operacion'])) {
  $colname_asignar = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_asignar = sprintf("SELECT * FROM opcce WHERE nro_operacion = %s and evento = %s", GetSQLValueString($colname_asignar, "text"),GetSQLValueString($colname1_asignar, "text"));
$query_limit_asignar = sprintf("%s LIMIT %d, %d", $query_asignar, $startRow_asignar, $maxRows_asignar);
$asignar = mysqli_query($comercioexterior, $query_limit_asignar) or die(mysqli_error());
$row_asignar = mysqli_fetch_assoc($asignar);
if (isset($_GET['totalRows_asignar'])) {
  $totalRows_asignar = $_GET['totalRows_asignar'];
} else {
  $all_asignar = mysqli_query($comercioexterior, $query_asignar);
  $totalRows_asignar = mysqli_num_rows($all_asignar);
}
$totalPages_asignar = ceil($totalRows_asignar/$maxRows_asignar)-1;
$queryString_asignar = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_asignar") == false && 
        stristr($param, "totalRows_asignar") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_asignar = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_asignar = sprintf("&totalRows_asignar=%d%s", $totalRows_asignar, $queryString_asignar);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso Documentos Exportaciones -  Maestro</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
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
	color: #0000FF;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
	font-weight: bold;
}
a:link {
	text-decoration: none;
	color: #FF0000;
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
.Estilo11 {font-size: 12px}
.Estilo12 {color: #00FF00}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
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
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
</head>
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO DOCUMENTOS EXPORTACIONES - MAESTRO </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTA DE CR&Eacute;DITO DE EXPORTACI&Oacute;N </td>
  </tr>
</table>
<br>
<form action="" method="get" name="form1">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo8">Ingreso Negociaci&oacute;n Exportaciones </span></td>
    </tr>
    <tr>
      <td width="23%" align="right" valign="middle">Nro Operaci&oacute;n:</td>
      <td width="77%" align="left" valign="middle">        <input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7"> 
      <span class="rojopequeno">E000000</span> </td>
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
<?php if ($totalRows_asignar > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="5" align="left" valign="middle"><span class="Estilo6"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo11">Numero Operaci&oacute;n <span class="Estilo12"><?php echo strtoupper($row_asignar['nro_operacion']); ?></span></span></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle">
      <class="titulocolumnas">Asignar</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso
      </div>      
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Referencia
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><a href="asidet.php?recordID=<?php echo $row_asignar['id']; ?>"> <img src="../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"> </a> </div></td>
    <td align="center" valign="middle"><?php echo $row_asignar['fecha_ingreso']; ?> </div>       </div></td>
    <td align="center" valign="middle"><?php echo $row_asignar['referencia']; ?> </div></td>
    <td align="center" valign="middle"><?php echo $row_asignar['rut_cliente']; ?> </div></td>
    <td align="left" valign="middle"><?php echo $row_asignar['nombre_cliente']; ?> </div></td>
  </tr>
  <?php } while ($row_asignar = mysqli_fetch_assoc($asignar)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_asignar > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_asignar=%d%s", $currentPage, 0, $queryString_asignar); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_asignar > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_asignar=%d%s", $currentPage, max(0, $pageNum_asignar - 1), $queryString_asignar); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_asignar < $totalPages_asignar) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_asignar=%d%s", $currentPage, min($totalPages_asignar, $pageNum_asignar + 1), $queryString_asignar); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_asignar < $totalPages_asignar) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_asignar=%d%s", $currentPage, $totalPages_asignar, $queryString_asignar); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_asignar + 1) ?></strong> al <strong><?php echo min($startRow_asignar + $maxRows_asignar, $totalRows_asignar) ?></strong> de un total de <strong><?php echo $totalRows_asignar ?></strong>
<?php } // Show if recordset not empty ?> <br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td><a href="../carcreexp.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image1" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($asignar);
?>