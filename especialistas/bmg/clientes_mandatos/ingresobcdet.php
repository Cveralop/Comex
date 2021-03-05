<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php require_once('../../../Connections/basecomercial.php'); ?>
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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO cliente (rut_cliente, nombre_cliente, nombre_ejecutivo, especialista, ejecutivo, subgerente, oficina, territorial, sucursal, ing_por, date1) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_ejecutivo'], "text"),
                       GetSQLValueString($_POST['especialista'], "text"),
                       GetSQLValueString($_POST['ejecutivo'], "text"),
                       GetSQLValueString($_POST['subgerente'], "text"),
                       GetSQLValueString($_POST['oficina'], "text"),
                       GetSQLValueString($_POST['territorial'], "text"),
                       GetSQLValueString($_POST['sucursal'], "text"),
                       GetSQLValueString($_POST['ing_por'], "text"),
                       GetSQLValueString($_POST['date1'], "date"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
  $insertGoTo = "ingresobcmae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($basecomercial, $database_basecomercial);
$query_DetailRS1 = sprintf("SELECT * FROM base_comercial  WHERE rut_cliente = %s", GetSQLValueString($colname_DetailRS1, "text"));
$DetailRS1 = mysqli_query($basecomercial, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

//var_dump($row_DetailRS1); die();
?>
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
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
	font-weight: bold;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #F00;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
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
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<title>Ingreso Cliente Segun Base Comercial - Detalle</title><body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')"><table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">INGRESO CLIENTES GOC SEGUN BASE COMERCIAL NI</td>
    <td rowspan="2" align="right" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">NEGOCIO INTERNACIONAL</td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulo_menu">Detalle Ingreso cliente</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="20" readonly="readonly" />
        <span class="respuestacolumna_rojo">(Sin Puntos ni Gui&oacute;n)</span></td>
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="center" valign="middle"><input name="date1" type="text" class="etiqueta12" value="<?php echo date("Y-m-d H:i:s"); ?>" size="30" maxlength="30" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="80" maxlength="80" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Ejecutivo:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_ejecutivo" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_ejecutivo']; ?>" size="80" maxlength="80" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Especialista:</td>
      <td colspan="3" align="left" valign="middle"><input name="especialista" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista_ni']; ?>" size="80" maxlength="80" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Ejecutivo:</td>
      <td colspan="3" align="left" valign="middle"><input name="ejecutivo" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['ejecutivo_ni']; ?>" size="80" maxlength="80" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Subgerente:</td>
      <td colspan="3" align="left" valign="middle"><input name="subgerente" type="text" class="etiqueta12" value="<?php //echo $row_DetailRS1['subgerente']; ?>" size="80" maxlength="80" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Oficina:</td>
      <td colspan="3" align="left" valign="middle"><input name="oficina" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['sucursal']; ?>" size="50" maxlength="50" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Distribucion Goc:</td>
      <td colspan="3" align="left" valign="middle"><input name="territorial" type="text" class="etiqueta12" id="territorial" value="<?php echo $row_DetailRS1['distribucion_goc']; ?>" size="50" maxlength="50" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Ingresado Por:</td>
      <td colspan="3" align="left" valign="middle"><input name="ing_por" type="text" class="etiqueta12" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle"><input type="submit" class="boton" value="Ingresar Cliente" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input name="sucursal" type="hidden" id="sucursal" value="<?php echo $row_DetailRS1['cod_suc']; ?>">
</form>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="ingresobcmae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<?php
mysqli_free_result($DetailRS1);
?>