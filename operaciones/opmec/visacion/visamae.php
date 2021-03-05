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
$colname4_DetailRS1 = "0";
if (isset($_GET['asignador'])) {
  $colname4_DetailRS1 = $_GET['asignador'];
}
$colname2_DetailRS1 = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname2_DetailRS1 = $_GET['estado'];
}
$colname1_DetailRS1 = "zzzxxx";
if (isset($_GET['rut_cliente'])) {
  $colname1_DetailRS1 = $_GET['rut_cliente'];
}
$colname5_DetailRS1 = "-1";
if (isset($_GET['id'])) {
  $colname5_DetailRS1 = $_GET['id'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opmec WHERE rut_cliente LIKE %s and asignador = %s and id LIKE %s and estado = %s and (estado_visacion = 'Pendiente.' or estado_visacion = 'Cursada.') ORDER BY urgente DESC", GetSQLValueString("%" . $colname1_DetailRS1 . "%", "text"),GetSQLValueString($colname4_DetailRS1, "text"),GetSQLValueString("%" . $colname5_DetailRS1 . "%", "text"),GetSQLValueString($colname2_DetailRS1, "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$colname2_DetailRS1 = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname2_DetailRS1 = $_GET['estado'];
}
$colname1_DetailRS1 = "zzzxxx";
if (isset($_GET['rut_cliente'])) {
  $colname1_DetailRS1 = $_GET['rut_cliente'];
}
$colname5_DetailRS1 = "-1";
if (isset($_GET['id'])) {
  $colname5_DetailRS1 = $_GET['id'];
}
$colname4_DetailRS1 = "0";
if (isset($_GET['operador'])) {
  $colname4_DetailRS1 = $_GET['operador'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opmec WHERE rut_cliente LIKE %s and operador = %s and id LIKE %s and estado = %s and (estado_visacion = 'Pendiente.' or estado_visacion = 'Cursada.') ORDER BY id ASC", GetSQLValueString("%" . $colname1_DetailRS1 . "%", "text"),GetSQLValueString($colname4_DetailRS1, "text"),GetSQLValueString("%" . $colname5_DetailRS1 . "%", "text"),GetSQLValueString($colname2_DetailRS1, "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opasignadas = "SELECT evento,operador,sum(cantidad)as cantidad, (usuarios.nombre)as nombre FROM opmec LEFT JOIN usuarios ON opmec.operador=usuarios.usuario WHERE sub_estado = 'Pendiente.'  GROUP BY operador,evento ORDER BY operador ASC";
$opasignadas = mysqli_query($comercioexterior, $query_opasignadas) or die(mysqli_error($comercioexterior));
$row_opasignadas = mysqli_fetch_assoc($opasignadas);
$totalRows_opasignadas = mysqli_num_rows($opasignadas);
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
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">VISACI&Oacute;N</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">MERCADO DE CORREDORES</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><span class="Estilo12"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"></span><span class="Estilo15">Buscar Visaci&oacute;n</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Folio Nro:</div></td>
      <td align="left" valign="middle"><input name="id" type="text" class="etiqueta12" id="id" size="10" maxlength="10"></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Rut Cliente:</div></td>
      <td width="79%" align="left" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15">
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar"></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a></div></td>
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
            <td colspan="3" align="left" valign="middle" bgcolor="#999999"><span class="Estilo12"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"></span><span class="mayuscula"><span class="titulodetalle">Total de </span></span><span class="tituloverde"><?php echo $totalRows_opasignadas ?></span><span class="mayuscula"><span class="titulodetalle"> Operaciones Asignadas</span></span></td>
            </tr>
          <tr>
            <td valign="middle" bgcolor="#999999" class="titulodetalle"><span class="titulocolumnas">Operador</span></td>
            <td valign="middle" bgcolor="#999999" class="titulocolumnas">Evento</td>
            <td valign="middle" bgcolor="#999999" class="titulocolumnas">Cantidad Operaciones Asignadas</td>
            </tr>
          <?php do { ?>
            <tr>
              <td valign="middle"><?php echo $row_opasignadas['nombre']; ?></td>
              <td valign="middle"><?php echo $row_opasignadas['evento']; ?></td>
              <td valign="middle"><?php echo $row_opasignadas['cantidad']; ?></td>
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
  <tr bgcolor="#999999">
    <td colspan="11" align="left" valign="middle"><span class="Estilo12"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"> <span class="Estilo13">Hay <span class="Estilo16"><?php echo $totalRows_DetailRS1 ?></span> Operaciones para Visaci&oacute;n</span></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="Estilo12"><span class="titulocolumnas">Visar</span></td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
    <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">OK Curse</td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente</td>
    <td align="center" valign="middle" class="titulocolumnas">Impedido Operar</td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><a href="visadet.php?recordID=<?php echo $row_DetailRS1['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></td>
    <td align="center" valign="middle" class="rojopequeno"><?php echo $row_DetailRS1['id']; ?></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?></div></td>
<td align="left" valign="middle"><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['date_espe']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['evento']; ?></div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['especialista_curse']); ?></div></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_DetailRS1['moneda_operacion']); ?></span>&nbsp; <strong class="respuestacolumna_azul"><?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td align="center" valign="middle"><?php if ($row_DetailRS1['ok_curse'] <> 'No' and $row_DetailRS1['ok_curse'] <> 'N/A') { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_DetailRS1['ok_curse']; ?> </span></span>        
		<?php } // Show if not first page ?>
		<?php if ($row_DetailRS1['ok_curse'] <> 'Si' and $row_DetailRS1['ok_curse'] <> 'N/A') { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_DetailRS1['ok_curse']; ?> </span></span>
    <?php } // Show if not first page ?>
    <?php if ($row_DetailRS1['ok_curse'] <> 'Si' and $row_DetailRS1['ok_curse'] <> 'No') { // Show if not first page ?>
        <span class="Gris2"><?php echo $row_DetailRS1['ok_curse']; ?> </span></span>
    <?php } // Show if not first page ?></td>
    <td align="center" valign="middle"><?php if ($row_DetailRS1['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_DetailRS1['urgente']; ?> </span></span>        
		<?php } // Show if not first page ?>
		<?php if ($row_DetailRS1['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_DetailRS1['urgente']; ?> </span></span>
	    <?php } // Show if not first page ?>      </td>
    <td align="center" valign="middle" class="destadado"><?php echo strtoupper($row_DetailRS1['impedido_operar']); ?></td>
  </tr>
  <?php } while ($row_DetailRS1 = mysqli_fetch_assoc($DetailRS1)); ?>
</table>
<?php } // Show if recordset not empty ?>
<script type="text/javascript">

var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});

</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
mysqli_free_result($colores);
mysqli_free_result($opasignadas);
?>