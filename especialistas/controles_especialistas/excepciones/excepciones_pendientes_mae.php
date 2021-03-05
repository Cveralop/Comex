<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,ESP,BMG,TER";
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
$MM_restrictGoTo = "../../bmg/erroracceso.php";
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
$colname_excepciones_pendientes = "Cursada.";
if (isset($_GET['estado'])) {
  $colname_excepciones_pendientes = $_GET['estado'];
}
$colname1_excepciones_pendientes = "Pendiente.";
if (isset($_GET['estado_excepcion'])) {
  $colname1_excepciones_pendientes = $_GET['estado_excepcion'];
}
$colname2_excepciones_pendientes = "Si";
if (isset($_GET['excepcion'])) {
  $colname2_excepciones_pendientes = $_GET['excepcion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_excepciones_pendientes = sprintf("SELECT * FROM excepciones WHERE estado = %s and estado_excepcion = %s and excepcion  = %s ORDER BY vcto_excepcion ASC", GetSQLValueString($colname_excepciones_pendientes, "text"),GetSQLValueString($colname1_excepciones_pendientes, "text"),GetSQLValueString($colname2_excepciones_pendientes, "text"));
$excepciones_pendientes = mysqli_query($comercioexterior, $query_excepciones_pendientes) or die(mysqli_error($comercioexterior));
$row_excepciones_pendientes = mysqli_fetch_assoc($excepciones_pendientes);
$totalRows_excepciones_pendientes = mysqli_num_rows($excepciones_pendientes);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Excepciones Pendientes de Solcuion - Maestro</title>
<style type="text/css">
<!--
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
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
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
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
</script>
</head>
<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3"> EXCEPCIONES PENDIENTES DE SOLUCION - MAESTRO</td>
    <td width="7%" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="excepciones.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="14" align="left" bgcolor="#999999" class="titulodetalle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" />Existen <span class="tituloverde"><?php echo $totalRows_excepciones_pendientes ?></span> Excepciones Pendientes</td>
  </tr>
  <tr>
    <td align="center" class="titulocolumnas">Rut Cliente</td>
    <td align="center" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" class="titulocolumnas">Ejecutivo Cuenta</td>
    <td align="center" class="titulocolumnas">Ejecutivo NI</td>
    <td align="center" class="titulocolumnas">Especialista NI</td>
    <td align="center" class="titulocolumnas">Especialista Curse</td>
    <td align="center" class="titulocolumnas">Fecha Ingreso</td>
    <td align="center" class="titulocolumnas">Eveto</td>
    <td align="center" class="titulocolumnas">Producto</td>
    <td align="center" class="titulocolumnas">No. Operación</td>
    <td align="center" class="titulocolumnas">No. Operación Relacionada</td>
    <td align="center" class="titulocolumnas">Observaciones</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operación</td>
    <td align="center" class="titulocolumnas">Vcto Excepciones</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_excepciones_pendientes['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_excepciones_pendientes['nombre_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_excepciones_pendientes['ejecutivo_cuenta']; ?></td>
      <td align="left" valign="middle"><?php echo $row_excepciones_pendientes['ejecutivo_ni']; ?></td>
      <td align="left" valign="middle"><?php echo $row_excepciones_pendientes['especialista_ni']; ?></td>
      <td align="left" valign="middle"><?php echo $row_excepciones_pendientes['especialista_curse']; ?></td>
      <td align="center" valign="middle"><?php echo $row_excepciones_pendientes['fecha_ingreso']; ?></td>
      <td align="left" valign="middle"><?php echo $row_excepciones_pendientes['evento']; ?></td>
      <td align="left" valign="middle"><?php echo $row_excepciones_pendientes['producto']; ?></td>
      <td align="center" valign="middle"><?php echo $row_excepciones_pendientes['nro_operacion']; ?></td>
      <td align="center" valign="middle"><?php echo $row_excepciones_pendientes['nro_operacion_relacionada']; ?></td>
      <td align="left" valign="middle"><?php echo $row_excepciones_pendientes['obs']; ?></td>
      <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_excepciones_pendientes['moneda_operacion']; ?> </span><span class="respuestacolumna_azul"><?php echo number_format($row_excepciones_pendientes['monto_operacion'], 2, ',', '.'); ?></span></td>
      <td align="center" valign="middle"><?php echo $row_excepciones_pendientes['vcto_excepcion']; ?></td>
    </tr>
    <?php } while ($row_excepciones_pendientes = mysqli_fetch_assoc($excepciones_pendientes)); ?>
</table>
</body>
</html>
<?php
mysqli_free_result($excepciones_pendientes);
?>