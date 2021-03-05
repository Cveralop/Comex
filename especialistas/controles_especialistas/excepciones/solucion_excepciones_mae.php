<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ESP,BMG,TER,ADM";
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
$colname_excepciones = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_excepciones = $_GET['rut_cliente'];
}
$colname1_excepciones = "Pendiente.";
if (isset($_GET['estado_excepcion'])) {
  $colname1_excepciones = $_GET['estado_excepcion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_excepciones = sprintf("SELECT * FROM excepciones WHERE rut_cliente = %s and estado_excepcion = %s", GetSQLValueString($colname_excepciones, "text"),GetSQLValueString($colname1_excepciones, "text"));
$excepciones = mysqli_query($comercioexterior, $query_excepciones) or die(mysqli_error($comercioexterior));
$row_excepciones = mysqli_fetch_assoc($excepciones);
$totalRows_excepciones = mysqli_num_rows($excepciones);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso Soluci&oacute;n Excepci&oacute;n - Maestro</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
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
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo10 {font-size: 12px}
.Estilo11 {color: #00FF00}
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
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="96%" align="left" valign="middle" class="Estilo3">INGRESO SOLUCION DE EXCEPCION - MAESTRO</td>
    <td width="4%" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right"></td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Ingreso Solucion de Excepcion</td>
    </tr>
    <tr>
      <td width="18%" align="right" valign="middle">Rut Cliente:</td>
      <td width="82%" align="left" valign="middle"><label>
        <input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15">
        <span class="rojopequeno">Sin Punto ni Guion</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar">
      </label></td>
    </tr>
  </table>
</form>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="excepciones.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen4','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen4" width="80" height="25" border="0"></a>
    </div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_excepciones > 0) { // Show if recordset not empty ?>
  <span class="respuestacolumna_azul"><?php echo $totalRows_excepciones ?></span> Registros Total <br>
  <br>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Solucion Excepci&oacute;n</td>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
      <td align="center" valign="middle" class="titulocolumnas">Producto</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operacion</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
      <td align="center" valign="middle" class="titulocolumnas">Excepcion</td>
      <td align="center" valign="middle" class="titulocolumnas">Autorizacion Operaciones</td>
      <td align="center" valign="middle" class="titulocolumnas">Autorizacion Especialista</td>
      <td align="center" valign="middle" class="titulocolumnas">Responsable Excepcion</td>
      <td align="center" valign="middle" class="titulocolumnas">Tipo Excepcion</td>
      <td align="center" valign="middle" class="titulocolumnas">Vcto Excepcion</td>
      <td align="center" valign="middle" class="titulocolumnas">En Plazo / Fuera Plazo</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><a href="solucion_excepciones_det.php?recordID=<?php echo $row_excepciones['id']; ?>"><img src="../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_excepciones['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_excepciones['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_excepciones['fecha_ingreso']; ?></td>
        <td align="left" valign="middle"><?php echo $row_excepciones['evento']; ?></td>
        <td align="left" valign="middle"><?php echo $row_excepciones['producto']; ?></td>
        <td align="center" valign="middle"><?php echo $row_excepciones['nro_operacion']; ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_excepciones['moneda_operacion']; ?></span>&nbsp; <span class="respuestacolumna_azul"><?php echo number_format($row_excepciones['monto_operacion'], 2, ',', '.'); ?></span></td>
        <td align="left" valign="middle"><?php echo $row_excepciones['excepcion']; ?></td>
        <td align="left" valign="middle"><?php echo $row_excepciones['autorizacion_operaciones']; ?></td>
        <td align="left" valign="middle"><?php echo $row_excepciones['autorizacion_especialista']; ?></td>
        <td align="left" valign="middle"><?php echo $row_excepciones['responsable_excepcion']; ?></td>
        <td align="left" valign="middle"><?php echo $row_excepciones['tipo_excepcion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_excepciones['vcto_excepcion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_excepciones['enplazo_fueraplazo']; ?></td>
      </tr>
      <?php } while ($row_excepciones = mysqli_fetch_assoc($excepciones)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($excepciones);
?>