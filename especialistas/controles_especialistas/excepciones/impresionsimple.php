<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ESP,BMG,TER,ADM";
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
$MM_restrictGoTo = "../../bmg/erroracceso.php";
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
$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
$colname_DetailRS1 = "-1";
if (isset($_SESSION['login'])) {
  $colname_DetailRS1 = $_SESSION['login'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT excepciones.*,(usuarios.nombre)as ne FROM excepciones, usuarios WHERE especialista_curse = %s and (excepciones.especialista_curse = usuarios.usuario) ORDER BY excepciones.id DESC", GetSQLValueString($colname_DetailRS1, "text"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysqli_query($comercioexterior, $query_limit_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1);
  $totalRows_DetailRS1 = mysqli_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
$queryString_DetailRS1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_DetailRS1") == false && 
        stristr($param, "totalRows_DetailRS1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_DetailRS1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_DetailRS1 = sprintf("&totalRows_DetailRS1=%d%s", $totalRows_DetailRS1, $queryString_DetailRS1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<script> 
window.print(); 
</script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<html>
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
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Impresi&oacute;n Instrucci&oacute;n</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #000000;
}
.Estilo9 {font-size: 24px; font-weight: bold; }
.Estilo12 {font-size: 14px; font-weight: bold; }
-->
</style>
</head>
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="0" align="center">
  <tr>
    <td align="left" valign="middle"><img src="../../../imagenes/JPEG/logo_carta.jpg" width="190" height="65"></div>      </div></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong>
      <?php
setlocale(LC_TIME,'spanish'); 
echo strftime("Santiago, %d de %B de %Y");?>
    </strong></td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="center" valign="middle"><span class="Estilo9">SOLUCION EXCEPCIONES</span></td>
  </tr>
</table>
<br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="excepciones.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0"></a>      </div></td>
  </tr>
</table>
<br>
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr>
    <td colspan="4" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><strong>Comprobante de Ingreso Solucion Excepcion</strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle">No. Folio:</td>
    <td colspan="3" align="left" valign="middle"><strong><?php echo strtoupper($row_DetailRS1['id']); ?></strong></td>
  </tr>
  <tr>
    <td width="20%" align="right" valign="middle">Rut Cliente:</div></td>
    <td colspan="3" align="left" valign="middle"><strong><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?></strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nombre Cliente:</div></td>
    <td colspan="3" align="left" valign="middle"><strong><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Fecha Ingreso:</div></td>
    <td colspan="3" align="left" valign="middle"><strong><?php echo $row_DetailRS1['date_ingreso']; ?></strong>      </div></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Evento:</div></td>
    <td colspan="3" align="left" valign="middle"><strong><?php echo $row_DetailRS1['evento']; ?></strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Especialista:</div></td>
    <td colspan="3" align="left" valign="middle"><span class="Estilo12"><?php echo strtoupper($row_DetailRS1['ne']); ?></span></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Moneda / Monto Operaci&oacute;n:</div></td>
    <td colspan="3" align="left" valign="middle"><strong><?php echo strtoupper($row_DetailRS1['moneda_operacion']); ?>&nbsp;<?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Obsevaciones:</td>
    <td colspan="3" align="left" valign="middle"><strong><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></strong></td>
  </tr>
</table>
<p align="center"><br>
  <br>
  <br>
  <br>
  <br>
  <span class="Estilo12"><?php echo strtoupper($row_DetailRS1['ne']); ?></span><br>
_____________________________________<br> 
<strong>FIRMA ESPECIALISTA</strong></p>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>