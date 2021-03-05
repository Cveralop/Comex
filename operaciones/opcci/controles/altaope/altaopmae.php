<?php require_once('../../../../Connections/comercioexterior.php'); ?>
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
$maxRows_operador = 5000;
$pageNum_operador = 0;
if (isset($_GET['pageNum_operador'])) {
  $pageNum_operador = $_GET['pageNum_operador'];
}
$startRow_operador = $pageNum_operador * $maxRows_operador;
$colname1_operador = "Pendiente.";
if (isset($_GET['sub_estado'])) {
  $colname1_operador = $_GET['sub_estado'];
}
$colname3_operador = "No";
if (isset($_GET['urgente'])) {
  $colname3_operador = $_GET['urgente'];
}
$colname4_operador = "No";
if (isset($_GET['fuera_horario'])) {
  $colname4_operador = $_GET['fuera_horario'];
}
$colname2_operador = "K";
if (isset($_GET['nro_operacion'])) {
  $colname2_operador = $_GET['nro_operacion'];
}
$colname_operador = "-1";
if (isset($_SESSION['login'])) {
  $colname_operador = $_SESSION['login'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_operador = sprintf("SELECT opcci.*,(usuarios.nombre)as ne FROM opcci, usuarios WHERE operador = %s and sub_estado = %s and nro_operacion LIKE %s and urgente = %s and fuera_horario = %s and (opcci.especialista_curse = usuarios.usuario) ORDER BY date_asig ASC", GetSQLValueString($colname_operador, "text"),GetSQLValueString($colname1_operador, "text"),GetSQLValueString("%" . $colname2_operador . "%", "text"),GetSQLValueString($colname3_operador, "text"),GetSQLValueString($colname4_operador, "text"));
$query_limit_operador = sprintf("%s LIMIT %d, %d", $query_operador, $startRow_operador, $maxRows_operador);
$operador = mysql_query($query_limit_operador, $comercioexterior) or die(mysqli_error());
$row_operador = mysqli_fetch_assoc($operador);
if (isset($_GET['totalRows_operador'])) {
  $totalRows_operador = $_GET['totalRows_operador'];
} else {
  $all_operador = mysql_query($query_operador);
  $totalRows_operador = mysqli_num_rows($all_operador);
}
$totalPages_operador = ceil($totalRows_operador/$maxRows_operador)-1;
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);
$colname_urgente = "-1";
if (isset($_SESSION['login'])) {
  $colname_urgente = $_SESSION['login'];
}
$colname1_urgente = "Pendiente.";
if (isset($_GET['sub_estado'])) {
  $colname1_urgente = $_GET['sub_estado'];
}
$colname2_urgente = "K";
if (isset($_GET['nro_operacion'])) {
  $colname2_urgente = $_GET['nro_operacion'];
}
$colname3_urgente = "SI";
if (isset($_GET['urgente'])) {
  $colname3_urgente = $_GET['urgente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_urgente = sprintf("SELECT opcci.*,(usuarios.nombre)as ne FROM opcci, usuarios WHERE operador = %s and sub_estado = %s and nro_operacion LIKE %s and urgente = %s  and (opcci.especialista_curse = usuarios.usuario) ORDER BY date_asig ASC", GetSQLValueString($colname_urgente, "text"),GetSQLValueString($colname1_urgente, "text"),GetSQLValueString("%" . $colname2_urgente . "%", "text"),GetSQLValueString($colname3_urgente, "text"));
$urgente = mysqli_query($comercioexterior, $query_urgente) or die(mysqli_error($comercioexterior));
$row_urgente = mysqli_fetch_assoc($urgente);
$totalRows_urgente = mysqli_num_rows($urgente);
$colname_fuerahorario = "-1";
if (isset($_SESSION['login'])) {
  $colname_fuerahorario = $_SESSION['login'];
}
$colname1_fuerahorario = "Pendiente.";
if (isset($_GET['sub_estado'])) {
  $colname1_fuerahorario = $_GET['sub_estado'];
}
$colname2_fuerahorario = "K";
if (isset($_GET['nro_operacion'])) {
  $colname2_fuerahorario = $_GET['nro_operacion'];
}
$colname3_fuerahorario = "Si";
if (isset($_GET['urgente'])) {
  $colname3_fuerahorario = $_GET['urgente'];
}
$colname4_fuerahorario = "Si";
if (isset($_GET['fuera_horario'])) {
  $colname4_fuerahorario = $_GET['fuera_horario'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_fuerahorario = sprintf("SELECT opcci.*,(usuarios.nombre)as ne FROM opcci, usuarios WHERE operador = %s and sub_estado = %s and nro_operacion LIKE %s and urgente <> %s and fuera_horario = %s and (opcci.especialista_curse = usuarios.usuario) ORDER BY date_asig ASC", GetSQLValueString($colname_fuerahorario, "text"),GetSQLValueString($colname1_fuerahorario, "text"),GetSQLValueString("%" . $colname2_fuerahorario . "%", "text"),GetSQLValueString($colname3_fuerahorario, "text"),GetSQLValueString($colname4_fuerahorario, "text"));
$fuerahorario = mysqli_query($comercioexterior, $query_fuerahorario) or die(mysqli_error($comercioexterior));
$row_fuerahorario = mysqli_fetch_assoc($fuerahorario);
$totalRows_fuerahorario = mysqli_num_rows($fuerahorario);
$queryString_operador = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_operador") == false && 
        stristr($param, "totalRows_operador") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_operador = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_operador = sprintf("&totalRows_operador=%d%s", $totalRows_operador, $queryString_operador);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Alta Operaciones Operador - Maestro</title>
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
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo8 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo11 {color: #00FF00}
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
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
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
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">ALTA OPERACIONES OPERADOR - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTAS DE CR&Eacute;DITO DE IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo5">Alta Operaciones</span></td>
    </tr>
    <tr valign="middle">
      <td width="22%" align="right" valign="middle">Nro Operaci&oacute;n:</div></td>
      <td width="78%" align="left" valign="middle">        <input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7"> 
      <span class="rojopequeno">K000000</span></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="submit" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../carcreimp.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen7','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen7" width="80" height="25" border="0"></a>
      </div></td>
  </tr>
</table>
</div>
<br>
<?php if ($totalRows_urgente > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="10" align="left" valign="middle" bgcolor="#FF0000"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"><span class="NegrillaCartaReparo">Total de Operaciones Asignadas<?php echo $totalRows_urgente ?> Curse Urgente</span></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Cursar</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n /  Nro Relacionado</td>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Documentos</td>
      <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
      <td align="center" valign="middle" class="titulocolumnas">Urgente</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><a href="altaopdet.php?recordID=<?php echo $row_urgente['id']; ?>"><img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" align="absmiddle"></a></td>
        <td align="center" valign="middle"><?php echo $row_urgente['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_urgente['fecha_ingreso']; ?></td>
        <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_urgente['nro_operacion']); ?></span> / <span class="respuestacolumna_azul"><?php echo strtoupper($row_urgente['nro_operacion_relacionada']); ?></span></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_urgente['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_urgente['nombre_cliente']); ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_urgente['moneda_operacion']; ?> </span><span class="respuestacolumna_azul"><?php echo number_format($row_urgente['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_urgente['moneda_documentos']; ?> </span><span class="respuestacolumna_azul"><?php echo number_format($row_urgente['monto_documentos'], 2, ',', '.'); ?></span></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_urgente['ne']); ?></td>
        <td align="center" valign="middle"><?php if ($row_urgente['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
          <span class="Rojo2"><?php echo $row_urgente['urgente']; ?></span></span>
          <?php } // Show if not first page ?>
          <?php if ($row_urgente['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
          <span class="Verde2"><?php echo $row_urgente['urgente']; ?></span></span>
          <?php } // Show if not first page ?></td>
      </tr>
      <?php } while ($row_urgente = mysqli_fetch_assoc($urgente)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br>
  <?php if ($totalRows_operador > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="10" align="left" bgcolor="#00CC00"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="NegrillaCartaReparo">Total de Operaciones Pendientes <?php echo $totalRows_operador ?> Curse Normal</span></td>
    </tr>
    <tr valign="middle" bgcolor="#999999">
      <td align="center" class="titulocolumnas">Cursar</div></td>
      <td align="center" class="titulocolumnas">Evento</td>
      <td align="center" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" class="titulocolumnas">Nro Operaci&oacute;n</div>
      / Nro Relacionado</td>
      <td align="center" class="titulocolumnas">Rut Cliente</td>
      <td align="center" class="titulocolumnas">Nombre Cliente 
        </div>
      </td>
      <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
      <td align="center" class="titulocolumnas">Moneda / Monto Documentos</td>
      <td align="center" class="titulocolumnas">Especialista Curse</td>
      <td align="center" class="titulocolumnas">Urgente</td>
    </tr>
    <?php do { ?>
    <tr valign="middle">
      <td align="center"><a href="altaopdet.php?recordID=<?php echo $row_operador['id']; ?>"> <img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></div></td>
      <td align="center"><?php echo $row_operador['evento']; ?></div></td>
      <td align="center"><?php echo $row_operador['fecha_ingreso']; ?></div></td>
      <td align="center"> <span class="respuestacolumna_rojo"><?php echo strtoupper($row_operador['nro_operacion']); ?></span>        /<span class="respuestacolumna_azul"><?php echo strtoupper($row_operador['nro_operacion_relacionada']); ?></span>
        </div></td>
      <td align="center"><?php echo strtoupper($row_operador['rut_cliente']); ?></td>
      <td align="left"><?php echo strtoupper($row_operador['nombre_cliente']); ?> </div></td>
      <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_operador['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_operador['monto_operacion'], 2, ',', '.'); ?></strong> </div></td>
      <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_operador['moneda_documentos']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_operador['monto_documentos'], 2, ',', '.'); ?></strong> </div></td>
      <td align="left"><?php echo strtoupper($row_operador['ne']); ?></td>
<td align="center"><?php if ($row_operador['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_operador['urgente']; ?> </span></span>        
		<?php } // Show if not first page ?>
		<?php if ($row_operador['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_operador['urgente']; ?> </span></span>
      <?php } // Show if not first page ?></td>
    </tr>
    <?php } while ($row_operador = mysqli_fetch_assoc($operador)); ?>
  </table>
<?php } // Show if recordset not empty ?>
  <br>
  <?php if ($totalRows_fuerahorario > 0) { // Show if recordset not empty ?>
    <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
      <tr>
        <td colspan="10" align="left" valign="middle" bgcolor="#FFFF00"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"><span class="NegrillaCartaReparo">Total de Operaciones Pendientes <?php echo $totalRows_fuerahorario ?> Curse Fuera Horario</span></td>
      </tr>
      <tr>
        <td align="center" valign="middle" class="titulocolumnas">Cursar</td>
        <td align="center" valign="middle" class="titulocolumnas">Evento</td>
        <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
        <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n / Nro Relacionado</td>
        <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
        <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
        <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
        <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Documentos</td>
        <td align="center" valign="middle" class="titulocolumnas">Especialista Curse</td>
        <td align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
      </tr>
      <?php do { ?>
        <tr>
          <td align="center" valign="middle"><a href="altaopdet.php?recordID=<?php echo $row_fuerahorario['id']; ?>"><img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" align="absmiddle"></a></td>
          <td align="center" valign="middle"><?php echo $row_fuerahorario['evento']; ?></td>
          <td align="center" valign="middle"><?php echo $row_fuerahorario['fecha_ingreso']; ?></td>
          <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_fuerahorario['nro_operacion']); ?></span> / <span class="respuestacolumna_azul"><?php echo strtoupper($row_fuerahorario['nro_operacion_relacionada']); ?></span></td>
          <td align="center" valign="middle"><?php echo strtoupper($row_fuerahorario['rut_cliente']); ?></td>
          <td align="left" valign="middle"><?php echo strtoupper($row_fuerahorario['nombre_cliente']); ?></td>
          <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_fuerahorario['moneda_operacion']; ?> </span><span class="respuestacolumna_azul"><?php echo number_format($row_fuerahorario['monto_operacion'], 2, ',', '.'); ?></span></td>
          <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_fuerahorario['moneda_documentos']; ?> </span><span class="respuestacolumna_azul"><?php echo number_format($row_fuerahorario['monto_documentos'], 2, ',', '.'); ?></span></td>
          <td align="left" valign="middle"><?php echo strtoupper($row_fuerahorario['ne']); ?></td>
          <td align="center" valign="middle"><?php echo $row_fuerahorario['fuera_horario']; ?></td>
        </tr>
        <?php } while ($row_fuerahorario = mysqli_fetch_assoc($fuerahorario)); ?>
    </table>
    <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($colores);
mysqli_free_result($urgente);
mysqli_free_result($fuerahorario);
mysqli_free_result($operador);
?>