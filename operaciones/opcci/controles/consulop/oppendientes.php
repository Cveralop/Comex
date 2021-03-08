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
$maxRows_pendientes = 5000;
$pageNum_pendientes = 0;
if (isset($_GET['pageNum_pendientes'])) {
  $pageNum_pendientes = $_GET['pageNum_pendientes'];
}
$startRow_pendientes = $pageNum_pendientes * $maxRows_pendientes;
$colname1_pendientes = "No";
if (isset($_GET['urgente'])) {
  $colname1_pendientes = $_GET['urgente'];
}
$colname2_pendientes = "No";
if (isset($_GET['fuera_horario'])) {
  $colname2_pendientes = $_GET['fuera_horario'];
}
$colname_pendientes = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname_pendientes = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_pendientes = sprintf("SELECT * FROM opcci WHERE estado = %s and urgente = %s and fuera_horario = %s ORDER BY date_ingreso ASC", GetSQLValueString($colname_pendientes, "text"),GetSQLValueString($colname1_pendientes, "text"),GetSQLValueString($colname2_pendientes, "text"));
$query_limit_pendientes = sprintf("%s LIMIT %d, %d", $query_pendientes, $startRow_pendientes, $maxRows_pendientes);
$pendientes = mysqli_query($comercioexterior, $query_limit_pendientes) or die(mysqli_error($comercioexterior));
$row_pendientes = mysqli_fetch_assoc($pendientes);
if (isset($_GET['totalRows_pendientes'])) {
  $totalRows_pendientes = $_GET['totalRows_pendientes'];
} else {
  $all_pendientes = mysqli_query($comercioexterior, $query_pendientes);
  $totalRows_pendientes = mysqli_num_rows($all_pendientes);
}
$totalPages_pendientes = ceil($totalRows_pendientes/$maxRows_pendientes)-1;
$colname_urgente = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname_urgente = $_GET['estado'];
}
$colname1_urgente = "Si";
if (isset($_GET['urgente'])) {
  $colname1_urgente = $_GET['urgente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_urgente = sprintf("SELECT * FROM opcci WHERE estado = %s and urgente = %s ORDER BY date_ingreso ASC", GetSQLValueString($colname_urgente, "text"),GetSQLValueString($colname1_urgente, "text"));
$urgente = mysqli_query($comercioexterior, $query_urgente) or die(mysqli_error($comercioexterior));
$row_urgente = mysqli_fetch_assoc($urgente);
$totalRows_urgente = mysqli_num_rows($urgente);
$colname_fuerahorario = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname_fuerahorario = $_GET['estado'];
}
$colname1_fuerahorario = "Si";
if (isset($_GET['fuera_horario'])) {
  $colname1_fuerahorario = $_GET['fuera_horario'];
}
$colname2_fuerahorario = "Si";
if (isset($_GET['fuera_hotario'])) {
  $colname2_fuerahorario = $_GET['fuera_hotario'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_fuerahorario = sprintf("SELECT * FROM opcci WHERE estado = %s and fuera_horario = %s and urgente <> %s ORDER BY date_ingreso ASC", GetSQLValueString($colname_fuerahorario, "text"),GetSQLValueString($colname1_fuerahorario, "text"),GetSQLValueString($colname2_fuerahorario, "text"));
$fuerahorario = mysqli_query($comercioexterior, $query_fuerahorario) or die(mysqli_error($comercioexterior));
$row_fuerahorario = mysqli_fetch_assoc($fuerahorario);
$totalRows_fuerahorario = mysqli_num_rows($fuerahorario);
$colname_opnorecibidas = "No";
if (isset($_GET['fuera_horario'])) {
  $colname_opnorecibidas = $_GET['fuera_horario'];
}
$colname1_opnorecibidas = "Carta de Credito Import";
if (isset($_GET['producto'])) {
  $colname1_opnorecibidas = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opnorecibidas = sprintf("SELECT * FROM opnorecibidas WHERE fuera_horario = %s and producto = %s ORDER BY tiempo DESC", GetSQLValueString($colname_opnorecibidas, "text"),GetSQLValueString($colname1_opnorecibidas, "text"));
$opnorecibidas = mysqli_query($comercioexterior, $query_opnorecibidas) or die(mysqli_error());
$row_opnorecibidas = mysqli_fetch_assoc($opnorecibidas);
$totalRows_opnorecibidas = mysqli_num_rows($opnorecibidas);
$queryString_pendientes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_pendientes") == false && 
        stristr($param, "totalRows_pendientes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_pendientes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_pendientes = sprintf("&totalRows_pendientes=%d%s", $totalRows_pendientes, $queryString_pendientes);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Control Operaciones Pendientes</title>
<style type="text/css">
<!--
@import url(../../../../estilos/estilo12.css);
.Estilo3 {	font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {	font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
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
.Estilo6 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo8 {color: #FFFFFF; font-weight: bold; }
.Estilo9 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo16 {color: #00FF00}
-->
</style>
<script src="../../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
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
</style>
<script> 
var segundos=1200
var direccion='../cierre.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<link href="../../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css">
</head>
<meta http-equiv="refresh" content="60" />
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CONTROL OPERACIONES PENDIENTES</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTAS DE CR&Eacute;DITO IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../carcreimp.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<div id="CollapsiblePanel1" class="CollapsiblePanel">
  <div class="CollapsiblePanelTab" tabindex="0">Operaciones Recibidas con Desfase Dentro de Hora</div>
  <div class="CollapsiblePanelContent"><br />
    <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
      <tr>
        <td colspan="8" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Operaciones No Recibidas por Operaciones (<span class="tituloverde"><?php echo $totalRows_opnorecibidas ?></span>)</td>
      </tr>
      <tr>
        <td align="center" valign="middle" class="titulocolumnas">Nro Registro Origen</td>
        <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso Especialista</td>
        <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
        <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
        <td align="center" valign="middle" class="titulocolumnas">Evento</td>
        <td align="center" valign="middle" class="titulocolumnas">Especialista</td>
        <td align="center" valign="middle" class="titulocolumnas">Producto</td>
        <td align="center" valign="middle" class="titulocolumnas">Tiempo Transcurrido</td>
      </tr>
      <?php do { ?>
      <tr>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_opnorecibidas['nro_registro']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opnorecibidas['date_espe']; ?></td>
        <td align="center" valign="middle"><?php echo $row_opnorecibidas['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opnorecibidas['nombre_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opnorecibidas['evento']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opnorecibidas['especialista_curse']; ?></td>
        <td align="left" valign="middle"><?php echo $row_opnorecibidas['producto']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opnorecibidas['tiempo']; ?></td>
      </tr>
      <?php } while ($row_opnorecibidas = mysqli_fetch_assoc($opnorecibidas)); ?>
    </table>
    <br />
  </div>
</div>
<br>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="12" align="left" valign="middle" bgcolor="#FF0000" class="NegrillaCartaReparo"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Total de Operaciones Pendientes <?php echo $totalRows_urgente ?> Curse Urgente</td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operacion</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Documentos</td>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Hora Ing. Espe.</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_urgente['id']; ?></td>
      <td align="center" valign="middle"><?php echo $row_urgente['evento']; ?></td>
      <td align="center" valign="middle"><?php echo $row_urgente['fecha_ingreso']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_urgente['nro_operacion']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_urgente['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_urgente['nombre_cliente']); ?></td>
      <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_urgente['moneda_operacion']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_urgente['monto_operacion'], 2, ',', '.'); ?></span></td>
      <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_urgente['monto_documentos']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_urgente['moneda_documentos'], 2, ',', '.'); ?></span></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_urgente['operador']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_urgente['especialista_curse']); ?></td>
      <td align="center" valign="middle"><?php echo $row_urgente['date_espe']; ?></td>
      <td align="center" valign="middle"><?php echo $row_urgente['urgente']; ?></td>
    </tr>
    <?php } while ($row_urgente = mysqli_fetch_assoc($urgente)); ?>
</table>
<br>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="12" align="left" bgcolor="#00CC00" class="NegrillaCartaReparo"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Total de Operaciones Pendientes <?php echo $totalRows_pendientes ?> Curse Normal</td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Nro Folio</td>
    <td align="center" class="titulocolumnas">Evento</td>
    <td align="center" class="titulocolumnas">Fecha Ingreso</td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n</td>
    <td align="center" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>
    </td>
    <td align="center" class="titulocolumnas">Moneda / Monto Documentos
      </div>
    </td>
    <td align="center" class="titulocolumnas">Operador</td>
    <td align="center" class="titulocolumnas">Especialista Curse</td>
    <td align="center" class="titulocolumnas">Hora Ing. Espe.</td>
    <td align="center" class="titulocolumnas">Urgente</td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center" class="respuestacolumna_rojo"><?php echo $row_pendientes['id']; ?></td>
    <td align="center"><?php echo $row_pendientes['evento']; ?></td>
    <td align="center"><?php echo $row_pendientes['fecha_ingreso']; ?></td>
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_pendientes['nro_operacion']); ?></span></td>
    <td align="center"><?php echo strtoupper($row_pendientes['rut_cliente']); ?></td>
    <td align="left"><?php echo strtoupper($row_pendientes['nombre_cliente']); ?></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_pendientes['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_pendientes['monto_operacion'], 2, ',', '.'); ?></strong>
      </div></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_pendientes['moneda_documentos']); ?></span> &nbsp;<strong class="respuestacolumna_azul"><?php echo number_format($row_pendientes['monto_documentos'], 2, ',', '.'); ?></strong></div></td>
    <td align="center"><?php echo strtoupper($row_pendientes['operador']); ?></td>
    <td align="center"><?php echo strtoupper($row_pendientes['especialista_curse']); ?>      </div></td>
    <td align="center"><?php echo $row_pendientes['date_espe']; ?></td>
<td align="center"><?php echo $row_pendientes['urgente']; ?></div></td>
  </tr>
  <?php } while ($row_pendientes = mysqli_fetch_assoc($pendientes)); ?>
</table>
<br>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="12" align="left" valign="middle" bgcolor="#FFFF00"><span class="NegrillaCartaReparo"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Total de Operaciones Pendientes <?php echo $totalRows_fuerahorario ?> Curse Fuera Horario</span></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Documentos</td>
    <td align="center" valign="middle" class="titulocolumnas">Operador</td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Hora Ing. Espe.</td>
    <td align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_fuerahorario['id']; ?></td>
      <td align="center" valign="middle"><?php echo $row_fuerahorario['evento']; ?></td>
      <td align="center" valign="middle"><?php echo $row_fuerahorario['fecha_ingreso']; ?></td>
      <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_fuerahorario['nro_operacion']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_fuerahorario['rut_cliente']); ?></td>
      <td align="left" valign="middle"><?php echo strtoupper($row_fuerahorario['nombre_cliente']); ?></td>
      <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_fuerahorario['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_fuerahorario['monto_operacion'], 2, ',', '.'); ?></span></td>
      <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_fuerahorario['moneda_documentos']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_fuerahorario['monto_documentos'], 2, ',', '.'); ?></span></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_fuerahorario['operador']); ?></td>
      <td align="center" valign="middle"><?php echo strtoupper($row_fuerahorario['especialista_curse']); ?></td>
      <td align="center" valign="middle"><?php echo $row_fuerahorario['date_espe']; ?></td>
      <td align="center" valign="middle"><?php echo $row_fuerahorario['fuera_horario']; ?></td>
    </tr>
    <?php } while ($row_fuerahorario = mysqli_fetch_assoc($fuerahorario)); ?>
</table>
<script type="text/javascript">
<!--
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
//-->
</script>
<?php
mysqli_free_result($pendientes);
mysqli_free_result($urgente);
mysqli_free_result($fuerahorario);
mysqli_free_result($opnorecibidas);
?>