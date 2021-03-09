<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
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
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_impresion = 5000;
$pageNum_impresion = 0;
if (isset($_GET['pageNum_impresion'])) {
  $pageNum_impresion = $_GET['pageNum_impresion'];
}
$startRow_impresion = $pageNum_impresion * $maxRows_impresion;
$colname1_impresion = "1";
if (isset($_GET['fecha_ingreso'])) {
  $colname1_impresion = $_GET['fecha_ingreso'];
}
$colname2_impresion = "Carta Original.";
if (isset($_GET['evento'])) {
  $colname2_impresion = $_GET['evento'];
}
$colname_impresion = "1";
if (isset($_GET['especialista_curse'])) {
  $colname_impresion = $_GET['especialista_curse'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_impresion = sprintf("SELECT *, time(date_espe)as esp FROM opcbi WHERE especialista_curse = %s and fecha_ingreso = %s and evento = %s ORDER BY id DESC", GetSQLValueString($colname_impresion, "text"),GetSQLValueString($colname1_impresion, "text"),GetSQLValueString($colname2_impresion, "text"));
$query_limit_impresion = sprintf("%s LIMIT %d, %d", $query_impresion, $startRow_impresion, $maxRows_impresion);
$impresion = mysqli_query($comercioexterior, $query_limit_impresion) or die(mysqli_error());
$row_impresion = mysqli_fetch_assoc($impresion);
if (isset($_GET['totalRows_impresion'])) {
  $totalRows_impresion = $_GET['totalRows_impresion'];
} else {
  $all_impresion = mysqli_query($comercioexterior, $query_impresion);
  $totalRows_impresion = mysqli_num_rows($all_impresion);
}
$totalPages_impresion = ceil($totalRows_impresion/$maxRows_impresion)-1;
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);
$queryString_impresion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_impresion") == false && 
        stristr($param, "totalRows_impresion") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_impresion = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_impresion = sprintf("&totalRows_impresion=%d%s", $totalRows_impresion, $queryString_impresion);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Impresi&oacute;n Carta Original - Maestro</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo6 {color: #FFFFFF; font-weight: bold; }
.Estilo7 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo8 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo10 {font-size: 16px; font-weight: bold; color: #FFFFFF; }
.Estilo11 {color: #CCCCCC}

</style>
<script language="JavaScript" type="text/JavaScript">
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
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">IMPRESI&Oacute;N CARTA ORIGINAL - MAESTRO </td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td height="21" align="left" class="Estilo4">COBRANZA EXTRANJERA DE EXPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo7">Impresi&oacute;n Instrucci&oacute;n Cliente</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right">Especialista:</div></td>
      <td width="79%" align="left"><input name="especialista_curse" type="text" class="etiqueta12" id="especialista_curse" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20" readonly="readonly"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Fecha Ingreso:</div></td>
      <td align="left"><input name="fecha_ingreso" type="text" class="etiqueta12" id="fecha_ingreso" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10"> 
      <span class="rojopequeno">(dd-mm-aaaa)</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
        <input name="Submit" type="submit" class="boton" value="Buscar"></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="opcbe.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_impresion > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td colspan="8"><span class="Estilo10">COBRANZA EXTRANJERA DE EXPORTACI&Oacute;N</span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center"><span class="titulocolumnas">Nro Folio </span></td>
    <td class="titulocolumnas">Fecha&nbsp; Ingreso</div>
    </td>
    <td class="titulocolumnas">Rut Cliente
      </div>
    </td>
    <td class="titulocolumnas">Nombre Cliente
      </div>
    </td>
    <td class="titulocolumnas">Evento
      </div>
    </td>
    <td class="titulocolumnas">Nro Operaci&oacute;n</div>
    </td>
    <td class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>
    </td>
    <td class="titulocolumnas">Urgente
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><span class="respuestacolumna_rojo"><?php echo $row_impresion['id']; ?></span>      </div></td>
    <td align="center"><?php echo $row_impresion['date_espe']; ?> </div></td>
    <td align="center"><?php echo strtoupper($row_impresion['rut_cliente']); ?></div></td>
    <td align="left"><?php echo strtoupper($row_impresion['nombre_cliente']); ?></td>
    <td align="center"><?php echo $row_impresion['evento']; ?> </div></td>
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_impresion['nro_operacion']); ?></span>      </div></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_impresion['moneda_operacion']); ?></span><strong class="respuestacolumna_azul"> <?php echo number_format($row_impresion['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td colspan="2" align="center"><?php if ($row_impresion['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_impresion['urgente']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_impresion['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_impresion['urgente']; ?> </span></span>
      <?php } // Show if not first page ?></td>
</tr>
  <tr valign="middle">
    <td align="center" bgcolor="#999999" class="titulocolumnas">Observaciones:</td>
    <td colspan="8" align="left"><?php echo $row_impresion['obs']; ?></td>
    </tr>
  <?php } while ($row_impresion = mysqli_fetch_assoc($impresion)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_impresion > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_impresion=%d%s", $currentPage, 0, $queryString_impresion); ?>">Primero</a>
      <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_impresion > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_impresion=%d%s", $currentPage, max(0, $pageNum_impresion - 1), $queryString_impresion); ?>">Anterior</a>
      <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_impresion < $totalPages_impresion) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_impresion=%d%s", $currentPage, min($totalPages_impresion, $pageNum_impresion + 1), $queryString_impresion); ?>">Siguiente</a>
      <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_impresion < $totalPages_impresion) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_impresion=%d%s", $currentPage, $totalPages_impresion, $queryString_impresion); ?>">&Uacute;ltimo</a>
      <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_impresion + 1) ?></strong> al <strong><?php echo min($startRow_impresion + $maxRows_impresion, $totalRows_impresion) ?></strong> de un total de <strong><?php echo $totalRows_impresion ?></strong>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($impresion);
mysqli_free_result($colores);
?>