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
$colname3_opste = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname3_opste = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opste = sprintf("SELECT * FROM opste WHERE estado = %s ORDER BY urgente DESC", GetSQLValueString($colname3_opste, "text"));
$opste = mysqli_query($comercioexterior, $query_opste) or die(mysqli_error());
$row_opste = mysqli_fetch_assoc($opste);
$totalRows_opste = mysqli_num_rows($opste);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);
$colname3_opbga = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname3_opbga = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opbga = sprintf("SELECT * FROM opbga WHERE  estado = %s  ORDER BY urgente DESC", GetSQLValueString($colname3_opbga, "text"));
$opbga = mysqli_query($comercioexterior, $query_opbga) or die(mysqli_error());
$row_opbga = mysqli_fetch_assoc($opbga);
$totalRows_opbga = mysqli_num_rows($opbga);
$colname3_opcex = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname3_opcex = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcex = sprintf("SELECT * FROM opcex WHERE estado = %s  ORDER BY urgente DESC", GetSQLValueString($colname3_opcex, "text"));
$opcex = mysqli_query($comercioexterior, $query_opcex) or die(mysqli_error());
$row_opcex = mysqli_fetch_assoc($opcex);
$totalRows_opcex = mysqli_num_rows($opcex);
$colname3_optbc = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname3_optbc = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_optbc = sprintf("SELECT * FROM optbc WHERE estado = %s  ORDER BY urgente DESC", GetSQLValueString($colname3_optbc, "text"));
$optbc = mysqli_query($comercioexterior, $query_optbc) or die(mysqli_error());
$row_optbc = mysqli_fetch_assoc($optbc);
$totalRows_optbc = mysqli_num_rows($optbc);
$colname_opstr = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname_opstr = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opstr = sprintf("SELECT * FROM opstr WHERE estado = %s ORDER BY id ASC", GetSQLValueString($colname_opstr, "text"));
$opstr = mysqli_query($comercioexterior, $query_opstr) or die(mysqli_error());
$row_opstr = mysqli_fetch_assoc($opstr);
$totalRows_opstr = mysqli_num_rows($opstr);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Control Operaciones Pendientes</title>
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
	font-weight: bold;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
	color: #0F0;
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
.Estilo5 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo12 {color: #FFFFFF; font-weight: bold; }
.Estilo13 {font-size: 12px}
.Estilo15 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo16 {
	color: #00FF00;
	font-size: 12px;
	font-weight: bold;
}
.Estilo19 {font-size: 10px; color: #FFFFFF; font-weight: bold; }
.aa {
	color: #FFF;
	font-weight: bold;
	font-size: 12px;
}
.aa td {
	color: #FFF;
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
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CONTROL OPERACIONES PENDIENTES</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CAMBIOS</td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><div align="right"><a href="../cambio.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0" align="right"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_opste > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="left" bgcolor="#999999">
    <td colspan="10" valign="middle"><span class="Estilo12"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"> <span class="Estilo13">Hay <span class="Estilo16"><?php echo $totalRows_opste ?></span> Stand BY Emitidas </span></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle"><span class="titulocolumnas">Nro Folio</span></div></td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso ESP
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Tipo Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr align="left">
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_opste['id']; ?></span></div></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo strtoupper($row_opste['rut_cliente']); ?></div>
    </td>
    <td align="left" valign="middle" class="respuestacolumna"><?php echo strtoupper($row_opste['nombre_cliente']); ?></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_opste['date_espe']; ?></div>
    </td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_opste['evento']; ?></div>
    </td>
    <td align="center" valign="middle" class="respuestacolumna"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opste['nro_operacion']); ?></span>      </div>
    </td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo strtoupper($row_opste['especialista_curse']); ?></div>
    </td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opste['moneda_operacion']); ?></span><strong class="respuestacolumna_azul"><?php echo number_format($row_opste['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_opste['tipo_operacion']; ?></td>
    <td align="center" valign="middle"><?php if ($row_opste['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_opste['urgente']; ?> </span></span>        
		<?php } // Show if not first page ?>
		<?php if ($row_opste['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_opste['urgente']; ?> </span></span>
	    <?php } // Show if not first page ?>      </td>
  </tr>
  <?php } while ($row_opste = mysqli_fetch_assoc($opste)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_opstr > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="10" align="left" valign="middle" bgcolor="#999999"><span class="Estilo12"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"></span><span class="aa">Hay</span> <span class="Estilo16"><?php echo $totalRows_opstr ?></span> <span class="aa">Stand BY Recibidas</span></td>
    </tr>
    <tr class="aa">
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Folio</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso ESP</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operaci&oacute;n</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Especilaista</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tipo Operaci&oacute;n</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Urgente</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opstr['id']; ?></td>
        <td align="left" valign="middle" class="respuestacolumna"><?php echo $row_opstr['rut_cliente']; ?></td>
        <td align="left" valign="middle" class="respuestacolumna"><?php echo $row_opstr['nombre_cliente']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_opstr['date_espe']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_opstr['evento']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opstr['nro_operacion']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_opstr['especialista_curse']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna"><span class="respuestacolumna_rojo"><?php echo $row_opstr['moneda_operacion']; ?></span><span class="respuestacolumna_azul"><?php echo number_format($row_opstr['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_opstr['tipo_operacion']; ?></td>
        <td align="center" valign="middle"><?php if ($row_opstr['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_opstr['urgente']; ?> </span></span>        
		<?php } // Show if not first page ?>
		<?php if ($row_opstr['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_opstr['urgente']; ?> </span></span>
	    <?php } // Show if not first page ?>      </td>
      </tr>
      <?php } while ($row_opstr = mysqli_fetch_assoc($opstr)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_opbga > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td colspan="9" align="left"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulodetalle">Hay </span><span class="tituloverde"><?php echo $totalRows_opbga ?></span><span class="titulodetalle"> Boletas de Garant&iacute;a</span></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Nro Folio </td>
    <td align="center" class="titulocolumnas">Rut Cliente </td>
    <td align="center" class="titulocolumnas">Nombre Cliente </td>
    <td align="center" class="titulocolumnas">Fecha Ingreso ESP</td>
    <td align="center" class="titulocolumnas">Evento</td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </td>
    <td align="center" class="titulocolumnas">Especialista</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
    <td align="center" class="titulocolumnas">Urgente</td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opbga['id']; ?></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo strtoupper($row_opbga['rut_cliente']); ?> </td>
    <td align="left" class="respuestacolumna"><?php echo strtoupper($row_opbga['nombre_cliente']); ?> </td>
    <td align="center" class="respuestacolumna"><?php echo $row_opbga['date_espe']; ?> </td>
    <td align="center" class="respuestacolumna"><?php echo $row_opbga['evento']; ?> </td>
    <td align="center" class="respuestacolumna_rojo"><?php echo strtoupper($row_opbga['nro_operacion']); ?> </td>
    <td align="center" class="respuestacolumna"><?php echo $row_opbga['especialista_curse']; ?> </td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opbga['moneda_operacion']); ?></span> <strong><?php echo number_format($row_opbga['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center"><?php if ($row_opbga['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_opbga['urgente']; ?> </span></span>        
        <?php } // Show if not first page ?>
        <?php if ($row_opbga['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_opbga['urgente']; ?> </span></span>
        <?php } // Show if not first page ?> </td>
  </tr>
  <?php } while ($row_opbga = mysqli_fetch_assoc($opbga)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_opcex > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td colspan="10" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulodetalle">Hay </span><span class="tituloverde"><?php echo $totalRows_opcex ?></span><span class="titulodetalle">  Otros Productos de Cambio</span></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso ESP</td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </td>
    <td align="center" valign="middle" class="titulocolumnas">Tipo Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcex['id']; ?></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo strtoupper($row_opcex['rut_cliente']); ?></td>
    <td align="left" valign="middle" class="respuestacolumna"><?php echo strtoupper($row_opcex['nombre_cliente']); ?></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_opcex['date_esp']; ?></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_opcex['evento']; ?></td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcex['nro_operacion']; ?></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_opcex['especialista_curse']; ?></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opcex['moneda_operacion']); ?></span><strong><?php echo number_format($row_opcex['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_opcex['tipo_operacion']; ?></td>
    <td align="center" valign="middle"><?php if ($row_opcex['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_opcex['urgente']; ?> </span></span>        
        <?php } // Show if not first page ?>
        <?php if ($row_opcex['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_opcex['urgente']; ?> </span></span>
    <?php } // Show if not first page ?></td>
  </tr>
  <?php } while ($row_opcex = mysqli_fetch_assoc($opcex)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_optbc > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td colspan="9" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulodetalle">Hay </span><span class="tituloverde"><?php echo $totalRows_optbc ?></span><span class="titulodetalle">  Cr&eacute;ditos IIIB5</span></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente </td>
    <td align="center" valign="middle"><span class="Estilo12">Nombre Cliente </span></td>
    <td align="center" valign="middle"><span class="Estilo12">Fecha Ingreso ESP</span></td>
    <td align="center" valign="middle"><span class="Estilo12">Evento</span></td>
    <td align="center" valign="middle"><span class="Estilo12">Nro Operaci&oacute;n</span></td>
    <td align="center" valign="middle"><span class="Estilo12">Especialista</span></td>
    <td align="center" valign="middle"><span class="Estilo12">Moneda / Monto Operaci&oacute;n </span></td>
    <td align="center" valign="middle"><span class="Estilo12">Urgente</span></td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_optbc['id']; ?></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo strtoupper($row_optbc['rut_cliente']); ?></td>
    <td align="left" valign="middle" class="respuestacolumna"><?php echo strtoupper($row_optbc['nombre_cliente']); ?></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_optbc['date_espe']; ?></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_optbc['evento']; ?></td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_optbc['nro_operacion']); ?></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_optbc['especialista_curse']; ?></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_optbc['moneda_operacion']); ?></span><strong class="respuestacolumna_azul"><?php echo number_format($row_optbc['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
<td align="center" valign="middle"><?php if ($row_optbc['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_optbc['urgente']; ?> </span></span>        
        <?php } // Show if not first page ?>
        <?php if ($row_optbc['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_optbc['urgente']; ?> </span></span>
    <?php } // Show if not first page ?></td>
  </tr>
  <?php } while ($row_optbc = mysqli_fetch_assoc($optbc)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($opste);
mysqli_free_result($colores);
mysqli_free_result($opbga);
mysqli_free_result($opcex);
mysqli_free_result($optbc);
mysqli_free_result($opstr);
?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     