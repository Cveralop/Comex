<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,CUS";
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

$colname_custodia = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname_custodia = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_custodia = sprintf("SELECT * FROM custodia WHERE nro_operacion = %s ORDER BY fecha_otorgamiento DESC", GetSQLValueString($colname_custodia, "text"));
$custodia = mysql_query($query_custodia, $comercioexterior) or die(mysqli_error());
$row_custodia = mysqli_fetch_assoc($custodia);
$totalRows_custodia = mysqli_num_rows($custodia);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consulta Custodia - Detalle</title>
<style type="text/css">
<!--
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
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
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
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
</head>

<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" valign="middle" class="Estilo3">CONSULTA CUSTODIA (DOCUMENTOS VALORADOS) - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" valign="middle" class="Estilo4">COMERCIO EXTERIOR</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" />Consulta por Nro Operación</td>
    </tr>
    <tr>
      <td width="22%" align="right" valign="middle">Nro Operacion:</td>
      <td width="78%" align="left" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><input name="button" type="submit" class="boton" id="button" value="Buscar Documento" /></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../principal.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_custodia > 0) { // Show if recordset not empty ?>
  <span class="respuestacolumna_rojo"><?php echo number_format(($totalRows_custodia), 0, ',', '.'); ?></span> Registro(s) en Total <br />
  <br />
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td valign="middle" class="titulocolumnas">Nro Operacion</td>
      <td valign="middle" class="titulocolumnas">Nro Operacion Relacionada</td>
      <td valign="middle" class="titulocolumnas">Nombre Producto</td>
      <td valign="middle" class="titulocolumnas">Fecha Otorgamiento</td>
      <td valign="middle" class="titulocolumnas">Moneda</td>
      <td valign="middle" class="titulocolumnas">Monto</td>
      <td valign="middle" class="titulocolumnas">Tipo Custodia</td>
      <td valign="middle" class="titulocolumnas">Tipo Garantia</td>
      <td valign="middle" class="titulocolumnas">Cod Suc</td>
      <td valign="middle" class="titulocolumnas">Nombre Oficina</td>
      <td valign="middle" class="titulocolumnas">Ejecutivo Cuenta</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_custodia['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_custodia['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_custodia['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_custodia['nro_operacion_relacionada']; ?></td>
        <td align="left" valign="middle"><?php echo $row_custodia['nombre_producto']; ?></td>
        <td align="center" valign="middle"><?php echo $row_custodia['fecha_otorgamiento']; ?></td>
        <td align="center" valign="middle"><?php echo $row_custodia['moneda']; ?></td>
        <td align="right" valign="middle"><?php echo number_format($row_custodia['monto'], 2, ',', '.'); ?></td>
        <td align="left" valign="middle"><?php echo $row_custodia['tipo_custodia']; ?></td>
        <td align="left" valign="middle"><?php echo $row_custodia['tipo_garantia']; ?></td>
        <td align="center" valign="middle"><?php echo $row_custodia['cod_suc']; ?></td>
        <td align="left" valign="middle"><?php echo $row_custodia['nombre_oficina']; ?></td>
        <td align="left" valign="middle"><?php echo $row_custodia['ejecutivo_cuenta']; ?></td>
      </tr>
      <?php } while ($row_custodia = mysqli_fetch_assoc($custodia)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($custodia);
?>