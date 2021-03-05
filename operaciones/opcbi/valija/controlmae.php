<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,SUP,OPE,GER";
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
$maxRows_valija = 50;
$pageNum_valija = 0;
if (isset($_GET['pageNum_valija'])) {
  $pageNum_valija = $_GET['pageNum_valija'];
}
$startRow_valija = $pageNum_valija * $maxRows_valija;
$colname_valija = "Pendiente.";
if (isset($_GET['acuse_recibo'])) {
  $colname_valija = $_GET['acuse_recibo'];
}
$colname1_valija = "0";
if (isset($_GET['nro_sobre'])) {
  $colname1_valija = $_GET['nro_sobre'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_valija = sprintf("SELECT * FROM opcbi WHERE acuse_recibo = %s and nro_sobre > %s ORDER BY id ASC", GetSQLValueString($colname_valija, "text"),GetSQLValueString($colname1_valija, "text"));
$query_limit_valija = sprintf("%s LIMIT %d, %d", $query_valija, $startRow_valija, $maxRows_valija);
$valija = mysql_query($query_limit_valija, $comercioexterior) or die(mysqli_error());
$row_valija = mysqli_fetch_assoc($valija);
if (isset($_GET['totalRows_valija'])) {
  $totalRows_valija = $_GET['totalRows_valija'];
} else {
  $all_valija = mysql_query($query_valija);
  $totalRows_valija = mysqli_num_rows($all_valija);
}
$totalPages_valija = ceil($totalRows_valija/$maxRows_valija)-1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Control Valija</title>
<style type="text/css">
<!--
.Estilo8 {font-size: 18px;
	color: #FFFFFF;
	font-weight: bold;
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
.Estilo11 {color: #FFFFFF; font-weight: bold; }
.Estilo14 {font-size: 12px}
.Estilo15 {color: #00FF00}
.Estilo16 {
	color: #FF0000;
	font-weight: bold;
}
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
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle"><span class="Estilo8">CONTROL VALIJA CARTA DE COBRANZA DE IMPORTACI&Oacute;N</span></td>
    <td width="7%" align="left" valign="middle"><span class="Estilo8"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></span></td>
  </tr>
</table>
<br>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="10" align="left" valign="middle"><span class="Estilo11"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo14">Total de <span class="Estilo15"><?php echo $totalRows_valija ?></span></span> </span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </div></td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto
      </div>Operaci&oacute;n      
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Valija
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Sobre 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Despacho Doctos
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Sucursal
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Encargado Sucursal 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Acuse Recibo 
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_valija['nro_operacion']; ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_valija['rut_cliente']; ?></div></td>
    <td align="left" valign="middle"><?php echo $row_valija['nombre_cliente']; ?> </td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_valija['moneda_documentos']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_valija['monto_documentos'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle"><?php echo $row_valija['fecha_valija']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_valija['nro_sobre']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_valija['despacho_doctos']; ?></td>
    <td align="center" valign="middle"><?php echo $row_valija['sucursal']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_valija['encargado_sucursal']; ?></td>
    <td align="center" valign="middle"><?php echo $row_valija['acuse_recibo']; ?></div></td>
  </tr>
  <?php } while ($row_valija = mysqli_fetch_assoc($valija)); ?>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($valija);
?>