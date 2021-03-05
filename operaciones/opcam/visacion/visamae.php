<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
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
$colname_DetailRS1 = "Pendiente.";
if (isset($_GET['sub_estado'])) {
  $colname_DetailRS1 = $_GET['sub_estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opste WHERE sub_estado = %s ORDER BY urgente DESC", GetSQLValueString($colname_DetailRS1, "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores";
$colores = mysqli_query($comercioexterior ,$query_colores) or die(mysqli_error());
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);
$colname_opbga = "Pendiente.";
if (isset($_GET['sub_estado'])) {
  $colname_opbga = $_GET['sub_estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opbga = sprintf("SELECT * FROM opbga WHERE sub_estado = %s ORDER BY urgente DESC", GetSQLValueString($colname_opbga, "text"));
$opbga = mysqli_query($comercioexterior, $query_opbga) or die(mysqli_error());
$row_opbga = mysqli_fetch_assoc($opbga);
$totalRows_opbga = mysqli_num_rows($opbga);
$colname_opcex = "Pendiente.";
if (isset($_GET['sub_estado'])) {
  $colname_opcex = $_GET['sub_estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcex = sprintf("SELECT * FROM opcex WHERE sub_estado = %s", GetSQLValueString($colname_opcex, "text"));
$opcex = mysqli_query($comercioexterior, $query_opcex) or die(mysqli_error());
$row_opcex = mysqli_fetch_assoc($opcex);
$totalRows_opcex = mysqli_num_rows($opcex);
$colname_optbc = "Pendiente.";
if (isset($_GET['sub_estado'])) {
  $colname_optbc = $_GET['sub_estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_optbc = sprintf("SELECT * FROM optbc WHERE sub_estado = %s  ORDER BY urgente DESC", GetSQLValueString($colname_optbc, "text"));
$optbc = mysqli_query($comercioexterior, $query_optbc) or die(mysqli_error());
$row_optbc = mysqli_fetch_assoc($optbc);
$totalRows_optbc = mysqli_num_rows($optbc);
$colname_opstbr = "Pendiente.";
if (isset($_GET['sub_estado'])) {
  $colname_opstbr = $_GET['sub_estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opstbr = sprintf("SELECT * FROM opstr WHERE sub_estado = %s ORDER BY urgente DESC", GetSQLValueString($colname_opstbr, "text"));
$opstbr = mysqli_query($comercioexterior, $query_opstbr) or die(mysqli_error());
$row_opstbr = mysqli_fetch_assoc($opstbr);
$totalRows_opstbr = mysqli_num_rows($opstbr);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Visaci&oacute;n - Maestro</title>
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
.Estilo16 {color: #00FF00}
.Estilo19 {font-size: 10px; color: #FFFFFF; font-weight: bold; }
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
    <td width="93%" align="left" valign="middle" class="Estilo3">VISACI&Oacute;N</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CAMBIOS</td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../cambio.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_opstbr > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="9" align="left" valign="middle"><span class="Estilo12"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"> </span><span class="Estilo15">Hay <span class="Estilo16"><?php echo $totalRows_opstbr ?></span> para visaci&oacute;n Stand By Recibidas</span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Visar
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso Op.
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><a href="visadetstr.php?recordID=<?php echo $row_opstbr['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></div></td>
    <td align="center" valign="middle" class="Estilo5"> <span class="respuestacolumna_rojo"><?php echo $row_opstbr['id']; ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_opstbr['rut_cliente']; ?></div></td>
    <td align="left" valign="middle" class="respuestacolumna"><?php echo $row_opstbr['nombre_cliente']; ?></td>
    <td align="center" valign="middle"><?php echo $row_opstbr['date_asig']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_opstbr['evento']; ?></div></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_opstbr['nro_operacion']; ?></span>      </div></td>
    <td align="right" valign="middle">   <span class="respuestacolumna_rojo"><?php echo $row_opstbr['moneda_operacion']; ?> </span><strong><?php echo number_format($row_opstbr['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle">  <?php if ($row_opstbr['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_opstbr['urgente']; ?> </span></span>        
		<?php } // Show if not first page ?>
		<?php if ($row_opstbr['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_opstbr['urgente']; ?> </span></span>
	    <?php } // Show if not first page ?> </div></td>
  </tr>
  <?php } while ($row_opstbr = mysqli_fetch_assoc($opstbr)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_DetailRS1 > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="11" align="left" valign="middle"><span class="Estilo12"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"> <span class="Estilo13">Hay <span class="Estilo16"><?php echo $totalRows_DetailRS1 ?></span> para visaci&oacute;n Stand By Emitidas </span></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Visar
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso Esp. 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso Op.
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
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><a href="visadet.php?recordID=<?php echo $row_DetailRS1['id']; ?>"> <img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></div></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_DetailRS1['id']; ?></span></div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?></div></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['date_espe']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['date_asig']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['evento']; ?></div></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_DetailRS1['nro_operacion']); ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['especialista_curse']); ?></div></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_DetailRS1['moneda_operacion']); ?></span>&nbsp; <strong class="respuestacolumna_azul"><?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle"><?php if ($row_DetailRS1['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_DetailRS1['urgente']; ?> </span></span>        
		<?php } // Show if not first page ?>
		<?php if ($row_DetailRS1['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_DetailRS1['urgente']; ?> </span></span>
	    <?php } // Show if not first page ?>      </td>
  </tr>
  <?php } while ($row_DetailRS1 = mysqli_fetch_assoc($DetailRS1)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_opbga > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td colspan="11" align="left"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulodetalle">Hay </span><span class="tituloverde"><?php echo $totalRows_opbga ?></span><span class="titulodetalle"> para visaci&oacute;n Boletas de Garant&iacute;a </div>
      </span></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td><span class="Estilo19">Visar</span></td>
    <td><span class="Estilo19">Nro Folio </span></td>
    <td><span class="Estilo19">Rut Cliente </span></td>
    <td><span class="Estilo19">Nombre Cliente </span></td>
    <td><span class="Estilo19">Fecha Ingreso Esp. </span></td>
    <td><span class="Estilo12">Fecha Ingreso Op.</span></td>
    <td><span class="Estilo19">Evento</span></td>
    <td><span class="Estilo19">Nro Operaci&oacute;n </span></td>
    <td><span class="Estilo19">Especialista</span></td>
    <td><span class="Estilo19">Moneda / Monto Operaci&oacute;n</span></td>
    <td><span class="Estilo19">Urgente</span></td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center" valign="middle"><a href="visadetbga.php?recordID=<?php echo $row_opbga['id']; ?>"> <img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opbga['id']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_opbga['rut_cliente']); ?> </td>
    <td align="left"><?php echo strtoupper($row_opbga['nombre_cliente']); ?> </td>
    <td align="center"><?php echo $row_opbga['date_espe']; ?> </td>
    <td align="center"><?php echo $row_opbga['date_asig']; ?></div></td>
    <td align="center"><?php echo $row_opbga['evento']; ?> </td>
    <td align="center" class="respuestacolumna_rojo"><?php echo strtoupper($row_opbga['nro_operacion']); ?> </td>
    <td align="center"><?php echo $row_opbga['especialista_curse']; ?> </td>
    <td><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opbga['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_opbga['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
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
    <td colspan="12" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulodetalle">Hay </span><span class="tituloverde"><?php echo $totalRows_opcex ?></span><span class="titulodetalle"> para visaci&oacute;n Otros Productos de Cambio </div>
      </span></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td valign="middle"><span class="Estilo12">Visar</span></td>
    <td valign="middle"><span class="Estilo12">Nro Folio </span></td>
    <td valign="middle"><span class="Estilo12">Rut Cliente</span></td>
    <td valign="middle"><span class="Estilo12">Nombre Cliente </span></td>
    <td valign="middle"><span class="Estilo12">Fecha Ingreso Esp. </span></td>
    <td valign="middle"><span class="Estilo12">Fecha Ingreso Op. </span></td>
    <td valign="middle"><span class="Estilo12">Evento</span></td>
    <td valign="middle"><span class="Estilo12">Tipo Operaci&oacute;n </span></td>
    <td valign="middle"><span class="Estilo12">Nro Operaci&oacute;n </span></td>
    <td valign="middle"><span class="Estilo12">Especialista</span></td>
    <td valign="middle"><span class="Estilo12">Moneda / Monto Operaci&oacute;n </span></td>
    <td valign="middle"><span class="Estilo12">Urgente</span></td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><a href="visadetcex.php?recordID=<?php echo $row_opcex['id']; ?>"> <img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_opcex['id']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_opcex['rut_cliente']); ?></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_opcex['nombre_cliente']); ?></td>
    <td align="center" valign="middle"><?php echo $row_opcex['date_espe']; ?></td>
    <td align="center" valign="middle"><?php echo $row_opcex['date_asig']; ?></td>
    <td align="center" valign="middle"><?php echo $row_opcex['evento']; ?></div></td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_opcex['tipo_operacion']); ?></td>
    <td align="center" valign="middle"><?php echo $row_opcex['nro_operacion']; ?></td>
    <td align="center" valign="middle"><?php echo $row_opcex['especialista_curse']; ?></td>
    <td valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opcex['moneda_operacion']); ?></span>&nbsp; <strong class="respuestacolumna_azul"><?php echo number_format($row_opcex['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
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
    <td colspan="11" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulodetalle">Hay </span><span class="tituloverde"><?php echo $totalRows_optbc ?></span><span class="titulodetalle"> para visaci&oacute;n Cr&eacute;ditos IIIB5 </div>
      </span></td>
  </tr>
  <tr align="center" valign="middle" bgcolor="#999999">
    <td valign="middle"><span class="Estilo12">Visar</span></td>
    <td valign="middle"><span class="Estilo12">Nro Folio </span></td>
    <td valign="middle"><span class="Estilo12">Rut Cliente </span></td>
    <td valign="middle"><span class="Estilo12">Nombre Cliente </span></td>
    <td valign="middle"><span class="Estilo12">Fecha Ingreso Esp. </span></td>
    <td valign="middle"><span class="Estilo12">Fecha Ingreso Op.</span></td>
    <td valign="middle"><span class="Estilo12">Evento</span></td>
    <td valign="middle"><span class="Estilo12">Nro Operaci&oacute;n</span></td>
    <td valign="middle"><span class="Estilo12">Especialista</span></td>
    <td valign="middle"><span class="Estilo12">Moneda / Monto Operaci&oacute;n </span></td>
    <td valign="middle"><span class="Estilo12">Urgente</span></td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><a href="visadettbc.php?recordID=<?php echo $row_optbc['id']; ?>"> <img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_optbc['id']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_optbc['rut_cliente']); ?></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_optbc['nombre_cliente']); ?></td>
    <td align="center" valign="middle"><?php echo $row_optbc['date_espe']; ?></td>
    <td align="center" valign="middle"><?php echo $row_optbc['date_asig']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_optbc['evento']; ?></td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_optbc['nro_operacion']); ?></td>
    <td align="center" valign="middle"><?php echo $row_optbc['especialista_curse']; ?></td>
    <td valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_optbc['moneda_operacion']); ?></span>&nbsp; <strong class="respuestacolumna_azul"><?php echo number_format($row_optbc['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
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
mysqli_free_result($DetailRS1);
mysqli_free_result($colores);
mysqli_free_result($opbga);
mysqli_free_result($opcex);
mysqli_free_result($optbc);
mysqli_free_result($opstbr);
?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          