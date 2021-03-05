<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
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

$colname_trasa_ingrec = "-1";
if (isset($_GET['date_ini'])) {
  $colname_trasa_ingrec = $_GET['date_ini'];
}
$colname1_trasa_ingrec = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_trasa_ingrec = $_GET['date_fin'];
}
$colname2_trasa_ingrec = "Acuse Recibo Caratula";
if (isset($_GET['estado'])) {
  $colname2_trasa_ingrec = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_trasa_ingrec = sprintf("SELECT *,date(date_ing)as fecha FROM trasabilidad nolock WHERE date(date_ing) between %s and %s and estado = %s GROUP BY date(date_ing)", GetSQLValueString($colname_trasa_ingrec, "date"),GetSQLValueString($colname1_trasa_ingrec, "date"),GetSQLValueString($colname2_trasa_ingrec, "text"));
$trasa_ingrec = mysqli_query($comercioexterior, $query_trasa_ingrec) or die(mysqli_error($comercioexterior));
$row_trasa_ingrec = mysqli_fetch_assoc($trasa_ingrec);
$totalRows_trasa_ingrec = mysqli_num_rows($trasa_ingrec);

$colname_trasa_espevisa = "-1";
if (isset($_GET['date_ini'])) {
  $colname_trasa_espevisa = $_GET['date_ini'];
}
$colname1_trasa_espevisa = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_trasa_espevisa = $_GET['date_fin'];
}
$colname2_trasa_espevisa = "Ingreso Espe. v/s Visacion";
if (isset($_GET['estado'])) {
  $colname2_trasa_espevisa = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_trasa_espevisa = sprintf("SELECT * FROM trasabilidad nolock WHERE date(date_espe) between %s and %s and estado = %s GROUP BY date(date_espe), producto, evento", GetSQLValueString($colname_trasa_espevisa, "date"),GetSQLValueString($colname1_trasa_espevisa, "date"),GetSQLValueString($colname2_trasa_espevisa, "text"));
$trasa_espevisa = mysqli_query($comercioexterior, $query_trasa_espevisa) or die(mysqli_error($comercioexterior));
$row_trasa_espevisa = mysqli_fetch_assoc($trasa_espevisa);
$totalRows_trasa_espevisa = mysqli_num_rows($trasa_espevisa);

$colname_trasa_visaasig = "-1";
if (isset($_GET['date_ini'])) {
  $colname_trasa_visaasig = $_GET['date_ini'];
}
$colname1_trasa_visaasig = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_trasa_visaasig = $_GET['date_fin'];
}
$colname2_trasa_visaasig = "Visacion v/s Asignacion";
if (isset($_GET['estado'])) {
  $colname2_trasa_visaasig = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_trasa_visaasig = sprintf("SELECT * FROM trasabilidad nolock WHERE date(date_espe) between %s and %s and estado = %s GROUP BY date(date_espe), producto, evento", GetSQLValueString($colname_trasa_visaasig, "date"),GetSQLValueString($colname1_trasa_visaasig, "date"),GetSQLValueString($colname2_trasa_visaasig, "text"));
$trasa_visaasig = mysqli_query($comercioexterior, $query_trasa_visaasig) or die(mysqli_error($comercioexterior));
$row_trasa_visaasig = mysqli_fetch_assoc($trasa_visaasig);
$totalRows_trasa_visaasig = mysqli_num_rows($trasa_visaasig);

$colname_trasa_asigoper = "-1";
if (isset($_GET['date_ini'])) {
  $colname_trasa_asigoper = $_GET['date_ini'];
}
$colname1_trasa_asigoper = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_trasa_asigoper = $_GET['date_fin'];
}
$colname2_trasa_asigoper = "Asignacion v/s Alta Operador";
if (isset($_GET['estado'])) {
  $colname2_trasa_asigoper = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_trasa_asigoper = sprintf("SELECT * FROM trasabilidad nolock WHERE date(date_espe) between %s and %s and estado = %s GROUP BY date(date_espe), producto, evento", GetSQLValueString($colname_trasa_asigoper, "date"),GetSQLValueString($colname1_trasa_asigoper, "date"),GetSQLValueString($colname2_trasa_asigoper, "text"));
$trasa_asigoper = mysqli_query($comercioexterior, $query_trasa_asigoper) or die(mysqli_error($comercioexterior));
$row_trasa_asigoper = mysqli_fetch_assoc($trasa_asigoper);
$totalRows_trasa_asigoper = mysqli_num_rows($trasa_asigoper);

$colname_trasa_opersupe = "-1";
if (isset($_GET['date_ini'])) {
  $colname_trasa_opersupe = $_GET['date_ini'];
}
$colname1_trasa_opersupe = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_trasa_opersupe = $_GET['date_fin'];
}
$colname2_trasa_opersupe = "Alta Operador v/s Alta Supervisor";
if (isset($_GET['estado'])) {
  $colname2_trasa_opersupe = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_trasa_opersupe = sprintf("SELECT * FROM trasabilidad nolock WHERE date(date_espe) between %s and %s and estado = %s GROUP BY date(date_espe), producto, evento", GetSQLValueString($colname_trasa_opersupe, "date"),GetSQLValueString($colname1_trasa_opersupe, "date"),GetSQLValueString($colname2_trasa_opersupe, "text"));
$trasa_opersupe = mysqli_query($comercioexterior, $query_trasa_opersupe) or die(mysqli_error($comercioexterior));
$row_trasa_opersupe = mysqli_fetch_assoc($trasa_opersupe);
$totalRows_trasa_opersupe = mysqli_num_rows($trasa_opersupe);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trazabilidad Operaciones Detalle- Detalle</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
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
-->
</style>
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
//-->
</script>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>

<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="96%" align="left" valign="middle" class="Estilo3">TRAZABILIDAD OPERACIONES RESUMEN - DETALLE</td>
    <td width="4%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="left" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4"><span class="subtitulopaguina">COMERCIO EXTERIOR</span></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="5" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><span class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" /></span>Caratula GOC</td>
  </tr>
  <tr>
    <td width="30%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
    <td width="25%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso Caratula</td>
    <td width="15%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo  Minimo (en Hora)</td>
    <td width="15%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo  Maximo (en Hora)</td>
    <td width="15%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Promedio (en Hora)</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo (isset($row_trasa_ingrec['producto']) ? $row_trasa_ingrec['producto']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_ingrec['fecha']) ? $row_trasa_ingrec['fecha']:""); ?> </td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_ingrec['minimo']) ? $row_trasa_ingrec['minimo']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_ingrec['maximo']) ? $row_trasa_ingrec['maximo']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_ingrec['promedio']) ? $row_trasa_ingrec['promedio']:""); ?></td>
    </tr>
    <?php } while ($row_trasa_ingrec = mysqli_fetch_assoc($trasa_ingrec)); ?>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="6" align="left" valign="middle" bgcolor="#999999"><span class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" />Especialista v/s Visacion</span></td>
  </tr>
  <tr>
    <td width="30%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso Especialista</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo  Minimo (en Hora)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo  Maximo (en Hora)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Promedio (en Hora)</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo (isset($row_trasa_espevisa['producto']) ? $row_trasa_espevisa['producto']:""); ?></td>
      <td align="left" valign="middle"><?php echo (isset($row_trasa_espevisa['evento']) ? $row_trasa_espevisa['evento']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_espevisa['date_espe']) ? $row_trasa_espevisa['date_es']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_espevisa['minimo']) ? $row_trasa_espevisa['minimo']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_espevisa['maximo']) ? $row_trasa_espevisa['maximo']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_espevisa['promedio']) ? $row_trasa_espevisa['promedio']:""); ?></td>
    </tr>
    <?php } while ($row_trasa_espevisa = mysqli_fetch_assoc($trasa_espevisa)); ?>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="6" align="left" valign="middle" bgcolor="#999999"><span class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" />Visacion v/s Asignación</span></td>
  </tr>
  <tr>
    <td width="30%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso Especialista</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo  Minimo (en Hora)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo  Maximo (en Hora)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Promedio (en Hora)</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo (isset($row_trasa_visaasig['producto']) ? $row_trasa_visaasig['producto']: ""); ?></td>
      <td align="left" valign="middle"><?php echo (isset($row_trasa_visaasig['evento']) ? $row_trasa_visaasig['evento']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_visaasig['date_espe']) ? $row_trasa_visaasig['date_es']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_visaasig['minimo']) ? $row_trasa_visaasig['minimo']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_visaasig['maximo']) ? $row_trasa_visaasig['maximo']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_visaasig['promedio']) ? $row_trasa_visaasig['promedio']:""); ?></td>
    </tr>
    <?php } while ($row_trasa_visaasig = mysqli_fetch_assoc($trasa_visaasig)); ?>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="6" align="left" valign="middle" bgcolor="#999999"><span class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" />Asignación v/s Alta Operador</span></td>
  </tr>
  <tr>
    <td width="30%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso Especialista</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo  Minimo (en Hora)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo  Maximo (en Hora)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Promedio (en Hora)</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo (isset($row_trasa_asigoper['producto']) ? $row_trasa_asigoper['producto']:""); ?></td>
      <td align="left" valign="middle"><?php echo (isset($row_trasa_asigoper['evento']) ? $row_trasa_asigoper['evento']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_asigoper['date_espe']) ? $row_trasa_asigoper['date_espe']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_asigoper['minimo']) ? $row_trasa_asigoper['minimo']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_asigoper['maximo']) ? $row_trasa_asigoper['maximo']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_asigoper['promedio']) ? $row_trasa_asigoper['promedio']:""); ?></td>
    </tr>
    <?php } while ($row_trasa_asigoper = mysqli_fetch_assoc($trasa_asigoper)); ?>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="6" align="left" valign="middle" bgcolor="#999999"><span class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" />Alta Operador v/s Alta Supervisor</span></td>
  </tr>
  <tr>
    <td width="30%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Producto</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
    <td width="20%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso Especialista</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo  Minimo (en Hora)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo  Maximo (en Hora)</td>
    <td width="10%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tiempo Promedio (en Hora)</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo (isset($row_trasa_opersupe['producto']) ? $row_trasa_opersupe['producto']:""); ?></td>
      <td align="left" valign="middle"><?php echo (isset($row_trasa_opersupe['evento']) ? $row_trasa_opersupe['evento']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_opersupe['date_espe']) ? $row_trasa_opersupe['date_espe']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_opersupe['minimo']) ? $row_trasa_opersupe['minimo']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_opersupe['maximo']) ? $row_trasa_opersupe['maximo']:""); ?></td>
      <td align="center" valign="middle"><?php echo (isset($row_trasa_opersupe['promedio']) ? $row_trasa_opersupe['promedio']:""); ?></td>
    </tr>
    <?php } while ($row_trasa_opersupe = mysqli_fetch_assoc($trasa_opersupe)); ?>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="trazabilidad_resumen_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($trasa_ingrec);
mysqli_free_result($trasa_espevisa);
mysqli_free_result($trasa_visaasig);
mysqli_free_result($trasa_asigoper);
mysqli_free_result($trasa_opersupe);
?>