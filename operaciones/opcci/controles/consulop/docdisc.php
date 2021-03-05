<?php require_once('../../../../Connections/comercioexterior.php'); ?>
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
$maxRows_registrodoctos = 5000;
$pageNum_registrodoctos = 0;
if (isset($_GET['pageNum_registrodoctos'])) {
  $pageNum_registrodoctos = $_GET['pageNum_registrodoctos'];
}
$startRow_registrodoctos = $pageNum_registrodoctos * $maxRows_registrodoctos;
$colname1_registrodoctos = "1";
if (isset($_GET['evento'])) {
  $colname1_registrodoctos = $_GET['evento'];
}
$colname_registrodoctos = "Discrepancia.";
if (isset($_GET['tipo_negociacion'])) {
  $colname_registrodoctos = $_GET['tipo_negociacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_registrodoctos = sprintf("SELECT * FROM opcci WHERE tipo_negociacion = %s and evento = %s ORDER BY id DESC", GetSQLValueString($colname_registrodoctos, "text"),GetSQLValueString($colname1_registrodoctos, "text"));
$query_limit_registrodoctos = sprintf("%s LIMIT %d, %d", $query_registrodoctos, $startRow_registrodoctos, $maxRows_registrodoctos);
$registrodoctos = mysql_query($query_limit_registrodoctos, $comercioexterior) or die(mysqli_error());
$row_registrodoctos = mysqli_fetch_assoc($registrodoctos);
if (isset($_GET['totalRows_registrodoctos'])) {
  $totalRows_registrodoctos = $_GET['totalRows_registrodoctos'];
} else {
  $all_registrodoctos = mysql_query($query_registrodoctos);
  $totalRows_registrodoctos = mysqli_num_rows($all_registrodoctos);
}
$totalPages_registrodoctos = ceil($totalRows_registrodoctos/$maxRows_registrodoctos)-1;
$queryString_registrodoctos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_registrodoctos") == false && 
        stristr($param, "totalRows_registrodoctos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_registrodoctos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_registrodoctos = sprintf("&totalRows_registrodoctos=%d%s", $totalRows_registrodoctos, $queryString_registrodoctos);
$queryString_registrodoctos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_registrodoctos") == false && 
        stristr($param, "totalRows_registrodoctos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_registrodoctos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_registrodoctos = sprintf("&totalRows_registrodoctos=%d%s", $totalRows_registrodoctos, $queryString_registrodoctos);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Control Doctos Con Discrepancias</title>
<style type="text/css">
<!--
@import url(../../../../estilos/estilo12.css);
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
.Estilo5 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo8 {font-size: 9px; }
.Estilo10 {font-size: 9px; color: #FFFFFF; font-weight: bold; }
.Estilo11 {color: #FF0000}
.Estilo14 {color: #00FF00}
.Estilo17 {font-size: 9px; font-weight: bold; }
-->
</style>
<script language="JavaScript" type="text/JavaScript">
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
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
</script>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
</head>
<meta http-equiv="refresh" content="10" />
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CONTROL DOCTOS CON DISCREPANCIAS </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTAS DE CR&Eacute;DITO IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Buscar Doctos al Cobro</span></td>
    </tr>
    <tr valign="middle">
      <td width="19%" align="right">Tipo Operaciones:</div></td>
      <td width="81%" align="left"><select name="evento" class="etiqueta12" id="evento">
        <option value="Negociacion." selected>Negociacion</option>
        <option value="MSG-Swift.">MSG-Swift</option>
      </select> <input name="Submit" type="submit" class="etiqueta12" value="Buscar"></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../carcreimp.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_registrodoctos > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="7" align="left"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo5">Total Operaciones <span class="Estilo14"><?php echo $totalRows_registrodoctos ?></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Numero Operaci&oacute;n</div></td>
    <td align="center" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Evento</td>
    <td align="center" class="titulocolumnas">Segmento
      </div>
    </td>
    <td align="center" class="titulocolumnas">Moneda / Monto Documentos
      </div>
    </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_registrodoctos['nro_operacion']); ?></span>      </div></td>
    <td align="center"><?php echo $row_registrodoctos['fecha_ingreso']; ?> </div></td>
    <td align="center"><?php echo $row_registrodoctos['rut_cliente']; ?> </div></td>
    <td align="left"><span class="Estilo8"><?php echo strtoupper($row_registrodoctos['nombre_cliente']); ?> </span></td>
    <td align="center"><?php echo $row_registrodoctos['evento']; ?></td>
    <td align="center"><?php echo strtoupper($row_registrodoctos['segmento']); ?></div></td>
    <td align="right"><strong><span class="respuestacolumna_rojo"><?php echo strtoupper($row_registrodoctos['moneda_documentos']); ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_registrodoctos['monto_documentos'], 2, ',', '.'); ?></span></strong>      </div></td>
  </tr>
  <?php } while ($row_registrodoctos = mysqli_fetch_assoc($registrodoctos)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($registrodoctos);
?>