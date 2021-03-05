<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,SUP";
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
$maxRows_alta = 5000;
$pageNum_alta = 0;
if (isset($_GET['pageNum_alta'])) {
  $pageNum_alta = $_GET['pageNum_alta'];
}
$startRow_alta = $pageNum_alta * $maxRows_alta;
$colname3_alta = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname3_alta = $_GET['nro_operacion'];
}
$colname4_alta = "Requerimiento.";
if (isset($_GET['evento'])) {
  $colname4_alta = $_GET['evento'];
}
$colname2_alta = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname2_alta = $_GET['estado'];
}
$colname1_alta = "Cursada.";
if (isset($_GET['sub_estado'])) {
  $colname1_alta = $_GET['sub_estado'];
}
$colname_alta = "Cursada.";
if (isset($_GET['estado_visacion'])) {
  $colname_alta = $_GET['estado_visacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_alta = sprintf("SELECT * FROM opstr WHERE estado_visacion = %s and sub_estado = %s and nro_operacion LIKE %s and estado = %s and evento = %s ORDER BY urgente DESC", GetSQLValueString($colname_alta, "text"),GetSQLValueString($colname1_alta, "text"),GetSQLValueString("%" . $colname3_alta . "%", "text"),GetSQLValueString($colname2_alta, "text"),GetSQLValueString($colname4_alta, "text"));
$query_limit_alta = sprintf("%s LIMIT %d, %d", $query_alta, $startRow_alta, $maxRows_alta);
$alta = mysqli_query($comercioexterior, $query_limit_alta) or die(mysqli_error());
$row_alta = mysqli_fetch_assoc($alta);
if (isset($_GET['totalRows_alta'])) {
  $totalRows_alta = $_GET['totalRows_alta'];
} else {
  $all_alta = mysqli_query($comercioexterior, $query_alta);
  $totalRows_alta = mysqli_num_rows($all_alta);
}
$totalPages_alta = ceil($totalRows_alta/$maxRows_alta)-1;
$colname_opste = "Cursada.";
if (isset($_GET['estado_visacion'])) {
  $colname_opste = $_GET['estado_visacion'];
}
$colname4_opste = "Requerimiento.";
if (isset($_GET['evento'])) {
  $colname4_opste = $_GET['evento'];
}
$colname2_opste = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname2_opste = $_GET['estado'];
}
$colname1_opste = "Cursada.";
if (isset($_GET['sub_estado'])) {
  $colname1_opste = $_GET['sub_estado'];
}
$colname3_opste = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname3_opste = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opste = sprintf("SELECT * FROM opste WHERE estado_visacion = %s and sub_estado = %s and nro_operacion LIKE %s and estado = %s and evento = %s ORDER BY urgente DESC", GetSQLValueString($colname_opste, "text"),GetSQLValueString($colname1_opste, "text"),GetSQLValueString("%" . $colname3_opste . "%", "text"),GetSQLValueString($colname2_opste, "text"),GetSQLValueString($colname4_opste, "text"));
$opste = mysqli_query($comercioexterior, $query_opste) or die(mysqli_error());
$row_opste = mysqli_fetch_assoc($opste);
$totalRows_opste = mysqli_num_rows($opste);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);
$colname_optbc = "Cursada.";
if (isset($_GET['estado_visacion'])) {
  $colname_optbc = $_GET['estado_visacion'];
}
$colname4_optbc = "Requerimiento.";
if (isset($_GET['evento'])) {
  $colname4_optbc = $_GET['evento'];
}
$colname2_optbc = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname2_optbc = $_GET['estado'];
}
$colname1_optbc = "Cursada.";
if (isset($_GET['sub_estado'])) {
  $colname1_optbc = $_GET['sub_estado'];
}
$colname3_optbc = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname3_optbc = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_optbc = sprintf("SELECT * FROM optbc WHERE estado_visacion = %s and sub_estado = %s and nro_operacion LIKE %s and estado = %s and evento = %s ORDER BY urgente DESC", GetSQLValueString($colname_optbc, "text"),GetSQLValueString($colname1_optbc, "text"),GetSQLValueString("%" . $colname3_optbc . "%", "text"),GetSQLValueString($colname2_optbc, "text"),GetSQLValueString($colname4_optbc, "text"));
$optbc = mysqli_query($comercioexterior, $query_optbc) or die(mysqli_error());
$row_optbc = mysqli_fetch_assoc($optbc);
$totalRows_optbc = mysqli_num_rows($optbc);
$colname_opcrext = "Cursada.";
if (isset($_GET['estado'])) {
  $colname_opcrext = $_GET['estado'];
}
$colname4_opcrext = "Requerimiento.";
if (isset($_GET['evento'])) {
  $colname4_opcrext = $_GET['evento'];
}
$colname2_opcrext = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname2_opcrext = $_GET['estado'];
}
$colname1_opcrext = "Cursada.";
if (isset($_GET['sub_estado'])) {
  $colname1_opcrext = $_GET['sub_estado'];
}
$colname3_opcrext = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname3_opcrext = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcrext = sprintf("SELECT * FROM opcex WHERE estado_visacion = %s and sub_estado = %s and nro_operacion LIKE %s and estado = %s and evento = %s ORDER BY urgente DESC", GetSQLValueString($colname_opcrext, "text"),GetSQLValueString($colname1_opcrext, "text"),GetSQLValueString("%" . $colname3_opcrext . "%", "text"),GetSQLValueString($colname2_opcrext, "text"),GetSQLValueString($colname4_opcrext, "text"));
$opcrext = mysqli_query($comercioexterior, $query_opcrext) or die(mysqli_error());
$row_opcrext = mysqli_fetch_assoc($opcrext);
$totalRows_opcrext = mysqli_num_rows($opcrext);
$colname_opbga = "Cursada.";
if (isset($_GET['estado_visacion'])) {
  $colname_opbga = $_GET['estado_visacion'];
}
$colname4_opbga = "Requerimiento.";
if (isset($_GET['evento'])) {
  $colname4_opbga = $_GET['evento'];
}
$colname2_opbga = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname2_opbga = $_GET['estado'];
}
$colname1_opbga = "Cursada.";
if (isset($_GET['sub_estado'])) {
  $colname1_opbga = $_GET['sub_estado'];
}
$colname3_opbga = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname3_opbga = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opbga = sprintf("SELECT * FROM opbga WHERE estado_visacion = %s and sub_estado = %s and nro_operacion LIKE %s and estado = %s and evento = %s ORDER BY urgente DESC", GetSQLValueString($colname_opbga, "text"),GetSQLValueString($colname1_opbga, "text"),GetSQLValueString("%" . $colname3_opbga . "%", "text"),GetSQLValueString($colname2_opbga, "text"),GetSQLValueString($colname4_opbga, "text"));
$opbga = mysqli_query($comercioexterior, $query_opbga) or die(mysqli_error());
$row_opbga = mysqli_fetch_assoc($opbga);
$totalRows_opbga = mysqli_num_rows($opbga);
$queryString_alta = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_alta") == false && 
        stristr($param, "totalRows_alta") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_alta = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_alta = sprintf("&totalRows_alta=%d%s", $totalRows_alta, $queryString_alta);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Alta Operaciones - Maestro</title>
<style type="text/css">
<!--
@import url(../../../../estilos/estilo12.css);
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
.Estilo5 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {color: #FFFFFF}
.Estilo7 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo8 {color: #FFFFFF; font-weight: bold; }
.Estilo10 {color: #FFFFFF; font-size: 12px;}
.Estilo11 {
	color: #00FF00;
	font-weight: bold;
}
.Estilo14 {font-size: 12px}
.Estilo16 {font-size: 12px; color: #00FF00; font-weight: bold; }
.Estilo17 {color: #00FF00}
.Estilo19 {
	font-size: 12;
	font-weight: bold;
}
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
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<meta http-equiv="refresh" content="60" />
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">ALTA OPERACIONES SUPERVISOR - MAESTRO </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">OPERACIONES DE CAMBIO</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="titulodetalle">Alta Operaciones Supervisor</span></span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle" class="respuestacolumna">Nro Operaci&oacute;n:</div></td>
      <td width="79%" align="left" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="17" maxlength="17">        </td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../cambio.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_alta > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="7" align="left" valign="middle"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="titulodetalle">Total de Operaciones para Curse Stand By Recibidas </span><span class="Estilo10"><span class="tituloverde"><?php echo $totalRows_alta ?></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" valign="middle"><strong class="titulocolumnas">Cursar</strong></div></td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Tipo Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><a href="altadet.php?recordID=<?php echo $row_alta['id']; ?>"> <img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"> </a> </div></td>
    <td align="center" valign="middle"><?php echo $row_alta['evento']; ?></div></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_alta['nro_operacion']); ?></span>      </div></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_alta['tipo_operacion']; ?></td>
    <td align="left" valign="middle" class="respuestacolumna"><?php echo strtoupper($row_alta['nombre_cliente']); ?> </td>
    <td align="right" valign="middle"> <span class="respuestacolumna_rojo"><?php echo strtoupper($row_alta['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_alta['monto_operacion'], 2, ',', '.'); ?></strong> </div></td>
    <td align="center" valign="middle"><?php if ($row_alta['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        </div>
      <span class="Rojo2"><?php echo $row_alta['urgente']; ?> </span>       
	        <?php } // Show if not first page ?>
	        <?php if ($row_alta['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
              <span class="Verde2"><?php echo $row_alta['urgente']; ?> </span>
    <?php } // Show if not first page ?> </td>
  </tr>
  <?php } while ($row_alta = mysqli_fetch_assoc($alta)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_opste > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="7" align="left"><span class="Estilo8"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="titulodetalle">Total de Operaciones para Curse Stand By Emitidas </span></span><span class="tituloverde"><?php echo $totalRows_opste ?></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center"><span class="titulocolumnas">Cursar</span>      </div></td>
    <td align="center" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" class="titulocolumnas">Tipo Operaci&oacute;n </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
    <td align="center" class="titulocolumnas">Urgente
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="altadetste.php?recordID=<?php echo $row_opste['id']; ?>"> <img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></div></td>
    <td align="center" class="respuestacolumna"><?php echo $row_opste['evento']; ?> </td>
    <td align="center" class="respuestacolumna_rojo"><?php echo strtoupper($row_opste['nro_operacion']); ?> </td>
    <td align="center" class="respuestacolumna"><?php echo $row_opste['tipo_operacion']; ?> </td>
    <td align="left" class="respuestacolumna"><?php echo strtoupper($row_opste['nombre_cliente']); ?> </td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opste['moneda_operacion']); ?></span> 
      <strong class="respuestacolumna_azul"><?php echo number_format($row_opste['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center"><?php if ($row_opste['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        </div>
        <span class="Rojo2"><?php echo $row_opste['urgente']; ?> </span>
		<?php } // Show if not first page ?>
		<?php if ($row_opste['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
              <span class="Verde2"><?php echo $row_opste['urgente']; ?> </span>
    <?php } // Show if not first page ?></td>
  </tr>
  <?php } while ($row_opste = mysqli_fetch_assoc($opste)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_optbc > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="7" align="left"><span class="Estilo8"><span class="Estilo14"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span></span><span class="titulodetalle">Total de Operaciones para  Curse de III B5</span><span class="Estilo8"><span class="Estilo14"> <span class="tituloverde"><?php echo $totalRows_optbc ?></span></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center"><strong class="titulodetalle"><span class="titulocolumnas">Cursar</span></strong>      </div></td>
    <td align="center" class="titulocolumnas"><strong>Evento</strong>
      </div>
    </td>
    <td align="center" class="titulocolumnas"><strong>Numero Operaci&oacute;n </strong>
      </div>
    </td>
    <td align="center" class="titulocolumnas"><strong>Tipo Operaci&oacute;n </strong>
      </div>
    </td>
    <td align="center" class="titulocolumnas"><strong>Nombre Cliente </strong>
      </div>
    </td>
    <td align="center" class="titulocolumnas"><strong>Moneda / Monto Operaci&oacute;n </strong>
      </div>
    </td>
    <td align="center" class="titulocolumnas"><strong>Urgente</strong>
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="../../../../opcam/controles/altaope/untitled.php?recordID=<?php echo $row_optbc['id']; ?>"> </a><a href="altadettbc.php?recordID=<?php echo $row_optbc['id']; ?>"><img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></div></td>
    <td align="center"><?php echo $row_optbc['evento']; ?></div></td>
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_optbc['nro_operacion']); ?></span>      </div></td>
    <td align="center"><?php echo $row_optbc['tipo_operacion']; ?></div></td>
    <td align="left" class="respuestacolumna"><?php echo strtoupper($row_optbc['nombre_cliente']); ?> </td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_optbc['moneda_operacion']); ?></span> 
      <strong class="respuestacolumna_azul"><?php echo number_format($row_optbc['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center"><?php if ($row_optbc['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_optbc['urgente']; ?> </span>
        <?php } // Show if not first page ?>
        <?php if ($row_optbc['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
              <span class="Verde2"><?php echo $row_optbc['urgente']; ?> </span>
        <?php } // Show if not first page ?>
    </div></td>
  </tr>
  <?php } while ($row_optbc = mysqli_fetch_assoc($optbc)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_opcrext > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="7" align="left" valign="middle"><span class="Estilo8"><span class="Estilo14"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span></span><span class="titulodetalle">Total de Operaciones para Otros Productos</span><span class="Estilo8"><span class="Estilo14"> <span class="tituloverde"><?php echo $totalRows_opcrext ?></span></span></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle"><span class="titulocolumnas">Cursar</span>      </div></td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Tipo Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><a href="altadetcext.php?recordID=<?php echo $row_opcrext['id']; ?>"> <img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></div></td>
    <td align="center" valign="middle"><?php echo $row_opcrext['evento']; ?> </div></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opcrext['nro_operacion']); ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_opcrext['tipo_operacion']; ?></div></td>
    <td align="left" valign="middle" class="respuestacolumna"><?php echo strtoupper($row_opcrext['nombre_cliente']); ?> </td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opcrext['moneda_operacion']); ?></span><strong><?php echo number_format($row_opcrext['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle"><?php if ($row_opcrext['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_opcrext['urgente']; ?> </span>
        <?php } // Show if not first page ?>
        <?php if ($row_opcrext['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_opcrext['urgente']; ?> </span>
        <?php } // Show if not first page ?></td>
  </tr>
  <?php } while ($row_opcrext = mysqli_fetch_assoc($opcrext)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_opbga > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="7" align="left" valign="middle"><span class="Estilo8"><span class="Estilo14"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span></span><span class="titulodetalle">Total de Operaciones para Boletas de Garant&iacute;a</span><span class="Estilo6"><span class="Estilo14"><span class="Estilo19"> <span class="tituloverde"><?php echo $totalRows_opbga ?></span></span></span></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle"><span class="titulocolumnas">Cursar</span>      </div></td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Tipo Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto OPeraci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><a href="altadetbga.php?recordID=<?php echo $row_opbga['id']; ?>"> <img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></div></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_opbga['evento']; ?> </td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_opbga['nro_operacion']); ?></td>
    <td align="center" valign="middle" class="respuestacolumna"><?php echo $row_opbga['tipo_operacion']; ?> </td>
    <td align="left" valign="middle" class="respuestacolumna"><?php echo strtoupper($row_opbga['nombre_cliente']); ?></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opbga['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"<?php echo number_format($row_opbga['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle">
        <?php if ($row_opbga['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_opbga['urgente']; ?> </span>
        <?php } // Show if not first page ?>
        <?php if ($row_opbga['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_opbga['urgente']; ?> </span>
        <?php } // Show if not first page ?>
    </div></td>
  </tr>
  <?php } while ($row_opbga = mysqli_fetch_assoc($opbga)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($alta);
mysqli_free_result($opste);
mysqli_free_result($colores);
mysqli_free_result($optbc);
mysqli_free_result($opcrext);
mysqli_free_result($opbga);
?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             