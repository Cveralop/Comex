<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
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
$colname3_alta = "K";
if (isset($_GET['nro_operacion'])) {
  $colname3_alta = $_GET['nro_operacion'];
}
$colname4_alta = "No";
if (isset($_GET['urgente'])) {
  $colname4_alta = $_GET['urgente'];
}
$colname5_alta = "No";
if (isset($_GET['fuera_horario'])) {
  $colname5_alta = $_GET['fuera_horario'];
}
$colname2_alta = "Pendiente.";
if (isset($_GET['sub_estado'])) {
  $colname2_alta = $_GET['sub_estado'];
}
$colname_alta = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname_alta = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_alta = sprintf("SELECT opcci.*,(usuarios.nombre)as op FROM opcci, usuarios WHERE estado = %s and sub_estado <> %s and nro_operacion LIKE %s and urgente = %s and fuera_horario = %s and (opcci.operador = usuarios.usuario) ORDER BY date_asig ASC", GetSQLValueString($colname_alta, "text"),GetSQLValueString($colname2_alta, "text"),GetSQLValueString("%" . $colname3_alta . "%", "text"),GetSQLValueString($colname4_alta, "text"),GetSQLValueString($colname5_alta, "text"));
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
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);
$colname_urgente = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname_urgente = $_GET['estado'];
}
$colname2_urgente = "Pendiente.";
if (isset($_GET['sub_estado'])) {
  $colname2_urgente = $_GET['sub_estado'];
}
$colname3_urgente = "K";
if (isset($_GET['nro_operacion'])) {
  $colname3_urgente = $_GET['nro_operacion'];
}
$colname4_urgente = "Si";
if (isset($_GET['urgente'])) {
  $colname4_urgente = $_GET['urgente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_urgente = sprintf("SELECT opcci.*,(usuarios.nombre)as op FROM opcci, usuarios WHERE estado = %s and sub_estado <> %s and nro_operacion LIKE %s and urgente = %s and (opcci.operador = usuarios.usuario) ORDER BY date_asig ASC", GetSQLValueString($colname_urgente, "text"),GetSQLValueString($colname2_urgente, "text"),GetSQLValueString("%" . $colname3_urgente . "%", "text"),GetSQLValueString($colname4_urgente, "text"));
$urgente = mysqli_query($comercioexterior, $query_urgente) or die(mysqli_error($comercioexterior));
$row_urgente = mysqli_fetch_assoc($urgente);
$totalRows_urgente = mysqli_num_rows($urgente);
$colname_fuera_horario = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname_fuera_horario = $_GET['estado'];
}
$colname2_fuera_horario = "Pendiente.";
if (isset($_GET['sub_estado'])) {
  $colname2_fuera_horario = $_GET['sub_estado'];
}
$colname3_fuera_horario = "K";
if (isset($_GET['nro_operacion'])) {
  $colname3_fuera_horario = $_GET['nro_operacion'];
}
$colname4_fuera_horario = "Si";
if (isset($_GET['urgente'])) {
  $colname4_fuera_horario = $_GET['urgente'];
}
$colname5_fuera_horario = "Si";
if (isset($_GET['fuera_horario'])) {
  $colname5_fuera_horario = $_GET['fuera_horario'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_fuera_horario = sprintf("SELECT opcci.*,(usuarios.nombre)as op FROM opcci, usuarios WHERE estado = %s and sub_estado <> %s and nro_operacion LIKE %s and urgente <> %s and fuera_horario = %s and (opcci.operador = usuarios.usuario) ORDER BY date_asig ASC", GetSQLValueString($colname_fuera_horario, "text"),GetSQLValueString($colname2_fuera_horario, "text"),GetSQLValueString("%" . $colname3_fuera_horario . "%", "text"),GetSQLValueString($colname4_fuera_horario, "text"),GetSQLValueString($colname5_fuera_horario, "text"));
$fuera_horario = mysql_query($query_fuera_horario, $comercioexterior) or die(mysqli_error());
$row_fuera_horario = mysqli_fetch_assoc($fuera_horario);
$totalRows_fuera_horario = mysqli_num_rows($fuera_horario);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opasignadas = "SELECT *,SUM(nro_cuotas_cursadas)as cursada FROM asignacion_operaciones WHERE producto = 'Carta de Credito Import' GROUP BY operador,evento ORDER BY evento ASC";
$opasignadas = mysqli_query($comercioexterior, $query_opasignadas) or die(mysqli_error($comercioexterior));
$row_opasignadas = mysqli_fetch_assoc($opasignadas);
$totalRows_opasignadas = mysqli_num_rows($opasignadas);
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
<title>Alta Operaciones Supervisor - Maestro</title>
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

</style>
<script src="../../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
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
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
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
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<link href="../../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo121 {color: #FFFFFF; font-weight: bold; }

</style>
</head>
<meta http-equiv="refresh" content="60" />
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">ALTA OPERACIONES SUPERVISOR - MAESTRO </td>
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
      <td colspan="2" align="left" valign="middle"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo5">Alta Operaciones Supervisor </span></td>
    </tr>
    <tr valign="middle">
      <td width="22%" align="right" valign="middle">Nro Operaci&oacute;n:</div></td>
      <td width="78%" align="left" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7">
      <span class="rojopequeno">K000000</span> </td>
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
    <td align="right" valign="middle"><a href="../../carcreimp.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a>
      </div></td>
  </tr>
</table>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">Operaciones Asignadas</div>
      <div class="CollapsiblePanelContent"><br>
        <table width="85%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td colspan="5" align="left" valign="middle" bgcolor="#999999"><span class="Estilo121"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"></span><span class="mayuscula"><span class="titulodetalle">Operaciones Asignadas para Curse</span></span></td>
            </tr>
          <tr>
            <td align="center" valign="middle" class="titulocolumnas">Evento</td>
            <td align="center" valign="middle" class="titulocolumnas">Operador</td>
            <td align="center" valign="middle" class="titulocolumnas">Operaciones Pendientes</td>
            <td align="center" valign="middle" class="titulocolumnas">Nro de Cuotas Pendientes</td>
            <td align="center" valign="middle" class="titulocolumnas">Nro Cuotas Cursadas</td>
            </tr>
          <?php do { ?>
            <tr>
              <td align="left" valign="middle"><?php echo $row_opasignadas['evento']; ?></td>
              <td align="left" valign="middle"><?php echo $row_opasignadas['operador']; ?></td>
              <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_opasignadas['cantidad_pendientes'], 0, ',', '.'); ?></td>
              <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_opasignadas['nro_cuotas_pendientes'], 0, ',', '.'); ?></td>
              <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_opasignadas['cursada'], 0, ',', '.'); ?></td>
              </tr>
            <?php } while ($row_opasignadas = mysqli_fetch_assoc($opasignadas)); ?>
        </table>
        <br>
        <br>
      </div>
    </div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_urgente > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="11" align="left" valign="middle" bgcolor="#FF0000"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="NegrillaCartaReparo">Total de Operaciones Cursadas por Operador <?php echo $totalRows_urgente ?> Curse Urgente</span></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Cursar</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n / Nro Relacionado</td>
      <td align="center" valign="middle" class="titulocolumnas">Alta Operador</td>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Documentos</td>
      <td align="center" valign="middle" class="titulocolumnas">Operador</td>
      <td align="center" valign="middle" class="titulocolumnas">Urgente</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><a href="altadet.php?recordID=<?php echo $row_urgente['id']; ?>"><img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" align="absmiddle"></a></td>
        <td align="center" valign="middle"><?php echo $row_urgente['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_urgente['date_oper']; ?></td>
        <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_urgente['nro_operacion']); ?></span>&nbsp; / <span class="respuestacolumna_azul"><?php echo strtoupper($row_urgente['nro_operacion_relacionada']); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_urgente['sub_estado']; ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_urgente['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_urgente['nombre_cliente']); ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_urgente['moneda_operacion']; ?> </span><span class="respuestacolumna_azul"><?php echo number_format($row_urgente['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_urgente['moneda_documentos']; ?> </span><span class="respuestacolumna_azul"><?php echo number_format($row_urgente['monto_documentos'], 2, ',', '.'); ?></span></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_urgente['op']); ?></td>
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
<?php if ($totalRows_alta > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="11" align="left" bgcolor="#00CC00"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="NegrillaCartaReparo">Total de Operaciones Cursadas por Operador <strong><?php echo $totalRows_alta ?> Curse Normal</strong></span></td>
    </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas"><strong>Cursar</strong>
      </div>
    </td>
    <td align="center" class="titulocolumnas">Evento</td>
    <td align="center" class="titulocolumnas">Fecha Ingreso</td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </div>
    / Nro Relacionado</td>
    <td align="center" class="titulocolumnas">Alta Operador</td>
    <td align="center" class="titulocolumnas">Rut Cliente</td>
    <td align="center" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operacion</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Documentos</td>
    <td align="center" class="titulocolumnas">Operador</td>
    <td align="center" class="titulocolumnas"><strong>Urgente</strong></td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="altadet.php?recordID=<?php echo $row_alta['id']; ?>"> <img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"> </a> </div></td>
    <td align="center"><?php echo $row_alta['evento']; ?> </td>
    <td align="center"><?php echo $row_alta['date_oper']; ?></td>
    <td align="center"> <span class="respuestacolumna_rojo"><?php echo strtoupper($row_alta['nro_operacion']); ?></span> /     <span class="respuestacolumna_azul"><?php echo strtoupper($row_alta['nro_operacion_relacionada']); ?></span>
      </div></td>
    <td align="center"><?php echo $row_alta['sub_estado']; ?></td>
    <td align="left"><?php echo strtoupper($row_alta['rut_cliente']); ?></td>
    <td align="left"><?php echo strtoupper($row_alta['nombre_cliente']); ?> </td>
    <td align="right"><strong class="respuestacolumna_azul"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_alta['moneda_operacion']); ?> </span><?php echo number_format($row_alta['monto_operacion'], 2, ',', '.'); ?></strong>      </div></td>
    <td align="right"><strong class="respuestacolumna_azul"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_alta['moneda_documentos']); ?> </span><?php echo number_format($row_alta['monto_documentos'], 2, ',', '.'); ?></strong></td>
    <td align="left"><?php echo strtoupper($row_alta['op']); ?></td>
<td align="center"><?php if ($row_alta['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_alta['urgente']; ?> </span></span>        
		<?php } // Show if not first page ?>
		<?php if ($row_alta['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_alta['urgente']; ?> </span></span>
    <?php } // Show if not first page ?> </td>
  </tr>
  <?php } while ($row_alta = mysqli_fetch_assoc($alta)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_fuera_horario > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="11" align="left" valign="middle" bgcolor="#FFFF00"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="NegrillaCartaReparo">Total de Operaciones Cursadas por Operador <?php echo $totalRows_fuera_horario ?> Curse Fuera Horario</span></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Cursar</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n / Nro Relacionado</td>
      <td align="center" valign="middle" class="titulocolumnas">Alta Operador</td>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Documentos</td>
      <td align="center" valign="middle" class="titulocolumnas">Operador</td>
      <td align="center" valign="middle" class="titulocolumnas">Fuera Horario</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><a href="altadet.php?recordID=<?php echo $row_fuera_horario['id']; ?>"><img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" align="absmiddle"></a></td>
        <td align="center" valign="middle"><?php echo $row_fuera_horario['evento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_fuera_horario['date_oper']; ?></td>
        <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_fuera_horario['nro_operacion']); ?></span> / <span class="respuestacolumna_azul"><?php echo strtoupper($row_fuera_horario['nro_operacion_relacionada']); ?></span></td>
        <td align="center" valign="middle"><?php echo $row_fuera_horario['sub_estado']; ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_fuera_horario['rut_cliente']); ?></td>
        <td align="left" valign="middle"><?php echo $row_fuera_horario['nombre_cliente']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_fuera_horario['moneda_operacion']; ?> </span> <span class="respuestacolumna_azul"><?php echo number_format($row_fuera_horario['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_fuera_horario['moneda_documentos']; ?> </span> <span class="respuestacolumna_azul"><?php echo number_format($row_fuera_horario['monto_documentos'], 2, ',', '.'); ?></span></td>
        <td align="left" valign="middle"><?php echo strtoupper($row_fuera_horario['op']); ?></td>
        <td align="center" valign="middle"><?php echo $row_fuera_horario['fuera_horario']; ?></td>
      </tr>
      <?php } while ($row_fuera_horario = mysqli_fetch_assoc($fuera_horario)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<script type="text/javascript">
<!--
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
//-->
  </script>
</body>
</html>
<?php
mysqli_free_result($alta);
mysqli_free_result($colores);
mysqli_free_result($urgente);
mysqli_free_result($fuera_horario);
mysqli_free_result($opasignadas);
?>