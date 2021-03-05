<?php require_once('../../../Connections/comercioexterior.php'); ?>
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
$colname4_DetailRS1 = "Cursada.";
if (isset($_GET['estado'])) {
  $colname4_DetailRS1 = $_GET['estado'];
}
$colname3_DetailRS1 = "0";
if (isset($_GET['asignador'])) {
  $colname3_DetailRS1 = $_GET['asignador'];
}
$colname1_DetailRS1 = "1";
if (isset($_GET['id'])) {
  $colname1_DetailRS1 = $_GET['id'];
}
$colname2_DetailRS1 = "1";
if (isset($_GET['nro_operacion'])) {
  $colname2_DetailRS1 = $_GET['nro_operacion'];
}
$colname_DetailRS1 = "Cursada.";
if (isset($_GET['estado_visacion'])) {
  $colname_DetailRS1 = $_GET['estado_visacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opmec WHERE estado_visacion = %s and id LIKE %s and nro_operacion LIKE %s and asignador = %s and estado = %s ORDER BY urgente,monto_operacion DESC", GetSQLValueString($colname_DetailRS1, "text"),GetSQLValueString("%" . $colname1_DetailRS1 . "%", "int"),GetSQLValueString("%" . $colname2_DetailRS1 . "%", "text"),GetSQLValueString($colname3_DetailRS1, "text"),GetSQLValueString($colname4_DetailRS1, "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$colname3_DetailRS1 = "0";
if (isset($_GET['asignador'])) {
  $colname3_DetailRS1 = $_GET['asignador'];
}
$colname6_DetailRS1 = "1";
if (isset($_GET['rut_cliente'])) {
  $colname6_DetailRS1 = $_GET['rut_cliente'];
}
$colname5_DetailRS1 = "Carta Original.";
if (isset($_GET['evento'])) {
  $colname5_DetailRS1 = $_GET['evento'];
}
$colname1_DetailRS1 = "1";
if (isset($_GET['id'])) {
  $colname1_DetailRS1 = $_GET['id'];
}
$colname_DetailRS1 = "Cursada.";
if (isset($_GET['estado_visacion'])) {
  $colname_DetailRS1 = $_GET['estado_visacion'];
}
$colname4_DetailRS1 = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname4_DetailRS1 = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opmec WHERE estado_visacion = %s and id LIKE %s and asignador = %s and estado = %s and evento <> %s and rut_cliente LIKE %s ORDER BY urgente,monto_operacion DESC", GetSQLValueString($colname_DetailRS1, "text"),GetSQLValueString("%" . $colname1_DetailRS1 . "%", "text"),GetSQLValueString($colname3_DetailRS1, "text"),GetSQLValueString($colname4_DetailRS1, "text"),GetSQLValueString($colname5_DetailRS1, "text"),GetSQLValueString("%" . $colname6_DetailRS1 . "%", "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opasignadas = "SELECT evento,operador,count(operador)as cantidad,sum(nro_cuotas)as pendientes, (usuarios.nombre)as nombre FROM oppre LEFT JOIN usuarios ON oppre.operador=usuarios.usuario WHERE sub_estado = 'Pendiente.' GROUP BY evento, operador ORDER BY evento, operador ASC";
$opasignadas = mysqli_query($comercioexterior, $query_opasignadas) or die(mysqli_error($comercioexterior));
$row_opasignadas = mysqli_fetch_assoc($opasignadas);
$totalRows_opasignadas = mysqli_num_rows($opasignadas);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso Asignaci&oacute;n - Maestro</title>
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
.Estilo10 {color: #FFFFFF; font-weight: bold; }
.Estilo11 {font-size: 12px}
.Estilo12 {color: #00FF00}
.Estilo13 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo15 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
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
<!--
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
//-->
</script> 
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo121 {color: #FFFFFF; font-weight: bold; }
-->
</style>
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO ASIGNACION - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">MERCADO DE CORREDORES</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><span class="Estilo10"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></span><span class="Estilo15">Buscar Operaciones</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right" valign="middle">Nro Folio:</div></td>
      <td width="79%" align="left" valign="middle"><label>
          <input name="id" type="text" class="etiqueta12" id="id" size="12" maxlength="10">
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="left" valign="middle"><label>
        <input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15">
      <span class="respuestacolumna_rojo">Sin puntos ni Guion</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limp&igrave;ar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../visacion/principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">Operaciones Asignadas</div>
      <div class="CollapsiblePanelContent">
        <br>
        <table width="85%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td colspan="4" align="left" valign="middle" bgcolor="#999999"><span class="Estilo121"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"></span><span class="mayuscula"><span class="titulodetalle">Operaciones Asignadas</span></span></td>
            </tr>
          <tr>
            <td valign="middle" bgcolor="#999999" class="titulocolumnas">Operador</td>
            <td valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
            <td valign="middle" bgcolor="#999999" class="titulocolumnas">Cantidad de Operaciones Pendientes</td>
            <td valign="middle" bgcolor="#999999" class="titulocolumnas">Numero de Cuotas Pendientes</td>
            </tr>
          <?php do { ?>
            <tr>
              <td align="left" valign="middle" bgcolor="#CCCCCC"><?php echo $row_opasignadas['nombre']; ?></td>
              <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_opasignadas['evento']; ?></td>
              <td valign="middle" bgcolor="#CCCCCC" class="respuestacolumna_rojo"><?php echo $row_opasignadas['cantidad']; ?></td>
              <td valign="middle" bgcolor="#CCCCCC" class="respuestacolumna_rojo"><?php echo $row_opasignadas['pendientes']; ?></td>
              </tr>
            <?php } while ($row_opasignadas = mysqli_fetch_assoc($opasignadas)); ?>
        </table>
        <br>
      </div>
    </div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_DetailRS1 > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="10" align="left"><span class="Estilo10"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo11">Total Operaciones para Asignaci&oacute;n <span class="Estilo12"><?php echo $totalRows_DetailRS1 ?></span></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Asignar</div></td>
    <td align="center" class="titulocolumnas">Nro Folio</td>
    <td align="center" class="titulocolumnas">Fecha Visaci&oacute;n </div>
    </td>
    <td align="center" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>
    </td>
    <td align="center" class="titulocolumnas">Estado
      </div>    </td>
    <td align="center" class="titulocolumnas">Urgente
      </div>
    </td>
    </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="ingdet.php?recordID=<?php echo $row_DetailRS1['id']; ?>"> <img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></div></td>
    <td align="center" class="respuestacolumna_rojo"><?php echo $row_DetailRS1['id']; ?></td>
    <td align="center"><?php echo $row_DetailRS1['date_visa']; ?></div></td>
    <td align="center"><?php echo $row_DetailRS1['rut_cliente']; ?></div></td>
    <td align="left"><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></td>
    <td align="center"><?php echo $row_DetailRS1['evento']; ?></div></td>
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_DetailRS1['nro_operacion']); ?></span>      </div></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_DetailRS1['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></strong> </div></td>
    <td align="right"><?php echo $row_DetailRS1['estado']; ?></div></td>
    <td align="center"><?php if ($row_DetailRS1['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
      <span class="Rojo2"><?php echo $row_DetailRS1['urgente']; ?> </span></span>        
      <?php } // Show if not first page ?>
      <?php if ($row_DetailRS1['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
      <span class="Verde2"><?php echo $row_DetailRS1['urgente']; ?> </span></span>
      <?php } // Show if not first page ?>
      </div></td>
    </tr>
  <?php } while ($row_DetailRS1 = mysqli_fetch_assoc($DetailRS1)); ?>
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
mysqli_free_result($DetailRS1);
mysqli_free_result($colores);
mysqli_free_result($opasignadas);
?>