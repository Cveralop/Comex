<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "SUP,ADM";
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
$maxRows_DetailRS1 = 100;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opmec  WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	color: #000;
}
body {
	background-image: url();
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
.Estilo12 {font-size: 14px; font-weight: bold; }
.Estilo9 {font-size: 24px; font-weight: bold; }
-->
</style>
<script type="text/javascript">
<!--
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
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
<script> 
window.print(); 
</script>
</head>
<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="0" align="center">
  <tr valign="middle">
    <td><img src="../../../imagenes/JPEG/logo_carta.jpg" alt="" width="190" height="65" align="left" />
      </div>
      </div></td>
  </tr>
  <tr valign="middle">
    <td align="right"><strong>
      <?php
setlocale(LC_TIME,'spanish'); 
echo strftime("Santiago, %d de %B de %Y");?>
    </strong></td>
  </tr>
</table>
<br />
<table width="95%"  border="0" align="center">
  <tr>
    <td align="center" valign="middle"><span class="Estilo9">MERCADO DE CORREDORES</span></td>
  </tr>
</table>
<br />
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="reimpre_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr valign="middle">
    <td colspan="4" align="left"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><strong>Comprobante de Ingreso Instrucci&oacute;n Cliente </strong></td>
  </tr>
  <tr valign="middle">
    <td align="right">No. Folio:</div></td>
    <td align="center"><strong><?php echo $row_DetailRS1['id']; ?></strong></td>
    <td align="right">Nro Folio Mesa Dinero:</td>
    <td align="center"><strong><?php echo strtoupper($row_DetailRS1['nro_foliomesadinero']); ?></strong></td>
  </tr>
  <tr valign="middle">
    <td align="right">Fecha Ingreso:</td>
    <td colspan="3" align="left"><strong><?php echo $row_DetailRS1['date_asig']; ?></strong></td>
  </tr>
  <tr valign="middle">
    <td width="20%" align="right">Rut Cliente:</div></td>
    <td colspan="3" align="left"><strong><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?></strong></td>
  </tr>
  <tr valign="middle">
    <td align="right">Nombre Cliente:</div></td>
    <td colspan="3" align="left"><strong><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></strong></td>
  </tr>
  <tr valign="middle">
    <td align="right">Evento:</div></td>
    <td colspan="3" align="left"><strong><?php echo $row_DetailRS1['evento']; ?></strong>
      </div></td>
  </tr>
  <tr valign="middle">
    <td align="right">Operador:</td>
    <td colspan="3" align="left"><span class="Estilo12"><?php echo strtoupper($row_DetailRS1['operador']); ?></span></td>
  </tr>
  <tr valign="middle">
    <td align="right">Importes:</td>
    <td colspan="3" align="left"><strong>Moneda: <?php echo strtoupper($row_DetailRS1['moneda_operacion']); ?> // Moneda MX: <?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?> // Monto ML: <?php echo number_format($row_DetailRS1['monto_ml'], 2, ',', '.'); ?> // Tipo Cambio: <?php echo number_format($row_DetailRS1['tipocambio'], 2, ',', '.'); ?>// Paridad: <?php echo number_format($row_DetailRS1['paridad'], 6, ',', '.'); ?></strong></td>
  </tr>
  <tr valign="middle">
    <td align="right">Origen y Destion:</td>
    <td colspan="3" align="left"><span class="Estilo12">Cta Cte Origen: <?php echo $row_DetailRS1['cta_cte_origen']; ?> // Cta Cte Destino: <?php echo $row_DetailRS1['cta_cte_destino']; ?> //Otro Destino: <?php echo $row_DetailRS1['otro_destino']; ?></span></td>
  </tr>
  <tr valign="middle">
    <td align="right">Mantado:</td>
    <td colspan="3" align="left"><span class="Estilo12"><?php echo $row_DetailRS1['mandato']; ?></span></td>
  </tr>
</table>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>